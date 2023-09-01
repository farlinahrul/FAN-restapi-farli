<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\PresenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::group([
        'name'       => "AuthRoutes",
        'prefix'     => null,
        "middleware" => []
    ], base_path('routes/ApiRoutes/AuthRoutes.php'));
    Route::group([
        'name'       => "PresenceRoutes",
        'prefix'     => null,
        "middleware" => ['auth:api']
    ], base_path('routes/ApiRoutes/PresenceRoutes.php'));
});