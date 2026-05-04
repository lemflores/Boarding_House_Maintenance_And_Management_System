@extends('layouts.app')
@section('title', 'Payment Ledger')

@section('content')

{{-- ── HEADER ──────────────────────────────────────────────────── --}}
<h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e] mb-6">Payment Ledger</h1>

{{-- ── TOP STAT CARDS ───────────────────────────────────────────── --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4 mb-7">
    <div class="bg-[#7c3a1e] rounded-xl p-5 text-white">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-white/60 mb-2">Total Collections</p>
        <p class="text-[24px] md:text-[28px] font-bold leading-none">₱{{ number_format($totalCollections, 2) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Settled Units</p>
        <p class="text-[24px] md:text-[28px] font-bold text-[#2d1a0e] leading-none">{{ $settledUnits }}/{{ $totalUnits }}</p>
    </div>
    <div class="bg-red-50 rounded-xl p-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-red-600 mb-1">Due / Overdue Amount</p>
        <p class="text-[24px] md:text-[28px] font-bold text-red-600 leading-none">₱{{ number_format($overdueAmount, 2) }}</p>
    </div>
</div>

{{-- ── TABLE CARD ───────────────────────────────────────────────── --}}
<div class="bg-white rounded-xl border border-[#ede7df] overflow-hidden">

    {{-- Tabs + Search --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 px-4 md:px-6 py-4 border-b border-[#ede7df]">
        <div class="flex gap-1 w-full sm:w-auto flex-wrap">
            <button class="bg-[#2d1a0e] text-white text-[11px] md:text-[12px] font-semibold px-3 md:px-4 py-1.5 rounded-lg">All Transactions</button>
            <button class="text-gray-500 text-[11px] md:text-[12px] font-medium px-3 md:px-4 py-1.5 rounded-lg hover:bg-[#faf7f4] transition-colors">Pending</button>
            <button class="text-gray-500 text-[11px] md:text-[12px] font-medium px-3 md:px-4 py-1.5 rounded-lg hover:bg-[#faf7f4] transition-colors">Overdue</button>
        </div>
        <div class="relative w-full sm:w-auto">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[13px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
</svg>
</span>
            <input type="text" placeholder=" Search tenant or unit..."
                   class="pl-8 pr-4 py-2 border border-[#e5e7eb] rounded-lg text-[12px] outline-none focus:border-[#7c3a1e] transition-colors w-full md:w-60 bg-white text-gray-600">
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
    <table class="w-full min-w-max">
        <thead class="bg-[#faf7f4]">
            <tr>
                <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-3 md:px-6 py-3">Tenant Details</th>
                <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3 hidden sm:table-cell">Unit</th>
                <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3 hidden md:table-cell">Scheduled Date</th>
                <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3">Amount</th>
                <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3">Status</th>
                <th class="text-left text-[9px] md:text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-2 md:px-4 py-3 hidden sm:table-cell">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $txn)
            <tr class="border-t border-[#f0ebe5] hover:bg-[#faf7f4] transition-colors">
                <td class="px-3 md:px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0"
                             style="background-color:{{ $txn['color'] }}">
                            {{ $txn['initials'] }}
                        </div>
                        <span class="text-[13px] font-semibold text-[#2d1a0e]">{{ $txn['name'] }}</span>
                    </div>
                </td>
                <td class="px-4 py-4 text-[13px] text-gray-500">{{ $txn['unit'] }}</td>
                <td class="px-4 py-4 text-[13px] text-gray-500">{{ $txn['date'] }}</td>
                <td class="px-4 py-4 text-[13px] font-semibold text-[#2d1a0e]">₱{{ number_format($txn['amount'], 2) }}</td>
                <td class="px-4 py-4">
                    @if ($txn['status'] === 'PAID')
                        <span class="inline-block bg-green-100 text-green-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">PAID</span>
                    @elseif ($txn['status'] === 'OVERDUE')
                        <span class="inline-block bg-red-600 text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full">OVERDUE</span>
                    @else
                        <span class="inline-block bg-gray-100 text-gray-500 text-[11px] font-bold px-2.5 py-0.5 rounded-full">PENDING</span>
                    @endif
                </td>
                <td class="px-4 py-4">
                    @if ($txn['status'] === 'OVERDUE')
                        <button class="bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition-colors whitespace-nowrap">
                            Notify Tenant
                        </button>
                    @else
                        <button class="text-gray-300 hover:text-gray-500 text-xl px-1 transition-colors">⋮</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-between px-6 py-4 border-t border-[#ede7df]">
        <p class="text-[12px] text-gray-400">Showing 1–{{ count($transactions) }} of 26 transactions</p>
        <div class="flex items-center gap-1.5">
            <button class="w-7 h-7 rounded-lg border border-[#e5e7eb] text-gray-400 text-[13px] hover:border-[#7c3a1e] transition-colors flex items-center justify-center">‹</button>
            <button class="w-7 h-7 rounded-lg bg-[#7c3a1e] text-white text-[12px] font-bold">1</button>
            <button class="w-7 h-7 rounded-lg border border-[#e5e7eb] text-gray-500 text-[12px] hover:border-[#7c3a1e] transition-colors">2</button>
            <span class="text-gray-300 text-[12px] px-0.5">…</span>
            <button class="w-7 h-7 rounded-lg border border-[#e5e7eb] text-gray-500 text-[12px] hover:border-[#7c3a1e] transition-colors">6</button>
            <button class="w-7 h-7 rounded-lg border border-[#e5e7eb] text-gray-400 text-[13px] hover:border-[#7c3a1e] transition-colors flex items-center justify-center">›</button>
        </div>
    </div>
</div>

@endsection
