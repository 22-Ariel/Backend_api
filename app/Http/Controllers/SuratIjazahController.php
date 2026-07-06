<?php

namespace App\Http\Controllers;

use App\Models\SuratIjazah;
use App\Models\WebSetting;
use App\Models\Notification;
use Illuminate\Http\Request;

class SuratIjazahController extends Controller
{
    // ================== ALUMNI ENDPOINTS ==================

    // Upload filled PDF
    public function upload(Request $request)
    {
        $alumni = $request->user()->alumni;
        if (!$alumni) return response()->json(['message' => 'Profil alumni tidak ditemukan'], 404);

        $request->validate([
            'surat_file' => 'required|file|mimes:pdf|max:5120', // Max 5MB PDF
        ]);

        $file = $request->file('surat_file');
        
        // Simpan langsung di public/uploads/surat_alumni
        $directory = public_path('uploads/surat_alumni');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $fileName = time() . '_' . $alumni->nim . '.pdf';
        $file->move($directory, $fileName);
        
        $publicFilePath = 'uploads/surat_alumni/' . $fileName;

        $surat = SuratIjazah::updateOrCreate(
            ['id_alumni' => $alumni->id_alumni],
            [
                'file_path' => $publicFilePath,
                'status' => 'Menunggu Verifikasi',
                'catatan_admin' => null,
                'generated_at' => now()
            ]
        );

        return response()->json([
            'message' => 'Dokumen berhasil diunggah dan sedang menunggu verifikasi.',
            'data' => $surat
        ]);
    }

    public function getMine(Request $request)
    {
        $alumni = $request->user()->alumni;
        
        $surat = SuratIjazah::where('id_alumni', $alumni->id_alumni)->first();
        
        // Also fetch template URL
        $template = WebSetting::where('key', 'template_surat_ijazah')->first();
        
        return response()->json([
            'surat' => $surat,
            'template_url' => $template ? $template->value : null
        ]);
    }

    // ================== ADMIN ENDPOINTS ==================

    public function adminIndex()
    {
        $surat = SuratIjazah::with('alumni.user')->orderBy('created_at', 'desc')->get();
        return response()->json($surat);
    }

    public function adminVerify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan' => 'nullable|string'
        ]);

        $surat = SuratIjazah::with('alumni')->findOrFail($id);
        $surat->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan
        ]);

        if ($surat->alumni) {
            $statusText = $request->status === 'Disetujui' ? 'disetujui' : 'ditolak';
            $type = $request->status === 'Disetujui' ? 'success' : 'error';
            $msg = $request->status === 'Disetujui' 
                ? 'Dokumen Pengambilan Ijazah Anda telah disetujui oleh admin. Anda sudah dapat mengambil ijazah.'
                : 'Dokumen Pengambilan Ijazah Anda ditolak. Catatan admin: ' . ($request->catatan ?? 'Tidak ada catatan');

            Notification::create([
                'id_user' => $surat->alumni->id_user,
                'title' => 'Status Dokumen Ijazah',
                'message' => $msg,
                'type' => $type
            ]);
        }

        return response()->json(['message' => 'Status berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $surat = SuratIjazah::findOrFail($id);
        
        // Hapus file fisik jika ada
        if ($surat->file_path && file_exists(public_path($surat->file_path))) {
            unlink(public_path($surat->file_path));
        }

        $surat->delete();

        return response()->json(['message' => 'Dokumen berhasil dihapus']);
    }
}
