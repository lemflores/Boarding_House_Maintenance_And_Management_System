@extends('layouts.app')
@section('title', 'Tenant Details')

@section('content')

{{-- ── HEADER ──────────────────────────────────────────────────── --}}
<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e]">{{ $tenant['name'] }}</h1>
        <p class="text-[11px] md:text-[12px] text-gray-400 mt-0.5">{{ $tenant['unit'] }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('tenants.edit', $tenant['id']) }}" class="inline-flex items-center gap-2 bg-[#7c3a1e] hover:bg-[#5c2910] text-white text-[12px] md:text-[13px] font-semibold px-4 py-2.5 rounded-lg transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
            Edit Tenant
        </a>
        <a href="{{ route('tenants') }}" class="inline-flex items-center gap-2 border border-[#e5e7eb] text-gray-500 text-[12px] md:text-[13px] font-medium px-4 py-2.5 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors">
            ← Back to Directory
        </a>
    </div>
</div>

@if (session('success'))
    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
        {{ session('success') }}
    </div>
@endif

{{-- ── DETAILS CARD ────────────────────────────────────────────── --}}
<div class="bg-white rounded-xl border border-[#ede7df] p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Full Name</p>
            <p class="text-[16px] font-semibold text-[#2d1a0e]">{{ $tenant['name'] }}</p>
        </div>
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Unit</p>
            <p class="text-[16px] font-semibold text-[#2d1a0e]">{{ $tenant['unit'] }}</p>
        </div>
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Lease Period</p>
            <p class="text-[16px] font-semibold text-[#2d1a0e]">{{ $tenant['leasePeriod'] }}</p>
        </div>
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Status</p>
            @if ($tenant['statusBadge'] === 'green')
                <span class="inline-block bg-green-100 text-green-800 text-[12px] font-semibold px-3 py-1 rounded-full">{{ $tenant['status'] }}</span>
            @elseif ($tenant['statusBadge'] === 'orange')
                <span class="inline-block bg-orange-100 text-orange-700 text-[12px] font-semibold px-3 py-1 rounded-full">{{ $tenant['status'] }}</span>
            @else
                <span class="inline-block bg-gray-100 text-gray-600 text-[12px] font-semibold px-3 py-1 rounded-full">{{ $tenant['status'] }}</span>
            @endif
        </div>
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Payment Status</p>
            <span class="text-[16px] {{ $tenant['paymentColor'] }} font-semibold inline-flex items-center gap-2">
                {!! $tenant['paymentIcon'] !!} {{ $tenant['payment'] }}
            </span>
        </div>
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Lease Remaining</p>
            <p class="text-[16px] {{ $tenant['leaseUrgency'] }} font-semibold">{{ $tenant['leaseRemaining'] }}</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 border-t border-[#ede7df] pt-6">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Email</p>
            <p class="text-[16px] font-semibold text-[#2d1a0e]">{{ $tenant['email'] ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Phone</p>
            <p class="text-[16px] font-semibold text-[#2d1a0e]">{{ $tenant['phone'] ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Occupants</p>
            <p class="text-[16px] font-semibold text-[#2d1a0e]">{{ $tenant['occupants'] ?? '1' }}</p>
        </div>
        <div class="md:col-span-2">
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Notes</p>
            <p class="text-[16px] font-semibold text-[#2d1a0e]">{{ $tenant['notes'] ?? 'No notes available.' }}</p>
        </div>
    </div>
</div>

@endsection