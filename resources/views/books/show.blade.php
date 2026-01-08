<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ $book->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('books.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700
                          text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300
                          dark:hover:bg-gray-600 transition">
                    ← Back to Books
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Book Cover -->
                    <div class="flex justify-center md:justify-start">
                        @if($book->cover_path)
                            <img src="{{ asset('storage/' . $book->cover_path) }}"
                                alt="Book Cover"
                                class="w-48 h-72 object-cover rounded-lg shadow">
                        @else
                            <div class="w-48 h-72 bg-gray-300 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-600 dark:text-gray-300">
                                No Cover
                            </div>
                        @endif
                    </div>

                    <!-- Book Details -->
                    <div class="md:col-span-2 space-y-4">

                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $book->title }}
                        </h1>

                        @if ($book->subtitle)
                            <p class="text-lg text-gray-700 dark:text-gray-300">
                                {{ $book->subtitle }}
                            </p>
                        @endif

                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Author:</strong> {{ $book->author }}
                        </p>

                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Category:</strong> {{ $book->category->name ?? 'Uncategorized' }}
                        </p>

                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Language:</strong> {{ $book->language ?? '-' }}
                        </p>

                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>ISBN:</strong> {{ $book->isbn }}
                        </p>

                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Publisher:</strong> {{ $book->publisher ?? '-' }}
                        </p>

                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>Publication Year:</strong> {{ $book->publication_year ?? '-' }}
                        </p>

                        <p class="text-sm font-medium
                            {{ $book->available_copies > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            <strong>{{ $book->available_copies }}</strong> Copies Available
                        </p>

                        @if ($book->description)
                            <p class="text-gray-700 dark:text-gray-300 mt-3 whitespace-pre-line">
                                {{ $book->description }}
                            </p>
                        @endif
                    </div>
                </div>

                <hr class="my-6 border-gray-300 dark:border-gray-700">

                <!-- Borrow Button -->
                <div class="flex justify-end">
                    <form method="POST" action="{{ route('loans.store') }}">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">

                        @if($book->available_copies > 0)
                            <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                                Borrow This Book
                            </button>
                        @else
                            <button disabled class="px-6 py-2 bg-gray-400 dark:bg-gray-700 text-white rounded-lg">
                                Not Available
                            </button>
                        @endif
                    </form>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
