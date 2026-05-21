<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'booking_id', 'subtotal',
        'tax', 'total', 'payment_status',
        'issue_date', 'due_date', 'items', 'paid_at',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date'   => 'date',
        'paid_at'    => 'datetime',
        'items'      => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isOverdue(): bool
    {
        return $this->payment_status === 'unpaid'
            && $this->due_date->isPast();
    }

    public function getPaymentBadgeAttribute(): string
    {
        return match ($this->payment_status) {
            'paid'      => 'badge-success',
            'cancelled' => 'badge-danger',
            default     => 'badge-warning',
        };
    }
}