<?php

use App\Http\Controllers\Api\v1\GameController;
use Illuminate\Support\Facades\Route;


Route::get('game/generate', [GameController::class, 'run']);
Route::get('game/clear', [GameController::class, 'clear']);

