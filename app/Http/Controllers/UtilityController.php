<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function index(Request $request)
    {
        $selectedFloor = (int) $request->query('floor', 1);
        if ($selectedFloor < 1 || $selectedFloor > 3) {
            $selectedFloor = 1;
        }

        $tenantRooms = Tenant::query()
            ->whereNotNull('unit')
            ->get()
            ->mapWithKeys(function (Tenant $tenant) {
                $roomNumber = $this->normalizeRoomNumber($tenant->unit);
                return $roomNumber ? [$roomNumber => $tenant->name] : [];
            })
            ->all();

        $roomsByFloor = [
            1 => [
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
            ],
            2 => [
                ['number' => '201', 'status' => 'vacant',   'statusClass' => 'room-card-vacant',   'note' => 'Open for Viewing'],
                ['number' => '202', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Ariel Mendoza'],
                ['number' => '203', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Jessa Cruz'],
                ['number' => '204', 'status' => 'repair',   'statusClass' => 'room-card-repair',   'issue' => 'Plumbing Leak',      'subNote' => 'Parts Ordered'],
                ['number' => '205', 'status' => 'vacant',   'statusClass' => 'room-card-vacant',   'note' => 'Immediate Move-in'],
                ['number' => '206', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Marco Villanueva'],
                ['number' => '207', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Leah Santos'],
                ['number' => '208', 'status' => 'repair',   'statusClass' => 'room-card-repair',   'issue' => 'Broken Window',      'subNote' => 'Estimate Sent'],
                ['number' => '209', 'status' => 'vacant',   'statusClass' => 'room-card-vacant',   'note' => 'Cleaning in Progress'],
                ['number' => '210', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Jonas Rivera'],
                ['number' => '211', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Nina Alonzo'],
                ['number' => '212', 'status' => 'vacant',   'statusClass' => 'room-card-vacant',   'note' => 'Available Soon'],
            ],
            3 => [
                ['number' => '301', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Mika Jose'],
                ['number' => '302', 'status' => 'vacant',   'statusClass' => 'room-card-vacant',   'note' => 'Immediate Move-in'],
                ['number' => '303', 'status' => 'repair',   'statusClass' => 'room-card-repair',   'issue' => 'Light Fixture',      'subNote' => 'Electrician Scheduled'],
                ['number' => '304', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Paolo Domingo'],
                ['number' => '305', 'status' => 'vacant',   'statusClass' => 'room-card-vacant',   'note' => 'Open for Viewing'],
                ['number' => '306', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Tina Reyes'],
                ['number' => '307', 'status' => 'vacant',   'statusClass' => 'room-card-vacant',   'note' => 'Cleaning in Progress'],
                ['number' => '308', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Dante Hidalgo'],
                ['number' => '309', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Carla Lim'],
                ['number' => '310', 'status' => 'repair',   'statusClass' => 'room-card-repair',   'issue' => 'AC Unit Leak',      'subNote' => 'Pending Repair'],
                ['number' => '311', 'status' => 'vacant',   'statusClass' => 'room-card-vacant',   'note' => 'Available Soon'],
                ['number' => '312', 'status' => 'occupied', 'statusClass' => 'room-card-occupied', 'tenant' => 'Rico Dela Cruz'],
            ],
        ];

        $floors = [
            ['value' => 1, 'label' => 'Level 01', 'count' => count($roomsByFloor[1]), 'active' => $selectedFloor === 1],
            ['value' => 2, 'label' => 'Level 02', 'count' => count($roomsByFloor[2]), 'active' => $selectedFloor === 2],
            ['value' => 3, 'label' => 'Level 03', 'count' => count($roomsByFloor[3]), 'active' => $selectedFloor === 3],
        ];

        $rooms = $this->applyTenantOccupancy($roomsByFloor[$selectedFloor], $tenantRooms);
        $allRooms = [];
        foreach ($roomsByFloor as $floorRooms) {
            $allRooms = array_merge($allRooms, $this->applyTenantOccupancy($floorRooms, $tenantRooms));
        }

        $totalUnits = count($allRooms);
        $occupied = count(array_filter($allRooms, fn ($room) => $room['status'] === 'occupied'));
        $vacant = count(array_filter($allRooms, fn ($room) => $room['status'] === 'vacant'));
        $maintenance = count(array_filter($allRooms, fn ($room) => $room['status'] === 'repair'));

        return view('utility.index', [
            'totalUnits'  => $totalUnits,
            'occupied'    => $occupied,
            'vacant'      => $vacant,
            'maintenance' => $maintenance,
            'floors'      => $floors,
            'rooms'       => $rooms,
        ]);
    }

    private function normalizeRoomNumber(string $unit): ?string
    {
        if (preg_match('/\d+/', $unit, $matches)) {
            return ltrim($matches[0], '0') === '' ? $matches[0] : $matches[0];
        }

        return null;
    }

    private function applyTenantOccupancy(array $rooms, array $tenantRooms): array
    {
        return array_map(function ($room) use ($tenantRooms) {
            $roomNumber = ltrim($room['number'], '0');

            if (isset($tenantRooms[$roomNumber])) {
                return [
                    'number' => $room['number'],
                    'status' => 'occupied',
                    'statusClass' => 'room-card-occupied',
                    'tenant' => $tenantRooms[$roomNumber],
                ];
            }

            return $room;
        }, $rooms);
    }
}
