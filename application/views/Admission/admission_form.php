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
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
    value="<?= $this->security->get_csrf_hash(); ?>">
    <script src="<?= base_url('application/components/admission_form.js') ?>"></script>
    <div class="container" style="padding-bottom: 20px;">
        <div class="card">
            <nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #6BAA75">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item navbar-expand-lg-extend">
                        <a class="nav-link " id="btn-new-transaction" href="/eadmission_logbook" style="border-radius: 5px; transition: background-color 0.3s ease-in-out;" onmouseover="this.style.backgroundColor='#5C9A65'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='black';">
                            <div class="bi bi-arrow-bar-left"> Dashboard </div> 
                        </a>
                    </li>

                    
                    <li class="nav-item navbar-expand-lg-extend">
                        <a class="nav-link " style="border-radius: 5px; transition: background-color 0.3s ease-in-out;" onmouseover="this.style.backgroundColor='#5C9A65'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='black';" id="btn-new-transaction" href="/eadmission_logbook/admission_form">
                            <div class="bi bi-database-add"> Admission Form </div> 
                        </a>
                    </li>

                    <li class="nav-item navbar-expand-lg-extend">
                        <a class="nav-link " id="btn-new-transaction" href="/eadmission_logbook/upload-xml-index" style="border-radius: 5px; transition: background-color 0.3s ease-in-out;" onmouseover="this.style.backgroundColor='#5C9A65'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='black';">
                            <div class="bi bi-filetype-xml"> Extract Data </div> 
                        </a>
                    </li>
                </ul>
            </nav>
           
            <div class="card-header">
                <h4 class="text-center">Admission Form</h4>
            </div>
            <div class="card-header"> 
                    Patient Details
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for=""> Case Number <span style="color: red;font-weight: bold;margin-left: 5px;">*</span>  </label>
                            <input type="text" class="form-control" id="caseNumber" data-error="#case-number">
                            <span id="case-number" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>PhilHealth Identification Number<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="text" id="philhealthID" data-error="#philhealt-id">
                            <span id="philhealt-id" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>PhilHealth Membership Type<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <select class="form-select" id="membershipType" data-error="#membershipType-select">
                                <option selected value="">-- SELECT --</option>
                                <option value="D">Dependent</option>
                                <option value="M">Member</option>
                            </select>
                            <span id="membershipType-select" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Patient Firstname  <span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="text" id="firstName" data-error="#first-name">
                            <span id="first-name" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>
                    

                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Patient Middlename<span style="color: red;font-weight: bold;margin-left: 5px;">*</span> </label>
                            <input class="form-control" type="text" id="middleName" data-error="#middle-name">
                            <span id="middle-name" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Patient Lastname <span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="text" data-error="#last_name" id="lastName">
                            <span id="last_name" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Suffix </label>
                            <input class="form-control" type="text" id="suffixName">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-check">
                            <label class="form-check-label" for="gridCheck">
                                Is mononym
                            </label>
                            <input class="form-check-input" type="checkbox" id="checkMononym">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <label>Birthdate<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                        <input class="form-control" type="date" value="" id="birthDate" data-error="#birth-date">
                        <span id="birth-date" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                    </div>
        
                    <div class="col-md-2">
                        <label>Sex<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                        <select class="form-select" id="genderSelect" data-error="#gender-select">
                            <option selected value="">-- SELECT --</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                        <span id="gender-select" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Nationality<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="text" id="Nationality" data-error="#nationality-error">
                            <span id="nationality-error" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Mobile Number<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="text" id="mobileNumber" data-error="#mobile-number">
                            <span id="mobile-number" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Email Address<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="email" id="emailAddress" data-error="#email-address">
                            <span id="email-address" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>
                </div>
