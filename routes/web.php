<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\Api\ImageFileController;
use App\Http\Controllers\Api\ListApiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DocumentFileController;
use App\Http\Controllers\EmbedParts\GalleryItemController;
use App\Http\Controllers\EmbedParts\GalleryCategoryController;
use App\Http\Controllers\EmbedParts\GallerySettingController;
use App\Http\Controllers\EmbedParts\MenuItemController;
use App\Http\Controllers\EmbedParts\ShopItemController;
use App\Http\Controllers\EmbedParts\MenuCategoryController;
use App\Http\Controllers\BlogsTemplateController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmbedParts\BeforeAfterItemController;
use App\Http\Controllers\EmbedParts\BeforeAfterCategoryController;
use App\Http\Controllers\EmbedParts\BeforeAfterSettingController;
use App\Http\Controllers\EmbedParts\StaffMemberController;
use App\Http\Controllers\EmbedParts\FaqItemController;
use App\Http\Controllers\EmbedParts\FaqCategoryController;
use App\Http\Controllers\EmbedParts\RecruitingCategoryController;
use App\Http\Controllers\EmbedParts\RecruitingController;
use App\Http\Controllers\EmbedParts\RecruitingSettingController;
use App\Http\Controllers\EmbedParts\InquiryFormController;
use App\Http\Controllers\ImageCategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\EmbedParts\FavoriteController;
use App\Http\Controllers\FavoriteCategoryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\SiteCssSettingController;
use App\Http\Controllers\SiteJsSettingController;
use App\Http\Controllers\SiteSnsSettingController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SitePaymentSettingController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\InquiryLogController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/table_sample', [SampleController::class, 'table']);

// 内部API
Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
    Route::put('/change_order/{listType}', [ListApiController::class, 'changeOrder']);
    Route::post('/menu_item/regist_category', [MenuItemController::class, 'registCategory']);
    Route::post('/gallery_item/regist_category', [GalleryItemController::class, 'registCategory']);
    Route::post('/recruiting/regist_category', [RecruitingController::class, 'registCategory']);
    Route::post('/before_after_item/regist_category', [BeforeAfterItemController::class, 'registCategory']);
    Route::post('/faq_item/regist_category', [FaqItemController::class, 'registCategory']);
    Route::get('/image_file/get', [ImageFileController::class, 'getImage']);
    Route::get('/image_file/list', [ImageFileController::class, 'list']);
    Route::delete('/image_file/delete', [ImageFileController::class, 'delete']);
    Route::get('/image_file/get_categories', [ImageFileController::class, 'getCategories']);
    Route::post('/image_file/upload', [ImageFileController::class, 'upload']);
});
Route::get('/table_sample', [SampleController::class, 'table']);

