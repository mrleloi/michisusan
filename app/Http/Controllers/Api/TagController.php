<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tags\ChangeOrderTagRequest;
use App\Services\TagService;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(
        TagService $tagService
    ) {
        $this->tagService = $tagService;
    }

    public function changeOrder(ChangeOrderTagRequest $request) {
        try {
            $validatedData = $request->validated();

            $result = $this->tagService->reorderTags($validatedData);

            if ($result) {
                return responseOkAPI();
            }
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'エラーが発生しました。システムの管理者に連絡してください。'
            );
        } catch (\Exception $e) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
}
