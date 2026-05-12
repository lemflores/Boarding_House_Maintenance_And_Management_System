<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MaintenanceController;
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

        $maintenanceRooms = collect(MaintenanceController::getTickets())
            ->mapWithKeys(function ($ticket) {
                $roomNumber = $this->normalizeRoomNumber($ticket['location']);
                return $roomNumber ? [$roomNumber => $ticket] : [];
            })
            ->all();

        $roomsByFloor = [
            1 => array_map(fn($number) => [
                'number' => $number,
                'status' => 'vacant',
                'note' => 'Available',
            ], ['101','102','103','104','105','106','107','108','109','110','111','112']),
            2 => array_map(fn($number) => [
                'number' => $number,
                'status' => 'vacant',
                'note' => 'Available',
            ], ['201','202','203','204','205','206','207','208','209','210','211','212']),
            3 => array_map(fn($number) => [
                'number' => $number,
                'status' => 'vacant',
                'note' => 'Available',
            ], ['301','302','303','304','305','306','307','308','309','310','311','312']),
        ];

        $floors = [
            ['value' => 1, 'label' => 'Level 01', 'count' => count($roomsByFloor[1]), 'active' => $selectedFloor === 1],
            ['value' => 2, 'label' => 'Level 02', 'count' => count($roomsByFloor[2]), 'active' => $selectedFloor === 2],
            ['value' => 3, 'label' => 'Level 03', 'count' => count($roomsByFloor[3]), 'active' => $selectedFloor === 3],
        ];

        $rooms = $this->applyMaintenanceStatus($this->applyTenantOccupancy($roomsByFloor[$selectedFloor], $tenantRooms), $maintenanceRooms);
        $allRooms = [];
        foreach ($roomsByFloor as $floorRooms) {
            $allRooms = array_merge($allRooms, $this->applyMaintenanceStatus($this->applyTenantOccupancy($floorRooms, $tenantRooms), $maintenanceRooms));
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
        if (preg_match('/\bUnit\s*(\d{2,3})\b/i', $unit, $matches)) {
            return $matches[1];
        }

        if (preg_match('/^\d{2,3}$/', trim($unit))) {
            return trim($unit);
        }

        if (preg_match('/\b(\d{3})\b/', $unit, $matches)) {
            return $matches[1];
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

    private function applyMaintenanceStatus(array $rooms, array $maintenanceRooms): array
    {
        return array_map(function ($room) use ($maintenanceRooms) {
            $roomNumber = ltrim($room['number'], '0');

            if (isset($maintenanceRooms[$roomNumber])) {
                return [
                    'number' => $room['number'],
                    'status' => 'repair',
                    'statusClass' => 'room-card-repair',
                    'issue' => $maintenanceRooms[$roomNumber]['subject'] ?? 'Maintenance report',
                    'subNote' => 'Reported',
                ];
            }

            return $room;
        }, $rooms);
    }
}
