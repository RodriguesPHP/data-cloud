<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('dashboard')->middleware('auth');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/login',[AuthController::class,'login'])->name('login');

Route::group(['prefix'=>'database','middleware'=>'auth'],function(){
    Route::get('/',[\App\Http\Controllers\DatabaseController::class,'index'])->name('database');
    Route::post('/',[\App\Http\Controllers\DatabaseController::class,'store'])->name('database');
    Route::get('/view/{database}',[\App\Http\Controllers\DatabaseController::class,'edit'])->name('view.database');
    Route::post('/view/{database}',[\App\Http\Controllers\DatabaseController::class,'upload'])->name('upload.database');
    Route::get('/view/{database}/download',[\App\Http\Controllers\DatabaseController::class,'exportar'])->name('exportar.database');
    Route::post('/view/{database}/truncate',[\App\Http\Controllers\DatabaseController::class,'truncate'])->name('truncate.database');
    Route::post('/view/{database}/delete',[\App\Http\Controllers\DatabaseController::class,'delete'])->name('delete.database');
});
