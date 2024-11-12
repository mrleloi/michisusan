<?php

use App\Http\Controllers\Api\TagController;
// kiai_loi.le 2024.09.10 feature/setting_base add start
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\SendMailController;
use App\Http\Controllers\Api\SiteCssSettingController;
use App\Http\Controllers\Api\SiteJsSettingController;


Route::prefix('pages')->group(function () {
    Route::get('/', [PageController::class, 'index']);
    Route::post('/', [PageController::class, 'create']);
    Route::put('/', [PageController::class, 'updatePageIdByPages']);
    Route::put('/{id}', [PageController::class, 'update']);
    Route::delete('/{id}', [PageController::class, 'destroy']);
});

Route::post('sendmail/inquiry_test', [SendMailController::class, 'sendInquiryTestMail']);

Route::prefix('news_articles')->group(function () {
    Route::post('/translate', [\App\Http\Controllers\Api\NewsArticleController::class, 'translate']);
});

Route::prefix('news_categories')->group(function () {
    Route::match(['post', 'put'], '/order', [\App\Http\Controllers\Api\NewsCategoryController::class, 'changeOrder']);
});

Route::prefix('blogs_categories')->group(function () {
    Route::match(['post', 'put'], '/order', [\App\Http\Controllers\Api\BlogsCategoryController::class, 'changeOrder']);
});

Route::prefix('blogs_posts')->group(function () {
    Route::post('/translate', [\App\Http\Controllers\Api\BlogsPostController::class, 'translate']);
});

Route::prefix('settings')->group(function () {
    Route::get('css/{siteCssSetting}', [SiteCssSettingController::class, 'edit'])->name('site_css_settings.edit');
    Route::get('js/{siteJsSetting}', [SiteJsSettingController::class, 'edit'])->name('site_js_settings.edit');
});

Route::prefix('tags')->group(function () {
    Route::match(['post', 'put'], '/order', [TagController::class, 'changeOrder'])->name('tags.changeOrder');
});

Route::prefix('google-analytics')->group(function () {
    Route::post( '/report-data', [\App\Http\Controllers\Api\SiteAnalyticSettingController::class, 'getReportData']);
    Route::post('/conversion-data', [\App\Http\Controllers\Api\SiteAnalyticSettingController::class, 'getConversionData']);
    Route::post('/search-console', [\App\Http\Controllers\Api\SiteAnalyticSettingController::class, 'getSearchConsoleData']);
});

Route::prefix('change_logs')->group(function () {
    Route::post('/', [\App\Http\Controllers\ChangeLogController::class, 'index'])->name('change_logs.ajax');
});

Route::prefix('phone_calls')->group(function () {
    Route::post('/', [\App\Http\Controllers\Api\PhoneCallController::class, 'store'])->name('phone_calls.store');
    Route::get('/', [\App\Http\Controllers\Api\PhoneCallController::class, 'index'])->name('phone_calls.index');
});
// kiai_loi.le 2024.09.10 feature/setting_base add end

Route::prefix('before_after')->group(function () {
    Route::get('/categories', [\App\Http\Controllers\Api\BeforeAfterController::class, 'getCategories']);
    Route::get('/items_by_category', [\App\Http\Controllers\Api\BeforeAfterController::class, 'getItemsByCategory']);
});

Route::prefix('menu')->group(function () {
    Route::get('/categories', [\App\Http\Controllers\Api\MenuController::class, 'getCategories']);
    Route::get('/items_by_category', [\App\Http\Controllers\Api\MenuController::class, 'getItemsByCategory']);
});

Route::prefix('staff_member')->group(function () {
    Route::get('/departments', [\App\Http\Controllers\Api\StaffMemberController::class, 'getDepartments']);
    Route::get('/items_by_department', [\App\Http\Controllers\Api\StaffMemberController::class, 'getItemsByDepartment']);
});

Route::prefix('gallery')->group(function () {
    Route::get('/categories', [\App\Http\Controllers\Api\GalleryController::class, 'getCategories']);
    Route::get('/items_by_category', [\App\Http\Controllers\Api\GalleryController::class, 'getItemsByCategory']);
});

Route::prefix('shop')->group(function () {
    Route::get('/item', [\App\Http\Controllers\Api\ShopController::class, 'getItem']);
    Route::get('/items', [\App\Http\Controllers\Api\ShopController::class, 'getItems']);
});

Route::prefix('faq')->group(function () {
    Route::get('/categories', [\App\Http\Controllers\Api\FaqController::class, 'getCategories']);
    Route::get('/items_by_category', [\App\Http\Controllers\Api\FaqController::class, 'getItemsByCategory']);
});

Route::prefix('recruiting')->group(function () {
    Route::get('/categories', [\App\Http\Controllers\Api\RecruitingController::class, 'getCategories']);
    Route::get('/items_by_category', [\App\Http\Controllers\Api\RecruitingController::class, 'getItemsByCategory']);
});
