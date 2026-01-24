<?php

namespace App\Http\Controllers;

use App\Models\Survei;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function show()
    {
        return view('auth.survey');
    }

    public function store(Request $request)
    {
        $request->validate([
            'info_sumber' => 'required|string',
            'motivasi' => 'required|array',
        ]);

        Survei::create([
            'akun_id' => Auth::id(),
            'info_sumber' => $request->info_sumber,
            'motivasi' => implode(', ', $request->motivasi),
            'bersedia_informasi_lain' => $request->has('bersedia_informasi_lain') ? $request->bersedia_informasi_lain : false,
            'daftar_beasiswa_lain' => $request->has('daftar_beasiswa_lain') ? $request->daftar_beasiswa_lain : false,
            'daftar_univ_lain' => $request->has('daftar_univ_lain') ? $request->daftar_univ_lain : false,
            'mengikuti_osis' => $request->has('mengikuti_osis') ? $request->mengikuti_osis : false,
            'mengikuti_forum_osis' => $request->has('mengikuti_forum_osis') ? $request->mengikuti_forum_osis : false,
            'anggota_forum_anak' => $request->has('anggota_forum_anak') ? $request->anggota_forum_anak : false,
            'sudah_diterima_kampus_lain' => $request->has('sudah_diterima_kampus_lain') ? $request->sudah_diterima_kampus_lain : false,
            'sudah_daftar_diterima_mncuniversity' => $request->has('sudah_daftar_diterima_mncuniversity') ? $request->sudah_daftar_diterima_mncuniversity : false,
        ]);

        return redirect('/pendaftar/dashboard');
    }
}
