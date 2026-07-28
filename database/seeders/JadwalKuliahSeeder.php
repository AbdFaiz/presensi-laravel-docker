<?php

namespace Database\Seeders;

use App\Models\JadwalKuliah;
use App\Models\KelasKuliah;
use Illuminate\Database\Seeder;

class JadwalKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = KelasKuliah::all();

        foreach ($kelas as $k) {
            for ($i = 1; $i <= 3; $i++) {
                JadwalKuliah::create([
                    'kelas_kuliah_id' => $k->id,
                    'pertemuan_ke' => $i,
                    'tgl_pertemuan' => now()->addWeeks($i - 1)->toDateString(),
                    'jam_mulai' => '08:00',
                    'jam_selesai' => '10:30',
                    'status_sesi' => $i === 1 ? 'dibuka' : 'ditutup',
                ]);
            }
        }
    }
}
