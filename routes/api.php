<?php

use App\Http\Controllers\NilaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('nilaiRT',[NilaiController::class,'rt']);
Route::get('nilaiST',[NilaiController::class,'st']);
