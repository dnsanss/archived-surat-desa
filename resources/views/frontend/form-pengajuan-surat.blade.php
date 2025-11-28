@include('layouts.navbar')

<div class="container mt-5">
    <h3 class="mb-4 text-center">Form Pengajuan Surat</h3>

    <div class="card shadow">
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> Ada kesalahan pada input anda:
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('pengajuan.store') }}" method="POST">
                @csrf

                <!-- NIK -->
                <div class="mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" class="form-control" value="{{ $warga->nik }}" readonly>
                </div>

                <!-- Nama -->
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" value="{{ $warga->nama }}" readonly>
                </div>

                <!-- Nomor WA -->
                <div class="mb-3">
                    <label class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="nomor_wa" class="form-control" placeholder="Contoh: 08123456789" required>
                    @error('nomor_wa')
                    <div class="text-danger small">{{ $nomor_wa }}</div>
                    @enderror
                </div>

                <!-- Pilihan Template Surat -->
                <div class="mb-3">
                    <label class="form-label">Pilih Jenis Surat</label>
                    <select name="template_id" class="form-control" required>
                        <option value="">-- Pilih Surat --</option>
                        @foreach ($templates as $template)
                        <option value="{{ $template->id }}">
                            {{ $template->nama_template }}
                        </option>
                        @endforeach
                    </select>

                    @error('template_id')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary w-100">
                    Ajukan Surat
                </button>
            </form>
        </div>
    </div>
</div>

@include('layouts.footer')