<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all');
        $search = $request->input('search', '');

        $query = Tenant::query();

        if ($filter !== 'all') {
            $query->whereRaw('LOWER(status) = ?', [Str::lower($filter)]);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('unit', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $tenantModels = $query->orderBy('lease_end', 'asc')->paginate(5);

        $tenants = $tenantModels->getCollection()->map(fn (Tenant $tenant) => $this->formatTenant($tenant))->all();
        $tenantModels->setCollection(collect($tenants));

        $totalResidents = Tenant::sum('occupants');
        $activeLeases = Tenant::where('status', 'Active')->count();
        $expiringLeases = Tenant::whereBetween('lease_end', [now(), now()->addDays(30)])->count();
        $totalUnits = 36; // 3 floors × 12 units per floor
        $occupancyRate = round((Tenant::count() / $totalUnits) * 100, 1);

        return view('tenants.index', [
            'tenants'        => $tenants,
            'totalResidents' => $totalResidents,
            'activeLeases'   => $activeLeases,
            'expiringLeases' => $expiringLeases,
            'occupancyRate'  => $occupancyRate,
            'currentFilter'  => $filter,
            'tenantsPaginated' => $tenantModels,
        ]);
    }

    public function create()
    {
        // Get all available units from utility tracking
        $availableUnits = $this->getAvailableUnits();
        return view('tenants.create', compact('availableUnits'));
    }

    public function store(Request $request)
    {
        $tenant = Tenant::create($this->validateTenant($request));

        return redirect()->route('tenants.show', $tenant)->with('success', 'Tenant created successfully.');
    }

    public function show($id)
    {
        $tenant = Tenant::findOrFail($id);

        return view('tenants.show', ['tenant' => $this->formatTenant($tenant), 'rawTenant' => $tenant]);
    }

    public function edit($id)
    {
        $tenant = Tenant::findOrFail($id);
        $availableUnits = $this->getAvailableUnits($tenant->unit);
        return view('tenants.edit', compact('tenant', 'availableUnits'));
    }

    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->update($this->validateTenant($request));

        return redirect()->route('tenants.show', $tenant)->with('success', 'Tenant updated successfully.');
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();

        return redirect()->route('tenants')->with('success', 'Tenant deleted successfully.');
    }

    private function validateTenant(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:100',
            'occupants' => 'required|integer|min:1|max:20',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|regex:/^[0-9\s\-\+\(\)]+$/|max:30',
            'lease_start' => 'required|date',
            'lease_end' => 'required|date|after_or_equal:lease_start',
            'status' => ['required', Rule::in(['Active', 'Renewal Sent', 'Pending', 'Overdue'])],
            'payment_status' => ['required', Rule::in(['Paid', 'Partially Paid', 'Pending', 'Overdue'])],
            'notes' => 'nullable|string|max:1000',
        ]);
    }

    private function formatTenant(Tenant $tenant): array
    {
        $now = Carbon::today();
        $leaseRemaining = 'No End Date';
        $leaseUrgency = 'text-gray-400';

        if ($tenant->lease_end) {
            if ($tenant->lease_end->isPast()) {
                $leaseRemaining = 'Expired';
                $leaseUrgency = $tenant->payment_status === 'Paid' ? 'text-gray-400' : 'text-red-600';
            } else {
                $days = (int) floor($now->diffInDays($tenant->lease_end));
                if ($days <= 30) {
                    $leaseRemaining = "Expiring in {$days} Days";
                    $leaseUrgency = 'text-orange-500';
                } else {
                    $months = round($now->diffInMonths($tenant->lease_end));
                    $leaseRemaining = "{$months} Months Remaining";
                    $leaseUrgency = 'text-gray-400';
                }
            }
        }

        $paymentStatus = $tenant->payment_status;
        if ($this->hasPartialPayment($tenant) && in_array($paymentStatus, ['Pending', 'Partially Paid'], true)) {
            $paymentStatus = 'Partially Paid';
        }

        return [
            'id' => $tenant->id,
            'name' => $tenant->name,
            'initials' => $this->generateInitials($tenant->name),
            'color' => $this->generateAvatarColor($tenant->name),
            'unit' => $tenant->unit,
            'leasePeriod' => $tenant->lease_start && $tenant->lease_end ? $tenant->lease_start->format('M Y') . ' – ' . $tenant->lease_end->format('M Y') : 'N/A',
            'leaseRemaining' => $leaseRemaining,
            'leaseUrgency' => $leaseUrgency,
            'status' => $tenant->status,
            'statusBadge' => $this->statusBadge($tenant->status),
            'payment' => $paymentStatus,
            'paymentIcon' => $this->paymentIcon($paymentStatus),
            'paymentColor' => $this->paymentColor($paymentStatus),
            'email' => $tenant->email,
            'phone' => $tenant->phone,
            'notes' => $tenant->notes,
            'occupants' => $tenant->occupants,
            'lease_start' => $tenant->lease_start?->format('M d, Y'),
            'lease_end' => $tenant->lease_end?->format('M d, Y'),
        ];
    }

    private function generateInitials(string $name): string
    {
        return collect(explode(' ', $name))->filter()->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->join('');
    }

    private function generateAvatarColor(string $name): string
    {
        $colors = ['#7c3a1e', '#1565c0', '#555555', '#7b1fa2', '#0f766e', '#b45309'];
        return $colors[crc32($name) % count($colors)];
    }

    private function statusBadge(string $status): string
    {
        return match ($status) {
            'Active' => 'green',
            'Renewal Sent' => 'orange',
            default => 'gray',
        };
    }

    private function paymentIcon(string $paymentStatus): string
    {
        return match ($paymentStatus) {
            'Paid' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>',
            'Partially Paid', 'Pending' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
            default => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>',
        };
    }

    private function paymentColor(string $paymentStatus): string
    {
        return match ($paymentStatus) {
            'Paid' => 'text-green-700',
            'Partially Paid' => 'text-orange-500',
            'Pending' => 'text-orange-500',
            default => 'text-red-600',
        };
    }

    private function hasPartialPayment(Tenant $tenant): bool
    {
        return $tenant->isPartiallyPaid();
    }

    private function getAvailableUnits(?string $currentUnit = null): array
    {
        $roomsByFloor = [
            1 => ['101', '102', '103', '104', '105', '106', '107', '108', '109', '110', '111', '112'],
            2 => ['201', '202', '203', '204', '205', '206', '207', '208', '209', '210', '211', '212'],
            3 => ['301', '302', '303', '304', '305', '306', '307', '308', '309', '310', '311', '312'],
        ];

        $allRooms = [];
        foreach ($roomsByFloor as $floorRooms) {
            $allRooms = array_merge($allRooms, $floorRooms);
        }

        // Get occupied units excluding the current tenant unit when editing.
        $occupiedUnits = Tenant::whereNotNull('unit')
            ->when($currentUnit, fn ($query) => $query->where('unit', '!=', $currentUnit))
            ->pluck('unit')
            ->map(fn ($unit) => $this->normalizeRoomNumber($unit))
            ->filter()
            ->toArray();

        $availableUnits = array_diff($allRooms, $occupiedUnits);

        sort($availableUnits, SORT_NUMERIC);
        return array_values($availableUnits);
    }

    private function normalizeRoomNumber(string $unit): ?string
    {
        if (preg_match('/\d+/', $unit, $matches)) {
            return $matches[0];
        }
        return null;
    }
}
