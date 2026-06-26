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
            'tipo'            => 'required|in:ingreso,egreso,ahorro',
            'monto'           => 'required|numeric|min:0.01',
            'fecha'           => 'required|date',
            'categoria_id'    => 'nullable|required_unless:tipo,ahorro|exists:categorias,id',
            'subcategoria_id' => 'nullable|exists:subcategorias,id',
            'meta_ahorro_id'  => 'required_if:tipo,ahorro|exists:metas_ahorro,id',
        ];
    }
}
