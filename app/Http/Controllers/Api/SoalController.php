<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    public function index()
    {
        // Ambil soal secara acak (misal 50 soal)
        $soals = Soal::inRandomOrder()->limit(50)->get();

        return response()->json([
            'status' => 'success',
            'data' => $soals
        ]);
    }
}
