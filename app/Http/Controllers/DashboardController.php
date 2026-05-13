<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Tenant;
use App\Http\Controllers\MaintenanceController;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUnits = 36;
        $activeRent = Tenant::where('status', 'Active')->count();
        $occupiedUnits = Tenant::where('status', 'Active')->count();
        $occupancyRate = $totalUnits ? round($occupiedUnits / $totalUnits * 100, 1) : 0;
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        $tickets = MaintenanceController::getTickets();
        $pendingRequests = count(array_filter($tickets, fn($t) => $t['status'] === 'NEW'));
        $inProgressRequests = count(array_filter($tickets, fn($t) => $t['status'] === 'IN PROGRESS'));
        $resolvedRequests = count(array_filter($tickets, fn($t) => $t['status'] === 'RESOLVED'));

        $newApplicants = Tenant::where('status', 'Pending')->count();

        $data = [
            'totalRevenue'      => $totalRevenue,
            'occupiedUnits'     => $occupiedUnits,
            'totalUnits'        => $totalUnits,
            'occupancyRate'     => $occupancyRate,
            'activeRent'        => $activeRent,
            'pendingRequests'   => $pendingRequests,
            'inProgressRequests'=> $inProgressRequests,
            'resolvedRequests'  => $resolvedRequests,
            'newApplicants'     => $newApplicants,

            'maintenanceItems' => $this->buildMaintenanceItems($tickets),

            'activityLog' => $this->buildActivityLog(),
        ];

        return view('dashboard.index', $data);
    }

    private function buildMaintenanceItems(array $tickets): array
    {
        $activeTickets = array_filter($tickets, fn($ticket) => $ticket['status'] !== 'RESOLVED');

        if (empty($activeTickets)) {
            return [
                [
                    'iconBg' => 'bg-green-100',
                    'title' => 'No active maintenance issues',
                    'priority' => 'All clear',
                    'meta' => 'Visit maintenance to create a report',
                ],
            ];
        }

        usort($activeTickets, function ($a, $b) {
            $priorityOrder = ['URGENT' => 1, 'NORMAL' => 2, 'MEDIUM' => 3];
            return ($priorityOrder[$a['priority']] ?? 99) <=> ($priorityOrder[$b['priority']] ?? 99);
        });

        return array_map(function ($ticket) {
            $priorityLabel = match ($ticket['priority']) {
                'URGENT' => 'Urgent',
                'MEDIUM' => 'Medium',
                default => 'Normal',
            };

            return [
                'iconBg' => $ticket['priority'] === 'URGENT' ? 'bg-red-100' : ($ticket['priority'] === 'MEDIUM' ? 'bg-yellow-50' : 'bg-gray-100'),
                'title' => $ticket['subject'],
                'priority' => $priorityLabel,
                'meta' => $ticket['location'] . ' · ' . $ticket['reported'],
            ];
        }, array_slice($activeTickets, 0, 3));
    }

    private function buildActivityLog(): array
    {
        $payments = Payment::with('tenant')
            ->orderByDesc('updated_at')
            ->limit(3)
            ->get();

        $activityLog = $payments->map(function (Payment $payment) {
            $unit = $payment->tenant->unit ?? 'N/A';
            $amount = '₱' . number_format($payment->amount, 2);

            if ($payment->status === 'paid') {
                $time = $payment->payment_date ? $payment->payment_date : $payment->updated_at;

                return [
                    'dotColor' => 'bg-green-500',
                    'title'    => 'Payment Received',
                    'desc'     => "{$amount} from Unit {$unit} · {$time->diffForHumans()}",
                ];
            }

            if ($payment->status === 'overdue') {
                return [
                    'dotColor' => 'bg-orange-400',
                    'title'    => 'Overdue Payment',
                    'desc'     => "Unit {$unit} overdue since {$payment->due_date->format('M d')} · {$amount}",
                ];
            }

            return [
                'dotColor' => 'bg-blue-400',
                'title'    => 'Upcoming Payment',
                'desc'     => "Unit {$unit} due on {$payment->due_date->format('M d')} · {$amount}",
            ];
        })->filter()->values()->all();

        if (empty($activityLog)) {
            return [
                [
                    'dotColor' => 'bg-gray-300',
                    'title'    => 'No recent activity yet',
                    'desc'     => 'Once payments or tenant actions happen, they will appear here.',
                ],
            ];
        }

        return $activityLog;
    }
}

