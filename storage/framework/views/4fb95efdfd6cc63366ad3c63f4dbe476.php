<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Produk: <?php echo e($product->judul); ?></h1>
        <div>
            <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition mr-2">
                Edit
            </a>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/3 p-6">
                <img src="<?php echo e($product->foto_url); ?>" alt="<?php echo e($product->judul); ?>" class="w-full h-auto rounded-lg">
            </div>
            <div class="md:w-2/3 p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-gray-800"><?php echo e($product->judul); ?></h2>
                    <p class="text-gray-600">Oleh: <?php echo e($product->penulis); ?></p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Harga</p>
                        <p class="text-lg font-bold text-blue-600">Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Stok Tersedia</p>
                        <p class="text-lg font-bold <?php echo e($product->stok > 0 ? 'text-green-600' : 'text-red-600'); ?>">
                            <?php echo e($product->stok); ?> buku
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Bahasa</p>
                        <p class="text-gray-800"><?php echo e($product->bahasa); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Halaman</p>
                        <p class="text-gray-800"><?php echo e($product->halaman ?? '-'); ?></p>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi</h3>
                    <p class="text-gray-700 whitespace-pre-line"><?php echo e($product->deskripsi); ?></p>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Detail Fisik</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Panjang</p>
                            <p class="text-gray-800"><?php echo e($product->panjang ? $product->panjang.' cm' : '-'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Lebar</p>
                            <p class="text-gray-800"><?php echo e($product->lebar ? $product->lebar.' cm' : '-'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Berat</p>
                            <p class="text-gray-800"><?php echo e($product->berat ? $product->berat.' gram' : '-'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Pandu-Projek\e-com\resources\views/admin/products/show.blade.php ENDPATH**/ ?>