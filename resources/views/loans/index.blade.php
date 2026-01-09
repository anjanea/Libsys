<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Peminjaman Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- =======================
                 ACTIVE LOANS SECTION
            ======================== -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-book-open-reader text-indigo-500"></i>
                        Buku Sedang Dipinjam
                    </h3>
                    @if($activeLoans->isNotEmpty())
                        <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                            {{ $activeLoans->count() }} Buku
                        </span>
                    @endif
                </div>

                @if ($activeLoans->isEmpty())
                    <!-- Empty State -->
                    <div class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                            <i class="fa-solid fa-book text-gray-400 dark:text-gray-500 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tidak ada peminjaman aktif</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-1 mb-6">Anda sedang tidak meminjam buku apapun saat ini.</p>
                        <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors shadow-sm hover:shadow-md">
                            <i class="fa-solid fa-magnifying-glass mr-2 text-xs"></i> Jelajahi Koleksi
                        </a>
                    </div>
                @else
                    <!-- Active Loans List -->
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($activeLoans as $loan)
                            <div class="p-6 flex flex-col sm:flex-row gap-6 dark:hover:bg-gray-750 transition-colors group">
                                
                                <!-- Cover Image -->
                                <div class="shrink-0">
                                    <div class="w-24 h-36 bg-gray-200 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden relative border border-gray-200 dark:border-gray-600">
                                         @if($loan->book->cover_path)
                                            <img src="{{ asset('storage/' . $loan->book->cover_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex flex-col items-center justify-center text-center p-2 text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800">
                                                <i class="fa-solid fa-book mb-2 opacity-50"></i>
                                                <span class="text-[10px] leading-tight font-medium">{{ $loan->book->title }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Loan Info -->
                                <div class="flex-1 flex flex-col">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-1 leading-tight">
                                                <a href="{{ route('books.show', $loan->book->id) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                                    {{ $loan->book->title }}
                                                </a>
                                            </h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                                <span class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded text-xs font-medium">
                                                    {{ $loan->book->author }}
                                                </span>
                                            </p>
                                        </div>
                                        
                                        <!-- Time Status Logic -->
                                        @php
                                            $now = now();
                                            $due = \Carbon\Carbon::parse($loan->due_date);
                                            $isOverdue = $due->isPast();
                                            $diff = $now->diff($due);
                                            // Calculate absolute days for cleaner display
                                            $daysDiff = $now->diffInDays($due, false); 
                                        @endphp
                                        
                                        <!-- Desktop Status Badge -->
                                        <div class="hidden sm:block text-right">
                                             @if($isOverdue)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 border border-red-200 dark:border-red-800 animate-pulse">
                                                    <i class="fa-solid fa-circle-exclamation mr-1.5"></i> Terlambat {{ abs((int)$daysDiff) }} Hari
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800">
                                                    <i class="fa-regular fa-clock mr-1.5"></i> Sisa {{ (int)$daysDiff }} Hari
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Date Details Grid -->
                                    <div class="mt-4 grid grid-cols-2 gap-4 text-sm max-w-md">
                                        <div class="bg-gray-50 dark:bg-gray-900/50 p-2.5 rounded-lg border border-gray-100 dark:border-gray-700/50">
                                            <span class="block text-xs text-gray-500 dark:text-gray-500 uppercase tracking-wider font-semibold">Tanggal Pinjam</span>
                                            <span class="font-semibold text-gray-800 dark:text-gray-200 mt-0.5 block">
                                                {{ $loan->borrow_date->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-900/50 p-2.5 rounded-lg border border-gray-100 dark:border-gray-700/50">
                                            <span class="block text-xs text-gray-500 dark:text-gray-500 uppercase tracking-wider font-semibold">Jatuh Tempo</span>
                                            <span class="font-semibold mt-0.5 block {{ $isOverdue ? 'text-red-600 dark:text-red-400' : 'text-gray-800 dark:text-gray-200' }}">
                                                {{ $loan->due_date->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Mobile Status Badge (Visible only on small screens) -->
                                    <div class="mt-4 sm:hidden">
                                         @if($isOverdue)
                                            <span class="inline-flex items-center justify-center w-full px-3 py-1.5 rounded-lg text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 border border-red-200 dark:border-red-800">
                                                Terlambat {{ abs((int)$daysDiff) }} Hari
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-full px-3 py-1.5 rounded-lg text-xs font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800">
                                                Sisa {{ (int)$daysDiff }} Hari
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-4 sm:mt-0 flex items-center sm:self-center">
                                    <form action="{{ route('loans.return', $loan->id) }}" method="POST" class="w-full sm:w-auto">
                                        @csrf
                                        <button onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku {{ $loan->book->title }}?')" 
                                                class="w-full sm:w-auto whitespace-nowrap inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-500/30 transition-all hover:-translate-y-0.5">
                                            <i class="fa-solid fa-rotate-left mr-2"></i> Kembalikan Buku
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- =======================
                 LOAN HISTORY SECTION
            ======================== -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-gray-400"></i>
                        Riwayat Peminjaman
                    </h3>
                </div>

                @if ($loanHistory->isEmpty())
                     <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <p class="text-sm">Belum ada riwayat peminjaman yang tercatat.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-tl-lg">Buku</th>
                                    <th scope="col" class="px-6 py-3">Dipinjam</th>
                                    <th scope="col" class="px-6 py-3">Dikembalikan</th>
                                    <th scope="col" class="px-6 py-3 rounded-tr-lg">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($loanHistory as $loan)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            <div class="flex items-center gap-3">
                                                 <div class="w-8 h-10 bg-gray-200 dark:bg-gray-700 rounded overflow-hidden shrink-0 border border-gray-200 dark:border-gray-600">
                                                    @if($loan->book->cover_path)
                                                        <img src="{{ asset('storage/' . $loan->book->cover_path) }}" class="w-full h-full object-cover">
                                                    @else
                                                         <div class="flex items-center justify-center h-full text-[8px] text-gray-500">IMG</div>
                                                    @endif
                                                </div>
                                                <span class="line-clamp-1">{{ $loan->book->title }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $loan->borrow_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $loan->returned_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 border border-green-200 dark:border-green-800">
                                                <i class="fa-solid fa-check mr-1.5"></i> Selesai
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($loanHistory->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            {{ $loanHistory->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</x-app-layout>