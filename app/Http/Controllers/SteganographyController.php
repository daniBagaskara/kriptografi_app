<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SteganographyController extends Controller
{
    public function showFormHide()
    {
        return view('Dashboard.formHideMessage');
    }

    public function showFormExtract()
    {
        return view('Dashboard.formExtractMessage');
    }
    /**
     * Maksimum ukuran pesan yang diizinkan (dalam bytes)
     */
    const MAX_MESSAGE_SIZE = 1024; // 1KB

    /**
     * Menyembunyikan pesan dalam gambar menggunakan teknik LSB
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function hideMessage(Request $request)
    {
        try {
            // Validasi input dengan batasan yang lebih ketat
            $validated = $request->validate([
                'image' => [
                    'required',
                    'image',
                    'mimes:png',
                    'max:2048', // Maksimum 2MB
                ],
                'message' => [
                    'required',
                    'string',
                    'max:' . self::MAX_MESSAGE_SIZE,
                ],
            ]);

            // Load gambar
            $imagePath = $request->file('image')->getRealPath();
            $image = @imagecreatefrompng($imagePath);

            if (!$image) {
                throw new \Exception('Gagal memuat gambar. Pastikan file adalah PNG yang valid.');
            }

            // Ambil dimensi gambar
            $width = imagesx($image);
            $height = imagesy($image);

            // Konversi pesan ke binary dengan header length
            $message = $request->message;
            $binaryMessage = $this->textToBinary($message);
            $messageLength = strlen($binaryMessage);

            // Hitung kapasitas maksimum
            $maxCapacity = $width * $height;
            if ($messageLength > $maxCapacity) {
                throw new \Exception(
                    "Pesan terlalu panjang. Maksimum karakter yang dapat disimpan: " .
                        floor($maxCapacity / 8)
                );
            }

            // Simpan panjang pesan di 32 pixel pertama (32 bit integer)
            $lengthBinary = str_pad(decbin($messageLength), 32, '0', STR_PAD_LEFT);
            for ($i = 0; $i < 32; $i++) {
                $x = $i % $width;
                $y = floor($i / $width);
                $this->embedBit($image, $x, $y, $lengthBinary[$i]);
            }

            // Sisipkan pesan
            $startIndex = 32; // Mulai setelah length header
            for ($i = 0; $i < $messageLength; $i++) {
                $position = $startIndex + $i;
                $x = $position % $width;
                $y = floor($position / $width);
                $this->embedBit($image, $x, $y, $binaryMessage[$i]);
            }

            // Generate nama file unik
            $outputFileName = 'stego_' . Str::random(10) . '.png';
            $outputPath = Storage::disk('temp')->path($outputFileName);

            // Simpan gambar dengan kompresi minimal
            imagepng($image, $outputPath, 0);
            imagedestroy($image);

            return response()->download($outputPath, $outputFileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Mengkonversi text ke binary string
     * 
     * @param string $text
     * @return string
     */
    private function textToBinary($text)
    {
        $binary = '';
        $length = strlen($text);

        for ($i = 0; $i < $length; $i++) {
            $binary .= str_pad(decbin(ord($text[$i])), 8, '0', STR_PAD_LEFT);
        }

        return $binary;
    }

    /**
     * Menyisipkan satu bit ke dalam pixel
     * 
     * @param resource $image
     * @param int $x
     * @param int $y
     * @param string $bit
     * @return void
     */
    private function embedBit($image, $x, $y, $bit)
    {
        $rgb = imagecolorat($image, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        // Modifikasi LSB dari blue channel
        $newB = ($b & 0xFE) | (int)$bit;

        $newColor = imagecolorallocate($image, $r, $g, $newB);
        imagesetpixel($image, $x, $y, $newColor);
    }

    public function extractMessage(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'image' => [
                    'required',
                    'image',
                    'mimes:png',
                    'max:2048', // Maksimum 2MB
                ],
            ]);

            // Load gambar
            $imagePath = $request->file('image')->getRealPath();
            $image = @imagecreatefrompng($imagePath);


            if (!$image) {
                throw new \Exception('Gagal memuat gambar. Pastikan file adalah PNG yang valid.');
            }

            $width = imagesx($image);
            $height = imagesy($image);

            // Baca panjang pesan dari 32 pixel pertama
            $lengthBinary = '';
            for ($i = 0; $i < 32; $i++) {
                $x = $i % $width;
                $y = floor($i / $width);
                $lengthBinary .= $this->extractBit($image, $x, $y);
            }

            // Konversi binary length ke integer
            $messageLength = bindec($lengthBinary);

            // Validasi panjang pesan
            if ($messageLength <= 0 || $messageLength > ($width * $height - 32)) {
                throw new \Exception('Format pesan tidak valid atau gambar telah rusak.');
            }

            // Ekstrak binary message
            $binaryMessage = '';
            $startIndex = 32; // Mulai setelah length header
            for ($i = 0; $i < $messageLength; $i++) {
                $position = $startIndex + $i;
                $x = $position % $width;
                $y = floor($position / $width);
                $binaryMessage .= $this->extractBit($image, $x, $y);
            }

            // Konversi binary ke text
            $message = $this->binaryToText($binaryMessage);

            // Bersihkan resource
            imagedestroy($image);

            // Return hasil
            return back()->with('message', $message);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Mengekstrak satu bit dari pixel
     * 
     * @param resource $image
     * @param int $x
     * @param int $y
     * @return string
     */
    private function extractBit($image, $x, $y)
    {
        $rgb = imagecolorat($image, $x, $y);
        $b = $rgb & 0xFF; // Ambil blue channel
        return (string)($b & 1); // Return LSB
    }

    /**
     * Konversi binary string ke text
     * 
     * @param string $binary
     * @return string
     */
    private function binaryToText($binary)
    {
        $text = '';

        // Proses setiap 8 bit (1 byte) untuk dikonversi ke karakter
        for ($i = 0; $i < strlen($binary); $i += 8) {
            $chunk = substr($binary, $i, 8);
            if (strlen($chunk) == 8) {
                $charCode = bindec($chunk);
                // Validasi karakter yang valid
                if ($charCode > 0 && $charCode <= 127) { // ASCII printable
                    $text .= chr($charCode);
                } else {
                    throw new \Exception('Ditemukan karakter tidak valid dalam pesan.');
                }
            }
        }

        return $text;
    }
}
