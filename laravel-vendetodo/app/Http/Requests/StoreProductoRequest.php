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
      'descripcion' => 'required',
      'precio' => 'required|numeric',
      'marca_id' => 'required|exists:marcas,id',
      'largo' => 'required|numeric',
      'alto' => 'required|numeric',
      'ancho' => 'required|numeric',
      'imagen_url' => '',
    ];
  }
}
