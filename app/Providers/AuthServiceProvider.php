<?php

namespace App\Providers;

use App\Models\Breed;
use App\Models\Coupon;
use App\Models\Pet;
use App\Models\PetService;
use App\Models\PetServicePrice;
use App\Models\User;
use App\Policies\BreedPolicy;
use App\Policies\CouponPolicy;
use App\Policies\PetPolicy;
use App\Policies\PetServicePolicy;
use App\Policies\PetServicePricePolicy;
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
        PetService::class => PetServicePolicy::class,
        PetServicePrice::class => PetServicePricePolicy::class,
        Breed::class => BreedPolicy::class,
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
