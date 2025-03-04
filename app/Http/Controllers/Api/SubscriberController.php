<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriber\StoreSubscriberRequest;
use App\Http\Requests\Subscriber\UpdateSubscriberRequest;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(): JsonResponse
    {
        $subscribers = Subscriber::paginate(10);
        
        return response()->json($subscribers, 200);
    }

    public function store(StoreSubscriberRequest $request): JsonResponse
    {
        $subscriber = Subscriber::create($request->validated());
        
        return response()->json($subscriber, 201);
    }

    public function show(Subscriber $subscriber): JsonResponse
    {
        return response()->json($subscriber, 200);
    }

    public function update(UpdateSubscriberRequest $request, Subscriber $subscriber): JsonResponse
    {
        $subscriber->update($request->validated());

        return response()->json($subscriber, 200);
    }

    public function destroy(Subscriber $subscriber): JsonResponse
    {
        $subscriber->delete();

        return response()->json([], 204);
    }
}
