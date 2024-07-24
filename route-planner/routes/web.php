<?php

use App\Http\Controllers\RouteController;

Route::get('/', [RouteController::class, 'index']);
Route::post('/addresses', [RouteController::class, 'store']);
Route::post('/get-route', [RouteController::class, 'getRoute']);
