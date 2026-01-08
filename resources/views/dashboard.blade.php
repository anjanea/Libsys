<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- =======================
                 STATS CARDS
            ======================== -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Active Loans -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Active Loans</p>
                    <h3 class="text-3xl font-bold text-blue-600">
                        {{ $stats['borrowed'] }}
                    </h3>
                </div>

                <!-- Total Borrowed -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Borrowed</p>
                    <h3 class="text-3xl font-bold text-green-600">
                        {{ $stats['total'] }}
                    </h3>
                </div>

                <!-- Overdue -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Overdue</p>
                    <h3 class="text-3xl font-bold text-red-600">
                        {{ $stats['overdue'] }}
                    </h3>
                </div>

                <!-- Next Due -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Next Due</p>
                    @if($nextDueLoan)
                    <h3 class="text-lg font-semibold text-yellow-500">
                        {{ $nextDueLoan->due_date->format('M d, Y') }}
                    </h3>
                    <p class="text-sm text-gray-400 truncate">
                        {{ $nextDueLoan->book->title }}
                    </p>
                    @else
                    <p class="text-gray-400">No active loans</p>
                    @endif
                </div>

            </div>

            <!-- =======================
                 CURRENT LOANS
            ======================== -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    Currently Borrowed
                </h3>

                @if($currentLoans->isEmpty())
                <p class="text-gray-400">
                    You're not borrowing any books right now.
                    <a href="{{ route('books.index') }}" class="text-blue-500 hover:underline">
                        Browse books →
                    </a>
                </p>

                @else
                <div class="space-y-4">
                    @foreach($currentLoans as $loan)
                    <div class="flex justify-between items-center border-b dark:border-gray-700 pb-3">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">
                                {{ $loan->book->title }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Due: {{ $loan->due_date->format('M d, Y') }}
                            </p>
                        </div>

                        <a href="{{ route('books.show', $loan->book_id) }}"
                            class="text-blue-600 hover:underline text-sm">
                            View
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- =======================
                 RECENT RETURNS
            ======================== -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    Recently Returned
                </h3>

                @if($recentReturns->isEmpty())
                <p class="text-gray-400">No recent returns.</p>
                @else
                <ul class="space-y-3">
                    @foreach($recentReturns as $loan)
                    <li class="flex justify-between">
                        <span class="text-gray-900 dark:text-gray-100">
                            {{ $loan->book->title }}
                        </span>
                        <span class="text-sm text-gray-400">
                            {{ $loan->returned_at->format('M d') }}
                        </span>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>

        </div>
    </div>

    <!-- =======================
         CHART.JS
    ======================== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = window.borrowHistory.map(item => item.month);
        const data = window.borrowHistory.map(item => item.total);

        const ctx = document.getElementById('borrowChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Books Borrowed',
                    data,
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


</x-app-layout>