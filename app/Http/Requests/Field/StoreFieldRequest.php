<?php

namespace App\Http\Requests\Field;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Field as FieldModel;
use Illuminate\Support\Facades\DB;

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
                function ($attribute, $value, $fail) {
                    $exists = DB::table('fields')
                        ->whereRaw('LOWER(title) = ?', [strtolower($value)])
                        ->exists();
                    
                    if ($exists) {
                        $fail('The ' . $attribute . ' is already registered.');
                    }
                }
            ],
            'type' => [
                'required',
                'in:' . implode(',', FieldModel::TYPES),
            ],
        ];
    }
}
