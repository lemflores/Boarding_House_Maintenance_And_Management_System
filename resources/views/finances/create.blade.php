@extends('layouts.app')
@section('title', 'Add Payment Record')

@section('content')

{{-- ── HEADER ──────────────────────────────────────────────────── --}}
<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e]">Add Payment Record</h1>
        <p class="text-sm text-gray-500 mt-1">Create a new payment record to track rental payments from tenants.</p>
    </div>
    <a href="{{ route('finances') }}" class="inline-flex items-center gap-2 border border-[#e5e7eb] text-gray-500 text-[12px] md:text-[13px] font-medium px-4 py-2.5 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors">
        ← Back to Finances
    </a>
</div>

{{-- ── FORM CARD ────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Quick Info Cards --}}
    <div class="lg:col-span-1 space-y-4">
        <div class="bg-white rounded-xl border border-[#ede7df] p-5">
            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-400 mb-2">Total Tenants</p>
            <p class="text-[32px] font-bold text-[#2d1a0e]">{{ count($tenants) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-[#ede7df] p-5">
            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-400 mb-2">Active Units</p>
            <p class="text-[32px] font-bold text-[#7c3a1e]">{{ count($tenants) }}</p>
        </div>
        <div class="bg-[#faf7f4] rounded-xl border border-[#ede7df] p-5">
            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-600 mb-3">Quick Tips</p>
            <ul class="space-y-2 text-[12px] text-gray-600">
                <li class="flex gap-2">
                    <span class="text-[#7c3a1e]">•</span>
                    <span>Set due dates for consistent tracking</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-[#7c3a1e]">•</span>
                    <span>Include payment amount and notes</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-[#7c3a1e]">•</span>
                    <span>Review overdue payments regularly</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- Form Section --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-[#ede7df] p-6 md:p-8">
        <form action="{{ route('finances.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Tenant Selection --}}
            <div>
                <label for="tenant_id" class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                    Tenant <span class="text-red-500">*</span>
                </label>
                <input type="text" name="tenant_name" id="tenant_name" required
                        list="tenantsList" class="w-full px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] focus:border-[#7c3a1e] focus:outline-none"
                        placeholder="Search and select tenant...">
                <datalist id="tenantsList">
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->name }} (Unit {{ $tenant->unit }}) - {{ $tenant->payment_status }}" data-id="{{ $tenant->id }}">
                    @endforeach
                </datalist>
                <input type="hidden" name="tenant_id" id="tenant_id" value="{{ old('tenant_id') }}">
                @error('tenant_id')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Months to Pay --}}
            <div>
                <label for="months" class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                    Months to Pay <span class="text-red-500">*</span>
                </label>
                <select name="months" id="months" required
                        class="w-full px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] focus:border-[#7c3a1e] focus:outline-none"
                        onchange="updatePaymentAmount()">
                    <option value="">-- Select number of months --</option>
                    <option value="1" {{ old('months') == 1 ? 'selected' : '' }}>1 Month (₱3,000)</option>
                    <option value="2" {{ old('months') == 2 ? 'selected' : '' }}>2 Months (₱6,000)</option>
                    <option value="3" {{ old('months') == 3 ? 'selected' : '' }}>3 Months (₱9,000)</option>
                    <option value="4" {{ old('months') == 4 ? 'selected' : '' }}>4 Months (₱12,000)</option>
                    <option value="5" {{ old('months') == 5 ? 'selected' : '' }}>5 Months (₱15,000)</option>
                    <option value="6" {{ old('months') == 6 ? 'selected' : '' }}>6 Months (₱18,000)</option>
                    <option value="12" {{ old('months') == 12 ? 'selected' : '' }}>12 Months (₱36,000)</option>
                </select>
                @error('months')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Amount (Hidden) --}}
            <input type="hidden" name="amount" id="amount" value="{{ old('amount') }}">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                    Payment Amount (₱)
                </label>
                <div class="px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] bg-[#faf7f4] text-gray-600">
                    ₱<span id="amountDisplay">0.00</span>
                </div>
            </div>

            {{-- Due Date (Auto-calculated) --}}
            <input type="hidden" name="due_date" id="due_date" value="{{ old('due_date') }}">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                    Due Date (Auto-calculated)
                </label>
                <div class="px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] bg-[#faf7f4] text-gray-600">
                    <span id="dueDateDisplay">Select months above</span>
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label for="notes" class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                    Payment Notes (Optional)
                </label>
                <textarea name="notes" id="notes" rows="3"
                          value="{{ old('notes') }}"
                          class="w-full px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] focus:border-[#7c3a1e] focus:outline-none"
                          placeholder="e.g. Advance payment for June 2026, Cash payment received, etc."></textarea>
                @error('notes')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 pt-6 border-t border-[#e5e7eb]">
                <a href="{{ route('finances') }}"
                   class="flex-1 inline-flex items-center justify-center gap-2 border border-[#e5e7eb] text-gray-500 text-[12px] md:text-[13px] font-semibold px-4 py-3 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 bg-[#7c3a1e] hover:bg-[#5a2a15] text-white text-[12px] md:text-[13px] font-semibold px-4 py-3 rounded-lg transition-colors">
                    Create Payment Record
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const MONTHS_PRICE = 3000;

function updatePaymentAmount() {
    const monthsSelect = document.getElementById('months');
    const months = parseInt(monthsSelect.value) || 0;
    const amount = months * MONTHS_PRICE;
    
    // Update hidden amount field
    document.getElementById('amount').value = amount;
    
    // Update display
    document.getElementById('amountDisplay').textContent = new Intl.NumberFormat('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
    
    // Calculate due date (months from today)
    if (months > 0) {
        const today = new Date();
        const dueDate = new Date(today.getFullYear(), today.getMonth() + months, today.getDate());
        const year = dueDate.getFullYear();
        const month = String(dueDate.getMonth() + 1).padStart(2, '0');
        const day = String(dueDate.getDate()).padStart(2, '0');
        const dateString = `${year}-${month}-${day}`;
        
        document.getElementById('due_date').value = dateString;
        document.getElementById('dueDateDisplay').textContent = dueDate.toLocaleDateString('en-PH', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
    } else {
        document.getElementById('due_date').value = '';
        document.getElementById('dueDateDisplay').textContent = 'Select months above';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const monthsSelect = document.getElementById('months');
    if (monthsSelect.value) {
        updatePaymentAmount();
    }

    // Handle tenant selection from datalist
    const tenantInput = document.getElementById('tenant_name');
    const tenantIdInput = document.getElementById('tenant_id');
    const tenantsList = document.getElementById('tenantsList');

    tenantInput.addEventListener('input', function() {
        const selectedOption = Array.from(tenantsList.options).find(option => option.value === this.value);
        if (selectedOption) {
            tenantIdInput.value = selectedOption.getAttribute('data-id');
        } else {
            tenantIdInput.value = '';
        }
    });
});
</script>

@endsection