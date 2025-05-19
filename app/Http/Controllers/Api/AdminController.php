<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\EventResource;
use App\Models\Booking;
use App\Models\Event;

class AdminController extends Controller
{
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
     * Update the specified resource in storage.
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
    public function allEvents(){
        $events = Event::all();
        return ApiResponse::sendResponse(200, 'All events have been successfully shown', EventResource::collection($events));
    }
    public function allEventsBooked(){
        $events = Booking::with(['event','user'])->get();
        return ApiResponse::sendResponse(200, 'All booking have been successfully shown', BookingResource::collection($events));
    }

    /**
     * Remove the specified resource from storage.
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
