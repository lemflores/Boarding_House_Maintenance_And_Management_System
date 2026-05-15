<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceReport;
use App\Models\Tenant;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MaintenanceController extends Controller
{
    public static function getTickets(): array
    {
        return MaintenanceReport::orderBy('id')->get()->toArray();
    }

    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $tickets = self::getTickets();
        $activeTickets = array_values(array_filter($tickets, fn($t) => $t['status'] !== 'RESOLVED'));
        $page = LengthAwarePaginator::resolveCurrentPage();
        $ticketPaginator = new LengthAwarePaginator(
            array_slice($activeTickets, ($page - 1) * 5, 5),
            count($activeTickets),
            5,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
        // Calculate summary statistics (all tickets)
        $openTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'NEW'));
        $inProgressTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'IN PROGRESS'));
        $resolvedTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'RESOLVED'));
        $unassignedTickets = count(array_filter($tickets, fn($t) => !$t['assigned']));

        // Get calendar data - exclude RESOLVED tickets
        $activeTickets = array_filter($tickets, fn($t) => $t['status'] !== 'RESOLVED');
        
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
            $dayTickets = array_filter($activeTickets, fn($t) => $t['date'] === $date);
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
            'ticketPaginator'   => $ticketPaginator,
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

        $ticket = MaintenanceReport::create([
            'ref'              => '',
            'subject'         => $validated['subject'],
            'location'        => $validated['location'],
            'assigned'        => false,
            'assigned_name'   => '',
            'assigned_initials'=> '',
            'priority'        => $validated['priority'],
            'status'          => 'NEW',
            'report_date'     => $validated['report_date'],
            'description'     => $validated['description'] ?? null,
        ]);

        $ticket->ref = '#MT-' . str_pad($ticket->id + 900, 3, '0', STR_PAD_LEFT);
        $ticket->save();

        return response()->json([
            'success' => true,
            'message' => 'Maintenance report created successfully!',
            'ticket' => $ticket->toArray(),
        ]);
    }

    public function resolve($id, Request $request)
    {
        $ticket = MaintenanceReport::find($id);

        if (! $ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found!'
            ], 404);
        }

        $ticket->status = 'RESOLVED';
        $ticket->save();

        return response()->json([
            'success' => true,
            'message' => 'Issue marked as resolved!',
            'ticket' => $ticket->toArray()
        ]);
    }

    public function assignTechnician($id, Request $request)
    {
        $validated = $request->validate([
            'technician' => 'required|string|max:255',
        ]);

        $ticket = MaintenanceReport::find($id);

        if (! $ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found!'
            ], 404);
        }

        $ticket->assigned = true;
        $ticket->assigned_name = $validated['technician'];
        $ticket->assigned_initials = $this->generateInitials($validated['technician']);
        if ($ticket->status === 'NEW') {
            $ticket->status = 'IN PROGRESS';
        }

        $ticket->save();

        return response()->json([
            'success' => true,
            'message' => 'Technician assigned successfully!',
            'ticket' => $ticket->toArray()
        ]);
    }

    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:NEW,IN PROGRESS,RESOLVED',
        ]);

        $ticket = MaintenanceReport::find($id);

        if (! $ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found!'
            ], 404);
        }

        $ticket->status = $validated['status'];
        $ticket->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'ticket' => $ticket->toArray()
        ]);
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
