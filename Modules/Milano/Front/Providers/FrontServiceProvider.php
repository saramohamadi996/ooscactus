<?php
namespace Milano\Front\Providers;

use Illuminate\Support\ServiceProvider;
use Milano\Article\Repositories\ArticleRepository;
use Milano\Baner\Models\Baner;
use Milano\Banner\Models\Banner;
use Milano\Category\Repositories\CategoryRepository;
use Milano\Product\Models\Product;
use Milano\Seller\Models\Seller;
use Milano\Setting\Models\Setting;
use Milano\Slideshow\Models\Slideshow;

class FrontServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__. "/../Routes/front_routes.php");
        $this->loadViewsFrom(__DIR__. "/../Resources/Views", "Front");


        view()->composer('Front::layout.header', function ($view) {
            $categories =  (new CategoryRepository())->tree();
            $view->with(compact('categories'));
        });

        view()->composer('Front::layout.header', function ($view) {
            $settings = Setting::where('confirmation_status',
                Setting::CONFIRMATION_STATUS_ACCEPTED)->latest()->get();
            $view->with(compact('settings'));
        });

        view()->composer('Front::layout.latestProducts',function ($view) {

            $latestProducts = (new CategoryRepository())->latestProducts();
            $view->with(compact('latestProducts'));
        });

        view()->composer('Front::layout.popularProducts' ,function($view){
            $popularProducts = (new Product())->popularProducts();
            $view->with(compact('popularProducts'));
        });

        view()->composer('Front::layout.popularArticles',function ($view) {
            $popularArticles = (new ArticleRepository())->PopularArticles();
            $view->with(compact('popularArticles'));
        });

        view()->composer('Front::layout.top-info',function ($view) {
            $sliders = Slideshow::where('confirmation_status' , Slideshow::CONFIRMATION_STATUS_ACCEPTED)->latest()->get();
            $view->with(compact('sliders'));
        });

        view()->composer('Front::layout.top-info', function ($view) {
            $banners = Banner::where('confirmation_status' , Banner::CONFIRMATION_STATUS_ACCEPTED)->latest()->get();
            $view->with(compact('banners'));
        });

        view()->composer('Front::layout.sidebar-banners', function ($view) {
            $baners = Baner::where('confirmation_status' , Baner::CONFIRMATION_STATUS_ACCEPTED)->latest()->get();
            $view->with(compact('baners'));
        });

        view()->composer('Front::seller', function ($view) {
            $sellers = Seller::where('confirmation_status' , Seller::CONFIRMATION_STATUS_ACCEPTED)->latest()->get();
            $view->with(compact('sellers'));
        });
    }
}
