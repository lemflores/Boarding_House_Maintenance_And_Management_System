@extends('layouts.app')
@section('title', 'Room Status')

@section('content')

{{-- ── HEADER ──────────────────────────────────────────────────── --}}
<div class="flex items-start justify-between mb-1">
    <div>
        <h1 class="font-[Playfair_Display] text-[32px] font-bold text-[#2d1a0e]">Room Status</h1>
        <p class="text-[12px] text-gray-400 mt-0.5">Floor and Available Room Status</p>
    </div>
    <div class="flex gap-2 mt-2">
        <button class="bg-[#7c3a1e] text-white text-[13px] font-semibold px-4 py-2 rounded-lg hover:bg-[#5c2910] transition-colors">
            Grid View
        </button>
        <button class="border border-[#e5e7eb] bg-white text-gray-500 text-[13px] font-medium px-4 py-2 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors">
            Floor Plan
        </button>
    </div>
</div>

{{-- ── SUMMARY CARDS ────────────────────────────────────────────── --}}
<div class="grid grid-cols-4 gap-4 mt-5 mb-6">
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Total Units</p>
        <p class="text-[34px] font-bold text-[#2d1a0e] leading-none">{{ $totalUnits }}</p>
    </div>
    <div class="bg-[#7c3a1e] rounded-xl p-5 text-white">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-white/60 mb-2">Occupied</p>
        <p class="text-[34px] font-bold leading-none">{{ $occupied }}</p>
    </div>
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Vacant</p>
        <p class="text-[34px] font-bold text-[#2d1a0e] leading-none">{{ sprintf('%02d', $vacant) }}</p>
    </div>
    <div class="bg-red-50 rounded-xl p-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-red-600 mb-2">Maintenance</p>
        <p class="text-[34px] font-bold text-red-600 leading-none">{{ sprintf('%02d', $maintenance) }}</p>
    </div>
</div>

{{-- ── FLOOR FILTER + ROOM GRID ─────────────────────────────────── --}}
<div class="grid grid-cols-4 gap-6">

    {{-- Floor Filter --}}
    <div>
        <h3 class="text-[13px] font-bold text-[#2d1a0e] mb-3">Floor Filter</h3>
        <div class="space-y-2 mb-6">
            @foreach ($floors as $floor)
            <button class="w-full flex items-center justify-between rounded-lg px-3.5 py-2.5 text-[13px] font-semibold transition-colors
                {{ $floor['active']
                    ? 'bg-red-50 text-red-600 border border-red-200'
                    : 'bg-white border border-[#ede7df] text-gray-500 hover:border-[#7c3a1e]' }}">
                <span>{{ $floor['label'] }}</span>
                <span class="{{ $floor['active'] ? 'text-red-400 text-base' : 'text-[11px] font-normal text-gray-400' }}">
                    {{ $floor['active'] ? '›' : $floor['count'].' Units' }}
                </span>
            </button>
            @endforeach
        </div>

        <h3 class="text-[13px] font-bold text-[#2d1a0e] mb-3">Status Legend</h3>
        <div class="space-y-2.5">
            <div class="flex items-center gap-2 text-[12px] text-gray-500">
                <div class="w-2.5 h-2.5 rounded-full bg-[#7c3a1e]"></div> Occupied
            </div>
            <div class="flex items-center gap-2 text-[12px] text-gray-500">
                <div class="w-2.5 h-2.5 rounded-full bg-gray-300"></div> Available
            </div>
            <div class="flex items-center gap-2 text-[12px] text-gray-500">
                <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div> Repair Required
            </div>
        </div>
    </div>

    {{-- Room Grid --}}
    <div class="col-span-3">
        <div class="grid grid-cols-4 gap-3">
            @foreach ($rooms as $room)
            <div class="bg-white rounded-xl border border-[#ede7df] p-3.5 hover:shadow-md transition-shadow
                {{ $room['status'] === 'occupied' ? 'border-t-[3px] border-t-[#7c3a1e]' : ($room['status'] === 'repair' ? 'border-t-[3px] border-t-red-500' : 'border-t-[3px] border-t-gray-300') }}">

                <div class="flex items-center justify-between mb-2">
                    <span class="text-[15px] font-bold text-[#2d1a0e]">{{ $room['number'] }}</span>
                    @if ($room['status'] === 'occupied')
                        <span class="bg-gray-100 text-gray-500 text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">Occupied</span>
                    @elseif ($room['status'] === 'vacant')
                        <span class="bg-blue-50 text-blue-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">Vacant</span>
                    @else
                        <span class="bg-red-100 text-red-600 text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">Repair</span>
                    @endif
                </div>

                @if ($room['status'] === 'occupied')
                    <p class="text-[11px] text-gray-400 uppercase font-semibold tracking-wide mb-0.5">Tenant</p>
                    <p class="text-[12px] font-semibold text-[#2d1a0e]">{{ $room['tenant'] }}</p>
                @elseif ($room['status'] === 'vacant')
                    <p class="text-[11px] text-gray-400 uppercase font-semibold tracking-wide mb-0.5">Availability</p>
                    <p class="text-[12px] text-gray-500">{{ $room['note'] }}</p>
                @else
                    <p class="text-[11px] text-gray-400 uppercase font-semibold tracking-wide mb-0.5">Issue</p>
                    <p class="text-[12px] font-semibold text-red-600">{{ $room['issue'] }}</p>
                    @if (!empty($room['subNote']))
                        <p class="text-[10px] text-orange-500 mt-1">{{ $room['subNote'] }}</p>
                    @endif
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
