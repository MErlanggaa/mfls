@extends('pendaftar.layout')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-10">
    <!-- Header Section -->
    <div class="relative overflow-hidden bg-navy-mnc p-10 md:p-14 rounded-[3rem] shadow-2xl border border-white/5">
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary-orange/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-center md:text-left">
                <h1 class="text-3xl md:text-5xl font-black text-white mb-3 tracking-tight">Biodata <span class="text-primary-orange italic">Lengkap</span></h1>
                <p class="text-orange-100/60 font-medium max-w-md text-sm leading-relaxed uppercase tracking-widest opacity-80">Pastikan seluruh data diri Anda terisi dengan benar untuk verifikasi.</p>
            </div>
            <div class="w-24 h-24 bg-white/5 rounded-3xl flex items-center justify-center text-primary-orange border border-white/10 backdrop-blur-md shadow-xl">
                <span class="iconify text-5xl" data-icon="solar:user-id-bold-duotone"></span>
            </div>
        </div>
    </div>

    <form action="{{ route('pendaftar.biodata.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Section Template -->
        @php
            $sections = [
                [
                    'id' => 'identitas',
                    'label' => 'Identitas Pribadi',
                    'icon' => 'solar:user-bold-duotone',
                    'fields' => [
                        ['name' => 'nama', 'label' => 'Nama Lengkap', 'placeholder' => 'Nama Lengkap Anda', 'type' => 'text', 'value' => $peserta->nama ?? Auth::user()->nama, 'icon' => 'solar:user-bold'],
                        ['name' => 'nisn', 'label' => 'NISN', 'placeholder' => '10 Digit NISN', 'type' => 'text', 'value' => $peserta->nisn, 'icon' => 'solar:card-2-bold'],
                        ['name' => 'jenis_kelamin', 'label' => 'Jenis Kelamin', 'type' => 'select', 'value' => $peserta->jenis_kelamin, 'icon' => 'solar:users-group-two-rounded-bold', 'options' => ['Laki-laki', 'Perempuan']],
                        ['name' => 'tgl_lahir', 'label' => 'Tanggal Lahir', 'type' => 'date', 'value' => $peserta->tgl_lahir, 'icon' => 'solar:calendar-bold']
                    ]
                ],
                [
                    'id' => 'kontak',
                    'label' => 'Kontak & Domisili',
                    'icon' => 'solar:map-point-bold-duotone',
                    'fields' => [
                        ['name' => 'no_whatsapp', 'label' => 'Nomor WhatsApp', 'placeholder' => '08xxxxxxxxxx', 'type' => 'text', 'value' => $peserta->no_whatsapp, 'icon' => 'solar:phone-bold'],
                        ['name' => 'provinsi', 'label' => 'Provinsi', 'placeholder' => 'Provinsi', 'type' => 'text', 'value' => $peserta->provinsi, 'icon' => 'solar:map-arrow-down-bold'],
                        ['name' => 'kabupaten', 'label' => 'Kabupaten/Kota', 'placeholder' => 'Kabupaten/Kota', 'type' => 'text', 'value' => $peserta->kabupaten, 'full' => true, 'icon' => 'solar:city-bold']
                    ]
                ],
                [
                    'id' => 'pendidikan',
                    'label' => 'Informasi Pendidikan',
                    'icon' => 'solar:bookmark-opened-bold-duotone',
                    'fields' => [
                        ['name' => 'nama_sekolah', 'label' => 'Asal Sekolah', 'placeholder' => 'Nama Sekolah SMA/SMK/MA', 'type' => 'text', 'value' => $peserta->nama_sekolah, 'icon' => 'solar:square-academic-cap-bold', 'full' => true],
                        ['name' => 'tahun_lulus', 'label' => 'Tahun Lulus', 'type' => 'select', 'value' => $peserta->tahun_lulus, 'icon' => 'solar:calendar-date-bold', 'options' => ['2021', '2022', '2023', '2024', '2025', '2026']],
                        ['name' => 'no_guru_bk', 'label' => 'WA Guru BK', 'placeholder' => '0812xxxx', 'type' => 'text', 'value' => $peserta->no_guru_bk, 'icon' => 'solar:chat-round-call-bold'],
                        ['name' => 'kode_referral', 'label' => 'Kode Referral (Opsional)', 'placeholder' => 'Jika ada', 'type' => 'text', 'value' => $peserta->daftar->kode_referral ?? '', 'icon' => 'solar:tag-bold', 'full' => true]
                    ]
                ]
            ];
        @endphp

        @foreach($sections as $section)
        <div class="bg-white rounded-[2.5rem] border-2 border-slate-50 shadow-sm overflow-hidden group hover:border-primary-orange/20 transition-all duration-300">
            <div class="px-8 py-6 border-b border-slate-50 flex items-center gap-3 bg-slate-50/50">
                <div class="w-10 h-10 bg-navy-mnc text-primary-orange rounded-xl flex items-center justify-center shadow-lg shadow-navy-mnc/10">
                    <span class="iconify text-xl" data-icon="{{ $section['icon'] }}"></span>
                </div>
                <h3 class="text-xs font-black text-navy-mnc uppercase tracking-[0.2em]">{{ $section['label'] }}</h3>
            </div>
            <div class="p-8 md:p-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($section['fields'] as $field)
                <div class="space-y-3 {{ ($field['full'] ?? false) ? 'col-span-full' : '' }}">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                        <div class="w-1.5 h-1.5 bg-primary-orange rounded-full"></div>
                        {{ $field['label'] }}
                    </label>
                    <div class="relative group/field">
                        @if(isset($field['icon']))
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 iconify text-xl transition-colors group-focus-within/field:text-primary-orange" data-icon="{{ $field['icon'] }}"></span>
                        @endif

                        @if($field['type'] == 'select')
                            <select name="{{ $field['name'] }}" required class="{{ isset($field['icon']) ? 'pl-14' : 'px-6' }} pr-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-primary-orange/30 outline-none transition-all font-bold text-navy-mnc appearance-none w-full shadow-sm">
                                <option value="">Pilih {{ $field['label'] }}</option>
                                @foreach($field['options'] as $opt)
                                    <option value="{{ $opt }}" {{ $field['value'] == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-300">
                                <span class="iconify" data-icon="solar:alt-arrow-down-bold"></span>
                            </div>
                        @else
                            <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" value="{{ $field['value'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" required
                                   class="{{ isset($field['icon']) ? 'pl-14' : 'px-6' }} pr-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-primary-orange/30 outline-none transition-all font-bold text-navy-mnc w-full placeholder:text-slate-300 shadow-sm">
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <!-- Account Security Section (New) -->
        <div class="bg-white rounded-[2.5rem] border-2 border-slate-50 shadow-sm overflow-hidden group hover:border-orange-500/20 transition-all duration-300">
            <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-navy-mnc text-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-navy-mnc/10">
                        <span class="iconify text-xl" data-icon="solar:shield-keyhole-bold-duotone"></span>
                    </div>
                    <h3 class="text-xs font-black text-navy-mnc uppercase tracking-[0.2em]">Keamanan Akun</h3>
                </div>
            </div>
            <div class="p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="space-y-2 text-center md:text-left">
                    <h4 class="text-sm font-black text-navy-mnc uppercase tracking-tight">Alamat Email Saat Ini</h4>
                    <p class="text-lg font-black text-primary-orange flex items-center justify-center md:justify-start gap-2">
                        <span class="iconify" data-icon="solar:letter-bold"></span>
                        {{ Auth::user()->email }}
                    </p>
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest leading-none opacity-70 italic">*Email digunakan untuk pengiriman notifikasi & reset password.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('pendaftar.email.change') }}" class="group/btn flex items-center gap-3 px-8 py-4 bg-slate-50 text-slate-500 hover:bg-orange-500 hover:text-white rounded-2xl transition-all duration-500 font-black text-[10px] uppercase tracking-widest border border-slate-200/50 hover:border-orange-500 shadow-sm hover:shadow-xl hover:shadow-orange-500/30">
                        Ganti Email <span class="iconify text-lg group-hover/btn:translate-x-1 transition-transform" data-icon="solar:arrow-right-up-bold"></span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-6">
            <button type="submit" class="group relative flex items-center gap-4 bg-navy-mnc text-white px-12 py-6 rounded-[2rem] shadow-2xl shadow-navy-mnc/20 hover:shadow-primary-orange/30 transition-all duration-500 active:scale-95 overflow-hidden">
                <div class="absolute inset-0 bg-primary-orange scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-700 opacity-20"></div>
                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center group-hover:bg-primary-orange transition-colors duration-500">
                    <span class="iconify text-xl" data-icon="solar:diskette-bold-duotone"></span>
                </div>
                <span class="text-[11px] font-black uppercase tracking-[0.3em] relative z-10">Simpan Seluruh Data</span>
            </button>
        </div>
    </form>
</div>
@endsection
