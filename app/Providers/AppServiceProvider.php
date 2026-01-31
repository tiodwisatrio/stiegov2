<?php

namespace App\Providers;

use App\Models\HighlightType;
use App\Models\ProductVariant;
use App\Observers\ProductVariantObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('layouts.admin', 'admin-layout');

        // Register ProductVariant Observer
        ProductVariant::observe(ProductVariantObserver::class);

        // Share highlight types and categories with navbar
        View::composer('layouts.partials.frontend.navbar', function ($view) {
            $view->with('highlightTypes', HighlightType::active()->ordered()->get());
            $view->with('categories', \App\Models\Category::parents()->with('children')->get());
        });
    }
}
