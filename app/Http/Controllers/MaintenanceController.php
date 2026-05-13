<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    // Static storage for demonstration (in production, use database)
    private static $ticketsStorage = null;

    public static function getTickets()
    {
        return session()->get('maintenance_tickets', (new self)->getDefaultTickets());
    }

    private function getTicketsStorage()
    {
        return session()->get('maintenance_tickets', $this->getDefaultTickets());
    }

    private function saveTickets(array $tickets): void
    {
        session()->put('maintenance_tickets', $tickets);
        self::$ticketsStorage = $tickets;
    }

    private function getDefaultTickets()
    {
        return [
            [
                'id' => 1,
                'ref' => '#MT-901',
                'subject' => 'Air conditioning leak in Room 103',
                'location' => 'Unit 103',
                'assigned' => false,
                'assignedName' => '',
                'assignedInitials' => '',
                'priority' => 'URGENT',
                'status' => 'NEW',
                'reported' => Carbon::now()->subMinutes(45)->format('M d, Y'),
                'date' => Carbon::now()->format('Y-m-d'),
            ],
            [
                'id' => 2,
                'ref' => '#MT-902',
                'subject' => 'Kitchen tap plumbing issue',
                'location' => 'Unit 219',
                'assigned' => true,
                'assignedName' => 'Carlo',
                'assignedInitials' => 'C',
                'priority' => 'NORMAL',
                'status' => 'IN PROGRESS',
                'reported' => Carbon::now()->subHours(3)->format('M d, Y'),
                'date' => Carbon::now()->format('Y-m-d'),
            ],
            [
                'id' => 3,
                'ref' => '#MT-903',
                'subject' => 'Hallway light bulb replacement',
                'location' => '2nd Floor Hallway',
                'assigned' => true,
                'assignedName' => 'Bella',
                'assignedInitials' => 'B',
                'priority' => 'MEDIUM',
                'status' => 'RESOLVED',
                'reported' => Carbon::now()->subDays(1)->format('M d, Y'),
                'date' => Carbon::now()->subDays(1)->format('Y-m-d'),
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
            'units'             => $this->getAllRoomUnits(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'priority' => 'required|in:URGENT,NORMAL,MEDIUM',
            'report_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $tickets = $this->getTicketsStorage();
        
        // Generate new ID and reference number
        $newId = $tickets ? max(array_column($tickets, 'id')) + 1 : 1;
        $newRef = '#MT-' . str_pad($newId + 900, 3, '0', STR_PAD_LEFT);

        $reportedDate = Carbon::parse($validated['report_date'])->format('M d, Y');

        $newTicket = [
            'id'              => $newId,
            'ref'             => $newRef,
            'subject'         => $validated['subject'],
            'location'        => $validated['location'],
            'assigned'        => false,
            'assignedName'    => '',
            'assignedInitials'=> '',
            'priority'        => $validated['priority'],
            'status'          => 'NEW',
            'reported'        => $reportedDate,
            'date'            => $validated['report_date'],
        ];

        $tickets[] = $newTicket;
        $this->saveTickets($tickets);

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
                $this->saveTickets($tickets);
                
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

    public function assignTechnician($id, Request $request)
    {
        $validated = $request->validate([
            'technician' => 'required|string|max:255',
        ]);

        $tickets = $this->getTicketsStorage();

        foreach ($tickets as &$ticket) {
            if ($ticket['id'] == $id) {
                $ticket['assigned'] = true;
                $ticket['assignedName'] = $validated['technician'];
                $ticket['assignedInitials'] = $this->generateInitials($validated['technician']);
                if ($ticket['status'] === 'NEW') {
                    $ticket['status'] = 'IN PROGRESS';
                }

                $this->saveTickets($tickets);

                return response()->json([
                    'success' => true,
                    'message' => 'Technician assigned successfully!',
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
                $this->saveTickets($tickets);
                
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

    private function getAllRoomUnits(): array
    {
        $roomsByFloor = [
            1 => ['101', '102', '103', '104', '105', '106', '107', '108', '109', '110', '111', '112'],
            2 => ['201', '202', '203', '204', '205', '206', '207', '208', '209', '210', '211', '212'],
            3 => ['301', '302', '303', '304', '305', '306', '307', '308', '309', '310', '311', '312'],
        ];

        $occupiedUnits = Tenant::whereNotNull('unit')
            ->pluck('unit')
            ->map(fn ($unit) => $this->normalizeRoomNumber($unit))
            ->filter()
            ->toArray();

        return array_map(function ($unit) use ($occupiedUnits) {
            return [
                'number' => $unit,
                'occupied' => in_array($unit, $occupiedUnits),
            ];
        }, array_merge(...array_values($roomsByFloor)));
    }

    private function normalizeRoomNumber(string $unit): ?string
    {
        if (preg_match('/\d+/', trim($unit), $matches)) {
            return $matches[0];
        }

        return null;
    }

    private function generateInitials(string $name): string
    {
        return collect(explode(' ', trim($name)))
            ->filter()
            ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
            ->take(2)
            ->join('');
    }
}
