<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Fakultas;
use App\Models\Prodi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'username' => 'admin_super',
            'email' => 'admin@unuha.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // 2. Buat Akun Pimpinan (opsional untuk tes)
        User::create([
            'username' => 'pimpinan_rektor',
            'email' => 'pimpinan@unuha.ac.id',
            'password' => Hash::make('pimpinan123'),
            'role' => 'pimpinan'
        ]);

        // 3. Buat Data Fakultas & Prodi Default
        $fakultas = Fakultas::create([
            'nama_fakultas' => 'Fakultas Ilmu Komputer'
        ]);

        Prodi::create([
            'id_fakultas' => $fakultas->id_fakultas,
            'nama_prodi' => 'Teknik Informatika'
        ]);
        
        Prodi::create([
            'id_fakultas' => $fakultas->id_fakultas,
            'nama_prodi' => 'Sistem Informasi'
        ]);
    }
}
