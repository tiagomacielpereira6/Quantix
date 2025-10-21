<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = [
            ['nombre' => 'Juan Pérez', 'telefono' => '3456789012', 'correo' => 'juan.perez@email.com'],
            ['nombre' => 'María González', 'telefono' => '3456789013', 'correo' => 'maria.gonzalez@email.com'],
            ['nombre' => 'Carlos Rodríguez', 'telefono' => '3456789014', 'correo' => null],
            ['nombre' => 'Ana López', 'telefono' => '3456789015', 'correo' => 'ana.lopez@email.com'],
            ['nombre' => 'Pedro Martínez', 'telefono' => '3456789016', 'correo' => null],
            ['nombre' => 'Laura Sánchez', 'telefono' => '3456789017', 'correo' => 'laura.sanchez@email.com'],
            ['nombre' => 'Roberto Silva', 'telefono' => '3456789018', 'correo' => 'roberto.silva@email.com'],
            ['nombre' => 'Sofía Torres', 'telefono' => '3456789019', 'correo' => null],
            ['nombre' => 'Miguel Herrera', 'telefono' => '3456789020', 'correo' => 'miguel.herrera@email.com'],
            ['nombre' => 'Valentina Morales', 'telefono' => '3456789021', 'correo' => 'valentina.morales@email.com'],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
