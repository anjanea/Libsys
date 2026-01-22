<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;



class HomeController extends Controller
{
    public function index()
    {
        // Mengambil 4 buku terbaru yang statusnya aktif
        // Kita gunakan 'with' agar query kategori lebih efisien
        $featuredBooks = Book::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        // Menghitung total untuk bagian Stats di Landing Page
        $totalBooks = Book::count();
        $totalCategories = \App\Models\Category::count();

        $stats = [
            'total_books' => Book::count(),
            'total_members' => User::where('role', 'user')->count(), // Menghitung anggota non-librarian
            'total_categories' => \App\Models\Category::count(),
        ];

        return view('welcome', compact('featuredBooks', 'totalBooks', 'totalCategories', 'stats'));
    }
}
