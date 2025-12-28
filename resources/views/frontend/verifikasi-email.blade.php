<h3>Halo {{ $pengguna->nama }}</h3>

<p>Silakan klik tombol di bawah ini untuk memverifikasi email Anda:</p>

<a href="{{ route('email.verify', $pengguna->verification_token) }}"
    style="padding:10px 15px;background:#2563eb;color:#fff;text-decoration:none;">
    Verifikasi Email
</a>

<p>Jika Anda tidak merasa mendaftar, abaikan email ini.</p>