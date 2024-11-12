<?php

namespace App\Services;

use App\Models\DocumentFile;
use App\Traits\UploadFileTraits;
use Illuminate\Support\Facades\DB;

class DocumentFileService extends EmbedPartsService
{
    use UploadFileTraits;

    public function list(int $perPage = null)
    {
        return DocumentFile::query()->paginate($perPage ?? self::DEFAULT_PER_PAGE);
    }

    public function store(string $filename, $file): void
    {
        $filepath = $this->upload($file);
        DocumentFile::query()->create([
            'filename' => $filename,
            'filepath' => $filepath,
        ]);
    }

    public function update(DocumentFile $documentFile, string $filename, $file = null): void
    {
        $dataUpdate = [
            'filename' => $filename,
        ];
        $oldFilepath = null;

        if ($file) {
            $path = $this->upload($file);
            $dataUpdate['filepath'] = $path;
            $oldFilepath = $documentFile->filepath;
        }

        $documentFile->update($dataUpdate);

        // delete old file after update success new file
        if ($oldFilepath) {
            $this->deleteFile($oldFilepath);
        }
    }

    public function delete(DocumentFile $documentFile): void
    {
        DB::transaction(function () use ($documentFile) {
            $filepath = $documentFile->filepath;
            $documentFile->delete();
            $this->deleteFile($filepath);
        });
    }

    public function bulkDelete(array $ids): void
    {
        DB::transaction(function () use ($ids) {
            $documentFiles = DocumentFile::query()->whereIn('id', $ids)->get();
            foreach ($documentFiles as $documentFile) {
                $filepath = $documentFile->filepath;
                $documentFile->delete();
                $this->deleteFile($filepath);
            }
        });
    }

    private function upload($file): string
    {
        $storageName = 'public';
        $ext = '.' . $file->getClientOriginalExtension();

        return $this->uploadStorage($storageName, 'document_files/' . auth()->user()->site_id, date('YmdHis') . $ext, $file);;
    }

    private function deleteFile($filepath): void
    {
        $storageName = 'public';
        $this->deleteFromStorage($storageName, null, $filepath);
    }
}
