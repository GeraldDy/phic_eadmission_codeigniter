<html>
<head>
	<meta charset="utf-8">
	<link href="<?php echo base_url('assets/css/bootstrap.css') ?> " rel="stylesheet">
    <link href="<?php echo base_url('assets/css/all.min.css') ?> " rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-icons.css') ?> " rel="stylesheet">
	<link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>  
	<script src="<?= base_url('assets/js/dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/dataTables.bootstrap5.min.js') ?>"></script>
    <link href="<?php echo base_url('assets/css/dataTables.bootstrap5.min.css') ?> " rel="stylesheet">  
	<title> <?= $title;?> </title>
</head>
<body>
	<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
    value="<?= $this->security->get_csrf_hash(); ?>">
    <script src="<?= base_url('application/components/dashboard.js') ?>"></script>
	<div class="container" style="padding-bottom: 20px;">
		<div class="card">
			<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #6BAA75">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item navbar-expand-lg-extend">
						<a class="nav-link" id="btn-new-transaction" href="/eadmission_logbook">
							<div class="bi bi-arrow-bar-left"> Dashboard </div> 
						</a>
					</li>

					<li class="nav-item navbar-expand-lg-extend">
						<a class="nav-link" id="btn-new-transaction" href="/eadmission_logbook/admission_form">
							<div class="bi bi-database-add"> Admission Form </div> 
						</a>
					</li>

					<li class="nav-item navbar-expand-lg-extend">
						<a class="nav-link" id="btn-new-transaction" href="/eadmission_logbook/upload-xml-index">
							<div class="bi bi-filetype-xml"> Extract Data </div> 
						</a>
					</li>

				</ul>
			</nav>
		</div>
		<div class="container">
			<h5 class="text-success fw-bold text-center mt-4">📋 Generate Admission Report</h5>
			<hr class="border-success opacity-50 w-50 mx-auto mb-4">

			<div class="container mt-3 d-flex justify-content-center">
				<div class="card border-0 shadow-deep shadow-lg" style="max-width: 500px; width: 100%; border: 2px solid #6BAA75;">
					<div class="card-header py-2 px-3 bg-success text-white">
						
					</div>
					<div class="card-body py-2 px-3">
						<div class="mb-2">
							<label for="start_date" class="form-label mb-1 small">Target Start Date</label>
							<input type="date" id="start_date" name="start_date" class="form-control form-control-sm" required>
						</div>
						<div class="mb-2">
							<label for="end_date" class="form-label mb-1 small">Target End Date</label>
							<input type="date" id="end_date" name="end_date" class="form-control form-control-sm" required>
						</div>
						<div class="text-end">
							<button type="submit" class="btn btn-sm btn-success" id="btn-generate-report">
								<i class="bi bi-file-earmark-bar-graph"></i> Generate
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="container mt-4">
				<div class="table-responsive shadow-sm rounded">
					<table id="data-table" class="table table-bordered table-hover table-striped align-middle mb-0">
						<thead class="table-success text-center">
						<tr>
							<th><i class="bi bi-hash"></i> Reference Number</th>
							<th><i class="bi bi-hospital"></i> Admission Code</th>
							<th><i class="bi bi-calendar-check"></i> Admission Date</th>
							<th><i class="bi bi-clock-history"></i> Date Submitted</th>
						</tr>
					</thead>
					<tbody>
						<!-- JavaScript will populate rows -->
					</tbody>
					</table>
				</div>
			</div>

		
		</div>
	</div>
</body>
</html>

<script>
	document.addEventListener("DOMContentLoaded", function () {
    var navLinks = document.querySelectorAll(".nav-link");
    var currentPath = window.location.pathname.replace(/\/$/, ""); // Normalize URL (remove trailing slash)

    navLinks.forEach(function (link) {
        var linkPath = link.getAttribute("href").replace(/\/$/, ""); // Normalize href

        if (linkPath === currentPath) {
            link.classList.add("active"); // Add active class
            link.style.backgroundColor = "#5C9A65"; // Highlight active link
            link.style.color = "white";
        }

        // Add hover effect
        link.addEventListener("mouseover", function () {
            this.style.backgroundColor = "#5C9A65";
            this.style.color = "white";
        });

        link.addEventListener("mouseout", function () {
            if (!this.classList.contains("active")) { // Keep active link highlighted
                this.style.backgroundColor = "transparent";
                this.style.color = "black";
            }
        });
    });
});
</script>