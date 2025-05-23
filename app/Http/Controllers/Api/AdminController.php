<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\EventResource;
use App\Models\Booking;
use App\Models\Event;

/**
* @OA\Schema(
*     schema="EventRequest",
*     type="object",
*     required={"event name", "description","category", "date", "location", "price", "status"},
*     @OA\Property(property="event name", type="string", example="Tech Meetup"),
*     @OA\Property(property="description", type="string", example="Meetup for developers."),
*     @OA\Property(property="category", type="string", example="cs."),
*     @OA\Property(property="date", type="string", format="date", example="2025-06-10"),
*     @OA\Property(property="location", type="string", example="cairo."),
*     @OA\Property(property="price", type="string", example="200"),
*     @OA\Property(property="status", type="string", example="0")
* )
*/
class AdminController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/admin/store/event",
     *     summary="Create a new event",
     *     tags={"Admin"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EventRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Event created successfully"
     *
     *     ),
     *    @OA\Response(
     *       response=422,
     *      description="Validation error",
     *     )
     * )
     */
    public function store(EventRequest $request)
    {
        $event_data = $request->validated();
        $event_data['status'] = $request->status ?? '0'; // Default to '0' if not provided
        if ($event_data) {
           $event= Event::create($event_data);
            return ApiResponse::sendResponse(201, 'Event created successfully', new EventResource($event));
        }
    }


    /**
     * @OA\Put(
     *     path="/api/admin/update/{id}/event",
     *     summary="Update an event",
     *     tags={"Admin"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the event to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EventRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event updated successfully"
     *     ),
     *    @OA\Response(
     *        response=404,
     *       description="Event not found"
     *    ),
     * )
     */


    public function update(EventRequest $request, $id)
    {
        if (!$id) {
            return ApiResponse::sendResponse(404, 'Event not found', []);
        }
        $event = Event::find($id);
        $event_data = $request->validated();
        if ($event_data) {
            $event->update($event_data);
            return ApiResponse::sendResponse(200, 'Event updated successfully', new EventResource($event));
        }
    }
     /**
     * @OA\Get(
     *     path="/api/admin/all/events'",
     *     summary="Get all events",
     *     tags={"Admin"},
     *     @OA\Response(
     *         response=200,
     *         description="All events retrieved successfully",
     *     )
     * )
     */

    public function allEvents(){
        $events = Event::all();
        return ApiResponse::sendResponse(200, 'All events have been successfully shown', EventResource::collection($events));
    }
    /**
     * @OA\Get(
     *     path="/api/admin/all/booking",
     *     summary="Get all bookings",
     *     tags={"Admin"},
     *     @OA\Response(
     *         response=200,
     *         description="All bookings retrieved successfully",
     *     )
     * )
     */
    public function allEventsBooked(){
        $events = Booking::with(['event','user'])->get();
        return ApiResponse::sendResponse(200, 'All booking have been successfully shown', BookingResource::collection($events));
    }

    /**
     * Remove the specified resource from storage.
     */

     /**
     * @OA\Delete(
     *     path="/api/admin/delete/{id}/event",
     *     summary="Delete an event",
     *     tags={"Admin"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the event to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *
     *     )
     * )
     */
    public function destroy($id)
    {
        if (!$id) {
            return ApiResponse::sendResponse(404, 'Event not found', []);
        }
        $event = Event::find($id);
        $event->delete();
        return ApiResponse::sendResponse(200, 'Event deleted successfully', []);
    }
}
