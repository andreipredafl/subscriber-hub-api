<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriber\StoreSubscriberRequest;
use App\Http\Requests\Subscriber\UpdateSubscriberRequest;
use App\Models\Subscriber;
use App\Models\Field;
use Illuminate\Http\JsonResponse;

class SubscriberController extends Controller
{
    public function index(): JsonResponse
    {
        $subscribers = Subscriber::orderBy('created_at', 'desc')->paginate(10);
        return response()->json($subscribers, 200);
    }

    public function store(StoreSubscriberRequest $request)
    {
        $validatedData = $request->validated();
        $fields = $request->input('fields', []);
        
        $subscriber = Subscriber::create($validatedData);
        
        $validFieldIds = Field::pluck('id')->toArray();
        
        foreach ($fields as $fieldId => $fieldData) {
            $fieldId = (int)$fieldId;
            if (in_array($fieldId, $validFieldIds) && isset($fieldData['value']) && !empty($fieldData['value'])) {
                $subscriber->fields()->attach($fieldId, [
                    'value' => $fieldData['value']
                ]);
            }
        }
        
        return response()->json($subscriber->fresh(['fields']), 201);
    }

    public function show(Subscriber $subscriber): JsonResponse
    {
        $subscriber->load('fields');
        return response()->json($subscriber, 200);
    }

    public function update(UpdateSubscriberRequest $request, Subscriber $subscriber): JsonResponse
    {
        $validatedData = $request->validated();
        $fields = $request->input('fields', []);
        
        $subscriber->update($validatedData);
        
        $existingFields = $subscriber->fields()->pluck('field_id')->toArray();
        $validFieldIds = Field::pluck('id')->toArray();
        $submittedFieldIds = [];
        
        foreach ($fields as $fieldId => $fieldData) {
            $fieldId = (int)$fieldId;
            
            if (in_array($fieldId, $validFieldIds) && isset($fieldData['value']) && !empty($fieldData['value'])) {
                $submittedFieldIds[] = $fieldId;
                
                if (in_array($fieldId, $existingFields)) {
                    $subscriber->fields()->updateExistingPivot($fieldId, [
                        'value' => $fieldData['value']
                    ]);
                } else {
                    $subscriber->fields()->attach($fieldId, [
                        'value' => $fieldData['value']
                    ]);
                }
            }
        }
        
        $fieldsToDetach = array_diff($existingFields, $submittedFieldIds);
        if (!empty($fieldsToDetach)) {
            $subscriber->fields()->detach($fieldsToDetach);
        }
        
        $subscriber->load('fields');
        
        return response()->json($subscriber, 200);
    }

    public function destroy(Subscriber $subscriber): JsonResponse
    {
        $subscriber->delete();
        return response()->json([], 204);
    }
}
