<?php

namespace App\Http\Controllers;

use App\Models\SuratIjazah;
use Illuminate\Http\Request;

class SuratIjazahController extends Controller
{
    // ALUMNI: Generate or Download
    public function generate(Request $request)
    {
        $alumni = $request->user()->alumni;
        if (!$alumni) return response()->json(['message' => 'Profil alumni tidak ditemukan'], 404);

        // Dummy generation logic
        $surat = SuratIjazah::updateOrCreate(
            ['id_alumni' => $alumni->id_alumni],
            [
                'file_path' => 'surat/dummy_surat_' . $alumni->nim . '.pdf',
                'generated_at' => now()
            ]
        );

        return response()->json([
            'message' => 'Surat Pengantar Ijazah berhasil dibuat.',
            'data' => $surat
        ]);
    }

    public function getMine(Request $request)
    {
        $alumni = $request->user()->alumni;
        $surat = SuratIjazah::where('id_alumni', $alumni->id_alumni)->get();
        return response()->json($surat);
    }
}
