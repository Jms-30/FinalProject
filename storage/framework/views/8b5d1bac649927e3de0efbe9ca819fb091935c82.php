

<?php $__env->startSection('content'); ?>

<h4 class="fw-bold mb-3">Tambah Karyawan</h4>

<?php if($errors->any()): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<form action="/employees" method="POST">
    <?php echo csrf_field(); ?>

    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Umur</label>
        <input type="number" name="age" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="address" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">No Telp</label>
        <input type="text" name="phone" class="form-control">
    </div>

    <button class="btn btn-success">Simpan</button>
    <a href="/employees" class="btn btn-secondary">Kembali</a>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('employees.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\LARAVEL\MidProject\resources\views/employees/create.blade.php ENDPATH**/ ?>