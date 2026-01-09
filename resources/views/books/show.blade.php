<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb / Back Navigation -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('books.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Koleksi
                        </a>
                    </li>
                </ol>
            </nav>

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                
                <!-- Main Content Grid -->
                <div class="md:flex">
                    
                    <!-- LEFT COLUMN: Cover Image -->
                    <div class="md:w-1/3 lg:w-1/4 bg-gray-50 dark:bg-gray-900/50 p-8 flex items-start justify-center border-r border-gray-100 dark:border-gray-700">
                        <div class="relative group w-48 shadow-2xl rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                            @if($book->cover_path)
                                <img src="{{ asset('storage/' . $book->cover_path) }}" 
                                     alt="{{ $book->title }}" 
                                     class="w-full h-auto object-cover">
                            @else
                                <!-- Modern Placeholder -->
                                <div class="w-full h-72 bg-gradient-to-br from-indigo-500 to-purple-600 flex flex-col items-center justify-center text-white p-4 text-center">
                                    <i class="fa-solid fa-book-open text-4xl mb-3 opacity-80"></i>
                                    <span class="font-bold text-sm line-clamp-2">{{ $book->title }}</span>
                                    <span class="text-xs mt-1 opacity-75">{{ $book->author }}</span>
                                </div>
                            @endif
                            
                            <!-- Status Badge Floating -->
                            <div class="absolute top-2 right-2">
                                @if($book->available_copies > 0)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-green-500 text-white shadow-sm">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-red-500 text-white shadow-sm">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Details -->
                    <div class="md:w-2/3 lg:w-3/4 p-8 flex flex-col">
                        
                        <!-- Title & Author Header -->
                        <div class="mb-6">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                @if($book->category)
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300">
                                        {{ $book->category->name }}
                                    </span>
                                @endif
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    {{ $book->language ?? 'Bahasa Indonesia' }}
                                </span>
                            </div>
                            
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">
                                {{ $book->title }}
                            </h1>
                            @if($book->subtitle)
                                <p class="text-lg text-gray-500 dark:text-gray-400 font-light italic mb-2">{{ $book->subtitle }}</p>
                            @endif
                            
                            <p class="text-lg text-gray-700 dark:text-gray-300 flex items-center gap-2">
                                <span class="text-gray-400 text-sm uppercase tracking-wide font-semibold">Penulis:</span>
                                {{ $book->author }}
                            </p>
                        </div>

                        <!-- Synopsis / Description -->
                        <div class="mb-8 prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-2 border-b border-gray-100 dark:border-gray-700 pb-1">Sinopsis</h3>
                            <p class="whitespace-pre-line leading-relaxed">
                                {{ $book->description ?: 'Tidak ada deskripsi tersedia untuk buku ini.' }}
                            </p>
                        </div>

                        <!-- Metadata Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 bg-gray-50 dark:bg-gray-900/50 p-5 rounded-xl border border-gray-100 dark:border-gray-700">
                            <div>
                                <span class="block text-xs text-gray-400 uppercase tracking-wider font-semibold">ISBN</span>
                                <span class="block font-medium text-gray-900 dark:text-white mt-1">{{ $book->isbn ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 uppercase tracking-wider font-semibold">Penerbit</span>
                                <span class="block font-medium text-gray-900 dark:text-white mt-1">{{ $book->publisher ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 uppercase tracking-wider font-semibold">Tahun</span>
                                <span class="block font-medium text-gray-900 dark:text-white mt-1">{{ $book->publication_year ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 uppercase tracking-wider font-semibold">Stok</span>
                                <span class="block font-medium mt-1 {{ $book->available_copies > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $book->available_copies }} Buku
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-auto pt-6 border-t border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row gap-4 justify-end items-center">
                            
                            <form method="POST" action="{{ route('loans.store') }}" class="w-full sm:w-auto">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">

                                @if($book->available_copies > 0)
                                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                                        <i class="fa-solid fa-book-bookmark mr-2"></i> Pinjam Buku
                                    </button>
                                @else
                                    <button type="button" disabled class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-lg text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 cursor-not-allowed">
                                        <i class="fa-solid fa-ban mr-2"></i> Stok Habis
                                    </button>
                                @endif
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>