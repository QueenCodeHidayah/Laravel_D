<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Mass Assignment: Memberi izin kolom mana saja yang boleh diisi
    protected $fillable = [
        'user_id',
        'lantai',
        'wing',
        'ruangan',
        'nama_barang',
        'tingkat_kerusakan',
        'deskripsi',
        'foto',
        'status',
    ];

    // Relasi: Menghubungkan laporan ke User (Pelapor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}