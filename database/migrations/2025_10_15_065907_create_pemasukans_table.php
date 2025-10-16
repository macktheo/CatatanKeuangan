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
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke tabel users (siapa yang mencatat)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->date('tanggal');
            $table->string('deskripsi');
            
            // Kolom jumlah (format mata uang, 15 digit total, 2 di belakang koma)
            $table->decimal('jumlah', 15, 2); 
            
            // Kolom untuk fasilitas Gambar/Foto (nullable karena tidak wajib)
            $table->string('bukti_gambar')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukan');
    }
};