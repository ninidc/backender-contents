<?php

namespace Backender\Contents\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTagRequest extends FormRequest
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
