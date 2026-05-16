<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Tenant;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        // Update overdue payments and keep tenant payment status in sync
        $userId = Auth::id();

        $overduePayments = Payment::where('due_date', '<', now())
            ->where('status', 'pending')
            ->where('user_id', $userId)
            ->get();

        foreach ($overduePayments as $payment) {
            $payment->update(['status' => 'overdue']);
            if ($payment->tenant) {
                $payment->tenant->update(['payment_status' => 'Overdue']);
            }
        }

        $filter = $request->get('filter', 'all');
        $search = $request->get('search');

        $query = Payment::with('tenant')->where('user_id', $userId);

        if ($filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($filter === 'overdue') {
            $query->where('status', 'overdue');
        }

        if ($search) {
            $query->whereHas('tenant', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('unit', 'like', '%' . $search . '%');
            });
        }

        $transactions = $query->paginate(5);

        $mappedTransactions = $transactions->getCollection()->map(function ($payment) {
            return [
                'id' => $payment->id,
                'name' => $payment->tenant->name,
                'initials' => strtoupper(substr($payment->tenant->name, 0, 1) . substr(explode(' ', $payment->tenant->name)[1] ?? '', 0, 1)),
                'color' => $this->getTenantColor($payment->tenant->id),
                'unit' => $payment->tenant->unit,
                'date' => $payment->due_date->format('M d, Y'),
                'amount' => $payment->amount,
                'tenantStatus' => $payment->tenant->payment_status,
                'status' => strtoupper($payment->status),
            ];
        });
        $transactions->setCollection(collect($mappedTransactions));

        // Calculate stats
        $totalCollections = Payment::where('user_id', $userId)->where('status', 'paid')->sum('amount');
        $settledUnits = Tenant::where('user_id', $userId)->where('payment_status', 'Paid')->count();
        $totalUnits = Tenant::where('user_id', $userId)->count();
        $overdueAmount = Payment::where('user_id', $userId)->where('status', 'overdue')->sum('amount');

        return view('finances.index', [
            'totalCollections' => $totalCollections,
            'settledUnits' => $settledUnits,
            'totalUnits' => $totalUnits,
            'overdueAmount' => $overdueAmount,
            'transactions' => $transactions,
            'currentFilter' => $filter,
            'request' => $request,
        ]);
    }

    private function getTenantColor($tenantId)
    {
        $colors = ['#7c3a1e', '#1565c0', '#555555', '#e65100', '#c62828', '#2e7d32', '#f57c00', '#6a1b9a'];
        return $colors[($tenantId - 1) % count($colors)];
    }

    public function create()
    {
        $userId = Auth::id();

        $tenants = Tenant::where('user_id', $userId)->get()->map(function (Tenant $tenant) {
            $paymentStatus = $tenant->payment_status;
            if ($paymentStatus !== 'Overdue' && $tenant->isPartiallyPaid()) {
                $paymentStatus = 'Partially Paid';
            }

            return [
                'id' => $tenant->id,
                'name' => $tenant->name,
                'unit' => $tenant->unit,
                'payment_status_display' => $paymentStatus,
            ];
        });

        return view('finances.create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'months' => 'required|integer|min:1|max:12',
            'notes' => 'nullable|string',
        ]);

        $tenant = Tenant::where('user_id', $userId)->findOrFail($request->tenant_id);
        $months = (int)$request->months;
        $amount = $months * 3000;
        $dueDate = now()->addMonths($months);
        $status = 'paid';

        $payment = Payment::create([
            'user_id' => $userId,
            'tenant_id' => $tenant->id,
            'amount' => $amount,
            'due_date' => $dueDate,
            'status' => $status,
            'notes' => $request->notes,
        ]);

        // Determine how many months remain before the lease is extended.
        $originalLeaseEnd = $tenant->lease_end;
        $remainingLeaseMonths = $originalLeaseEnd && $originalLeaseEnd->gt(now())
            ? max(1, now()->diffInMonths($originalLeaseEnd) + 1)
            : 0;

        // Extend lease only when the payment covers time beyond the current lease end.
        if ($tenant->lease_end && $tenant->lease_end->gt(now())) {
            $leaseStart = $tenant->lease_end;
            $remainingLeaseMonths = max(1, now()->diffInMonths($tenant->lease_end) + 1);
            $monthsToExtend = max(0, $months - $remainingLeaseMonths);
            if ($monthsToExtend > 0) {
                $tenant->lease_end = $leaseStart->copy()->addMonths($monthsToExtend);
            }
        } else {
            $tenant->lease_end = now()->copy()->addMonths($months);
        }

        $existingPaidMonths = (int) round($tenant->payments()->where('status', 'paid')->sum('amount') / 3000);
        $tenantStatus = 'Partially Paid';
        if ($remainingLeaseMonths === 0 || $existingPaidMonths >= $remainingLeaseMonths) {
            $tenantStatus = 'Paid';
        }

        $tenant->payment_status = $tenantStatus;
        $tenant->save();

        return redirect()->route('finances')->with('success', 'Payment record created successfully.');
    }

    public function markAsPaid($id)
    {
        $userId = Auth::id();
        $payment = Payment::where('user_id', $userId)->findOrFail($id);
        $payment->update([
            'status' => 'paid',
            'payment_date' => now(),
        ]);

        if ($payment->tenant) {
            $this->syncTenantPaymentStatus($payment->tenant);
        }

        return redirect()->route('finances')->with('success', 'Payment marked as paid.');
    }

    public function markAsOverdue($id)
    {
        $userId = Auth::id();
        $payment = Payment::where('user_id', $userId)->findOrFail($id);
        $payment->update(['status' => 'overdue']);

        if ($payment->tenant) {
            $payment->tenant->update(['payment_status' => 'Overdue']);
        }

        return redirect()->route('finances')->with('success', 'Payment marked as overdue.');
    }

    public function destroy($id)
    {
        $userId = Auth::id();
        $payment = Payment::where('user_id', $userId)->findOrFail($id);
        $tenant = $payment->tenant;
        $payment->delete();

        if ($tenant) {
            $this->syncTenantPaymentStatus($tenant);
        }

        return redirect()->route('finances')->with('success', 'Payment record deleted successfully.');
    }

    private function syncTenantPaymentStatus(Tenant $tenant)
    {
        if ($tenant->payments()->where('status', 'overdue')->exists()) {
            $tenant->update(['payment_status' => 'Overdue']);
            return;
        }

        $paidAmount = $tenant->getPaidAmount();
        $leaseTotalAmount = $tenant->getLeaseTotalAmount();

        if ($paidAmount <= 0) {
            $tenant->update(['payment_status' => 'Pending']);
            return;
        }

        if ($leaseTotalAmount > 0 && $paidAmount < $leaseTotalAmount) {
            $tenant->update(['payment_status' => 'Partially Paid']);
            return;
        }

        $tenant->update(['payment_status' => 'Paid']);
    }

    public function notifyTenant($id)
    {
        $userId = Auth::id();
        $payment = Payment::with('tenant')->where('user_id', $userId)->findOrFail($id);
        $tenant = $payment->tenant;

        // Prepare notification message
        $message = "Dear {$tenant->name}, this is a reminder that your payment of ₱" . number_format($payment->amount, 2) . 
                   " for unit {$tenant->unit} is overdue as of " . $payment->due_date->format('F d, Y') . 
                   ". Please make your payment at your earliest convenience. Thank you.";

        // Send via email if available, otherwise via phone
        if ($tenant->email) {
            // Send email notification
            \Mail::raw($message, function ($mail) use ($tenant) {
                $mail->to($tenant->email)
                     ->subject('Overdue Payment Reminder - ' . config('app.name'));
            });
            $method = "email ({$tenant->email})";
        } elseif ($tenant->phone) {
            // For phone, we would typically use an SMS service
            // For now, we'll just log it or store it for manual processing
            $method = "phone ({$tenant->phone})";
        } else {
            return redirect()->route('finances')->with('error', 'No contact information available for this tenant.');
        }

        return redirect()->route('finances')->with('success', "Notification sent to tenant via {$method}.");
    }
}
