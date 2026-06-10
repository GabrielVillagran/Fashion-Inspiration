<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'garments.index')->name('garments.index');

Route::view('/garments/create', 'garments.create')->name('garments.create');

Route::view('/garments/sample', 'garments.show')->name('garments.show');