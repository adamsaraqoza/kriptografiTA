<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;

Route::get('/', function () {
    return view('home');
});

Route::post('/encrypt',
 [CryptoController::class, 'encrypt'])->name('encrypt');

 Route::post('/decrypt',
 [CryptoController::class, 'decrypt'])->name('decrypt');

