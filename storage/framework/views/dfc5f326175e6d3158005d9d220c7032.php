<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo dan Menu Utama -->
            <div class="flex items-center">
                <!-- Logo -->
                <a href="<?php echo e(route('home')); ?>" class="flex items-center">
                    <span class="text-xl font-bold text-gray-800">'Allima</span>
                </a>

                <!-- Menu Desktop -->
                <div class="hidden md:ml-8 md:flex md:space-x-4">
                    <a href="<?php echo e(route('home')); ?>" class="px-3 py-2 rounded-md text-sm font-medium text-[#0ABAB5] hover:bg-[#ADEED9]">Beranda</a>
                    <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-[#0ABAB5] hover:bg-[#ADEED9]">Tentang Kami</a>
                    <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-[#0ABAB5] hover:bg-[#ADEED9]">Kontak</a>
                </div>
            </div>

            <!-- Menu Kanan -->
            <div class="flex items-center space-x-4">
                <!-- Keranjang -->
                <a href="<?php echo e(route('cart.index')); ?>" class="p-1 rounded-full text-gray-600 hover:text-[#0ABAB5] relative">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <?php
                        $cartCount = \App\Models\Cart::where('session_id', session('cart_session_id'))
                            ->first()
                            ?->items
                            ->sum('quantity') ?? 0;
                    ?>
                    <span class="cart-count <?php echo e($cartCount == 0 ? 'hidden' : ''); ?> absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-[#0ABAB5] rounded-full">
                        <?php echo e($cartCount); ?>

                    </span>
                </a>

                <!-- Tombol Menu Mobile -->
                <div class="md:hidden ml-2">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-[#0ABAB5] hover:bg-[#ADEED9] focus:outline-none mobile-menu-button">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white">
            <a href="<?php echo e(route('home')); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-[#0ABAB5] bg-[#ADEED9]">Beranda</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-[#0ABAB5] hover:bg-[#ADEED9]">Tentang Kami</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-[#0ABAB5] hover:bg-[#ADEED9]">Kontak</a>
            <a href="<?php echo e(route('cart.index')); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-[#0ABAB5] hover:bg-[#ADEED9]">Keranjang</a>
        </div>
    </div>
</nav>

<script>
    document.querySelector('.mobile-menu-button')?.addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
<?php /**PATH E:\Pandu-Projek\e-com\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>