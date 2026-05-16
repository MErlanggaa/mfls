<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    /**
     * Analyze personality based on dimension scores.
     * 
     * @param string $jsonData
     * @return string
     */
    public function analyzePemetaanDiri(string $jsonData)
    {
        if (!$this->apiKey) {
            return "AI Analysis is currently unavailable (API Key missing).";
        }

        $data = json_decode($jsonData, true);
        $scores = $data['scores'];
        $prompt = "Kamu adalah Arion, asisten AI cerdas dari MNC University. Tugasmu adalah melakukan analisis kepribadian dan potensi (Pemetaan Diri) berdasarkan skor rata-rata (skala 1-5) pada 5 dimensi berikut ini:\n\n";

        foreach ($scores as $dimension => $score) {
            $prompt .= "- **$dimension**: $score / 5.00\n";
        }

        $prompt .= "\n**Petunjuk Analisis Padat & Berbobot:**\n";
        $prompt .= "1. Berikan interpretasi yang mendalam namun PADAT (To the point).\n";
        $prompt .= "2. Analisis dimensi utama yang menonjol (kekuatan) dan satu area yang perlu ditingkatkan.\n";
        $prompt .= "3. Hubungkan dengan potensi karir secara ringkas.\n";
        $prompt .= "4. Gunakan gaya bahasa inspiratif dan profesional.\n";
        $prompt .= "5. Tuliskan dalam TEPAT 3 PARAGRAF yang tidak terlalu panjang tapi sangat berbobot.\n";
        $prompt .= "6. Sapa dia sebagai 'Future Leader'.";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '?key=' . $this->apiKey, [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'maxOutputTokens' => 1500,
                        ]
                    ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? "Gagal mendapatkan analisis AI.";
            }

            Log::error('Gemini API Error: ' . $response->body());
            return "Maaf, sistem AI kami sedang sibuk. Silakan coba beberapa saat lagi.";

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return "Terjadi kesalahan saat menghubungi layanan AI.";
        }
    }

    /**
     * Analyze personality based on answers.
     * 
     * @param array $questionsAndAnswers
     * @return string
     */
    /**
     * Analyze personality based on a PDF document.
     * 
     * @param string $base64Pdf
     * @return string
     */
    public function analyzePemetaanDiriPdf(string $base64Pdf)
    {
        if (!$this->apiKey) {
            return "AI Analysis is currently unavailable (API Key missing).";
        }

        $prompt = "Kamu adalah Arion, asisten AI cerdas dari MNC University. Di bawah ini adalah dokumen hasil 'Pemetaan Diri' dari calon mahasiswa. \n\n";
        $prompt .= "Tugasmu adalah:\n";
        $prompt .= "1. Baca dan pahami seluruh isi dokumen hasil pemetaan tersebut.\n";
        $prompt .= "2. Berikan interpretasi mendalam tentang karakter, kekuatan, dan area pengembangan calon mahasiswa ini.\n";
        $prompt .= "3. Hubungkan hasil ini dengan potensi keberhasilannya di dunia perkuliahan dan karir masa depan.\n";
        $prompt .= "4. Gunakan gaya bahasa yang inspiratif, profesional, dan menyemangati.\n";
        $prompt .= "5. Pastikan kesimpulan mencerminkan bahwa ia memiliki kualitas 'Future Leader'.\n";
        $prompt .= "6. Tuliskan dalam 3-4 paragraf yang mengalir dan sapa dia sebagai 'Future Leader'.";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '?key=' . $this->apiKey, [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt],
                                    [
                                        'inline_data' => [
                                            'mime_type' => 'application/pdf',
                                            'data' => $base64Pdf
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'maxOutputTokens' => 2048,
                        ]
                    ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? "Gagal mengekstrak analisis dari PDF.";
            }

            Log::error('Gemini API PDF Error: ' . $response->body());
            return "Maaf, AI gagal menganalisis dokumen PDF tersebut. Pastikan file PDF terbaca dengan jelas.";

        } catch (\Exception $e) {
            Log::error('Gemini Service PDF Exception: ' . $e->getMessage());
            return "Terjadi kesalahan saat memproses dokumen PDF.";
        }
    }
}
