<div class="grid gap-5">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">Tenant Name</label>
            <input type="text" name="name" value="{{ old('name', isset($tenant) ? $tenant->name : '') }}"
                   class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none"
                   placeholder="e.g. Rafael Dela Cruz">
            @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">Unit</label>
            <input type="text" name="unit" value="{{ old('unit', isset($tenant) ? $tenant->unit : '') }}"
                   class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none"
                   placeholder="e.g. Unit 12">
            @error('unit')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">Occupants</label>
            <input type="number" name="occupants" min="1" max="20" value="{{ old('occupants', isset($tenant) ? $tenant->occupants : 1) }}"
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
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', isset($tenant) ? $tenant->phone : '') }}"
                   class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none"
                   placeholder="09XX XXX XXXX">
            @error('phone')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">Lease Start</label>
                <input type="date" name="lease_start" value="{{ old('lease_start', isset($tenant) ? optional($tenant)->lease_start?->format('Y-m-d') : '') }}"
                       class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">
                @error('lease_start')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">Lease End</label>
                <input type="date" name="lease_end" value="{{ old('lease_end', isset($tenant) ? optional($tenant)->lease_end?->format('Y-m-d') : '') }}"
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
                    <option value="{{ $statusOption }}" {{ old('status', isset($tenant) ? $tenant->status : 'Active') === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                @endforeach
            </select>
            @error('status')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">Payment Status</label>
            <select name="payment_status" class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">
                @foreach (['Paid', 'Pending', 'Overdue'] as $paymentOption)
                    <option value="{{ $paymentOption }}" {{ old('payment_status', isset($tenant) ? $tenant->payment_status : 'Paid') === $paymentOption ? 'selected' : '' }}>{{ $paymentOption }}</option>
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
