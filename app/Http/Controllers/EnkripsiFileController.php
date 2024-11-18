<?php

namespace App\Http\Controllers;

use App\Models\Enkripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;


class EnkripsiFileController extends Controller
{
    public function showFormEnkripsi()
    {
        return view('Dashboard.formEnkripsiFile');
    }

    public function showFormDekripsi()
    {
        return view('Dashboard.formDekripsiFile');
    }

    public function processEnkripsi(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileContent = file_get_contents($file->getRealPath());

        // Generate kunci
        $key = bin2hex(random_bytes(32));

        // Enkripsi file
        $encryptedContent = $this->encryptContent($fileContent, $key);

        // Buat file metadata yang berisi informasi enkripsi
        $metadata = [
            'original_name' => $originalName,
            'encryption_method' => 'AES-256-CBC',
            'date_encrypted' => now()->toString(),
            'instructions' => "File ini telah dienkripsi menggunakan metode AES-256-CBC." .
                "Gunakan kunci yang telah disediakan untuk mendekripsi file ini." .
                "Anda dapat mengunduh kunci tersebut di halaman dashboard." .
                "Peringatan: Jangan pernah mengubah file ini jika ingin mendekripsinya."
        ];


        // Gabung metadata dengan file terenkripsi
        $finalContent = json_encode($metadata, JSON_PRETTY_PRINT) . "\n\n\n\n===ENCRYPTED_CONTENT===\n" . $encryptedContent;

        Enkripsi::create([
            'data_type' => 'file',
            'algorithm' => 'AES-256-CBC | key: ' . $key,
            'original_data' => $originalName,
            'encrypted_data' => $finalContent,
            'user_id' => Auth::id(),
            'description' => 'Enkripsi'
        ]);

        // Store encryption key in session and download file
        return response()->streamDownload(function () use ($finalContent, $key) {
            session()->flash('key', $key);
            echo $finalContent;
        }, $originalName . '.encrypted', [
            'Content-Type' => 'application/octet-stream',
        ]);
    }

    private function encryptContent($content, $key)
    {
        $cipher = "AES-256-CBC";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);

        $encrypted = openssl_encrypt(
            $content,
            $cipher,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        return base64_encode($iv . $encrypted);
    }

    public function processDekripsi(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'key' => 'required|string|size:64' // 32 bytes in hex = 64 characters
        ]);

        $file = $request->file('file');
        $key = $request->input('key');

        try {
            // Baca konten file
            $fileContent = file_get_contents($file->getRealPath());

            // Pisahkan metadata dan konten terenkripsi
            [$metadata, $encryptedContent] = $this->parseEncryptedFile($fileContent);

            // Validasi metadata
            if (!$metadata || !isset($metadata['original_name']) || !isset($metadata['encryption_method'])) {
                throw new \Exception('Invalid encrypted file format');
            }

            // Pastikan metode enkripsi sesuai
            if ($metadata['encryption_method'] !== 'AES-256-CBC') {
                throw new \Exception('Unsupported encryption method');
            }

            // Dekripsi konten
            $decryptedContent = $this->decryptContent($encryptedContent, $key);

            // Simpan record dekripsi ke database
            Enkripsi::create([
                'data_type' => 'file',
                'algorithm' => 'AES-256-CBC' . ' | key: ' . $key,
                'original_data' => $metadata['original_name'],
                'encrypted_data' => $fileContent,
                'user_id' => Auth::id(),
                'description' => 'Dekripsi'
            ]);

            // Return file yang sudah didekripsi
            return response()->streamDownload(function () use ($decryptedContent) {
                echo $decryptedContent;
            }, $metadata['original_name'], [
                'Content-Type' => 'application/octet-stream',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to decrypt file: ' . $e->getMessage()]);
        }
    }

    private function parseEncryptedFile($fileContent)
    {
        // Pisahkan metadata dari konten terenkripsi
        $parts = explode("\n===ENCRYPTED_CONTENT===\n", $fileContent, 2);

        if (count($parts) !== 2) {
            throw new \Exception('Invalid file format');
        }

        $metadata = json_decode(trim($parts[0]), true);
        $encryptedContent = trim($parts[1]);

        return [$metadata, $encryptedContent];
    }

    private function decryptContent($encryptedContent, $key)
    {
        $cipher = "AES-256-CBC";
        $ivlen = openssl_cipher_iv_length($cipher);

        // Decode base64
        $combined = base64_decode($encryptedContent);

        // Ekstrak IV dan konten terenkripsi
        $iv = substr($combined, 0, $ivlen);
        $encrypted = substr($combined, $ivlen);

        // Dekripsi
        $decrypted = openssl_decrypt(
            $encrypted,
            $cipher,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($decrypted === false) {
            throw new \Exception('Decryption failed. Invalid key or corrupted data.');
        }

        return $decrypted;
    }
}
