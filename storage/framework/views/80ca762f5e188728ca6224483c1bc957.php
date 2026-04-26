<?php $__env->startSection('title', 'Maintenance Board'); ?>

<?php $__env->startSection('content'); ?>


<h1 class="font-[Playfair_Display] text-[32px] font-bold text-[#2d1a0e] mb-6">Maintenance Board</h1>


<div class="grid grid-cols-3 gap-6">

    
    <div class="col-span-2 space-y-4">

        
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-white border border-[#ede7df] rounded-lg px-3.5 py-2 text-[13px] text-[#2d1a0e] font-medium whitespace-nowrap">
                📅 May 2026
            </div>
            <button class="inline-flex items-center gap-2 border border-[#ede7df] bg-white text-gray-500 text-[12px] font-medium px-3.5 py-2 rounded-lg hover:border-[#7c3a1e] hover:text-[#7c3a1e] transition-colors whitespace-nowrap">
                ↓ Export Report
            </button>
            <div class="relative flex-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[13px]">🔍</span>
                <input type="text" placeholder="Search logs..."
                       class="w-full pl-8 pr-4 py-2 border border-[#e5e7eb] rounded-lg text-[12px] outline-none focus:border-[#7c3a1e] transition-colors bg-white text-gray-600">
            </div>
        </div>

        
        <div class="bg-white rounded-xl border border-[#ede7df] overflow-hidden">
            <table class="w-full">
                <thead class="bg-[#faf7f4]">
                    <tr>
                        <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Reference ID</th>
                        <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Subject / Issue</th>
                        <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Location / Unit</th>
                        <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Assigned To</th>
                        <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Priority</th>
                        <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Status</th>
                        <th class="text-left text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 px-4 py-3">Reported</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-t border-[#f0ebe5] hover:bg-[#faf7f4] transition-colors">
                        <td class="px-4 py-3.5 font-mono text-[11px] text-gray-400"><?php echo e($ticket['ref']); ?></td>
                        <td class="px-4 py-3.5 text-[13px] font-semibold text-[#2d1a0e]"><?php echo e($ticket['subject']); ?></td>
                        <td class="px-4 py-3.5">
                            <span class="text-[11px] text-gray-400 mr-0.5">📍</span>
                            <span class="text-[12px] text-gray-500"><?php echo e($ticket['location']); ?></span>
                        </td>
                        <td class="px-4 py-3.5">
                            <?php if($ticket['assigned']): ?>
                                <div class="w-7 h-7 rounded-full bg-[#7c3a1e] flex items-center justify-center text-white text-[9px] font-bold">
                                    <?php echo e($ticket['assignedInitials']); ?>

                                </div>
                            <?php else: ?>
                                <div class="flex items-center gap-1.5">
                                    <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-[10px]">👤</div>
                                    <span class="text-[10px] text-gray-400 font-medium uppercase tracking-wide">Unassigned</span>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3.5">
                            <?php if($ticket['priority'] === 'URGENT'): ?>
                                <span class="inline-block bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Urgent</span>
                            <?php elseif($ticket['priority'] === 'NORMAL'): ?>
                                <span class="inline-block bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Normal</span>
                            <?php else: ?>
                                <span class="inline-block bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Medium</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3.5">
                            <?php if($ticket['status'] === 'NEW'): ?>
                                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                                    🔵 New
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 bg-orange-50 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase whitespace-nowrap">
                                    🔄 In Progress
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3.5 text-[11px] text-gray-400 whitespace-nowrap"><?php echo e($ticket['reported']); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="space-y-4">

        
        <h3 class="text-[13px] font-bold text-[#2d1a0e]">Priority Maintenance</h3>

        
        <div class="bg-white rounded-xl border border-[#ede7df] p-4">
            <div class="flex items-start gap-3">
                <div class="w-11 h-11 bg-red-100 rounded-xl flex items-center justify-center text-[20px] flex-shrink-0">❄️</div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start gap-2 flex-wrap">
                        <span class="text-[13px] font-bold text-[#2d1a0e] leading-snug">Unit 103 – Air Conditioning Leak</span>
                        <span class="bg-red-100 text-red-700 text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wide whitespace-nowrap">High Priority</span>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Reported by Resident · 1h ago</p>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-xl border border-[#ede7df] p-5">
            <p class="text-[10px] font-semibold uppercase tracking-[0.1em] text-gray-400 mb-4">Summary</p>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">Open Tickets</span>
                    <span class="text-[13px] font-bold text-[#2d1a0e]"><?php echo e($openTickets); ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">In Progress</span>
                    <span class="text-[13px] font-bold text-orange-600"><?php echo e($inProgressTickets); ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">Resolved This Month</span>
                    <span class="text-[13px] font-bold text-green-600"><?php echo e($resolvedTickets); ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[13px] text-gray-500">Unassigned</span>
                    <span class="text-[13px] font-bold text-red-600"><?php echo e($unassignedTickets); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\boome\OneDrive\Desktop\navi-laravel test\resources\views/maintenance/index.blade.php ENDPATH**/ ?>