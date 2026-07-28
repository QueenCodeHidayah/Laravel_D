<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6">
                    <div class="bg-emerald-500 text-white p-4 rounded-2xl shadow-lg shadow-emerald-200 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">🎉</span>
                            <div>
                                <p class="font-bold">Berhasil!</p>
                                <p class="text-sm opacity-90">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button @click="show = false" class="text-white hover:text-emerald-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            @endif

            <div class="p-8 bg-white dark:bg-gray-800 overflow-hidden shadow-[0_10px_40px_rgba(0,0,0,0.04)] rounded-[30px] border border-indigo-50 relative">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            @if(Auth::user()->avatar && Storage::disk('public')->exists(Auth::user()->avatar))
                                <img class="h-20 w-20 rounded-full border-4 border-white shadow-xl shadow-indigo-200 object-cover" 
                                     src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                                     alt="{{ Auth::user()->name }}">
                            @elseif(Auth::user()->photo && Storage::disk('public')->exists(Auth::user()->photo))
                                <img class="h-20 w-20 rounded-full border-4 border-white shadow-xl shadow-indigo-200 object-cover" 
                                     src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                     alt="{{ Auth::user()->name }}">
                            @else
                                <img class="h-20 w-20 rounded-full border-4 border-white shadow-xl shadow-indigo-200 object-cover" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff&bold=true" 
                                     alt="{{ Auth::user()->name }}">
                            @endif
                            <div class="absolute bottom-0 right-0 h-5 w-5 bg-green-500 border-4 border-white rounded-full"></div>
                        </div>

                        <div>
                            <h1 class="text-3xl font-black text-gray-800 dark:text-white">
                                Halo, {{ Auth::user()->name }}!
                            </h1>
                            <p class="text-indigo-500 font-medium">
                                {{ Auth::user()->role == 'admin' ? 'Selamat bertugas kembali di Panel Pengelola Sarpras.' : (Auth::user()->role == 'kasubag' ? 'Selamat memantau sistem di Panel Eksekutif Kasubag.' : 'Selamat datang di Layanan Pengaduan Fasilitas Saintek.') }}
                            </p>
                        </div>
                    </div>

                    @php
                        $hasNewReport = \App\Models\Report::where('status', 'Terkirim')->exists();
                        
                        if (Auth::user()->role == 'admin') {
                            $quotes = $hasNewReport 
                                ? '["Cek min!! Itu ada laporan baru yang masuk!! 🚨", "Ayo cek kelola laporan sekarang, Min! ⚙️"]'
                                : '["Halo Admin! Semangat cek fasilitas hari ini! 💪", "Sistem aman terkendali, Min! ≽^•⩊•^≼", "Kerja bagus, pantau terus laporan masuk! ✨"]';
                        } elseif (Auth::user()->role == 'kasubag') {
                             $quotes = '["Selamat datang, Pak/Bu Kasubag! 👓", "Semua laporan sarpras siap dipantau dan dievaluasi! 📊", "Gunakan data ini untuk keputusan terbaik ya! 🏫"]';
                        } else {
                          $quotes = '["Halo! Ada fasilitas yang rusak hari ini? 📝", "Jangan lupa lapor kalau ada bangku patah ya! Meow~ 🐾", "Aplikasi Hidayah siap membantumu! 🥰", "Meow! Jagalah fasilitas kampus kita bersama ya! 🏫"]';
                        }
                    @endphp

                    <div x-data="{ 
                            mood: 'normal', 
                            currentText: '', 
                            texts: {{ $quotes }},
                            initMaskot() {
                                this.currentText = this.texts[Math.floor(Math.random() * this.texts.length)];
                                this.mood = Math.random() > 0.5 ? 'tengil' : 'normal';
                            },
                            triggerClick() {
                                if (this.mood === 'marah') return;
                                
                                this.mood = 'senang';
                                this.currentText = 'Hehehe, makasih ya udah nyapa aku! ฅ^>⩊<^ฅ';
                                
                                setTimeout(() => {
                                    this.mood = 'marah';
                                    this.currentText = 'Aduduh!! Jangan diklik terus dong, Meow!! ≽•̀ ᴖ •́ ≼ 💢';
                                }, 1200);

                                setTimeout(() => {
                                    this.mood = 'normal';
                                    this.initMaskot();
                                }, 5000);
                            }
                         }" 
                         x-init="initMaskot()" 
                         class="flex items-center space-x-4 bg-indigo-50/70 p-5 rounded-[24px] border border-indigo-100 relative max-w-md w-full justify-end">
                        
                        <div class="bg-white text-gray-800 p-3.5 rounded-2xl shadow-md text-xs font-bold border border-indigo-100 relative flex-1">
                            <span x-text="currentText"></span>
                            <div class="absolute right-[-6px] top-1/2 transform -translate-y-1/2 w-0 h-0 border-t-[6px] border-t-transparent border-b-[6px] border-b-transparent border-l-[6px] border-l-white"></div>
                        </div>

                        <div @click="triggerClick()" class="cursor-pointer select-none relative transform hover:scale-110 transition duration-200 flex-shrink-0">
                            <div class="w-24 h-20 rounded-[22px] flex flex-col items-center justify-center relative shadow-lg transition-colors duration-300"
                                 :class="{
                                    'bg-slate-800 text-white shadow-slate-200': mood == 'normal' || mood == 'tengil',
                                    'bg-indigo-600 text-white shadow-indigo-200': mood == 'senang',
                                    'bg-red-500 text-white shadow-red-200 animate-bounce': mood == 'marah'
                                 }">
                                
                                <div class="absolute top-[-8px] left-2 w-0 h-0 border-b-[14px] border-r-[14px] border-r-transparent" :class="mood == 'marah' ? 'border-b-red-500' : (mood == 'senang' ? 'border-b-indigo-600' : 'border-b-slate-800')"></div>
                                <div class="absolute top-[-8px] right-2 w-0 h-0 border-b-[14px] border-l-[14px] border-l-transparent" :class="mood == 'marah' ? 'border-b-red-500' : (mood == 'senang' ? 'border-b-indigo-600' : 'border-b-slate-800')"></div>
                                
                                <div class="font-black text-sm tracking-wide text-center px-1">
                                    <span x-show="mood == 'normal'">≽^•⩊•^≼</span>
                                    <span x-show="mood == 'tengil'">≽^-⩊-^≼</span>
                                    <span x-show="mood == 'senang'">ฅ^>⩊<^ฅ</span>
                                    <span x-show="mood == 'marah'">≽•̀ ᴖ •́ ≼</span>
                                </div>

                                <div class="text-[9px] font-black tracking-widest mt-1 opacity-75" x-text="mood.toUpperCase()"></div>

                                <div class="absolute -bottom-1 -right-2 text-2xl animate__animated animate__wobble animate__infinite" style="animation-duration: 2s;">
                                    👋
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'kasubag')
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-[30px] shadow-sm border border-gray-100 transform hover:translate-y-[-4px] transition duration-200">
                    <div class="text-gray-400 text-sm font-bold uppercase tracking-widest">📁 Total Laporan</div>
                    <div class="text-3xl font-black text-indigo-900">{{ \App\Models\Report::count() }}</div>
                </div>

                <div class="bg-white p-6 rounded-[30px] shadow-sm border border-gray-100 transform hover:translate-y-[-4px] transition duration-200">
                    <div class="text-orange-400 text-sm font-bold uppercase tracking-widest flex items-center">
                        <span class="relative flex h-2 w-2 mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                        </span>
                        Sedang Diproses
                    </div>
                    <div class="text-3xl font-black text-orange-600">
                        {{ \App\Models\Report::where('status', 'Proses')->count() }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[30px] shadow-sm border border-gray-100 transform hover:translate-y-[-4px] transition duration-200">
                    <div class="text-red-400 text-sm font-bold uppercase tracking-widest flex items-center">
                        @if($hasNewReport)
                        <span class="relative flex h-2 w-2 mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        @endif
                        Belum Dicek
                    </div>
                    <div class="text-3xl font-black text-red-600">
                        {{ \App\Models\Report::where('status', 'Terkirim')->count() }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[30px] shadow-sm border border-gray-100 transform hover:translate-y-[-4px] transition duration-200">
                    <div class="text-emerald-400 text-sm font-bold uppercase tracking-widest">✅ Sudah Selesai</div>
                    <div class="text-3xl font-black text-emerald-600">
                        {{ \App\Models\Report::where('status', 'Selesai')->count() }}
                    </div>
                </div>
            </div>
            @endif

            @if(Auth::user()->role == 'user')
            <div class="p-8 bg-gradient-to-br from-indigo-900 to-slate-900 text-white shadow-xl rounded-[40px] relative overflow-hidden">
                <div class="absolute right-0 bottom-0 opacity-10 text-9xl font-black select-none">⭐️</div>
                
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-4">
                    <div>
                        <h3 class="text-xl font-bold flex items-center">
                            <span>📝 Kotak Kepuasan & Review Fasilitas Fakultas</span>
                        </h3>
                        <p class="text-xs text-indigo-200">Berikan penilaian objektif mengenai responsivitas perbaikan sarpras untuk keperluan data statistik skripsi.</p>
                    </div>
                    
                    <a href="{{ route('user.reviews.index') }}" class="bg-white/10 hover:bg-white/20 text-white text-xs font-bold px-4 py-2 rounded-xl transition border border-white/10 text-center whitespace-nowrap">
                        📂 Lihat Riwayat Review Saya →
                    </a>
                </div>
                
                <form action="{{ route('review.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] uppercase font-black tracking-widest text-indigo-300 mb-2">Ulasan / Masukan Kamu</label>
                            <textarea rows="2" name="ulasan" required placeholder="Tulis masukan tentang kecepatan perbaikan sarana prasarana..." 
                                      class="w-full text-sm bg-white/10 border border-white/20 rounded-2xl p-4 text-white placeholder-white/40 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>

                        <div x-data="{ rating: 0, hoverRating: 0 }" class="flex flex-col justify-center items-start">
                            <label class="block text-[10px] uppercase font-black tracking-widest text-indigo-300 mb-2">Tingkat Responsivitas Fakultas</label>
                            
                            <div class="flex items-center space-x-2">
                                <input type="hidden" name="rating" :value="rating" required>
                                
                                <template x-for="star in 5">
                                    <button type="button" 
                                            @click="rating = star" 
                                            @mouseover="hoverRating = star" 
                                            @mouseleave="hoverRating = 0"
                                            class="text-3xl focus:outline-none transition-transform duration-100 hover:scale-125">
                                        <span :class="star <= (hoverRating || rating) ? 'text-amber-400' : 'text-gray-500'" x-text="'★'"></span>
                                    </button>
                                </template>
                                <span class="text-xs font-bold ml-2 bg-white/20 px-3 py-1 rounded-full text-indigo-200" x-text="rating + ' / 5 Bintang'"></span>
                            </div>
                            
                            <button type="submit" @click="if(rating === 0) { alert('Silakan pilih jumlah bintang terlebih dahulu ya!'); $event.preventDefault(); }" class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-3 rounded-xl transition duration-200 shadow-md w-full md:w-max">
                                🚀 Kirim Review Saya
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @endif

            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'kasubag')
                @php 
                    $rataRataBintang = class_exists('\App\Models\Review') ? number_format(\App\Models\Review::avg('rating') ?? 0, 1) : number_format(0.0, 1); 
                @endphp
                <div class="p-6 bg-amber-50 border border-amber-200 rounded-[30px] flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="bg-amber-500 text-white font-black text-2xl p-4 rounded-2xl shadow-md shadow-amber-200 flex-shrink-0">
                            ⭐ {{ $rataRataBintang }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg">Ringkasan Nilai Kepuasan Pengguna</h4>
                            <p class="text-xs text-gray-500">Saat ini rata-rata penilaian responsivitas fakultas berada di angka <span class="text-amber-600 font-bold">{{ $rataRataBintang }} dari 5.0</span></p>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.reviews.index') }}" class="bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold px-5 py-3 rounded-2xl shadow-md transition whitespace-nowrap">
                        👁️ Buka Data Review & Kesimpulan Rata-Rata
                    </a>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-[0_10px_40px_rgba(0,0,0,0.04)] rounded-[30px] border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-indigo-900 uppercase tracking-tighter">
                        {{ (Auth::user()->role == 'admin' || Auth::user()->role == 'kasubag') ? '📂  Laporan Masuk Terbaru' : '📝 Riwayat Laporan Saya' }}
                    </h3>
                    <a href="{{ (Auth::user()->role == 'admin' || Auth::user()->role == 'kasubag') ? route('admin.reports.index') : route('report.history') }}" class="text-xs font-bold text-indigo-600">Lihat Semua →</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50 dark:bg-gray-700">
                            <tr>
                                <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">Detail Barang</th>
                                <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">Lokasi & Wing</th>
                                <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php
                                $displayReports = (Auth::user()->role == 'admin' || Auth::user()->role == 'kasubag')
                                    ? \App\Models\Report::with('user')->latest()->take(5)->get() 
                                    : Auth::user()->reports()->latest()->get();
                            @endphp

                            @forelse($displayReports as $report)
                            <tr class="hover:bg-indigo-50/50 transition cursor-pointer group" 
                                onclick="window.location='{{ (Auth::user()->role == 'admin' || Auth::user()->role == 'kasubag') ? route('admin.reports.index') : route('report.history') }}'">
                                <td class="p-6">
                                    <div class="font-bold text-gray-800 group-hover:text-indigo-600 transition">{{ $report->nama_barang }}</div>
                                    <div class="text-[11px] text-gray-400 font-medium">Oleh: {{ $report->user->name ?? 'User' }} • {{ $report->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="p-6">
                                    <div class="text-sm text-gray-600 font-bold">{{ $report->lantai }}</div>
                                    <div class="text-xs text-indigo-400">{{ $report->wing ?? 'Non-Wing' }} | {{ $report->ruangan }}</div>
                                </td>
                                <td class="p-6 text-center">
                                    <span class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest
                                        {{ $report->status == 'Selesai' ? 'bg-green-100 text-green-600' : ($report->status == 'Proses' || $report->status == 'Diproses' ? 'bg-indigo-100 text-indigo-600' : 'bg-amber-100 text-amber-600') }}">
                                        {{ $report->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-12 text-center text-gray-400 italic">Belum ada laporan yang tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>