<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalRevenue'      => 245800.00,
            'occupiedUnits'     => 36,
            'totalUnits'        => 48,
            'occupancyRate'     => 75.1,
            'pendingRequests'   => 2,
            'inProgressRequests'=> 2,
            'resolvedRequests'  => 2,
            'newApplicants'     => 4,

            'maintenanceItems' => [
                [
                    'icon'     => '❄️',
                    'iconBg'   => 'bg-red-100',
                    'title'    => 'Room 103 – Air Conditioning Leak',
                    'priority' => 'high',
                    'meta'     => 'Reported by Resident · 45 mins ago',
                ],
                [
                    'icon'     => '🚿',
                    'iconBg'   => 'bg-gray-100',
                    'title'    => 'Kitchen Tap Plumbing',
                    'priority' => 'normal',
                    'meta'     => 'Unit 219',
                ],
                [
                    'icon'     => '💡',
                    'iconBg'   => 'bg-yellow-50',
                    'title'    => 'Light Bulb Replacement',
                    'priority' => 'normal',
                    'meta'     => '2nd Floor Hallway',
                ],
            ],

            'activityLog' => $this->buildActivityLog(),
        ];

        return view('dashboard.index', $data);
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
