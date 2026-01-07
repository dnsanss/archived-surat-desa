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

    public function sendLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Tambahkan trim() untuk menghapus spasi yang tidak sengaja terketik
        $emailInput = trim($request->email);

        // Cari user berdasarkan email
        $user = DataPengguna::where('email', $emailInput)->first();

        // Debugging: Jika masih tidak terdeteksi, aktifkan baris di bawah ini untuk melihat isi $user
        // dd($user); 

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email ini tidak terdaftar di sistem kami.'
            ]);
        }

        // Jika user ditemukan tapi password kosong (biasanya login via Google/OAuth)
        if (empty($user->password)) {
            return back()->withErrors([
                'email' => 'Akun ini terdaftar melalui Google Login. Silakan login langsung menggunakan tombol Google.'
            ]);
        }
        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

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

    public function reset($token, Request $request)
    {
        return view('frontend.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

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

        DataPengguna::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
