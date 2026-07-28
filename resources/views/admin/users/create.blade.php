<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-indigo-600 transition text-xl">
                ⬅️
            </a>
            <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
                ➕ Tambah Akun Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-[40px] overflow-hidden border border-gray-100 p-8">
                
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama pengguna..."
                            class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 text-sm">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh: hidayah@gmail.com"
                            class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 text-sm">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Hak Akses / Role</label>
                        <select name="role" required class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 text-sm">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (Mahasiswa / Pelapor)</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola Sarpras)</option>
                            <option value="kasubag" {{ old('role') == 'kasubag' ? 'selected' : '' }}>Kasubag (Kepala / Ketua)</option>
                        </select>
                        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-8" x-data="{ show: false }">
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Kata Sandi (Minimal 8 Karakter)</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="password" required placeholder="Buat password aman..."
                                class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 pr-12 text-sm">
                            
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-indigo-600">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.758 4.252A10.012 10.012 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.4m-4.568-4.568a3 3 0 11-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center space-x-3 justify-end">
                        <a href="{{ route('admin.users.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-500 hover:bg-gray-50 font-bold text-sm transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold text-sm shadow-md hover:bg-indigo-700 transition">
                            💾 Simpan Akun
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>