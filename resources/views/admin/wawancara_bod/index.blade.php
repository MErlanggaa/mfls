@extends('layouts.admin')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-black text-slate-800">Wawancara BoD (Beasiswa 100%)</h2>
        <p class="text-slate-500">Penilaian Kelayakan Wawancara BoD khusus penerima Beasiswa 100%.</p>
    </div>
</div>

<!-- Database Table -->
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[10px] tracking-[0.2em]">
                <tr>
                    <th class="px-6 py-5">Mahasiswa / Pendaftar</th>
                    <th class="px-6 py-5 text-center">Sekolah</th>
                    <th class="px-6 py-5 text-center">Rekomendasi / Keputusan Beasiswa</th>
                    <th class="px-6 py-5 text-center">Status Kelayakan</th>
                    <th class="px-6 py-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 uppercase">
                @foreach($pesertas as $akun)
                <tr class="hover:bg-slate-50/50 transition-all group">
                    <td class="px-6 py-4">
                        <div class="font-black text-slate-800">{{ $akun->nama }}</div>
                        <div class="text-[9px] font-bold text-blue-500 tracking-widest">{{ $akun->peserta->nisn ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="text-xs font-bold text-slate-500">{{ $akun->peserta->daftar->asal_sekolah ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col gap-1 items-center">
                            @if($akun->peserta->penilaianAkademiks->first()?->rekomendasi_beasiswa)
                                <span class="px-3 py-1 bg-purple-50 text-purple-700 rounded-lg text-[9px] font-black border border-purple-100" title="Rekomendasi Wawancara Akademik">
                                    Rek: {{ $akun->peserta->penilaianAkademiks->first()->rekomendasi_beasiswa }}
                                </span>
                            @endif
                            
                            @if($akun->peserta->daftar->nominal_beasiswa)
                                <span class="px-3 py-1 bg-green-50 text-green-700 rounded-lg text-[9px] font-black border border-green-100" title="Keputusan Final Admin">
                                    Final: {{ $akun->peserta->daftar->nominal_beasiswa }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($akun->peserta->daftar->status_wawancara_bod === 'Layak')
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-[10px] font-black border border-blue-100">Layak</span>
                        @elseif($akun->peserta->daftar->status_wawancara_bod === 'Tidak Layak')
                            <span class="px-3 py-1 bg-red-50 text-red-700 rounded-lg text-[10px] font-black border border-red-100">Tidak Layak</span>
                        @else
                            <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black border border-slate-200">Belum Dinilai</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.wawancara_bod.update', $akun->peserta->daftar->id) }}" method="POST" class="flex justify-end items-center gap-2">
                            @csrf
                            <select name="status_wawancara_bod" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold text-slate-700 focus:border-orange-500 outline-none">
                                <option value="" {{ empty($akun->peserta->daftar->status_wawancara_bod) ? 'selected' : '' }}>Pilih Kelayakan</option>
                                <option value="Layak" {{ $akun->peserta->daftar->status_wawancara_bod === 'Layak' ? 'selected' : '' }}>Layak</option>
                                <option value="Tidak Layak" {{ $akun->peserta->daftar->status_wawancara_bod === 'Tidak Layak' ? 'selected' : '' }}>Tidak Layak</option>
                            </select>
                            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-xs font-black hover:bg-blue-700 transition-all uppercase">
                                Simpan
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($pesertas->isEmpty())
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-bold">
                        Tidak ada data penerima beasiswa 100%.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
