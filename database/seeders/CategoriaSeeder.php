<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Subcategoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Alimentación' => ['Supermercado', 'Restaurantes', 'Delivery', 'Cafetería'],
            'Transporte' => ['Combustible', 'Uber/Taxi', 'Transporte público', 'Estacionamiento'],
            'Vivienda' => ['Alquiler', 'Electricidad', 'Agua', 'Internet', 'Gas'],
            'Salud' => ['Farmacia', 'Médico', 'Seguro', 'Gimnasio'],
            'Entretenimiento' => ['Cine', 'Streaming', 'Videojuegos', 'Salidas'],
            'Educación' => ['Cursos', 'Libros', 'Suscripciones'],
            'Servicios' => ['Teléfono', 'Seguros', 'Suscripciones'],
            'Trabajo' => ['Sueldo', 'Freelance', 'Bonos'],
            'Inversiones' => ['Acciones', 'Cripto', 'Plazo fijo', 'Fondos'],
            'Otros' => ['Regalos', 'Ropa', 'Impuestos', 'Varios'],
        ];

        foreach ($categorias as $nombre => $subs) {
            $categoria = Categoria::create(['nombre' => $nombre]);

            foreach ($subs as $sub) {
                Subcategoria::create([
                    'nombre' => $sub,
                    'categoria_id' => $categoria->id,
                ]);
            }
        }
    }
}
