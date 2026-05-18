<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat! Anda Lolos Seleksi Ujian MFLS 2026</title>
</head>
<body style="margin:0;padding:0;background-color:#f0f4f8;font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0f4f8;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);max-width:600px;width:100%;">

                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#0f172a 0%,#1e3a5f 100%);padding:36px 40px;text-align:center;">
                            <img src="{{ $message->embed(public_path('icon/logoo.png')) }}" alt="MNCU Logo" style="max-width:120px;margin-bottom:16px;display:block;margin-left:auto;margin-right:auto;">
                            <div style="display:inline-block;background:#F2B451;color:#0f172a;font-size:11px;font-weight:900;letter-spacing:0.15em;text-transform:uppercase;padding:6px 18px;border-radius:50px;margin-bottom:8px;">
                                ✅ Lolos Seleksi Ujian
                            </div>
                            <h1 style="color:#ffffff;font-size:22px;font-weight:900;margin:12px 0 0;line-height:1.3;">
                                MNC Future Leader Scholarship 2026
                            </h1>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:40px;">
                            <p style="color:#374151;font-size:16px;margin:0 0 8px;">Halo, <strong style="color:#0f172a;">{{ $nama }}</strong>! 👋</p>

                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                Kami dengan bangga mengumumkan bahwa kamu telah <strong style="color:#16a34a;">LOLOS Seleksi Ujian</strong> MNCU Future Leader Scholarship 2026!
                            </p>

                            {{-- Info Card --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border-radius:16px;border:1px solid #e2e8f0;margin-bottom:28px;">
                                <tr>
                                    <td style="padding:24px;">
                                        <p style="margin:0 0 4px;font-size:10px;font-weight:900;color:#94a3b8;text-transform:uppercase;letter-spacing:0.1em;">Nama Peserta</p>
                                        <p style="margin:0 0 20px;font-size:16px;font-weight:900;color:#0f172a;">{{ $nama }}</p>

                                        <p style="margin:0 0 4px;font-size:10px;font-weight:900;color:#94a3b8;text-transform:uppercase;letter-spacing:0.1em;">Asal Sekolah</p>
                                        <p style="margin:0 0 20px;font-size:15px;font-weight:700;color:#1e40af;">{{ $asalSekolah }}</p>

                                        <p style="margin:0 0 4px;font-size:10px;font-weight:900;color:#94a3b8;text-transform:uppercase;letter-spacing:0.1em;">Ujian yang Diikuti</p>
                                        <p style="margin:0 0 20px;font-size:15px;font-weight:700;color:#0f172a;">{{ $namaUjian }}</p>

                                        <p style="margin:0 0 4px;font-size:10px;font-weight:900;color:#94a3b8;text-transform:uppercase;letter-spacing:0.1em;">Skor yang Diraih</p>
                                        <p style="margin:0;font-size:28px;font-weight:900;color:#16a34a;">{{ number_format($skor, 2) }} <span style="font-size:13px;color:#6b7280;font-weight:600;">/ 100</span></p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Status Badge --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#dcfce7,#bbf7d0);border-radius:12px;border:1px solid #86efac;margin-bottom:28px;">
                                <tr>
                                    <td style="padding:18px 24px;text-align:center;">
                                        <p style="margin:0;font-size:13px;font-weight:900;color:#15803d;text-transform:uppercase;letter-spacing:0.1em;">
                                            🎉 STATUS: LOLOS SELEKSI UJIAN CBT
                                        </p>
                                        <p style="margin:6px 0 0;font-size:12px;color:#166534;">
                                            Kamu akan berlanjut ke tahap berikutnya — Seleksi Dosen / Wawancara
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 20px;">
                                Harap pantau email ini dan website resmi beasiswa untuk informasi jadwal dan tahapan seleksi selanjutnya. Jika ada pertanyaan, silakan hubungi panitia melalui kontak resmi kami.
                            </p>

                            <p style="color:#374151;font-size:14px;line-height:1.7;margin:0;">
                                Semangat terus, <strong>{{ $nama }}</strong>! Kami tunggu di tahap selanjutnya. 💪
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:24px 40px;text-align:center;">
                            <p style="margin:0 0 4px;font-size:12px;font-weight:900;color:#0f172a;text-transform:uppercase;letter-spacing:0.1em;">
                                Panitia Seleksi MFLS 2026
                            </p>
                            <p style="margin:0;font-size:11px;color:#94a3b8;">
                                MNC University · beasiswamncuniversity@gmail.com
                            </p>
                            <p style="margin:8px 0 0;font-size:10px;color:#cbd5e1;">
                                Email ini dikirim secara otomatis. Harap tidak membalas langsung ke email ini.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
