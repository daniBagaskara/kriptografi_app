<?php

namespace App\Http\Controllers;

use App\Models\Enkripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnkripsiTextController extends Controller
{
    // untuk menampilkan form enkripsi
    public function showFormEnkripsi()
    {
        return view('Dashboard.formEnkripsiText');
    }

    // untuk menampilkan form dekripsi
    public function showFormDekripsi()
    {
        return view('Dashboard.formDekripsiText');
    }

    public function processEnkripsi(Request $request)
    {
        // Validasi input
        $request->validate([
            'plaintext' => 'required|string',
            'key1' => 'required|string|size:16', // Key AES harus 16 karakter
            'iv' => 'required|string|size:16',   // IV harus 16 karakter
            'method' => 'required|in:AES-128-CTR,AES-128-CBC,AES-128-CFB',
            'key2' => 'required|integer',
        ]);

        try {
            // Enkripsi AES
            $aesCiphertext = openssl_encrypt(
                $request->plaintext,
                $request->method,
                $request->key1,
                0,
                $request->iv
            );

            // Enkripsi Caesar
            $finalCiphertext = $this->caesarEncrypt($aesCiphertext, $request->key2);

            Enkripsi::create([
                'data_type' => 'text',
                'original_data' => $request->plaintext,
                'encrypted_data' => $finalCiphertext,
                'algorithm' => $request->method . ' + Caesar (key1: ' . $request->key1 . ', key2: ' . $request->key2 . ', iv: ' . $request->iv . ')',
                'user_id' => Auth::user()->id,
                'description' => 'Enkripsi'
            ]);

            return back()->with([
                'success' => 'Text berhasil dienkripsi',
                'encrypted_text' => $finalCiphertext,
                'original_text' => $request->plaintext,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal melakukan enkripsi');
        }
    }

    public function caesarEncrypt($text, $shift)
    {
        $result = '';
        $shift = $shift % 26;

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (ctype_alpha($char)) {
                $ascii = ord($char);
                $isUpper = ctype_upper($char);
                $base = $isUpper ? 65 : 97;
                $shifted = ($ascii - $base + $shift) % 26 + $base;
                $result .= chr($shifted);
            } else {
                $result .= $char;
            }
        }

        return $result;
    }


    public function processDekripsi(Request $request)
    {
        // Validasi input
        $request->validate([
            'encrypted_text' => 'required|string',
            'key1' => 'required|string|size:16', // Key AES harus 16 karakter
            'iv' => 'required|string|size:16',   // IV harus 16 karakter
            'method' => 'required|in:AES-128-CTR,AES-128-CBC,AES-128-CFB',
            'key2' => 'required|integer',
        ]);

        $caesarDecrypted = $this->caesarDecrypt($request->encrypted_text, $request->key2);

        $finalPlaintext = openssl_decrypt(
            $caesarDecrypted,
            $request->method,
            $request->key1,
            0,
            $request->iv
        );

        Enkripsi::create([
            'data_type' => 'text',
            'original_data' => $finalPlaintext,
            'encrypted_data' => $request->encrypted_text,
            'algorithm' => $request->method . ' + Caesar (key1: ' . $request->key1 . ', key2: ' . $request->key2 . ', iv: ' . $request->iv . ')',
            'user_id' => Auth::user()->id,
            'description' => 'Dekripsi',
        ]);

        return back()->with([
            'success' => 'Text berhasil didekripsi',
            'decrypted_text' => $finalPlaintext,
            'encrypted_text' => $request->encrypted_text,
        ]);
    }

    public function caesarDecrypt($text, $shift)
    {
        // Dekripsi Caesar adalah enkripsi dengan shift negatif
        return $this->caesarEncrypt($text, 26 - ($shift % 26));
    }
}
