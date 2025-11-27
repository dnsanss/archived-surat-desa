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
            $table->foreignId('warga_id')->constrained('data_warga')->cascadeOnDelete()->nullable()->after('id');
            $table->string('nik', 16);
            $table->string('nama');
            $table->foreignId('template_id')->constrained('templates_surat')->cascadeOnDelete();
            $table->string('nomor_wa')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->longText('isi_surat')->nullable();
            $table->string('kepada')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
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
