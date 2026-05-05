<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

class MaintenanceController extends Controller
{
    // Static storage for demonstration (in production, use database)
    private static $ticketsStorage = null;

    private function getTicketsStorage()
    {
        if (self::$ticketsStorage === null) {
            self::$ticketsStorage = $this->getDefaultTickets();
        }
        return self::$ticketsStorage;
    }

    private function getDefaultTickets()
    {
        return [
            [
                'id'              => 1,
                'ref'             => '#MT-882',
                'subject'         => 'Air Conditioning Leak',
                'location'        => 'Unit 103',
                'assigned'        => false,
                'assignedInitials'=> '',
                'priority'        => 'URGENT',
                'status'          => 'NEW',
                'reported'        => '1h ago',
                'date'            => now()->format('Y-m-d'),
            ],
            [
                'id'              => 2,
                'ref'             => '#MT-878',
                'subject'         => 'Kitchen Tap Plumbing',
                'location'        => 'Unit 219',
                'assigned'        => true,
                'assignedInitials'=> 'LMF',
                'priority'        => 'URGENT',
                'status'          => 'IN PROGRESS',
                'reported'        => '4h ago',
                'date'            => now()->format('Y-m-d'),
            ],
            [
                'id'              => 3,
                'ref'             => '#MT-885',
                'subject'         => 'Gate Repair',
                'location'        => 'Main Entrance',
                'assigned'        => false,
                'assignedInitials'=> '',
                'priority'        => 'NORMAL',
                'status'          => 'NEW',
                'reported'        => '5h ago',
                'date'            => now()->format('Y-m-d'),
            ],
            [
                'id'              => 4,
                'ref'             => '#MT-895',
                'subject'         => 'Electrical Panel Upgrade',
                'location'        => 'Utility Room B',
                'assigned'        => true,
                'assignedInitials'=> 'LMF',
                'priority'        => 'MEDIUM',
                'status'          => 'IN PROGRESS',
                'reported'        => '1d ago',
                'date'            => now()->subDay()->format('Y-m-d'),
            ],
            [
                'id'              => 5,
                'ref'             => '#MT-897',
                'subject'         => 'Light Bulb Replacement',
                'location'        => '2nd Floor Hallway',
                'assigned'        => true,
                'assignedInitials'=> 'LMF',
                'priority'        => 'MEDIUM',
                'status'          => 'IN PROGRESS',
                'reported'        => '1d ago',
                'date'            => now()->subDay()->format('Y-m-d'),
            ],
        ];
    }

    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $tickets = $this->getTicketsStorage();

        // Calculate summary statistics
        $openTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'NEW'));
        $inProgressTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'IN PROGRESS'));
        $resolvedTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'RESOLVED'));
        $unassignedTickets = count(array_filter($tickets, fn($t) => !$t['assigned']));

        // Get calendar data
        $firstDay = new DateTime("$year-$month-01");
        $daysInMonth = $firstDay->format('t');
        $startingDayOfWeek = $firstDay->format('N'); // 1-7 (Monday-Sunday)
        
        $calendarDays = [];
        // Add empty cells for days before month starts
        for ($i = 1; $i < $startingDayOfWeek; $i++) {
            $calendarDays[] = null;
        }
        // Add days of month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $dayTickets = array_filter($tickets, fn($t) => $t['date'] === $date);
            $calendarDays[] = [
                'day' => $day,
                'date' => $date,
                'ticketCount' => count($dayTickets),
                'hasUrgent' => count(array_filter($dayTickets, fn($t) => $t['priority'] === 'URGENT')) > 0,
            ];
        }

        $currentMonth = $firstDay->format('F Y');
        $previousMonth = $firstDay->sub(new \DateInterval('P1M'));
        $nextMonth = (new DateTime("$year-$month-01"))->add(new \DateInterval('P1M'));

        return view('maintenance.index', [
            'tickets'           => $tickets,
            'openTickets'       => $openTickets,
            'inProgressTickets' => $inProgressTickets,
            'resolvedTickets'   => $resolvedTickets,
            'unassignedTickets' => $unassignedTickets,
            'currentMonth'      => $currentMonth,
            'calendarDays'      => $calendarDays,
            'month'             => $month,
            'year'              => $year,
            'previousMonth'     => $previousMonth->format('m'),
            'previousYear'      => $previousMonth->format('Y'),
            'nextMonth'         => $nextMonth->format('m'),
            'nextYear'          => $nextMonth->format('Y'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'priority' => 'required|in:URGENT,NORMAL,MEDIUM',
            'description' => 'nullable|string',
        ]);

        $tickets = $this->getTicketsStorage();
        
        // Generate new ID and reference number
        $newId = max(array_column($tickets, 'id')) + 1;
        $newRef = '#MT-' . str_pad($newId + 900, 3, '0', STR_PAD_LEFT);

        $newTicket = [
            'id'              => $newId,
            'ref'             => $newRef,
            'subject'         => $validated['subject'],
            'location'        => $validated['location'],
            'assigned'        => false,
            'assignedInitials'=> '',
            'priority'        => $validated['priority'],
            'status'          => 'NEW',
            'reported'        => 'just now',
            'date'            => now()->format('Y-m-d'),
        ];

        $tickets[] = $newTicket;
        self::$ticketsStorage = $tickets;

        return response()->json([
            'success' => true,
            'message' => 'Maintenance report created successfully!',
            'ticket' => $newTicket
        ]);
    }

    public function resolve($id, Request $request)
    {
        $tickets = $this->getTicketsStorage();
        
        foreach ($tickets as &$ticket) {
            if ($ticket['id'] == $id) {
                $ticket['status'] = 'RESOLVED';
                self::$ticketsStorage = $tickets;
                
                return response()->json([
                    'success' => true,
                    'message' => 'Issue marked as resolved!',
                    'ticket' => $ticket
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Ticket not found!'
        ], 404);
    }

    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:NEW,IN PROGRESS,RESOLVED',
        ]);

        $tickets = $this->getTicketsStorage();
        
        foreach ($tickets as &$ticket) {
            if ($ticket['id'] == $id) {
                $ticket['status'] = $validated['status'];
                self::$ticketsStorage = $tickets;
                
                return response()->json([
                    'success' => true,
                    'message' => 'Status updated successfully!',
                    'ticket' => $ticket
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Ticket not found!'
        ], 404);
    }
}
