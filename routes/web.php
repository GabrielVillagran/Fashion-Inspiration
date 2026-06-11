<?php

use App\Http\Controllers\GarmentImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GarmentImageController::class, 'index'])
    ->name('garments.index');

Route::get('/garments/create', [GarmentImageController::class, 'create'])
    ->name('garments.create');

Route::post('/garments', [GarmentImageController::class, 'store'])
    ->name('garments.store');

Route::get('/garments/{garmentImage}', [GarmentImageController::class, 'show'])
    ->name('garments.show');