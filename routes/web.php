<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
#|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::resource('users', App\Http\Controllers\UserController::class)->middleware('auth');
Route::resource('posts', PostController::class)->middleware('auth');
Route::resource('category', App\Http\Controllers\CategoryController::class)->middleware('auth');
Route::resource('apikey', App\Http\Controllers\ApikeyController::class)->middleware('auth');
Route::resource('roles', App\Http\Controllers\RoleController::class)->middleware('auth');
Route::resource('tasks', App\Http\Controllers\TaskController::class)->middleware('auth');