<?php

namespace App\Http\Requests\Subscriber;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Field;
use App\Models\Subscriber as SubscriberModel;

class UpdateSubscriberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $states = [
            'active',
            'unsubscribed',
            'junk',
            'bounced',
            'unconfirmed',
        ];
        
        $types = [
            'date',
            'number',
            'string',
            'boolean',
            'link',
        ];
        
        return [
            'email' => [
                'sometimes',
                'max:255',
                'email:rfc,dns',
                'unique:subscribers,email,' . $this->route('subscriber')?->id,
            ],
            'name' => [
                'sometimes',
                'string',
                'min:3',
                'max:255',
            ],
            'state' => [
                'sometimes',
                'max:255',
                'in:' . implode(',', SubscriberModel::STATES),
            ],
            'fields' => [
                'sometimes',
                'array',
            ],
            'fields.*' => [
                'sometimes',
                'array',
            ],
            'fields.*.title' => [
                'sometimes',
                'string',
                'max:255',
            ],
            'fields.*.type' => [
                'sometimes',
                'string',
                'max:255',
                'in:' . implode(',', Field::TYPES),
            ],
            'fields.*.value' => [
                'sometimes',
            ],
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
