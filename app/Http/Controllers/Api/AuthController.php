<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataPengguna;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string',
                'password' => 'required',
            ],
            [
                'nama.required' => 'Nama wajib diisi',
                'password.required' => 'Password wajib diisi',
            ]
        );

        $user = DataPengguna::where('nama', $request->nama)->first();
        if (!$user) {
            return back()->withErrors([
                'nama' => 'Data pengguna tidak ditemukan'
            ])->withInput();
        }
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah'
            ])->withInput();
        }

        // hapus token lama (opsional)
        $user->tokens()->delete();

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'nik' => $user->nik,
                'nama' => $user->nama,
            ]
        ]);
    }
}
