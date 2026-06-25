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
        // Drop tables first, since they have foreign keys to surat_masuk
        Schema::dropIfExists('komentar_surat_masuk');
        Schema::dropIfExists('disposisi');

        // Remove columns from surat_masuk
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn(['status', 'catatan']);
        });

        // Remove columns from surat_keluar
        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->dropColumn(['status', 'catatan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add columns to surat_keluar
        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->string('status')->default('disetujui');
            $table->text('catatan')->nullable();
        });

        // Re-add columns to surat_masuk
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->string('status')->default('diterima');
            $table->text('catatan')->nullable();
        });

        // Recreate disposisi table
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained()->onDelete('cascade');
            $table->foreignId('dari_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kepada_user_id')->constrained('users')->onDelete('cascade');
            $table->text('instruksi')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // Recreate komentar_surat_masuk table
        Schema::create('komentar_surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('komentar');
            $table->timestamps();
        });
    }
};
