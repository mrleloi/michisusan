<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageFileListRequest;
use App\Services\ImageFileService;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Storage;

class ImageFileController extends Controller
{
    protected $ifService;

    public function __construct(ImageFileService $ifService)
    {
        $this->ifService = $ifService;
    }

    public function getImage(Request $request)
    {
        $result = $this->ifService->get($request->id);
        return responseOkAPI(['image' => $result ? $result->toArray() : null]);
    }

    public function list(ImageFileListRequest $request)
    {
        $result = $this->ifService->list($request->validated());
        return responseOkAPI(['image_list' => $result]);
    }

    public function delete(Request $request)
    {
        try {
            $result = $this->ifService->delete($request->id);
            return responseOkAPI(['deleted' => $result]);
        } catch (Exception $e) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'アップロードできませんでした'
            );
        }
    }
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'image_file_category_id' => 'exists:image_file_categories,id',
            'quality' => 'integer'
        ]);

        $file = $request->file('file');
        $categoryId = $request->input('image_file_category_id');
        $quality = $request->input('quality');
        try {
            $this->ifService->upload($file, $categoryId, $quality);
            return responseOkAPI();
        } catch (Exception $e) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'アップロードできませんでした'
            );
        }
    }

    public function getCategories()
    {
        try {
            $categoryList = $this->ifService->getCategories();
            return responseOkAPI(['image_categories' => $categoryList]);
        } catch (Exception $e) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                '画像カテゴリーの取得に失敗しました'
            );
        }
    }
}
