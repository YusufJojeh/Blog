<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider {
    /**
    * Register any application services.
    */

    public function register(): void {
        //
    }

    /**
    * Bootstrap any application services.
    */

    public function boot(): void {
        View::composer('*', function ($view) {
            $view->with('site_name',  Setting::get('site_name', config('app.name')));
            $view->with('logo',       Setting::get('logo'));
            $view->with('favicon',    Setting::get('favicon'));
            $view->with('custom_css', Setting::get('custom_css'));
        });
        Paginator::useBootstrapFive();
    }
}
