<?php

namespace App\Http\Controllers\Api;

use App\Events\BookingNewEventEvent;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Resources\EventResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/**
 * @OA\Schema(
 *     schema="BookingResource",
 *     type="object",
 *     title="Booking Resource",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="event_id", type="integer", example=10),
 *         @OA\Property(property="user_id", type="integer", example=5),
 *         @OA\Property(property="created_at", type="string", format="date-time"),
 *         @OA\Property(property="updated_at", type="string", format="date-time")
 *     }
 * )
 */


class UserController extends Controller
{

    /**
 * @OA\Post(
 *     path="/api/user/bookEvent",
 *     summary="Book an event (User)",
 *     tags={"User"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"event_id"},
 *             @OA\Property(property="event_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Event booked successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=201),
 *             @OA\Property(property="message", type="string", example="Event booked successfully!"),
 *             @OA\Property(property="data", ref="#/components/schemas/BookingResource")
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthorized"),
 *     @OA\Response(response=404, description="Event not found"),
 *     @OA\Response(response=409, description="You already booked this event")
 * )
 */


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
        event(new BookingNewEventEvent($booking->event, $user));

        return ApiResponse::sendResponse(201, 'Event booked successfully!', new BookingResource($booking));
    }
    /**
     * Remove the specified resource from storage.
     */

     /**
 * @OA\Delete(
 *     path="/api/user/delete/{id}/event",
 *     summary="Cancel a booking for an event",
 *     tags={"User"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the event to cancel booking",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Booking canceled successfully.",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=201),
 *             @OA\Property(property="message", type="string", example="Booking canceled successfully."),
 *             @OA\Property(property="data", type="array", @OA\Items())
 *         )
 *     ),
 *     @OA\Response(response=404, description="Booking not found for this event.")
 * )
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

    /**
 * @OA\Post(
 *     path="/api/user/events",
 *     summary="Get all events booked by authenticated user",
 *     tags={"User"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="User events fetched successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="User events fetched successfully"),
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/EventResource"))
 *         )
 *     ),
 *     @OA\Response(response=404, description="No events found for this user")
 * )
 */

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
