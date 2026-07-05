<?php

namespace App\Http\Controllers;

use App\Models\WebSetting;
use Illuminate\Http\Request;

class WebSettingController extends Controller
{
    public function index()
    {
        // Return key-value pairs
        $settings = WebSetting::all()->pluck('value', 'key');
        return response()->json($settings);
    }

    // === ADMIN ENDPOINTS ===

    public function update(Request $request)
    {
        $data = $request->all(); // Expecting array like ['hero_title' => '...', 'hero_desc' => '...']
        
        foreach ($data as $key => $value) {
            WebSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return response()->json(['message' => 'Pengaturan web berhasil diperbarui']);
    }
}
