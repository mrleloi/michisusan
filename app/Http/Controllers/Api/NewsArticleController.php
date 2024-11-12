<?php
// kiai_loi.le 2024.09.10 feature/setting_base add start
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsArticles\TranslateRequest;
use App\Models\NewsArticle;
use App\Services\NewsArticleService;
use App\Services\NewsArticlesTranslateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NewsArticleController extends Controller
{
    protected $newsArticlesService;
    protected $newsArticlesTranslateService;

    public function __construct(
        NewsArticleService $newsArticlesService,
        NewsArticlesTranslateService $newsArticlesTranslateService,
    ) {
        $this->newsArticlesService = $newsArticlesService;
        $this->newsArticlesTranslateService = $newsArticlesTranslateService;
    }

    public function translate(TranslateRequest $request)
    {
        $request->validate([
            'translate_word' => 'required|string|max:255',
        ]);

        try {
            $validatedData = $request->validated();
            $translatedWord = $this->newsArticlesTranslateService->callTranslationService($validatedData);

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
