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
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn(['sifat', 'prioritas']);
        });

        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->dropColumn(['sifat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->enum('sifat', ['biasa', 'penting', 'rahasia'])->default('biasa');
            $table->enum('prioritas', ['normal', 'urgent'])->default('normal');
        });

        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->enum('sifat', ['biasa', 'penting', 'rahasia'])->default('biasa');
        });
    }
};
