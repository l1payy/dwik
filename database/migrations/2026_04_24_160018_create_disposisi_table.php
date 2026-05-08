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
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->string('no_disposisi');
            $table->foreignId('surat_masuk_id')->constrained('surat_masuk')->onDelete('cascade');
            $table->foreignId('dari_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kepada_user_id')->constrained('users')->onDelete('cascade');
            $table->text('instruksi');
            $table->text('catatan')->nullable();
            $table->string('prioritas');
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->date('batas_waktu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};
