<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guide;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama agar tidak duplikat saat di-seed ulang
        Guide::truncate();

        Guide::create([
            'judul' => 'Gunakan Seperlunya',
            'kategori' => 'Kelistrikan',
            'isi' => 'Matikan AC dan Lampu jika ruangan kelas atau laboratorium sudah tidak digunakan lagi.',
            'ikon' => '💡'
        ]);

        Guide::create([
            'judul' => 'No Food & Drink',
            'kategori' => 'Larangan',
            'isi' => 'Hindari membawa makanan atau minuman ke dalam Laboratorium Komputer untuk mencegah tumpahan pada perangkat.',
            'ikon' => '🥪'
        ]);

        Guide::create([
            'judul' => 'Lapor Segera',
            'kategori' => 'Prosedur',
            'isi' => 'Jika melihat kerusakan kecil (seperti kabel terkelupas), segera lapor lewat sistem ini sebelum kerusakan menjadi parah.',
            'ikon' => '⌨️'
        ]);
    }
}