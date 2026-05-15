<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Tenant;
use App\Http\Controllers\MaintenanceController;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUnits = 36;
        $activeRent = Tenant::where('status', 'Active')->count();
        $occupiedUnits = Tenant::count();
        $occupancyRate = $totalUnits ? round($occupiedUnits / $totalUnits * 100, 1) : 0;
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        $tickets = MaintenanceController::getTickets();
        $pendingRequests = count(array_filter($tickets, fn($t) => $t['status'] === 'NEW'));
        $inProgressRequests = count(array_filter($tickets, fn($t) => $t['status'] === 'IN PROGRESS'));
        $resolvedRequests = count(array_filter($tickets, fn($t) => $t['status'] === 'RESOLVED'));

        $newApplicants = Tenant::where('status', 'Pending')->count();

        // Get expired and almost expired tenants
        $now = Carbon::today();
        $expiredTenants = Tenant::where('lease_end', '<', $now)->get();
        $almostExpiredTenants = Tenant::whereBetween('lease_end', [$now, $now->copy()->addDays(7)])->get();

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
            'expiredTenants' => $expiredTenants,
            'almostExpiredTenants' => $almostExpiredTenants,
        ];

        return view('dashboard.index', $data);
    }

    public function clearActivityLog(Request $request)
    {
        // Set a session flag to indicate activity log should be cleared
        session(['activity_log_cleared' => true]);
        return redirect()->route('dashboard')->with('activity_cleared', 'Activity log has been cleared successfully.');
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
        // Check if activity log has been cleared
        if (session('activity_log_cleared', false)) {
            return [];
        }

        $payments = Payment::with('tenant')
            ->orderByDesc('updated_at')
            ->limit(6)
            ->get();

        $activityLog = $payments->map(function (Payment $payment) {
            $unit = $payment->tenant->unit ?? 'N/A';
            $amount = '₱' . number_format($payment->amount, 2);
            $paymentId = $payment->id;

            // Total paid by tenant (only consider paid payments)
            $totalPaid = 0;
            if ($payment->tenant) {
                $totalPaid = $payment->tenant->payments()->where('status', 'paid')->sum('amount');
            }
            $totalPaidFormatted = '₱' . number_format($totalPaid, 2);

            if ($payment->status === 'paid') {
                $time = $payment->payment_date ? $payment->payment_date : $payment->updated_at;

                return [
                    'dotColor' => 'bg-green-500',
                    'title'    => 'Payment Received',
                    'desc'     => "{$amount} from Unit {$unit} · total paid {$totalPaidFormatted} · {$time->diffForHumans()}",
                    'payment_id' => $paymentId,
                ];
            }

            if ($payment->status === 'overdue') {
                return [
                    'dotColor' => 'bg-orange-400',
                    'title'    => 'Overdue Payment',
                    'desc'     => "Unit {$unit} overdue since {$payment->due_date->format('M d')} · {$amount}",
                    'payment_id' => $paymentId,
                ];
            }

            return [
                'dotColor' => 'bg-blue-400',
                'title'    => 'Upcoming Payment',
                'desc'     => "Unit {$unit} due on {$payment->due_date->format('M d')} · {$amount}",
                'payment_id' => $paymentId,
            ];
        })->filter()->values()->all();

        if (count($activityLog) < 6) {
            $activityLog = array_merge($activityLog, $this->getActivityLogPlaceholders(6 - count($activityLog)));
        }

        return $activityLog;
    }

    private function getActivityLogPlaceholders(int $count): array
    {
        return array_map(fn () => [
            'dotColor' => 'bg-gray-300',
            'title'    => 'Awaiting activity',
            'desc'     => 'More events will appear in the activity feed soon.',
        ], range(1, $count));
    }
}

