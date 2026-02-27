@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h2 class="text-xl sm:text-2xl font-black text-gray-800">Detail Akademik</h2>
        <p class="text-gray-500 text-sm">Transkrip Nilai Raport: {{ $user->nama }}</p>
    </div>
    <a href="{{ route('admin.raport.index') }}" class="inline-flex self-start sm:self-auto items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-2xl text-xs font-black shadow-sm hover:bg-slate-50 transition-all uppercase tracking-widest">
        <span class="iconify" data-icon="solar:arrow-left-bold"></span> Kembali
    </a>
</div>

<div class="space-y-8">
    <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
            <h3 class="text-lg sm:text-xl font-black text-slate-800 flex items-center gap-2">
                <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm">📊</span>
                Detail Transkrip (Sem. 1-6)
            </h3>
            <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 rounded-xl text-xs font-black border border-indigo-100 uppercase self-start sm:self-auto">Avg: {{ number_format($rataRata, 2) }}</span>
        </div>
        
        <div class="overflow-x-auto -mx-8 px-8">
            <table class="w-full text-sm text-center border-separate border-spacing-x-1">
                <thead>
                    <tr class="text-slate-400 font-black text-[10px] uppercase tracking-widest">
                        <th class="py-4 text-left px-4">Mata Pelajaran</th>
                        @for($i=1; $i<=6; $i++)
                            <th class="py-4">S{{ $i }}</th>
                        @endfor
                        <th class="py-4 bg-slate-50 rounded-lg">Rata2</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $allNilai = $user->peserta->nilais;
                        $matpels = $user->peserta->nilais->pluck('matpel')->unique('id');
                        $totalPerSemester = array_fill(1, 6, 0);
                        $countPerSemester = array_fill(1, 6, 0);
                    @endphp
                    @foreach($matpels as $mp)
                        <tr class="group">
                            <td class="py-4 text-left px-4 font-black text-slate-700">{{ $mp->nama }}</td>
                            @php $totalMp = 0; $countMp = 0; @endphp
                            @for($sem=1; $sem<=6; $sem++)
                                @php
                                    $nilai = $allNilai->where('matpel_id', $mp->id)->where('semester', $sem)->first();
                                    $val = $nilai ? $nilai->nilai : 0;
                                    if($val > 0) {
                                        $totalMp += $val; $countMp++;
                                        $totalPerSemester[$sem] += $val; $countPerSemester[$sem]++;
                                    }
                                @endphp
                                <td class="py-4 font-bold text-slate-500 {{ $val >= 90 ? 'text-blue-600' : '' }}">
                                    {{ $val ?: '-' }}
                                </td>
                            @endfor
                            <td class="py-4 bg-slate-50 rounded-lg font-black text-blue-600">
                                {{ $countMp > 0 ? number_format($totalMp / $countMp, 1) : '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-blue-600 text-white font-black">
                        <td class="py-4 text-left px-6 rounded-l-2xl uppercase tracking-widest text-[10px]">Rata-Rata Sem.</td>
                        @for($sem=1; $sem<=6; $sem++)
                            <td class="py-4">
                                {{ $countPerSemester[$sem] > 0 ? number_format($totalPerSemester[$sem] / $countPerSemester[$sem], 1) : '-' }}
                            </td>
                        @endfor
                        <td class="py-4 rounded-r-2xl bg-yellow-400 text-blue-900 border-l-4 border-white">
                            {{ number_format($rataRata, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
