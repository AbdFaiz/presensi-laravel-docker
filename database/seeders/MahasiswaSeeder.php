<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswaData = [
            [
                'name' => 'Budi Santoso',
                'username' => '2023001',
                'email' => 'budi.santoso@student.ac.id',
                'nim' => '2023001',
                'nama_lengkap' => 'Budi Santoso',
                'program_studi_kode' => 'TI',
                'angkatan' => 2023,
            ],
            [
                'name' => 'Rina Wati',
                'username' => '2023002',
                'email' => 'rina.wati@student.ac.id',
                'nim' => '2023002',
                'nama_lengkap' => 'Rina Wati',
                'program_studi_kode' => 'TI',
                'angkatan' => 2023,
            ],
            [
                'name' => 'Dedi Kurniawan',
                'username' => '2023003',
                'email' => 'dedi.kurniawan@student.ac.id',
                'nim' => '2023003',
                'nama_lengkap' => 'Dedi Kurniawan',
                'program_studi_kode' => 'SI',
                'angkatan' => 2023,
            ],
            [
                'name' => 'Maya Putri',
                'username' => '2024001',
                'email' => 'maya.putri@student.ac.id',
                'nim' => '2024001',
                'nama_lengkap' => 'Maya Putri',
                'program_studi_kode' => 'TI',
                'angkatan' => 2024,
            ],
            [
                'name' => 'Andi Pratama',
                'username' => '2024002',
                'email' => 'andi.pratama@student.ac.id',
                'nim' => '2024002',
                'nama_lengkap' => 'Andi Pratama',
                'program_studi_kode' => 'SI',
                'angkatan' => 2024,
            ],
        ];

        foreach ($mahasiswaData as $data) {
            $prodi = ProgramStudi::where('kode', $data['program_studi_kode'])->first();

            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt('password'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
            ]);

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $data['nim'],
                'nama_lengkap' => $data['nama_lengkap'],
                'program_studi_id' => $prodi->id,
                'angkatan' => $data['angkatan'],
            ]);
        }
    }
}
