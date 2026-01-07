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
        $request->validate([
            'nama' => 'required|string',
            'password' => 'required',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        // CARI NAMA SECARA PERSIS (CASE-SENSITIVE)
        $pengguna = DataPengguna::where('nama', $request->nama)->first();

        if (!$pengguna) {
            return back()->withErrors([
                'nama' => 'Data pengguna tidak ditemukan'
            ])->withInput();
        }

        if (!Hash::check($request->password, $pengguna->password)) {
            return back()->withErrors([
                'password' => 'Password salah'
            ])->withInput();
        }

        // Login sukses
        session([
            'pengguna_login' => true,
            'pengguna_id'    => $pengguna->id,
            'data_pengguna'  => $pengguna,
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
        $request->validate(
            [
                'nama'      => 'required|string|max:100',
                'nik'       => 'required|digits:16',
                'email'     => 'required|email|unique:data_pengguna,email',
                'nomor_hp'  => 'required',
                'password'  => 'required|min:6|confirmed',
            ],
            [
                'nama.required' => 'Nama wajib diisi.',
                'nik.required' => 'NIK wajib diisi.',
                'nik.digits' => 'NIK harus 16 digit.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'nomor_hp.required' => 'Nomor HP wajib diisi.',
                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password minimal 6 karakter.',
            ]
        );

        //cek NIK terdaftar di data_warga
        $warga = DataWarga::where('nik', $request->nik)
            ->where('nama', $request->nama)
            ->first();

        if (!$warga) {
            return back()
                ->withErrors([
                    'nik' => 'NIK tidak terdaftar sebagai warga.'
                ])
                ->withInput();
        }

        //cek nama sesuai dengan NIK
        if (strtolower(trim($warga->nama)) !== strtolower(trim($request->nama))) {
            return back()->withErrors([
                'nama' => 'Nama tidak sesuai dengan NIK yang terdaftar.'
            ])->withInput();
        }

        //cek NIK sudah terdaftar di data_pengguna
        $user = DataPengguna::where('nik', $request->nik)->first();

        if ($user) {
            return back()
                ->withErrors([
                    'nik' => 'NIK ini sudah terdaftar sebagai pengguna.'
                ])
                ->withInput();
        }
        //buat token verifikasi
        $token = Str::uuid();

        //simpan data pengguna
        $user = DataPengguna::create([
            'id' => random_int(100000, 999999),
            'nama'      => $request->nama,
            'nik'       => $request->nik,
            'email'     => $request->email,
            'nomor_hp'  => $request->nomor_hp,
            'password'  => Hash::make($request->password),
            'verification_token' => $token,
        ]);

        Mail::to($user->email)->send(new VerifikasiEmailPengguna($token, $user->nama));

        //redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Silakan cek email untuk verifikasi.');
    }

    public function verifyEmail($token)
    {
        $user = DataPengguna::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Token verifikasi tidak valid.');
        }

        $user->update([
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
