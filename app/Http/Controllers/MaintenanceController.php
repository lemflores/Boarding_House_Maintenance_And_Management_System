<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $tickets = [
            [
                'ref'             => '#MT-882',
                'subject'         => 'Air Conditioning Leak',
                'location'        => 'Unit 103',
                'assigned'        => false,
                'assignedInitials'=> '',
                'priority'        => 'URGENT',
                'status'          => 'NEW',
                'reported'        => '1h ago',
            ],
            [
                'ref'             => '#MT-878',
                'subject'         => 'Kitchen Tap Plumbing',
                'location'        => 'Unit 219',
                'assigned'        => true,
                'assignedInitials'=> 'LMF',
                'priority'        => 'URGENT',
                'status'          => 'IN PROGRESS',
                'reported'        => '4h ago',
            ],
            [
                'ref'             => '#MT-885',
                'subject'         => 'Gate Repair',
                'location'        => 'Main Entrance',
                'assigned'        => false,
                'assignedInitials'=> '',
                'priority'        => 'NORMAL',
                'status'          => 'NEW',
                'reported'        => '5h ago',
            ],
            [
                'ref'             => '#MT-895',
                'subject'         => 'Electrical Panel Upgrade',
                'location'        => 'Utility Room B',
                'assigned'        => true,
                'assignedInitials'=> 'LMF',
                'priority'        => 'MEDIUM',
                'status'          => 'IN PROGRESS',
                'reported'        => '1d ago',
            ],
            [
                'ref'             => '#MT-897',
                'subject'         => 'Light Bulb Replacement',
                'location'        => '2nd Floor Hallway',
                'assigned'        => true,
                'assignedInitials'=> 'LMF',
                'priority'        => 'MEDIUM',
                'status'          => 'IN PROGRESS',
                'reported'        => '1d ago',
            ],
        ];

        return view('maintenance.index', [
            'tickets'           => $tickets,
            'openTickets'       => 2,
            'inProgressTickets' => 3,
            'resolvedTickets'   => 8,
            'unassignedTickets' => 2,
        ]);
    }
}
