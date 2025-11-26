<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor = User::create([
            'name' => 'Vendedor Sillas Sostenibles',
            'email' => 'vendor@tienda.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'is_verified' => true,
            'phone' => '555-1234'
        ]);
    }
}
