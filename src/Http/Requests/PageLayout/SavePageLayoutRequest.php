<?php

namespace Backender\Contents\Http\Requests\PageLayout;

use Illuminate\Foundation\Http\FormRequest;

class SavePageLayoutRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'definition' => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
