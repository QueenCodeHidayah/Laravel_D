<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Review; // 👈 PENTING: Jangan lupa panggil model Review di atas!

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung rata-rata bintang dari semua review yang masuk
        // Kita gunakan rumus round() agar hasilnya bulat indah (misal: 4.2 atau 4.5)
        $rataRataBintang = round(Review::avg('rating'), 1) ?? 0;

        // 2. Kirim variabel $rataRataBintang ke dalam view dashboard
        return view('dashboard', compact('rataRataBintang'));
    }
}