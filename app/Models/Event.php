<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    use HasFactory;
    protected $guarded = [];


    public function bookings()
    {
        return $this->hasMany(Booking::class, 'event_id', 'id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'bookings', 'event_id', 'user_id');
    }
   
}
