<?php

namespace App\Services;

use App\Models\ImageFile;
use App\Models\ImageFileCategory;
use App\Traits\UploadFileTraits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class ImageFileService
{
    use UploadFileTraits;

    const ITEMS_PER_PAGE = 20;

    public const QUALITY_OPTIONS = [
        ['id' => '1', 'label' => '軽量（最大幅960px&高圧縮）'],
        ['id' => '2', 'label' => '標準（最大幅1,280px&標準圧縮）'],
        ['id' => '3', 'label' => '高画質（最大幅1,920px&低圧縮）'],
    ];

    public function get($id)
    {
        return ImageFile::find($id);
    }

    public function list($params)
    {
        $q = ImageFile::query();

        if (isset($params['image_file_category_id']) && $params['image_file_category_id'] != 0) {
            $q->where('image_file_category_id',$params['image_file_category_id']);
        }

        return $q->paginate(self::ITEMS_PER_PAGE);
    }

    public function delete($id)
    {
        ImageFile::find($id)->delete();
    }

    public function getCategories() {
        return ImageFileCategory::get();
    }

    public function upload($files, $imageFileCategoryId = null, $quality) {
        if(!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            $ext = '.' . $file->getClientOriginalExtension();
            $storage = 'public';

            $path = $this->uploadStorage($storage, 'images/' . Auth::user()->site_id, date('YmdHis') . $ext, $file);
            $thumbnailPath = $this->uploadStorage($storage, 'images/' . Auth::user()->site_id, date('YmdHis') . '_s' . $ext, $file);
            $thumbnailFullPath = Storage::disk($storage)->path($thumbnailPath);
            $manager = new ImageManager(new Driver());
            $thumbnail = $manager->read($thumbnailFullPath);
            $thumbnail = $thumbnail->scale(200,200)->save();

            ImageFile::create([
                'image_file_category_id' => $imageFileCategoryId,
                'filename' => $path,
                'thumbnail_filename' => $thumbnailPath,
                'quality' => $quality,
            ]);
        }

        return true;
    }

    public function updateImage($imageId, $imageFileCategoryId)
    {
        return ImageFile::find($imageId)->update(['image_file_category_id' => $imageFileCategoryId]);
    }

    public function bulkDeleteImages(array $imageIds)
    {
        try {
            $result = DB::transaction(function () use ($imageIds) {
                $images = ImageFile::whereIn('id', $imageIds)->get();

                foreach ($images as $image) {
                    $categoryDeleted = $image->delete();

                    if (!$categoryDeleted) {
                        throw new \Exception("Failed to delete category ID: " . $image->id);
                    }
                }

                return true;
            });

            Log::info("Bulk deletion process completed for image IDs: " . implode(', ', $imageIds) . ". Final result: Success");
            return $result;

        } catch (\Exception $e) {
            Log::error("Exception occurred during bulk deletion. Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
}
