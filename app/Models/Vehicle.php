<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'owner_name', 'email', 'phone', 'brand',
        'model', 'year', 'license_plate', 'vin', 'color', 'mileage'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function latestBooking()
    {
        return $this->hasOne(Booking::class)->latestOfMany();
    }
}