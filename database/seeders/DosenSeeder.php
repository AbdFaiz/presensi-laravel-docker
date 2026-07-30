<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $dosenData = [
            [
                'name' => 'Dr. Ahmad Fauzi, S.Kom., M.T.',
                'username' => 'dosen001',
                'email' => 'ahmad.fauzi@university.ac.id',
                'nip' => '198501152010121001',
                'gelar' => 'S.Kom., M.T.',
                'no_hp' => '081234567890',
                'program_studi_kode' => 'TI',
            ],
            [
                'name' => 'Siti Nurhaliza, S.Kom., M.Sc.',
                'username' => 'dosen002',
                'email' => 'dosen002@university.ac.id',
                'nip' => '199003202015042002',
                'gelar' => 'S.Kom., M.Sc.',
                'no_hp' => '081234567891',
                'program_studi_kode' => 'SI',
            ],
        ];

        foreach ($dosenData as $data) {
            $prodi = ProgramStudi::where('kode', $data['program_studi_kode'])->first();

            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt('password'),
                'role' => 'dosen',
                'email_verified_at' => now(),
            ]);

            Dosen::create([
                'user_id' => $user->id,
                'nip' => $data['nip'],
                'nama_lengkap' => $data['name'],
                'gelar' => $data['gelar'],
                'no_hp' => $data['no_hp'],
                'program_studi_id' => $prodi->id,
            ]);
        }
    }
}
