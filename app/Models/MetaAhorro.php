<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaAhorro extends Model
{
    protected $table = 'metas_ahorro';

    protected $fillable = [
        'user_id',
        'nombre',
        'monto_objetivo',
        'monto_actual',
        'fecha_limite',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
