<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DataPengguna;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // AMBIL DATA DARI GOOGLE
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal login menggunakan Google.');
        }

        // Cari berdasarkan email
        $pengguna = DataPengguna::where('email', $googleUser->email)->first();

        if (!$pengguna) {
            // BUAT AKUN MINIMAL (BELUM LOGIN)
            $pengguna = DataPengguna::create([
                'id'            => random_int(100000, 999999),
                'email'             => $googleUser->email,
                'google_id'         => $googleUser->id,
                'email_verified_at' => now(),
            ]);
        } else {
            if (!$pengguna->google_id) {
                $pengguna->update([
                    'google_id' => $googleUser->id,
                ]);
            }

            if (!$pengguna->email_verified_at) {
                $pengguna->update([
                    'email_verified_at' => now(),
                ]);
            }
        }

        // CEK KELENGKAPAN DATA
        if (
            empty($pengguna->nik) ||
            empty($pengguna->nama)
        ) {
            Session::put('google_login_pending', true);
            Session::put('pengguna_id', $pengguna->id);

            return redirect()->route('register')
                ->with('info', 'Silakan lengkapi data diri Anda terlebih dahulu.');
        }

        // LOGIN BERHASIL
        Session::put('data_pengguna', $pengguna);
        Session::put('pengguna_login', true);
        Session::forget('google_login_pending');

        return redirect()->route('pengajuan-surat')
            ->with('success', 'Login Google berhasil.');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
