<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    use HasFactory;

        protected $fillable = [
        'booking_code',
        'vehicle_id',
        'service_type',
        'complaint',
        'service_date',
        'status',
        'progress',
        'specialist',
        'handled_by',
        'admin_notes',
        'estimated_finish',
        'service_cost',
    ];

    protected $casts = [
        'service_date' => 'date',
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function services() {
        return $this->hasMany(Service::class);
    }

    public function invoice() {
        return $this->hasOne(Invoice::class);
    }

    public function getStatusBadgeAttribute(): string {
        return match($this->status) {
            'pending'     => 'badge-warning',
            'confirmed'   => 'badge-info',
            'in_progress' => 'badge-primary',
            'completed'   => 'badge-success',
            'cancelled'   => 'badge-danger',
            default       => 'badge-secondary',
        };
    }
}