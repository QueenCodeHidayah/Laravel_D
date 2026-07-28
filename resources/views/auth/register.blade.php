<x-guest-layout>
    <div class="w-full max-w-md mx-auto bg-white/80 backdrop-blur-xl border border-gray-100 p-8 sm:p-10 rounded-[35px] shadow-[0_20px_50px_rgba(0,0,0,0.03)]">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/50 rounded-2xl mb-3 p-2 filter drop-shadow-sm border border-gray-100">
                <img src="{{ asset('images/UIN_LOGO.png') }}" alt="Logo UIN" class="object-contain w-full h-full">
            </div>
            <h2 class="font-black text-2xl text-indigo-900 tracking-tight">Buat Akun Baru</h2>
            <p class="text-xs text-gray-400 mt-1">Silakan daftarkan NIM dan akun mahasiswa kamu</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-xs font-black uppercase text-gray-400 tracking-wider mb-1.5">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 text-sm pointer-events-none">👤</span>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                        placeholder="Masukkan nama lengkap..."
                        class="w-full rounded-2xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-4 pl-11 text-sm bg-gray-50/50 transition-all duration-200">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-red-500 font-bold" />
            </div>

            <div>
                <label for="email" class="block text-xs font-black uppercase text-gray-400 tracking-wider mb-1.5">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 text-sm pointer-events-none">✉️</span>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                        placeholder="contoh: hidayah@gmail.com"
                        class="w-full rounded-2xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-4 pl-11 text-sm bg-gray-50/50 transition-all duration-200">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500 font-bold" />
            </div>

            <div>
                <label for="password" class="block text-xs font-black uppercase text-gray-400 tracking-wider mb-1.5">Kata Sandi (Min. 8 Karakter)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 text-sm pointer-events-none">🔒</span>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        placeholder="Buat password aman..."
                        class="w-full rounded-2xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-4 pl-11 text-sm bg-gray-50/50 transition-all duration-200">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500 font-bold" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-black uppercase text-gray-400 tracking-wider mb-1.5">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 text-sm pointer-events-none">🛡️</span>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="Ulangi password di atas..."
                        class="w-full rounded-2xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-4 pl-11 text-sm bg-gray-50/50 transition-all duration-200">
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-red-500 font-bold" />
            </div>

            <div class="pt-2 space-y-4">
                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-sm rounded-2xl shadow-lg shadow-indigo-100 transition-all transform hover:translate-y-[-1px] active:translate-y-[0px]">
                    🚀 Daftar Akun Sekarang
                </button>

                <div class="text-center">
                    <a class="inline-block text-xs font-bold text-gray-400 hover:text-indigo-600 transition-colors py-1" href="{{ route('login') }}">
                        {{ __('Sudah punya akun? Masuk di sini') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>