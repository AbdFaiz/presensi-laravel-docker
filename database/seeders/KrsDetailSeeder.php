<?php

namespace Database\Seeders;

use App\Models\KelasKuliah;
use App\Models\KrsDetail;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class KrsDetailSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswas = Mahasiswa::all();
        $kelas = KelasKuliah::all();

        $enrollments = [
            ['mahasiswa_nim' => '2023001', 'kelas_nama' => 'TI-4A', 'status' => 'aktif'],
            ['mahasiswa_nim' => '2023002', 'kelas_nama' => 'TI-4A', 'status' => 'aktif'],
            ['mahasiswa_nim' => '2024001', 'kelas_nama' => 'TI-4A', 'status' => 'pending'],
            ['mahasiswa_nim' => '2023001', 'kelas_nama' => 'TI-4C', 'status' => 'aktif'],
            ['mahasiswa_nim' => '2023003', 'kelas_nama' => 'SI-5A', 'status' => 'aktif'],
            ['mahasiswa_nim' => '2024002', 'kelas_nama' => 'SI-5A', 'status' => 'pending'],
        ];

        foreach ($enrollments as $e) {
            $mhs = Mahasiswa::where('nim', $e['mahasiswa_nim'])->first();
            $kls = KelasKuliah::where('nama_kelas', $e['kelas_nama'])->first();

            if ($mhs && $kls) {
                KrsDetail::create([
                    'kelas_kuliah_id' => $kls->id,
                    'mahasiswa_id' => $mhs->id,
                    'status' => $e['status'],
                ]);
            }
        }
    }
}
