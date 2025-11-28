<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class FrontendController extends Controller
{
    public function profilDesa()
    {
        $berita_terbaru = Berita::latest()->take(4)->get();
        return view('frontend.profil-desa', compact('berita_terbaru'));
    }

    public function pengajuanSurat()
    {
        return view('frontend.pengajuan-surat');
    }
}
