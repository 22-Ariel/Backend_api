<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fakultas;
use App\Models\Prodi;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $prodiByFakultas = [
            'Fakultas Agama Islam' => ['Pendidikan Agama Islam', 'Pendidikan Guru Madrasah Ibtidaiyah'],
            'Fakultas Pendidikan' => ['Pendidikan Fisika', 'Pendidikan Ekonomi', 'Pendidikan Bahasa Inggris', 'Pendidikan Bahasa dan Sastra Indonesia', 'Pendidikan Teknologi Informasi'],
            'Fakultas Sains dan Teknologi' => ['Informatika', 'Matematika', 'Sains Pertanian']
        ];

        foreach ($prodiByFakultas as $fakultasName => $prodis) {
            $fakultas = Fakultas::where('nama_fakultas', $fakultasName)->first();
            
            if ($fakultas) {
                foreach ($prodis as $namaProdi) {
                    Prodi::firstOrCreate([
                        'id_fakultas' => $fakultas->id_fakultas,
                        'nama_prodi' => $namaProdi
                    ]);
                }
            }
        }
    }
}
