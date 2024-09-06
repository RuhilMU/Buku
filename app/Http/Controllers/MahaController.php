<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahaController extends Controller
{
    public function index()
    {
        $mahasiswa = DB::table('mahasiswa')->get();
        return view('index', compact('mahasiswa'));
    }
}
