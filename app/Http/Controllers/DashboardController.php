<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /* ==========================
       CURRENT & RECENT DATA
    ========================== */

        // Currently borrowed books
        $currentLoans = Loan::with('book.category')
            ->where('user_id', $user->id)
            ->where('status', 'borrowed')
            ->orderBy('borrow_date', 'desc')
            ->get();

        // Recently returned books
        $recentReturns = Loan::with('book.category')
            ->where('user_id', $user->id)
            ->where('status', 'returned')
            ->orderBy('returned_at', 'desc')
            ->limit(5)
            ->get();

        /* ==========================
       STATS
    ========================== */

        $stats = [
            'borrowed' => $currentLoans->count(),

            'returned' => Loan::where('user_id', $user->id)
                ->where('status', 'returned')
                ->count(),

            'overdue' => Loan::where('user_id', $user->id)
                ->where('status', 'borrowed')
                ->where('due_date', '<', now())
                ->count(),

            'total' => Loan::where('user_id', $user->id)->count(),
        ];

        /* ==========================
       NEXT DUE DATE
    ========================== */

        $nextDueLoan = Loan::where('user_id', $user->id)
            ->where('status', 'borrowed')
            ->orderBy('due_date')
            ->first();

        /* ==========================
       BORROW HISTORY (6 MONTHS)
    ========================== */

        $borrowHistory = Loan::selectRaw('DATE_FORMAT(borrow_date, "%Y-%m") as month, COUNT(*) as total')
            ->where('user_id', $user->id)
            ->where('borrow_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        /* ==========================
       MOST BORROWED CATEGORY
    ========================== */

        $topCategory = Loan::join('books', 'loans.book_id', '=', 'books.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->where('loans.user_id', $user->id)
            ->select('categories.name', DB::raw('COUNT(*) as total'))
            ->groupBy('categories.name')
            ->orderByDesc('total')
            ->first();

        return view('dashboard', compact(
            'currentLoans',
            'recentReturns',
            'stats',
            'nextDueLoan',
            'borrowHistory',
            'topCategory'
        ));
    }
}
