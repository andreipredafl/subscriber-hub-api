<?php

namespace App\Http\Requests\Subscriber;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Field as FieldModel;
use App\Models\Subscriber as SubscriberModel;

class StoreSubscriberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:subscribers,email',
                'max:255',
            ],
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'state' => [
                'required',
                'max:255',
                'in:' . implode(',', SubscriberModel::STATES),
            ],
            'fields' => [
                'sometimes',
                'array'
            ],
            'fields.*' => [
                'sometimes',
                'array'
            ],
            'fields.*.title' => [
                'sometimes',
                'string',
                'max:255',
                'exists:fields,title'
            ],
            'fields.*.type' => [
                'sometimes',
                'string',
                'max:255',
                'in:' . implode(',', FieldModel::TYPES)
            ],
            'fields.*.value' => [
                'sometimes'
            ]
        ];
    }
    
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();
        
        if (isset($validated['fields'])) {
            unset($validated['fields']);
        }
        
        return $validated;
    }
}
