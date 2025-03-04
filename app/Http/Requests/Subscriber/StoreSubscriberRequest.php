<?php

namespace App\Http\Requests\Subscriber;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriberRequest extends FormRequest
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
                'in:' . implode(',', $states),
            ],
        ];
    }
}
