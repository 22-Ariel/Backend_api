<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'nim' => 'required|string|unique:alumni',
            'nama_lengkap' => 'required|string',
            'angkatan' => 'required|string'
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'alumni' // Default role for registration is alumni
        ]);

        // Create alumni profile
        Alumni::create([
            'id_user' => $user->id_user,
            'id_prodi' => $request->id_prodi,
            'nim' => $request->nim,
            'nama_lengkap' => $request->nama_lengkap,
            'angkatan' => $request->angkatan,
            'nomor_telepon' => $request->nomor_telepon ?? null,
            'alamat' => $request->alamat ?? null,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required', // Can be email or username
            'password' => 'required'
        ]);

        $user = User::where('email', $request->login)->orWhere('username', $request->login)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['Kredensial tidak valid.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role' => $user->role
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    public function forgotPassword(Request $request)
    {
        return response()->json([
            'message' => 'Fitur forgot password belum diimplementasi (membutuhkan mailer)'
        ]);
    }
}
