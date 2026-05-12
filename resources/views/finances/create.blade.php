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
                <select name="tenant_id" id="tenant_id" required
                        class="w-full px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] focus:border-[#7c3a1e] focus:outline-none">
                    <option value="">-- Select a tenant --</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                            {{ $tenant->name }} (Unit {{ $tenant->unit }})
                        </option>
                    @endforeach
                </select>
                @error('tenant_id')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Amount --}}
            <div>
                <label for="amount" class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                    Amount (₱) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="amount" id="amount" step="0.01" min="0" required
                       value="{{ old('amount') }}"
                       class="w-full px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] focus:border-[#7c3a1e] focus:outline-none"
                       placeholder="e.g. 5000.00">
                @error('amount')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Due Date --}}
            <div>
                <label for="due_date" class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                    Due Date <span class="text-red-500">*</span>
                </label>
                <input type="date" name="due_date" id="due_date" required
                       value="{{ old('due_date') }}"
                       class="w-full px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] focus:border-[#7c3a1e] focus:outline-none">
                @error('due_date')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
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

@endsection