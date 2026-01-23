<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:akun',
            'password' => 'required|string|min:8|confirmed',
            'no_whatsapp' => 'required|string',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'tahun_lulus' => 'required|integer',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'nama_sekolah' => 'required|string',
        ]);

        $user = Akun::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pendaftar',
        ]);

        // Create Peserta profile
        \App\Models\Peserta::create([
            'akun_id' => $user->id,
            'nama' => $request->nama,
            'no_whatsapp' => $request->no_whatsapp,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tahun_lulus' => $request->tahun_lulus,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'nama_sekolah' => $request->nama_sekolah,
            'nisn' => rand(1000000000, 9999999999), // Placeholder NISN for now
        ]);

        Auth::login($user);

        return redirect('/survey');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
