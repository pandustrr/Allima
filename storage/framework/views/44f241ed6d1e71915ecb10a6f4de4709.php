<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <div class="bg-[#0ABAB5] text-white py-12 md:py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-2">Selamat Datang di TokoBuku Online</h2>
            <h3 class="text-xl md:text-2xl mb-8">Temukan buku berkualitas dengan harga terbaik</h3>
            <a href="#produk" class="inline-block bg-white text-[#0ABAB5] font-bold rounded-full py-3 px-6 md:py-4 md:px-8 shadow-lg uppercase tracking-wider hover:bg-gray-100 transition duration-300">
                Lihat Koleksi Buku
            </a>
        </div>
    </div>

    <!-- Product Section -->
    <section id="produk" class="container mx-auto px-4 sm:px-6 py-8 md:py-12">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 md:mb-8 text-center">Koleksi Buku</h2>

        <?php if($products->isEmpty()): ?>
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">Belum ada buku yang tersedia saat ini.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 flex flex-col h-full">
                    <!-- Foto Buku -->
                    <div class="relative h-40 sm:h-48 md:h-56 overflow-hidden">
                        <img src="<?php echo e($product->foto_url); ?>" alt="<?php echo e($product->judul); ?>"
                             class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        <?php if($product->stok > 0): ?>
                            <span class="absolute top-2 right-2 bg-[#56DFCF] text-white text-xs px-2 py-1 rounded-full">
                                Tersedia (<?php echo e($product->stok); ?>)
                            </span>
                        <?php else: ?>
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                Stok Habis
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Detail Buku -->
                    <div class="p-3 md:p-4 flex flex-col flex-grow">
                        <h3 class="font-bold text-sm md:text-base lg:text-lg mb-1 md:mb-2 text-gray-800 line-clamp-2"><?php echo e($product->judul); ?></h3>
                        <p class="text-gray-600 text-xs md:text-sm mb-2">Oleh: <?php echo e($product->penulis); ?></p>

                        <div class="mt-auto">
                            <div class="flex justify-between items-center mb-2 md:mb-3">
                                <span class="font-bold text-[#0ABAB5] text-sm md:text-base">
                                    Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?>

                                </span>
                                <?php if($product->stok > 0): ?>
                                    <span class="hidden sm:inline text-xs text-gray-500">
                                        <?php echo e($product->halaman); ?> hlm
                                    </span>
                                <?php endif; ?>
                            </div>

                            <a href="<?php echo e(route('product.show', $product->id)); ?>"
                               class="block w-full bg-[#0ABAB5] hover:bg-[#56DFCF] text-white text-center text-xs md:text-sm font-medium py-2 px-2 md:py-2 md:px-4 rounded transition duration-300">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Pandu-Projek\e-com\resources\views/home.blade.php ENDPATH**/ ?>