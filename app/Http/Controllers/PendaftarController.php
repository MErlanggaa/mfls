<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarController extends Controller
{
    public function index()
    {
        // Get the authenticated user's peserta profile
        $peserta = Auth::user()->peserta;
        
        return view('pendaftar.dashboard', compact('peserta'));
    }

    public function biodata()
    {
        $peserta = Auth::user()->peserta;
        return view('pendaftar.biodata', compact('peserta'));
    }

    public function berkas()
    {
        $peserta = Auth::user()->peserta;
        return view('pendaftar.berkas', compact('peserta'));
    }
}
