<?php

namespace App\Http\Controllers;

use App\Models\TracerStudy;
use Illuminate\Http\Request;

class TracerStudyController extends Controller
{
    // ALUMNI: Fill the form
    public function store(Request $request)
    {
        $request->validate([
            'job_status' => 'required',
            'job_title' => 'required_if:job_status,Bekerja',
            'company' => 'required_if:job_status,Bekerja',
            'city' => 'nullable'
        ]);

        $alumni = $request->user()->alumni;
        if (!$alumni) return response()->json(['message' => 'Profil alumni tidak ditemukan'], 404);

        $tracer = TracerStudy::updateOrCreate(
            ['id_alumni' => $alumni->id_alumni],
            [
                'job_status' => $request->job_status,
                'job_title' => $request->job_title,
                'company' => $request->company,
                'city' => $request->city,
                'filled_at' => now()
            ]
        );

        return response()->json(['message' => 'Berhasil disimpan', 'data' => $tracer]);
    }

    // ADMIN: View Reports
    public function index()
    {
        $data = TracerStudy::with('alumni.prodi')->get();
        return response()->json($data);
    }
}
