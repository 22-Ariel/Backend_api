<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::query();
        if ($request->search) {
            $query->where('posisi', 'like', "%{$request->search}%")
                  ->orWhere('perusahaan', 'like', "%{$request->search}%");
        }
        if ($request->type) {
            $query->where('tipe_pekerjaan', $request->type);
        }
        return response()->json($query->orderBy('created_at', 'desc')->get());
    }

    public function show($id)
    {
        $job = Job::find($id);
        if (!$job) return response()->json(['message' => 'Not found'], 404);
        return response()->json($job);
    }

    // === ADMIN ENDPOINTS ===
    
    public function store(Request $request)
    {
        $request->validate([
            'posisi' => 'required',
            'perusahaan' => 'required',
            'tipe_pekerjaan' => 'required|in:Penuh Waktu,Paruh Waktu,Magang,Kontrak',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'persyaratan' => 'required',
            'batas_waktu' => 'required|date'
        ]);

        $job = Job::create($request->all());
        return response()->json(['message' => 'Berhasil dibuat', 'data' => $job], 201);
    }

    public function update(Request $request, $id)
    {
        $job = Job::find($id);
        if (!$job) return response()->json(['message' => 'Not found'], 404);
        
        $job->update($request->all());
        return response()->json(['message' => 'Berhasil diupdate', 'data' => $job]);
    }

    public function destroy($id)
    {
        $job = Job::find($id);
        if (!$job) return response()->json(['message' => 'Not found'], 404);
        
        $job->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
