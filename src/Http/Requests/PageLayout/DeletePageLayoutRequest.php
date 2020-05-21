<?php

namespace Backender\Contents\Http\Requests\PageLayout;

use Illuminate\Foundation\Http\FormRequest;

class DeletePageLayoutRequest extends FormRequest
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
