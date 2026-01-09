<x-guest-layout>
    <!-- Slot Head untuk Style & Scripts Khusus Halaman Ini -->
    <x-slot name="head">
        <title>LibSys - Perpustakaan Digital</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            html {
                scroll-behavior: smooth;
            }

            .glass-nav {
                background-color: rgba(17, 24, 39, 0.85);
                backdrop-filter: blur(12px);
            }
        </style>
    </x-slot>

    <div class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased selection:bg-indigo-500 selection:text-white">

        <!-- Navbar -->
        <nav class="fixed w-full z-50 glass-nav border-b border-gray-200 dark:border-gray-800 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Logo -->
                    <div class="flex items-center gap-2">
                        <div class="bg-indigo-600 text-white w-8 h-8 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/30">
                            <i class="fa-solid fa-book-open text-sm"></i>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">LibSys</span>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white transition">Beranda</a>
                        <a href="#koleksi" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white transition">Koleksi</a>
                        <a href="#fitur" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white transition">Fitur</a>
                    </div>

                    <!-- Auth Buttons (Logic Laravel) -->
                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                        @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition px-3 py-2">
                            Dashboard
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition px-3 py-2">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition shadow-lg shadow-indigo-600/20">
                            Daftar
                        </a>
                        @endif
                        @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
            <!-- Background Gradients -->
            <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-0 pointer-events-none opacity-40 dark:opacity-20">
                <div class="absolute top-20 left-1/4 w-96 h-96 bg-indigo-500 rounded-full blur-[128px]"></div>
                <div class="absolute bottom-20 right-1/4 w-80 h-80 bg-purple-500 rounded-full blur-[128px]"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-800 text-indigo-600 dark:text-indigo-300 text-xs font-semibold mb-6 animate-fade-in-up">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    Sistem Perpustakaan Digital Terintegrasi
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight text-gray-900 dark:text-white mb-6 leading-tight">
                    Akses Pengetahuan <br class="hidden md:block">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">Tanpa Batas</span>
                </h1>

                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Platform modern untuk meminjam buku fisik, membaca jurnal, dan mengelola referensi akademik Anda dalam satu tempat.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-16">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-base font-bold px-8 py-3.5 rounded-xl shadow-xl shadow-indigo-600/20 transition hover:-translate-y-1">
                        Akses Dashboard
                    </a>
                    @else
                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-base font-bold px-8 py-3.5 rounded-xl shadow-xl shadow-indigo-600/20 transition hover:-translate-y-1">
                        Mulai Sekarang
                    </a>
                    @endauth
                    <a href="#koleksi" class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 text-base font-semibold px-8 py-3.5 rounded-xl transition hover:-translate-y-1">
                        Lihat Koleksi
                    </a>
                </div>

                <!-- Dashboard Preview Mockup -->
                <div class="relative mx-auto max-w-5xl rounded-2xl bg-gray-900/5 dark:bg-gray-100/5 p-2 ring-1 ring-inset ring-gray-900/10 dark:ring-white/10 lg:rounded-3xl lg:p-4">
                    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-2xl ring-1 ring-gray-900/10 dark:ring-black/20 overflow-hidden">
                        <!-- Fake Browser Bar -->
                        <div class="flex items-center gap-2 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-3">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <div class="mx-auto text-xs text-gray-400 font-mono">dashboard.libsys.id</div>
                        </div>
                        <!-- Mock Content -->
                        <div class="p-6 grid grid-cols-3 gap-6 opacity-50 blur-[1px] select-none pointer-events-none">
                            <div class="col-span-2 space-y-4">
                                <div class="h-32 bg-gray-100 dark:bg-gray-700/50 rounded-lg"></div>
                                <div class="h-64 bg-gray-100 dark:bg-gray-700/50 rounded-lg"></div>
                            </div>
                            <div class="space-y-4">
                                <div class="h-20 bg-gray-100 dark:bg-gray-700/50 rounded-lg"></div>
                                <div class="h-20 bg-gray-100 dark:bg-gray-700/50 rounded-lg"></div>
                                <div class="h-48 bg-gray-100 dark:bg-gray-700/50 rounded-lg"></div>
                            </div>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="bg-indigo-600/90 text-white px-6 py-3 rounded-full font-bold backdrop-blur-sm shadow-xl">
                                Tampilan Dashboard User
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="border-y border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-100 dark:divide-gray-800">
                    <div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">10k+</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Buku & Jurnal</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">500+</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Anggota Aktif</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">24h</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Akses Sistem</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">4.9</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Rating Pengguna</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Books Preview Section -->
        <div id="koleksi" class="py-24 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-end mb-12">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Koleksi Terpopuler</h2>
                        <p class="text-gray-600 dark:text-gray-400 max-w-xl">
                            Temukan buku-buku yang paling banyak diminati oleh komunitas kami minggu ini.
                        </p>
                    </div>
                    <a href="#" class="hidden md:inline-flex items-center text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                        Lihat Semua Koleksi <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Book Card 1 -->
                    <div class="group flex flex-col bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-300 overflow-hidden">
                        <div class="h-48 bg-gray-200 dark:bg-gray-700 relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400" alt="Book" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-500">
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/80 dark:text-indigo-300 backdrop-blur-sm">
                                    Fiksi
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-1 mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">The Psychology of Money</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Morgan Housel</p>
                            <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-xs font-medium text-green-600 dark:text-green-400 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Tersedia
                                </span>
                                <button class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                    <i class="fa-regular fa-bookmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Book Card 2 -->
                    <div class="group flex flex-col bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-300 overflow-hidden">
                        <div class="h-48 bg-gray-200 dark:bg-gray-700 relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1592496431122-2349e0fbc666?auto=format&fit=crop&q=80&w=400" alt="Book" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-500">
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/80 dark:text-indigo-300 backdrop-blur-sm">
                                    Teknologi
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-1 mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">Clean Code</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Robert C. Martin</p>
                            <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-xs font-medium text-yellow-600 dark:text-yellow-400 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span> Terbatas
                                </span>
                                <button class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                    <i class="fa-regular fa-bookmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Book Card 3 -->
                    <div class="group flex flex-col bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-300 overflow-hidden">
                        <div class="h-48 bg-gray-200 dark:bg-gray-700 relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=400" alt="Book" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-500">
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/80 dark:text-indigo-300 backdrop-blur-sm">
                                    Sejarah
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-1 mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">Sapiens: A Brief History</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Yuval Noah Harari</p>
                            <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-xs font-medium text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Habis
                                </span>
                                <button class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                    <i class="fa-regular fa-bookmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Book Card 4 -->
                    <div class="group flex flex-col bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-300 overflow-hidden">
                        <div class="h-48 bg-gray-200 dark:bg-gray-700 relative overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1629196914375-f7e48f477b6d?auto=format&fit=crop&q=80&w=400" alt="Book" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-500">
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/80 dark:text-indigo-300 backdrop-blur-sm">
                                    Sains
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-1 mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">Astrophysics</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Neil deGrasse Tyson</p>
                            <div class="mt-auto flex justify-between items-center pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-xs font-medium text-green-600 dark:text-green-400 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Tersedia
                                </span>
                                <button class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                    <i class="fa-regular fa-bookmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-center md:hidden">
                    <a href="#" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                        Lihat Semua Koleksi <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="fitur" class="py-24 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Fitur Unggulan</h2>
                    <p class="text-gray-600 dark:text-gray-400">Dirancang untuk memudahkan pengalaman membaca dan manajemen buku Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <!-- Feature 1 -->
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-2xl mb-6 shadow-sm">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Peminjaman Cepat</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Proses peminjaman tanpa antri. Cukup scan QR code atau booking lewat aplikasi.
                        </p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-2xl mb-6 shadow-sm">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Notifikasi Pintar</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Dapatkan pengingat otomatis sebelum masa peminjaman Anda habis untuk menghindari denda.
                        </p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-2xl mb-6 shadow-sm">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Katalog Lengkap</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Ribuan judul dari berbagai kategori, jurnal ilmiah, hingga skripsi digital tersedia.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="relative py-20 overflow-hidden bg-gray-900">
            <div class="absolute inset-0 bg-indigo-600/10"></div>
            <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Mulai Petualangan Literasi Anda</h2>
                <p class="text-gray-400 text-lg mb-8 max-w-2xl mx-auto">Bergabunglah dengan ribuan anggota lainnya dan nikmati kemudahan akses perpustakaan dalam genggaman.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-indigo-600/30 transition duration-200">
                        Daftar Sekarang - Gratis
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-950 border-t border-gray-200 dark:border-gray-800 pt-16 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                    <div class="col-span-1 md:col-span-1">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-book-open text-indigo-600"></i>
                            <span class="font-bold text-xl text-gray-900 dark:text-white">LibSys</span>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            Membangun ekosistem literasi digital yang mudah diakses, modern, dan inklusif bagi seluruh masyarakat.
                        </p>
                    </div>

                    <div>
                        <h4 class="text-gray-900 dark:text-white font-bold mb-4">Navigasi</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <li><a href="#" class="hover:text-indigo-600 dark:hover:text-white transition">Beranda</a></li>
                            <li><a href="#" class="hover:text-indigo-600 dark:hover:text-white transition">Katalog</a></li>
                            <li><a href="#" class="hover:text-indigo-600 dark:hover:text-white transition">E-Journal</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-gray-900 dark:text-white font-bold mb-4">Bantuan</h4>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <li><a href="#" class="hover:text-indigo-600 dark:hover:text-white transition">FAQ</a></li>
                            <li><a href="#" class="hover:text-indigo-600 dark:hover:text-white transition">Kebijakan Privasi</a></li>
                            <li><a href="#" class="hover:text-indigo-600 dark:hover:text-white transition">Syarat & Ketentuan</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-gray-900 dark:text-white font-bold mb-4">Media Sosial</h4>
                        <div class="flex gap-4">
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center text-gray-500 hover:bg-indigo-600 hover:text-white transition duration-300">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center text-gray-500 hover:bg-indigo-600 hover:text-white transition duration-300">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-900 flex items-center justify-center text-gray-500 hover:bg-indigo-600 hover:text-white transition duration-300">
                                <i class="fa-brands fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-500 dark:text-gray-600 text-sm">
                        &copy; 2023 LibSys Digital Library. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</x-guest-layout>