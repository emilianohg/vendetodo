<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'nombre' => 'required',
      'descripcion' => '',
      'precio' => 'required|numeric',
      'marca_id' => 'required|exists:marcas,marca_id',
      'largo' => 'required|numeric',
      'alto' => 'required|numeric',
      'ancho' => 'required|numeric',
      'imagen' => 'mimes:jpg,png',
    ];
  }
}
