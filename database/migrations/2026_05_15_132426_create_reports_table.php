<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang melapor
        $table->string('lantai');
        $table->string('ruangan');
        $table->string('nama_barang');
        $table->enum('tingkat_kerusakan', ['Ringan', 'Sedang', 'Parah']);
        $table->text('deskripsi');
        $table->string('foto')->nullable();
        $table->enum('status', ['Terkirim', 'Diproses', 'Selesai'])->default('Terkirim');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
