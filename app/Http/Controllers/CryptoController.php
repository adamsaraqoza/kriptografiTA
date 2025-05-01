<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class CryptoController extends Controller
{
    /**
     * Fungsi untuk menangani enkripsi.
     */
    public function encrypt(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'plain_text' => 'required|string', // Plain text wajib diisi
            'secret_key_aes' => 'required|string', // Secret key AES wajib diisi
            'secret_key_lsb' => 'required|string', // Secret key AES wajib diisi
            'image' => 'nullable|file|image', // Gambar opsional, harus berupa file gambar
        ]);
        dd($validated);
        
        // Simpan plain text dan secret key
        $plainText = $validated['plain_text'];
        $secretKeyAES = $validated['secret_key_aes'];

        // Enkripsi menggunakan AES (contoh sederhana)
        $encryptedText = Crypt::encryptString($plainText);

        // Jika ada gambar, simpan di folder storage
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Simpan di folder storage/app/public/images
        } else {
            $imagePath = null;
        }

        // Kirim respons JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Enkripsi berhasil!',
            'encrypted_text' => $encryptedText,
            'image_path' => $imagePath ? Storage::url($imagePath) : null, // URL gambar jika ada
        ]);
    }

    /**
     * Fungsi untuk menangani dekripsi.
     */
    public function decrypt(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'encrypted_text' => 'required|string', // Encrypted text wajib diisi
            'secret_key_aes' => 'required|string', // Secret key AES wajib diisi
        ]);

        // Dekripsi menggunakan AES
        try {
            $decryptedText = Crypt::decryptString($validated['encrypted_text']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dekripsi gagal. Pastikan kunci rahasia benar.',
            ], 400);
        }

        // Kirim respons JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Dekripsi berhasil!',
            'decrypted_text' => $decryptedText,
        ]);
    }
}