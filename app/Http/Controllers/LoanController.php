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
        $user = Auth::user();

        // Active loans
        $activeLoans = Loan::with('book')
            ->where('user_id', $user->id)
            ->where('status', 'borrowed')
            ->orderBy('borrow_date', 'desc')
            ->get();

        // Loan history
        $loanHistory = Loan::with('book')
            ->where('user_id', $user->id)
            ->where('status', 'returned')
            ->orderBy('returned_at', 'desc')
            ->paginate(10);

        return view('loans.index', compact('activeLoans', 'loanHistory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = Auth::user();
        $book = Book::findOrFail($request->book_id);

        // 1️⃣ Ensure only members can borrow
        if ($user->role !== 'member') {
            return back()->with('error', 'Only members can borrow books.');
        }

        // 2️⃣ Max 3 active loans
        $activeLoansCount = Loan::where('user_id', $user->id)
            ->where('status', 'borrowed')
            ->count();

        if ($activeLoansCount >= 3) {
            return back()->with('error', 'You can only borrow up to 3 books at a time.');
        }

        // 3️⃣ Prevent borrowing the same book twice
        $alreadyBorrowed = Loan::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'You have already borrowed this book.');
        }

        // 4️⃣ Check availability
        if ($book->available_copies < 1) {
            return back()->with('error', 'No copies available for this book.');
        }

        // 5️⃣ Create loan
        Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrow_date' => now(),
            'due_date' => now()->addDays(14),
            'returned_at' => null,
            'status' => 'borrowed',
            'fine' => 0,
        ]);

        // 6️⃣ Decrease available copies
        $book->decrement('available_copies');

        return back()->with('success', 'Book borrowed successfully!');
    }

    public function returnBook($id)
    {
        $loan = Loan::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'borrowed')
            ->firstOrFail();

        $loan->update([
            'returned_at' => now(),
            'status' => 'returned',
        ]);

        $loan->book->increment('available_copies');

        return back()->with('success', 'Book returned successfully!');
    }
}
