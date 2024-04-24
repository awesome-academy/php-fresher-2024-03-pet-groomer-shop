<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DirectiveServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('admin', function () {
            return '<?php if(auth()->check() && auth()->user()->is_admin): ?>';
        });

        Blade::directive('endadmin', function () {
            return '<?php endif; ?>';
        });
    }
}
