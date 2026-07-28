<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-indigo-600 transition text-xl">⬅️</a>
            <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
                📂 Riwayat Ulasan & Review Saya
            </h2>
        </div>
    </x-slot>

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

            <div class="p-6 bg-indigo-50 border border-indigo-100 rounded-[30px] flex items-center space-x-4">
                <span class="text-3xl">📝</span>
                <div>
                    <h4 class="font-bold text-indigo-900 text-lg">Transparansi Penilaian Anda</h4>
                    <p class="text-xs text-indigo-600">Berikut adalah daftar seluruh kontribusi review responsivitas yang telah Anda kirimkan untuk membantu evaluasi sarpras fakultas.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($reviews as $review)
                    <div class="bg-white p-6 rounded-[35px] shadow-[0_10px_30px_rgba(0,0,0,0.02)] border border-gray-100 flex flex-col justify-between transform hover:translate-y-[-2px] transition duration-200 relative overflow-hidden">
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-xl {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}">★</span>
                                    @endfor
                                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full ml-1">
                                        {{ $review->rating }}.0
                                    </span>
                                </div>
                                <div class="text-[11px] text-gray-400 font-medium bg-gray-50 px-3 py-1 rounded-full">
                                    📅 {{ $review->created_at->format('d M Y • H:i') }} WIB
                                </div>
                            </div>
                            
                            <p class="text-gray-700 text-sm leading-relaxed italic bg-slate-50/50 p-4 rounded-2xl border border-gray-50 mb-4">
                                "{{ $review->ulasan }}"
                            </p>
                        </div>
                        
                        <div class="mt-2 pt-3 border-t border-gray-50 flex items-center text-xs text-gray-400 justify-between">
                            <span class="font-bold text-indigo-500">≽^•⩊•^≼ Meow~</span>
                            
                            @if(class_exists('\App\Models\Review') && Route::has('review.destroy'))
                            <form action="{{ route('review.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus ulasan review ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 font-bold transition flex items-center space-x-1 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-xl">
                                    🗑️ <span>Hapus</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 bg-white p-16 text-center rounded-[40px] border border-gray-100 shadow-sm">
                        <div class="text-4xl mb-3">📂</div>
                        <p class="text-gray-400 font-medium italic">Kamu belum pernah mengirimkan review kepuasan fasilitas.</p>
                        <a href="{{ route('dashboard') }}" class="mt-4 inline-block bg-indigo-600 text-white text-xs font-bold px-4 py-2 rounded-xl hover:bg-indigo-700 transition">
                            Kirim Review Sekarang
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>