<?php

namespace App\Http\Controllers;

use App\Models\StrukturPemerintahan;

class StrukturPemerintahanController extends Controller
{
    public function index()
    {
        $struktur = StrukturPemerintahan::orderBy('jabatan')->get();

        return view('frontend.struktur-pemerintahan', compact('struktur'));
    }
}
