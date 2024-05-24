<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\BreedController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Customer\CareOrderController;
use App\Http\Controllers\Customer\CustomerPetController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PetServiceController;
use App\Http\Controllers\PetServicePriceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LandingPageController::class, 'landingPage'])->name('home');

Route::prefix('/customer')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::resource('customer-profile', CustomerProfileController::class)->names('customer-profile');

        Route::resource('care-order', CareOrderController::class)->names('care-order');
        Route::get(
            '/care-order/{pet}/request',
            [CareOrderController::class, 'requestPage']
        )
            ->name('care-order.request-page');
        Route::post('/care-order/{pet}/request', [CareOrderController::class, 'request'])->name('care-order.request');

        Route::resource('pet.payment', PaymentController::class)->names('payment');
        Route::get('/payment/coupon', [PaymentController::class, 'getCoupon'])->name('payment.coupon');
        Route::get('/payment/confirm', [PaymentController::class, 'confirmPage'])->name('payment.confirm');

        Route::resource('customer.pet', CustomerPetController::class)->names('customer-pet');
        Route::resource('care-order-history', CareOrderHistoryController::class)->names('care-order-history');
    });
});

Route::middleware(['auth', 'not.customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard');

    Route::resource('user', UserController::class)->names('user');

    Route::resource('branch', BranchController::class)->names('branch');

    Route::get('/pet', [PetController::class, 'index'])->name('pet.index');

    Route::get('/pet/create', [PetController::class, 'create'])->name('pet.create');

    Route::post('/pet/store/{user}', [PetController::class, 'store'])->name('pet.store');

    Route::get('/pet/{id}/edit', [PetController::class, 'edit'])->name('pet.edit');

    Route::put('/pet/{id}/update/{user}', [PetController::class, 'update'])->name('pet.update');

    Route::delete('/pet/{id}/delete/{user}', [PetController::class, 'destroy'])->name('pet.delete');

    Route::resource('employee', EmployeeController::class)->names('employee');
    Route::get(
        '/employee/assign-task/{employee}/{branch}',
        [EmployeeController::class, 'assignTaskPage']
    )
        ->name('employee.assign-task-page');
    Route::post(
        '/employee/assign-task/{employee}/{order}',
        [EmployeeController::class, 'assignTask']
    )
        ->name('employee.assign-task');
    Route::put(
        '/employee/assign-task/{employee}/{order}',
        [EmployeeController::class, 'updateAssignTask']
    )
        ->name('employee.update-assign-task');

    Route::resource('coupon', CouponController::class)->names('coupon');

    Route::resource('pet-service', PetServiceController::class)->names('pet-service');

    Route::resource('pet-service.pet-service-price', PetServicePriceController::class)->names('pet-service-price');

    Route::resource('breed', BreedController::class)->names('breed');
});

Route::get('language/{lang}', [LanguageController::class, 'setLanguage'])->name('language.set');

require __DIR__ . '/auth.php';
