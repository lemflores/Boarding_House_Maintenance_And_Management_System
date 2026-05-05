@extends('layouts.app')
@section('title', 'Tenant Directory')

@section('content')

{{-- ── HEADER ──────────────────────────────────────────────────── --}}
<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-7">
    <h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e]">Tenant Directory</h1>
    <button class="inline-flex items-center gap-2 bg-[#7c3a1e] hover:bg-[#5c2910] text-white text-[12px] md:text-[13px] font-semibold px-4 py-2.5 rounded-lg transition-colors shadow w-full md:w-auto justify-center md:justify-start">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
</svg>
Add New Tenant
    </button>
</div>

{{-- ── STAT CARDS ───────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4 mb-7">
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Total Residents</p>
        <p class="text-[34px] font-bold text-[#2d1a0e] leading-none">{{ $totalResidents }}</p>
    </div>
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Active Leases</p>
        <p class="text-[34px] font-bold text-[#2d1a0e] leading-none">{{ $activeLeases }}</p>
        <p class="text-[11px] text-orange-600 mt-2">⏱ {{ $expiringLeases }} expiring soon</p>
    </div>
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Occupancy Rate</p>
        <p class="text-[34px] font-bold text-[#2d1a0e] leading-none">{{ $occupancyRate }}%</p>
        <div class="mt-3 h-1.5 bg-[#ede7df] rounded-full overflow-hidden">
            <div class="h-full bg-[#7c3a1e] rounded-full" style="width:{{ $occupancyRate }}%"></div>
        </div>
    </div>
</div>

{{-- ── TABLE CARD ───────────────────────────────────────────────── --}}
<div class="bg-white rounded-xl border border-[#ede7df] overflow-hidden">

    {{-- Tabs + Search --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 px-4 md:px-6 py-4 border-b border-[#ede7df]">
        <div class="flex gap-1 w-full sm:w-auto flex-wrap">
            <a href="{{ route('tenants', ['filter' => 'all']) }}" class="{{ $currentFilter === 'all' ? 'bg-[#2d1a0e] text-white' : 'text-gray-500 hover:bg-[#faf7f4]' }} text-[11px] md:text-[12px] font-semibold px-3 md:px-4 py-1.5 rounded-lg transition-colors">All Tenants</a>
            <a href="{{ route('tenants', ['filter' => 'active']) }}" class="{{ $currentFilter === 'active' ? 'bg-[#2d1a0e] text-white' : 'text-gray-500 hover:bg-[#faf7f4]' }} text-[11px] md:text-[12px] font-medium px-3 md:px-4 py-1.5 rounded-lg transition-colors">Active</a>
            <a href="{{ route('tenants', ['filter' => 'renewal sent']) }}" class="{{ $currentFilter === 'renewal sent' ? 'bg-[#2d1a0e] text-white' : 'text-gray-500 hover:bg-[#faf7f4]' }} text-[11px] md:text-[12px] font-medium px-3 md:px-4 py-1.5 rounded-lg transition-colors">Renewal Sent</a>
        </div>
        <form method="GET" action="{{ route('tenants') }}" class="w-full sm:w-auto">
            <div class="relative w-full max-w-[320px]">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[13px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
</svg>
</span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder=" Search tenants..."
                       class="pl-8 pr-4 py-2 border border-[#e5e7eb] rounded-lg text-[12px] text-gray-600 outline-none focus:border-[#7c3a1e] transition-colors w-full bg-white">
                <input type="hidden" name="filter" value="{{ $currentFilter }}">
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full min-w-[720px]">
            <thead class="bg-[#faf7f4]">
            <tr>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-6 py-3">Tenant</th>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Unit</th>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Lease Period</th>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Status</th>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Payment</th>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tenants as $tenant)
            <tr class="border-t border-[#f0ebe5] hover:bg-[#faf7f4] transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0"
                             style="background-color:{{ $tenant['color'] }}">
                            {{ $tenant['initials'] }}
                        </div>
                        <a href="{{ route('tenants.show', $tenant['id']) }}" class="text-[13px] font-semibold text-[#2d1a0e] hover:text-[#7c3a1e] transition-colors">{{ $tenant['name'] }}</a>
                    </div>
                </td>
                <td class="px-4 py-4 text-[13px] text-gray-500">{{ $tenant['unit'] }}</td>
                <td class="px-4 py-4">
                    <p class="text-[13px] text-gray-700">{{ $tenant['leasePeriod'] }}</p>
                    <p class="text-[11px] {{ $tenant['leaseUrgency'] }} mt-0.5 uppercase tracking-wide font-medium">{{ $tenant['leaseRemaining'] }}</p>
                </td>
                <td class="px-4 py-4">
                    @if ($tenant['statusBadge'] === 'green')
                        <span class="inline-block bg-green-100 text-green-800 text-[11px] font-semibold px-2.5 py-0.5 rounded-full">{{ $tenant['status'] }}</span>
                    @elseif ($tenant['statusBadge'] === 'orange')
                        <span class="inline-block bg-orange-100 text-orange-700 text-[11px] font-semibold px-2.5 py-0.5 rounded-full">{{ $tenant['status'] }}</span>
                    @else
                        <span class="inline-block bg-gray-100 text-gray-600 text-[11px] font-semibold px-2.5 py-0.5 rounded-full">{{ $tenant['status'] }}</span>
                    @endif
                </td>
                <td class="px-4 py-4">
                    <span class="text-[13px] {{ $tenant['paymentColor'] }} font-medium inline-flex items-center gap-1">
                        {!! $tenant['paymentIcon'] !!} {{ $tenant['payment'] }}
                    </span>
                </td>
                <td class="px-4 py-4">
                    <div class="relative">
                        <button class="text-gray-300 hover:text-gray-500 text-xl leading-none px-1 transition-colors" onclick="toggleDropdown({{ $tenant['id'] }})">⋮</button>
                        <div id="dropdown-{{ $tenant['id'] }}" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden">
                            <div class="py-1">
                                <a href="{{ route('tenants.show', $tenant['id']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Details</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Tenant</a>
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Delete Tenant</a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-between px-6 py-4 border-t border-[#ede7df]">
        <button class="inline-flex items-center gap-1 border border-[#e5e7eb] text-gray-500 text-[12px] font-medium px-4 py-1.5 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors bg-white">
            ← Previous
        </button>
        <div class="flex items-center gap-1.5">
            <button class="w-8 h-8 rounded-lg bg-[#7c3a1e] text-white text-[12px] font-bold">1</button>
            <button class="w-8 h-8 rounded-lg border border-[#e5e7eb] text-gray-500 text-[12px] hover:border-[#7c3a1e] transition-colors">2</button>
            <button class="w-8 h-8 rounded-lg border border-[#e5e7eb] text-gray-500 text-[12px] hover:border-[#7c3a1e] transition-colors">3</button>
            <span class="text-gray-300 text-[12px] px-1">…</span>
            <button class="w-8 h-8 rounded-lg border border-[#e5e7eb] text-gray-500 text-[12px] hover:border-[#7c3a1e] transition-colors">12</button>
        </div>
        <button class="inline-flex items-center gap-1 border border-[#e5e7eb] text-gray-500 text-[12px] font-medium px-4 py-1.5 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors bg-white">
            Next →
        </button>
    </div>
</div>

@endsection

<script>
function toggleDropdown(id) {
    const dropdown = document.getElementById('dropdown-' + id);
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.relative')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});
</script>
