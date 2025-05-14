<html>
<head>
	<meta charset="utf-8">
	<link href="<?php echo base_url('assets/css/bootstrap.css') ?> " rel="stylesheet">
    <link href="<?php echo base_url('assets/css/all.min.css') ?> " rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-icons.css') ?> " rel="stylesheet">
    <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            text-align: center;
        }
        .error-container {
            max-width: 600px;
            padding: 40px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .error-icon {
            font-size: 80px;
            color: #007bff;
        }
        .btn-home {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-home:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="error-container">
        <div class="error-icon">🔍</div>
        <h1 class="display-4 fw-bold text-primary">404</h1>
        <h2 class="text-dark">Page Not Found</h2>
        <p class="text-muted">The page you are looking for might have been moved, deleted, or does not exist.</p>
    </div>
</body>
</html>