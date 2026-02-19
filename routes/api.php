<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibrayController;
use App\Http\Controllers\LoanController;

Route::get('/users', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('books')->group(function () {
    Route::get('/', [LibrayController::class, 'index'])->name('books.index');
    Route::get('/{book}', [LibrayController::class, 'show'])->name('books.show');
});

Route::prefix('loans')->group(function () {
    Route::post('/', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/', [LoanController::class, 'index'])->name('loans.index');
});

Route::post('/returns/{loan_id}', [LoanController::class, 'return'])->name('loans.return');
