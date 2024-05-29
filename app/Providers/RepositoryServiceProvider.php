<?php

namespace App\Providers;

use App\Repositories\Branch\BranchRepository;
use App\Repositories\Branch\BranchRepositoryInterface;
use App\Repositories\Breed\BreedRepository;
use App\Repositories\Breed\BreedRepositoryInterface;
use App\Repositories\CareOrder\CareOrderRepository;
use App\Repositories\CareOrder\CareOrderRepositoryInterface;
use App\Repositories\CareOrderDetail\CareOrderDetailRepository;
use App\Repositories\CareOrderDetail\CareOrderDetailRepositoryInterface;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Coupon\CouponRepositoryInterface;
use App\Repositories\HotelService\HotelServiceRepository;
use App\Repositories\HotelService\HotelServiceRepositoryInterface;
use App\Repositories\Pet\PetRepository;
use App\Repositories\Pet\PetRepositoryInterface;
use App\Repositories\PetService\PetServiceRepository;
use App\Repositories\PetService\PetServiceRepositoryInterface;
use App\Repositories\PetServicePrice\PetServicePriceRepository;
use App\Repositories\PetServicePrice\PetServicePriceRepositoryInterface;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            PetRepositoryInterface::class,
            PetRepository::class
        );

        $this->app->singleton(
            BreedRepositoryInterface::class,
            BreedRepository::class
        );

        $this->app->singleton(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );

        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            BranchRepositoryInterface::class,
            BranchRepository::class
        );

        $this->app->singleton(
            CareOrderRepositoryInterface::class,
            CareOrderRepository::class
        );

        $this->app->singleton(
            CareOrderDetailRepositoryInterface::class,
            CareOrderDetailRepository::class
        );

        $this->app->singleton(
            CouponRepositoryInterface::class,
            CouponRepository::class
        );

        $this->app->singleton(
            PetServiceRepositoryInterface::class,
            PetServiceRepository::class
        );

        $this->app->singleton(
            PetServicePriceRepositoryInterface::class,
            PetServicePriceRepository::class
        );

        $this->app->singleton(
            HotelServiceRepositoryInterface::class,
            HotelServiceRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
