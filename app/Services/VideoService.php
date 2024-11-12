<?php

namespace App\Services;

use App\Models\ImageFile;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Traits\UploadFileTraits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoService
{
    use UploadFileTraits;

    const ITEMS_PER_PAGE = 20;

    public function get($id)
    {
        return Video::find($id);
    }

    public function list($params)
    {
        $q = Video::query();

        if (isset($params['video_category_id']) && $params['video_category_id'] != 0) {
            $q->where('video_category_id',$params['video_category_id']);
        }

        return $q->paginate(self::ITEMS_PER_PAGE);
    }

    public function delete($id)
    {
        Video::find($id)->delete();
    }

    public function getCategories() {
        return VideoCategory::get();
    }

    public function upload($file, $videoCategoryId = null) {
        $ext = '.' . $file->getClientOriginalExtension();
        $storage = 'public';
        $timestamp = date('YmdHis');
        $videoPath = 'movies/' . Auth::user()->site_id . '/' . $timestamp . $ext;
        $thumbnailPath = 'movies/' . Auth::user()->site_id . '/' . $timestamp . '_thumbnail.jpg';

        Storage::disk($storage)->put($videoPath, file_get_contents($file));

        FFMpeg::fromDisk($storage)
            ->open($videoPath)
            ->getFrameFromSeconds(1)
            ->export()
            ->toDisk($storage)
            ->save($thumbnailPath);

        Video::create([
            'video_category_id' => $videoCategoryId,
            'filename' => $videoPath,
            'thumbnail_filename' => $thumbnailPath,
        ]);

        return true;
    }

    public function updateVideo($videoId, $videoCategoryId)
    {
        return Video::find($videoId)->update(['video_category_id' => $videoCategoryId]);
    }

    public function bulkDeleteVideos(array $videoIds)
    {
        try {
            $result = DB::transaction(function () use ($videoIds) {
                $videos = Video::whereIn('id', $videoIds)->get();

                foreach ($videos as $video) {
                    $videoDeleted = $video->delete();

                    if (!$videoDeleted) {
                        throw new \Exception("Failed to delete category ID: " . $video->id);
                    }
                }

                return true;
            });

            Log::info("Bulk deletion process completed for image IDs: " . implode(', ', $videoIds) . ". Final result: Success");
            return $result;

        } catch (\Exception $e) {
            Log::error("Exception occurred during bulk deletion. Error: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
}
