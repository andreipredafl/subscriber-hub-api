<?php

namespace App\Http\Requests\SubscriberField;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpsertSubscriberFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'field_id' => [
                'required',
                'exists:fields,id'
            ],
            'value' => [
                'nullable',
                'string',
                'max:255'
            ],
        ];
    }
}
