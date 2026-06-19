<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Categoria;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    protected $fillable = [
        'user_id',
        'tipo',
        'monto',
        'fecha',
        'categoria_id',
        'subcategoria_id'
    ];

    public $timestamps = false;

    // ✅ Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Relación con categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function subcategoria()
    {
    	return $this->belongsTo(Subcategoria::class);
    }


}
