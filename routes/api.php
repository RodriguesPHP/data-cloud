<?php

use App\Http\Controllers\DatabaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/{database}/query',[DatabaseController::class,'query']);
Route::get('/{database}/structure',[DatabaseController::class,'getStructure']);
Route::post('/{database}/insert',[DatabaseController::class,'insert']);