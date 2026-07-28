<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ISI DATA USER (AKUN LOGIN)
        DB::table('users')->insert([
            [
                'name' => 'Admin Sarpras',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kasubag UIN',
                'email' => 'kasubag@gmail.com',
                'password' => Hash::make('kasubag123'),
                'role' => 'kasubag',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hidayah Herliyani',
                'email' => 'hidayah@gmail.com',
                'password' => Hash::make('hidayah123'),
                'role' => 'user', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 2. ISI DATA PANDUAN APLIKASI (GUIDES)
        DB::table('guides')->insert([
            [
                'title' => 'Cara Melaporkan Kerusakan Barang',
                'content' => '1. Login menggunakan akun Mahasiswa yang telah terdaftar.<br>2. Klik tombol "Laporkan Kerusakan" pada halaman utama atau dashboard.<br>3. Isi formulir laporan dengan lengkap mulai dari lokasi gedung, nama barang, beserta deskripsi kerusakannya.<br>4. Unggah foto bukti kerusakan fasilitas tersebut.<br>5. Klik tombol "Kirim Laporan".',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cara Melacak Status Perbaikan',
                'content' => '1. Masuk ke menu "Riwayat Laporan" atau dashboard utama.<br>2. Perhatikan kolom status pada tabel aduan Anda.<br>3. Status "Pending" berarti laporan baru diterima, "Proses" berarti tim sarpras sedang memperbaiki, dan "Selesai" berarti fasilitas sudah diperbaiki dan berfungsi kembali.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}