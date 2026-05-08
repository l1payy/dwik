<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';

    protected $fillable = [
        'no_disposisi',
        'surat_masuk_id',
        'dari_user_id',
        'kepada_user_id',
        'instruksi',
        'catatan',
        'prioritas',
        'status',
        'batas_waktu',
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'dari_user_id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'kepada_user_id');
    }
}
