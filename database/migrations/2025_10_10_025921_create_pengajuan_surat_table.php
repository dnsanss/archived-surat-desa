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
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16);
            $table->string('nama');
            $table->foreignId('template_id')->constrained('templates_surat')->cascadeOnDelete();
            $table->string('nomor_surat')->nullable();
            $table->string('kepada')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('warga_id')->constrained('data_warga')->cascadeOnDelete();
            $table->foreignId('templates_id')->constrained('templates_surat')->cascadeOnDelete();
            $table->text('perihal')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->text('keterangan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};
=======
=======
>>>>>>> 
>>>>>>> 34e9fb3 (Revert "Merge pull request #1 from dnsanss/perubahan-struktur-database")
