<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        try {
            Log::info('=== INICIANDO SEEDER ===');

            // Vendedor de prueba - Crear solo si no existe
            $vendor = User::firstOrCreate(
                ['email' => 'vendor@tienda.com'],
                [
                    'name' => 'Vendedor Sillas Sostenibles',
                    'password' => Hash::make('password'),
                    'role' => 'vendor',
                    'is_verified' => true,
                    'phone' => '555-1234'
                ]
            );

            Log::info('Usuario creado/encontrado: ' . $vendor->email . ' (ID: ' . $vendor->id . ')');
            echo "\n✓ Usuario vendor creado exitosamente\n";

        } catch (\Exception $e) {
            Log::error('Error en seeder: ' . $e->getMessage());
            echo "\n✗ Error en seeder: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}
