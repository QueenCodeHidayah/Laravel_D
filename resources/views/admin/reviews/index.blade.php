<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-indigo-600 transition text-xl">⬅️</a>
            <h2 class="font-bold text-2xl text-indigo-900 leading-tight">📊 Rekapitulasi Review & Grafik Kepuasan</h2>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6">
                    <div class="bg-emerald-500 text-white p-4 rounded-2xl shadow-lg shadow-emerald-200 flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">🎉</span>
                            <div>
                                <p class="font-bold">Berhasil!</p>
                                <p class="text-sm opacity-90">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button @click="show = false" class="text-white hover:text-emerald-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            @endif

            <div class="bg-gradient-to-r from-indigo-900 to-indigo-700 text-white p-8 rounded-[30px] shadow-xl flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h3 class="text-2xl font-black mb-1">Skor Kepuasan Fakultas Saintek</h3>
                    <p class="text-xs text-indigo-200">Akumulasi rata-rata nilai responsivitas penanganan fasilitas berdasarkan peninjauan mahasiswa.</p>
                </div>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <div class="text-center bg-white/10 px-6 py-4 rounded-2xl border border-white/20 whitespace-nowrap">
                        <div class="text-4xl font-black text-amber-400">★ {{ number_format($rataRata, 1) }} <span class="text-sm text-white">/ 5.0</span></div>
                        <div class="text-[10px] uppercase font-bold tracking-widest text-indigo-200 mt-1">Rata-Rata Bintang</div>
                    </div>
                    <div class="text-center bg-white/10 px-6 py-4 rounded-2xl border border-white/20 whitespace-nowrap">
                        <div class="text-4xl font-black text-white">{{ $reviews->count() }}</div>
                        <div class="text-[10px] uppercase font-bold tracking-widest text-indigo-200 mt-1">Total Responden</div>
                    </div>
                </div>
            </div>

            @php
                // Menghitung sebaran jumlah bintang untuk diumpankan ke dalam grafik Chart.js
                $star5 = $reviews->where('rating', 5)->count();
                $star4 = $reviews->where('rating', 4)->count();
                $star3 = $reviews->where('rating', 3)->count();
                $star2 = $reviews->where('rating', 2)->count();
                $star1 = $reviews->where('rating', 1)->count();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-[30px] shadow-sm border border-gray-100 md:col-span-2">
                    <h4 class="font-bold text-gray-800 text-base mb-4">📈 Tren Sebaran Nilai Kepuasan</h4>
                    <div class="relative w-full h-64">
                        <canvas id="barChartReview"></canvas>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[30px] shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div>
                        <h4 class="font-bold text-gray-800 text-base mb-4">🍕 Proporsi Persentase</h4>
                    </div>
                    <div class="relative w-full h-52 mx-auto flex justify-center">
                        <canvas id="pieChartReview"></canvas>
                    </div>
                    <div class="text-center text-[11px] text-gray-400 font-medium mt-2">
                        Data diambil otomatis dari data ulasan mahasiswa.
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-[0_10px_40px_rgba(0,0,0,0.02)] rounded-[35px] overflow-hidden border border-gray-100">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="text-lg font-bold text-indigo-900 uppercase tracking-tight">Daftar Feedback Log Mahasiswa</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/70">
                            <tr>
                                <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">Nama Mahasiswa</th>
                                <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Penilaian</th>
                                <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest">Isi Komentar / Kritik / Saran</th>
                                <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Waktu Kirim</th>
                                <th class="p-6 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($reviews as $review)
                            <tr class="hover:bg-indigo-50/20 transition">
                                <td class="p-6 font-bold text-gray-800 flex items-center space-x-2">
                                    <span class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-full flex items-center justify-center text-xs uppercase font-black">
                                        {{ substr($review->user->name, 0, 2) }}
                                    </span>
                                    <span>{{ $review->user->name }}</span>
                                </td>
                                <td class="p-6 text-center">
                                    <div class="flex items-center justify-center space-x-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-sm {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}">★</span>
                                        @endfor
                                    </div>
                                </td>
                                <td class="p-6 text-sm text-gray-600 font-medium max-w-sm break-words italic">"{{ $review->ulasan }}"</td>
                                <td class="p-6 text-center text-xs text-gray-400 font-medium">{{ $review->created_at->format('d M Y • H:i') }} WIB</td>
                                <td class="p-6 text-center">
                                    @if(Auth::user()->role == 'admin')
                                    <form action="{{ route('review.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data review milik {{ $review->user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 font-bold transition text-xs bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-xl">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-400 italic">Belum ada review yang masuk dari mahasiswa pelapor.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data dinamis dari server laravel ke javascript array
            const dataReview = [{{ $star1 }}, {{ $star2 }}, {{ $star3 }}, {{ $star4 }}, {{ $star5 }}];
            const labelsReview = ['⭐ 1 Bintang', '⭐ 2 Bintang', '⭐ 3 Bintang', '⭐ 4 Bintang', '⭐ 5 Bintang'];
            const colorPalette = ['#ef4444', '#f97316', '#f59e0b', '#3b82f6', '#10b981'];

            // 1. Inisialisasi Bar Chart (Grafik Batang)
            const ctxBar = document.getElementById('barChartReview').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: labelsReview,
                    datasets: [{
                        label: 'Jumlah Pemilih',
                        data: dataReview,
                        backgroundColor: colorPalette,
                        borderRadius: 12,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

            // 2. Inisialisasi Pie Chart (Grafik Lingkaran)
            const ctxPie = document.getElementById('pieChartReview').getContext('2d');
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: labelsReview,
                    datasets: [{
                        data: dataReview,
                        backgroundColor: colorPalette,
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, font: { size: 10, weight: 'bold' } }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>