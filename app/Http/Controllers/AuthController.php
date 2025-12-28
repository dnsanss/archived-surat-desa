<?php

namespace App\Http\Controllers;

use App\Models\DataWarga;
use App\Models\DataPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('frontend.login-warga');
    }

    public function loginSubmit(Request $request)
    {
        // validasi
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $pengguna = DataPengguna::where('email', $request->email)->first();

        if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
            return back()->withErrors(['email' => 'Login gagal']);
        }

        session([
            'pengguna_login' => true,
            'pengguna_id'    => $pengguna->id,
            'data_pengguna'  => $pengguna,
        ]);

        return redirect()->route('pengajuan-surat');
    }

    /* =======================
     * FORM REGISTER
     * ======================= */
    public function register()
    {
        return view('frontend.register');
    }

    /* =======================
     * PROSES REGISTER
     * ======================= */
    public function registerSubmit(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'nik'       => 'required|digits:16',
            'email'     => 'required|email|unique:data_pengguna,email',
            'nomor_hp'  => 'required',
            'password'  => 'required|min:6|confirmed',
        ]);

        $warga = DataWarga::where('nik', $request->nik)->first();
        if (!$warga) {
            return back()->withErrors([
                'nik' => 'NIK tidak terdaftar sebagai warga'
            ]);
        }

        DataPengguna::create([
            'id'        => random_int(100000, 999999),
            'nama'      => $request->nama,
            'nik'       => $request->nik,
            'email'     => $request->email,
            'nomor_hp'  => $request->nomor_hp,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->route('pengajuan-surat')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    /* =======================
     * LOGOUT
     * ======================= */
    public function logout()
    {
        session()->flush();

        return redirect()->route('pengajuan-surat')
            ->with('success', 'Berhasil logout.');
    }
}
