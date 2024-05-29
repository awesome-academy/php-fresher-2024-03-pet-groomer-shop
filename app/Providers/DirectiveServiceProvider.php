<?php

namespace App\Providers;

use App\Enums\RoleEnum;
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
            return $this->getEndPhp();
        });

        Blade::directive('manager', function () {
            return '<?php if(auth()->check() && (auth()->user()->role_id === '
                . RoleEnum::MANGER
                . ' || auth()->user()->role_id === '
                . RoleEnum::ADMIN . ')): ?>';
        });

        Blade::directive('endmanager', function () {
            return $this->getEndPhp();
        });

        Blade::directive('notcustomer', function () {
            return '<?php if(auth()->check() && auth()->user()->role_id !== ' . RoleEnum::CUSTOMER . '): ?>';
        });

        Blade::directive('endnotcustomer', function () {
            return $this->getEndPhp();
        });

        Blade::directive('customer', function () {
            return '<?php if(auth()->check() && auth()->user()->role_id === ' . RoleEnum::CUSTOMER . '): ?>';
        });

        Blade::directive('endcustomer', function () {
            return $this->getEndPhp();
        });
    }

    public function getEndPhp()
    {
        return '<?php endif; ?>';
    }
}
