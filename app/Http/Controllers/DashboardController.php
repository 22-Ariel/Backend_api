<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\Job;
use App\Models\News;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalAlumni = AlumniProfile::count();
        $totalJobs = Job::count();
        $totalNews = News::count();

        return response()->json([
            'total_alumni' => $totalAlumni,
            'total_jobs' => $totalJobs,
            'total_news' => $totalNews,
        ]);
    }
}
