<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Movimiento;
use App\Models\Presupuesto;
use App\Models\MetaAhorro;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $userId = 4;

        if (Categoria::count() === 0) {
            $this->call(CategoriaSeeder::class);
        }

        $cat = fn($name) => Categoria::where('nombre', $name)->first()->id;
        $sub = fn($catName, $subName) => Subcategoria::whereHas('categoria', fn($q) => $q->where('nombre', $catName))
            ->where('nombre', $subName)->first()->id;

        DB::beginTransaction();

        // === 15 MOVEMENTS for June 2026 ===
        $movements = [
            // INGRESOS
            ['2026-06-02', 'ingreso', 350000.00, 'Sueldo mensual', 'Trabajo', 'Sueldo'],
            ['2026-06-05', 'ingreso', 25000.00, 'Proyecto freelance', 'Trabajo', 'Freelance'],
            ['2026-06-10', 'ingreso', 12000.00, 'Venta productos', 'Trabajo', 'Bonos'],
            ['2026-06-15', 'ingreso', 8000.00, 'Dividendos', 'Inversiones', 'Acciones'],
            ['2026-06-20', 'ingreso', 5000.00, 'Interés plazo fijo', 'Inversiones', 'Plazo fijo'],

            // EGRESOS
            ['2026-06-03', 'egreso', 80000.00, 'Alquiler departamento', 'Vivienda', 'Alquiler'],
            ['2026-06-04', 'egreso', 45000.00, 'Supermercado mensual', 'Alimentación', 'Supermercado'],
            ['2026-06-07', 'egreso', 12000.00, 'Factura electricidad', 'Vivienda', 'Electricidad'],
            ['2026-06-08', 'egreso', 8500.00, 'Internet Fibra', 'Servicios', 'Teléfono'],
            ['2026-06-12', 'egreso', 15000.00, 'Combustible', 'Transporte', 'Combustible'],
            ['2026-06-14', 'egreso', 5500.00, 'Farmacia', 'Salud', 'Farmacia'],
            ['2026-06-19', 'egreso', 5000.00, 'Cena y cine', 'Entretenimiento', 'Salidas'],

            // AHORROS
            ['2026-06-05', 'ahorro', 20000.00, 'Fondo de emergencia', null, null],
            ['2026-06-15', 'ahorro', 10000.00, 'Ahorro viaje', null, null],
            ['2026-06-20', 'ahorro', 15000.00, 'Inversión mensual', null, null],
        ];

        foreach ($movements as $m) {
            $data = [
                'user_id' => $userId,
                'fecha' => $m[0],
                'tipo' => $m[1],
                'monto' => $m[2],
                'descripcion' => $m[3],
                'moneda_id' => 1,
            ];

            if ($m[1] !== 'ahorro') {
                $data['categoria_id'] = $cat($m[4]);
                $data['subcategoria_id'] = $sub($m[4], $m[5]);
            }

            Movimiento::create($data);
        }

        // === 2 BUDGETS ===
        $presupuestos = [
            ['categoria_id' => $cat('Alimentación'), 'limite_mensual' => 60000.00],
            ['categoria_id' => $cat('Vivienda'), 'limite_mensual' => 100000.00],
        ];
        foreach ($presupuestos as $p) {
            Presupuesto::create([
                'user_id' => $userId,
                'categoria_id' => $p['categoria_id'],
                'limite_mensual' => $p['limite_mensual'],
                'mes' => now()->month,
                'año' => now()->year,
            ]);
        }

        // === 2 METAS ===
        $meta1 = MetaAhorro::create([
            'user_id' => $userId,
            'nombre' => 'Viaje a Europa',
            'monto_objetivo' => 500000.00,
            'monto_actual' => 10000.00,
            'fecha_limite' => '2026-12-31',
        ]);

        $meta2 = MetaAhorro::create([
            'user_id' => $userId,
            'nombre' => 'Fondo de Emergencia',
            'monto_objetivo' => 1000000.00,
            'monto_actual' => 20000.00,
            'fecha_limite' => '2027-06-30',
        ]);

        // Link ahorro movements to metas
        Movimiento::where('user_id', $userId)->where('descripcion', 'Ahorro viaje')->update(['meta_ahorro_id' => $meta1->id]);
        Movimiento::where('user_id', $userId)->where('descripcion', 'Fondo de emergencia')->update(['meta_ahorro_id' => $meta2->id]);

        DB::commit();

        $this->command->info("Test data created successfully!");

        $counts = [
            'movimientos' => Movimiento::where('user_id', $userId)->count(),
            'presupuestos' => Presupuesto::where('user_id', $userId)->count(),
            'metas_ahorro' => MetaAhorro::where('user_id', $userId)->count(),
        ];
        foreach ($counts as $table => $count) {
            $this->command->info("  $table: $count");
        }
    }
}
