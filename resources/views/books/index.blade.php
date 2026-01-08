<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Books Collection
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Search -->
            <form method="GET" class="mb-6">
                <input type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search books..."
                    class="w-full md:w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 rounded-lg" />
            </form>

            <!-- Book Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($books as $book)
                <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg flex flex-col justify-between">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $book->title }}
                        </h3>

                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $book->author }}
                        </p>

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-500">
                            Category: {{ $book->category->name ?? 'Uncategorized' }}
                        </p>

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-500">
                            ISBN: {{ $book->isbn }}
                        </p>

                        <p class="mt-2 text-sm font-medium
                            {{ $book->available_copies > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $book->available_copies }} Copies Available
                        </p>
                    </div>

                    <!-- View Details Button -->
                    <a href="{{ route('books.show', $book->id) }}"
                       class="mt-4 w-full inline-block text-center px-4 py-2 bg-blue-600
                              hover:bg-blue-700 text-white rounded-lg">
                        View Details
                    </a>

                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
