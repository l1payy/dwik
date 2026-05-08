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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat');
            $table->string('no_agenda')->nullable();
            $table->date('tanggal_surat');
            $table->date('tanggal_masuk');
            $table->string('pengirim');
            $table->string('instansi_pengirim')->nullable();
            $table->string('perihal');
            $table->enum('sifat', ['biasa', 'penting', 'rahasia'])->default('biasa');
            $table->enum('prioritas', ['normal', 'urgent'])->default('normal');
            $table->enum('status', ['diterima', 'terdisposisi', 'selesai'])->default('diterima');
            $table->string('file_lampiran')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
