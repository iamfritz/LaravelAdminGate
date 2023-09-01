<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::apiResource('posts', App\Http\Controllers\Api\PostApiController::class);
    Route::apiResource('category', App\Http\Controllers\Api\PostApiController::class);
    Route::apiResource('users', App\Http\Controllers\Api\PostApiController::class);
    Route::apiResource('roles', App\Http\Controllers\Api\PostApiController::class);

    //Route::post('/register', [AuthController::class, 'register']);
    //Route::post('/login', [AuthController::class, 'login']);
    //Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');    
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::get('logout', 'logout');
        Route::get('refreshtoken', 'refresh');
        Route::get('userinfo', 'userInfo');
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('blogs', App\Http\Controllers\Api\PostApiController::class);
    });

});