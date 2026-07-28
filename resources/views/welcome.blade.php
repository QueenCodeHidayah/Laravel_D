<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Hidayah Sarpras') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:300,400,600,800,900&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Figtree', 'sans-serif'],
                        }
                    }
                }
            }
        </script>

        <style>
            /* Animasi Mewah Mengambang Bergerak */
            @keyframes float {
                0% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-10px) rotate(1deg); }
                100% { transform: translateY(0px) rotate(0deg); }
            }
            @keyframes pulse-slow {
                0%, 100% { opacity: 0.4; transform: scale(1); }
                50% { opacity: 0.6; transform: scale(1.05); }
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            .animate-pulse-slow {
                animation: pulse-slow 8s ease-in-out infinite;
            }
            .glass {
                background: rgba(255, 255, 255, 0.75);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }
        </style>
    </head>
    <body class="antialiased font-sans bg-slate-50 text-slate-800 relative overflow-x-hidden min-h-screen flex flex-col justify-between">
        
        <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-indigo-200 rounded-full mix-blend-multiply filter blur-[80px] opacity-50 animate-pulse-slow"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[600px] h-[600px] bg-amber-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-60 animate-pulse-slow" style="animation-delay: 3s;"></div>

        <header class="w-full max-w-7xl mx-auto px-6 py-5 flex justify-between items-center relative z-10">
            <div class="flex items-center space-x-3">
                <!-- LOGO UIN REVISI TERBARU -->
                <div class="w-12 h-12 flex items-center justify-center filter drop-shadow-sm">
                    <img src="{{ asset('images/UIN_LOGO.png') }}" alt="Logo UIN" class="object-contain w-full h-full">
                </div>
                <span class="font-black text-xl tracking-tight text-indigo-900">
                    {{ config('app.name', 'Hidayah Sarpras') }}
                </span>
            </div>

            @if (Route::has('login'))
                <nav class="flex items-center space-x-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-6 py-2.5 rounded-full shadow-lg shadow-indigo-100 transition-all transform hover:scale-105 duration-200">
                            Masuk Dashboard ➡️
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="font-bold text-slate-600 hover:text-indigo-600 text-sm px-4 py-2 transition-colors">
                            Log In
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-5 py-2.5 rounded-full shadow-md shadow-indigo-100 transition-all transform hover:scale-105 duration-200">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="w-full max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center my-auto relative z-10 py-8">
            
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 bg-indigo-50 border border-indigo-100 text-indigo-700 px-4 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase">
                    <span>✨ Sistem Informasi Pengaduan Inventaris</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 leading-[1.15] tracking-tight">
                    Layanan Sarpras <br>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-indigo-900">
                        Cepat, Tepat & Transparan
                    </span>
                </h1>
                
                <p class="text-slate-500 text-base sm:text-lg max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    Sistem pemantauan fasilitas terpadu. Mahasiswa lapor kendala fisik barang, Admin eksekusi perbaikan di lapangan, dan Kasubag memantau rekapitulasi data secara real-time demi kenyamanan perkuliahan kita.
                </p>

                <div class="pt-4 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-slate-900 text-white font-extrabold rounded-2xl shadow-xl hover:bg-slate-800 transition-all text-center">
                            Akses Layanan Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all text-center transform hover:translate-y-[-2px]">
                            Laporkan Kerusakan 🚀
                        </a>
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-700 border border-slate-200 font-bold rounded-2xl hover:bg-slate-50 shadow-sm transition-all text-center">
                            Buat Akun Mahasiswa
                        </a>
                    @endauth
                </div>

                <div class="pt-8 grid grid-cols-3 gap-4 border-t border-slate-200/60 max-w-md mx-auto lg:mx-0">
                    <div>
                        <div class="text-2xl font-black text-indigo-900">{{ \App\Models\Report::count() }}</div>
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Laporan</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-emerald-600">{{ \App\Models\Report::where('status', 'Selesai')->count() }}</div>
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Tuntas</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-amber-500">{{ \App\Models\Report::where('status', 'Proses')->count() }}</div>
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Diproses</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 flex justify-center items-center relative">
                <div class="w-72 h-72 sm:w-96 sm:h-96 bg-indigo-600/10 absolute rounded-full filter blur-2xl"></div>
                
                <div class="glass border border-white p-8 rounded-[40px] shadow-2xl relative w-full max-w-sm animate-float">
                    <div class="absolute -top-4 left-10 bg-amber-400 text-amber-950 font-black text-[10px] uppercase tracking-widest px-3 py-1 rounded-full shadow-sm">
                        Maskot Sarpras 🐾
                    </div>
                    
                    <div class="text-center font-bold text-indigo-900 text-4xl my-4 select-none drop-shadow-md">
                        ≽^•⩊•^≼
                    </div>
                    
                    <div class="bg-indigo-900 text-indigo-50 p-4 rounded-3xl text-xs leading-relaxed font-semibold relative shadow-inner">
                        "Meow! Selamat datang di aplikasi {{ config('app.name', 'Hidayah') }}. Ada kursi kelas patah atau AC ruang lab bocor? Jangan diam aja, yuk laporkan langsung biar segera ditangani operator!"
                        <div class="absolute bottom-[-6px] left-1/2 transform -translate-x-1/2 w-3 h-3 bg-indigo-900 rotate-45"></div>
                    </div>

                    <div class="mt-6 flex justify-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-600 animate-ping"></span>
                        <span class="text-[11px] font-bold text-indigo-600 tracking-wide uppercase">Sistem Online 24/7</span>
                    </div>
                </div>
            </div>

        </main>

        <footer class="w-full max-w-7xl mx-auto px-6 py-6 border-t border-slate-200/50 flex flex-col sm:flex-row justify-between items-center gap-4 relative z-10 text-xs text-slate-400 font-medium">
            <div>
                &copy; {{ date('Y') }} {{ config('app.name', 'Hidayah Sarpras') }} - Hak Cipta Dilindungi Undang-Undang.
            </div>
            <div class="bg-slate-200/60 dark:bg-slate-800 text-slate-500 dark:text-slate-400 px-4 py-1.5 rounded-full font-bold">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </footer>

    </body>
</html>