<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NaVi – @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f5f0eb] font-sans antialiased">

    {{-- ── SIDEBAR ─────────────────────────────────────────────── --}}
    <aside class="fixed inset-y-0 left-0 w-48 bg-white border-r border-[#ede7df] flex flex-col z-50">

        {{-- Brand --}}
        <div class="px-5 pt-5 pb-4 border-b border-[#ede7df]">
            <p class="font-[Playfair_Display] font-bold text-xl text-[#2d1a0e] leading-none">NaVi</p>
            <p class="mt-2 text-[13px] font-semibold text-[#2d1a0e]">Visayan Village</p>
            <p class="text-[10px] font-semibold tracking-[0.12em] uppercase text-gray-400">Tagum Branch</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 pt-3">
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-5 py-[9px] text-[13px] font-medium border-l-[3px] transition-colors
                      {{ request()->routeIs('dashboard') ? 'border-[#7c3a1e] bg-[#f5ede6] text-[#2d1a0e] font-semibold' : 'border-transparent text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4]' }}">
                Property Overview
            </a>
            <a href="{{ route('utility') }}"
               class="flex items-center px-5 py-[9px] text-[13px] font-medium border-l-[3px] transition-colors
                      {{ request()->routeIs('utility') ? 'border-[#7c3a1e] bg-[#f5ede6] text-[#2d1a0e] font-semibold' : 'border-transparent text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4]' }}">
                Utility Tracking
            </a>
            <a href="{{ route('tenants') }}"
               class="flex items-center px-5 py-[9px] text-[13px] font-medium border-l-[3px] transition-colors
                      {{ request()->routeIs('tenants') ? 'border-[#7c3a1e] bg-[#f5ede6] text-[#2d1a0e] font-semibold' : 'border-transparent text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4]' }}">
                Tenants
            </a>
            <a href="{{ route('finances') }}"
               class="flex items-center px-5 py-[9px] text-[13px] font-medium border-l-[3px] transition-colors
                      {{ request()->routeIs('finances') ? 'border-[#7c3a1e] bg-[#f5ede6] text-[#2d1a0e] font-semibold' : 'border-transparent text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4]' }}">
                Finances
            </a>
            <a href="{{ route('maintenance') }}"
               class="flex items-center px-5 py-[9px] text-[13px] font-medium border-l-[3px] transition-colors
                      {{ request()->routeIs('maintenance') ? 'border-[#7c3a1e] bg-[#f5ede6] text-[#2d1a0e] font-semibold' : 'border-transparent text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4]' }}">
                Maintenance
            </a>
        </nav>

        {{-- Footer --}}
        <div class="px-5 py-4 border-t border-[#ede7df] space-y-1">
            <a href="#" class="flex items-center gap-2 text-[12px] text-gray-400 hover:text-[#7c3a1e] transition-colors py-0.5">
                <span class="text-[11px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
</svg>
</span> Help Center
            </a>
            <a href="{{ route('login') }}" class="flex items-center gap-2 text-[12px] text-gray-400 hover:text-[#7c3a1e] transition-colors py-0.5">
                <span class="text-[11px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
</svg>
</span> Logout
            </a>
        </div>
    </aside>

    {{-- ── TOPBAR ──────────────────────────────────────────────── --}}
    <header class="fixed top-0 left-48 right-0 h-14 bg-white border-b border-[#ede7df] flex items-center justify-between px-8 z-40">
        <span class="font-[Playfair_Display] font-bold text-xl text-[#2d1a0e]">NaVi</span>
        <div class="flex items-center gap-3">
            <button class="w-8 h-8 rounded-full bg-[#f5f0eb] flex items-center justify-center text-gray-500 hover:bg-[#ede7df] transition-colors text-sm"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
</svg>
</button>
            <button class="w-8 h-8 rounded-full bg-[#f5f0eb] flex items-center justify-center text-gray-500 hover:bg-[#ede7df] transition-colors text-sm"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
</svg>
</button>
            <div class="w-8 h-8 rounded-full bg-[#4a3728] flex items-center justify-center text-white text-[10px] font-bold"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
</svg>
</div>
        </div>
    </header>

    {{-- ── MAIN ────────────────────────────────────────────────── --}}
    <main class="ml-48 mt-14 p-8 min-h-[calc(100vh-56px)]">
        @yield('content')
    </main>

</body>
</html>
