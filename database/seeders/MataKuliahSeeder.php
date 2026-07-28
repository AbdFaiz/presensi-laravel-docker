<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_mk' => 'TI201', 'nama_mk' => 'Pemrograman Web', 'sks' => 3, 'semester' => 4, 'program_studi_kode' => 'TI'],
            ['kode_mk' => 'TI202', 'nama_mk' => 'Basis Data', 'sks' => 3, 'semester' => 4, 'program_studi_kode' => 'TI'],
            ['kode_mk' => 'TI203', 'nama_mk' => 'Jaringan Komputer', 'sks' => 3, 'semester' => 4, 'program_studi_kode' => 'TI'],
            ['kode_mk' => 'SI301', 'nama_mk' => 'Analisis Perancangan Sistem', 'sks' => 3, 'semester' => 5, 'program_studi_kode' => 'SI'],
        ];

        foreach ($data as $item) {
            $prodi = \App\Models\ProgramStudi::where('kode', $item['program_studi_kode'])->first();
            MataKuliah::create([
                'kode_mk' => $item['kode_mk'],
                'nama_mk' => $item['nama_mk'],
                'sks' => $item['sks'],
                'semester' => $item['semester'],
                'program_studi_id' => $prodi->id,
            ]);
        }
    }
}
