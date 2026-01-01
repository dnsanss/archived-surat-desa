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
        Schema::create('data_pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengguna', 6)->unique();
            $table->string('nama');
            $table->string('nik', 16);
            $table->string('email')->unique();
            $table->string('nomor_hp')->nullable();

            // Auth
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_token')->nullable();

            $table->timestamps();

            // Relasi ke data_warga lewat NIK (logis & fleksibel)
            $table->foreign('nik')
                ->references('nik')
                ->on('data_warga')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pengguna');
    }
};
