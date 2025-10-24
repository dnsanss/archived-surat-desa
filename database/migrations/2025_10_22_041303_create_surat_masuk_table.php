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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 50)->nullable();
            $table->string('pengirim', 100)->nullable();
            $table->string('perihal', 150)->nullable();
            $table->string('jenis', 50)->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->date('tanggal_terima')->nullable();
            $table->text('dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
