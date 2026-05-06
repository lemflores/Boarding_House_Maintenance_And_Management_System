<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            [
                'tenant_id' => 1,
                'amount' => 22500.00,
                'due_date' => '2025-01-15',
                'payment_date' => '2025-01-15',
                'status' => 'paid',
                'notes' => 'Monthly rent payment',
            ],
            [
                'tenant_id' => 2,
                'amount' => 45000.00,
                'due_date' => '2026-01-03',
                'payment_date' => null,
                'status' => 'overdue',
                'notes' => 'Monthly rent payment - overdue',
            ],
            [
                'tenant_id' => 3,
                'amount' => 18200.00,
                'due_date' => '2025-11-15',
                'payment_date' => null,
                'status' => 'pending',
                'notes' => 'Monthly rent payment',
            ],
            [
                'tenant_id' => 4,
                'amount' => 120000.00,
                'due_date' => '2025-12-03',
                'payment_date' => '2025-12-03',
                'status' => 'paid',
                'notes' => 'Annual rent payment',
            ],
            [
                'tenant_id' => 5,
                'amount' => 12000.00,
                'due_date' => '2025-11-28',
                'payment_date' => null,
                'status' => 'overdue',
                'notes' => 'Monthly rent payment - overdue',
            ],
        ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }
    }
}
