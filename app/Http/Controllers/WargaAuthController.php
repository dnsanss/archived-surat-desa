<?php

namespace App\Http\Controllers;

use App\Models\DataWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WargaAuthController extends Controller
{
    /**
     * Tampilkan halaman login warga
     */
    public function showLoginForm()
    {
        return view('frontend.login-warga');
    }

    /**
     * Proses login warga
     */
    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16',
            'password' => 'required',
        ]);

        // Cari warga berdasarkan NIK
        $warga = DataWarga::where('nik', $request->nik)->first();

        if (!$warga) {
            return back()->withErrors([
                'nik' => 'NIK tidak ditemukan dalam database warga.'
            ])->withInput();
        }

        // Password = tanggal lahir warga → format dd-mm-yyyy
        $passwordBenar = Carbon::parse($warga->tanggal_lahir)
            ->format('d-m-Y');

        if ($request->password !== $passwordBenar) {
            return back()->withErrors([
                'password' => 'Password tidak sesuai.'
            ])->withInput();
        }

        // SIMPAN SESSION LOGIN WARGA
        session([
            'warga_logged_in' => true,
            'warga' => $warga, // object
        ]);

        return redirect()
            ->route('pengajuan-surat')
            ->with('success', 'Berhasil login sebagai ' . $warga->nama);
    }

    /**
     * Logout warga
     */
    public function logout()
    {
        session()->forget([
            'warga_logged_in',
            'warga_nik',
            'warga_nama',
            'warga_id',
            'warga_data'
        ]);

        return redirect()
            ->route('pengajuan-surat')
            ->with('success', 'Anda telah logout.');
    }
}
