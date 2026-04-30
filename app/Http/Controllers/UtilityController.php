<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function index()
    {
        $rooms = [
            ['number' => '101', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Mateo Dela Cruz'],
            ['number' => '102', 'status' => 'repair',   'statusClass' => 'room-card-repair',   'issue' => 'AC Unit Leakage',    'subNote' => 'PENDING WO'],
            ['number' => '103', 'status' => 'vacant',   'statusClass' => 'room-card-vacant',   'note' => 'Immediate Move-in'],
            ['number' => '104', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Rafael Santos'],
            ['number' => '105', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Carlos Yulo'],
            ['number' => '106', 'status' => 'vacant',   'statusClass' => 'room-card-vacant',   'note' => 'Cleaning in Progress'],
            ['number' => '107', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Isabella Luna'],
            ['number' => '108', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Rafael Santos'],
            ['number' => '109', 'status' => 'vacant',   'statusClass' => 'room-card-vacant',   'note' => 'Open for Viewing'],
            ['number' => '110', 'status' => 'repair',   'statusClass' => 'room-card-repair',   'issue' => 'Flooring Renewal',   'subNote' => ''],
            ['number' => '111', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Elena Soriano'],
            ['number' => '112', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Miguel Tan'],
        ];

        return view('utility.index', [
            'totalUnits'  => 48,
            'occupied'    => 36,
            'vacant'      => 9,
            'maintenance' => 3,
            'floors' => [
                ['label' => 'Level 01', 'count' => 12, 'active' => true],
                ['label' => 'Level 02', 'count' => 12, 'active' => false],
                ['label' => 'Level 03', 'count' => 12, 'active' => false],
            ],
            'rooms' => $rooms,
        ]);
    }
}
