

<?php $__env->startSection('content'); ?>

<h3 class="text-primary fw-bold mb-4">Tambah Karyawan</h3>

<?php if($errors->any()): ?>
<div class="alert alert-danger">
    <ul class="mb-0">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<form action="/employees" method="POST" class="row g-3">
    <?php echo csrf_field(); ?>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Nama</label>
        <input type="text" name="name" class="form-control" placeholder="Enter">
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Umur</label>
        <input type="number" name="age" class="form-control" placeholder="Enter">
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Alamat</label>
        <textarea name="address" class="form-control" placeholder="Enter"></textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">No Telp</label>
        <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxx">
    </div>

    <div class="col-12 mt-3 d-flex gap-2">
        <button class="btn btn-success fw-bold">Simpan</button>
        <a href="/employees" class="btn btn-secondary fw-bold">Kembali</a>
    </div>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('employees.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lenovo\OneDrive\Documents\James_MidProject\MidProject\resources\views/employees/create.blade.php ENDPATH**/ ?>