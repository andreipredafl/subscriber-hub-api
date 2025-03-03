<?php

use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\FieldController;
use Illuminate\Support\Facades\Route;

Route::apiResource('subscribers', SubscriberController::class);
Route::apiResource('fields', FieldController::class);
