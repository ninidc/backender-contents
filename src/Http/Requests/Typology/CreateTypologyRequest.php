<?php

namespace Backender\Contents\Http\Requests\Typology;

use Illuminate\Foundation\Http\FormRequest;

use Backender\Contents\Rules\TypologyFields;

class CreateTypologyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'fields' => ['required', new TypologyFields],
            'identifier' => 'required|unique:typologies',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
