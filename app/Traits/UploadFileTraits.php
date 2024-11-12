<?php

namespace App\Traits;

use Dotenv\Exception\InvalidFileException;
use Illuminate\Support\Facades\Auth;
use Storage;

// This trait should be used by services only.
trait UploadFileTraits
{

    /**
     * Storageにファイルを保存します。
     *
     * @param string $storage_name 使用するStorage名
     * @param string $dir_key ディレクトリを表すキー
     * @param string $file_name ファイル名
     */
    public function uploadStorage($storage_name, $dir, $file_name, $file)
    {
        return Storage::disk($storage_name)->putFileAs($dir, $file, $file_name);
    }

    /**
     * Storageからファイルを削除します。
     *
     * @param string $storage_name 使用するStorage名
     * @param string $dir_key ディレクトリを表すキー
     * @param string $file_name ファイル名
     */
    public function deleteFromStorage($storage_name, $dir_key, $file_name)
    {
        $path = $dir_key ? $dir_key . DIRECTORY_SEPARATOR . $file_name
            : $file_name;
        Storage::disk($storage_name)->delete($path);
    }

    public function getMimeType($file_name)
    {
        $mimetypes = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'];
        $ext = pathinfo($file_name)['extension'];

        return $mimetypes[$ext];
    }

    /**
     * Base64ファイル情報から内容と拡張子を返します。
     *
     * @param string $base64_data Base64データ
     * @return array ファイル内容と拡張子の配列
     */
    private function getFileAndExtFromBase64($base64_data): array
    {
        list(, $file_data) = explode(';', $base64_data);
        list(, $file_data) = explode(',', $file_data);
        $file_data = base64_decode($file_data);

        // ファイル内容から拡張子取得
        $ext = finfo_buffer(finfo_open(), $file_data, FILEINFO_EXTENSION);
        $ext = $ext ? explode('/', $ext)[0] : $ext;

        // jpegが優先的に返るようなので、jpgに
        if (strtolower($ext) == "jpeg") {
            $ext = "jpg";
        }

        return [$file_data, $ext];
    }

}
