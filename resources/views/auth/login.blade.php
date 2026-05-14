<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NaVi – Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f5f0eb] font-sans antialiased min-h-screen">

<div class="flex flex-col md:flex-row min-h-screen">

    {{-- ── LEFT HERO ─────────────────────────────────────────── --}}
    <div class="relative hidden md:flex md:w-1/2 flex-col justify-between overflow-hidden">

        {{-- Background photo --}}
        <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=900&auto=format&fit=crop&q=80"
             alt="Boarding house interior"
             class="absolute inset-0 w-full h-full object-cover">

        {{-- Dark overlay --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/35 via-black/10 to-black/65"></div>

        {{-- Top logo --}}
        <div class="relative z-10 p-6 md:p-8">
            <div class="flex items-center gap-2 text-white">
                <span class="text-lg"></span>
                <span class="font-[Playfair_Display] font-bold text-[15px] md:text-[17px] tracking-wide">NaVi Boarding House</span>
            </div>
        </div>

        {{-- Bottom copy --}}
        <div class="relative z-10 p-6 md:p-10 text-white">
            <h1 class="font-[Playfair_Display] text-[32px] md:text-[38px] font-bold leading-[1.15] mb-3">
                Affordable And<br>Welcoming Dorm
            </h1>
            <div class="w-10 h-[3px] bg-green-400 rounded-full mb-5"></div>
            <p class="text-[12px] md:text-[13px] text-white/80 leading-relaxed max-w-[280px]">
                A Student and Local-friendly Boarding House. Log in to access your dashboard, tenant ledgers, and property insights.
            </p>
        </div>
    </div>

    {{-- ── RIGHT SIGN-IN PANEL ──────────────────────────────── --}}
    <div class="flex-1 flex items-center justify-center p-4 md:p-8">
        <div class="bg-white rounded-2xl shadow-xl px-6 md:px-10 py-8 md:py-10 w-full max-w-[400px]">

            <p class="text-[10px] font-semibold tracking-[0.14em] uppercase text-gray-400 mb-1">
                Navi Boarding House
            </p>
            <h2 class="font-[Playfair_Display] text-[24px] md:text-[28px] font-bold text-[#2d1a0e] leading-tight mb-1">
                Sign In
            </h2>
            <p class="text-[12px] md:text-[13px] text-gray-400 mb-6 md:mb-7">
                Please enter your credentials to manage your spaces.
            </p>

            @if (session('registered'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-700 text-[13px] rounded-xl px-4 py-3">
                    {{ session('registered') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-[13px] rounded-xl px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                {{-- Username --}}
                <div>
                    <label for="username" class="block text-[12px] font-semibold text-[#2d1a0e] mb-1.5">
                        Username
                    </label>
                    <div class="flex items-center border border-gray-200 rounded-lg px-3 py-2.5 gap-2 focus-within:border-[#7c3a1e] transition-colors">
                        <span class="text-gray-400 text-[13px] leading-none"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM1.5 20.25a7.5 7.5 0 0 1 14.99 0A.75.75 0 0 0 16.5 21H3a.75.75 0 0 0 .75-.75Z" clip-rule="evenodd" />
</svg>
</span>
                        <input id="username" type="text" name="username" value="{{ old('username') }}"
                               placeholder="e.g. manager123"
                               class="flex-1 text-[13px] text-gray-700 outline-none bg-transparent placeholder-gray-300"
                               autofocus required>
                    </div>
                    @error('username')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-[12px] font-semibold text-[#2d1a0e] mb-1.5">
                        Password
                    </label>
                    <div class="flex items-center border border-gray-200 rounded-lg px-3 py-2.5 gap-2 focus-within:border-[#7c3a1e] transition-colors">
                        <span class="text-gray-400 text-[13px]"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
</svg>
</span>
                        <input id="password" type="password" name="password"
                               class="flex-1 text-[13px] text-gray-700 outline-none bg-transparent tracking-[0.2em]"
                               required>
                        <button type="button" onclick="document.getElementById('password').type==='password'?document.getElementById('password').type='text':document.getElementById('password').type='password'"
                                class="text-gray-400 hover:text-gray-600 text-[13px]"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
  <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
</svg>
</button>
                    </div>
                </div>

                {{-- Remember --}}
                <div class="flex items-center gap-2 pt-0.5">
                    <input id="remember" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-gray-300 accent-[#7c3a1e]">
                    <label for="remember" class="text-[12px] text-gray-500">Keep me signed in for 30 days</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-[#7c3a1e] hover:bg-[#5c2910] text-white font-semibold text-[14px] rounded-lg py-3 flex items-center justify-center gap-2 transition-colors shadow-md mt-2">
                    Access Dashboard →
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-[12px] text-gray-400 mb-2">Are you a new Manager?</p>
                <button type="button" onclick="toggleRegisterModal(true)"
                        class="border border-gray-200 text-gray-500 text-[12px] font-medium px-5 py-[7px] rounded-full hover:bg-gray-50 transition-colors">
                    Register
                </button>
            </div>
        </div>
    </div>

</div>

<div id="registerModal" class="fixed inset-0 z-50 {{ old('from_register') ? 'flex' : 'hidden' }} items-center justify-center bg-black/50 p-4"
     onclick="if (event.target === this) toggleRegisterModal(false)">
    <div class="relative w-full max-w-lg bg-white rounded-[30px] shadow-2xl p-6 md:p-8">
        <button type="button" onclick="toggleRegisterModal(false)"
                class="absolute right-4 top-4 text-gray-400 hover:text-gray-600">
            <span class="sr-only">Close register form</span>
            ×
        </button>

        <h3 class="font-[Playfair_Display] text-[22px] font-bold text-[#2d1a0e] mb-2">Create an account</h3>
        <p class="text-[13px] text-gray-500 mb-6">Register to access the boarding house management dashboard.</p>

        @if ($errors->any() && old('from_register'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-[13px] rounded-xl px-4 py-3">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="from_register" value="1">

            <div>
                <label for="name" class="block text-[12px] font-semibold text-[#2d1a0e] mb-1.5">Full Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-[13px] text-gray-700 outline-none focus:border-[#7c3a1e] transition-colors"
                       placeholder="Jane Doe" required>
                @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="register_username" class="block text-[12px] font-semibold text-[#2d1a0e] mb-1.5">Username</label>
                <input id="register_username" name="username" type="text" value="{{ old('username') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-[13px] text-gray-700 outline-none focus:border-[#7c3a1e] transition-colors"
                       placeholder="e.g. manager123" required>
                @error('username')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="register_email" class="block text-[12px] font-semibold text-[#2d1a0e] mb-1.5">Email <span class="text-gray-400">(optional)</span></label>
                <input id="register_email" name="email" type="email" value="{{ old('email') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-[13px] text-gray-700 outline-none focus:border-[#7c3a1e] transition-colors"
                       placeholder="e.g. jane@bahay.com">
                @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="register_password" class="block text-[12px] font-semibold text-[#2d1a0e] mb-1.5">Password</label>
                <input id="register_password" name="password" type="password"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-[13px] text-gray-700 outline-none focus:border-[#7c3a1e] transition-colors"
                       placeholder="Minimum 8 characters" required>
                @error('password')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-[12px] font-semibold text-[#2d1a0e] mb-1.5">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-[13px] text-gray-700 outline-none focus:border-[#7c3a1e] transition-colors"
                       placeholder="Re-enter password" required>
            </div>

            <button type="submit"
                    class="w-full bg-[#7c3a1e] hover:bg-[#5c2910] text-white font-semibold text-[14px] rounded-lg py-3 transition-colors shadow-md">
                Register account
            </button>
        </form>
    </div>
</div>

<script>
    function toggleRegisterModal(open) {
        const modal = document.getElementById('registerModal');
        if (!modal) return;
        modal.classList.toggle('hidden', !open);
        modal.classList.toggle('flex', open);
    }
</script>

</body>
</html>
