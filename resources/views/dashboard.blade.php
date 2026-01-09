<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- 1. Greeting & Search Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Berikut adalah aktivitas perpustakaan Anda hari ini.</p>
                </div>
                <div class="w-full md:w-1/3 relative">
                    <form action="{{ route('books.index') }}" method="GET">
                        <input type="text" name="search" 
                            class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded-lg pl-10 pr-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm" 
                            placeholder="Cari buku...">
                        <div class="absolute left-3 top-2.5 text-gray-500">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 2. Stats Grid (Matched with $stats) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Stat Card: Active Loans -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400">
                                <i class="fa-solid fa-book-open text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Sedang Dipinjam</div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['borrowed'] ?? 0 }} Buku
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Total History -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400">
                                <i class="fa-solid fa-rotate-left text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Peminjaman</div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['total'] ?? 0 }} Buku
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stat Card: Overdue/Fines -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 dark:bg-red-900/50 text-red-600 dark:text-red-400">
                                <i class="fa-solid fa-circle-exclamation text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Terlambat / Denda</div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $stats['overdue'] ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- LEFT COLUMN (2/3 width) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- 3. Active Loans Table -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Peminjaman Aktif</h4>
                            <a href="#" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">Lihat Semua</a>
                        </div>
                        
                        <div class="p-0">
                            @if($currentLoans->isEmpty())
                                <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                    <p class="mb-2">Anda tidak sedang meminjam buku apapun.</p>
                                    <a href="{{ route('books.index') }}" class="text-indigo-500 hover:underline">Jelajahi Katalog &rarr;</a>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 dark:text-gray-400 uppercase bg-gray-50 dark:bg-gray-700/50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Buku</th>
                                                <th scope="col" class="px-6 py-3 hidden sm:table-cell">Jatuh Tempo</th>
                                                <th scope="col" class="px-6 py-3">Status</th>
                                                <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($currentLoans as $loan)
                                                @php
                                                    $dueDate = \Carbon\Carbon::parse($loan->due_date);
                                                    $daysLeft = now()->diffInDays($dueDate, false);
                                                    
                                                    // Logic status warna
                                                    if ($daysLeft < 0) {
                                                        $statusClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 border-red-200 dark:border-red-800';
                                                        $statusText = 'Terlambat';
                                                    } elseif ($daysLeft < 3) {
                                                        $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800';
                                                        $statusText = $daysLeft . ' Hari Lagi';
                                                    } else {
                                                        $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 border-green-200 dark:border-green-800';
                                                        $statusText = 'Aman';
                                                    }
                                                @endphp
                                                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                        <div class="flex items-center gap-3">
                                                            <!-- Placeholder Cover jika tidak ada image -->
                                                            <div class="w-8 h-10 bg-gray-200 dark:bg-gray-600 rounded overflow-hidden shrink-0">
                                                                @if($loan->book->cover_url)
                                                                    <img src="{{ asset('storage/' . $book->cover_path) }}" class="w-full h-full object-cover">
                                                                @else
                                                                    <div class="flex items-center justify-center h-full text-xs text-gray-500">Img</div>
                                                                @endif
                                                            </div>
                                                            <span class="line-clamp-1">{{ $loan->book->title }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 hidden sm:table-cell">
                                                        {{ $dueDate->format('d M Y') }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span class="{{ $statusClass }} text-xs font-medium px-2.5 py-0.5 rounded border">
                                                            {{ $statusText }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-right">
                                                        <a href="{{ route('books.show', $loan->book_id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- 4. Recommendations (Visual Mockup) -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Rekomendasi Untuk Anda</h4>
                        </div>
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Card Statis sebagai Placeholder Layout -->
                            <div class="flex gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition cursor-pointer">
                                <div class="w-16 h-20 bg-gray-300 dark:bg-gray-600 rounded shrink-0 overflow-hidden">
                                    <!-- Ganti src dengan asset real -->
                                    <div class="w-full h-full bg-gray-400 flex items-center justify-center text-white text-xs">Cover</div>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h5 class="text-gray-900 dark:text-white font-medium line-clamp-1">Atomic Habits</h5>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">James Clear</p>
                                    <div class="text-xs text-indigo-500">Lihat Detail &rarr;</div>
                                </div>
                            </div>
                            
                            <div class="flex gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition cursor-pointer">
                                <div class="w-16 h-20 bg-gray-300 dark:bg-gray-600 rounded shrink-0 overflow-hidden">
                                    <div class="w-full h-full bg-gray-400 flex items-center justify-center text-white text-xs">Cover</div>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h5 class="text-gray-900 dark:text-white font-medium line-clamp-1">Design Patterns</h5>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Erich Gamma</p>
                                    <div class="text-xs text-indigo-500">Lihat Detail &rarr;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN (1/3 width) -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- 5. Notification / Reminder (Based on $nextDueLoan) -->
                    @if(isset($nextDueLoan) && $nextDueLoan)
                        <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-500/30 rounded-lg p-4">
                            <div class="flex gap-3">
                                <i class="fa-solid fa-bell text-indigo-600 dark:text-indigo-400 mt-1"></i>
                                <div>
                                    <h5 class="text-gray-900 dark:text-white font-medium text-sm">Pengingat!</h5>
                                    <p class="text-gray-600 dark:text-indigo-200 text-xs mt-1">
                                        Buku <strong>"{{ $nextDueLoan->book->title }}"</strong> harus dikembalikan pada {{ $nextDueLoan->due_date->format('d M') }}.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- 6. Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi Cepat</h4>
                            <div class="space-y-3">
                                <button class="w-full flex items-center justify-between p-3 rounded bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 transition">
                                    <span class="flex items-center gap-3">
                                        <i class="fa-solid fa-qrcode text-gray-500 dark:text-gray-400"></i> Scan QR
                                    </span>
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>
                                <a href="{{ route('books.index') }}" class="w-full flex items-center justify-between p-3 rounded bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 transition">
                                    <span class="flex items-center gap-3">
                                        <i class="fa-solid fa-list text-gray-500 dark:text-gray-400"></i> Cari Buku
                                    </span>
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </a>
                                <button class="w-full flex items-center justify-between p-3 rounded bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 transition">
                                    <span class="flex items-center gap-3">
                                        <i class="fa-regular fa-id-card text-gray-500 dark:text-gray-400"></i> Kartu Anggota
                                    </span>
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 7. Mini Calendar (Visual Only) -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ now()->format('F Y') }}</h4>
                            <div class="grid grid-cols-7 gap-1 text-center text-xs">
                                <div class="text-gray-400 py-1">M</div>
                                <div class="text-gray-400 py-1">S</div>
                                <div class="text-gray-400 py-1">S</div>
                                <div class="text-gray-400 py-1">R</div>
                                <div class="text-gray-400 py-1">K</div>
                                <div class="text-gray-400 py-1">J</div>
                                <div class="text-gray-400 py-1">S</div>

                                {{-- Simple Logic to simulate calendar days --}}
                                @for($i = 1; $i <= 30; $i++)
                                    <div class="{{ $i == now()->day ? 'bg-indigo-600 text-white rounded-full' : 'text-gray-600 dark:text-gray-300' }} py-1">
                                        {{ $i }}
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>