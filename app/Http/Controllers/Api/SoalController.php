<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\JawabanUjian;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoalController extends Controller
{
    /**
     * Get list of available exams.
     */
    public function getUjians()
    {
        $ujians = Ujian::select('id', 'nama')->get();
        return response()->json([
            'status' => 'success',
            'data' => $ujians
        ]);
    }

    /**
     * Get questions for an exam.
     */
    public function index(Request $request)
    {
        $ujianId = $request->query('ujian_id');

        if (!$ujianId) {
            return response()->json([
                'status' => 'error',
                'message' => 'ujian_id is required'
            ], 400);
        }

        $ujian = Ujian::findOrFail($ujianId);
        $soals = Soal::where('ujian_id', $ujianId)
            ->inRandomOrder()
            ->get(['id', 'ujian_id', 'pertanyaan', 'gambar', 'opsi_a', 'opsi_a_image', 'opsi_b', 'opsi_b_image', 'opsi_c', 'opsi_c_image', 'opsi_d', 'opsi_d_image', 'bobot'])
            ->map(function ($soal) {
                $soal->gambar = $soal->gambar ? asset('storage/' . $soal->gambar) : null;
                $soal->opsi_a_image = $soal->opsi_a_image ? asset('storage/' . $soal->opsi_a_image) : null;
                $soal->opsi_b_image = $soal->opsi_b_image ? asset('storage/' . $soal->opsi_b_image) : null;
                $soal->opsi_c_image = $soal->opsi_c_image ? asset('storage/' . $soal->opsi_c_image) : null;
                $soal->opsi_d_image = $soal->opsi_d_image ? asset('storage/' . $soal->opsi_d_image) : null;
                return $soal;
            });

        return response()->json([
            'status' => 'success',
            'ujian' => $ujian->nama,
            'data' => $soals
        ]);
    }

    /**
     * Submit answers and get score.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'ujian_id' => 'required|exists:ujian,id',
            'answers' => 'required|array', // Structure: { "soal_id": "a", "soal_id_2": "b" }
        ]);

        $user = $request->user();
        if ($user->role !== 'pendaftar') {
            return response()->json(['message' => 'Hanya pendaftar yang bisa mengambil ujian.'], 403);
        }

        $peserta = $user->peserta;
        if (!$peserta) {
            return response()->json(['message' => 'Profil peserta tidak ditemukan.'], 404);
        }

        // Check if already submitted
        $existing = JawabanUjian::where('ujian_id', $request->ujian_id)
            ->where('peserta_id', $peserta->id)
            ->first();
        
        if ($existing) {
             return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah mengerjakan ujian ini sebelumnya.',
                'score' => $existing->nilai
            ], 400);
        }

        $ujianId = $request->ujian_id;
        $submittedAnswers = $request->answers;
        
        // Get all questions for this exam to calculate score
        $soals = Soal::where('ujian_id', $ujianId)->get();
        
        $totalScore = 0;
        $maxScore = $soals->sum('bobot');
        $correctCount = 0;
        $totalCount = $soals->count();

        foreach ($soals as $soal) {
            $userAnswer = $submittedAnswers[$soal->id] ?? null;
            if ($userAnswer && strtolower($userAnswer) === strtolower($soal->kunci_jawaban)) {
                $totalScore += $soal->bobot;
                $correctCount++;
            }
        }

        // Calculate final score out of 100 based on weight
        $finalScore = $maxScore > 0 ? round(($totalScore / $maxScore) * 100, 2) : 0;

        // Save to jawaban_ujian (Detailed JSON)
        $result = JawabanUjian::create([
            'ujian_id' => $ujianId,
            'peserta_id' => $peserta->id,
            'jawaban' => json_encode($submittedAnswers),
            'nilai' => $totalScore // Store RAW score (sum of weights) as requested
        ]);

        // Save to nilai_ujian (Official Score Summary)
        \App\Models\NilaiUjian::create([
            'ujian_id' => $ujianId,
            'peserta_id' => $peserta->id,
            'skor_asli' => $totalScore,
            'skor_rata' => $finalScore
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jawaban berhasil disimpan.',
            'results' => [
                'earned_raw_score' => $totalScore,
                'max_raw_score' => $maxScore,
                'score' => $finalScore,
                'correct_answers' => $correctCount,
                'total_questions' => $totalCount,
            ]
        ]);
    }
}
