

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary">Daftar Karyawan</h3>
    <a href="/employees/create" class="btn btn-success fw-bold">+ Tambah Karyawan</a>
</div>

<table class="table table-hover align-middle text-center">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Umur</th>
            <th>Alamat</th>
            <th>Telp</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($e->name); ?></td>
            <td><?php echo e($e->age); ?></td>
            <td><?php echo e($e->address); ?></td>
            <td><?php echo e($e->phone); ?></td>
            <td class="d-flex justify-content-center gap-2">
                <a href="/employees/<?php echo e($e->id); ?>/edit" class="btn btn-warning btn-sm fw-bold">Edit</a>
                <form action="/employees/<?php echo e($e->id); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-danger btn-sm fw-bold" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="5" class="text-muted">None</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('employees.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\OneDrive\Documents\James_MidProject\MidProject\resources\views/employees/index.blade.php ENDPATH**/ ?>