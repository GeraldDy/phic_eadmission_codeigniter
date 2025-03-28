<html>
<head>
	<meta charset="utf-8">
	<link href="<?php echo base_url('assets/css/bootstrap.css') ?> " rel="stylesheet">
    <link href="<?php echo base_url('assets/css/all.min.css') ?> " rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-icons.css') ?> " rel="stylesheet">
	<link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>    
	<title> <?= $title;?> </title>
</head>
<body>
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
		<div class="card-header">
            <h4 class="text-center">eAdmission Logbook</h4>
		</div>
	</div>
	<div class="container">
    <h2>List</h2>
    <div style="overflow-x: auto; width: 100%; overflow-y: auto; height: 75%;  background-color:rgba(250, 250, 250, 0.81);"> 
        <table id="data-table" class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
					<th class="text-center">PhilHealth Number</th>
                    <th class="text-center">Reference Number</th>
                    <th class="text-center">Admission Date</th>
                    <th class="text-center">Date Submitted</th>
                </tr>
				
            </thead>
            <tbody>
			<?php if (!empty($admission_data) ) : ?>
				<?php $count = 1; ?>
				
				<?php foreach ($admission_data as $row) : ?>
					<tr>
						<td><?= $count++; ?></td>
						<td class="text-center"><?= htmlspecialchars($row['philhealthIdNum']) ?></td>
						<td class="text-center"><?= htmlspecialchars($row['referenceNumber']) ?></td>
						<td class="text-center"><?= date('M d, Y', strtotime(str_replace('-', '/',$row['admissionDate'])) )?></td>
						<td class="text-center"><?= date('M d, Y h:i A', strtotime(str_replace('-', '/',$row['dateSubmitted']) ))?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan="5" class="text-center">No data available</td>
				</tr>
			<?php endif; ?>
            </tbody>
        </table>
    </div>


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
</div>
</body>
</html>