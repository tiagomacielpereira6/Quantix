<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            // Comidas
            ['nombre' => 'Hamburguesa Clásica', 'precio' => 8.50, 'stock' => 25, 'categoria' => 'Comidas'],
            ['nombre' => 'Hamburguesa con Queso', 'precio' => 9.50, 'stock' => 30, 'categoria' => 'Comidas'],
            ['nombre' => 'Hot Dog Completo', 'precio' => 6.00, 'stock' => 20, 'categoria' => 'Comidas'],
            ['nombre' => 'Sandwich de Pollo', 'precio' => 7.50, 'stock' => 15, 'categoria' => 'Comidas'],
            ['nombre' => 'Papas Fritas', 'precio' => 4.50, 'stock' => 40, 'categoria' => 'Comidas'],
            ['nombre' => 'Empanadas (2 unidades)', 'precio' => 5.00, 'stock' => 35, 'categoria' => 'Comidas'],
            
            // Bebidas
            ['nombre' => 'Coca Cola 500ml', 'precio' => 2.50, 'stock' => 50, 'categoria' => 'Bebidas'],
            ['nombre' => 'Agua Mineral 500ml', 'precio' => 1.50, 'stock' => 60, 'categoria' => 'Bebidas'],
            ['nombre' => 'Jugo de Naranja', 'precio' => 3.00, 'stock' => 25, 'categoria' => 'Bebidas'],
            ['nombre' => 'Cerveza Artesanal', 'precio' => 4.00, 'stock' => 15, 'categoria' => 'Bebidas'],
            ['nombre' => 'Café Americano', 'precio' => 2.00, 'stock' => 30, 'categoria' => 'Bebidas'],
            
            // Postres
            ['nombre' => 'Helado de Vainilla', 'precio' => 3.50, 'stock' => 20, 'categoria' => 'Postres'],
            ['nombre' => 'Brownie con Helado', 'precio' => 5.50, 'stock' => 12, 'categoria' => 'Postres'],
            ['nombre' => 'Flan Casero', 'precio' => 4.00, 'stock' => 8, 'categoria' => 'Postres'],
            
            // Snacks
            ['nombre' => 'Nachos con Queso', 'precio' => 6.50, 'stock' => 18, 'categoria' => 'Snacks'],
            ['nombre' => 'Palomitas de Maíz', 'precio' => 3.00, 'stock' => 25, 'categoria' => 'Snacks'],
            ['nombre' => 'Papas Fritas Saborizadas', 'precio' => 2.50, 'stock' => 0, 'categoria' => 'Snacks'], // Stock 0 para probar
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
