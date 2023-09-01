<?php

use App\Http\Controllers\Api\v1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::group([
        'name'       => "AuthRoutes",
        'prefix'     => null,
        "middleware" => []
    ], base_path('routes/ApiRoutes/AuthRoutes.php'));
});