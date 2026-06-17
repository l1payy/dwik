<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'no_surat',
        'no_agenda',
        'tanggal_surat',
        'tanggal_masuk',
        'deadline',
        'pengirim',
        'instansi_pengirim',
        'perihal',
        'status',
        'file_lampiran',
        'catatan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_masuk' => 'date',
        'deadline' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id');
    }

    public function komentar()
    {
        return $this->hasMany(KomentarSuratMasuk::class)->latest();
    }
}
