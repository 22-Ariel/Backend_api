<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    // === ALUMNI ENDPOINTS ===

    public function profile(Request $request)
    {
        $profile = Alumni::with('prodi.fakultas')->where('id_user', $request->user()->id_user)->first();
        return response()->json($profile);
    }

    public function updateProfile(Request $request)
    {
        $profile = Alumni::where('id_user', $request->user()->id_user)->first();
        if (!$profile) return response()->json(['message' => 'Profil tidak ditemukan'], 404);

        $profile->update($request->only([
            'id_prodi', 'nim', 'nama_lengkap', 'angkatan', 'nomor_telepon', 'alamat'
        ]));

        return response()->json(['message' => 'Profil berhasil diperbarui', 'data' => $profile]);
    }

    // === ADMIN ENDPOINTS ===

    public function index()
    {
        return response()->json(Alumni::with(['user', 'prodi.fakultas'])->get());
    }

    public function show($id)
    {
        $alumni = Alumni::with(['user', 'prodi.fakultas'])->find($id);
        if (!$alumni) return response()->json(['message' => 'Not found'], 404);
        return response()->json($alumni);
    }

    public function update(Request $request, $id)
    {
        $alumni = Alumni::find($id);
        if (!$alumni) return response()->json(['message' => 'Not found'], 404);
        
        $alumni->update($request->all());
        return response()->json(['message' => 'Diperbarui', 'data' => $alumni]);
    }

    public function destroy($id)
    {
        $alumni = Alumni::find($id);
        if (!$alumni) return response()->json(['message' => 'Not found'], 404);
        
        User::destroy($alumni->id_user); // Akan cascade delete profilnya
        return response()->json(['message' => 'Dihapus']);
    }
}
