<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'atmin',
            'email' => 'admin@gmail.com',
            'password' => 'atmin123',
            'role' => 'admin', // Pastikan kolom 'role' ada di database Anda
        ]);

        // 2. Buat Akun Librarian (Pustakawan)
        User::create([
            'name' => 'librarian',
            'email' => 'librarian@gmail.com',
            'password' => 'perpus123',
            'role' => 'librarian',
        ]);

        // 3. Buat Akun User Biasa (Mahasiswa)
        User::create([
            'name' => 'orang',
            'email' => 'user@gmail.com',
            'password' =>'orang123',
            'role' => 'member',
        ]);
    }
}
