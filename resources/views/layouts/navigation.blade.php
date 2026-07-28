<nav x-data="{ open: false }" class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 h-screen fixed shadow-sm flex flex-col justify-between">
    
    <div>
        <!-- BRANDING LOGO UIN & NAMA LAYANAN SARPRAS -->
        <div class="p-6 flex items-center space-x-3">
            <div class="w-10 h-10 flex items-center justify-center filter drop-shadow-sm">
                <img src="{{ asset('images/UIN_LOGO.png') }}" alt="Logo UIN" class="object-contain w-full h-full">
            </div>
            <span class="font-bold text-xl tracking-tight dark:text-white">
                Layanan<span class="text-indigo-600"> Sarpras</span>
            </span>
        </div>

        <div class="px-4 space-y-2 mt-4">
            
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center p-3 rounded-xl transition-all group hover:bg-indigo-50 dark:hover:bg-gray-700">
                <span class="group-hover:text-indigo-600">📊 {{ __('Dashboard') }}</span>
            </x-nav-link>

            @if(Auth::user()->role == 'user')
                <x-nav-link :href="route('report.create')" :active="request()->routeIs('report.create')" class="flex items-center p-3 rounded-xl transition-all group hover:bg-indigo-50 dark:hover:bg-gray-700">
                    <span class="group-hover:text-indigo-600">📝 Buat Laporan</span>
                </x-nav-link>
                
                <x-nav-link :href="route('report.history')" :active="request()->routeIs('report.history')" class="flex items-center p-3 rounded-xl transition-all group hover:bg-indigo-50 dark:hover:bg-gray-700">
                    <span class="group-hover:text-indigo-600">📂 Riwayat Laporanku</span>
                </x-nav-link>

                <x-nav-link :href="route('user.reviews.index')" :active="request()->routeIs('user.reviews.*')" class="flex items-center p-3 rounded-xl transition-all group hover:bg-indigo-50 dark:hover:bg-gray-700">
                    <span class="group-hover:text-indigo-600 {{ request()->routeIs('user.reviews.*') ? 'text-indigo-600 font-bold' : '' }}">
                        📝 Riwayat Review Saya
                    </span>
                </x-nav-link>
            @endif

            @if(Auth::user()->role == 'admin')
                <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')" class="flex items-center p-3 rounded-xl transition-all group hover:bg-indigo-50 dark:hover:bg-gray-700">
                    <span class="group-hover:text-indigo-600">⚙️ Kelola Laporan</span>
                </x-nav-link>
                
                <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="flex items-center p-3 rounded-xl transition-all group hover:bg-indigo-50 dark:hover:bg-gray-700">
                    <span class="group-hover:text-indigo-600 {{ request()->routeIs('admin.users.*') ? 'text-indigo-600 font-bold' : '' }}">
                        👥 Data Pengguna
                    </span>
                </x-nav-link>
                
                <x-nav-link :href="route('admin.reviews.index')" :active="request()->routeIs('admin.reviews.*')" class="flex items-center p-3 rounded-xl transition-all group hover:bg-indigo-50 dark:hover:bg-gray-700">
                    <span class="group-hover:text-indigo-600 {{ request()->routeIs('admin.reviews.*') ? 'text-indigo-600 font-bold' : '' }}">
                        ⭐ Data Review & Grafik
                    </span>
                </x-nav-link>
            @endif

            @if(Auth::user()->role == 'kasubag')
               <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')" class="flex items-center p-3 rounded-xl transition-all group hover:bg-indigo-50 dark:hover:bg-gray-700">
                   <span class="group-hover:text-indigo-600">👁️ Pantau Seluruh Laporan</span>
               </x-nav-link>
    
                <x-nav-link :href="route('admin.reviews.index')" :active="request()->routeIs('admin.reviews.*')" class="flex items-center p-3 rounded-xl transition-all group hover:bg-indigo-50 dark:hover:bg-gray-700">
                   <span class="group-hover:text-indigo-600 {{ request()->routeIs('admin.reviews.*') ? 'text-indigo-600 font-bold' : '' }}">
                       ⭐ Rekapitulasi Review & Grafik
                   </span>
                 </x-nav-link>
            @endif

            <x-nav-link :href="route('panduan')" :active="request()->routeIs('panduan')" class="flex items-center p-3 rounded-xl transition-all group hover:bg-indigo-50 dark:hover:bg-gray-700">
                 <span class="group-hover:text-indigo-600">📖 Panduan Fasilitas</span>
            </x-nav-link>
        </div>
    </div>

    <!-- PROFIL PENGGUNA DI BAGIAN BAWAH SIDEBAR -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-700 mb-4">
        <div class="flex items-center space-x-3 p-2 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800">
            <img class="h-10 w-10 rounded-full object-cover border border-indigo-400 shadow-[0_0_8px_rgba(99,102,241,0.3)]" 
                 src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}" 
                 alt="Avatar">
            
            <div class="overflow-hidden">
                <p class="text-xs font-bold text-gray-800 dark:text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-indigo-500 font-medium uppercase tracking-tighter">{{ Auth::user()->role }}</p>
            </div>
        </div>
        
        <div class="mt-4 flex flex-col space-y-1">
            <a href="{{ route('profile.edit') }}" class="text-[11px] text-gray-500 hover:text-indigo-600 py-1 flex items-center">
                ⚙️ Pengaturan Profil
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[11px] text-red-500 hover:text-red-700 py-1 w-full text-left font-medium flex items-center">
                    🚪 Keluar Sistem
                </button>
            </form>
        </div>
    </div>
</nav>