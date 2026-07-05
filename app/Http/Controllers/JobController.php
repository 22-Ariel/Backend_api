<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Lowongan::query();
        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('company', 'like', "%{$request->search}%");
        }
        return response()->json($query->orderBy('created_at', 'desc')->get());
    }

    public function show($id)
    {
        $lowongan = Lowongan::find($id);
        if (!$lowongan) return response()->json(['message' => 'Not found'], 404);
        return response()->json($lowongan);
    }

    // === ADMIN ENDPOINTS ===
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'description' => 'required'
        ]);

        $data = $request->all();
        $data['id_user'] = $request->user()->id_user; // Assign current admin

        $lowongan = Lowongan::create($data);
        return response()->json(['message' => 'Berhasil dibuat', 'data' => $lowongan], 201);
    }

    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::find($id);
        if (!$lowongan) return response()->json(['message' => 'Not found'], 404);
        
        $lowongan->update($request->all());
        return response()->json(['message' => 'Berhasil diupdate', 'data' => $lowongan]);
    }

    public function destroy($id)
    {
        $lowongan = Lowongan::find($id);
        if (!$lowongan) return response()->json(['message' => 'Not found'], 404);
        
        $lowongan->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
