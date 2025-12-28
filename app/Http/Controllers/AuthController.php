<?php

namespace App\Http\Controllers;

use App\Models\DataWarga;
use Illuminate\Support\Str;
use App\Models\DataPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifikasiEmailPengguna;

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
            'data_pengguna'  => $pengguna->fresh(),
        ]);

        return redirect()->route('pengajuan-surat');
    }

    //Register
    public function register()
    {
        return view('frontend.register');
    }

    //proses register
    public function registerSubmit(Request $request)
    {
        // validasi
        $request->validate([
            'nama'      => 'required|string|max:100',
            'nik'       => 'required|digits:16',
            'email'     => 'required|email|unique:data_pengguna,email',
            'nomor_hp'  => 'required',
            'password'  => 'required|min:6|confirmed',
        ]);

        //cek NIK terdaftar di data_warga
        $warga = DataWarga::where('nik', $request->nik)->first();
        if (!$warga) {
            return back()->withErrors([
                'nik' => 'NIK tidak terdaftar sebagai warga'
            ]);
        }
        //buat token verifikasi
        $token = Str::uuid();

        //simpan data pengguna
        $pengguna = DataPengguna::create([
            'kode_pengguna' => random_int(100000, 999999),
            'nama'      => $request->nama,
            'nik'       => $request->nik,
            'email'     => $request->email,
            'nomor_hp'  => $request->nomor_hp,
            'password'  => Hash::make($request->password),
            'verification_token' => $token,
        ]);

        Mail::to($request->email)->send(
            new VerifikasiEmailPengguna($pengguna)
        );

        //redirect ke halaman login dengan pesan sukses
        return redirect()->route('pengajuan-surat')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function verifyEmail($token)
    {
        $pengguna = DataPengguna::where('verification_token', $token)->first();

        if (!$pengguna) {
            return redirect()->route('login')
                ->with('error', 'Token verifikasi tidak valid.');
        }

        $pengguna->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);

        return redirect()->route('login')
            ->with('success', 'Email berhasil diverifikasi. Silakan login.');
    }


    //logout
    public function logout()
    {
        session()->flush();

        return redirect()->route('pengajuan-surat')
            ->with('success', 'Berhasil logout.');
    }
}
