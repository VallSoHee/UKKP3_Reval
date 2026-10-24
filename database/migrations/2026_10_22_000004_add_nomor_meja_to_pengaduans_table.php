<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Nullable supaya data lama (sebelum ada nomor meja) tetap aman
            $table->unsignedSmallInteger('nomor_meja')->nullable()->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn('nomor_meja');
        });
    }
};
