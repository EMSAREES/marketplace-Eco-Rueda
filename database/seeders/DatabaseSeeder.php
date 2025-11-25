<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tienda.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_verified' => true
        ]);

        // Vendedor de prueba
        $vendor = User::create([
            'name' => 'Vendedor Sillas Sostenibles',
            'email' => 'vendor@tienda.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'is_verified' => true,
            'phone' => '555-1234'
        ]);

        // Productos de ejemplo
        $products = [
            [
                'name' => 'Silla Moderna Eco - Madera Reciclada',
                'description' => 'Hermosa silla hecha con madera 100% reciclada. Diseño moderno y cómodo.',
                'price' => 45.99,
                'stock' => 10,
                'material' => 'Madera reciclada',
                'color' => 'Natural'
            ],
            [
                'name' => 'Silla Plástico Reutilizado',
                'description' => 'Silla ligera y resistente hecha con plástico PET reutilizado.',
                'price' => 35.50,
                'stock' => 15,
                'material' => 'Plástico reciclado',
                'color' => 'Gris'
            ],
            [
                'name' => 'Silla de Comedor Vintage',
                'description' => 'Silla estilo vintage restaurada con materiales sostenibles.',
                'price' => 55.00,
                'stock' => 8,
                'material' => 'Madera y tela reciclada',
                'color' => 'Castaño'
            ]
        ];

        foreach ($products as $product) {
            Product::create([
                'vendor_id' => $vendor->id,
                ...$product
            ]);
        }

        // Cliente de prueba
        User::create([
            'name' => 'Cliente Prueba',
            'email' => 'customer@tienda.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '555-5678',
            'address' => 'Calle Principal 123',
            'city' => 'Guasave',
            'state' => 'Sinaloa',
            'country' => 'México',
            'postal_code' => '81250'
        ]);
    }
}
