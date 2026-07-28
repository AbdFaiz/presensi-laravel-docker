<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    protected $fillable = [
        'jadwal_kuliah_id',
        'mahasiswa_id',
        'waktu_presensi',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'waktu_presensi' => 'datetime',
    ];

    public function jadwalKuliah(): BelongsTo
    {
        return $this->belongsTo(JadwalKuliah::class);
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
