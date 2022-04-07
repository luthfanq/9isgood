<?php

namespace App\Http\Controllers\Keuangan\Jurnal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JurnalUmumController extends Controller
{
    public function index()
    {
        return view('pages.Keuangan.jurnal-umum-index');
    }
}
