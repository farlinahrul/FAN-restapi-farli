<?php


use App\Http\Controllers\Api\v1\Auth\AuthorizationController;
use App\Http\Controllers\Api\v1\Auth\AuthorizeController;
use App\Http\Controllers\Api\v1\Auth\CallbackController;
use App\Http\Controllers\Api\v1\Auth\LoginController;
use App\Http\Controllers\Api\v1\Auth\LogoutController;
use App\Http\Controllers\Api\v1\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix("auth")->group(function () {
    Route::post("register", [RegisterController::class, 'register']);

    Route::post("login", [LoginController::class, 'login']);

    Route::get('callback', CallbackController::class);

    Route::post('authorize', AuthorizeController::class);

    Route::get('oauth/authorize', [
        'uses' => 'App\Http\Controllers\Api\v1\Auth\AuthorizationController@authorize',
        'as'   => 'authorizations.authorize',
    ]);

    Route::get("logout/{id}", LogoutController::class)->middleware('auth:api');
});