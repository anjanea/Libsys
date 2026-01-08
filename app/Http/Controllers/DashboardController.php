<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalBooks = Book::count();

        $activeLoans = Loan::where('user_id', $user->id)
            ->whereNull('returned_at')
            ->count();

        $returnedLoans = Loan::where('user_id', $user->id)
            ->whereNotNull('returned_at')
            ->count();

        return view('dashboard', compact(
            'totalBooks',
            'activeLoans',
            'returnedLoans'
        ));
    }
}
