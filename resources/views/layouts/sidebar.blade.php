<!-- Sidebar -->
<aside class="w-72 bg-premium-dark flex flex-col sticky top-0 h-screen overflow-hidden border-r border-white/5">
    <!-- Top Decoration -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary-orange to-transparent opacity-50"></div>
    
    <div class="p-10">
        <a href="/" class="flex items-center justify-center p-4 bg-white/5 rounded-3xl backdrop-blur-md border border-white/10 hover:border-primary-orange/50 transition-all duration-500 group">
            <img src="{{ asset('icon/loog.png') }}" alt="Logo MFLS" class="h-14 w-auto transform group-hover:scale-110 transition-transform duration-500">
        </a>
    </div>

    <nav class="flex-grow px-6 space-y-2 mt-4 overflow-y-auto custom-scrollbar">
        @php
            $menus = [
                ['url' => '/pendaftar/dashboard', 'label' => 'Dashboard', 'icon' => 'solar:home-2-bold-duotone'],
                ['url' => '/pendaftar/biodata', 'label' => 'Biodata Diri', 'icon' => 'solar:user-circle-bold-duotone'],
                ['url' => '/pendaftar/berkas', 'label' => 'Upload Berkas', 'icon' => 'solar:cloud-upload-bold-duotone'],
                ['url' => '/pendaftar/nilai', 'label' => 'Nilai Rapor', 'icon' => 'solar:chart-square-bold-duotone'],
                ['url' => '/pendaftar/twibbon', 'label' => 'Twibbon', 'icon' => 'solar:gallery-wide-bold-duotone'],
            ];
        @endphp

        @foreach($menus as $menu)
        @php $isActive = request()->is(ltrim($menu['url'], '/')); @endphp
        <a href="{{ $menu['url'] }}" 
           class="flex items-center gap-4 px-5 py-4 rounded-2xl transition-all duration-300 group relative {{ $isActive ? 'bg-primary-orange/10 text-primary-orange ring-1 ring-primary-orange/30' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
            @if($isActive)
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-primary-orange rounded-r-full shadow-[0_0_15px_rgba(249,115,22,0.8)]"></div>
            @endif
            <span class="iconify text-2xl transition-transform group-hover:scale-110 {{ $isActive ? 'text-primary-orange text-shadow-orange' : 'text-gray-500' }}" data-icon="{{ $menu['icon'] }}"></span>
            <span class="text-sm font-bold tracking-wide">{{ $menu['label'] }}</span>
        </a>
        @endforeach
    </nav>

    <!-- User Profile Glassmorphism -->
    <div class="p-6">
        <form action="/logout" method="POST" class="m-0">
            @csrf
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-primary-orange/20 to-transparent rounded-[2.5rem] blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                <div class="relative bg-white/5 backdrop-blur-xl p-4 rounded-[2rem] border border-white/10 flex items-center gap-3 transition-colors group-hover:bg-white/10">
                    @php
                        $user = Auth::user();
                        $foto = $user->peserta->berkas->foto ?? null;
                        $fotoUrl = $foto ? asset('storage/' . $foto) : "https://ui-avatars.com/api/?name=".urlencode($user->nama)."&background=f97316&color=ffffff";
                    @endphp
                    <div class="h-10 w-10 rounded-xl overflow-hidden flex-shrink-0 border border-white/20 shadow-lg transition-transform group-hover:scale-105">
                        <img src="{{ $fotoUrl }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-grow min-w-0">
                        <p class="text-[11px] font-black text-white truncate uppercase tracking-tighter">{{ explode(' ', $user->nama)[0] }}</p>
                        <p class="text-[9px] text-primary-orange font-bold uppercase tracking-widest opacity-80">Pendaftar</p>
                    </div>
                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-red-400 transition-colors" title="Logout">
                        <span class="iconify" data-icon="solar:logout-bold-duotone" data-width="20"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</aside>
