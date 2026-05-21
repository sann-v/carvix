<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model {
    use HasFactory;

    protected $fillable = [
        'booking_id', 'stage_name', 'description', 'status', 'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}