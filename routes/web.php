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
    '/decrypt-aes',
    [CryptoController::class, 'decryptAes']
)->name('decryptAes');

Route::post(
    '/decrypt-lsb',
    [CryptoController::class, 'decryptLsb']
)->name('decryptLsb');

Route::get('/download-lsb/{filename}', [CryptoController::class, 'downloadLsb'])->name('download.lsb');
