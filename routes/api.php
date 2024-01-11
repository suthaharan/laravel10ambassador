<?php

use App\Http\Controllers\AmbassadorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatsController;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

function common($scope){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware(['auth:sanctum', $scope])->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::put('users/info', [AuthController::class, 'updateInfo']);
        Route::put('users/password', [AuthController::class, 'updatePassword']);
    });
}


// Admin has prefix admin in the URI
Route::prefix('admin')->group(function () {
    common('scope.admin');
    Route::middleware(['auth:sanctum', 'scope.admin'])->group(function () {

        Route::get('ambassadors', [AmbassadorController::class, 'index']);
        Route::get('users/{user_id}/links', [LinkController::class, 'index']);
        Route::get('orders', [OrderController::class, 'index']);

        // grouping API resources
        Route::apiResource('products', ProductController::class);
    });
});



// Ambassador
Route::prefix('ambassador')->group(function () {
    common('scope.ambassador');
    Route::get('products/frontend', [ProductController::class, 'frontend']);
    Route::get('products/backend', [ProductController::class, 'backend']);
    Route::middleware(['auth:sanctum', 'scope.ambassador'])->group(function () {
        Route::get('stats', [StatsController::class, 'index']);
        Route::get('rankings', [StatsController::class, 'rankings']);
    });
});



// Checkout
