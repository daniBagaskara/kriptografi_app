<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enkripsi;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total untuk masing-masing jenis data
        $totalTexts = Enkripsi::where('data_type', 'text')->count();
        $totalImages = Enkripsi::where('data_type', 'image')->count();
        $totalFiles = Enkripsi::where('data_type', 'file')->count();

        // Ambil semua data untuk fitur history (diurutkan dari terbaru)
        $history = Enkripsi::select('data_type', 'algorithm', 'created_at', 'original_data')
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
}
