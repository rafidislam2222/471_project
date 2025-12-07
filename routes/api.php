<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;

Route::get('/properties', [PropertyController::class, 'index']);
Route::post('/properties', [PropertyController::class, 'store']);
Route::get('/properties/{id}', [PropertyController::class, 'show']);
Route::put('/properties/{id}', [PropertyController::class, 'update']);
Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);

Route::get('/properties/{id}/weather', [PropertyController::class, 'getWeather']);
