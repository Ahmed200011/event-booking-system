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


/**
 * @OA\Schema(
 *     schema="EventResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Laravel Conference"),
 *     @OA\Property(property="date", type="string", format="date", example="2025-06-01"),
 * )
 */

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/events",
     *     summary="Get all events",
     *     tags={"Events"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="All events have been successfully shown",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="All events have been successfully shown"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/EventResource"))
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
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

    /**
 * @OA\Get(
 *     path="/api/events/{id}",
 *     summary="Get a single event",
 *     tags={"Events"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the event",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Event has been successfully shown",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="event has been successfully shown"),
 *             @OA\Property(property="data", ref="#/components/schemas/EventResource")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Event not found")
 * )
 */

    public function show(Event $event)
    {
        return ApiResponse::sendResponse(200, 'event has been successfully shown', new EventResource($event));
    }
}
