<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceReport extends Model
{
    protected $fillable = [
        'ref',
        'subject',
        'location',
        'assigned',
        'assigned_name',
        'assigned_initials',
        'priority',
        'status',
        'report_date',
        'description',
    ];

    protected $casts = [
        'assigned' => 'boolean',
        'report_date' => 'date',
    ];

    protected $appends = ['reported', 'date', 'assignedInitials', 'assignedName'];

    public function getReportedAttribute(): string
    {
        return $this->report_date ? $this->report_date->format('M d, Y') : '';
    }

    public function getDateAttribute(): ?string
    {
        return $this->report_date ? $this->report_date->format('Y-m-d') : null;
    }

    public function getAssignedInitialsAttribute(): ?string
    {
        return $this->attributes['assigned_initials'] ?? null;
    }

    public function getAssignedNameAttribute(): ?string
    {
        return $this->attributes['assigned_name'] ?? null;
    }
}
