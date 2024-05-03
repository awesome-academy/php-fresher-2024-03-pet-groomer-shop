<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * The path to the current lang files.
     *
     * @var string
     */
    protected $langPath;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $langPath = resource_path('lang/' . App::getLocale());

        View::composer('*', function ($view) use ($langPath) {
            $translation = collect(File::allFiles($langPath))->flatMap(function ($file) {
                return [
                    ($translation = $file->getBasename('.php')) => trans($translation),
                ];
            });

            $view->with('translation', $translation);
        });
    }
}
