<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.reports.index') }}" class="bg-white p-2 rounded-xl shadow-sm hover:bg-gray-50 transition">
                ⬅️
            </a>
            <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
                Detail & Verifikasi Laporan
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1">
                    <div class="bg-white p-4 rounded-[40px] shadow-xl border border-gray-100">
                        <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-4 text-center">Bukti Foto Kerusakan</p>
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $report->foto) }}" 
                                 class="w-full h-80 object-cover rounded-[30px] shadow-inner border border-gray-50"
                                 alt="Foto Laporan">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-[30px] flex items-center justify-center">
                                <a href="{{ asset('storage/' . $report->foto) }}" target="_blank" class="text-white font-bold text-xs bg-indigo-600 px-4 py-2 rounded-full">Lihat Ukuran Penuh 🔍</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white p-8 rounded-[40px] shadow-xl border border-gray-100">
                        <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                            @csrf @method('PATCH')

                            <div class="flex justify-between items-start border-bottom border-gray-100 pb-6 mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ $report->nama_barang }}</h3>
                                    <p class="text-sm text-gray-500">{{ $report->lantai }} - {{ $report->ruangan }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-black text-gray-400 uppercase">Waktu Masuk</p>
                                    <p class="text-sm font-bold text-indigo-600">{{ $report->created_at->format('d F Y') }}</p>
                                    <p class="text-xs text-gray-400">{{ $report->created_at->format('H:i') }} WIB</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-[30px] mb-8 flex items-center space-x-4">
                                <div class="bg-white p-3 rounded-2xl shadow-sm text-2xl">👤</div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase">Identitas Pelapor</p>
                                    <p class="font-bold text-gray-800">{{ $report->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $report->user->email }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase ml-2">Edit Nama Barang</label>
                                    <input type="text" name="nama_barang" value="{{ $report->nama_barang }}" 
                                           class="w-full mt-1 border-gray-100 bg-gray-50 rounded-2xl focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase ml-2">Update Status</label>
                                    <select name="status" class="w-full mt-1 border-gray-100 bg-gray-50 rounded-2xl focus:ring-indigo-500 font-bold text-indigo-600">
                                        <option value="Pending" {{ $report->status == 'Pending' ? 'selected' : '' }}>🕒 Pending (Menunggu)</option>
                                        <option value="Proses" {{ $report->status == 'Proses' ? 'selected' : '' }}>🔧 Proses (Dikerjakan)</option>
                                        <option value="Selesai" {{ $report->status == 'Selesai' ? 'selected' : '' }}>✅ Selesai (Berhasil)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="text-[10px] font-black text-gray-400 uppercase ml-2">Deskripsi Kerusakan</label>
                                <textarea name="deskripsi" rows="3" 
                                          class="w-full mt-1 border-gray-100 bg-gray-50 rounded-2xl focus:ring-indigo-500">{{ $report->deskripsi }}</textarea>
                            </div>

                            <div class="mt-10 flex items-center justify-between border-t pt-6">
                                <button type="button" onclick="window.history.back()" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">
                                    Batalkan Perubahan
                                </button>
                                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition transform hover:-translate-y-1">
                                    Simpan & Update Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>