<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NaVi – Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-[#f5f0eb] font-sans antialiased min-h-screen">

<div class="flex min-h-screen">

    
    <div class="relative hidden md:flex md:w-1/2 flex-col justify-between overflow-hidden">

        
        <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=900&auto=format&fit=crop&q=80"
             alt="Boarding house interior"
             class="absolute inset-0 w-full h-full object-cover">

        
        <div class="absolute inset-0 bg-gradient-to-b from-black/35 via-black/10 to-black/65"></div>

        
        <div class="relative z-10 p-8">
            <div class="flex items-center gap-2 text-white">
                <span class="text-lg">🏢</span>
                <span class="font-[Playfair_Display] font-bold text-[17px] tracking-wide">NaVi Boarding House</span>
            </div>
        </div>

        
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

            <?php if($errors->any()): ?>
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-[13px] rounded-xl px-4 py-3">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login.post')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>

                
                <div>
                    <label for="email" class="block text-[12px] font-semibold text-[#2d1a0e] mb-1.5">
                        Manager Email
                    </label>
                    <div class="flex items-center border border-gray-200 rounded-lg px-3 py-2.5 gap-2 focus-within:border-[#7c3a1e] transition-colors">
                        <span class="text-gray-400 text-[13px] leading-none">@</span>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>"
                               placeholder="e.g. ilustrado@bahay.com"
                               class="flex-1 text-[13px] text-gray-700 outline-none bg-transparent placeholder-gray-300"
                               autofocus required>
                    </div>
                </div>

                
                <div>
                    <label for="password" class="block text-[12px] font-semibold text-[#2d1a0e] mb-1.5">
                        Password
                    </label>
                    <div class="flex items-center border border-gray-200 rounded-lg px-3 py-2.5 gap-2 focus-within:border-[#7c3a1e] transition-colors">
                        <span class="text-gray-400 text-[13px]">🔒</span>
                        <input id="password" type="password" name="password"
                               class="flex-1 text-[13px] text-gray-700 outline-none bg-transparent tracking-[0.2em]"
                               required>
                        <button type="button" onclick="document.getElementById('password').type==='password'?document.getElementById('password').type='text':document.getElementById('password').type='password'"
                                class="text-gray-400 hover:text-gray-600 text-[13px]">👁</button>
                    </div>
                </div>

                
                <div class="flex items-center gap-2 pt-0.5">
                    <input id="remember" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-gray-300 accent-[#7c3a1e]">
                    <label for="remember" class="text-[12px] text-gray-500">Keep me signed in for 30 days</label>
                </div>

                
                <button type="submit"
                        class="w-full bg-[#7c3a1e] hover:bg-[#5c2910] text-white font-semibold text-[14px] rounded-lg py-3 flex items-center justify-center gap-2 transition-colors shadow-md mt-2">
                    Access Dashboard →
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-[12px] text-gray-400 mb-2">Are you a new Tenant?</p>
                <button class="border border-gray-200 text-gray-500 text-[12px] font-medium px-5 py-[7px] rounded-full hover:bg-gray-50 transition-colors">
                    Register
                </button>
            </div>
        </div>
    </div>

</div>

</body>
</html>
<?php /**PATH C:\Users\parad\dejesus\Boarding_House_Maintenance_And_Management_System\resources\views/auth/login.blade.php ENDPATH**/ ?>