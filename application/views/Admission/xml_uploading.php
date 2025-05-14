<html>
<head>
	<meta charset="utf-8">
    
	<link href="<?php echo base_url('assets/css/bootstrap.css') ?> " rel="stylesheet">
    <link href="<?php echo base_url('assets/css/all.min.css') ?> " rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-icons.css') ?> " rel="stylesheet">
    <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">
	<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/dataTables.bootstrap5.min.js') ?>"></script>
    <link href="<?php echo base_url('assets/css/dataTables.bootstrap5.min.css') ?> " rel="stylesheet">
    
    
	<title> XML UPLOADING </title>
</head>
<body>
    
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"value="<?= $this->security->get_csrf_hash(); ?>">
    <script src="<?= base_url('application/components/xml_uploading.js') ?>"></script>
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
					<a class="nav-link"  id="btn-new-transaction" href="/eadmission_logbook/admission_form">
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
                <h4 class="text-center">Upload eClaims XML</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="xmlFile">Upload XML File</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="xmlFile" accept=".xml.enc">
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary" id="btn-upload-xml">Upload</button>
                        <button class="btn btn-danger"  id="btn-clear-table">Clear Data</button>
                        <button class="btn btn-success" id="btn-submit-data">Submit Data</button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="container">
    <h2>Extracted Patient Data</h2>
        <div style="overflow-x: auto; width: 100%; overflow-y: auto; height: 75%;  background-color:rgba(250, 250, 250, 0.81);"> 
            <table id="data-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Philhealth ID</th>
                        <th>Membership Type</th>
                        <th>Patient Name</th>
                        <th>Suffix</th>
                        <th>Patient Birthdate</th>
                        <th>Sex</th>
                        <th>Mobile Number</th>
                        <th>Email Address</th>
                        <th>Home Address</th>
                        <th>Member Name</th>
                        <th>Member Suffix</th>
                        <th>Email Address</th>
                        <th>Contact Number</th>
                        <th>Type of Benefit</th>
                        <th>Availment Type</th>
                        <th>Admission Date</th>
                        <th>Admission Time</th>
                        <th>Medical Code</th>
                        <th>Diagnosis</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data Rows Can Be Inserted Dynamically Using JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
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
</body>
</html>