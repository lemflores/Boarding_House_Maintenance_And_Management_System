@extends('layouts.app')
@section('title', 'Property Overview')

@section('content')

{{-- ── HERO BANNER ─────────────────────────────────────────────── --}}
<div class="relative rounded-2xl overflow-hidden mb-6 min-h-[130px] flex items-end"
     style="background: linear-gradient(100deg,rgba(50,22,8,.90) 0%,rgba(100,45,20,.80) 55%,rgba(130,70,35,.70) 100%)">
    <img src="https://images.unsplash.com/photo-1560185007-cde436f6a4d0?w=1000&auto=format&fit=crop&q=80"
         alt="" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-60">
    <div class="relative z-10 w-full flex items-center justify-between px-8 py-7">
        <div class="text-white">
            <h2 class="font-[Playfair_Display] text-[28px] font-bold leading-tight">Magandang Umaga.</h2>
            <p class="text-[12px] text-white/65 mt-0.5">NaVi Dormitory Management</p>
        </div>
        <div class="flex gap-8 text-white text-right">
            <div>
                <p class="text-[9px] uppercase tracking-[0.12em] text-white/55 font-semibold">Occupancy</p>
                <p class="text-[22px] font-bold mt-0.5">{{ $occupancyRate }}%</p>
            </div>
            <div>
                <p class="text-[9px] uppercase tracking-[0.12em] text-white/55 font-semibold">Active Rent</p>
                <p class="text-[22px] font-bold mt-0.5">{{ $totalUnits }}</p>
            </div>
        </div>
    </div>
</div>

{{-- ── STAT CARDS ───────────────────────────────────────────────── --}}
<div class="grid grid-cols-4 gap-4 mb-6">

    {{-- Revenue --}}
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center text-[18px]">💰</div>
            <span class="text-[10px] font-semibold uppercase tracking-[0.09em] text-gray-400">Total Revenue</span>
        </div>
        <p class="text-[22px] font-bold text-[#2d1a0e]">₱{{ number_format($totalRevenue, 2) }}</p>
        <a href="{{ route('finances') }}"
           class="inline-flex items-center gap-1 text-[11px] text-[#7c3a1e] hover:text-[#5c2910] font-medium mt-1.5 transition-colors">
            Export Ledger ↓
        </a>
    </div>

    {{-- Occupancy --}}
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-9 h-9 bg-orange-100 rounded-lg flex items-center justify-center text-[18px]">🏢</div>
            <span class="text-[10px] font-semibold uppercase tracking-[0.09em] text-gray-400">Occupancy</span>
        </div>
        <p class="text-[22px] font-bold text-[#2d1a0e]">
            {{ $occupiedUnits }}/{{ $totalUnits }}
            <span class="text-[15px] font-normal text-gray-400">({{ $occupancyRate }}%)</span>
        </p>
        <div class="mt-3 h-1.5 bg-[#ede7df] rounded-full overflow-hidden">
            <div class="h-full bg-[#7c3a1e] rounded-full" style="width:{{ $occupancyRate }}%"></div>
        </div>
    </div>

    {{-- Active Requests --}}
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center text-[18px]">🔧</div>
            <span class="text-[10px] font-semibold uppercase tracking-[0.09em] text-gray-400">Active Requests</span>
        </div>
        <p class="text-[22px] font-bold text-[#2d1a0e]">{{ $pendingRequests }} Pending</p>
        <p class="text-[11px] text-gray-400 mt-1">{{ $inProgressRequests }} In Progress &nbsp;·&nbsp; {{ $resolvedRequests }} Resolved</p>
    </div>

    {{-- Onboarding --}}
    <div class="bg-[#1e3a1e] rounded-xl p-5 text-white">
        <p class="text-[9px] font-semibold uppercase tracking-[0.12em] text-green-300/70 mb-2">Onboarding</p>
        <p class="font-[Playfair_Display] text-[22px] font-bold leading-tight">{{ $newApplicants }} New<br>Applicants</p>
        <p class="text-[11px] text-white/50 mt-1 mb-3">Awaiting for Approval</p>
        <button class="bg-[#6fcf4a] hover:bg-[#5ab83a] text-[#1a3310] text-[11px] font-bold px-4 py-1.5 rounded-full transition-colors">
            Review Queue
        </button>
    </div>
</div>

{{-- ── BOTTOM ROW ───────────────────────────────────────────────── --}}
<div class="grid grid-cols-3 gap-6">

    {{-- Priority Maintenance --}}
    <div class="col-span-2">
        <h3 class="text-[15px] font-bold text-[#2d1a0e] mb-4">Priority Maintenance</h3>
        <div class="space-y-3">
            @foreach ($maintenanceItems as $item)
            <div class="bg-white rounded-xl border border-[#ede7df] p-4 flex items-center gap-3.5">
                <div class="w-10 h-10 {{ $item['iconBg'] }} rounded-xl flex items-center justify-center text-[18px] flex-shrink-0">
                    {{ $item['icon'] }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-[13px] font-semibold text-[#2d1a0e]">{{ $item['title'] }}</span>
                        @if ($item['priority'] === 'high')
                            <span class="bg-red-100 text-red-700 text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">High Priority</span>
                        @endif
                    </div>
                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $item['meta'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Activity Log --}}
    <div>
        <h3 class="text-[15px] font-bold text-[#2d1a0e] mb-4">Activity Log</h3>
        <div class="space-y-4">
            @foreach ($activityLog as $log)
            <div class="flex gap-3 items-start">
                <div class="w-2.5 h-2.5 rounded-full mt-[3px] flex-shrink-0 {{ $log['dotColor'] }}"></div>
                <div>
                    <p class="text-[13px] font-semibold text-[#2d1a0e] leading-tight">{{ $log['title'] }}</p>
                    <p class="text-[11px] text-gray-400 mt-0.5 leading-snug">{{ $log['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <a href="#" class="inline-block text-[12px] text-[#7c3a1e] hover:text-[#5c2910] font-semibold mt-5 transition-colors">
            View All Activity
        </a>
    </div>
</div>

{{-- ── FOOTER ───────────────────────────────────────────────────── --}}
<footer class="mt-12 pt-5 border-t border-[#ede7df] flex flex-wrap items-center justify-between gap-3">
    <span class="text-[11px] text-gray-300">© 2021 NaVi Boarding House Management. All rights reserved.</span>
    <div class="flex items-center gap-5 text-[11px] text-gray-300">
        <a href="#" class="hover:text-[#7c3a1e] transition-colors">Internal Guidelines</a>
        <a href="#" class="hover:text-[#7c3a1e] transition-colors">Privacy Policy</a>
        <a href="#" class="hover:text-[#7c3a1e] transition-colors">Staff Support</a>
    </div>
</footer>

@endsection
