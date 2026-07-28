<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'gelar',
        'no_hp',
        'program_studi_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function kelasKuliahs(): HasMany
    {
        return $this->hasMany(KelasKuliah::class, 'dosen_id');
    }
}
