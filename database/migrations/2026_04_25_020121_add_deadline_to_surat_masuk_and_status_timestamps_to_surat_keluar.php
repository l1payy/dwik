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
            $table->date('deadline')->nullable()->after('tanggal_masuk');
        });

        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->timestamp('disetujui_at')->nullable()->after('status');
            $table->timestamp('ditolak_at')->nullable()->after('disetujui_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn('deadline');
        });

        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->dropColumn(['disetujui_at', 'ditolak_at']);
        });
    }
};
