<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::where('status', 'Diterbitkan');
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        return response()->json($query->orderBy('published_at', 'desc')->get());
    }

    public function show($id)
    {
        $news = News::where('id_news', $id)->where('status', 'Diterbitkan')->first();
        if (!$news) return response()->json(['message' => 'Not found'], 404);
        return response()->json($news);
    }

    // === ADMIN ENDPOINTS ===

    public function indexAdmin()
    {
        return response()->json(News::orderBy('created_at', 'desc')->get());
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'kategori' => 'required|in:Akademik,Karir,Acara',
            'konten' => 'required',
            'status' => 'required|in:Diterbitkan,Draf'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul) . '-' . time();
        
        if ($request->status === 'Diterbitkan') {
            $data['published_at'] = now();
        }

        $news = News::create($data);
        return response()->json(['message' => 'Berhasil dibuat', 'data' => $news], 201);
    }

    public function update(Request $request, $id)
    {
        $news = News::find($id);
        if (!$news) return response()->json(['message' => 'Not found'], 404);
        
        $data = $request->all();
        if ($request->has('judul') && $request->judul !== $news->judul) {
            $data['slug'] = Str::slug($request->judul) . '-' . time();
        }
        
        $news->update($data);
        return response()->json(['message' => 'Berhasil diupdate', 'data' => $news]);
    }

    public function destroy($id)
    {
        $news = News::find($id);
        if (!$news) return response()->json(['message' => 'Not found'], 404);
        
        $news->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
