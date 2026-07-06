<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fakultas;

class FakultasSeeder extends Seeder
{
    public function run(): void
    {
        $fakultas = [
            'Fakultas Agama Islam',
            'Fakultas Pendidikan',
            'Fakultas Sains dan Teknologi'
        ];

        foreach ($fakultas as $nama) {
            Fakultas::firstOrCreate(['nama_fakultas' => $nama]);
        }
    }
}
