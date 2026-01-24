@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.pendaftar.index') }}" class="text-gray-500 hover:text-dark-navy font-bold flex items-center gap-2 mb-4">
        ← Kembali ke Daftar
    </a>
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h1 class="text-3xl font-black text-dark-navy">{{ $user->nama }}</h1>
            <p class="text-gray-500 font-medium">{{ $user->email }} • {{ $user->peserta->nisn ?? 'NISN Tidak Ada' }}</p>
            <div class="flex gap-2 mt-2">
                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">{{ $user->peserta->daftar->asal_sekolah ?? '-' }}</span>
                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">{{ $user->peserta->daftar->provinsi ?? '-' }}</span>
            </div>
        </div>
        <div class="text-right">
            <div class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Rata-Rata Total</div>
            <div class="text-5xl font-black text-primary-gold">{{ number_format($rataRata, 2) }}</div>
        </div>
    </div>
</div>

<!-- Tabel Nilai Raport -->
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">
    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
        <span>📚</span> Transkrip Nilai Raport (Sem. 1-6)
    </h3>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead>
                <tr class="bg-dark-navy text-white text-xs uppercase">
                    <th class="px-4 py-3 rounded-tl-lg">Mata Pelajaran</th>
                    @for($i=1; $i<=6; $i++)
                        <th class="px-4 py-3 text-center">Smstr {{ $i }}</th>
                    @endfor
                    <th class="px-4 py-3 text-center rounded-tr-lg bg-primary-gold text-dark-navy">Rata-Rata MP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                    // Grouping nilai by Matpel
                    $allNilai = $user->peserta->nilais;
                    $matpels = $allNilai->pluck('matpel')->unique('id');
                    $totalPerSemester = array_fill(1, 6, 0);
                    $countPerSemester = array_fill(1, 6, 0);
                @endphp

                @foreach($matpels as $mp)
                <tr class="hover:bg-gray-50 font-medium text-gray-700">
                    <td class="px-4 py-3 border-r border-gray-100 font-bold">{{ $mp->nama }}</td>
                    
                    @php $totalMp = 0; $countMp = 0; @endphp

                    @for($sem=1; $sem<=6; $sem++)
                        @php
                            $nilai = $allNilai->where('matpel_id', $mp->id)->where('semester', $sem)->first();
                            $val = $nilai ? $nilai->nilai : 0;
                            
                            if($val > 0) {
                                $totalMp += $val;
                                $countMp++;
                                $totalPerSemester[$sem] += $val;
                                $countPerSemester[$sem]++;
                            }
                        @endphp
                        <td class="px-4 py-3 text-center text-gray-600 {{ $val == 0 ? 'bg-red-50' : '' }}">
                            {{ $val > 0 ? $val : '-' }}
                        </td>
                    @endfor

                    <td class="px-4 py-3 text-center font-bold text-dark-navy bg-gray-50 border-l border-gray-100">
                        {{ $countMp > 0 ? number_format($totalMp / $countMp, 2) : '-' }}
                    </td>
                </tr>
                @endforeach

                <!-- Baris Rata-Rata Semester -->
                <tr class="bg-gray-100 font-black text-dark-navy border-t-2 border-gray-200">
                    <td class="px-4 py-4 text-right pr-6 uppercase tracking-wider text-xs">Rata-Rata Semester</td>
                    @for($sem=1; $sem<=6; $sem++)
                        <td class="px-4 py-4 text-center">
                            @if($countPerSemester[$sem] > 0)
                                <span class="px-2 py-1 rounded {{ ($totalPerSemester[$sem] / $countPerSemester[$sem]) >= 90 ? 'bg-green-200 text-green-800' : 'bg-white border border-gray-200' }}">
                                    {{ number_format($totalPerSemester[$sem] / $countPerSemester[$sem], 2) }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                    @endfor
                    <td class="px-4 py-4 text-center bg-primary-gold/20 text-xl border-l border-white">
                        {{ number_format($rataRata, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Bagian Verifikasi & Aksi (Copy dari Index tapi lebih besar) -->
<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    <h3 class="text-xl font-bold text-gray-900 mb-4">Keputusan Akhir</h3>
    <div class="flex items-center gap-4">
        <form action="{{ route('admin.pendaftar.verify', $user->id) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="lulus">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg shadow-green-600/20 transition-all flex items-center gap-2">
                <span>✓</span> NYATAKAN LULUS
            </button>
        </form>

        <form action="{{ route('admin.pendaftar.verify', $user->id) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="tidak_lulus">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg shadow-red-600/20 transition-all flex items-center gap-2">
                <span>✕</span> TOLAK
            </button>
        </form>
    </div>
    <p class="text-sm text-gray-500 mt-4">* Keputusan LULUS akan otomatis mengirim email undangan ujian ke peserta.</p>
</div>
@endsection
