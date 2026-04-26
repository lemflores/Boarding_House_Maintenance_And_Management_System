<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

            'activityLog' => [
                [
                    'dotColor' => 'bg-green-500',
                    'title'    => 'Unit 205 Renewed',
                    'desc'     => 'Mr. Garcia signed for 12 months. 44M AGO',
                ],
                [
                    'dotColor' => 'bg-orange-400',
                    'title'    => 'Payment Received',
                    'desc'     => '₱18,500.00 from Unit 116. 1H AGO',
                ],
                [
                    'dotColor' => 'bg-blue-400',
                    'title'    => 'New Viewing',
                    'desc'     => 'Penthouse A scheduled for Sat 2pm. 3H AGO',
                ],
            ],
        ];

        return view('dashboard.index', $data);
    }
}
