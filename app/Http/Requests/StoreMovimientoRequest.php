<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo'            => 'required|in:ingreso,egreso',
            'monto'           => 'required|numeric|min:0.01',
            'fecha'           => 'required|date',
            'categoria_id'    => 'required|exists:categorias,id',
            'subcategoria_id' => 'nullable|exists:subcategorias,id',
        ];
    }
}
