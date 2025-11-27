<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Warga - Pengajuan Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card shadow-sm">
                    <div class="card-body p-4">

                        <h4 class="text-center mb-3">Login</h4>
                        <p class="text-center text-muted">
                            Masukkan <strong>NIK</strong> dan <strong>Tanggal Lahir</strong> untuk melanjutkan.
                        </p>

                        {{-- Tampilkan error jika gagal login --}}
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        {{-- Form Login --}}
                        <form method="POST" action="{{ route('warga.login.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control" maxlength="16" placeholder="Masukkan NIK yang ada di KTP anda" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir (dd-mm-yyyy)</label>
                                <input type="password" name="password" class="form-control" placeholder="contoh: 02-12-2001" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Login
                            </button>
                        </form>

                    </div>
                </div>

                <p class="text-center mt-3 text-muted">
                    <br>Login menggunakan NIK & tanggal lahir Anda.
                </p>

            </div>
        </div>
    </div>

</body>

</html>