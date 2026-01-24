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
            
            // Periksa role user
            if (Auth::user()->role !== 'pendaftar') {
                Auth::logout();
                return back()->with('loginError', 'Area ini khusus pendaftar. Gunakan Login Internal.');
            }
            
            return redirect()->intended('/pendaftar/dashboard');
        }

        return back()->with('loginError', 'Email atau password salah!');
    }

    public function showInternalLogin()
    {
        return view('auth.internal_login');
    }

    public function internalLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Blokir jika pendaftar mencoba login admin
            if (Auth::user()->role === 'pendaftar') {
                Auth::logout();
                return back()->with('loginError', 'Pendaftar tidak memiliki akses ke sini.');
            }
            
            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('loginError', 'Kredensial salah atau tidak memiliki akses.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:peserta',
            'email' => 'required|string|email|max:255|unique:akun',
            'password' => 'required|string|min:8|confirmed',
            'no_whatsapp' => 'required|string',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'tahun_lulus' => 'required|integer',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'nama_sekolah' => 'required|string',
            'telp_sekolah' => 'nullable|string',
            'kode_referral' => 'nullable|string|max:50',
            'g-recaptcha-response' => 'required',
        ]);

        // Verify Google reCAPTCHA
        $secretKey = env('RECAPTCHA_SECRET_KEY');
        $response = $request->input('g-recaptcha-response');
        $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$response}");
        $responseData = json_decode($verifyResponse);

        if (!$responseData->success) {
            return back()->withErrors(['g-recaptcha-response' => 'Verifikasi robot gagal, silakan coba lagi.'])->withInput();
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            // 1. Create Akun
            $user = Akun::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pendaftar', // Use 'pendaftar' matching DB enum
            ]);

            // 2. Create Peserta
            $peserta = \App\Models\Peserta::create([
                'akun_id' => $user->id,
                'nama' => $request->nama,
                'no_whatsapp' => $request->no_whatsapp,
                'tgl_lahir' => $request->tgl_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tahun_lulus' => $request->tahun_lulus,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'nama_sekolah' => $request->nama_sekolah,
                'telp_sekolah' => $request->telp_sekolah,
                'nisn' => $request->nisn,
            ]);

            // 3. Create Daftar (Initial Registration Data)
            \App\Models\Daftar::create([
                'peserta_id' => $peserta->id,
                'no_wa' => $request->no_whatsapp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tahun_lulus' => $request->tahun_lulus,
                'ttl' => $request->tgl_lahir, // Using date for now
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'asal_sekolah' => $request->nama_sekolah,
                'no_sekolah' => $request->telp_sekolah ?? '-', // Default if null
                'kode_referral' => $request->kode_referral,
            ]);
        });

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
