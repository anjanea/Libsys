<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Total Books -->
                <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Total Books
                    </h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                        {{ $totalBooks }}
                    </p>
                </div>

                <!-- Active Loans -->
                <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Active Loans
                    </h3>
                    <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">
                        {{ $activeLoans }}
                    </p>
                </div>

                <!-- Returned Loans -->
                <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Returned Books
                    </h3>
                    <p class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">
                        {{ $returnedLoans }}
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
