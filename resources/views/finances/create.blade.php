@extends('layouts.app')
@section('title', 'Add Payment Record')

@section('content')

{{-- ── HEADER ──────────────────────────────────────────────────── --}}
<h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e] mb-6">Add Payment Record</h1>

{{-- ── FORM CARD ────────────────────────────────────────────────── --}}
<div class="bg-white rounded-xl border border-[#ede7df] p-6 md:p-8 max-w-2xl">

    <form action="{{ route('finances.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Tenant Selection --}}
        <div>
            <label for="tenant_id" class="block text-[14px] font-semibold text-[#2d1a0e] mb-2">Tenant</label>
            <select name="tenant_id" id="tenant_id" required
                    class="w-full px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] focus:border-[#7c3a1e] focus:outline-none">
                <option value="">Select a tenant</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}">{{ $tenant->name }} - {{ $tenant->unit }}</option>
                @endforeach
            </select>
        </div>

        {{-- Amount --}}
        <div>
            <label for="amount" class="block text-[14px] font-semibold text-[#2d1a0e] mb-2">Amount (₱)</label>
            <input type="number" name="amount" id="amount" step="0.01" min="0" required
                   class="w-full px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] focus:border-[#7c3a1e] focus:outline-none"
                   placeholder="Enter amount">
        </div>

        {{-- Due Date --}}
        <div>
            <label for="due_date" class="block text-[14px] font-semibold text-[#2d1a0e] mb-2">Due Date</label>
            <input type="date" name="due_date" id="due_date" required
                   class="w-full px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] focus:border-[#7c3a1e] focus:outline-none">
        </div>

        {{-- Notes --}}
        <div>
            <label for="notes" class="block text-[14px] font-semibold text-[#2d1a0e] mb-2">Notes (Optional)</label>
            <textarea name="notes" id="notes" rows="3"
                      class="w-full px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] focus:border-[#7c3a1e] focus:outline-none"
                      placeholder="Additional notes about this payment"></textarea>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-3 pt-4">
            <a href="{{ route('finances') }}"
               class="px-6 py-3 border border-[#e5e7eb] text-[#2d1a0e] rounded-lg text-[14px] font-semibold hover:bg-[#faf7f4] transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-3 bg-[#7c3a1e] text-white rounded-lg text-[14px] font-semibold hover:bg-[#5a2a15] transition-colors">
                Create Payment Record
            </button>
        </div>
    </form>
</div>

@endsection