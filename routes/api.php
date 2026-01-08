<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */


Route::get('/cards', [APIController::class, "listCards"]);
Route::get('/cards/{id}', [APIController::class, "searchCard"]);
Route::post('/cards/import', [APIController::class, "importCard"]);
Route::put('/cards/{id}', [APIController::class, "updateCard"]);
Route::delete('/cards/{id}', [APIController::class, "deleteCard"]);



