@extends('layouts.app')
@section('title', 'Maintenance Board')

@section('content')

{{-- ── HEADER ──────────────────────────────────────────────────── --}}
<h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e] mb-6">Maintenance Board</h1>

{{-- ── CONTENT GRID ─────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT: Toolbar + Table --}}
    <div class="col-span-1 lg:col-span-2 space-y-4">

        {{-- Toolbar --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
            <div class="flex items-center gap-2 bg-white border border-[#ede7df] rounded-lg px-3.5 py-2 text-[12px] sm:text-[13px] text-[#2d1a0e] font-medium whitespace-nowrap w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
</svg>
 May 2026
            </div>

            <div class="relative flex-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[13px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
</svg>
</span>
                <input type="text" placeholder="  Search logs..."
                       class="w-full pl-8 pr-4 py-2 border border-[#e5e7eb] rounded-lg text-[12px] outline-none focus:border-[#7c3a1e] transition-colors bg-white text-gray-600">
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl border border-[#ede7df] overflow-x-auto">
            <table class="w-full min-w-max">
                <thead class="bg-[#faf7f4]">
                    <tr>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3">Reference ID</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3">Subject / Issue</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3 hidden md:table-cell">Location / Unit</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3 hidden lg:table-cell">Assigned To</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3 hidden md:table-cell">Priority</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3">Status</th>
                        <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3 hidden md:table-cell">Reported</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                    <tr class="border-t border-[#f0ebe5] hover:bg-[#faf7f4] transition-colors">
                        <td class="px-4 py-3.5 font-mono text-[11px] text-gray-400">{{ $ticket['ref'] }}</td>
                        <td class="px-4 py-3.5 text-[13px] font-semibold text-[#2d1a0e]">{{ $ticket['subject'] }}</td>
                        <td class="px-4 py-3.5">
                            <span class="text-[11px] text-gray-400 mr-0.5"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
</svg>
</span>
                            <span class="text-[12px] text-gray-500">{{ $ticket['location'] }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            @if ($ticket['assigned'])
                                <div class="w-7 h-7 rounded-full bg-[#7c3a1e] flex items-center justify-center text-white text-[9px] font-bold">
                                    {{ $ticket['assignedInitials'] }}
                                </div>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-[10px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>
</div>
                                    <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wide">Unassigned</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3.5">
                            @if ($ticket['priority'] === 'URGENT')
                                <span class="inline-block bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Urgent</span>
                            @elseif ($ticket['priority'] === 'NORMAL')
                                <span class="inline-block bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Normal</span>
                            @else
                                <span class="inline-block bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Medium</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5">
                            @if ($ticket['status'] === 'NEW')
                                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                                    New
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-orange-50 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase whitespace-nowrap">
                                    In Progress
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-[11px] text-gray-400 whitespace-nowrap">{{ $ticket['reported'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- RIGHT: Priority card + Summary --}}
    <div class="space-y-4">

        {{-- Priority label --}}
        <h3 class="text-[13px] font-bold text-[#2d1a0e]">Priority Maintenance</h3>

        {{-- Priority Card --}}
        <div class="bg-white rounded-xl border border-[#ede7df] p-4">
            <div class="flex items-start gap-3">
                <div class="w-11 h-11 bg-red-100 rounded-xl flex items-center justify-center text-[20px] flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
</svg>
</div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start gap-2 flex-wrap">
                        <span class="text-[13px] font-bold text-[#2d1a0e] leading-snug">Unit 103 – Air Conditioning Leak</span>
                        <span class="bg-red-100 text-red-700 text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wide whitespace-nowrap">High Priority</span>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Reported by Resident · 1h ago</p>
                </div>
            </div>
        </div>

        {{-- Summary Stats --}}
        <div class="bg-white rounded-xl border border-[#ede7df] p-5">
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-4">Summary</p>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">Open Tickets</span>
                    <span class="text-[13px] font-bold text-[#2d1a0e]">{{ $openTickets }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">In Progress</span>
                    <span class="text-[13px] font-bold text-orange-600">{{ $inProgressTickets }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">Resolved This Month</span>
                    <span class="text-[13px] font-bold text-green-600">{{ $resolvedTickets }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">Unassigned</span>
                    <span class="text-[13px] font-bold text-red-600">{{ $unassignedTickets }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
