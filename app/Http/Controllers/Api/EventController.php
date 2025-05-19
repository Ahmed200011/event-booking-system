<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        // $user = Auth::user();
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        // dd(Auth::user());
        return ApiResponse::sendResponse(200, 'All events have been successfully shown', EventResource::collection($events));
    }
    public function show(Event $event)
    {
        return ApiResponse::sendResponse(200, 'event has been successfully shown', new EventResource($event));
    }
  
}
