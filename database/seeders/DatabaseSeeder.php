<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'username' => 'admin001',
            'email' => 'admin@presensi.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->call([
            ProgramStudiSeeder::class,
            DosenSeeder::class,
            MahasiswaSeeder::class,
            MataKuliahSeeder::class,
            KelasKuliahSeeder::class,
            JadwalKuliahSeeder::class,
            KrsDetailSeeder::class,
        ]);
    }
}
