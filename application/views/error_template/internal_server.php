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
            color: #dc3545;
        }
        .btn-retry {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-retry:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">🚨</div>
        <h1 class="display-4 fw-bold text-danger">500</h1>
        <h2 class="text-dark">Internal Server Error</h2>
        <p class="text-muted">Oops! Something went wrong on our end. Please try again later or contact support.</p>
    </div>
</body>
</html>