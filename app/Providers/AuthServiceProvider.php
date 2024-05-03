<?php

namespace App\Providers;

use App\Models\Coupon;
use App\Models\Pet;
use App\Models\User;
use App\Policies\CouponPolicy;
use App\Policies\PetPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Pet::class => PetPolicy::class,
        User::class => UserPolicy::class,
        Coupon::class => CouponPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
