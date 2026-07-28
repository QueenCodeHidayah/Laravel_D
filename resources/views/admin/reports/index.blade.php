<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
                {{ Auth::user()->role == 'kasubag' ? '👁️ Pantau Seluruh Laporan' : '⚙️ Kelola Seluruh Laporan' }}
            </h2>
            <form action="{{ route('admin.reports.export.excel') }}" method="GET" class="bg-indigo-50/50 p-6 rounded-[30px] border border-indigo-100/80 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        
        <div>
            <label class="block text-xs font-black uppercase text-indigo-900 mb-2">📅 Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-3 text-sm">
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-indigo-900 mb-2">📅 Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                class="w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 p-3 text-sm">
        </div>

        <div class="flex space-x-2">
            <button type="submit" formaction="{{ route('admin.reports.export.excel') }}" 
                class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-3.5 rounded-2xl shadow-md shadow-emerald-100 transition text-center">
                🟢 Cetak Excel
            </button>
            
            <button type="submit" formaction="{{ route('admin.reports.export.pdf') }}" 
                class="flex-1 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs px-4 py-3.5 rounded-2xl shadow-md shadow-rose-100 transition text-center">
                🔴 Cetak PDF
            </button>
        </div>

    </div>
    <p class="text-[11px] text-gray-400 mt-2 italic">*Kosongkan kedua tanggal jika ingin mengunduh seluruh data (Semua Waktu).</p>
</form>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-[40px] overflow-hidden border border-gray-100">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-indigo-50/50">
                        <tr>
                            <th class="p-6 text-xs font-black text-indigo-900 uppercase tracking-widest">Pelapor</th>
                            <th class="p-6 text-xs font-black text-indigo-900 uppercase tracking-widest">Barang & Lokasi</th>
                            <th class="p-6 text-xs font-black text-indigo-900 uppercase tracking-widest text-center">Status & Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-6">
                                <div class="flex items-center space-x-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($report->user->name) }}&background=E0E7FF&color=4338CA&bold=true" 
                                         class="w-10 h-10 rounded-full shadow-sm border border-white" alt="PP">
                                    <div>
                                        <div class="font-bold text-gray-800">{{ $report->user->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $report->created_at->format('d M Y') }} • {{ $report->created_at->format('H:i') }} WIB</div>
                                    </div>
                                </div>
                            </td>

                            <td class="p-6">
                                <div class="flex items-center space-x-2">
                                    @if($report->status == 'Pending' || $report->status == 'Terkirim')
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                        </span>
                                    @endif
                                    
                                    <div class="font-bold text-indigo-900">{{ $report->nama_barang }}</div>
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $report->lantai }} - {{ $report->ruangan }}</div>
                            </td>

                            <td class="p-6">
                                <div class="flex items-center justify-center space-x-4">
                                    {{-- JIKA YANG LOGIN ADMIN: BISA UBAH STATUS CEPAT & MANIPULASI DATA --}}
                                    @if(Auth::user()->role == 'admin')
                                        <form action="{{ route('admin.reports.updateStatus', $report->id) }}" method="POST" class="flex items-center space-x-2 bg-gray-50 p-1.5 rounded-2xl border border-gray-100">
                                            @csrf @method('PATCH')
                                            <select name="status" class="text-[10px] border-none bg-transparent focus:ring-0 font-bold uppercase text-gray-600">
                                                <option value="Pending" {{ $report->status == 'Pending' || $report->status == 'Terkirim' ? 'selected' : '' }}>🕒 Pending</option>
                                                <option value="Proses" {{ $report->status == 'Proses' ? 'selected' : '' }}>🔧 Proses</option>
                                                <option value="Selesai" {{ $report->status == 'Selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                            </select>
                                            <button type="submit" class="bg-indigo-600 text-white p-1.5 rounded-xl hover:bg-indigo-700 transition shadow-sm">
                                                OK
                                            </button>
                                        </form>

                                        <div class="flex items-center space-x-2 border-l pl-4 border-gray-200">
                                            <a href="{{ route('admin.reports.edit', $report->id) }}" class="bg-amber-400 text-white p-2 rounded-xl hover:bg-amber-500 transition shadow-sm" title="Lihat Detail & Edit">
                                                ✏️
                                            </a>

                                            <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Lyra, yakin mau hapus laporan ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white p-2 rounded-xl hover:bg-red-600 transition shadow-sm">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    {{-- JIKA YANG LOGIN KASUBAG: HANYA LIHAT STATUS DAN DETAIL SAJA (READ-ONLY) --}}
                                    @else
                                        <span class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest
                                            {{ $report->status == 'Selesai' ? 'bg-green-100 text-green-600' : ($report->status == 'Proses' ? 'bg-indigo-100 text-indigo-600' : 'bg-amber-100 text-amber-600') }}">
                                            {{ $report->status == 'Pending' || $report->status == 'Terkirim' ? '🕒 PENDING' : ($report->status == 'Proses' ? '🔧 PROSES' : '✅ SELESAI') }}
                                        </span>

                                        <div class="flex items-center space-x-2 border-l pl-4 border-gray-200">
                                            <a href="{{ route('report.show', $report->id) }}" class="bg-indigo-600 text-white px-3 py-2 rounded-xl hover:bg-indigo-700 transition shadow-sm text-xs font-bold" title="Periksa Detail Laporan">
                                                👁️ Detail
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>