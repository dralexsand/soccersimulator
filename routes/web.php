<?php

use App\Http\Controllers\ShowController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ShowController::class, 'index'])->name('home');
Route::get('/translation', [ShowController::class, 'translation'])->name('translation');
Route::get('/stats', [ShowController::class, 'stats'])->name('stats');
