<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    // === ALUMNI ENDPOINTS ===

    public function profile(Request $request)
    {
        $profile = AlumniProfile::where('user_id', $request->user()->id_users)->first();
        return response()->json($profile);
    }

    public function updateProfile(Request $request)
    {
        $profile = AlumniProfile::where('user_id', $request->user()->id_users)->first();
        if (!$profile) return response()->json(['message' => 'Profil tidak ditemukan'], 404);

        $profile->update($request->only([
            'nama_lengkap', 'nim', 'fakultas', 'program_studi',
            'tahun_lulus', 'status_karir', 'telepon',
            'alamat_lengkap', 'provinsi', 'kota'
        ]));

        return response()->json(['message' => 'Profil berhasil diperbarui', 'data' => $profile]);
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate(['avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
        $profile = AlumniProfile::where('user_id', $request->user()->id_users)->first();
        
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $profile->update(['avatar_url' => asset('storage/' . $path)]);
            return response()->json(['message' => 'Avatar berhasil diunggah', 'avatar_url' => $profile->avatar_url]);
        }
        return response()->json(['message' => 'Gagal unggah'], 400);
    }

    // === ADMIN ENDPOINTS ===

    public function index()
    {
        return response()->json(AlumniProfile::with('user')->get());
    }

    public function show($id)
    {
        $alumni = AlumniProfile::with('user')->find($id);
        if (!$alumni) return response()->json(['message' => 'Not found'], 404);
        return response()->json($alumni);
    }

    public function update(Request $request, $id)
    {
        $alumni = AlumniProfile::find($id);
        if (!$alumni) return response()->json(['message' => 'Not found'], 404);
        
        $alumni->update($request->all());
        return response()->json(['message' => 'Diperbarui', 'data' => $alumni]);
    }

    public function destroy($id)
    {
        $alumni = AlumniProfile::find($id);
        if (!$alumni) return response()->json(['message' => 'Not found'], 404);
        
        User::destroy($alumni->user_id); // Akan cascade delete profilnya
        return response()->json(['message' => 'Dihapus']);
    }
}
