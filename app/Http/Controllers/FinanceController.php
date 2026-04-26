<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $transactions = [
            [
                'name'     => 'Mateo Alcantara',
                'initials' => 'MA',
                'color'    => '#7c3a1e',
                'unit'     => 'Unit 113',
                'date'     => 'Jan 15, 2025',
                'amount'   => 22500.00,
                'status'   => 'PAID',
            ],
            [
                'name'     => 'Miguel Tan',
                'initials' => 'MT',
                'color'    => '#1565c0',
                'unit'     => 'Unit 112',
                'date'     => 'Jan 03, 2026',
                'amount'   => 45000.00,
                'status'   => 'OVERDUE',
            ],
            [
                'name'     => 'Lucas Cruz',
                'initials' => 'LC',
                'color'    => '#555555',
                'unit'     => 'Unit 122',
                'date'     => 'Nov 15, 2025',
                'amount'   => 18200.00,
                'status'   => 'PENDING',
            ],
            [
                'name'     => 'Elena Pineda',
                'initials' => 'EP',
                'color'    => '#e65100',
                'unit'     => 'Unit 108',
                'date'     => 'Dec 03, 2025',
                'amount'   => 120000.00,
                'status'   => 'PAID',
            ],
            [
                'name'     => 'Rafael Villamorez',
                'initials' => 'RV',
                'color'    => '#c62828',
                'unit'     => 'Unit 102',
                'date'     => 'Nov 28, 2025',
                'amount'   => 12000.00,
                'status'   => 'OVERDUE',
            ],
        ];

        return view('finances.index', [
            'totalCollections' => 482900.00,
            'settledUnits'     => 36,
            'totalUnits'       => 48,
            'overdueAmount'    => 34500.00,
            'transactions'     => $transactions,
        ]);
    }
}
