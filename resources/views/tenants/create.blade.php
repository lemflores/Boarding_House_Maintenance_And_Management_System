@extends('layouts.app')
@section('title', 'Add Tenant')

@section('content')

<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e]">Add New Tenant</h1>
        <p class="text-sm text-gray-500 mt-1">Create a tenant record to manage lease and payment details.</p>
    </div>
    <a href="{{ route('tenants') }}" class="inline-flex items-center gap-2 border border-[#e5e7eb] text-gray-500 text-[12px] md:text-[13px] font-medium px-4 py-2.5 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors">
        ← Back to Directory
    </a>
</div>

<div class="bg-white rounded-xl border border-[#ede7df] p-6">
    <form method="POST" action="{{ route('tenants.store') }}">
        @csrf
        @php $tenant = null; @endphp
        @include('tenants._form')
        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-[#7c3a1e] hover:bg-[#5c2910] text-white text-[12px] md:text-[13px] font-semibold px-4 py-2.5 rounded-lg transition-colors">
                Save Tenant
            </button>
            <a href="{{ route('tenants') }}" class="text-gray-500 text-[12px] font-medium hover:text-[#7c3a1e] transition-colors">Cancel</a>
        </div>
    </form>
</div>

@endsection
