<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Satu pengaduan bisa punya banyak foto bukti
        Schema::create('lampirans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduans')->cascadeOnDelete();
            $table->string('path');
            $table->string('nama_asli');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lampirans');
    }
};
