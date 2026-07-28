<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
            ✏️ Edit Pengguna
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-10 rounded-[40px] shadow-xl border border-indigo-50">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf 
                    @method('PATCH')
                    
                    <div>
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Nama Mahasiswa</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full rounded-2xl border-gray-100 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full rounded-2xl border-gray-100 focus:ring-indigo-500">
                    </div>

                    <div class="p-4 bg-indigo-50 rounded-2xl border border-indigo-100">
                        <p class="text-[10px] text-indigo-600 font-bold uppercase tracking-widest italic">
                            💡 Kosongkan password jika tidak ingin mengganti. Isi jika ingin mereset password mahasiswa.
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Password Baru (Minimal 8 Karakter)</label>
                        <input type="password" name="password" placeholder="Masukkan password baru..." class="w-full rounded-2xl border-gray-100 focus:ring-indigo-500">
                    </div>

                    <div class="flex space-x-4 pt-4">
                        <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="flex-1 bg-gray-100 text-gray-400 py-4 rounded-2xl font-bold text-center hover:bg-gray-200 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>