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
        Schema::create('surat_terbit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->cascadeOnDelete();
            $table->foreignId('warga_id')
                ->nullable()
                ->constrained('data_warga')
                ->cascadeOnDelete();
            $table->string('nomor_surat');
            $table->string('kepada');
            $table->string('diproses_oleh')->nullable();
            $table->string('file_pdf');
            $table->date('tanggal_pengajuan');
            $table->longText('qrcode_path')->nullable();
            $table->string('qr_token', 100)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_terbit');
    }
};