Route::prefix('admin')->group(function () {
    Route::get('/login', function () {
        return view('login');
    });
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::view('/', 'dashboard.index')->name('dashboard');

    Route::prefix('news_articles')->group(function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\NewsArticleController::class, 'index'])->name('news_articles.index');
        Route::get('/add', [\App\Http\Controllers\NewsArticleController::class, 'create'])->name('news_articles.create');
        Route::post('/add', [\App\Http\Controllers\NewsArticleController::class, 'store'])->name('news_articles.store');
        Route::get('/{newsArticle}/edit', [\App\Http\Controllers\NewsArticleController::class, 'edit'])->name('news_articles.edit');
        Route::match(['post', 'put'], '/{newsArticle}/edit', [\App\Http\Controllers\NewsArticleController::class, 'update'])->name('news_articles.update');
        Route::match(['post', 'delete'], '/{newsArticle}/delete', [\App\Http\Controllers\NewsArticleController::class, 'delete'])->name('news_articles.delete');
        Route::match(['post', 'delete'], '/bulkDelete', [\App\Http\Controllers\NewsArticleController::class, 'bulkDelete'])->name('news_articles.bulkDelete');
    });

    Route::prefix('news_articles')->group(function () {
        Route::get('/basic_setting', [\App\Http\Controllers\NewsSettingController::class, 'edit'])->name('news_settings.edit');
        Route::match(['post', 'put'], '/basic_setting', [\App\Http\Controllers\NewsSettingController::class, 'update'])->name('news_settings.update');
    });

    Route::prefix('news_categories')->group(function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\NewsCategoryController::class, 'index'])->name('news_categories.index');
        Route::get('/add', [\App\Http\Controllers\NewsCategoryController::class, 'create'])->name('news_categories.create');
        Route::post('/add', [\App\Http\Controllers\NewsCategoryController::class, 'store'])->name('news_categories.store');
        Route::get('/{newsCategory}/edit', [\App\Http\Controllers\NewsCategoryController::class, 'edit'])->name('news_categories.edit');
        Route::match(['post', 'put'], '/{newsCategory}/edit', [\App\Http\Controllers\NewsCategoryController::class, 'update'])->name('news_categories.update');
        Route::match(['post', 'delete'], '/{newsCategory}/delete', [\App\Http\Controllers\NewsCategoryController::class, 'delete'])->name('news_categories.delete');
        Route::match(['post', 'delete'], '/bulkDelete', [\App\Http\Controllers\NewsCategoryController::class, 'bulkDelete'])->name('news_categories.bulkDelete');
    });

    Route::prefix('blogs_categories')->group(function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\BlogsCategoryController::class, 'index'])->name('blogs_categories.index');
        Route::get('/add', [\App\Http\Controllers\BlogsCategoryController::class, 'create'])->name('blogs_categories.create');
        Route::post('/add', [\App\Http\Controllers\BlogsCategoryController::class, 'store'])->name('blogs_categories.store');
        Route::get('/{blogsCategory}/edit', [\App\Http\Controllers\BlogsCategoryController::class, 'edit'])->name('blogs_categories.edit');
        Route::match(['post', 'put'], '/{blogsCategory}/edit', [\App\Http\Controllers\BlogsCategoryController::class, 'update'])->name('blogs_categories.update');
        Route::match(['post', 'delete'], '/{blogsCategory}/delete', [\App\Http\Controllers\BlogsCategoryController::class, 'delete'])->name('blogs_categories.delete');
        Route::match(['post', 'delete'], '/bulkDelete', [\App\Http\Controllers\BlogsCategoryController::class, 'bulkDelete'])->name('blogs_categories.bulkDelete');
    });

    Route::prefix('blogs_posts')->group(function () {
        Route::match(['get', 'post'], '/', [\App\Http\Controllers\BlogsPostController::class, 'index'])->name('blogs_posts.index');
        Route::get('/add', [\App\Http\Controllers\BlogsPostController::class, 'create'])->name('blogs_posts.create');
        Route::post('/add', [\App\Http\Controllers\BlogsPostController::class, 'store'])->name('blogs_posts.store');
        Route::get('/{blogsPost}/edit', [\App\Http\Controllers\BlogsPostController::class, 'edit'])->name('blogs_posts.edit');
        Route::match(['post', 'put'], '/{blogsPost}/edit', [\App\Http\Controllers\BlogsPostController::class, 'update'])->name('blogs_posts.update');
        Route::match(['post', 'delete'], '/{blogsPost}/delete', [\App\Http\Controllers\BlogsPostController::class, 'delete'])->name('blogs_posts.delete');
        Route::match(['post', 'delete'], '/bulkDelete', [\App\Http\Controllers\BlogsPostController::class, 'bulkDelete'])->name('blogs_posts.bulkDelete');
        Route::get('/blogs_simple', [\App\Http\Controllers\BlogsPostController::class, 'addBlogsSimple'])->name('blogs_simple.create');
        Route::post('/blogs_simple', [\App\Http\Controllers\BlogsPostController::class, 'storeBlogsSimple'])->name('blogs_simple.store');
        Route::get('/blogs_simple/{blogsPost}/edit', [\App\Http\Controllers\BlogsPostController::class, 'editBlogSimple'])->name('blogs_simple.edit');
        Route::match(['post', 'put'], '/blogs_simple/{blogsPost}/edit', [\App\Http\Controllers\BlogsPostController::class, 'update'])->name('blogs_simple.update');

        Route::prefix('basic_setting')->group(function () {
            Route::get('/', [\App\Http\Controllers\BlogsSettingController::class, 'edit'])->name('blogs_settings.edit');
            Route::match(['post', 'put'], '/', [\App\Http\Controllers\BlogsSettingController::class, 'update'])->name('blogs_settings.update');
        });
    });

    Route::prefix('pages')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('pages.index');
        Route::get('/templates', [PageController::class, 'templates'])->name('pages.templates');
        Route::get('/create', [PageController::class, 'create_index'])->name('pages.create');
        Route::post('/create', [PageController::class, 'create']);
        Route::get('/{id}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::post('/{id}/update', [PageController::class, 'update']);
    });

    Route::prefix('templates')->group(function () {
        Route::get('/', [TemplateController::class, 'index'])->name('templates.index');
        Route::get('/{id}/edit', [TemplateController::class, 'edit'])->name('templates.edit');
        Route::get('/{id}/delete', [TemplateController::class, 'destroy'])->name('templates.destroy');
    });

    Route::prefix('sidenavi')->group(function () {
        Route::get('/', [SidebarController::class, 'index'])->name('sidenavi.index');
        Route::post('/', [SidebarController::class, 'update'])->name('sidenavi.post');
    });

    Route::prefix('footer')->group(function () {
        Route::get('/', [FooterController::class, 'index'])->name('footer.index');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/header-footer', [SettingsController::class, 'header_footer'])->name('header_footer.index');
        Route::post('/header-footer', [SettingsController::class, 'header_footer_update'])->name('header_footer.post');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/embedded-script', [SettingController::class, 'embeddedScript'])->name('settings.embedded_script.edit');
        Route::match(['post', 'put'], '/embedded-script', [SettingController::class, 'updateEmbeddedScript'])->name('settings.embedded_script.update');
        Route::get('/site-map', [SettingController::class, 'sitemap'])->name('settings.sitemap.edit');
        Route::match(['post', 'put'], '/site-map', [SettingController::class, 'updateSitemap'])->name('settings.sitemap.update');
        Route::get('/analytic', [SettingController::class, 'analytic'])->name('site_analytic_settings.index');
        Route::match(['post', 'put'],'/analytic', [SettingController::class, 'updateAnalytic'])->name('site_analytic_settings.update');
        Route::get('/advanced', [SettingController::class, 'advanced'])->name('settings.advanced.edit');
        Route::match(['post', 'put'], '/advanced', [SettingController::class, 'updateAdvanced'])->name('settings.advanced.update');
    });

    Route::resource('shop_item', ShopItemController::class)->except(['show']);
    Route::delete('/shop_item_bulk_delete', [ShopItemController::class, 'bulkDelete'])->name('shop_item.bulk_delete');
    Route::resource('menu_item', MenuItemController::class)->except(['show']);
    Route::delete('/menu_item_bulk_delete', [MenuItemController::class, 'bulkDelete'])->name('menu_item.bulk_delete');
    Route::resource('menu_category', MenuCategoryController::class)->except(['show']);
    Route::delete('/menu_category_bulk_delete', [MenuCategoryController::class, 'bulkDelete'])->name('menu_category.bulk_delete');
    Route::resource('gallery_item', GalleryItemController::class)->except(['show']);
    Route::delete('/gallery_item_bulk_delete', [GalleryItemController::class, 'bulkDelete'])->name('gallery_item.bulk_delete');
    Route::get('/gallery_item/{gallery_item}/copy', [GalleryItemController::class, 'copy'])->name('gallery_item.copy');
    Route::resource('faq_item', FaqItemController::class)->except(['show']);
    Route::delete('/faq_item_bulk_delete', [FaqItemController::class, 'bulkDelete'])->name('faq_item.bulk_delete');
    Route::resource('faq_category', FaqCategoryController::class)->except(['show']);
    Route::delete('/faq_category_bulk_delete', [FaqCategoryController::class, 'bulkDelete'])->name('faq_category.bulk_delete');
    Route::resource('gallery_category', GalleryCategoryController::class)->except(['show']);
    Route::delete('/gallery_category_bulk_delete', [GalleryCategoryController::class, 'bulkDelete'])->name('gallery_category.bulk_delete');
    Route::resource('gallery_setting', GallerySettingController::class)->except(['show']);
    Route::resource('staff_member', StaffMemberController::class)->except(['show']);
    Route::delete('/staff_member_bulk_delete', [StaffMemberController::class, 'bulkDelete'])->name('staff_member.bulk_delete');
    Route::resource('department', DepartmentController::class)->except(['show']);
    Route::delete('/department_bulk_delete', [DepartmentController::class, 'bulkDelete'])->name('department.bulk_delete');
    Route::resource('gallery_setting', GallerySettingController::class)->except(['show']);
    Route::resource('staff_member', StaffMemberController::class)->except(['show']);
    Route::delete('/staff_member_bulk_delete', [StaffMemberController::class, 'bulkDelete'])->name('staff_member.bulk_delete');
    Route::resource('department', DepartmentController::class)->except(['show']);
    Route::delete('/department_bulk_delete', [DepartmentController::class, 'bulkDelete'])->name('department.bulk_delete');
    Route::resource('recruiting', RecruitingController::class)->except(['show']);
    Route::delete('/recruiting_bulk_delete', [RecruitingController::class, 'bulkDelete'])->name('recruiting.bulk_delete');
    Route::resource('recruiting_category', RecruitingCategoryController::class)->except(['show']);
    Route::delete('/recruiting_category_bulk_delete', [RecruitingCategoryController::class, 'bulkDelete'])->name('recruiting_category.bulk_delete');
    Route::get('/recruiting/{recruiting}/copy', [RecruitingController::class, 'copy'])->name('gallery_item.copy');
    Route::resource('recruiting_setting', RecruitingSettingController::class)->except(['show', 'destroy']);
    Route::resource('favorite', FavoriteController::class)->except(['show'])->only(['index', 'destroy']);
    Route::delete('/favorite_bulk_delete', [FavoriteController::class, 'bulkDelete'])->name('favorite.bulk_delete');

    Route::resource('before_after_item', BeforeAfterItemController::class)->except(['show']);
    Route::delete('/before_after_item_bulk_delete', [BeforeAfterItemController::class, 'bulkDelete'])->name('before_after_item.bulk_delete');
    Route::resource('before_after_category', BeforeAfterCategoryController::class)->except(['show']);
    Route::delete('/before_after_category_bulk_delete', [BeforeAfterCategoryController::class, 'bulkDelete'])->name('before_after_category.bulk_delete');
    Route::resource('before_after_setting', BeforeAfterSettingController::class)->except(['show', 'delete']);
    Route::resource('inquiry_form', InquiryFormController::class);
    Route::delete('/inquiry_form_bulk_delete', [InquiryFormController::class, 'bulkDelete'])->name('inquiry_form.bulk_delete');
    Route::get('/inquiry_form/{inquiry_form}/history', [InquiryFormController::class, 'history'])->name('inquiry_form.history');

    Route::prefix('inquiry_log')->group(function () {
        Route::get('/{inquiry_form_id}', [InquiryLogController::class, 'index'])->name('inquiry_log.index');
        Route::get('/csv/{inquiry_form_id}/{enc}', [InquiryLogController::class, 'downloadCSV'])->name('inquiry_log.csv');
        Route::delete('/{inquiry_log}', [InquiryLogController::class, 'destroy'])->name('users.destroy');
    });
    Route::delete('/inquiry_log_bulk_delete', [InquiryLogController::class, 'bulkDelete'])->name('inquiry_log.bulk_delete');


    Route::get('/setting/general', [SettingController::class, 'general'])->name('setting.general');
    Route::post('/setting/general', [SettingController::class, 'updateGeneral'])->name('setting.general.update');
    Route::get('/setting/initial', [SettingController::class, 'initial'])->name('setting.initial');
    Route::post('/setting/initial', [SettingController::class, 'updateInitial'])->name('setting.initial.update');
    Route::get('/setting/appearance', [SettingController::class, 'appearance'])->name('setting.appearance');
    Route::post('/setting/appearance', [SettingController::class, 'updateappearance'])->name('setting.appearance.update');

    Route::prefix('blogs_templates')->group(function () {
        Route::match(['get', 'post'], '/', [BlogsTemplateController::class, 'index'])->name('blogs_templates.index');
        Route::get('/{blogsTemplate}/add', [BlogsTemplateController::class, 'edit'])->name('blogs_templates.edit');
        Route::match(['post', 'put'], '/{blogsTemplate}/add', [BlogsTemplateController::class, 'update'])->name('blogs_templates.update');
        Route::match(['post', 'delete'], '/bulkDelete', [BlogsTemplateController::class, 'bulkDelete'])->name('blogs_templates.bulkDelete');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/add', [UserController::class, 'create'])->name('users.create');
        Route::post('/add', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}/edit', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::delete('/bulk_delete', [UserController::class, 'bulkDelete'])->name('users.bulk_delete');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/css', [SiteCssSettingController::class, 'index'])->name('site_css_settings.index');
        Route::post('/css', [SiteCssSettingController::class, 'store'])->name('site_css_settings.store');
        Route::get('/js', [SiteJsSettingController::class, 'index'])->name('site_js_settings.index');
        Route::post('/js', [SiteJsSettingController::class, 'store'])->name('site_js_settings.store');
        Route::get('/payment', [SitePaymentSettingController::class, 'index'])->name('site_payment_settings.index');
        Route::post('/payment', [SitePaymentSettingController::class, 'update'])->name('site_payment_settings.update');
        Route::get('/sns', [SiteSnsSettingController::class, 'index'])->name('site_sns_settings.index');
        Route::post('/sns', [SiteSnsSettingController::class, 'update'])->name('site_sns_settings.update');
    });

    Route::prefix('tags')->group(function () {
        Route::match(['get', 'post'], '/', [TagController::class, 'index'])->name('tags.index');
        Route::get('/add', [TagController::class, 'create'])->name('tags.create');
        Route::post('/add', [TagController::class, 'store'])->name('tags.store');
        Route::get('/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
        Route::match(['post', 'put'], '/{tag}/edit', [TagController::class, 'update'])->name('tags.update');
        Route::match(['post', 'delete'], '/bulkDelete', [TagController::class, 'bulkDelete'])->name('tags.bulkDelete');
        Route::match(['post', 'delete'], '/{tag}/delete', [TagController::class, 'delete'])->name('tags.delete');
    });

    Route::prefix('document_files')->group(function () {
        Route::match(['get', 'post'], '/', [DocumentFileController::class, 'index'])->name('document_files.index');
        Route::get('/add', [DocumentFileController::class, 'create'])->name('document_files.create');
        Route::post('/add', [DocumentFileController::class, 'store'])->name('document_files.store');
        Route::get('/{documentFile}/edit', [DocumentFileController::class, 'edit'])->name('document_files.edit');
        Route::match(['post', 'put'], '/{documentFile}/edit', [DocumentFileController::class, 'update'])->name('document_files.update');
        Route::match(['post', 'delete'], '/bulkDelete', [DocumentFileController::class, 'bulkDelete'])->name('document_files.bulk_delete');
        Route::match(['post', 'delete'], '/{documentFile}', [DocumentFileController::class, 'delete'])->name('document_files.delete');
    });

    Route::prefix('images')->group(function () {
        Route::match(['get', 'post'], '/', [ImageController::class, 'index'])->name('images.index');
        Route::get('/add', [ImageController::class, 'create'])->name('images.create');
        Route::post('/add', [ImageController::class, 'store'])->name('images.store');
        Route::get('/{image}/edit', [ImageController::class, 'edit'])->name('images.edit');
        Route::match(['post', 'put'], '/{image}/edit', [ImageController::class, 'update'])->name('images.update');
        Route::match(['post', 'delete'], '/bulkDelete', [ImageController::class, 'bulkDelete'])->name('images.bulkDelete');
        Route::match(['post', 'delete'], '/{image}/delete', [ImageController::class, 'delete'])->name('images.delete');
    });

    Route::prefix('image_categories')->group(function () {
        Route::match(['get', 'post'], '/', [ImageCategoryController::class, 'index'])->name('image_categories.index');
        Route::get('/add', [ImageCategoryController::class, 'create'])->name('image_categories.create');
        Route::post('/add', [ImageCategoryController::class, 'store'])->name('image_categories.store');
        Route::get('/{imageCategory}/edit', [ImageCategoryController::class, 'edit'])->name('image_categories.edit');
        Route::match(['post', 'put'], '/{imageCategory}/edit', [ImageCategoryController::class, 'update'])->name('image_categories.update');
        Route::match(['post', 'delete'], '/bulk_delete', [ImageCategoryController::class, 'bulkDelete'])->name('image_categories.bulk_delete');
        Route::match(['post', 'delete'], '/{imageCategory}', [ImageCategoryController::class, 'delete'])->name('image_categories.delete');
    });

    Route::prefix('redirects')->group(function () {
        Route::match(['get', 'post'], '/', [RedirectController::class, 'index'])->name('redirects.index');
        Route::get('/add', [RedirectController::class, 'create'])->name('redirects.create');
        Route::post('/add', [RedirectController::class, 'store'])->name('redirects.store');
        Route::get('/{redirect}/edit', [RedirectController::class, 'edit'])->name('redirects.edit');
        Route::match(['post', 'put'], '/{redirect}/edit', [RedirectController::class, 'update'])->name('redirects.update');
        Route::match(['post', 'delete'], '/bulk_delete', [RedirectController::class, 'bulkDelete'])->name('redirects.bulk_delete');
        Route::match(['post', 'delete'], '/{redirect}', [RedirectController::class, 'delete'])->name('redirects.delete');
    });

    Route::get('change_logs', [\App\Http\Controllers\ChangeLogController::class, 'index'])->name('change_logs.index');
    Route::get('report-tels', [\App\Http\Controllers\ReportTelController::class, 'index'])->name('report_tels.index');

    Route::prefix('videos')->group(function () {
        Route::match(['get', 'post'], '/', [VideoController::class, 'index'])->name('videos.index');
        Route::get('/add', [VideoController::class, 'create'])->name('videos.create');
        Route::post('/add', [VideoController::class, 'store'])->name('videos.store');
        Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
        Route::match(['post', 'put'], '/{video}/edit', [VideoController::class, 'update'])->name('videos.update');
        Route::match(['post', 'delete'], '/bulkDelete', [VideoController::class, 'bulkDelete'])->name('videos.bulkDelete');
        Route::match(['post', 'delete'], '/{video}/delete', [VideoController::class, 'delete'])->name('videos.delete');
    });

    Route::prefix('video_categories')->group(function () {
        Route::match(['get', 'post'], '/', [VideoCategoryController::class, 'index'])->name('video_categories.index');
        Route::get('/add', [VideoCategoryController::class, 'create'])->name('video_categories.create');
        Route::post('/add', [VideoCategoryController::class, 'store'])->name('video_categories.store');
        Route::get('/{videoCategory}/edit', [VideoCategoryController::class, 'edit'])->name('video_categories.edit');
        Route::match(['post', 'put'], '/{videoCategory}/edit', [VideoCategoryController::class, 'update'])->name('video_categories.update');
        Route::match(['post', 'delete'], '/bulk_delete', [VideoCategoryController::class, 'bulkDelete'])->name('video_categories.bulk_delete');
        Route::match(['post', 'delete'], '/{videoCategory}', [VideoCategoryController::class, 'delete'])->name('video_categories.delete');
    });

    Route::prefix('navigations')->group(function () {
        Route::match(['get', 'post'], '/', [NavigationController::class, 'index'])->name('navigations.index');
        Route::get('/add', [NavigationController::class, 'create'])->name('navigations.create');
        Route::post('/add', [NavigationController::class, 'store'])->name('navigations.store');
        Route::get('/{navigation}/edit', [NavigationController::class, 'edit'])->name('navigations.edit');
        Route::match(['post', 'put'], '/{navigation}/edit', [NavigationController::class, 'update'])->name('navigations.update');
        Route::match(['post', 'delete'], '/bulk_delete', [NavigationController::class, 'bulkDelete'])->name('navigations.bulk_delete');
        Route::match(['post', 'delete'], '/{navigation}', [NavigationController::class, 'delete'])->name('navigations.delete');
    });
});

Route::get('', [FrontController::class, 'index']);
Route::get('/{path}', [FrontController::class, 'index'])->where('path', '.+');