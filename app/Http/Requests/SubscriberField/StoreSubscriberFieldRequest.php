<?php

namespace App\Http\Requests\SubscriberField;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Subscriber;
use App\Models\Field;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSubscriberFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        $subscriber = $this->route('subscriber');
        if (!$subscriber) {
            return false;
        }
        
        $fieldId = $this->input('field_id');
        if (!$fieldId) {
            return true;
        }
        
        $field = Field::find($fieldId);
        
        return $field && !$subscriber->fields()->where('field_id', $field->id)->exists();
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
    
    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'This field has already been assigned to the subscriber or does not exist.'
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
