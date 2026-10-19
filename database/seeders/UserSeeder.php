<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //Data Admin
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'sisutosistem@gmail.com', // Saya sesuaikan dengan error log Anda
            'password' => Hash::make('admin12'),
            'role' => 'admin',
        ]);

        //Data Karyawan
        User::create([
            'name' => 'Budi Prihatin',
            'username' => 'budiprihatin',
            'email' => 'yuvikatriana46@sma.belajar.id',
            'password' => Hash::make('budiprihatin12'),
            'role' => 'karyawan',
        ]);
    }
}