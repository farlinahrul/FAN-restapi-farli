<?php
use App\Http\Controllers\Api\v1\PresenceController;
use Illuminate\Support\Facades\Route;

Route::get("presence", [PresenceController::class, 'index']);
Route::get("my_presence", [PresenceController::class, 'myPresence']);
Route::get("my_presence_approval", [PresenceController::class, 'myPresenceApproval']);
Route::post("presence", [PresenceController::class, 'store']);
Route::post("approve/{id}", [PresenceController::class, 'store']);

// imporvement: pagination
Route::get("my_presence_paginate", [PresenceController::class, 'myPresencePaginate']);
Route::get("presence_paginate", [PresenceController::class, 'indexPaginate']);
Route::get("my_presence_approval_paginate", [PresenceController::class, 'myPresenceApprovalPaginate']);