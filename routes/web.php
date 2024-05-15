<?php

use App\Http\Controllers\BreedController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\PetServiceController;
use App\Http\Controllers\PetServicePriceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
    });
});

Route::middleware(['auth', 'not.customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard');

    Route::resource('user', UserController::class)->names('user');

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

    Route::resource('coupon', CouponController::class)->names('coupon');

    Route::resource('pet-service', PetServiceController::class)->names('pet-service');

    Route::resource('coupon', CouponController::class)->names('coupon');

    Route::resource('pet-service', PetServiceController::class)->names('pet-service');

    Route::resource('pet-service.pet-service-price', PetServicePriceController::class)->names('pet-service-price');

    Route::resource('coupon', CouponController::class)->names('coupon');

    Route::resource('pet-service', PetServiceController::class)->names('pet-service');

    Route::resource('pet-service.pet-service-price', PetServicePriceController::class)->names('pet-service-price');

    Route::resource('breed', BreedController::class)->names('breed');

    Route::resource('coupon', CouponController::class)->names('coupon');

    Route::middleware(['admin'])->group(function () {
        Route::resource('role', RoleController::class)->names('role');
        // Permission
        Route::resource('permission', PermissionController::class)->names('permission');
        Route::get(
            'permission/{permission}/attach-role',
            [PermissionController::class, 'attachRolePage']
        )->name('permission.attach-role-page');
        Route::post(
            'permission/{permission}/attach-role',
            [PermissionController::class, 'attachRole']
        )->name('permission.attach-role');
    });
});

Route::get('language/{lang}', [LanguageController::class, 'setLanguage'])->name('language.set');

require __DIR__ . '/auth.php';
