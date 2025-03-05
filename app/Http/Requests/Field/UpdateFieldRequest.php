<?php

namespace App\Http\Requests\Field;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Field as FeldModel;

class UpdateFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $fieldId = $this->route('field')?->id;
        
        return [
            'title' => [
                'sometimes',
                'string',
                function ($attribute, $value, $fail) use ($fieldId) {
                    $exists = DB::table('fields')
                        ->whereRaw('LOWER(title) = ?', [strtolower($value)])
                        ->when($fieldId, function ($query) use ($fieldId) {
                            $query->where('id', '!=', $fieldId);
                        })
                        ->exists();
                    
                    if ($exists) {
                        $fail('The ' . $attribute . ' is already registered.');
                    }
                }
            ],
            'type' => [
                'sometimes',
                'in:' . implode(',', FeldModel::TYPES),
            ],
        ];
    }
}
