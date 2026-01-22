<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function borrow(Book $book)
    {
        $user = Auth::user();

        // 1. Validasi Stok
        if ($book->available_copies <= 0) {
            return back()->with('error', 'Maaf, stok buku ini sedang habis.');
        }

        // 2. Batasi maksimal 3 peminjaman aktif
        $activeLoansCount = Loan::where('user_id', $user->id)
            ->where('status', 'borrowed')
            ->count();

        if ($activeLoansCount >= 3) {
            return back()->with('error', 'Kamu sudah meminjam 3 buku. Kembalikan buku lama terlebih dahulu.');
        }

        // 3. Cek apakah user sudah meminjam buku yang sama
        $alreadyBorrowed = Loan::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'Kamu sedang meminjam buku ini.');
        }

        // 4. Proses Transaksi
        try {
            DB::transaction(function () use ($book, $user) {
                Loan::create([
                    'user_id' => $user->id, // Menggunakan variabel $user yang sudah kita ambil di atas
                    'book_id' => $book->id,
                    'borrow_date' => now(),
                    'due_date' => now()->addDays(14),
                    'status' => 'borrowed',
                    'fine' => 0,
                ]);

                $book->decrement('available_copies');
            });

            return back()->with('success', 'Buku berhasil dipinjam! Cek menu Loans untuk melihat daftar pinjamanmu.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    public function returnBook($id)
    {
        $loan = Loan::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'borrowed')
            ->firstOrFail();

        DB::transaction(function () use ($loan) {
            $loan->update([
                'returned_at' => now(),
                'status' => 'returned',
            ]);

            $loan->book->increment('available_copies');
        });

        return back()->with('success', 'Buku berhasil dikembalikan!');
    }
}