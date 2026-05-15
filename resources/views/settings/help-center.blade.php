@extends('layouts.app')
@section('title', 'Help Center')

@section('content')

{{-- ── HEADER ──────────────────────────────────────────────────── --}}
<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e]">Help Center</h1>
        <p class="text-sm text-gray-500 mt-1">Find answers to common questions and get support.</p>
    </div>
    <a href="{{ route('settings.index') }}" class="inline-flex items-center gap-2 border border-[#e5e7eb] text-gray-500 text-[12px] md:text-[13px] font-medium px-4 py-2.5 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors">
        ← Back to Settings
    </a>
</div>

{{-- Search Bar --}}
<div class="mb-8">
    <div class="relative max-w-2xl">
        <input type="text" id="helpSearch" placeholder="Search help articles..."
               class="w-full px-4 py-3 border border-[#e5e7eb] rounded-lg text-[14px] outline-none focus:border-[#7c3a1e] transition-colors bg-white">
        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
</svg>
</span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Getting Started --}}
    <div class="bg-white rounded-xl border border-[#ede7df] p-6">
        <h2 class="text-[18px] font-bold text-[#2d1a0e] mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#7c3a1e]">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09l-.813 2.846z" />
</svg>
            Getting Started
        </h2>
        <ul class="space-y-3">
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'how-to-log-in') }}" class="text-[#7c3a1e] hover:underline font-medium">How to log in to my account</a>
                <p class="text-gray-500 text-[12px] mt-1">Step-by-step guide to access your boarding house management dashboard.</p>
            </li>
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'creating-your-first-tenant-profile') }}" class="text-[#7c3a1e] hover:underline font-medium">Creating your first tenant profile</a>
                <p class="text-gray-500 text-[12px] mt-1">Learn how to add new tenants to your system.</p>
            </li>
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'setting-up-payment-tracking') }}" class="text-[#7c3a1e] hover:underline font-medium">Setting up payment tracking</a>
                <p class="text-gray-500 text-[12px] mt-1">Configure payment records and due dates.</p>
            </li>
        </ul>
    </div>

    {{-- Tenant Management --}}
    <div class="bg-white rounded-xl border border-[#ede7df] p-6">
        <h2 class="text-[18px] font-bold text-[#2d1a0e] mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#7c3a1e]">
  <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0ZM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
</svg>
            Tenant Management
        </h2>
        <ul class="space-y-3">
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'how-to-edit-tenant-information') }}" class="text-[#7c3a1e] hover:underline font-medium">How to edit tenant information</a>
                <p class="text-gray-500 text-[12px] mt-1">Update tenant details, contact info, and lease terms.</p>
            </li>
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'viewing-tenant-lease-status') }}" class="text-[#7c3a1e] hover:underline font-medium">Viewing tenant lease status</a>
                <p class="text-gray-500 text-[12px] mt-1">Check lease expiration dates and renewal information.</p>
            </li>
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'removing-a-tenant') }}" class="text-[#7c3a1e] hover:underline font-medium">Removing a tenant</a>
                <p class="text-gray-500 text-[12px] mt-1">Steps to delete tenant records from the system.</p>
            </li>
        </ul>
    </div>

    {{-- Finances & Payments --}}
    <div class="bg-white rounded-xl border border-[#ede7df] p-6">
        <h2 class="text-[18px] font-bold text-[#2d1a0e] mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#7c3a1e]">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 3.071-.879 4.242 0M9.75 11.25c.386 0 .75-.385.75-.75s-.364-.75-.75-.75-.75.385-.75.75.364.75.75.75Zm-.007 4.5c.386 0 .75-.385.75-.75s-.364-.75-.75-.75-.75.385-.75.75.364.75.75.75Zm7.007-4.5c.386 0 .75-.385.75-.75s-.364-.75-.75-.75-.75.385-.75.75.364.75.75.75Zm-.007 4.5c.386 0 .75-.385.75-.75s-.364-.75-.75-.75-.75.385-.75.75.364.75.75.75Z" />
</svg>
            Finances & Payments
        </h2>
        <ul class="space-y-3">
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'recording-a-payment') }}" class="text-[#7c3a1e] hover:underline font-medium">Recording a payment</a>
                <p class="text-gray-500 text-[12px] mt-1">Add new payment records for tenants.</p>
            </li>
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'understanding-payment-status') }}" class="text-[#7c3a1e] hover:underline font-medium">Understanding payment status</a>
                <p class="text-gray-500 text-[12px] mt-1">Learn about paid, pending, and overdue payment statuses.</p>
            </li>
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'viewing-payment-history') }}" class="text-[#7c3a1e] hover:underline font-medium">Viewing payment history</a>
                <p class="text-gray-500 text-[12px] mt-1">Access transaction records and financial reports.</p>
            </li>
        </ul>
    </div>

    {{-- Maintenance --}}
    <div class="bg-white rounded-xl border border-[#ede7df] p-6">
        <h2 class="text-[18px] font-bold text-[#2d1a0e] mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#7c3a1e]">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.6L8.35 12.53m3.07 3.07l3.07-3.07m0 0L20.53 8.35m-3.07 3.07l3.07 3.07M9.379 5.5L5.5 9.379m0 0l-3.879 3.879M5.5 9.379L9.379 5.5" />
</svg>
            Maintenance
        </h2>
        <ul class="space-y-3">
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'creating-maintenance-reports') }}" class="text-[#7c3a1e] hover:underline font-medium">Creating maintenance reports</a>
                <p class="text-gray-500 text-[12px] mt-1">Log and track property maintenance issues.</p>
            </li>
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'assigning-technicians') }}" class="text-[#7c3a1e] hover:underline font-medium">Assigning technicians</a>
                <p class="text-gray-500 text-[12px] mt-1">Allocate maintenance tasks to team members.</p>
            </li>
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'tracking-maintenance-status') }}" class="text-[#7c3a1e] hover:underline font-medium">Tracking maintenance status</a>
                <p class="text-gray-500 text-[12px] mt-1">Monitor ongoing and completed repairs.</p>
            </li>
        </ul>
    </div>

    {{-- Account & Security --}}
    <div class="bg-white rounded-xl border border-[#ede7df] p-6">
        <h2 class="text-[18px] font-bold text-[#2d1a0e] mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#7c3a1e]">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c.055.156.102.312.153.465.953 3.427 3.93 5.9 7.15 5.9s6.197-2.473 7.15-5.9c.05-.153.098-.309.153-.465M12 15a3 3 0 100-6 3 3 0 000 6z" />
</svg>
            Account & Security
        </h2>
        <ul class="space-y-3">
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'changing-your-password') }}" class="text-[#7c3a1e] hover:underline font-medium">Changing your password</a>
                <p class="text-gray-500 text-[12px] mt-1">Update your account security regularly.</p>
            </li>
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'updating-profile-information') }}" class="text-[#7c3a1e] hover:underline font-medium">Updating profile information</a>
                <p class="text-gray-500 text-[12px] mt-1">Edit your name, username, and contact details.</p>
            </li>
            <li class="text-[13px]">
                <a href="{{ route('help-center.article', 'logging-out-safely') }}" class="text-[#7c3a1e] hover:underline font-medium">Logging out safely</a>
                <p class="text-gray-500 text-[12px] mt-1">Best practices for ending your session.</p>
            </li>
        </ul>
    </div>

    {{-- FAQ & Troubleshooting --}}
    <div class="bg-white rounded-xl border border-[#ede7df] p-6">
        <h2 class="text-[18px] font-bold text-[#2d1a0e] mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#7c3a1e]">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.90.63-2.295.968-3.862.968a3.883 3.883 0 01-3.716-3.7m12.753-1.007A6.5 6.5 0 1015.75 7.5M9.879 16.481c-1.171-1.025-1.171-2.687 0-3.712.9-.63 2.295-.969 3.862-.969 1.903 0 3.716.981 3.716 3.7m-12.753 1.007A6.5 6.5 0 0021.75 15M12 12a3 3 0 100-6 3 3 0 000 6zm0 6a3 3 0 100-6 3 3 0 000 6z" />
</svg>
            FAQ & Troubleshooting
        </h2>
        <ul class="space-y-3">
            <li class="text-[13px]">
                <a href="#" class="text-[#7c3a1e] hover:underline font-medium">Why am I locked out of my account?</a>
                <p class="text-gray-500 text-[12px] mt-1">Solutions for account access issues.</p>
            </li>
            <li class="text-[13px]">
                <a href="#" class="text-[#7c3a1e] hover:underline font-medium">Data recovery and backups</a>
                <p class="text-gray-500 text-[12px] mt-1">How your data is protected and recovered.</p>
            </li>
            <li class="text-[13px]">
                <a href="#" class="text-[#7c3a1e] hover:underline font-medium">Contacting support</a>
                <p class="text-gray-500 text-[12px] mt-1">Get in touch with our support team.</p>
            </li>
        </ul>
    </div>

</div>

<script>
    document.getElementById('helpSearch').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const articles = document.querySelectorAll('li a');
        
        articles.forEach(article => {
            const text = article.textContent.toLowerCase();
            const li = article.closest('li');
            
            if (text.includes(searchTerm)) {
                li.style.display = '';
            } else {
                li.style.display = 'none';
            }
        });
    });
</script>

@endsection
