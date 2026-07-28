<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
                🔍 Detail Laporan Kerusakan
            </h2>
            <a href="{{ route('dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-2xl text-sm font-bold transition">
                ⬅️ Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                
                <div class="md:col-span-5">
                    <div class="bg-white p-4 rounded-[40px] shadow-2xl shadow-indigo-100 border border-gray-100">
                        <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-4 ml-2">Bukti Foto Kejadian</p>
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $report->foto) }}" 
                                 alt="Foto Kerusakan" 
                                 class="w-full h-auto rounded-[30px] object-cover shadow-md transition-transform duration-500 group-hover:scale-[1.02]">
                        </div>
                    </div>
                </div>

                <div class="md:col-span-7 space-y-6">
                    <div class="bg-white p-10 rounded-[40px] shadow-sm border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8">
                            <span class="px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-widest
                                {{ $report->status == 'Selesai' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                                {{ $report->status }}
                            </span>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-3xl font-black text-gray-800 leading-tight">{{ $report->nama_barang }}</h3>
                            <p class="text-indigo-400 font-medium mt-1">ID Laporan: #SAINTEK-{{ $report->id }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-8 py-8 border-y border-gray-50">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">📍 Lokasi Spesifik</p>
                                <p class="text-gray-800 font-bold">{{ $report->lantai }}</p>
                                <p class="text-indigo-600 font-bold">{{ $report->wing ?? 'Non-Wing' }} | {{ $report->ruangan }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">⚠️ Tingkat Kerusakan</p>
                                <p class="text-gray-800 font-bold flex items-center">
                                    <span class="w-3 h-3 rounded-full mr-2 {{ $report->tingkat_kerusakan == 'Parah' ? 'bg-red-500' : 'bg-orange-400' }}"></span>
                                    {{ $report->tingkat_kerusakan }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-8">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">📝 Keterangan Pelapor</p>
                            <div class="bg-indigo-50/50 p-6 rounded-[25px] text-gray-700 italic leading-relaxed">
                                "{{ $report->deskripsi }}"
                            </div>
                        </div>
                    </div>

                    <div class="bg-indigo-900 p-8 rounded-[40px] text-white flex items-center justify-between">
                        <div class="flex items-center space-x-5">
                            <div class="bg-indigo-800 p-4 rounded-2xl text-2xl">
                                🛠️
                            </div>
                            <div>
                                <p class="text-xs opacity-60 uppercase tracking-widest font-bold">Estimasi Perbaikan</p>
                                <p class="font-medium text-indigo-100">Laporan Anda sudah masuk dalam sistem antrean perbaikan sarpras.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>