@extends('layouts.admin')

@section('content')
<!-- Notifikasi Flash -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-500 text-white rounded-2xl shadow-lg shadow-green-200 flex items-center justify-between animate-bounce">
    <div class="flex items-center gap-3">
        <span>✅</span>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">✕</button>
</div>
@endif

<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-black text-gray-800">Verifikasi Seleksi Administrasi</h2>
        <p class="text-gray-500">Cek Profil, Raport, dan Berkas Peserta: {{ $user->nama }}</p>
    </div>
    <a href="{{ route('admin.pendaftar.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-2xl text-xs font-black shadow-sm hover:bg-slate-50 transition-all uppercase tracking-widest">
        ← Kembali Ke List
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kolom Utama -->
    <div class="lg:col-span-2 space-y-8">
        <!-- 1. Identitas Global -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-blue-50/50 rounded-full translate-x-1/2 -translate-y-1/2"></div>
            <div class="flex items-center gap-8 mb-10 relative">
                <div class="w-24 h-24 bg-blue-600 text-white rounded-[1.5rem] flex items-center justify-center text-4xl font-black shadow-xl">
                    {{ substr($user->nama, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 mb-1">{{ $user->nama }}</h1>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-widest">{{ $user->peserta->nisn }}</span>
                        <span class="text-slate-300 font-bold">•</span>
                        <span class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">{{ $user->peserta->nama_sekolah }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-y-6 pt-6 border-t border-slate-50">
                <div>
                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Email / WhatsApp</label>
                    <div class="text-sm font-bold">{{ $user->email }} / {{ $user->peserta->no_whatsapp }}</div>
                </div>
                <div>
                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">TTL / Gender</label>
                    <div class="text-sm font-bold">{{ \Carbon\Carbon::parse($user->peserta->tgl_lahir)->format('d M Y') }} / {{ $user->peserta->jenis_kelamin }}</div>
                </div>
            </div>
        </div>

        <!-- 2. Rincian Raport -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-4">
                <span class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl">📚</span>
                Rincian Nilai Raport
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="text-slate-400 font-black uppercase tracking-widest border-b border-slate-50">
                            <th class="py-4 text-left">Mata Pelajaran</th>
                            @for($i=1;$i<=6;$i++) <th class="py-4 text-center">S{{$i}}</th> @endfor
                            <th class="py-4 text-center bg-slate-50">AVG</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @php $totalNilai = 0; $totalCount = 0; @endphp
                        @foreach($user->peserta->nilais->pluck('matpel')->unique('id') as $mp)
                            <tr>
                                <td class="py-4 font-black uppercase">{{ $mp->nama }}</td>
                                @php $mpAvg = 0; $mpCount = 0; @endphp
                                @for($sem=1;$sem<=6;$sem++)
                                    @php 
                                        $val = $user->peserta->nilais->where('matpel_id', $mp->id)->where('semester', $sem)->first()->nilai ?? 0;
                                        if($val > 0) { $mpAvg += $val; $mpCount++; $totalNilai += $val; $totalCount++; }
                                    @endphp
                                    <td class="py-4 text-center font-bold {{ $val > 0 ? 'text-slate-700' : 'text-slate-200' }}">{{ $val > 0 ? $val : '-' }}</td>
                                @endfor
                                <td class="py-4 text-center font-black bg-slate-50 text-blue-600">{{ $mpCount > 0 ? number_format($mpAvg/$mpCount, 1) : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-blue-600 text-white font-black text-sm">
                            <td colspan="7" class="p-4 text-right rounded-bl-2xl">RATA-RATA GLOBAL (TOTAL SCORE)</td>
                            <td class="p-4 text-center rounded-br-2xl">{{ $totalCount > 0 ? number_format($totalNilai/$totalCount, 2) : '0' }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- 3. Berkas Dokumen -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100">
            <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-4">
                <span class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl">📂</span>
                Checklist Berkas Fisik
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $berkasItems = [
                        'foto' => 'Foto Profil',
                        'rapor1' => 'Raport Smst 1',
                        'rapor2' => 'Raport Smst 2',
                        'rapor3' => 'Raport Smst 3',
                        'rapor4' => 'Raport Smst 4',
                        'rapor5' => 'Raport Smst 5',
                        'ijazah' => 'Ijazah / SKL',
                        'motivasi_video' => 'Video Motivasi'
                    ];
                @endphp
                @foreach($berkasItems as $key => $label)
                @php $file = $user->peserta->berkas->$key ?? null; @endphp
                <div class="p-6 {{ $file ? 'bg-emerald-50 border-emerald-100' : 'bg-slate-50 border-slate-100' }} rounded-3xl border flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $label }}</div>
                        <div class="text-xs font-bold {{ $file ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $file ? 'DOKUMEN TERSEDIA' : 'BELUM DIUPLOAD' }}
                        </div>
                    </div>
                    @if($file)
                        <a href="{{ asset('storage/' . $file) }}" target="_blank" class="w-10 h-10 bg-white text-emerald-600 rounded-xl flex items-center justify-center shadow-sm hover:scale-110 transition-all font-black">👁️</a>
                    @else
                        <div class="w-10 h-10 bg-white/50 text-slate-300 rounded-xl flex items-center justify-center font-black">✕</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sidebar Verifikasi -->
    <div class="space-y-8">
        <div class="bg-dark-navy p-10 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/5 rounded-full"></div>
            <h3 class="text-lg font-black mb-10 uppercase tracking-[0.2em] text-slate-400">Decision Center</h3>
            
            <div class="mb-10 p-6 bg-white/5 border border-white/10 rounded-[2rem] text-center">
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Administrasi Status</div>
                @if($user->peserta->daftar->status == 'lulus')
                    <div class="text-xl font-black text-emerald-400 uppercase">LOLOS BERKAS ✅</div>
                @elseif($user->peserta->daftar->status == 'tidak_lulus')
                    <div class="text-xl font-black text-red-400 uppercase">DITOLAK ✕</div>
                @else
                    <div class="text-xl font-black text-yellow-400 animate-pulse uppercase">PENDING ⏳</div>
                @endif
            </div>

            <div class="space-y-4 relative">
                <form action="{{ route('admin.pendaftar.verify', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="lulus">
                    <button type="button" onclick="confirmVerify(this, 'lulus', '{{ $user->nama }}')" class="w-full py-5 bg-emerald-500 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-emerald-500/20 hover:bg-emerald-600 transition-all">Setujui Berkas & Profil</button>
                </form>
                <form action="{{ route('admin.pendaftar.verify', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="tidak_lulus">
                    <button type="button" onclick="confirmVerify(this, 'tidak_lulus', '{{ $user->nama }}')" class="w-full py-5 bg-white/5 border border-white/10 text-red-300 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-500/10 transition-all">Tolak / Diskualifikasi</button>
                </form>
                @if(($user->peserta->daftar->status ?? 'menunggu') != 'menunggu')
                <form action="{{ route('admin.pendaftar.verify', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="menunggu">
                    <button type="button" onclick="confirmVerify(this, 'menunggu', '{{ $user->nama }}')" class="w-full py-5 bg-white/10 text-slate-300 rounded-2xl font-black text-[9px] uppercase tracking-widest">🔄 Batalkan Keputusan</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function confirmVerify(button, status, name) {
    let title, text, icon, confirmButtonColor;
    if (status === 'lulus') { title = 'Setujui Administrasi?'; text = `Luluskan berkas dan profil ${name}?`; icon = 'success'; confirmButtonColor = '#10b981'; } 
    else if (status === 'tidak_lulus') { title = 'Tolak Administrasi?'; text = `Tolak pendaftaran ${name}?`; icon = 'warning'; confirmButtonColor = '#ef4444'; }
    else { title = 'Reset Keputusan?'; text = `Kembalikan ${name} ke status Menunggu?`; icon = 'info'; confirmButtonColor = '#6366f1'; }

    Swal.fire({
        title: title, text: text, icon: icon,
        showCancelButton: true, confirmButtonColor: confirmButtonColor, cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Lakukan!', cancelButtonText: 'Batal',
        borderRadius: '2rem',
        customClass: { title: 'font-black', content: 'font-semibold' }
    }).then((result) => { if (result.isConfirmed) { button.closest('form').submit(); } });
}
</script>
@endsection
