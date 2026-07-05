<?php

namespace App\Http\Controllers;

use App\Models\TandaTanganAdmin;
use Illuminate\Http\Request;

class TandaTanganController extends Controller
{
    // ADMIN
    public function getMine(Request $request)
    {
        $ttd = TandaTanganAdmin::where('id_user', $request->user()->id_user)->first();
        return response()->json($ttd);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'ttd_file' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $path = $request->file('ttd_file')->store('signatures', 'public');
        
        $ttd = TandaTanganAdmin::updateOrCreate(
            ['id_user' => $request->user()->id_user],
            ['file_path' => asset('storage/' . $path)]
        );

        return response()->json(['message' => 'Tanda tangan berhasil diunggah', 'data' => $ttd]);
    }
}
