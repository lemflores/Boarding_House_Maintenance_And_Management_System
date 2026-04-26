<?php $__env->startSection('title', 'Tenant Directory'); ?>

<?php $__env->startSection('content'); ?>


<div class="flex items-center justify-between mb-7">
    <h1 class="font-[Playfair_Display] text-[32px] font-bold text-[#2d1a0e]">Tenant Directory</h1>
    <button class="inline-flex items-center gap-2 bg-[#7c3a1e] hover:bg-[#5c2910] text-white text-[13px] font-semibold px-4 py-2.5 rounded-lg transition-colors shadow">
        👤+ Add New Tenant
    </button>
</div>


<div class="grid grid-cols-3 gap-4 mb-7">
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Total Residents</p>
        <p class="text-[34px] font-bold text-[#2d1a0e] leading-none"><?php echo e($totalResidents); ?></p>
    </div>
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Active Leases</p>
        <p class="text-[34px] font-bold text-[#2d1a0e] leading-none"><?php echo e($activeLeases); ?></p>
        <p class="text-[11px] text-orange-600 mt-2">⏱ <?php echo e($expiringLeases); ?> expiring soon</p>
    </div>
    <div class="bg-white rounded-xl border border-[#ede7df] p-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-2">Occupancy Rate</p>
        <p class="text-[34px] font-bold text-[#2d1a0e] leading-none"><?php echo e($occupancyRate); ?>%</p>
        <div class="mt-3 h-1.5 bg-[#ede7df] rounded-full overflow-hidden">
            <div class="h-full bg-[#7c3a1e] rounded-full" style="width:<?php echo e($occupancyRate); ?>%"></div>
        </div>
    </div>
</div>


<div class="bg-white rounded-xl border border-[#ede7df] overflow-hidden">

    
    <div class="flex items-center justify-between px-6 py-4 border-b border-[#ede7df]">
        <p class="text-[12px] text-gray-400">Displaying 1–<?php echo e(count($tenants)); ?> of <?php echo e($totalResidents); ?> tenants</p>
        <form method="GET" action="<?php echo e(route('tenants')); ?>">
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[13px]">🔍</span>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       placeholder="Search tenants..."
                       class="pl-8 pr-4 py-2 border border-[#e5e7eb] rounded-lg text-[12px] text-gray-600 outline-none focus:border-[#7c3a1e] transition-colors w-52 bg-white">
            </div>
        </form>
    </div>

    
    <table class="w-full">
        <thead class="bg-[#faf7f4]">
            <tr>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-6 py-3">Tenant</th>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Unit</th>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Lease Period</th>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Status</th>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Payment</th>
                <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-t border-[#f0ebe5] hover:bg-[#faf7f4] transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0"
                             style="background-color:<?php echo e($tenant['color']); ?>">
                            <?php echo e($tenant['initials']); ?>

                        </div>
                        <span class="text-[13px] font-semibold text-[#2d1a0e]"><?php echo e($tenant['name']); ?></span>
                    </div>
                </td>
                <td class="px-4 py-4 text-[13px] text-gray-500"><?php echo e($tenant['unit']); ?></td>
                <td class="px-4 py-4">
                    <p class="text-[13px] text-gray-700"><?php echo e($tenant['leasePeriod']); ?></p>
                    <p class="text-[11px] <?php echo e($tenant['leaseUrgency']); ?> mt-0.5 uppercase tracking-wide font-medium"><?php echo e($tenant['leaseRemaining']); ?></p>
                </td>
                <td class="px-4 py-4">
                    <?php if($tenant['statusBadge'] === 'green'): ?>
                        <span class="inline-block bg-green-100 text-green-800 text-[11px] font-semibold px-2.5 py-0.5 rounded-full"><?php echo e($tenant['status']); ?></span>
                    <?php elseif($tenant['statusBadge'] === 'orange'): ?>
                        <span class="inline-block bg-orange-100 text-orange-700 text-[11px] font-semibold px-2.5 py-0.5 rounded-full"><?php echo e($tenant['status']); ?></span>
                    <?php else: ?>
                        <span class="inline-block bg-gray-100 text-gray-600 text-[11px] font-semibold px-2.5 py-0.5 rounded-full"><?php echo e($tenant['status']); ?></span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-4">
                    <span class="text-[13px] <?php echo e($tenant['paymentColor']); ?> font-medium">
                        <?php echo e($tenant['paymentIcon']); ?> <?php echo e($tenant['payment']); ?>

                    </span>
                </td>
                <td class="px-4 py-4">
                    <button class="text-gray-300 hover:text-gray-500 text-xl leading-none px-1 transition-colors">⋮</button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    
    <div class="flex items-center justify-between px-6 py-4 border-t border-[#ede7df]">
        <button class="inline-flex items-center gap-1 border border-[#e5e7eb] text-gray-500 text-[12px] font-medium px-4 py-1.5 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors bg-white">
            ← Previous
        </button>
        <div class="flex items-center gap-1.5">
            <button class="w-8 h-8 rounded-lg bg-[#7c3a1e] text-white text-[12px] font-bold">1</button>
            <button class="w-8 h-8 rounded-lg border border-[#e5e7eb] text-gray-500 text-[12px] hover:border-[#7c3a1e] transition-colors">2</button>
            <button class="w-8 h-8 rounded-lg border border-[#e5e7eb] text-gray-500 text-[12px] hover:border-[#7c3a1e] transition-colors">3</button>
            <span class="text-gray-300 text-[12px] px-1">…</span>
            <button class="w-8 h-8 rounded-lg border border-[#e5e7eb] text-gray-500 text-[12px] hover:border-[#7c3a1e] transition-colors">12</button>
        </div>
        <button class="inline-flex items-center gap-1 border border-[#e5e7eb] text-gray-500 text-[12px] font-medium px-4 py-1.5 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors bg-white">
            Next →
        </button>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\boome\OneDrive\Desktop\navi-laravel test\resources\views/tenants/index.blade.php ENDPATH**/ ?>