<?php

namespace Backender\Contents\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

use Backender\Contents\Rules\ContentField;
use Backender\Contents\Rules\PageField;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateContentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(request('is_page')) {
            return [
                'status' => 'required',
                'fields' => ['required', new PageField]
            ];
        }

        return [
            'status' => 'required',
            'typology_id' => 'required',
            'fields' => ['required', new ContentField]
        ];
    }


    protected function failedValidation(Validator $validator)
     {
         $errors = (new ValidationException($validator))->errors();

         throw new HttpResponseException(response()->json([
           'errors' => $errors,
           'message' => trans('architect::rules.error')
         ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
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
