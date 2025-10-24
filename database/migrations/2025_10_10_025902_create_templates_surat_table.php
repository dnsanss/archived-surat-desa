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
            $table->string('nama_template', 100);
            $table->longText('isi_template');
<<<<<<< HEAD
            $table->string('nomor_surat');
=======
            $table->string('format_file', 10)->default('PDF');
            $table->text('keterangan')->nullable();
>>>>>>> main
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
