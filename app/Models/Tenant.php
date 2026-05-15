<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'occupants',
        'email',
        'phone',
        'lease_start',
        'lease_end',
        'status',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'lease_start' => 'date',
        'lease_end' => 'date',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getLeaseMonths(): int
    {
        if (! $this->lease_start || ! $this->lease_end) {
            return 0;
        }

        return max(1, $this->lease_start->diffInMonths($this->lease_end) + 1);
    }

    public function getLeaseTotalAmount(): int
    {
        return $this->getLeaseMonths() * 3000;
    }

    public function getPaidAmount(): float
    {
        return (float) $this->payments()->where('status', 'paid')->sum('amount');
    }

    public function isPartiallyPaid(): bool
    {
        if (! $this->lease_start || ! $this->lease_end) {
            return false;
        }

        $totalLeaseAmount = $this->getLeaseTotalAmount();
        $paidAmount = $this->getPaidAmount();

        return $paidAmount > 0 && $paidAmount < $totalLeaseAmount;
    }
}
