<?php $__env->startSection('title', 'Manajemen Penjualan'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Laporan Penjualan</h2>
        <div class="flex space-x-2">
            <a href="<?php echo e(route('admin.sales.index', ['period' => 'daily'])); ?>"
                class="px-4 py-2 rounded <?php echo e($period === 'daily' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'); ?>">
                Harian
            </a>
            <a href="<?php echo e(route('admin.sales.index', ['period' => 'weekly'])); ?>"
                class="px-4 py-2 rounded <?php echo e($period === 'weekly' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'); ?>">
                Mingguan
            </a>
            <a href="<?php echo e(route('admin.sales.index', ['period' => 'monthly'])); ?>"
                class="px-4 py-2 rounded <?php echo e($period === 'monthly' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'); ?>">
                Bulanan
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-blue-800">Total Penjualan</h3>
            <p class="text-2xl font-bold text-blue-600">Rp <?php echo e(number_format($totalSales, 0, ',', '.')); ?></p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-green-800">Total Pesanan</h3>
            <p class="text-2xl font-bold text-green-600"><?php echo e($totalOrders); ?></p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-purple-800">Periode</h3>
            <p class="text-xl font-bold text-purple-600">
                <?php if($period === 'daily'): ?>
                    Hari Ini
                <?php elseif($period === 'weekly'): ?>
                    Minggu Ini
                <?php else: ?>
                    Bulan Ini
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">No. Pesanan</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Pelanggan</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">PGTPQ</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Total</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Status</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Tanggal</th>
                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo e($order->order_number); ?></td>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo e($order->customer_name); ?></td>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo e($order->pgtpq); ?></td>
                    <td class="py-2 px-4 border-b border-gray-200">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></td>
                    <td class="py-2 px-4 border-b border-gray-200">
                    <span class="px-2 py-1 text-xs rounded-full
                        <?php if($order->status === 'selesai'): ?> bg-green-100 text-green-800
                        <?php elseif($order->status === 'dibatalkan'): ?> bg-red-100 text-red-800
                        <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                        <?php echo e(\App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status)); ?>

                    </span>
                    </td>
                    <td class="py-2 px-4 border-b border-gray-200"><?php echo e($order->created_at->format('d M Y H:i')); ?></td>
<td class="py-2 px-4 border-b border-gray-200">
    <div class="flex space-x-2">
        <a href="<?php echo e(route('admin.sales.show', $order)); ?>"
           class="text-blue-600 hover:text-blue-900"
           title="Detail">
            <i class="fas fa-eye"></i>
        </a>
        <form action="<?php echo e(route('admin.sales.destroy', $order)); ?>"
              method="POST"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit"
                    class="text-red-600 hover:text-red-900"
                    title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
</td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?php echo e($orders->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Pandu-Projek\e-com\resources\views/admin/sales/index.blade.php ENDPATH**/ ?>