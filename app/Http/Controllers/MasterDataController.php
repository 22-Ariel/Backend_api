<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    // === FAKULTAS ===
    public function getFakultas()
    {
        return response()->json(Fakultas::all());
    }

    public function storeFakultas(Request $request)
    {
        $request->validate(['nama_fakultas' => 'required']);
        $fakultas = Fakultas::create($request->all());
        return response()->json($fakultas, 201);
    }

    public function destroyFakultas($id)
    {
        Fakultas::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }

    // === PRODI ===
    public function getProdi()
    {
        return response()->json(Prodi::with('fakultas')->get());
    }

    public function storeProdi(Request $request)
    {
        $request->validate([
            'id_fakultas' => 'required|exists:fakultas,id_fakultas',
            'nama_prodi' => 'required'
        ]);
        $prodi = Prodi::create($request->all());
        return response()->json($prodi, 201);
    }

    public function destroyProdi($id)
    {
        Prodi::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
