<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'currentUser']);

Route::prefix('/v1')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthenticationController::class, 'logout']);

        Route::get('branches', [BranchController::class, 'index']);
        Route::post('branches', [BranchController::class, 'store']);
        Route::get('branches/{id}', [BranchController::class, 'show']);
        Route::put('branches/{id}', [BranchController::class, 'update']);
        Route::delete('branches/{id}', [BranchController::class, 'destroy']);
    });
});
