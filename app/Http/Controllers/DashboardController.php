<?php

namespace App\Http\Controllers;

use App\Models\Enkripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total untuk masing-masing jenis data
        $totalTexts = Enkripsi::where('data_type', 'text')->where('user_id', Auth::user()->id)->count();
        $totalImages = Enkripsi::where('data_type', 'image')->where('user_id', Auth::user()->id)->count();
        $totalFiles = Enkripsi::where('data_type', 'file')->where('user_id', Auth::user()->id)->count();

        // Ambil semua data untuk fitur history (diurutkan dari terbaru)
        $history = Enkripsi::select('id', 'data_type', 'algorithm', 'created_at', 'original_data', 'description')->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Kirimkan data ke view
        return view('Dashboard.main', [
            'totalTexts' => $totalTexts ?? 0,
            'totalImages' => $totalImages ?? 0,
            'totalFiles' => $totalFiles ?? 0,
            'historys' => $history ?? [], // Tambahkan history ke view
        ]);
    }

    public function download($id)
    {
        $enkripsi = Enkripsi::findOrFail($id);

        if ($enkripsi->data_type === 'text') {
            $body =  "Process Name : " . $enkripsi->description . "\n" .
                "Time:" . $enkripsi->created_at . "\n" .
                "Original Data: " . $enkripsi->original_data . "\n" .
                "Encrypted Data: " . $enkripsi->encrypted_data . "\n" .
                "Algorithm: " . $enkripsi->algorithm . "\n" .
                "Data Type: " . $enkripsi->data_type;
        } else {
            $body =  "Process Name : " . $enkripsi->description . "\n" .
                "Time:" . $enkripsi->created_at . "\n" .
                "Original Data: " . $enkripsi->original_data . "\n" .
                "Algorithm: " . $enkripsi->algorithm . "\n" .
                "Data Type: " . $enkripsi->data_type;
        }
        $fileName = 'encrypted_data' . $id . '.txt';
        $headers = [
            'Content-Type' => 'text/plain',
        ];

        return response(
            $body,
            200,
            $headers
        )->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
