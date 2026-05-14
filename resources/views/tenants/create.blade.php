@extends('layouts.app')
@section('title', 'Add Tenant')

@section('content')

<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e]">New Tenant Application</h1>
        <p class="text-sm text-gray-500 mt-1">Submit a new tenant application so the lease and payment preview stays in sync.</p>
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const unitSearch = document.getElementById('unit-search');
    const unitDropdown = document.getElementById('unit-dropdown');
    const unitInput = document.getElementById('unit-input');
    const unitOptions = document.querySelectorAll('.unit-option');

    // Set initial value if exists
    if (unitInput.value) {
        unitSearch.value = unitInput.value;
    }

    // Toggle dropdown
    unitSearch.addEventListener('focus', function() {
        unitDropdown.classList.remove('hidden');
        filterOptions('');
    });

    unitSearch.addEventListener('input', function() {
        filterOptions(this.value);
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!unitSearch.contains(e.target) && !unitDropdown.contains(e.target)) {
            unitDropdown.classList.add('hidden');
        }
    });

    // Handle option selection
    unitOptions.forEach(option => {
        option.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            unitSearch.value = value;
            unitInput.value = value;
            unitDropdown.classList.add('hidden');
        });
    });

    function filterOptions(searchTerm) {
        const term = searchTerm.toLowerCase();
        unitOptions.forEach(option => {
            const text = option.textContent.toLowerCase();
            if (text.includes(term)) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
    }
});
</script>
@endsection
