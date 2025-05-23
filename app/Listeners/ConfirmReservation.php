<?php

namespace App\Listeners;

use App\Events\BookingNewEventEvent;
use App\Mail\EventDetailsMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ConfirmReservation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingNewEventEvent $event): void
    {
        Mail::to($event->user->email)->send(new EventDetailsMail($event->event, $event->user));
    }
}
