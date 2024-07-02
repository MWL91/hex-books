<?php

use App\Http\Controllers\CreateBookStockController;
use App\Http\Controllers\RentBookController;
use App\Http\Controllers\ReturnBookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('book_stock', CreateBookStockController::class);
Route::post('rent_book', RentBookController::class);
Route::post('return_book/{rent_id}', ReturnBookController::class);
