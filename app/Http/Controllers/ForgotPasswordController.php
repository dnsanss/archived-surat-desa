<?php

namespace App\Http\Controllers;

use App\Models\DataPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function request()
    {
        return view('frontend.reset-password');
    }

    // KIRIM LINK RESET PASSWORD
    public function sendLink(Request $request)
    {
        // VALIDASI INPUT
        $request->validate([
            'email' => 'required|email'
        ]);

        $emailInput = trim($request->email);

        // Cari user berdasarkan email
        $user = DataPengguna::where('email', $emailInput)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email ini tidak terdaftar di sistem kami.'
            ]);
        }

        // Cek apakah user terdaftar melalui Google Login
        if (empty($user->password)) {
            return back()->withErrors([
                'email' => 'Akun ini terdaftar melalui Google Login. Silakan login langsung menggunakan tombol Google.'
            ]);
        }
        $token = Str::random(64);

        // Simpan token ke tabel password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Kirim email berisi link reset password
        $link = route('password.reset', $token) . '?email=' . $request->email;

        Mail::raw(
            "Klik link berikut untuk reset password:\n\n$link\n\nLink berlaku 60 menit.",
            function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Reset Password SISEKAR');
            }
        );

        return back()->with('success', 'Link reset password telah dikirim ke email.');
    }

    // FORM RESET PASSWORD
    public function reset($token, Request $request)
    {
        return view('frontend.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // UPDATE PASSWORD BARU
    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors([
                'email' => 'Token reset tidak valid.'
            ]);
        }

        // Update password pengguna
        DataPengguna::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
