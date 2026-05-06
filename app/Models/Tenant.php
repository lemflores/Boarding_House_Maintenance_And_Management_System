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
}
