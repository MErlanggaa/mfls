<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat! Anda Lolos Seleksi Ujian MFLS 2026</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="background:#ffffff; max-width:600px; width:100%; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05); border-top:4px solid #1a365d;">
                    
                    {{-- Logo & Top Header --}}
                    <tr>
                        <td style="padding:30px 40px 20px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <img src="{{ $message->embed(public_path('icon/logoo.png')) }}" alt="MNC University" style="max-height:45px; display:block;">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top:15px;">
                                        <div style="border-bottom:2px solid #1a365d; width:100%;"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Main Content --}}
                    <tr>
                        <td style="padding:20px 40px 40px 40px;">
                            <h2 style="color:#1a365d; font-size:22px; font-weight:700; margin:0 0 24px 0; font-family:'Segoe UI', Arial, sans-serif;">
                                Selamat! Anda Lolos Seleksi Ujian
                            </h2>

                            <p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 16px 0;">
                                Halo <strong>{{ $nama }}</strong>.
                            </p>

                            <p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 16px 0;">
                                Kami dengan senang hati menginformasikan bahwa Anda telah dinyatakan <strong style="color:#1a365d;">LOLOS Seleksi Ujian</strong> (Computer Based Test) dalam program <strong>MNC Future Leader Scholarship 2026</strong>.
                            </p>

                            <p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 24px 0;">
                                Tahap selanjutnya (Seleksi Wawancara / Dosen) akan diinformasikan melalui dashboard pendaftar dan email resmi kami. Mohon pantau dashboard pendaftar dan email Anda secara berkala.
                            </p>

                            <p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 24px 0;">
                                Terima kasih atas semangat dan antusiasme Anda untuk bergabung dengan MNC University.
                            </p>

                            <p style="color:#334155; font-size:15px; line-height:1.6; margin:0 0 4px 0;">
                                Salam hangat,
                            </p>
                            <p style="color:#1a365d; font-size:15px; font-weight:700; margin:0 0 30px 0;">
                                Panitia MNCU Future Leader Scholarship
                            </p>

                            {{-- Divider --}}
                            <div style="border-top:1px solid #e2e8f0; margin-bottom:20px;"></div>

                            {{-- Footer Content --}}
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="color:#94a3b8; font-size:12px; line-height:1.5;">
                                        &copy; 2026 MNC University. All rights reserved.<br>
                                        MNC Tower, Jakarta, Indonesia
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
