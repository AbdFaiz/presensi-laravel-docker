<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\KelasKuliah;
use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class KelasKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $dosen1 = Dosen::where('nip', '198501152010121001')->first();
        $dosen2 = Dosen::where('nip', '199003202015042002')->first();

        $pw = MataKuliah::where('kode_mk', 'TI201')->first();
        $bd = MataKuliah::where('kode_mk', 'TI202')->first();
        $aps = MataKuliah::where('kode_mk', 'SI301')->first();

        $data = [
            ['mata_kuliah_id' => $pw->id, 'dosen_id' => $dosen1->id, 'nama_kelas' => 'TI-4A', 'tahun_akademik' => '2025/2026'],
            ['mata_kuliah_id' => $pw->id, 'dosen_id' => $dosen1->id, 'nama_kelas' => 'TI-4B', 'tahun_akademik' => '2025/2026'],
            ['mata_kuliah_id' => $bd->id, 'dosen_id' => $dosen1->id, 'nama_kelas' => 'TI-4C', 'tahun_akademik' => '2025/2026'],
            ['mata_kuliah_id' => $aps->id, 'dosen_id' => $dosen2->id, 'nama_kelas' => 'SI-5A', 'tahun_akademik' => '2025/2026'],
        ];

        foreach ($data as $item) {
            KelasKuliah::create($item);
        }
    }
}
