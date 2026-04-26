<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $allTenants = [
            [
                'name'          => 'Rafael Dela Cruz',
                'initials'      => 'RD',
                'color'         => '#7c3a1e',
                'unit'          => 'Unit 12',
                'leasePeriod'   => 'Oct 2023 – Oct 2024',
                'leaseRemaining'=> '10 Months Remaining',
                'leaseUrgency'  => 'text-gray-400',
                'status'        => 'Active',
                'statusBadge'   => 'badge-green',
                'payment'       => 'Paid',
                'paymentIcon'   => '✅',
                'paymentColor'  => 'text-green-700',
            ],
            [
                'name'          => 'Bianca Santos',
                'initials'      => 'BS',
                'color'         => '#1565c0',
                'unit'          => 'Unit 15',
                'leasePeriod'   => 'Jan 2023 – Jan 2024',
                'leaseRemaining'=> 'Expiring in 12 Days',
                'leaseUrgency'  => 'text-orange-500',
                'status'        => 'Renewal Sent',
                'statusBadge'   => 'badge-orange',
                'payment'       => 'Pending',
                'paymentIcon'   => '🕐',
                'paymentColor'  => 'text-orange-500',
            ],
            [
                'name'          => 'Miguel Reyes',
                'initials'      => 'MR',
                'color'         => '#555555',
                'unit'          => 'Unit 08',
                'leasePeriod'   => 'Mar 2023 – Mar 2024',
                'leaseRemaining'=> '4 Months Remaining',
                'leaseUrgency'  => 'text-gray-400',
                'status'        => 'Active',
                'statusBadge'   => 'badge-green',
                'payment'       => 'Paid',
                'paymentIcon'   => '✅',
                'paymentColor'  => 'text-green-700',
            ],
            [
                'name'          => 'Sofia Villamor',
                'initials'      => 'SV',
                'color'         => '#7b1fa2',
                'unit'          => 'Unit 05',
                'leasePeriod'   => 'Nov 2022 – Nov 2023',
                'leaseRemaining'=> '1 Month Remaining',
                'leaseUrgency'  => 'text-red-600',
                'status'        => 'Active',
                'statusBadge'   => 'badge-green',
                'payment'       => 'Paid',
                'paymentIcon'   => '✅',
                'paymentColor'  => 'text-green-700',
            ],
        ];

        // Simple search filter
        $search = $request->input('search', '');
        if ($search) {
            $allTenants = array_filter($allTenants, fn($t) =>
                str_contains(strtolower($t['name']), strtolower($search)) ||
                str_contains(strtolower($t['unit']), strtolower($search))
            );
        }

        return view('tenants.index', [
            'tenants'        => array_values($allTenants),
            'totalResidents' => 124,
            'activeLeases'   => 36,
            'expiringLeases' => 6,
            'occupancyRate'  => 75.1,
        ]);
    }
}
