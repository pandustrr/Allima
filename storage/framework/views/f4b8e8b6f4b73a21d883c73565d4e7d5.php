<?php $__env->startSection('title', 'Detail User'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded shadow p-6 max-w-lg mx-auto">
    <h2 class="text-xl font-semibold mb-6">Detail User</h2>

    <div class="space-y-4">
        <div>
            <label class="block text-gray-600 mb-1">Username</label>
            <p class="bg-gray-100 p-2 rounded"><?php echo e($user->username); ?></p>
        </div>

        <div>
            <label class="block text-gray-600 mb-1">Password</label>
            <div class="flex items-center">
                <p class="bg-gray-100 p-2 rounded font-mono flex-1" id="passwordField">••••••••</p>
                <button
                    type="button"
                    onclick="togglePassword()"
                    class="ml-2 text-sm bg-blue-100 text-blue-600 px-3 py-1 rounded hover:bg-blue-200"
                >
                    Tampilkan
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">Password ini hanya untuk admin dan tidak disimpan sebagai teks biasa di database</p>
        </div>

        <div class="pt-4 border-t mt-4 flex justify-between">
            <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                Kembali
            </a>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('passwordField');
        const button = event.target;

        if (passwordField.textContent === '••••••••') {
            // Tampilkan password sementara
            passwordField.textContent = '<?php echo e($tempPassword); ?>';
            button.textContent = 'Sembunyikan';
        } else {
            passwordField.textContent = '••••••••';
            button.textContent = 'Tampilkan';
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Pandu-Projek\e-com\resources\views/admin/users/show.blade.php ENDPATH**/ ?>