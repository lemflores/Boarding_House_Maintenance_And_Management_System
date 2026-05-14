@extends('layouts.app')
@section('title', 'Account Settings')

@section('content')

{{-- ── HEADER ──────────────────────────────────────────────────── --}}
<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-7">
    <div>
        <h1 class="font-[Playfair_Display] text-[26px] md:text-[32px] font-bold text-[#2d1a0e]">Account Settings</h1>
        <p class="text-sm text-gray-500 mt-1">Manage your account information, security, and preferences.</p>
    </div>
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 border border-[#e5e7eb] text-gray-500 text-[12px] md:text-[13px] font-medium px-4 py-2.5 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors">
        ← Back to Dashboard
    </a>
</div>

@if (session('success'))
    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Sidebar Navigation --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-[#ede7df] p-4 space-y-2">
            <button onclick="scrollToSection('profile')" class="w-full text-left px-4 py-3 rounded-lg bg-[#f5f0eb] text-[#2d1a0e] font-semibold text-[13px] hover:bg-[#7c3a1e] hover:text-white transition-colors">
                Profile Information
            </button>
            <button onclick="scrollToSection('password')" class="w-full text-left px-4 py-3 rounded-lg text-gray-500 font-medium text-[13px] hover:bg-[#f5f0eb] transition-colors">
                Change Password
            </button>
            <a href="{{ route('help-center') }}" class="w-full text-left px-4 py-3 rounded-lg text-gray-500 font-medium text-[13px] hover:bg-[#f5f0eb] transition-colors block">
                Help Center
            </a>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="lg:col-span-2 space-y-6">
        
        {{-- Profile Information Section --}}
        <div id="profile" class="bg-white rounded-xl border border-[#ede7df] p-6 md:p-8">
            <h2 class="text-[18px] font-bold text-[#2d1a0e] mb-6">Profile Information</h2>
            
            <form method="POST" action="{{ route('settings.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" required value="{{ old('name', $user->name) }}"
                               class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">
                        @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="username" class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="username" name="username" required value="{{ old('username', $user->username) }}"
                               class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">
                        @error('username')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                        Email Address
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none"
                           placeholder="optional@bahay.com">
                    @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex gap-3 pt-4 border-t border-[#e5e7eb]">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-[#7c3a1e] hover:bg-[#5c2910] text-white text-[12px] md:text-[13px] font-semibold px-4 py-2.5 rounded-lg transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        {{-- Change Password Section --}}
        <div id="password" class="bg-white rounded-xl border border-[#ede7df] p-6 md:p-8">
            <h2 class="text-[18px] font-bold text-[#2d1a0e] mb-6">Change Password</h2>
            
            <form method="POST" action="{{ route('settings.change-password') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                        Current Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="current_password" name="current_password" required
                           class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">
                    @error('current_password')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required
                               class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none"
                               placeholder="Minimum 8 characters">
                        @error('password')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-500 mb-2">
                            Confirm New Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full rounded-lg border border-[#e5e7eb] px-4 py-2 text-sm text-gray-700 focus:border-[#7c3a1e] outline-none">
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t border-[#e5e7eb]">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-[#7c3a1e] hover:bg-[#5c2910] text-white text-[12px] md:text-[13px] font-semibold px-4 py-2.5 rounded-lg transition-colors">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function scrollToSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            section.scrollIntoView({ behavior: 'smooth' });
        }
    }
</script>

@endsection
