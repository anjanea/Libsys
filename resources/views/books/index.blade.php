<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Books Collection
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4">

                <!-- Search -->
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search title or author"
                    class="rounded-lg dark:bg-gray-800 dark:text-gray-200">

                <!-- Category -->
                <select name="category" class="rounded-lg dark:bg-gray-800 dark:text-gray-200">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category')==$cat->id)>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>

                <!-- Availability -->
                <select name="availability" class="rounded-lg dark:bg-gray-800 dark:text-gray-200">
                    <option value="">All</option>
                    <option value="available" @selected(request('availability')==='available' )>
                        Available Only
                    </option>
                </select>

                <!-- Sorting -->
                <select name="sort" class="rounded-lg dark:bg-gray-800 dark:text-gray-200">
                    <option value="newest">Newest</option>
                    <option value="alphabetical" @selected(request('sort')==='alphabetical' )>
                        Alphabetical
                    </option>
                    <option value="most_borrowed" @selected(request('sort')==='most_borrowed' )>
                        Most Borrowed
                    </option>
                </select>

                <button class="bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">
                    Apply Filters
                </button>
            </form>

            <!-- Book Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($books as $book)
                <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg flex flex-col justify-between">

                    <div class="space-y-2">

                        <!-- Title -->
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $book->title }}
                        </h3>

                        <!-- Author -->
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $book->author }}
                        </p>

                        <!-- Category Badges -->
                        @if($book->category)
                        <span class="px-2 py-1 text-xs bg-indigo-600 text-white rounded-full">
                            {{ $book->category->name }}
                        </span>
                        @else
                        <span class="px-2 py-1 text-xs bg-gray-400 text-white rounded-full">
                            Uncategorized
                        </span>
                        @endif

                        <!-- ISBN -->
                        <p class="text-xs text-gray-500 dark:text-gray-500">
                            ISBN: {{ $book->isbn ?? '—' }}
                        </p>

                        <!-- Borrow count -->
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Borrowed {{ $book->times_borrowed }} times
                        </p>

                        <!-- Availability Badge -->
                        <span class="inline-block w-fit px-3 py-1 text-xs rounded-full
        {{ $book->available_copies > 0
            ? 'bg-green-600 text-white'
            : 'bg-red-600 text-white' }}">
                            {{ $book->available_copies > 0 ? 'Available' : 'Not Available' }}
                        </span>

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