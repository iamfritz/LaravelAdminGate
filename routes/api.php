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

    Route::controller(AuthController::class)->middleware(['api.key'])->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
    });
    
    //Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::get('/refreshtoken', [AuthController::class, 'refreshToken']);    
        Route::get('/logout', [AuthController::class, 'logout']);

        Route::apiResource('users', App\Http\Controllers\Api\PostApiController::class);
        Route::apiResource('roles', App\Http\Controllers\Api\PostApiController::class);
        Route::apiResource('posts', App\Http\Controllers\Api\PostApiController::class);
        Route::apiResource('category', App\Http\Controllers\Api\PostApiController::class);
    });
    
    /* PUBLIC API */
    #->except(['index', 'show']);/* not working */
    Route::get('/posts', [App\Http\Controllers\Api\PostApiController::class, 'index']);
    Route::get('/posts/{post}', [App\Http\Controllers\Api\PostApiController::class, 'show']);
});