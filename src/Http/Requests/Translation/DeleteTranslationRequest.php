<?php

namespace Backender\Contents\Http\Requests\Translation;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTranslationRequest extends FormRequest
{

    public function rules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }
}
