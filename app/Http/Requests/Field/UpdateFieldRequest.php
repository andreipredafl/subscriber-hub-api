<?php

namespace App\Http\Requests\Field;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Field;

class UpdateFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'sometimes',
                'string',
                'unique:fields,title,' . $this->route('field')?->id,
            ],
            'type' => [
                'sometimes',
                Rule::in(Field::TYPES)
            ],
        ];
    }
}
