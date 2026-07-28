<x-guest-layout>
    <div class="bg-white/80 backdrop-blur-xl p-8 rounded-[40px] shadow-[0_20px_50px_rgba(99,102,241,0.1)] border border-white/60 relative overflow-hidden max-w-md mx-auto">
        
        <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl -mr-6 -mt-6"></div>

        <div class="text-center mb-6">
            <div class="inline-flex p-4 bg-indigo-50 text-indigo-600 rounded-3xl text-3xl mb-3 shadow-inner">
                🔑
            </div>
            <h2 class="font-black text-2xl text-indigo-900 leading-tight">
                Lupa Kata Sandi?
            </h2>
            <p class="mt-2 text-xs text-gray-500 leading-relaxed max-w-xs mx-auto">
                {{ __('Jangan khawatir! Cukup masukkan alamat email akun Hidayah Sarpras kamu, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi baru.') }}
            </p>
        </div>

        @if (session('status'))
            <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold rounded-2xl flex items-center space-x-2">
                <span>📧</span>
                <x-auth-session-status :status="session('status')" />
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">
                    {{ __('Alamat Email Terdaftar') }}
                </label>
                
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        ✉️
                    </span>
                    <input id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        placeholder="contoh: mhs@hidayah.com"
                        class="w-full pl-11 pr-4 py-4 rounded-2xl border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm transition-all duration-200"
                    />
                </div>
                
                @if ($errors->has('email'))
                    <div class="mt-2 text-xs text-red-500 font-bold flex items-center space-x-1 pl-1">
                        <span>⚠️</span>
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                @endif
            </div>

            <div class="pt-2 flex flex-col space-y-3">
                <button type="submit" class="w-full px-6 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-indigo-800 text-white font-extrabold text-sm shadow-lg shadow-indigo-200 hover:shadow-xl hover:from-indigo-700 hover:to-indigo-900 transition-all duration-200 transform active:scale-[0.98] text-center">
                    {{ __('Kirim Link Reset Password 🚀') }}
                </button>

                <a href="{{ route('login') }}" class="text-center text-xs font-bold text-gray-400 hover:text-indigo-600 transition-colors py-1">
                    ⬅️ Kembali ke Halaman Login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>