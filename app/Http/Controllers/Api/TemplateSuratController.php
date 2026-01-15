<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TemplateSurat;

class TemplateSuratController extends Controller
{
    public function index()
    {
        return response()->json(
            TemplateSurat::select('id', 'nama_template')->get()
        );
    }
}
