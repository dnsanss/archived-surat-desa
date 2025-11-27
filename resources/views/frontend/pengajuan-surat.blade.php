@include('layouts.navbar')
<div class="container mt-5">

    {{-- CEK STATUS LOGIN --}}
    @if (!session('warga_logged_in'))

    {{-- Jika belum login --}}
    <div class="text-center p-5 border rounded">
        <h3>Anda belum masuk</h3>
        <p>Silakan masuk terlebih dahulu untuk mengakses fitur pengajuan surat.</p>
        <a href="{{ route('warga.login') }}" class="btn btn-primary">
            Masuk Disini
        </a>
    </div>

    @else
    {{-- Jika sudah login --}}
    <div class="text-center mb-4">
        <h4>Selamat Datang, <strong>{{ session('warga_nama') }}</strong></h4>
        <p>NIK: {{ session('warga_nik') }}</p>
    </div>

    <div class="row text-center">

        {{-- Menu Pengajuan Surat --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('form.pengajuan.surat') }}" class="card p-4 shadow-sm text-decoration-none">
                <h5>Pengajuan Surat</h5>
                <p>Ajukan surat secara online</p>
            </a>
        </div>

        {{-- Menu Pelacakan Surat --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('pelacakan.surat') }}" class="card p-4 shadow-sm text-decoration-none">
                <h5>Pelacakan Surat</h5>
                <p>Lihat status surat yang telah diajukan</p>
            </a>
        </div>

        {{-- Menu Penyimpanan Surat --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('penyimpanan.surat') }}" class="card p-4 shadow-sm text-decoration-none">
                <h5>Penyimpanan Surat</h5>
                <p>Lihat semua surat yang telah selesai diproses</p>
            </a>
        </div>

    </div>
    @endif

    {{-- FLASH MESSAGE --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Tombol Logout --}}
    <div class="text-center mt-4">
        <a href="{{ route('warga.logout') }}" class="btn btn-danger">Logout</a>
    </div>
    @endif

</div>
@include('layouts.footer')