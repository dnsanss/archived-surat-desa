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
        Schema::create('templates_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_template');
            $table->longText('isi_template');
            $table->string('nomor_surat');
            $table->string('nama_ttd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates_surat');
    }
};
