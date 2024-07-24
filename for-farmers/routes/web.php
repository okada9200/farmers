<?php

use App\Http\Controllers\CropController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\FertilizerController;
use App\Http\Controllers\PesticideController;
use App\Http\Controllers\TSPController;
use App\Http\Controllers\RouteController;

Route::resource('crops', CropController::class);

//作業関連
Route::get('crops/{crop}/works/create', [WorkController::class, 'create'])->name('works.create');
Route::post('crops/{crop}/works', [WorkController::class, 'store'])->name('works.store');
Route::get('crops/{crop}/works/{work}/edit', [WorkController::class, 'edit'])->name('works.edit');
Route::put('crops/{crop}/works/{work}', [WorkController::class, 'update'])->name('works.update');
Route::delete('crops/{crop}/works/{work}', [WorkController::class, 'destroy'])->name('works.destroy');

//肥料関連
Route::get('crops/{crop}/fertilizers/create', [FertilizerController::class, 'create'])->name('fertilizers.create');
Route::post('crops/{crop}/fertilizers', [FertilizerController::class, 'store'])->name('fertilizers.store');
Route::get('crops/{crop}/fertilizers/{fertilizer}/edit', [FertilizerController::class, 'edit'])->name('fertilizers.edit');
Route::put('crops/{crop}/fertilizers/{fertilizer}', [FertilizerController::class, 'update'])->name('fertilizers.update');
Route::delete('crops/{crop}/fertilizers/{fertilizer}', [FertilizerController::class, 'destroy'])->name('fertilizers.destroy');

//農薬関連
Route::get('crops/{crop}/pesticides/create', [PesticideController::class, 'create'])->name('pesticides.create');
Route::post('crops/{crop}/pesticides', [PesticideController::class, 'store'])->name('pesticides.store');
Route::get('crops/{crop}/pesticides/{pesticide}/edit', [PesticideController::class, 'edit'])->name('pesticides.edit');
Route::put('crops/{crop}/pesticides/{pesticide}', [PesticideController::class, 'update'])->name('pesticides.update');
Route::delete('crops/{crop}/pesticides/{pesticide}', [PesticideController::class, 'destroy'])->name('pesticides.destroy');


//巡回ルート計算関連
Route::get('tsp', [TSPController::class, 'index'])->name('tsp.index');
Route::post('tsp/calculate', [TSPController::class, 'calculate'])->name('tsp.calculate');

Route::get('/calculate-route', [RouteController::class, 'calculateRoute']);
Route::get('/map', function () {
    return view('map');
});


Route::get('route/input', [RouteController::class, 'input'])->name('route.input');
Route::post('route/showOptimal', [RouteController::class, 'showOptimalRoute'])->name('route.showOptimal');
