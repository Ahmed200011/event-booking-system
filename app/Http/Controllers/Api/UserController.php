<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\UserResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);
        if (!$request->user()) {
            return ApiResponse::sendResponse(401, 'Unauthorized', []);
        }
        if (!$request->event_id) {
            return ApiResponse::sendResponse(404, 'Event not found', []);
        }

        $user = $request->user();
        if ($user->events()->where('event_id', $request->event_id)->exists()) {
            return response()->json(['message' => 'You already booked this event.'], 409);
        }
        // $user->events()->attach($request->event_id);
        $booking = Booking::create([
            'event_id' => $request->event_id,
            'user_id' => $user->id,
        ]);
        return ApiResponse::sendResponse(201, 'Event booked successfully!', new BookingResource($booking));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $event = $user->events()->where('event_id', $id)->first();
        if (!$event) {
            return ApiResponse::sendResponse(404, 'Booking not found for this event..', []);
        }
        $user->events()->detach($id);
        return ApiResponse::sendResponse(201, 'Booking canceled successfully.', []);
    }
    public function userEvents(Request $request)
    {
        $user = $request->user();
        // $user = Auth::user();
        $events = $user->events()->get();
        if ($events->isEmpty()) {
            return ApiResponse::sendResponse(404, 'No events found for this user', []);
        }
        return ApiResponse::sendResponse(
            200,
            'User events fetched successfully',
            EventResource::collection($events)
        );
    }
}
