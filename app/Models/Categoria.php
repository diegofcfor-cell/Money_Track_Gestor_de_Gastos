<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = ['nombre'];

    public $timestamps = false;

    public function subcategorias()
    {
        return $this->hasMany(Subcategoria::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    public function presupuestos()
    {
        return $this->hasMany(Presupuesto::class);
    }
}
