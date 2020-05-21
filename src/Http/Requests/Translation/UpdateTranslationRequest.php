<?php

namespace Backender\Contents\Http\Requests\Translation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationRequest extends FormRequest
{

  public function rules()
  {
      return [
          'name' => 'required',
          'fields.value.*' => 'required'
      ];
  }

  public function authorize()
  {
      return true;
  }
}
