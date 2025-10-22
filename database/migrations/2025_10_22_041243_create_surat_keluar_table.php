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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->nullable()->constrained('pengajuan_surat')->cascadeOnDelete();
            $table->string('nomor_surat', 50)->unique();
            $table->string('nama_surat', 100);
            $table->string('kepada', 100)->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
