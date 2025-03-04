<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberField\StoreSubscriberFieldRequest;
use App\Http\Requests\SubscriberField\UpdateSubscriberFieldRequest;
use App\Http\Requests\SubscriberField\UpsertSubscriberFieldRequest;
use App\Models\Subscriber;
use App\Models\Field;
use Illuminate\Http\JsonResponse;

class SubscriberFieldController extends Controller
{

    public function upsert(UpsertSubscriberFieldRequest $request, Subscriber $subscriber): JsonResponse
    {
        $validated = $request->validated();
        
        $fieldId = $validated['field_id'];
        $value = $validated['value'] ?? null;
        
        $exists = $subscriber->fields()->where('field_id', $fieldId)->exists();
        
        if ($exists) {

            $subscriber->fields()->updateExistingPivot($fieldId, ['value' => $value]);
            return response()->json([
                'message' => 'Field value updated successfully.'
            ], 200);
        } else {
            
            $subscriber->fields()->attach($fieldId, ['value' => $value]);
            return response()->json([
                'message' => 'Field assigned to subscriber successfully.'
            ], 201);
        }
    }

    public function destroy(Subscriber $subscriber, Field $field): JsonResponse
    {
        if (!$subscriber->fields()->where('field_id', $field->id)->exists()) {
            return response()->json([
                'message' => 'This field is not associated with the subscriber.'
            ], 404);
        }
        
        $subscriber->fields()->detach($field->id);

        return response()->json([], 204);
    }
}
