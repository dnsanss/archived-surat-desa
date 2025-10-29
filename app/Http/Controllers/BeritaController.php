<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Menampilkan semua berita di halaman frontend.
     */
    public function index()
    {
        // Ambil data berita dari database, urutkan dari terbaru, dan tampilkan 9 berita per halaman
        $beritas = Berita::orderBy('tanggal_publikasi', 'desc')->paginate(9);

        // Kirim data berita ke view frontend.berita
        return view('frontend.berita', compact('beritas'));
    }

    /**
     * Menampilkan detail satu berita berdasarkan ID.
     */
    public function show($id)
    {
        // Ambil berita berdasarkan ID
        $berita = Berita::findOrFail($id);

        // Kirim ke view detail berita
        return view('frontend.detail-berita', compact('berita'));
    }

    /**
     * Form tambah berita (halaman admin)
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Menyimpan berita baru dari form admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal_publikasi' => 'required|date',
            'penulis' => 'required|string|max:100',
        ]);

        $data = $request->only(['judul', 'isi', 'tanggal_publikasi', 'penulis']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create($data);

        return redirect()->route('berita')->with('success', 'Berita berhasil ditambahkan.');
    }
}