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
    <style>
        /* Custom styles for datalist dropdown positioning */
        input[list] {
            position: relative;
        }
        datalist {
            position: absolute;
            background: white;
            border: 1px solid #ede7df;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            width: 100%;
            top: 100%;
            left: 0;
            margin-top: 2px;
        }
        datalist option {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f5f0eb;
        }
        datalist option:hover {
            background-color: #faf7f4;
        }
        datalist option:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body class="bg-[#f5f0eb] font-sans antialiased overflow-x-hidden">

    {{-- ── SIDEBAR ─────────────────────────────────────────────── --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-48 bg-white border-r border-[#ede7df] flex flex-col z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

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
        <div class="px-5 py-4 border-t border-[#ede7df] space-y-2">
            <a href="{{ route('settings.index') }}"
               class="flex items-center px-3 py-2 text-[12px] font-medium text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4] rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.592c.55 0 1.02.398 1.11.94m-.213 9.526c.106.734.435 1.408.995 1.838m0 0A24.226 24.226 0 0021.514 20.022M2.486 20.022A24.226 24.226 0 0015.064 15.404m-9.141-5.95a6 6 0 1112 0 6 6 0 01-12 0zm12 0c0 1.657-.672 3.157-1.757 4.243A4.243 4.243 0 0015.604 15.12" />
                </svg>
                Settings
            </a>
            <a href="{{ route('help-center') }}"
               class="flex items-center px-3 py-2 text-[12px] font-medium text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4] rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.90.63-2.295.968-3.862.968a3.883 3.883 0 01-3.716-3.7m12.753-1.007A6.5 6.5 0 1015.75 7.5M9.879 16.481c-1.171-1.025-1.171-2.687 0-3.712.9-.63 2.295-.969 3.862-.969 1.903 0 3.716.981 3.716 3.7m-12.753 1.007A6.5 6.5 0 0021.75 15M12 12a3 3 0 100-6 3 3 0 000 6zm0 6a3 3 0 100-6 3 3 0 000 6z" />
                </svg>
                Help
            </a>
            <a href="{{ route('logout') }}"
               class="flex items-center px-3 py-2 text-[12px] font-medium text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                Logout
            </a>
        </div>
    </aside>

    {{-- ── TOPBAR ──────────────────────────────────────────────── --}}
    <header class="fixed top-0 left-0 right-0 h-14 bg-white border-b border-[#ede7df] flex items-center justify-between px-4 md:px-8 md:left-48 z-40">
        <div class="flex items-center gap-3">
            <button id="sidebarToggle" class="md:hidden p-2 hover:bg-[#f5f0eb] rounded-lg transition-colors" aria-label="Toggle menu">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <button id="topbarNotificationButton" type="button" onclick="toggleTopbarDropdown('notifications')" class="w-8 h-8 rounded-full bg-[#f5f0eb] flex items-center justify-center text-gray-500 hover:bg-[#ede7df] transition-colors text-sm" aria-haspopup="true" aria-expanded="false" aria-controls="topbarNotificationDropdown">
                    <span class="sr-only">Open notifications</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
</svg>
                </button>

                <div id="topbarNotificationDropdown" class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg z-50 hidden text-sm">
                    <div class="p-4 space-y-2">
                        <p class="text-sm font-semibold text-[#2d1a0e]">Notifications</p>
                        <div class="space-y-2 max-h-64 overflow-y-auto">
                            {{-- Tenant Lease Alerts --}}
                            @if(isset($expiredTenants) && $expiredTenants->count() > 0)
                                @foreach($expiredTenants->take(3) as $tenant)
                                <div class="flex items-start gap-3 p-2 bg-red-50 rounded-lg">
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-600 flex-shrink-0 font-bold text-xs">
                                        {{ substr($tenant->name, 0, 1) }}{{ substr($tenant->name, strpos($tenant->name, ' ') + 1, 1) ?? '' }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-red-800">{{ $tenant->name }} - Unit {{ $tenant->unit }}</p>
                                        <p class="text-xs text-red-600">Lease expired {{ $tenant->lease_end->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            @if(isset($almostExpiredTenants) && $almostExpiredTenants->count() > 0)
                                @foreach($almostExpiredTenants->take(3) as $tenant)
                                <div class="flex items-start gap-3 p-2 bg-orange-50 rounded-lg">
                                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 flex-shrink-0 font-bold text-xs">
                                        {{ substr($tenant->name, 0, 1) }}{{ substr($tenant->name, strpos($tenant->name, ' ') + 1, 1) ?? '' }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-orange-800">{{ $tenant->name }} - Unit {{ $tenant->unit }}</p>
                                        <p class="text-xs text-orange-600">Lease expires in {{ now()->diffInDays($tenant->lease_end) }} days</p>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            {{-- Maintenance Issues --}}
                            @if(isset($maintenanceItems) && count($maintenanceItems) > 0)
                                @foreach($maintenanceItems as $item)
                                <div class="flex items-start gap-3 p-2 bg-gray-50 rounded-lg">
                                    <div class="w-8 h-8 {{ $item['iconBg'] }} rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-800">{{ $item['title'] }}</p>
                                        <p class="text-xs text-gray-600">{{ $item['meta'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <a href="{{ route('dashboard') }}" class="block text-sm text-[#7c3a1e] hover:underline">View all notifications</a>
                    </div>
                </div>
            </div>

            <div class="relative">
                <button id="topbarProfileButton" type="button" onclick="toggleTopbarDropdown('profile')" class="w-8 h-8 rounded-full bg-[#4a3728] flex items-center justify-center text-white text-[10px] font-bold" aria-haspopup="true" aria-expanded="false" aria-controls="topbarProfileDropdown">
                    <span class="sr-only">Open profile menu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
</svg>
                </button>

                <div id="topbarProfileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg z-50 hidden text-sm">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-gray-700 hover:bg-[#f5f0eb]">Account Settings</a>
                    <a href="{{ route('utility') }}" class="block px-4 py-3 text-gray-700 hover:bg-[#f5f0eb]">Help Center</a>
                    <div class="border-t border-[#ede7df]"></div>
                    <a href="{{ route('logout') }}" class="block px-4 py-3 text-gray-700 hover:bg-[#f5f0eb]">Logout</a>
                </div>
            </div>
        </div>
    </header>

    {{-- Mobile Sidebar Overlay --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 md:hidden z-40 hidden" onclick="closeSidebar()"></div>

    {{-- ── MAIN ────────────────────────────────────────────────── --}}
    <main class="ml-0 md:ml-48 mt-14 p-4 md:p-8 min-h-[calc(100vh-56px)]">
        @yield('content')
    </main>

    {{-- Mobile Navigation Script --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');

        function openSidebar() {
            sidebar?.classList.remove('-translate-x-full');
            overlay?.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar?.classList.add('-translate-x-full');
            overlay?.classList.add('hidden');
        }

        toggleBtn?.addEventListener('click', () => {
            if (!sidebar) return;
            sidebar.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar();
        });

        // Close sidebar when a link is clicked
        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', closeSidebar);
        });

        // Close sidebar when clicking on the main area
        document.querySelector('main')?.addEventListener('click', closeSidebar);

        function toggleTopbarDropdown(dropdownId) {
            const notificationDropdown = document.getElementById('topbarNotificationDropdown');
            const profileDropdown = document.getElementById('topbarProfileDropdown');

            if (dropdownId === 'notifications') {
                notificationDropdown?.classList.toggle('hidden');
                profileDropdown?.classList.add('hidden');
            }

            if (dropdownId === 'profile') {
                profileDropdown?.classList.toggle('hidden');
                notificationDropdown?.classList.add('hidden');
            }
        }

        document.addEventListener('click', event => {
            const notificationButton = document.getElementById('topbarNotificationButton');
            const profileButton = document.getElementById('topbarProfileButton');
            const notificationDropdown = document.getElementById('topbarNotificationDropdown');
            const profileDropdown = document.getElementById('topbarProfileDropdown');

            const clickedInsideNotification = notificationButton?.contains(event.target) || notificationDropdown?.contains(event.target);
            const clickedInsideProfile = profileButton?.contains(event.target) || profileDropdown?.contains(event.target);

            if (!clickedInsideNotification) {
                notificationDropdown?.classList.add('hidden');
            }
            if (!clickedInsideProfile) {
                profileDropdown?.classList.add('hidden');
            }
        });
    </script>

</body>
</html>
