<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Sistem Pelaporan Hidayah - UIN Jambi</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
        <style>
            /* =========================================================================
               EFEK MORPH LAYER TENGGELAM & MUNCUL (SUPER FAST & RESPONSIVE)
               ========================================================================= */
            
            /* Animasi saat pertama kali web dibuka */
            .page-enter-active {
                animation: morphLayerIn 0.35s cubic-bezier(0.215, 0.610, 0.355, 1) both;
            }

            /* 1. Layer halaman lama yang tenggelam ke bawah */
            ::view-transition-old(root) {
                animation: morphLayerOut 0.25s cubic-bezier(0.55, 0.055, 0.675, 0.19) both;
            }

            /* 2. Layer halaman baru yang muncul ke atas */
            ::view-transition-new(root) {
                animation: morphLayerIn 0.35s cubic-bezier(0.215, 0.610, 0.355, 1) both;
            }

            @keyframes morphLayerOut {
                0% {
                    opacity: 1;
                    transform: scale(1);
                }
                100% {
                    opacity: 0;
                    transform: scale(0.94); /* Efek tenggelam mengecil ke background */
                    filter: blur(4px);
                }
            }

            @keyframes morphLayerIn {
                0% {
                    opacity: 0;
                    transform: scale(1.05) translateY(15px); /* Masuk dari depan/atas */
                    filter: blur(4px);
                }
                100% {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                    filter: blur(0);
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900">
        <div class="min-h-screen flex">
            <div id="sidebar-container">
                @include('layouts.navigation')
            </div>

            <main id="main-content" class="flex-1 ml-64 p-8 transition-all duration-300 page-enter-active">
                @if (isset($header))
                    <header class="mb-8">
                        <div class="max-w-7xl mx-auto">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                {{ $slot }}
            </main>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // Mencegat interaksi klik pada seluruh area body (Event Delegation)
                document.body.addEventListener("click", (e) => {
                    // Mencari tag <a> terdekat (mengatasi bug klik pada elemen span di dalam x-nav-link)
                    const link = e.target.closest("a");
                    
                    // Jika elemen bukan link murni atau tidak memiliki rute tujuan, abaikan
                    if (!link || !link.href) return;

                    // Validasi internal routing (bukan link luar, bukan tombol logout, dan bukan anchor id #)
                    if (link.hostname === window.location.hostname && 
                        !link.getAttribute('href').includes('logout') && 
                        !link.getAttribute('href').startsWith('#')) {
                        
                        // Eksekusi jika peramban mendukung View Transitions API
                        if (document.startViewTransition) {
                            e.preventDefault();
                            const targetUrl = link.href;

                            document.startViewTransition(async () => {
                                try {
                                    // Mengambil dokumen HTML halaman tujuan via AJAX background fetch
                                    const response = await fetch(targetUrl);
                                    if (!response.ok) throw new Error("Gagal memuat halaman");
                                    const text = await response.text();
                                    
                                    // Parsing text string menjadi DOM Document baru
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(text, "text/html");
                                    
                                    // Sinkronisasi Konten Utama
                                    const newContent = doc.getElementById("main-content");
                                    const currentContent = document.getElementById("main-content");
                                    
                                    // Sinkronisasi Komponen Sidebar Baru
                                    const newNav = doc.querySelector("nav");
                                    const currentNav = document.querySelector("nav");
                                    
                                    if (newContent && currentContent) {
                                        // Ganti wrapper konten utama
                                        currentContent.innerHTML = newContent.innerHTML;
                                        
                                        // Ganti wrapper navigasi untuk memperbarui kelas active menu secara dinamis
                                        if (newNav && currentNav) {
                                            currentNav.outerHTML = newNav.outerHTML;
                                        }
                                        
                                        // Sinkronisasi address bar URL browser
                                        window.history.pushState({}, "", targetUrl);
                                        
                                        // Inisialisasi ulang lifecycle Alpine.js untuk menghidupkan komponen interaktif
                                        if (window.Alpine) {
                                            window.Alpine.discover();
                                        }
                                    } else {
                                        // Fallback mekanisme jika struktur ID tidak cocok
                                        window.location.href = targetUrl;
                                    }
                                } catch (error) {
                                    // Fallback pengaman jika request background gagal (masalah jaringan)
                                    window.location.href = targetUrl;
                                }
                            });
                        }
                    }
                });
            });

            // Menangani manajemen history navigasi tombol Back dan Forward browser
            window.addEventListener("popstate", async () => {
                if (document.startViewTransition) {
                    document.startViewTransition(async () => {
                        try {
                            const response = await fetch(window.location.href);
                            const text = await response.text();
                            const doc = new DOMParser().parseFromString(text, "text/html");
                            
                            document.getElementById("main-content").innerHTML = doc.getElementById("main-content").innerHTML;
                            
                            const newNav = doc.querySelector("nav");
                            const currentNav = document.querySelector("nav");
                            if (newNav && currentNav) {
                                currentNav.outerHTML = newNav.outerHTML;
                            }
                            
                            if (window.Alpine) { 
                                window.Alpine.discover(); 
                            }
                        } catch (e) {
                            window.location.reload();
                        }
                    });
                } else {
                    window.location.reload();
                }
            });
        </script>
    </body>
</html>