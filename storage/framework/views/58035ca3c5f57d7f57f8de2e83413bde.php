<?php $__env->startSection('title', $product->judul); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail Produk</h1>
            <a href="<?php echo e(route('home')); ?>"
                class="inline-flex items-center px-4 py-2 bg-[#56DFCF] text-gray-800 rounded-md hover:bg-[#0ABAB5] transition duration-150 ease-in-out">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>

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
                            <?php if($product->available_stock > 0): ?>
                                <span class="ml-4 px-2 py-1 text-xs font-medium rounded-full bg-[#ADEED9] text-green-800">
                                    Stok Tersedia (<?php echo e($product->available_stock); ?>)
                                </span>
                            <?php else: ?>
                                <span class="ml-4 px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                    Stok Habis
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Form Tambah ke Keranjang -->
                        <?php if($product->available_stock > 0): ?>
                        <form action="<?php echo e(route('cart.add', $product)); ?>" method="POST" class="mt-6 add-to-cart-form">
                            <?php echo csrf_field(); ?>
                            <div class="flex items-center space-x-4">
                                <div class="w-24">
                                    <label for="quantity" class="sr-only">Jumlah</label>
                                    <input type="number" id="quantity" name="quantity"
                                           min="1" max="<?php echo e($product->available_stock); ?>"
                                           value="1" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                                </div>
                                <button type="submit"
                                        class="flex-1 bg-[#0ABAB5] hover:bg-[#56DFCF] text-white px-6 py-3 rounded-md font-medium transition duration-150 flex items-center justify-center">
                                    <i class="fas fa-cart-plus mr-2"></i>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </form>
                        <?php else: ?>
                        <div class="mt-6">
                            <button disabled class="w-full bg-gray-400 text-white px-6 py-3 rounded-md font-medium cursor-not-allowed">
                                Stok Habis
                            </button>
                        </div>
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

<!-- Notifikasi -->
<div id="notification" class="fixed bottom-4 right-4 hidden">
    <div class="bg-[#0ABAB5] text-white px-4 py-3 rounded-md shadow-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span id="notification-message"></span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi showNotification
    function showNotification(message, isError = false) {
        const notification = document.getElementById('notification');
        const messageEl = document.getElementById('notification-message');

        messageEl.textContent = message;

        notification.firstElementChild.className = isError
            ? 'bg-red-500 text-white px-4 py-3 rounded-md shadow-lg flex items-center'
            : 'bg-[#0ABAB5] text-white px-4 py-3 rounded-md shadow-lg flex items-center';

        // Set ikon
        notification.firstElementChild.innerHTML = `
            <i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'} mr-2"></i>
            <span id="notification-message">${message}</span>
        `;

        // Tampilkan notifikasi
        notification.classList.remove('hidden');

        // Sembunyikan setelah 3 detik
        setTimeout(() => {
            notification.classList.add('hidden');
        }, 3000);
    }

    // Tangani form tambah ke keranjang
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const button = form.querySelector('button');
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menambahkan...';

            try {
                const formData = new FormData(form);
                const quantity = formData.get('quantity');

                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        _token: '<?php echo e(csrf_token()); ?>',
                        quantity: quantity
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Update jumlah keranjang di navbar
                    const cartCountElements = document.querySelectorAll('.cart-count');
                    cartCountElements.forEach(el => {
                        el.textContent = data.cartCount;
                        el.classList.remove('hidden');
                    });

                    // Update tampilan stok
                    const stockElement = document.querySelector('.ml-4.px-2.py-1.text-xs.font-medium.rounded-full');
                    if (stockElement) {
                        const currentStock = parseInt(stockElement.textContent.match(/\d+/)[0]);
                        const newStock = currentStock - quantity;

                        if (newStock > 0) {
                            stockElement.textContent = `Stok Tersedia (${newStock})`;
                            // Update max quantity
                            form.querySelector('input[name="quantity"]').max = newStock;
                        } else {
                            stockElement.classList.remove('bg-[#ADEED9]', 'text-green-800');
                            stockElement.classList.add('bg-red-100', 'text-red-800');
                            stockElement.textContent = 'Stok Habis';

                            // Nonaktifkan form
                            button.disabled = true;
                            button.classList.remove('bg-[#0ABAB5]', 'hover:bg-[#56DFCF]');
                            button.classList.add('bg-gray-400', 'cursor-not-allowed');
                            button.innerHTML = '<i class="fas fa-ban mr-2"></i>Stok Habis';
                        }
                    }

                    // Tampilkan notifikasi
                    showNotification(data.message);
                } else {
                    showNotification(data.message, true);
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', true);
            } finally {
                if (!button.disabled) {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Pandu-Projek\e-com\resources\views/produk-detail.blade.php ENDPATH**/ ?>