<?php

namespace Backender\Contents\Http\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class CreateLanguageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'iso' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
