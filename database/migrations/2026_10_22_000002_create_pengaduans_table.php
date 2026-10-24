<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('no_hp', 20);

            // Kategori dipilih dari tabel kategoris, atau diisi manual
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris');
            $table->string('kategori_manual')->nullable();

            $table->text('aduan');
            $table->enum('status', ['baru', 'diproses', 'selesai'])->default('baru');
            $table->text('tanggapan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
