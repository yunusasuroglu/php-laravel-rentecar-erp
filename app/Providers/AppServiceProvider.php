<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\TranslationKey;
use App\Observers\LanguageObserver;
use App\Observers\TranslationKeyObserver;
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
        $languages = Language::all(); // Language modelinden tüm dilleri alın
        View::share('languages', $languages); // $languages değişkenini tüm view dosyalarına paylaşılan veri olarak ekleyin
        TranslationKey::observe(TranslationKeyObserver::class);
        Language::observe(LanguageObserver::class);
    }
}
