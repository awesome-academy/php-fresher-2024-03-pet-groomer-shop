<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PetController;
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

Route::get('/', [LandingPageController::class, 'landingPage']);



Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('user', UserController::class)->names('user');
});

Route::get('/pet', [PetController::class, 'index'])->name('pet.index');

Route::get('/pet/create', [PetController::class, 'create'])->name('pet.create');

Route::post('/pet/store', [PetController::class, 'store'])->name('pet.store');

Route::get('/pet/{id}/edit', [PetController::class, 'edit'])->name('pet.edit');

Route::put('/pet/{id}/update', [PetController::class, 'update'])->name('pet.update');

Route::delete('/pet/{id}/delete', [PetController::class, 'delete'])->name('pet.delete');


Route::get('language/{lang}', [LanguageController::class, 'setLanguage'])->name('language.set');

require __DIR__ . '/auth.php';
