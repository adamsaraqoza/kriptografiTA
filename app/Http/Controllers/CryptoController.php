<?php

namespace App\Http\Controllers;

use Exception;
use App\Libraries\AES;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class CryptoController extends Controller
{
    /**
     * Fungsi untuk menangani enkripsi AES.
     */
    public function encryptAes(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'plain_text' => 'required|string',
            'secret_key_aes' => 'required|string',
        ]);

        $plainText = $validated['plain_text'];
        $secretKeyAES = $validated['secret_key_aes'];

        // Pastikan panjang secret key adalah 16 karakter untuk AES-128
        if (strlen($secretKeyAES) !== 16) {
            return response()->json([
                'status' => 'error',
                'message' => 'Secret key harus tepat 16 karakter untuk AES-128.',
            ], 400);
        }

        // Buat instance AES
        $aes = new AES($secretKeyAES);

        // Enkripsi plaintext
        $encryptedText = $aes->encrypt($plainText);

        // Encode ke Base64 agar aman saat dikirim via JSON
        $encryptedTextBase64 = base64_encode($encryptedText);

        // Kirim respons
        return response()->json([
            'status' => 'success',
            'message' => 'Enkripsi berhasil!',
            'encrypted_text' => $encryptedTextBase64,
        ]);
    }

    /**
     * Fungsi untuk menangani enkripsi LSB.
     */
    public function encryptLsb(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'chiper_text' => 'required|string',
            'image' => 'required|file|image|mimes:png|max:10240', // Maks 2MB
        ]);

        $chipperTextAes = $validated['chiper_text'];

        // Simpan gambar sementara
        try {
            $image = $request->file('image');
            $imagePath = $image->getPathname();
            $outputFilename = 'encoded_' . uniqid() . '.png';
            $outputPath = storage_path('app/public/' . $outputFilename);

            // Jalankan embed LSB
            $this->embedLSB($imagePath, $chipperTextAes, $outputPath);

            // Verifikasi file output
            if (!file_exists($outputPath) || mime_content_type($outputPath) !== 'image/png') {
                throw new Exception('Gagal menghasilkan file gambar PNG.');
            }

            // Kirim respons
            return response()->json([
                'status' => 'success',
                'message' => 'Enkripsi LSB berhasil!',
                'lsb_image_url' => Storage::url($outputFilename),
                'download_url' => route('download.lsb', ['filename' => $outputFilename]),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal melakukan enkripsi LSB: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Fungsi untuk mengunduh file gambar LSB.
     */
    public function downloadLsb($filename)
    {
        $filePath = storage_path('app/public/' . $filename);
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($filePath, 'encoded_image.png', [
            'Content-Type' => 'image/png',
        ]);
    }

    /**
     * Menyisipkan data ke dalam gambar PNG menggunakan LSB dengan pengacakan XOR.
     */
    private function embedLSB($imagePath, $data, $outputPath)
    {
        // Validasi file gambar
        if (!file_exists($imagePath) || !($img = @imagecreatefrompng($imagePath))) {
            throw new Exception('Gagal membuka gambar atau format tidak didukung.');
        }

        $width = imagesx($img);
        $height = imagesy($img);

        // Konversi data ke biner
        $dataLength = strlen($data);
        $lengthBinary = str_pad(decbin($dataLength), 32, '0', STR_PAD_LEFT);
        $binaryData = $lengthBinary;
        foreach (str_split($data) as $char) {
            $binaryData .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
        }

        $len = strlen($binaryData);
        $requiredPixels = ceil($len / 3);

        // Validasi kapasitas gambar
        if ($requiredPixels > $width * $height) {
            imagedestroy($img);
            throw new Exception('Gambar terlalu kecil untuk menampung data.');
        }

        $dataIndex = 0;

        // Iterasi piksel
        for ($y = 0; $y < $height && $dataIndex < $len; $y++) {
            for ($x = 0; $x < $width && $dataIndex < $len; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                // Proses setiap saluran (R, G, B)
                $channels = [&$r, &$g, &$b];
                foreach ($channels as &$channel) {
                    if ($dataIndex >= $len) {
                        break;
                    }

                    // Ambil bit 5, 6, 7, 8
                    $bit8 = $channel & 0x01;
                    $bit7 = ($channel >> 1) & 0x01;
                    $bit6 = ($channel >> 2) & 0x01;
                    $bit5 = ($channel >> 3) & 0x01;

                    // Pengacakan XOR
                    $newBit8 = $bit7 ^ $bit8;
                    $newBit7 = $bit6 ^ $bit7;
                    $newBit6 = $bit5 ^ $bit6;

                    // Bit data yang akan disisipkan
                    $dataBit = (int)$binaryData[$dataIndex++];

                    // Jika bit 6 baru tidak sama dengan bit data, ubah bit 6 asli
                    if ($newBit6 !== $dataBit) {
                        $channel = ($channel & ~(1 << 2)) | ($dataBit << 2);
                    }
                }

                // Set warna baru
                $newColor = imagecolorallocate($img, $r, $g, $b);
                if ($newColor === false) {
                    imagedestroy($img);
                    throw new Exception('Gagal mengalokasikan warna.');
                }
                imagesetpixel($img, $x, $y, $newColor);
            }
        }

        // Simpan dan bersihkan
        if (!imagepng($img, $outputPath)) {
            imagedestroy($img);
            throw new Exception('Gagal menyimpan gambar output.');
        }
        imagedestroy($img);
    }
}
