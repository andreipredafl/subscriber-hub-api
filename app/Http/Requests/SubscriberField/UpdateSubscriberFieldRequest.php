<?php

namespace App\Http\Requests\SubscriberField;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Subscriber;
use App\Models\Field;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateSubscriberFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        $subscriber = $this->route('subscriber');
        $field = $this->route('field');
        
        if (!$subscriber || !$field) {
            return false;
        }
        
        return $subscriber->fields()->where('field_id', $field->id)->exists();
    }

    public function rules(): array
    {
        return [
            'value' => [
                'nullable',
                'string',
                'max:255'
            ],
        ];
    }
    
    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'This field has not been assigned to the subscriber yet.'
            ], 403)
        );
    }
    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => $validator->errors()->first()
            ], 422)
        );
    }
}
