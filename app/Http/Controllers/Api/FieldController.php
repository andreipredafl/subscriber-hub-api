<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Field\StoreFieldRequest;
use App\Http\Requests\Field\UpdateFieldRequest;
use App\Models\Field;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index(): JsonResponse
    {
        $perPage = request()->get('per_page');
        
        if ($perPage) {
            $fields = Field::orderBy('created_at', 'desc')->paginate($perPage);
        } else {
            $fields = Field::orderBy('created_at', 'desc')->get();
        }
        
        return response()->json($fields, 200);
    }

    public function store(StoreFieldRequest $request): JsonResponse
    {
        $field = Field::create($request->validated());
        
        return response()->json($field, 201);
    }

    public function show(Field $field): JsonResponse
    {
        return response()->json($field, 200);
    }

    public function update(UpdateFieldRequest $request, Field $field): JsonResponse
    {
        $field->update($request->validated());

        return response()->json($field, 200);
    }

    public function destroy(Field $field): JsonResponse
    {
        $field->delete();

        return response()->json([], 204);
    }
}
