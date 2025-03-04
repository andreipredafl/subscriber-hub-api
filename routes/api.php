<?php

use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\FieldController;
use App\Http\Controllers\Api\FieldSubscriberController;
use App\Http\Controllers\Api\SubscriberFieldController;
use Illuminate\Support\Facades\Route;

Route::apiResource('subscribers', SubscriberController::class);

Route::apiResource('fields', FieldController::class);

Route::post('subscribers/{subscriber}/fields', [SubscriberFieldController::class, 'upsert']);
Route::delete('subscribers/{subscriber}/fields/{field}', [SubscriberFieldController::class, 'destroy']);