<!-- 
                <div class="row" style="display: none;" id="address-data-container">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="text" id="xmlAddress" data-error="#address-error" >
                            <span id="address-error" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>
                </div> -->

                <div class="row" id="street-container">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Street<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="text" id="street" data-error="#street-error">
                            <span id="street-error" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>
                </div>

                <div class="row" id="address-details-container">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Barangay<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="text" id="barangay" data-error="#barangay-error">
                            <span id="barangay-error" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>City<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="text" id="city" data-error="#city-error">
                            <span id="city-error" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Region<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="text" id="region" data-error="#region-error">
                            <span id="region-error" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Province<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                            <input class="form-control" type="text" id="province" data-error="#province-error">
                            <span id="province-error" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Zip Code <span style="color: red;font-weight: bold;margin-left: 5px;">*</span> </label>
                            <input class="form-control" type="text" id="zipCode" data-error="#zip-code-error">
                            <span id="zip-code-error" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-header"> 
                Members Information
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Member Firstname<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                                <input class="form-control" type="text" id="memberFirstname" data-error="#member-firstname">
                                <span id="member-firstname" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                            </div>
                        </div>
                        

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Member Middlename<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                                <input class="form-control" type="text" id="memberMiddlename" data-error="#member-middlename">
                                <span id="member-middlename" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Member Lastname<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                                <input class="form-control" type="text" id="memberLastname" data-error="#member-lastname">
                                <span id="member-lastname" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Member Suffix</label>
                                <input class="form-control" type="text" id="memberSuffix">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Address<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                                <input class="form-control" type="text" id="memberEmailAddress" data-error="#member-email-address">
                                <span id="member-email-address" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact Number<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                                <input class="form-control" type="text" id="memberContactNumber" data-error="#contact-number">
                                <span id="contact-number" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="card-header"> 
                    Admission Details
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Type of Benefit Availment<span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                                <select class="form-select" id="typeBenefit" data-error="#admission-type-benefit-error">
                                    <option selected value="">-- Select --</option>
                                    <option value="1">All Case Rate - RVS</option>
                                    <option value="2">All Case Rate - ICD</option>
                                    <option value="3">Z Benefit Package</option>
                                </select>
                                <span id="admission-type-benefit-error" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Admission Date<span style="color: red;font-weight: bold;margin-left: 5px;">*</span> </label>
                                <input class="form-control" type="date" value="" id="admissionDate" data-error="#admission-date-error">
                                <span id="admission-date-error" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Admission Time<span style="color: red;font-weight: bold;margin-left: 5px;">*</span> </label>
                                <input class="form-control" type="time" value="" id="admissionTime" data-error="#admission-time-error">
                                <span id="admission-time-error" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Reason for Availment <span style="color: red;font-weight: bold;margin-left: 5px;">*</span> </label>
                                <select class="form-select" id="AvailmentCode" data-error="#availmentType">
                                    <option selected value="">-- Select --</option>
                                    <option value="1">Out Patient</option>
                                    <option value="2">In Patient</option>
                                    <option value="3">Z BENEFIT</option>
                                </select>
                                <span id="availmentType" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Medical Code / Procedure Code <span style="color: red;font-weight: bold;margin-left: 5px;">*</span></label>
                                <input class="form-control" type="text" id="admissionCodeType" data-error="#admissionCode" >
                                <span id="admissionCode" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-label">Admission Diagnosis
                                    <span style="color: red;font-weight: bold;margin-left: 5px;">*</span> 
                                </div>
                                <textarea class="form-control" type="text" id="AdmissionDiagnosis" data-error="#admissionDiagnosisError" > </textarea>
                                <span id="admissionDiagnosisError" class="text-red-500 text-sm" style="display: none;color: red;"></span>
                            </div>
                        </div>

                       
                    </div>
                </div>

                <div class="row" style="padding: 20px; display: block;" id="btn-submit-encoded-data">
                    <div class="col">
                        <div class="form-group">
                            <button  class="btn btn-primary" id="btn-submit">Submit</button>
                        </div>
                    </div>
                </div>
             
        </div>
    </div>
    <div class="modal"  id="confirmSaveModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title text-xl">Confirm Save</span>
                </div>
                <div class="modal-body">
                        <span> Are you sure you want to save?</span>
                </div>
                <div id="loadingIndicator" style="display:none; text-align: center; margin-top: 10px;">
                    Loading...
                </div>

                <div id="responseMessage" style="display:none; text-align: center; margin-top: 10px; color: green;">
                    <!-- This will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button  class="btn btn-primary btn-modal-create-confirm"  id="btn-modal-create-confirm">Confirm</button>
                    <button  class="btn btn-secondary" data-dismiss="modal" id="btn-modal-close">Close</button>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">eAdmission Logbook v1.0.2025.1</span>
        </div>
    </footer>

 
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


    let today = new Date();
    let todayStr = today.toISOString().split("T")[0];
    let pBirthdate = document.getElementById("birthDate");
    if (pBirthdate) {
        pBirthdate.setAttribute("max", todayStr);
    }
    pBirthdate.addEventListener("change", function () {
            if (this.value > todayStr) {
                this.value = todayStr; 
            }
    });

    //disable future date
    let admissionDate = document.getElementById("admissionDate");
    if (admissionDate) {
        admissionDate.setAttribute("max", todayStr);
    }
    admissionDate.addEventListener("change", function () {
            if (this.value > todayStr) {
                this.value = todayStr; 
            }
    });

    document.getElementById("firstName").addEventListener("input", function () {
        let regex = /^[A-Za-z\s]+$/; 
        let firstName = this.value;

        if (!regex.test(firstName)) {
            this.value = firstName.replace(/[^A-Za-z\s]/g, ""); 
        }
    });
    document.getElementById("middleName").addEventListener("input", function () {
        let regex = /^[A-Za-z\s]+$/; 
        let middleName = this.value;

        if (!regex.test(middleName)) {
            this.value = middleName.replace(/[^A-Za-z\s]/g, "");
        }
    });
    document.getElementById("lastName").addEventListener("input", function () {
        let regex = /^[A-Za-z\s]+$/; 
        let lastName = this.value;

        if (!regex.test(lastName)) {
            this.value = lastName.replace(/[^A-Za-z\s]/g, ""); 
        }
    });
    document.getElementById("memberFirstname").addEventListener("input", function () {
        let regex = /^[A-Za-z\s]+$/; 
        let memberFirstname = this.value;

        if (!regex.test(memberFirstname)) {
            this.value = memberFirstname.replace(/[^A-Za-z\s]/g, ""); 
        }
    });
    document.getElementById("memberMiddlename").addEventListener("input", function () {
        let regex = /^[A-Za-z\s]+$/; 
        let memberMiddlename = this.value;

        if (!regex.test(memberMiddlename)) {
            this.value = memberMiddlename.replace(/[^A-Za-z\s]/g, ""); 
        }
    });
    document.getElementById("memberLastname").addEventListener("input", function () {
        let regex = /^[A-Za-z\s]+$/;
        let memberLastname = this.value;

        if (!regex.test(memberLastname)) {
            this.value = memberLastname.replace(/[^A-Za-z\s]/g, "");
        }
    });

});
</script>
</body>
</html>