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
            <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center text-[18px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
</svg>
</div>
            <span class="text-[10px] font-semibold uppercase tracking-[0.09em] text-gray-400">Total Revenue</span>
        </div>
        <p class="text-[22px] font-bold text-[#2d1a0e]">₱{{ number_format($totalRevenue, 2) }}</p>
        <a href="{{ route('finances') }}"
           class="inline-flex items-center gap-1 text-[11px] text-[#7c3a1e] hover:text-[#5c2910] font-medium mt-1.5 transition-colors">
          
        </a>
    </div>

    {{-- Occupancy --}}
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-9 h-9 bg-orange-100 rounded-lg flex items-center justify-center text-[18px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
</svg>
</div>
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
            <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center text-[18px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
</svg>
</div>
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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
</svg>

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
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
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
