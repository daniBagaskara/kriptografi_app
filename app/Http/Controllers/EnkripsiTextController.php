<?php

namespace App\Http\Controllers;

use App\Models\Enkripsi;
use Illuminate\Http\Request;

class EnkripsiTextController extends Controller
{
    public function showForm()
    {
        return view('Dashboard.formEnkripsiText');
    }

    public function process(Request $request)
    {

        $request->validate([
            'plaintext' => 'required|string',
            'key1' => 'required|string', // Key untuk AES
            'key2' => 'required|integer', // Shift untuk Caesar
        ]);

        $plaintext = $request->input('plaintext');
        $key_AES = $request->input('key1');
        $key_caesar = $request->input('key2');

        $aesCiphertext = $this->AESEncrypt($plaintext, $key_AES);

        $finalCiphertext = $this->caesarEncrypt($aesCiphertext, $key_caesar);

        Enkripsi::create([
            'data_type' => 'text',
            'original_data' => $plaintext,
            'encrypted_data' => $finalCiphertext,
            'algorithm' => 'AES-256-ECB + Caesar'
        ]);

        return back()->with([
            'success' => 'Text berhasil dienkripsi',
            'encrypted_text' => $finalCiphertext,
            'original_text' => $request->plaintext
        ]);
    }

    public function AESEncrypt($text, $key)
    {
        $method = 'AES-256-ECB';
        $key = hash('sha256', $key, true); // Hash kunci menjadi 256-bit

        return openssl_encrypt($text, $method, $key, 0);
    }

    public function caesarEncrypt($text, $shift)
    {
        $result = '';
        $shift = intval($shift) % 26;

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];

            if (ctype_alpha($char)) {
                $asciiOffset = ctype_upper($char) ? 65 : 97;
                $shifted = (($asciiOffset + ord($char) - $asciiOffset + $shift) % 26) + $asciiOffset;
                $result .= chr($shifted);
            } else {
                $result .= $char;
            }
        }

        return $result;
    }

    // public function decrypt(Request $request)
    // {
    //     $request->validate([
    //         'ciphertext' => 'required|string',
    //         'key1' => 'required|string', // Key untuk AES
    //         'key2' => 'required|integer', // Shift untuk Caesar
    //     ]);

    //     $ciphertext = $request->input('ciphertext');
    //     $key_AES = $request->input('key1');
    //     $key_caesar = $request->input('key2');

    //     // Langkah 1: Dekripsi Caesar
    //     $caesarDecrypted = $this->caesarDecrypt($ciphertext, $key_caesar);

    //     // Langkah 2: Dekripsi AES
    //     $finalPlaintext = $this->AESDecrypt($caesarDecrypted, $key_AES);

    //     return view('Dashboard.result', compact('finalPlaintext'));
    // }

    // public function AESDecrypt($text, $key)
    // {
    //     $method = 'AES-256-CBC';
    //     $key = hash('sha256', $key, true); // Generate kunci AES

    //     // Decode teks dari Base64
    //     $data = base64_decode($text);

    //     // Ekstrak IV dan teks terenkripsi
    //     $ivLength = openssl_cipher_iv_length($method);
    //     $iv = substr($data, 0, $ivLength);
    //     $encryptedText = substr($data, $ivLength);

    //     // Dekripsi menggunakan AES
    //     return openssl_decrypt($encryptedText, $method, $key, 0, $iv);
    // }

    // public function caesarDecrypt($text, $shift)
    // {
    //     $result = '';
    //     $shift = intval($shift) % 26;

    //     for ($i = 0; $i < strlen($text); $i++) {
    //         $char = $text[$i];

    //         if (ctype_alpha($char)) {
    //             $asciiOffset = ctype_upper($char) ? 65 : 97;
    //             $shifted = (($asciiOffset + ord($char) - $asciiOffset - $shift + 26) % 26) + $asciiOffset;
    //             $result .= chr($shifted);
    //         } else {
    //             $result .= $char;
    //         }
    //     }

    //     return $result;
    // }
}
