<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
            📂 {{ __('Riwayat Laporanku') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-[0_10px_40px_rgba(0,0,0,0.04)] rounded-[30px] border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-indigo-50/50">
                            <tr>
                                <th class="p-6 text-xs font-black text-indigo-900 uppercase tracking-widest">Tanggal Lapor</th>
                                <th class="p-6 text-xs font-black text-indigo-900 uppercase tracking-widest">Detail Barang</th>
                                <th class="p-6 text-xs font-black text-indigo-900 uppercase tracking-widest">Lokasi</th>
                                <th class="p-6 text-xs font-black text-indigo-900 uppercase tracking-widest text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse(auth()->user()->reports()->latest()->get() as $report)
                            <tr class="hover:bg-indigo-50/30 transition cursor-pointer group" onclick="window.location='{{ route('report.show', $report->id) }}'">
                                <td class="p-6">
                                    <div class="font-bold text-gray-700">{{ $report->created_at->format('d M Y') }}</div>
                                    <div class="text-[10px] text-indigo-400 font-medium">{{ $report->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td class="p-6">
                                    <div class="font-bold text-gray-800 group-hover:text-indigo-600 transition">{{ $report->nama_barang }}</div>
                                    <div class="text-[11px] text-gray-400 italic">"{{ Str::limit($report->deskripsi, 30) }}"</div>
                                </td>
                                <td class="p-6">
                                    <div class="text-sm text-gray-600 font-bold">{{ $report->lantai }}</div>
                                    <div class="text-[11px] text-gray-400">{{ $report->wing ?? 'Saintek' }} | {{ $report->ruangan }}</div>
                                </td>
                                <td class="p-6 text-center">
                                    <span class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest
                                        {{ $report->status == 'Selesai' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                                        {{ $report->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-12 text-center text-gray-400 italic">Belum ada riwayat laporan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>