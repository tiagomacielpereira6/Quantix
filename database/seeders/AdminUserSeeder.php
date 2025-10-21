<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Buscar o crear usuario admin
        $admin = User::where('email', 'admin@carrito.com')->first();
        
        if ($admin) {
            // Actualizar usuario existente con username
            $admin->update([
                'name' => 'Administrador',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
            ]);
            $this->command->info('Usuario admin actualizado con username.');
        } else {
            // Crear nuevo usuario
            User::create([
                'name' => 'Administrador',
                'username' => 'admin',
                'email' => 'admin@carrito.com',
                'password' => Hash::make('admin123'),
            ]);
            $this->command->info('Usuario admin creado.');
        }
    }
}