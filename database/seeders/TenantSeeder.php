<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenants = [
            [
                'name' => 'Mateo Alcantara',
                'unit' => 'Unit 113',
                'occupants' => 2,
                'email' => 'mateo@example.com',
                'phone' => '+63 912 345 6789',
                'lease_start' => '2025-01-01',
                'lease_end' => '2026-01-01',
                'status' => 'Active',
                'payment_status' => 'Paid',
                'notes' => 'Regular tenant, pays on time.',
            ],
            [
                'name' => 'Miguel Tan',
                'unit' => 'Unit 112',
                'occupants' => 1,
                'email' => 'miguel@example.com',
                'phone' => '+63 923 456 7890',
                'lease_start' => '2025-02-01',
                'lease_end' => '2026-02-01',
                'status' => 'Active',
                'payment_status' => 'Overdue',
                'notes' => 'Has been late with payments recently.',
            ],
            [
                'name' => 'Lucas Cruz',
                'unit' => 'Unit 122',
                'occupants' => 3,
                'email' => 'lucas@example.com',
                'phone' => '+63 934 567 8901',
                'lease_start' => '2025-03-01',
                'lease_end' => '2026-03-01',
                'status' => 'Active',
                'payment_status' => 'Pending',
                'notes' => 'New tenant, still settling in.',
            ],
            [
                'name' => 'Elena Pineda',
                'unit' => 'Unit 108',
                'occupants' => 1,
                'email' => 'elena@example.com',
                'phone' => '+63 945 678 9012',
                'lease_start' => '2024-12-01',
                'lease_end' => '2025-12-01',
                'status' => 'Active',
                'payment_status' => 'Paid',
                'notes' => 'Long-term tenant, very reliable.',
            ],
            [
                'name' => 'Rafael Villamorez',
                'unit' => 'Unit 102',
                'occupants' => 2,
                'email' => 'rafael@example.com',
                'phone' => '+63 956 789 0123',
                'lease_start' => '2025-04-01',
                'lease_end' => '2026-04-01',
                'status' => 'Active',
                'payment_status' => 'Overdue',
                'notes' => 'Has maintenance issues that need attention.',
            ],
        ];

        foreach ($tenants as $tenant) {
            Tenant::create($tenant);
        }
    }
}
