<?php

namespace App\Http\Controllers;

use Exception;
use App\Libraries\AES;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class CryptoController extends Controller
{
    /**
     * Fungsi untuk menangani enkripsi AES.
     */
    public function encryptAes(Request $request)
    {
        $validated = $request->validate([
            'plain_text' => 'required|string',
            'secret_key_aes' => 'required|string|size:16',
        ]);

        $plainText = $validated['plain_text'];
        $secretKeyAES = $validated['secret_key_aes'];

        try {
            $aes = new AES($secretKeyAES);
            $encryptedText = $aes->encrypt($plainText);
            $encryptedTextBase64 = base64_encode($encryptedText);

            return response()->json([
                'status' => 'success',
                'message' => 'Enkripsi berhasil!',
                'encrypted_text' => $encryptedTextBase64,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Enkripsi AES gagal: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Fungsi untuk menangani dekripsi AES.
     */
    public function decryptAes(Request $request)
    {
        $validated = $request->validate([
            'decrypted_chiper_text' => 'required|string',
            'secret_key_aes' => 'required|string|size:16',
        ]);

        $encryptedText = $validated['decrypted_chiper_text'];
        $secretKeyAES = $validated['secret_key_aes'];

        try {
            $aes = new AES($secretKeyAES);
            $decryptedText = $aes->decrypt(base64_decode($encryptedText));

            return response()->json([
                'status' => 'success',
                'message' => 'Dekripsi berhasil!',
                'decrypted_text' => $decryptedText,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dekripsi AES gagal: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Fungsi untuk menangani enkripsi LSB.
     */
    public function encryptLsb(Request $request)
    {
        $validated = $request->validate([
            'chiper_text' => 'required|string',
            'image' => 'required|file|image|mimes:png|max:10240',
        ]);

        $chipperTextBase64 = $validated['chiper_text'];

        try {
            // Dekode Base64 dari chiper_text
            $chipperText = base64_decode($chipperTextBase64, true);
            if ($chipperText === false) {
                throw new Exception('Gagal mendekode Base64 dari chiper text.');
            }

            $image = $request->file('image');
            $imagePath = $image->getPathname();
            $outputFilename = 'encoded_' . uniqid() . '.png';
            $outputPath = storage_path('app/public/' . $outputFilename);

            // Jalankan embed LSB dengan teks mentah
            $this->embedLSB($imagePath, $chipperText, $outputPath);

            // Verifikasi file output
            if (!file_exists($outputPath) || mime_content_type($outputPath) !== 'image/png') {
                throw new Exception('Gagal menghasilkan file gambar PNG.');
            }

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
     * Fungsi untuk menangani dekripsi LSB.
     */
    public function decryptLsb(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|file|image|mimes:png|max:10240',
            // 'secret_key_AES' => 'nullable|string|size:16',
        ]);

        try {
            $imagePath = $request->file('image')->getPathname();
            $secretKeyAES = $validated['secret_key_AES'] ?? null;

            // Ekstrak teks dari gambar
            $encryptedText = $this->extractLSB($imagePath);

            // Encode kembali ke Base64 untuk ditampilkan
            $encryptedTextBase64 = base64_encode($encryptedText);

            $response = [
                'status' => 'success',
                'message' => 'Ekstraksi LSB berhasil!',
                'encrypted_text' => $encryptedTextBase64,
            ];

            // Jika kunci AES diberikan, lakukan dekripsi
            // if ($secretKeyAES) {
            //     $aes = new AES($secretKeyAES);
            //     $decryptedText = $aes->decrypt($encryptedText);
            //     $response['decrypted_text'] = $decryptedText;
            //     $response['message'] = 'Ekstraksi LSB dan dekripsi AES berhasil!';
            // }

            return response()->json($response);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dekripsi LSB gagal: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Menyisipkan data ke dalam gambar PNG menggunakan LSB dengan pengacakan XOR.
     */
    private function embedLSB($imagePath, $data, $outputPath)
    {
        if (!file_exists($imagePath) || !($img = @imagecreatefrompng($imagePath))) {
            throw new Exception('Gagal membuka gambar atau format tidak didukung.');
        }

        $width = imagesx($img);
        $height = imagesy($img);

        // Tambahkan penanda MAGIC123
        $magic = 'MAGIC123';
        $dataLength = strlen($data);
        $lengthBinary = str_pad(decbin($dataLength), 32, '0', STR_PAD_LEFT);
        $binaryData = '';
        foreach (str_split($magic) as $char) {
            $binaryData .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
        }
        $binaryData .= $lengthBinary;
        foreach (str_split($data) as $char) {
            $binaryData .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
        }

        $len = strlen($binaryData);
        $requiredPixels = ceil($len / 3);

        Log::info("embedLSB: Magic='$magic', dataLength=$dataLength, totalBits=$len, requiredPixels=$requiredPixels, availablePixels=" . ($width * $height));

        if ($requiredPixels > $width * $height) {
            imagedestroy($img);
            throw new Exception('Gambar terlalu kecil untuk menampung data.');
        }

        $dataIndex = 0;

        for ($y = 0; $y < $height && $dataIndex < $len; $y++) {
            for ($x = 0; $x < $width && $dataIndex < $len; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $channels = [&$r, &$g, &$b];
                foreach ($channels as &$channel) {
                    if ($dataIndex >= $len) break;

                    $bit5 = ($channel >> 3) & 0x01;
                    $dataBit = (int)$binaryData[$dataIndex++];

                    // Set bit6 sehingga (bit5 ^ bit6) = dataBit
                    $bit6 = $bit5 ^ $dataBit;
                    $channel = ($channel & ~(1 << 2)) | ($bit6 << 2);
                }

                $newColor = imagecolorallocate($img, $r, $g, $b);
                if ($newColor === false) {
                    imagedestroy($img);
                    throw new Exception('Gagal mengalokasikan warna.');
                }
                imagesetpixel($img, $x, $y, $newColor);
            }
        }

        if (!imagepng($img, $outputPath)) {
            imagedestroy($img);
            throw new Exception('Gagal menyimpan gambar output.');
        }
        Log::info("embedLSB: Output image saved at $outputPath, size=" . filesize($outputPath));
        imagedestroy($img);
    }

    /**
     * Mengekstrak data dari gambar PNG menggunakan LSB dengan pengacakan XOR.
     */
    private function extractLSB($imagePath)
    {
        if (!file_exists($imagePath) || !($img = @imagecreatefrompng($imagePath))) {
            throw new Exception('Gagal membuka gambar atau format tidak didukung.');
        }

        $width = imagesx($img);
        $height = imagesy($img);
        $binaryData = '';
        $dataIndex = 0;

        // Baca semua bit secara berurutan
        for ($y = 0; $y < $height && strlen($binaryData) < 1048576 * 8; $y++) {
            for ($x = 0; $x < $width && strlen($binaryData) < 1048576 * 8; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $channels = [$r, $g, $b];
                foreach ($channels as $channel) {
                    if (strlen($binaryData) >= 1048576 * 8) break;
                    $bit5 = ($channel >> 3) & 0x01;
                    $bit6 = ($channel >> 2) & 0x01;
                    $binaryData .= $bit5 ^ $bit6;
                    $dataIndex++;
                }
            }
        }

        // Ekstrak penanda MAGIC123 (64 bit)
        if (strlen($binaryData) < 64) {
            imagedestroy($img);
            throw new Exception('Gambar tidak cukup besar untuk menampung penanda.');
        }
        $magic = '';
        for ($i = 0; $i < 64; $i += 8) {
            $byte = substr($binaryData, $i, 8);
            $magic .= chr(bindec($byte));
        }
        Log::info("extractLSB: Magic marker found: '$magic'");
        if ($magic !== 'MAGIC123') {
            imagedestroy($img);
            throw new Exception('Gambar tidak mengandung data LSB valid (penanda tidak cocok).');
        }

        // Ekstrak panjang data (32 bit)
        if (strlen($binaryData) < 64 + 32) {
            imagedestroy($img);
            throw new Exception('Gambar tidak cukup besar untuk menampung panjang data.');
        }
        $lengthBinary = substr($binaryData, 64, 32);
        $dataLength = bindec($lengthBinary);
        Log::info("extractLSB: dataLength=$dataLength, requiredPixels=" . ceil(($dataLength * 8) / 3) . ", availablePixels=" . ($width * $height));
        if ($dataLength > 1048576 || $dataLength < 0) {
            imagedestroy($img);
            throw new Exception('Panjang data tidak valid: ' . $dataLength);
        }

        // Validasi piksel yang diperlukan
        $requiredPixels = ceil(($dataLength * 8 + 96) / 3); // 64 bit penanda + 32 bit panjang
        if ($requiredPixels > $width * $height) {
            imagedestroy($img);
            throw new Exception('Gambar tidak cukup besar untuk data. DataLength: ' . $dataLength . ', Required Pixels: ' . $requiredPixels . ', Available Pixels: ' . ($width * $height));
        }

        // Ekstrak data
        if (strlen($binaryData) < 64 + 32 + $dataLength * 8) {
            imagedestroy($img);
            throw new Exception('Gambar tidak cukup besar untuk menampung data.');
        }
        $dataBinary = substr($binaryData, 64 + 32, $dataLength * 8);
        $result = '';
        for ($i = 0; $i < strlen($dataBinary); $i += 8) {
            $byte = substr($dataBinary, $i, 8);
            $result .= chr(bindec($byte));
        }

        imagedestroy($img);
        return $result;
    }
}
