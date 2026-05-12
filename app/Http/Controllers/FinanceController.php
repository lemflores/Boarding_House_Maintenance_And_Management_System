<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Tenant;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        // Update overdue payments and keep tenant payment status in sync
        $overduePayments = Payment::where('due_date', '<', now())
            ->where('status', 'pending')
            ->get();

        foreach ($overduePayments as $payment) {
            $payment->update(['status' => 'overdue']);
            if ($payment->tenant) {
                $payment->tenant->update(['payment_status' => 'Overdue']);
            }
        }

        $filter = $request->get('filter', 'all');
        $search = $request->get('search');

        $query = Payment::with('tenant');

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

        $transactions = $query->get()->map(function ($payment) {
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

        // Calculate stats
        $totalCollections = Payment::where('status', 'paid')->sum('amount');
        $settledUnits = Tenant::where('payment_status', 'Paid')->count();
        $totalUnits = Tenant::count();
        $overdueAmount = Payment::where('status', 'overdue')->sum('amount');

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
        $tenants = Tenant::all();
        return view('finances.create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $tenant = Tenant::findOrFail($request->tenant_id);
        $status = now()->greaterThan(Carbon::parse($request->due_date)) ? 'overdue' : 'pending';

        $payment = Payment::create([
            'tenant_id' => $tenant->id,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'status' => $status,
            'notes' => $request->notes,
        ]);

        $tenant->update([
            'payment_status' => $status === 'overdue' ? 'Overdue' : 'Pending',
        ]);

        return redirect()->route('finances')->with('success', 'Payment record created successfully.');
    }

    public function markAsPaid($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => 'paid',
            'payment_date' => now(),
        ]);

        if ($payment->tenant) {
            $payment->tenant->update(['payment_status' => 'Paid']);
        }

        return redirect()->route('finances')->with('success', 'Payment marked as paid.');
    }

    public function markAsOverdue($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'overdue']);

        if ($payment->tenant) {
            $payment->tenant->update(['payment_status' => 'Overdue']);
        }

        return redirect()->route('finances')->with('success', 'Payment marked as overdue.');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('finances')->with('success', 'Payment record deleted successfully.');
    }

    public function notifyTenant($id)
    {
        $payment = Payment::with('tenant')->findOrFail($id);
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
