<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogsPosts\TranslateRequest;
use App\Models\BlogsPost;
use App\Services\BlogsPostService;
use App\Services\BlogsPostsTranslateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BlogsPostController extends Controller
{
    protected $blogsPostsService;
    protected $blogsPostsTranslateService;

    public function __construct(
        BlogsPostService $blogsPostsService,
        BlogsPostsTranslateService $blogsPostsTranslateService,
    ) {
        $this->blogsPostsService = $blogsPostsService;
        $this->blogsPostsTranslateService = $blogsPostsTranslateService;
    }

    public function translate(TranslateRequest $request)
    {
        $request->validate([
            'translate_word' => 'required|string|max:255',
        ]);

        try {
            $validatedData = $request->validated();
            $translatedWord = $this->blogsPostsTranslateService->callTranslationService($validatedData);

            if ($translatedWord) {
                return responseOkAPI(['result' => $translatedWord]);
            } else {
                return responseOkAPI();
            }
        } catch (\Exception $e) {
            return responseErrorAPI(
                null,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                ERROR_CODE_INTERNAL_SERVER_ERROR,
                'エラーが発生しました。システムの管理者に連絡してください。'
            );
        }
    }
}
// kiai_loi.le 2024.09.10 feature/setting_base add end
