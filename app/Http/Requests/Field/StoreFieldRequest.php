<?php

namespace App\Http\Requests\Field;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Field;

class StoreFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                'unique:fields,title'
            ],
            'type' => [
                'required',
                Rule::in(Field::TYPES)
            ],
        ];
    }
}
