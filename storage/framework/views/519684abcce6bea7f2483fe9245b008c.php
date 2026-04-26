<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>NaVi – <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-[#f5f0eb] font-sans antialiased">

    
    <aside class="fixed inset-y-0 left-0 w-48 bg-white border-r border-[#ede7df] flex flex-col z-50">

        
        <div class="px-5 pt-5 pb-4 border-b border-[#ede7df]">
            <p class="font-[Playfair_Display] font-bold text-xl text-[#2d1a0e] leading-none">NaVi</p>
            <p class="mt-2 text-[13px] font-semibold text-[#2d1a0e]">Visayan Village</p>
            <p class="text-[10px] font-semibold tracking-[0.12em] uppercase text-gray-400">Tagum Branch</p>
        </div>

        
        <nav class="flex-1 pt-3">
            <a href="<?php echo e(route('dashboard')); ?>"
               class="flex items-center px-5 py-[9px] text-[13px] font-medium border-l-[3px] transition-colors
                      <?php echo e(request()->routeIs('dashboard') ? 'border-[#7c3a1e] bg-[#f5ede6] text-[#2d1a0e] font-semibold' : 'border-transparent text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4]'); ?>">
                Property Overview
            </a>
            <a href="<?php echo e(route('utility')); ?>"
               class="flex items-center px-5 py-[9px] text-[13px] font-medium border-l-[3px] transition-colors
                      <?php echo e(request()->routeIs('utility') ? 'border-[#7c3a1e] bg-[#f5ede6] text-[#2d1a0e] font-semibold' : 'border-transparent text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4]'); ?>">
                Utility Tracking
            </a>
            <a href="<?php echo e(route('tenants')); ?>"
               class="flex items-center px-5 py-[9px] text-[13px] font-medium border-l-[3px] transition-colors
                      <?php echo e(request()->routeIs('tenants') ? 'border-[#7c3a1e] bg-[#f5ede6] text-[#2d1a0e] font-semibold' : 'border-transparent text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4]'); ?>">
                Tenants
            </a>
            <a href="<?php echo e(route('finances')); ?>"
               class="flex items-center px-5 py-[9px] text-[13px] font-medium border-l-[3px] transition-colors
                      <?php echo e(request()->routeIs('finances') ? 'border-[#7c3a1e] bg-[#f5ede6] text-[#2d1a0e] font-semibold' : 'border-transparent text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4]'); ?>">
                Finances
            </a>
            <a href="<?php echo e(route('maintenance')); ?>"
               class="flex items-center px-5 py-[9px] text-[13px] font-medium border-l-[3px] transition-colors
                      <?php echo e(request()->routeIs('maintenance') ? 'border-[#7c3a1e] bg-[#f5ede6] text-[#2d1a0e] font-semibold' : 'border-transparent text-gray-400 hover:text-[#2d1a0e] hover:bg-[#faf7f4]'); ?>">
                Maintenance
            </a>
        </nav>

        
        <div class="px-5 py-4 border-t border-[#ede7df] space-y-1">
            <a href="#" class="flex items-center gap-2 text-[12px] text-gray-400 hover:text-[#7c3a1e] transition-colors py-0.5">
                <span class="text-[11px]">❓</span> Help Center
            </a>
            <a href="<?php echo e(route('login')); ?>" class="flex items-center gap-2 text-[12px] text-gray-400 hover:text-[#7c3a1e] transition-colors py-0.5">
                <span class="text-[11px]">↩</span> Logout
            </a>
        </div>
    </aside>

    
    <header class="fixed top-0 left-48 right-0 h-14 bg-white border-b border-[#ede7df] flex items-center justify-between px-8 z-40">
        <span class="font-[Playfair_Display] font-bold text-xl text-[#2d1a0e]">NaVi</span>
        <div class="flex items-center gap-3">
            <button class="w-8 h-8 rounded-full bg-[#f5f0eb] flex items-center justify-center text-gray-500 hover:bg-[#ede7df] transition-colors text-sm">🔔</button>
            <button class="w-8 h-8 rounded-full bg-[#f5f0eb] flex items-center justify-center text-gray-500 hover:bg-[#ede7df] transition-colors text-sm">⚙️</button>
            <div class="w-8 h-8 rounded-full bg-[#4a3728] flex items-center justify-center text-white text-[10px] font-bold">MG</div>
        </div>
    </header>

    
    <main class="ml-48 mt-14 p-8 min-h-[calc(100vh-56px)]">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

</body>
</html>
<?php /**PATH C:\Users\boome\OneDrive\Desktop\navi-laravel test\resources\views/layouts/app.blade.php ENDPATH**/ ?>