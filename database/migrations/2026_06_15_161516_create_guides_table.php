<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('guides', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('kategori'); // Contoh: Ruangan, Alat Laboratorium, Gedung
        $table->text('isi');
        $table->string('ikon')->default('📖'); // Emoji atau class icon
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
