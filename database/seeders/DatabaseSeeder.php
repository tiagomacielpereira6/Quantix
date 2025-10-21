<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar seeders del sistema de carrito
        $this->call([
            AdminUserSeeder::class,
            ProductoSeeder::class,
            ClienteSeeder::class,
        ]);
    }
}
