<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [PhotoController::class, 'create']);
Route::post('/upload-single',[PhotoController::class,'storeSingle'])->name('photo.store.single');
Route::post('/upload-multiple',[PhotoController::class,'storeMultiple'])->name('photo.store.multiple');