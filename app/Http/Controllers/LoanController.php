<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::where('user_id', Auth::id())
            ->with('book')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('loans.index', compact('loans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Prevent borrowing if no copies left
        if ($book->available_copies < 1) {
            return redirect()->back()->with('error', 'No copies available for this book.');
        }

        // Create loan record
        Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(14),
            'returned_at' => null,
            'status' => 'borrowed',
            'fine' => 0,
        ]);

        // Decrease available copies
        $book->decrement('available_copies');

        return redirect()->back()->with('success', 'Book borrowed successfully!');
    }

    public function returnLoan($id)
    {
        $loan = Loan::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereNull('returned_at')
            ->firstOrFail();

        $loan->update([
            'returned_at' => now(),
        ]);

        $loan->book->increment('available_copies');

        return back()->with('success', 'Book returned successfully!');
    }
}
