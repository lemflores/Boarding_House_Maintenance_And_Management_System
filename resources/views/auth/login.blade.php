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

<div class="flex min-h-screen">

    {{-- ── LEFT HERO ─────────────────────────────────────────── --}}
    <div class="relative hidden md:flex md:w-1/2 flex-col justify-between overflow-hidden">

        {{-- Background photo --}}
        <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=900&auto=format&fit=crop&q=80"
             alt="Boarding house interior"
             class="absolute inset-0 w-full h-full object-cover">

        {{-- Dark overlay --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/35 via-black/10 to-black/65"></div>

        {{-- Top logo --}}
        <div class="relative z-10 p-8">
            <div class="flex items-center gap-2 text-white">
                <span class="text-lg"></span>
                <span class="font-[Playfair_Display] font-bold text-[17px] tracking-wide">NaVi Boarding House</span>
            </div>
        </div>

        {{-- Bottom copy --}}
        <div class="relative z-10 p-10 text-white">
            <h1 class="font-[Playfair_Display] text-[38px] font-bold leading-[1.15] mb-3">
                Affordable And<br>Welcoming Dorm
            </h1>
            <div class="w-10 h-[3px] bg-green-400 rounded-full mb-5"></div>
            <p class="text-[13px] text-white/80 leading-relaxed max-w-[280px]">
                A Student and Local-friendly Boarding House. Log in to access your dashboard, tenant ledgers, and property insights.
            </p>
        </div>
    </div>

    {{-- ── RIGHT SIGN-IN PANEL ──────────────────────────────── --}}
    <div class="flex-1 flex items-center justify-center p-8">
        <div class="bg-white rounded-2xl shadow-xl px-10 py-10 w-full max-w-[400px]">

            <p class="text-[10px] font-semibold tracking-[0.14em] uppercase text-gray-400 mb-1">
                Navi Boarding House
            </p>
            <h2 class="font-[Playfair_Display] text-[28px] font-bold text-[#2d1a0e] leading-tight mb-1">
                Sign In
            </h2>
            <p class="text-[13px] text-gray-400 mb-7">
                Please enter your credentials to manage your spaces.
            </p>

            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-[13px] rounded-xl px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[12px] font-semibold text-[#2d1a0e] mb-1.5">
                        Manager Email
                    </label>
                    <div class="flex items-center border border-gray-200 rounded-lg px-3 py-2.5 gap-2 focus-within:border-[#7c3a1e] transition-colors">
                        <span class="text-gray-400 text-[13px] leading-none"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M17.834 6.166a8.25 8.25 0 1 0 0 11.668.75.75 0 0 1 1.06 1.06c-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788 3.807-3.808 9.98-3.808 13.788 0A9.722 9.722 0 0 1 21.75 12c0 .975-.296 1.887-.809 2.571-.514.685-1.28 1.179-2.191 1.179-.904 0-1.666-.487-2.18-1.164a5.25 5.25 0 1 1-.82-6.26V8.25a.75.75 0 0 1 1.5 0V12c0 .682.208 1.27.509 1.671.3.401.659.579.991.579.332 0 .69-.178.991-.579.3-.4.509-.99.509-1.671a8.222 8.222 0 0 0-2.416-5.834ZM15.75 12a3.75 3.75 0 1 0-7.5 0 3.75 3.75 0 0 0 7.5 0Z" clip-rule="evenodd" />
</svg>
</span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               placeholder="e.g. ilustrado@bahay.com"
                               class="flex-1 text-[13px] text-gray-700 outline-none bg-transparent placeholder-gray-300"
                               autofocus required>
                    </div>
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
                <button class="border border-gray-200 text-gray-500 text-[12px] font-medium px-5 py-[7px] rounded-full hover:bg-gray-50 transition-colors">
                    Register
                </button>
            </div>
        </div>
    </div>

</div>

</body>
</html>
