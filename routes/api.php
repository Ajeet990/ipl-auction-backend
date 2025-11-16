<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\BidController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::prefix('player')->group(function () {
    Route::get('/', [PlayerController::class, 'index']);
    Route::post('/create', [PlayerController::class, 'store']);
    Route::post('/mark-current', [PlayerController::class, 'markCurrentBidPlayer']);
    // Route::get('/{id}', [PlayerController::class, 'show']);
    // Route::put('/update/{id}', [PlayerController::class, 'update']);
    // Route::delete('/{id}', [PlayerController::class, 'destroy']);
    Route::get('/current-bidder', [PlayerController::class, 'getCurrentBidPlayer']);
});

Route::prefix('bid')->group(function () {
    // Route::get('/', [BidController::class, 'index']);
    Route::post('/submit-bid', [BidController::class, 'store']);
    // Route::get('/{id}', [BidController::class, 'show']);
    // Route::put('/update/{id}', [BidController::class, 'update']);
    // Route::delete('/{id}', [BidController::class, 'destroy']);
});
