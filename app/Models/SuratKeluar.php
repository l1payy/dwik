<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'no_surat',
        'tanggal_surat',
        'penerima',
        'instansi_penerima',
        'perihal',
        'file_lampiran',
        'created_by',
        'status',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
