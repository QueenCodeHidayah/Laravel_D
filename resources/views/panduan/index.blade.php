<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
                📖 Panduan Merawat Fasilitas
            </h2>
            @if(Auth::user()->role == 'admin')
                <a href="{{ route('admin.guides.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-5 py-3 rounded-2xl shadow-lg shadow-indigo-200 transition-all transform hover:translate-y-[-1px]">
                    ➕ Tambah Kartu Panduan
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="bg-emerald-500 text-white p-4 rounded-2xl shadow-lg shadow-emerald-100 flex justify-between items-center transition">
                    <p class="text-sm font-bold flex items-center">🎉 {{ session('success') }}</p>
                    <button @click="show = false" class="text-white opacity-70 hover:opacity-100 text-sm">✕</button>
                </div>
            @endif

            <div class="p-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-[40px] text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold mb-2">Halo {{ Auth::user()->name }}! 👋</h3>
                    <p class="opacity-90 leading-relaxed max-w-2xl text-sm">Mencegah lebih baik daripada memperbaiki. Yuk, bantu tim Sarpras menjaga fasilitas Fakultas Saintek agar tetap nyaman digunakan bersama.</p>
                </div>
                <div class="absolute right-6 bottom-[-20px] text-8xl opacity-10 pointer-events-none select-none">🏢</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($guides as $guide)
                    <div class="bg-white p-8 rounded-[35px] border border-gray-100 shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between relative">
                        <div>
                            <div class="flex justify-between items-center mb-6">
                                <div class="bg-indigo-50 text-2xl w-14 h-14 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300">
                                    {{ $guide->ikon }}
                                </div>
                                <span class="bg-indigo-50 text-indigo-600 text-[10px] uppercase tracking-widest font-extrabold px-3 py-1 rounded-full">
                                    {{ $guide->kategori }}
                                </span>
                            </div>

                            <h4 class="font-bold text-gray-800 text-lg mb-3 group-hover:text-indigo-600 transition">{{ $guide->judul }}</h4>
                            <p class="text-gray-500 text-sm leading-relaxed whitespace-pre-line">{{ $guide->isi }}</p>
                        </div>

                        @if(Auth::user()->role == 'admin')
                            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.guides.edit', $guide->id) }}" class="bg-amber-50 text-amber-600 hover:bg-amber-100 font-bold text-xs px-3 py-2 rounded-xl transition">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.guides.destroy', $guide->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus kartu panduan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-100 font-bold text-xs px-3 py-2 rounded-xl transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 bg-white p-16 text-center rounded-[40px] border border-gray-100 shadow-sm">
                        <div class="text-4xl mb-3">📭</div>
                        <p class="text-gray-400 font-medium italic">Belum ada data panduan di database. Silakan klik tambah data atau jalankan seeder.</p>
                    </div>
                @endif
            </div>

            <div class="bg-indigo-50 p-10 rounded-[40px] border-2 border-dashed border-indigo-200">
                <h4 class="font-black text-indigo-900 uppercase tracking-widest text-sm mb-6 text-center">Alur Penanganan Laporan</h4>
                <div class="flex flex-col md:flex-row justify-between items-center space-y-8 md:space-y-0 md:space-x-4">
                    <div class="text-center flex-1">
                        <div class="font-bold text-indigo-600 text-xl">01. Kirim</div>
                        <p class="text-xs text-gray-500 mt-1">Isi form & foto kerusakan</p>
                    </div>
                    <div class="hidden md:block text-indigo-300 text-lg">➜</div>
                    <div class="text-center flex-1">
                        <div class="font-bold text-indigo-600 text-xl">02. Verifikasi</div>
                        <p class="text-xs text-gray-500 mt-1">Admin mengecek laporan</p>
                    </div>
                    <div class="hidden md:block text-indigo-300 text-lg">➜</div>
                    <div class="text-center flex-1">
                        <div class="font-bold text-indigo-600 text-xl">03. Perbaikan</div>
                        <p class="text-xs text-gray-500 mt-1">Teknisi datang ke lokasi</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>