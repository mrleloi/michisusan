<?php

namespace App\Traits;

use Illuminate\Support\Facades\Response;
use Log;

trait CsvTrait
{
    /**
     * CSVファイルを生成してダウンロードする
     *
     * @param array $columns 出力するカラム名
     * @param string $filename 出力ファイル名
     * @return \Illuminate\Http\Response
     */
    public function exportToCsv($model, array $headers = null, $encoding = "utf8")
    {
        $chunkSize = 100;
        $file = new \SplFileObject('php://output', 'w');

        if ($headers) {
            if ($encoding === 'sjis') {
                $headers = array_map(function ($value) {
                    return mb_convert_encoding($value, 'SJIS-win', 'UTF-8');
                }, $headers);
            }
            $file->fputcsv($headers);
        }

        $model->chunk($chunkSize, function ($data) use ($file, $encoding) {
            foreach ($data as $datum) {
                $row = $datum->toArray();
                if ($encoding === 'sjis') {
                    $row = array_map(function ($value) {
                        return mb_convert_encoding($value, 'SJIS-win', 'UTF-8');
                    }, $row);
                }

                $file->fputcsv($row);
            }
        });
    }
}
