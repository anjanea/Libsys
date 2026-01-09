<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Koleksi Buku') }}
            </h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Menampilkan {{ $books->count() }} dari {{ $books->total() }} buku
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- FILTER BAR -->
            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    
                    <!-- Search (Span 4) -->
                    <div class="md:col-span-4 space-y-1">
                        <label for="search" class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pencarian</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                placeholder="Judul buku atau penulis...">
                        </div>
                    </div>

                    <!-- Category (Span 3) -->
                    <div class="md:col-span-3 space-y-1">
                        <label for="category" class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</label>
                        <select name="category" id="category" 
                            class="block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Availability (Span 2) -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="availability" class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</label>
                        <select name="availability" id="availability" 
                            class="block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Semua</option>
                            <option value="available" @selected(request('availability') === 'available')>Tersedia</option>
                        </select>
                    </div>

                    <!-- Sort (Span 2) -->
                    <div class="md:col-span-2 space-y-1">
                        <label for="sort" class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Urutkan</label>
                        <select name="sort" id="sort" 
                            class="block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="newest">Terbaru</option>
                            <option value="alphabetical" @selected(request('sort') === 'alphabetical')>A-Z Judul</option>
                            <option value="most_borrowed" @selected(request('sort') === 'most_borrowed')>Populer</option>
                        </select>
                    </div>

                    <!-- Button (Span 1) -->
                    <div class="md:col-span-1">
                        <button type="submit" class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            <i class="fa-solid fa-filter md:hidden mr-2"></i> Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- BOOK GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($books as $book)
                    <div class="group flex flex-col bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-xl border border-gray-200 dark:border-gray-700 transition-all duration-300 overflow-hidden">
                        
                        <!-- Visual Header / Cover Placeholder -->
                        <!-- Jika Anda memiliki kolom cover_url, uncomment bagian img dan hapus div placeholder -->
                        <div class="h-32 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 relative flex items-center justify-center overflow-hidden">
                            @if(isset($book->cover_path) && $book->cover_path)
                                <img src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->title }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition duration-500">
                            @else
                                <!-- Pattern Placeholder jika tidak ada gambar -->
                                <i class="fa-solid fa-book-open text-4xl text-gray-300 dark:text-gray-600"></i>
                                <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-white dark:from-gray-800 to-transparent"></div>
                            @endif

                            <!-- Category Badge (Absolute) -->
                            <div class="absolute top-3 right-3">
                                @if($book->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/80 dark:text-indigo-300 shadow-sm backdrop-blur-sm border border-indigo-200 dark:border-indigo-500/30">
                                        {{ $book->category->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700/80 dark:text-gray-300 shadow-sm backdrop-blur-sm">
                                        Umum
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex-1 flex flex-col">
                            <!-- Title & Author -->
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-1 group-hover:text-indigo-500 transition-colors" title="{{ $book->title }}">
                                    {{ $book->title }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-1">
                                    <i class="fa-regular fa-user text-xs"></i> {{ $book->author }}
                                </p>
                            </div>

                            <!-- Meta Info Grid -->
                            <div class="grid grid-cols-2 gap-3 mb-6 mt-auto">
                                <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-2 text-center border border-gray-100 dark:border-gray-700">
                                    <span class="block text-xs text-gray-400 uppercase tracking-wide">ISBN</span>
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
                                        {{ $book->isbn ?? '-' }}
                                    </span>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-2 text-center border border-gray-100 dark:border-gray-700">
                                    <span class="block text-xs text-gray-400 uppercase tracking-wide">Dipinjam</span>
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $book->times_borrowed }}x
                                    </span>
                                </div>
                            </div>

                            <!-- Footer: Status & Action -->
                            <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                                <!-- Status Indicator -->
                                <div class="flex items-center gap-2">
                                    @if($book->available_copies > 0)
                                        <span class="flex h-2.5 w-2.5 relative">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                                        </span>
                                        <span class="text-xs font-medium text-green-600 dark:text-green-400">Tersedia</span>
                                    @else
                                        <span class="inline-block h-2.5 w-2.5 rounded-full bg-red-500"></span>
                                        <span class="text-xs font-medium text-red-600 dark:text-red-400">Habis</span>
                                    @endif
                                </div>

                                <!-- Action Button -->
                                <a href="{{ route('books.show', $book->id) }}" 
                                   class="inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 transition-colors group/link">
                                    Detail <i class="fa-solid fa-arrow-right ml-1 transform group-hover/link:translate-x-1 transition-transform text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State (Jika tidak ada hasil filter) -->
            @if($books->isEmpty())
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                        <i class="fa-solid fa-book text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Buku tidak ditemukan</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Coba sesuaikan kata kunci atau filter pencarian Anda.</p>
                </div>
            @endif

            <!-- Pagination -->
            <div class="mt-8">
                {{ $books->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>