<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarSuratMasuk extends Model
{
    protected $table = 'komentar_surat_masuk';

    protected $fillable = [
        'surat_masuk_id',
        'user_id',
        'komentar',
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
