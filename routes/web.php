<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;

Route::get('/', function () {
    return view('home');
});

Route::post(
    '/encrypt-aes',
    [CryptoController::class, 'encryptAes']
)->name('encryptAes');

Route::post(
    '/encrypt-lsb',
    [CryptoController::class, 'encryptLsb']
)->name('encryptLsb');

Route::post(
    '/decrypt',
    [CryptoController::class, 'decrypt']
)->name('decrypt');

Route::get('/download-lsb/{filename}', [CryptoController::class, 'downloadLsb'])->name('download.lsb');
