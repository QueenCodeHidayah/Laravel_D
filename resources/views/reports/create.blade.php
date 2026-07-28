<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-indigo-900 dark:text-white">
            🚀 {{ __('Buat Laporan Fasilitas') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[40px] overflow-hidden border border-gray-100">
                <div class="p-8 sm:p-12">
                    
                    <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf

                        <div class="space-y-4">
                            <h3 class="text-sm font-black uppercase tracking-widest text-indigo-500">1. Detail Lokasi</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="lantai" :value="__('Lantai')" class="font-bold ml-1" />
                                    <select name="lantai" id="lantai" class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-100 transition-all">
                                        <option value="">Pilih Lantai</option>
                                        @for ($i = 1; $i <= 6; $i++) <option value="Lantai {{ $i }}">Lantai {{ $i }}</option> @endfor
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="wing" :value="__('Wing (Opsional)')" class="font-bold ml-1" />
                                    <select name="wing" id="wing" class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-100 transition-all">
                                        <option value="">-- Lewati --</option>
                                        @foreach(['A','B','C','D','E'] as $w) <option value="Wing {{ $w }}">Wing {{ $w }}</option> @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-input-label for="ruangan" :value="__('Nama/No Ruang')" class="font-bold ml-1" />
                                    <x-text-input id="ruangan" name="ruangan" type="text" class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white" placeholder="B601 / Lab Bio" required />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-sm font-black uppercase tracking-widest text-indigo-500">2. Detail Barang & Kerusakan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="nama_barang" :value="__('Nama Barang')" class="font-bold ml-1" />
                                        <x-text-input id="nama_barang" name="nama_barang" type="text" class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white" placeholder="AC, Kursi, Meja, dll" required />
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Tingkat Kerusakan')" class="font-bold ml-1 mb-2" />
                                        <div class="flex p-1 bg-gray-100 rounded-2xl">
                                            @foreach(['Ringan', 'Sedang', 'Parah'] as $level)
                                            <label class="flex-1">
                                                <input type="radio" name="tingkat_kerusakan" value="{{ $level }}" class="hidden peer" required>
                                                <div class="text-center py-2.5 rounded-xl cursor-pointer peer-checked:bg-white peer-checked:text-indigo-600 peer-checked:shadow-sm transition-all text-gray-500 font-bold text-xs uppercase tracking-tighter">
                                                    {{ $level }}
                                                </div>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="deskripsi" :value="__('Deskripsi Singkat')" class="font-bold ml-1" />
                                    <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-100" placeholder="Jelaskan kondisi barang saat ini..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-sm font-black uppercase tracking-widest text-indigo-500">3. Bukti Foto</h3>
                            <div class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[30px] blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
                                <div class="relative bg-gray-50 p-10 border-2 border-dashed border-indigo-100 rounded-[30px] text-center transition-all hover:bg-white">
                                    <input type="file" name="foto" id="foto" accept="image/*" capture="environment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                                    <div class="flex flex-col items-center">
                                        <div class="bg-indigo-600 p-4 rounded-full shadow-lg shadow-indigo-200 mb-4">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <p class="text-indigo-900 font-bold">Ambil Foto atau Upload</p>
                                        <p class="text-xs text-gray-400 mt-2 italic">* Pastikan foto terlihat jelas kerusakannya</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-[25px] shadow-2xl shadow-indigo-200 transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest">
                                🚀 Kirim Laporan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>