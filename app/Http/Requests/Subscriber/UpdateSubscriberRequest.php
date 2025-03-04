<?php

namespace App\Http\Requests\Subscriber;

use Illuminate\Foundation\Http\FormRequest;

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
                'in:' . implode(',', $states),
            ],
        ];
    }
}
