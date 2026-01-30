<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;

Route::get('/', function () { return view('welcome'); });

Route::get('/cards', [CardController::class, 'index'])->name('cards.index');
Route::get('/cards/{card}', [CardController::class, 'show'])->name('cards.show');


