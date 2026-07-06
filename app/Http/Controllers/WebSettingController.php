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
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $directory = public_path('uploads/settings');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($directory, $fileName);
                $value = asset('uploads/settings/' . $fileName);
            }

            if ($value !== null) {
                WebSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }

        return response()->json(['message' => 'Pengaturan web berhasil diperbarui']);
    }
}
