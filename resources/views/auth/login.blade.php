<x-guest-layout>
    <div class="mb-8 text-center">
        <!-- REVISI: GANTI KOTAK HURUF "H" MENJADI LOGO UIN FULL COLOR -->
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl p-2 border border-gray-100 shadow-md shadow-gray-100/50 mb-4 filter drop-shadow-sm">
            <img src="{{ asset('images/UIN_LOGO.png') }}" alt="Logo UIN" class="object-contain w-full h-full">
        </div>
        <h2 class="text-2xl font-black text-indigo-950 tracking-tight">Selamat Datang Kembali!</h2>
        <p class="text-xs text-gray-400 mt-1 font-medium">Silakan masuk untuk mengelola dan melaporkan sarpras kampus</p>
    </div>

    <x-auth-session-status class="mb-4 bg-emerald-50 text-emerald-600 p-4 rounded-2xl text-xs font-bold border border-emerald-100 shadow-sm" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-wider">Alamat Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 select-none">
                    📧
                </span>
                <input id="email" 
                       class="block w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 pl-11 text-sm transition-all shadow-sm bg-gray-50/50" 
                       type="email" 
                       name="email" 
                       :value="old('email')" 
                       placeholder="Masukkan email resmi kamu..."
                       required 
                       autofocus 
                       autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500 font-bold" />
        </div>

        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-xs font-black uppercase text-gray-400 tracking-wider">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 select-none">
                    🔒
                </span>
                <input id="password" 
                       class="block w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 pl-11 text-sm transition-all shadow-sm bg-gray-50/50"
                       type="password"
                       name="password"
                       placeholder="Masukkan password..."
                       required 
                       autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500 font-bold" />
        </div>

        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded-lg border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-4 h-4 transition" name="remember">
                <span class="ms-2 text-xs text-gray-500 font-semibold group-hover:text-gray-700 transition-colors">Ingat akun saya</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center px-6 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-sm rounded-2xl shadow-lg shadow-indigo-100 hover:shadow-indigo-200 transition-all transform hover:translate-y-[-1px] duration-150">
                Masuk ke Sistem 🚀
            </button>
        </div>
        
        @if (Route::has('register'))
            <p class="text-center text-xs text-gray-400 font-semibold pt-2">
                Belum punya akun mahasiswa? 
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-bold underline transition-colors">Daftar Sekarang</a>
            </p>
        @endif
    </form>
</x-guest-layout>