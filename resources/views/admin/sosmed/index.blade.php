@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black text-gray-800">Kontrol Sosial Media</h2>
    <p class="text-gray-500">Pantau Link IG, TikTok, dan Campaign Twibbon pendaftar.</p>
</div>

<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[10px] tracking-[0.2em]">
                <tr>
                    <th class="px-6 py-5">Pendaftar</th>
                    <th class="px-6 py-5">Instagram</th>
                    <th class="px-6 py-5">TikTok</th>
                    <th class="px-6 py-5 text-center">Status Twibbon</th>
                    <th class="px-6 py-5 text-right">Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($pendaftars as $akun)
                <tr class="hover:bg-slate-50/50 transition-all group">
                    <td class="px-6 py-4">
                        <div class="font-black text-slate-800">{{ $akun->nama }}</div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID: {{ $akun->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($akun->peserta->link_ig)
                            <a href="{{ $akun->peserta->link_ig }}" target="_blank" class="text-xs font-bold text-blue-600 hover:underline">Link IG ↗</a>
                        @else
                            <span class="text-xs text-slate-300 font-bold italic">N/A</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($akun->peserta->link_tiktok)
                            <a href="{{ $akun->peserta->link_tiktok }}" target="_blank" class="text-xs font-bold text-slate-800 hover:underline">Link TikTok ↗</a>
                        @else
                            <span class="text-xs text-slate-300 font-bold italic">N/A</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($akun->peserta->link_twibbon)
                            <span class="px-3 py-1 bg-yellow-400 text-blue-900 rounded-lg text-[10px] font-black uppercase shadow-sm shadow-yellow-200">ACTIVE 🔖</span>
                        @else
                            <span class="px-3 py-1 bg-slate-100 text-slate-400 rounded-lg text-[10px] font-bold uppercase">PENDING</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.sosmed.show', $akun->id) }}" class="text-xs font-black text-blue-600 hover:text-blue-800 transition-all uppercase">Pantau Sosmed 👀</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
