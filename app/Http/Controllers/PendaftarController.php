<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarController extends Controller
{
    public function index()
    {
        return view('pendaftar.dashboard');
    }

    public function biodata()
    {
        return view('pendaftar.biodata');
    }

    public function berkas()
    {
        return view('pendaftar.berkas');
    }
}
