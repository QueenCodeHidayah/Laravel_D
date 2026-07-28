<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('panduan') }}" class="text-gray-400 hover:text-indigo-600 transition text-xl">⬅️</a>
            <h2 class="font-bold text-2xl text-indigo-900 leading-tight">✏️ Edit Panduan: {{ $guide->judul }}</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-[40px] overflow-hidden border border-gray-100 p-8">
                
                <form action="{{ route('admin.guides.update', $guide->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black uppercase text-gray-400 mb-2">Judul Panduan</label>
                            <input type="text" name="judul" value="{{ old('judul', $guide->judul) }}" required placeholder="Contoh: Tata Tertib Lab..."
                                class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 text-sm shadow-sm">
                            @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase text-gray-400 mb-2">Ikon Emoji</label>
                            <input type="text" name="ikon" value="{{ old('ikon', $guide->ikon) }}" required placeholder="📖 / 🖥️ / 💡"
                                class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 text-sm text-center shadow-sm">
                            @error('ikon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Kategori Bidang Panduan</label>
                        <select name="kategori" required class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 text-sm shadow-sm">
                            <option value="Regulasi" {{ old('kategori', $guide->kategori) == 'Regulasi' ? 'selected' : '' }}>⚖️ Regulasi / Prosedur</option>
                            <option value="Fasilitas" {{ old('kategori', $guide->kategori) == 'Fasilitas' ? 'selected' : '' }}>🏫 Umum / Fasilitas Gedung</option>
                            <option value="Laboratorium" {{ old('kategori', $guide->kategori) == 'Laboratorium' ? 'selected' : '' }}>🖥️ Alat Laboratorium / Komputer</option>
                            <option value="Elektronik" {{ old('kategori', $guide->kategori) == 'Elektronik' ? 'selected' : '' }}>🔌 Perangkat Elektronik / AC / Proyektor</option>
                        </select>
                        @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Isi Prosedur Panduan Lengkap</label>
                        <textarea name="isi" rows="6" required placeholder="Tuliskan detail langkah demi langkah instruksi panduan sarpras..."
                            class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 text-sm shadow-sm">{{ old('isi', $guide->isi) }}</textarea>
                        @error('isi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center space-x-3 justify-end">
                        <a href="{{ route('panduan') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-500 hover:bg-gray-50 font-bold text-sm transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold text-sm shadow-md hover:bg-indigo-700 transition">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>