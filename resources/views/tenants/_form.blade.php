<div class="grid gap-5">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                Tenant Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" required value="{{ old('name', isset($tenant) ? $tenant->name : '') }}"
                   class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none"
                   placeholder="e.g. Rafael Dela Cruz">
            @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                Unit <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input type="hidden" name="unit" value="{{ old('unit', isset($tenant) ? $tenant->unit : '') }}" id="unit-input">
                <div class="relative">
                    <input type="text" id="unit-search" class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none" placeholder="Search and select unit..." autocomplete="off">
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div id="unit-dropdown" class="absolute z-10 w-full bg-white border border-[#e5e7eb] rounded-lg shadow-lg mt-1 max-h-48 overflow-y-auto hidden">
                    @if(isset($availableUnits))
                        @foreach($availableUnits as $unitNumber)
                            <div class="unit-option px-4 py-2 hover:bg-[#faf7f4] cursor-pointer text-sm" data-value="{{ $unitNumber }}">{{ $unitNumber }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
            @error('unit')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                Occupants <span class="text-red-500">*</span>
            </label>
            <input type="number" name="occupants" min="1" max="20" required value="{{ old('occupants', isset($tenant) ? $tenant->occupants : 1) }}"
                   class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">
            @error('occupants')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', isset($tenant) ? $tenant->email : '') }}"
                   class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none"
                   placeholder="tenant@example.com">
            @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                Phone <span class="text-red-500">*</span>
            </label>
            <input type="tel" name="phone" required value="{{ old('phone', isset($tenant) ? $tenant->phone : '') }}"
                   class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none"
                   placeholder="09XX XXX XXXX"
                   inputmode="numeric"
                   onkeypress="return /[0-9\s\-\+\(\)]/i.test(event.key)"
                   oninput="this.value = this.value.replace(/[^0-9\s\-\+\(\)]/g, '')">
            @error('phone')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                    Lease Start <span class="text-red-500">*</span>
                </label>
                <input type="date" name="lease_start" required value="{{ old('lease_start', isset($tenant) ? optional($tenant)->lease_start?->format('Y-m-d') : '') }}"
                       class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">
                @error('lease_start')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                    Lease End <span class="text-red-500">*</span>
                </label>
                <input type="date" name="lease_end" required value="{{ old('lease_end', isset($tenant) ? optional($tenant)->lease_end?->format('Y-m-d') : '') }}"
                       class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">
                @error('lease_end')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">Lease Status</label>
            <select name="status" class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">
                @foreach (['Active', 'Renewal Sent', 'Pending', 'Overdue'] as $statusOption)
                    <option value="{{ $statusOption }}" {{ old('status', isset($tenant) ? $tenant->status : 'Pending') === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                @endforeach
            </select>
            @error('status')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">Payment Status</label>
            <select name="payment_status" class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">
                @foreach (['Paid', 'Pending', 'Overdue'] as $paymentOption)
                    <option value="{{ $paymentOption }}" {{ old('payment_status', isset($tenant) ? $tenant->payment_status : 'Pending') === $paymentOption ? 'selected' : '' }}>{{ $paymentOption }}</option>
                @endforeach
            </select>
            @error('payment_status')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>
    <div>
        <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">Notes</label>
        <textarea name="notes" rows="4" class="w-full rounded-lg border border-[#e5e7eb] px-4 py-3 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">{{ old('notes', isset($tenant) ? $tenant->notes : '') }}</textarea>
        @error('notes')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
</div>
