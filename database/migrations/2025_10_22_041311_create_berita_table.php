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
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD:database/migrations/2025_10_10_025933_create_surat_terbit_table.php
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->cascadeOnDelete();
            $table->string('nomor_surat');
<<<<<<< HEAD
            $table->string('kepada');
            $table->string('file_pdf');
            $table->date('tanggal_pengajuan');
<<<<<<< HEAD:database/migrations/2025_10_22_041311_create_berita_table.php
            $table->string('qrcode_path')->nullable();
=======
            $table->string('judul', 150);
            $table->longText('isi');
            $table->text('gambar')->nullable();
            $table->date('tanggal_publikasi')->nullable();
            $table->string('penulis', 100)->default('Admin Desa Karangasem');
>>>>>>> main:database/migrations/2025_10_22_041311_create_berita_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
=======
=======
            $table->string('file_pdf');
            $table->date('tanggal_terbit');
>>>>>>> 
>>>>>>> 34e9fb3 (Revert "Merge pull request #1 from dnsanss/perubahan-struktur-database"):database/migrations/2025_10_10_025933_create_surat_terbit_table.php
