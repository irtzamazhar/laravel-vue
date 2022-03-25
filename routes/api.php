<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('user', [UserController::class, 'current']);

    Route::get('activities', [ActivityController::class, 'index']);
    Route::post('add_activity', [ActivityController::class, 'store']);
    Route::patch('update_activity', [ActivityController::class, 'update']);
    Route::delete('remove_activity', [ActivityController::class, 'delete']);
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);
});
