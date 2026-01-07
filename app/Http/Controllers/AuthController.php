<?php

namespace App\Http\Controllers;

use App\Models\DataWarga;
use App\Models\DataPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // FORM LOGIN
    public function login()
    {
        return view('frontend.login-warga');
    }
    public function loginSubmit(Request $request)
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
        ); // CARI NAMA SECARA PERSIS (CASE-SENSITIVE)
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
            'pengguna_id' => $pengguna->id,
            'data_pengguna' => $pengguna,
        ]);
        return redirect()->route('pengajuan-surat');
    }

    // FORM REGISTER GOOGLE USER
    public function register()
    {
        // Pastikan berasal dari Google Auth
        if (!session('google_login_pending')) {
            return redirect()->route('login');
        }

        return view('frontend.register');
    }

    // SUBMIT REGISTER GOOGLE USER
    public function registerSubmit(Request $request)
    {
        if (!session('google_login_pending')) {
            return redirect()->route('login');
        }

        $request->validate(
            [
                'nama'      => 'required|string|max:100',
                'nik'       => 'required|digits:16',
                'nomor_hp'  => 'required',
                'password'  => 'required|min:6|confirmed',
            ],
            [
                'nama.required' => 'Nama wajib diisi.',
                'nik.required' => 'NIK wajib diisi.',
                'nik.digits' => 'NIK harus 16 digit.',
                'nomor_hp.required' => 'Nomor HP wajib diisi.',
                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password minimal 6 karakter.',
            ]
        );

        // Ambil user Google
        $pengguna = DataPengguna::find(session('pengguna_id'));

        if (!$pengguna) {
            return redirect()->route('login');
        }

        // VALIDASI NIK DAN NAMA DENGAN DATA WARGA
        $warga = DataWarga::where('nik', $request->nik)->first();

        if (!$warga) {
            return back()->withErrors([
                'nik' => 'NIK tidak terdaftar sebagai warga.'
            ]);
        }

        if (strtolower(trim($warga->nama)) !== strtolower(trim($request->nama))) {
            return back()->withErrors([
                'nama' => 'Nama tidak sesuai dengan NIK yang terdaftar.'
            ]);
        }

        // CEK NIK SUDAH DIGUNAKAN PENGGUNA LAIN
        $nikUsed = DataPengguna::where('nik', $request->nik)
            ->where('id', '!=', $pengguna->id)
            ->exists();

        if ($nikUsed) {
            return back()->withErrors([
                'nik' => 'NIK ini sudah digunakan akun lain.'
            ]);
        }

        // UPDATE DATA PENGGUNA
        $pengguna->update([
            'nama'      => $request->nama,
            'nik'       => $request->nik,
            'nomor_hp'  => $request->nomor_hp,
            'password'  => Hash::make($request->password),
        ]);

        // LOGIN PENUH
        session()->forget('google_login_pending');
        session([
            'pengguna_login' => true,
            'data_pengguna'  => $pengguna,
        ]);

        return redirect()->route('pengajuan-surat')
            ->with('success', 'Registrasi berhasil. Selamat datang!');
    }

    /**
     * LOGOUT
     */
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
