<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('panduan') }}" class="text-gray-400 hover:text-indigo-600 transition text-xl">⬅️</a>
            <h2 class="font-bold text-2xl text-indigo-900 leading-tight">📝 Tambah Panduan Fasilitas Baru</h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-[40px] overflow-hidden border border-gray-100 p-8">
                
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
                        <p class="text-xs font-black uppercase text-red-600 mb-2">⚠️ Ada kesalahan pengisian:</p>
                        <ul class="list-disc list-inside text-xs text-red-500 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.guides.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-black uppercase text-gray-400 mb-2">Judul Panduan</label>
                            <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Aturan Penggunaan Laboratorium Komputer"
                                class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 text-sm shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase text-gray-400 mb-2">Ikon Emoji</label>
                            <input type="text" name="ikon" value="{{ old('ikon') }}" required placeholder="Contoh: 💻 atau 🏫"
                                class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 text-sm text-center shadow-sm">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Kategori Fasilitas / Tag</label>
                        <select name="kategori" required class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 text-sm shadow-sm">
                            <option value="Umum" {{ old('kategori') == 'Umum' ? 'selected' : '' }}>Umum / Gedung</option>
                            <option value="Ruangan" {{ old('kategori') == 'Ruangan' ? 'selected' : '' }}>Ruang Kelas / Aula</option>
                            <option value="Laboratorium" {{ old('kategori') == 'Laboratorium' ? 'selected' : '' }}>Alat Laboratorium</option>
                            <option value="Elektronik" {{ old('kategori') == 'Elektronik' ? 'selected' : '' }}>Perangkat Elektronik / AC / Proyektor</option>
                            <option value="Aturan" {{ old('kategori') == 'Aturan' ? 'selected' : '' }}>Aturan & Regulasi</option>
                            <option value="Tips" {{ old('kategori') == 'Tips' ? 'selected' : '' }}>Tips / Larangan</option>
                        </select>
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-black uppercase text-gray-400 mb-2">Isi Prosedur Panduan Lengkap</label>
                        <textarea name="isi" rows="6" required placeholder="Tuliskan poin-poin petunjuk penggunaan barang di sini..."
                            class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-4 text-sm shadow-sm">{{ old('isi') }}</textarea>
                    </div>

                    <div class="flex items-center space-x-3 justify-end">
                        <a href="{{ route('panduan') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-500 hover:bg-gray-50 font-bold text-sm transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold text-sm shadow-md hover:bg-indigo-700 transition">
                            🚀 Terbitkan Panduan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>