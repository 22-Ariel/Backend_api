<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Lowongan;
use App\Models\News;
use App\Models\Fakultas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalAlumni = Alumni::count();
        $totalJobs = Lowongan::count();
        $totalNews = News::count();
        $totalFakultas = Fakultas::count();

        return response()->json([
            'total_alumni' => $totalAlumni,
            'total_jobs' => $totalJobs,
            'total_news' => $totalNews,
            'total_fakultas' => $totalFakultas,
        ]);
    }
}
