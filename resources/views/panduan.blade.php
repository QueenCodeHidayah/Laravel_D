<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-indigo-900 leading-tight">
            📖 Panduan Merawat Fasilitas
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 p-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-[40px] text-white shadow-xl">
                <h3 class="text-2xl font-bold mb-2">Halo Lyra! 👋</h3>
                <p class="opacity-90 leading-relaxed">Mencegah lebih baik daripada memperbaiki. Yuk, bantu tim Sarpras menjaga fasilitas Fakultas Saintek agar tetap nyaman digunakan bersama.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-white p-8 rounded-[35px] border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="bg-blue-100 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                        💡
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg mb-3">Gunakan Seperlunya</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Matikan AC dan Lampu jika ruangan kelas atau laboratorium sudah tidak digunakan lagi.</p>
                </div>

                <div class="bg-white p-8 rounded-[35px] border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="bg-amber-100 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                        🥪
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg mb-3">No Food & Drink</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Hindari membawa makanan atau minuman ke dalam Laboratorium Komputer untuk mencegah tumpahan pada perangkat.</p>
                </div>

                <div class="bg-white p-8 rounded-[35px] border border-gray-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="bg-emerald-100 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                        ⌨️
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg mb-3">Lapor Segera</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Jika melihat kerusakan kecil (seperti kabel terkelupas), segera lapor lewat sistem ini sebelum kerusakan menjadi parah.</p>
                </div>

            </div>

            <div class="mt-12 bg-indigo-50 p-10 rounded-[40px] border-2 border-dashed border-indigo-200">
                <h4 class="font-black text-indigo-900 uppercase tracking-widest text-sm mb-6 text-center">Alur Penanganan Laporan</h4>
                <div class="flex flex-col md:flex-row justify-between items-center space-y-8 md:space-y-0 md:space-x-4">
                    <div class="text-center flex-1">
                        <div class="font-bold text-indigo-600 text-xl">01. Kirim</div>
                        <p class="text-xs text-gray-500 mt-1">Isi form & foto kerusakan</p>
                    </div>
                    <div class="hidden md:block text-indigo-300">➜</div>
                    <div class="text-center flex-1">
                        <div class="font-bold text-indigo-600 text-xl">02. Verifikasi</div>
                        <p class="text-xs text-gray-500 mt-1">Admin mengecek laporan</p>
                    </div>
                    <div class="hidden md:block text-indigo-300">➜</div>
                    <div class="text-center flex-1">
                        <div class="font-bold text-indigo-600 text-xl">03. Perbaikan</div>
                        <p class="text-xs text-gray-500 mt-1">Teknisi datang ke lokasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>