<?php

namespace App\Http\Controllers;

use App\Models\CampusInfo;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        return response()->json(CampusInfo::where('status', 'Aktif')->get());
    }

    public function show($id)
    {
        $info = CampusInfo::where('id_info', $id)->where('status', 'Aktif')->first();
        if (!$info) return response()->json(['message' => 'Not found'], 404);
        return response()->json($info);
    }

    // === ADMIN ENDPOINTS ===
    
    public function indexAdmin()
    {
        return response()->json(CampusInfo::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tipe' => 'required|in:Pengumuman,Panduan,Informasi',
            'konten' => 'required',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ]);

        $data = $request->all();
        $data['id_user'] = $request->user()->id_user ?? 1;

        $info = CampusInfo::create($data);
        return response()->json(['message' => 'Berhasil dibuat', 'data' => $info], 201);
    }

    public function update(Request $request, $id)
    {
        $info = CampusInfo::find($id);
        if (!$info) return response()->json(['message' => 'Not found'], 404);
        
        $info->update($request->all());
        return response()->json(['message' => 'Berhasil diupdate', 'data' => $info]);
    }

    public function destroy($id)
    {
        $info = CampusInfo::find($id);
        if (!$info) return response()->json(['message' => 'Not found'], 404);
        
        $info->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
