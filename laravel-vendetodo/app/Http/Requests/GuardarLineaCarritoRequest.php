<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarLineaCarritoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'producto_id' => 'required|exists:productos,producto_id',
            'proveedor_id' => 'required|exists:proveedores,proveedor_id',
            'cantidad' => 'required|numeric',
        ];
    }
}
