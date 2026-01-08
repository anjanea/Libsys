<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">

        <h1 class="text-3xl font-bold text-white mb-6">My Loans</h1>

        @if ($loans->isEmpty())
            <p class="text-gray-400">You have no loan records yet.</p>
        @else
            <div class="bg-gray-800 shadow rounded-lg overflow-hidden">
                <table class="w-full text-left text-gray-300">
                    <thead class="bg-gray-900 text-gray-400 uppercase text-sm">
                        <tr>
                            <th class="px-4 py-3">Book</th>
                            <th class="px-4 py-3">Borrowed</th>
                            <th class="px-4 py-3">Due</th>
                            <th class="px-4 py-3">Returned</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach ($loans as $loan)
                            <tr>
                                <td class="px-4 py-3">
                                    <a href="{{ route('books.show', $loan->book->id) }}"
                                       class="text-blue-400 hover:underline">
                                        {{ $loan->book->title }}
                                    </a>
                                </td>

                                <td class="px-4 py-3">
                                    {{ $loan->borrow_date ? $loan->borrow_date->format('Y-m-d') : '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $loan->due_date ? $loan->due_date->format('Y-m-d') : '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $loan->returned_at ? $loan->returned_at->format('Y-m-d') : 'Not returned' }}
                                </td>

                                <td class="px-4 py-3">
                                    @if ($loan->returned_at)
                                        <span class="text-green-400">Returned</span>
                                    @elseif ($loan->due_date && $loan->due_date < now())
                                        <span class="text-red-400">Overdue</span>
                                    @else
                                        <span class="text-yellow-400">Borrowed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</x-app-layout>
