<!DOCTYPE html>
<html>

<body>
    <h2>Halo {{ $nama }}</h2>

    <p>Silakan klik tombol di bawah ini untuk memverifikasi email Anda.</p>

    <a href="{{ url('/verify-email/' . $token) }}"
        style="padding:10px 15px; background:#16a34a; color:white; text-decoration:none;">
        Verifikasi Email
    </a>

    <p>Jika Anda tidak mendaftar, abaikan email ini.</p>
</body>

</html>