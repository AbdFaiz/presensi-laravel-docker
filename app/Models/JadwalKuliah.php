<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalKuliah extends Model
{
    protected $fillable = [
        'kelas_kuliah_id',
        'pertemuan_ke',
        'tgl_pertemuan',
        'jam_mulai',
        'jam_selesai',
        'status_sesi',
    ];

    protected $casts = [
        'tgl_pertemuan' => 'date',
    ];

    public function kelasKuliah(): BelongsTo
    {
        return $this->belongsTo(KelasKuliah::class);
    }

    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }

    public function isAktif(): bool
    {
        return $this->status_sesi === 'dibuka';
    }
}
