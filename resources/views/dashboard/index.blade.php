@extends('layouts.app')
@section('title', 'Property Overview')

@section('content')

{{-- ── HERO BANNER ─────────────────────────────────────────────── --}}
<div class="relative rounded-2xl overflow-hidden mb-6 min-h-[100px] md:min-h-[130px] flex items-end"
     style="background: linear-gradient(100deg,rgba(50,22,8,.90) 0%,rgba(100,45,20,.80) 55%,rgba(130,70,35,.70) 100%)">
    <img src="https://images.unsplash.com/photo-1560185007-cde436f6a4d0?w=1000&auto=format&fit=crop&q=80"
         alt="" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-60">
    <div class="relative z-10 w-full flex flex-col md:flex-row items-start md:items-center justify-between px-4 md:px-8 py-5 md:py-7 gap-4">
        <div class="text-white">
            <h2 class="font-[Playfair_Display] text-[22px] md:text-[28px] font-bold leading-tight">Magandang Umaga.</h2>
            <p class="text-[11px] md:text-[12px] text-white/65 mt-0.5">NaVi Dormitory Management</p>
        </div>
        <div class="flex gap-4 md:gap-8 text-white text-right">
            <div>
                <p class="text-[8px] md:text-[9px] uppercase tracking-[0.12em] text-white/55 font-semibold">Occupancy</p>
                <p class="text-[18px] md:text-[22px] font-bold mt-0.5">{{ $occupancyRate }}%</p>
            </div>
            <div>
                <p class="text-[8px] md:text-[9px] uppercase tracking-[0.12em] text-white/55 font-semibold">Active Rent</p>
                <p class="text-[18px] md:text-[22px] font-bold mt-0.5">{{ $activeRent }}</p>
            </div>
        </div>
    </div>
</div>

@if (session('success') || session('activity_cleared'))
    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
        {{ session('success') ?: session('activity_cleared') }}
    </div>
@endif

{{-- ── STAT CARDS ───────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 mb-6">

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
            View Ledger
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
        <a href="{{ route('maintenance') }}" class="inline-flex items-center gap-1 text-[11px] text-[#7c3a1e] hover:text-[#5c2910] font-medium mt-3 transition-colors">
            View Requests
        </a>
    </div>
</div>

{{-- ── BOTTOM ROW ───────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Tenant Notifications --}}
    <div class="col-span-1 lg:col-span-2">
        @if($expiredTenants->count() > 0 || $almostExpiredTenants->count() > 0)
        <div class="mb-6">
            <h3 class="text-[15px] font-bold text-[#2d1a0e] mb-4">Tenant Lease Alerts</h3>
            <div class="space-y-3">
                {{-- Expired Tenants --}}
                @foreach ($expiredTenants as $tenant)
                <div class="bg-red-50 rounded-xl border border-red-200 p-4 flex items-start gap-3.5">
                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-red-600 flex-shrink-0 font-bold text-sm">
                        {{ substr($tenant->name, 0, 1) }}{{ substr($tenant->name, strpos($tenant->name, ' ') + 1, 1) ?? '' }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13px] font-semibold text-red-800">{{ $tenant->name }} - {{ $tenant->unit }}</span>
                            <span class="bg-red-200 text-red-800 text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">EXPIRED</span>
                        </div>
                        <p class="text-[11px] text-red-600 mt-0.5">Lease ended on {{ $tenant->lease_end->format('M d, Y') }}</p>
                    </div>
                </div>
                @endforeach

                {{-- Almost Expired Tenants --}}
                @foreach ($almostExpiredTenants as $tenant)
                <div class="bg-orange-50 rounded-xl border border-orange-200 p-4 flex items-start gap-3.5">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600 flex-shrink-0 font-bold text-sm">
                        {{ substr($tenant->name, 0, 1) }}{{ substr($tenant->name, strpos($tenant->name, ' ') + 1, 1) ?? '' }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13px] font-semibold text-orange-800">{{ $tenant->name }} - {{ $tenant->unit }}</span>
                            <span class="bg-orange-200 text-orange-800 text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">EXPIRING SOON</span>
                        </div>
                        <p class="text-[11px] text-orange-600 mt-0.5">Lease expires in {{ now()->diffInDays($tenant->lease_end) }} days ({{ $tenant->lease_end->format('M d, Y') }})</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    {{-- Priority Maintenance --}}
    <div>
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
    </div>

    {{-- Activity Log --}}
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <h3 class="text-[15px] font-bold text-[#2d1a0e] mb-4">Activity Log</h3>
        <div class="space-y-4">
            @forelse ($activityLog as $log)
            <div class="flex gap-3 items-start">
                <div class="w-2.5 h-2.5 rounded-full mt-[3px] flex-shrink-0 {{ $log['dotColor'] }}"></div>
                <div>
                    <p class="text-[13px] font-semibold text-[#2d1a0e] leading-tight">{{ $log['title'] }}</p>
                    <p class="text-[11px] text-gray-400 mt-0.5 leading-snug">{{ $log['desc'] }}</p>
                </div>
            </div>
            @empty
            <div class="text-[12px] text-gray-500">No recent activity available.</div>
            @endforelse
        </div>
        <div class="flex items-center justify-between mt-5">
            <a href="{{ route('finances') }}" class="inline-block text-[12px] text-[#7c3a1e] hover:text-[#5c2910] font-semibold transition-colors">
                View All Activity
            </a>
            <form method="POST" action="{{ route('dashboard.clear-activity') }}" class="inline" onsubmit="return confirm('Are you sure you want to clear the activity log?');">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1 text-[12px] text-gray-400 hover:text-red-500 font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 2.98a1.125 1.125 0 00-2.228-.015L9.591 5.6M5.106 5.4A2.625 2.625 0 103.675 3.98m0 13.621a8.002 8.002 0 01-5.022-2.478A8.002 8.002 0 015.106 19.02M19.5 9.5c0 .828-.672 1.5-1.5 1.5s-1.5-.672-1.5-1.5.672-1.5 1.5-1.5 1.5.672 1.5 1.5z" />
                    </svg>
                    Clear Log
                </button>
            </form>
        </div>
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
