<?php $__env->startSection('title', $product->judul); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Foto Produk -->
                    <div>
                        <img src="<?php echo e($product->foto_url); ?>" alt="<?php echo e($product->judul); ?>"
                             class="w-full h-auto rounded-lg shadow-md border border-gray-200">
                    </div>

                    <!-- Detail Produk -->
                    <div class="space-y-4">
                        <h1 class="text-2xl font-bold text-gray-900"><?php echo e($product->judul); ?></h1>
                        <p class="text-gray-600">Oleh: <?php echo e($product->penulis); ?></p>

                        <div class="flex items-center">
                            <span class="text-2xl font-bold text-[#0ABAB5]">
                                Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?>

                            </span>
                            <?php if($product->stok > 0): ?>
                                <span class="ml-4 px-2 py-1 text-xs font-medium rounded-full bg-[#ADEED9] text-green-800">
                                    Stok Tersedia (<?php echo e($product->stok); ?>)
                                </span>
                            <?php else: ?>
                                <span class="ml-4 px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                    Stok Habis
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Form Tambah ke Keranjang -->
                        <?php if($product->stok > 0): ?>
                        <form action="<?php echo e(route('cart.add', $product)); ?>" method="POST" class="mt-6">
                            <?php echo csrf_field(); ?>
                            <div class="flex items-center space-x-4">
                                <div class="w-24">
                                    <label for="quantity" class="sr-only">Jumlah</label>
                                    <input type="number" id="quantity" name="quantity" min="1" max="<?php echo e($product->stok); ?>"
                                           value="1" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                                </div>
                                <button type="submit"
                                        class="flex-1 bg-[#0ABAB5] hover:bg-[#56DFCF] text-white px-6 py-3 rounded-md font-medium transition duration-150">
                                    + Tambah ke Keranjang
                                </button>
                            </div>
                        </form>
                        <?php endif; ?>

                        <!-- Deskripsi -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Deskripsi Produk</h3>
                            <p class="text-gray-600 leading-relaxed"><?php echo e($product->deskripsi); ?></p>
                        </div>

                        <!-- Detail Buku -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Detail Buku</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">Halaman:</span> <?php echo e($product->halaman ?? '-'); ?>

                                </div>
                                <div>
                                    <span class="font-medium">Panjang:</span>
                                    <?php echo e($product->panjang && $product->lebar ? $product->panjang.'cm x '.$product->lebar.'cm' : '-'); ?>

                                </div>
                                <div>
                                    <span class="font-medium">Berat:</span>
                                    <?php echo e($product->berat ? $product->berat.' gram' : '-'); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Pandu-Projek\e-com\resources\views/produk-detail.blade.php ENDPATH**/ ?>