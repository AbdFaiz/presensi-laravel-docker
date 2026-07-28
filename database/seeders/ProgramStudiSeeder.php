<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'TI', 'nama' => 'Teknologi Informasi', 'deskripsi' => 'Program studi teknologi informasi meliputi pemrograman, jaringan, dan basis data.'],
            ['kode' => 'SI', 'nama' => 'Sistem Informasi', 'deskripsi' => 'Program studi sistem informasi meliputi analisis sistem, manajemen proyek, dan bisnis digital.'],
            ['kode' => 'TK', 'nama' => 'Teknik Komputer', 'deskripsi' => 'Program studi teknik komputer meliputi perangkat keras, embedded system, dan elektronika.'],
        ];

        foreach ($data as $item) {
            ProgramStudi::create($item);
        }
    }
}
