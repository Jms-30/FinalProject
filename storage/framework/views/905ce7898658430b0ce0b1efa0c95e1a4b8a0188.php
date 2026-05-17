<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Londo Bell</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #d9b0b0; /* Soft blue background */
        }

        .navbar {
            background-color: #070b11; /* Primary blue */
        }

        .card {
            border-radius: 12px;
        }

        .btn-primary, .btn-success, .btn-warning, .btn-danger {
            border-radius: 8px;
        }

        table th {
            background-color: #90a9cf;
            color: white;
        }

        table tbody tr:hover {
            background-color: #071b37;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/employees">PT Londo Bell</a>
    </div>
</nav>

<div class="container">
    <div class="card shadow-sm p-3">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html><?php /**PATH C:\Users\Lenovo\OneDrive\Documents\James_MidProject\MidProject\resources\views/employees/layout.blade.php ENDPATH**/ ?>