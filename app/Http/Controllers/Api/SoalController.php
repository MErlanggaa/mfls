<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\JawabanUjian;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\GeminiService;

class SoalController extends Controller
{
    /**
     * Get list of available exams.
     */
    public function getUjians(Request $request)
    {
        $user = $request->user();
        $pesertaId = null;
        
        // Get peserta_id if user is logged in as pendaftar
        if ($user && $user->role === 'pendaftar' && $user->peserta) {
            $pesertaId = $user->peserta->id;
        }
        
        $ujians = Ujian::select('id', 'nama')
            ->withCount('soals as jumlah_soal') // Count questions
            ->get()
            ->map(function ($ujian) use ($pesertaId) {
                $data = [
                    'id' => $ujian->id,
                    'nama' => $ujian->nama,
                    'jumlah_soal' => $ujian->jumlah_soal,
                    'is_submitted' => false,
                ];
                
                // Check if user has already submitted this exam
                if ($pesertaId) {
                    $hasSubmitted = JawabanUjian::where('ujian_id', $ujian->id)
                        ->where('peserta_id', $pesertaId)
                        ->exists();
                    $data['is_submitted'] = $hasSubmitted;
                }
                
                return $data;
            });
        
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
            ->get(['id', 'ujian_id', 'pertanyaan', 'gambar', 'opsi_a', 'opsi_a_image', 'opsi_b', 'opsi_b_image', 'opsi_c', 'opsi_c_image', 'opsi_d', 'opsi_d_image', 'opsi_e', 'opsi_e_image', 'kategori', 'bobot'])
            ->map(function ($soal) {
                $data = $soal->toArray();
                $baseUrl = request()->getSchemeAndHttpHost() . '/storage/';
                
                $data['gambar'] = $soal->gambar ? $baseUrl . $soal->gambar : null;
                $data['opsi_a_image'] = $soal->opsi_a_image ? $baseUrl . $soal->opsi_a_image : null;
                $data['opsi_b_image'] = $soal->opsi_b_image ? $baseUrl . $soal->opsi_b_image : null;
                $data['opsi_c_image'] = $soal->opsi_c_image ? $baseUrl . $soal->opsi_c_image : null;
                $data['opsi_d_image'] = $soal->opsi_d_image ? $baseUrl . $soal->opsi_d_image : null;
                $data['opsi_e_image'] = $soal->opsi_e_image ? $baseUrl . $soal->opsi_e_image : null;
                return $data;
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
        $ujian = Ujian::findOrFail($ujianId);
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

        // Handle AI Analysis for Pemetaan Diri
        $kesimpulanAi = null;
        if (str_contains(strtolower($ujian->nama), 'pemetaan diri')) {
            $categoryScores = [];
            $categoryCounts = [];
            
            // Map values: A=1, B=2, C=3, D=4, E=5
            $valMap = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
            
            foreach ($soals as $soal) {
                $userAns = strtolower($submittedAnswers[$soal->id] ?? '');
                $val = $valMap[$userAns] ?? 0;
                
                if ($val > 0) {
                    $cat = $soal->kategori ?? 'Umum';
                    $categoryScores[$cat] = ($categoryScores[$cat] ?? 0) + $val;
                    $categoryCounts[$cat] = ($categoryCounts[$cat] ?? 0) + 1;
                }
            }
            
            $finalAverages = [];
            foreach ($categoryScores as $cat => $sum) {
                $finalAverages[$cat] = round($sum / $categoryCounts[$cat], 2);
            }
            
            $gemini = new GeminiService();
            $kesimpulanAi = $gemini->analyzePemetaanDiri(json_encode(['scores' => $finalAverages]));
        }

        // Save to jawaban_ujian (Detailed JSON)
        $result = JawabanUjian::create([
            'ujian_id' => $ujianId,
            'peserta_id' => $peserta->id,
            'jawaban' => json_encode($submittedAnswers),
            'nilai' => $totalScore,
            'kesimpulan_ai' => $kesimpulanAi
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
