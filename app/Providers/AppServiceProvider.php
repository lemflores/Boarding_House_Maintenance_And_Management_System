<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Tenant;
use App\Http\Controllers\MaintenanceController;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $now = Carbon::today();
            if (! auth()->check()) {
                $view->with([
                    'expiredTenants' => collect(),
                    'almostExpiredTenants' => collect(),
                    'maintenanceItems' => [],
                ]);
                return;
            }

            // Get expired and almost expired tenants for current user
            $expiredTenants = Tenant::where('user_id', auth()->id())->where('lease_end', '<', $now)->get();
            $almostExpiredTenants = Tenant::where('user_id', auth()->id())->whereBetween('lease_end', [$now, $now->copy()->addDays(7)])->get();

            // Get maintenance items
            $tickets = MaintenanceController::getTickets(auth()->id());
            $maintenanceItems = $this->buildMaintenanceItems($tickets);

            $view->with([
                'expiredTenants' => $expiredTenants,
                'almostExpiredTenants' => $almostExpiredTenants,
                'maintenanceItems' => $maintenanceItems,
            ]);
        });
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
}
