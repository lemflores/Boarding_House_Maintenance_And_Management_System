@extends('layouts.app')
@section('title', 'Payment Ledger')

@section('content')

{{-- ── HEADER ──────────────────────────────────────────────────── --}}
<h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e] mb-6">Payment Ledger</h1>

{{-- ── FLASH MESSAGES ──────────────────────────────────────────── --}}
@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126c-.866 1.5-.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126Z" />
        </svg>
        <span class="text-sm font-medium">{{ session('error') }}</span>
    </div>
@endif

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
            <a href="{{ route('finances', array_merge(['filter' => 'all'], $request->only('search'))) }}" class="{{ $currentFilter === 'all' ? 'bg-[#2d1a0e] text-white' : 'text-gray-500 hover:bg-[#faf7f4]' }} text-[11px] md:text-[12px] font-semibold px-3 md:px-4 py-1.5 rounded-lg transition-colors">All Transactions</a>
            <a href="{{ route('finances', array_merge(['filter' => 'pending'], $request->only('search'))) }}" class="{{ $currentFilter === 'pending' ? 'bg-[#2d1a0e] text-white' : 'text-gray-500 hover:bg-[#faf7f4]' }} text-[11px] md:text-[12px] font-medium px-3 md:px-4 py-1.5 rounded-lg transition-colors">Pending</a>
            <a href="{{ route('finances', array_merge(['filter' => 'overdue'], $request->only('search'))) }}" class="{{ $currentFilter === 'overdue' ? 'bg-[#2d1a0e] text-white' : 'text-gray-500 hover:bg-[#faf7f4]' }} text-[11px] md:text-[12px] font-medium px-3 md:px-4 py-1.5 rounded-lg transition-colors">Overdue</a>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('finances.create') }}" class="bg-[#7c3a1e] hover:bg-[#5a2a15] text-white text-[12px] font-semibold px-4 py-2 rounded-lg transition-colors">
                Add Payment
            </a>
            <form method="GET" action="{{ route('finances') }}" class="flex">
                @if($currentFilter !== 'all')
                    <input type="hidden" name="filter" value="{{ $currentFilter }}">
                @endif
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[13px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
</svg>
</span>
                    <input type="text" name="search" value="{{ $request->get('search') }}" placeholder=" Search tenant or unit..."
                           class="pl-8 pr-4 py-2 border border-[#e5e7eb] rounded-lg text-[12px] outline-none focus:border-[#7c3a1e] transition-colors w-full md:w-60 bg-white text-gray-600">
                </div>
            </form>
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
                    @if ($txn['tenantStatus'] === 'Paid')
                        <span class="inline-block bg-green-100 text-green-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">Paid</span>
                    @elseif ($txn['tenantStatus'] === 'Overdue')
                        <span class="inline-block bg-red-600 text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full">Overdue</span>
                    @else
                        <span class="inline-block bg-blue-100 text-blue-700 text-[11px] font-bold px-2.5 py-0.5 rounded-full">Pending</span>
                    @endif
                </td>
                <td class="px-4 py-4">
                    <div class="flex items-center gap-2">
                        @if ($txn['status'] === 'OVERDUE')
                            <form method="POST" action="{{ route('finances.notify', $txn['id']) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-orange-600 transition-colors p-1" title="Notify Tenant">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A6.375 6.375 0 0110.5 1.5H6.375A6.375 6.375 0 003.124 7.5z" />
                                    </svg>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('finances.mark-paid', $txn['id']) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-green-600 transition-colors p-1" title="Mark as Paid">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </form>
                        @elseif ($txn['status'] === 'PENDING')
                            <form method="POST" action="{{ route('finances.mark-paid', $txn['id']) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-green-600 transition-colors p-1" title="Mark as Paid">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </form>
                        @elseif ($txn['status'] === 'PAID')
                            <span class="text-gray-400 text-[11px]">Paid</span>
                        @endif
                        <form method="POST" action="{{ route('finances.destroy', $txn['id']) }}" onsubmit="return confirm('Are you sure you want to delete this payment record?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors p-1" title="Delete Payment">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 2.98a1.125 1.125 0 00-2.228-.015L9.591 5.6M5.106 5.4A2.625 2.625 0 103.675 3.98m0 13.621a8.002 8.002 0 01-5.022-2.478A8.002 8.002 0 015.106 19.02M19.5 9.5c0 .828-.672 1.5-1.5 1.5s-1.5-.672-1.5-1.5.672-1.5 1.5-1.5 1.5.672 1.5 1.5z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    {{-- Pagination --}}
    <div class="flex items-center justify-between px-6 py-4 border-t border-[#ede7df]">
        <p class="text-[12px] text-gray-400">Showing {{ count($transactions) }} transactions</p>
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
