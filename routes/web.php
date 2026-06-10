<?php

use App\Http\Controllers\GarmentImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GarmentImageController::class, 'index'])
    ->name('garments.index');

Route::get('/garments/create', [GarmentImageController::class, 'create'])
    ->name('garments.create');

Route::get('/garments/{garmentImage}', [GarmentImageController::class, 'show'])
    ->name('garments.show');
