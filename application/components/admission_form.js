var $btnSubmit;
var $confirmSaveModal;
var $btnConfirmSave;
var $btnCloseConfirmModal



var $btnUploadXml;
var $xmlFile;
var $btnSubmitXmlData;
var $Xmladdress;

var $caseNumber;
var $pFirstName;
var $pMiddleName;
var $pLastName;
var $pSuffix;
var $pMononym;
var $pBirthdate;
var $pSex;
var $pNationality;
var $pMobileNumber;
var $pEmailAdd;
var $pStreet;
var $pBarangay;
var $pCity;
var $pRegion;
var $pProvince;
var $pZipCode;
var $mPhilhealthId;
var $selectMembershipType;
var $mFirstName;
var $mMiddleName;
var $mLastName;
var $mSuffix;
var $mEmailAddress;
var $mContactNumber;
var $TypeBenefit;
var $AdmissionDate;
var $AdmissionTime;
var $Availment;
var $MedicalCode;
var $AdmissionDiagnosis;
var $AddressBlock;
var $streetContainer;
var $addressDataContainer;



var $csrfToken;


var _select_gender      = "";
var _select_birthday    = "";
var _select_benefit     = "";
var _select_membership_type = "";
var _select_admission_date  = "";
var _select_reason_availment = "";
var _is_mononym = false;

let _encrypted_data = "";

var init  = function() {
    console.log("test");
    cacheDom();
    bindEvents();
};


var cacheDom = function() {
    $csrfToken   = document.querySelector('input[name="csrf_test_name"]').value;
    console.log($csrfToken);
    $btnSubmit          = document.querySelector("#btn-submit");
    $confirmSaveModal   =$("#confirmSaveModal");
    $btnConfirmSave     = document.querySelector("#btn-modal-create-confirm");
    $btnCloseConfirmModal = document.querySelector("#btn-modal-close");

    $btnUploadXml       = document.querySelector("#btn-upload-xml");
    $xmlFile            = document.querySelector("#xmlFile");

    $caseNumber         = document.querySelector("#caseNumber");
    $pFirstName         = document.querySelector("#firstName");
    $pMiddleName        = document.querySelector("#middleName");
    $pLastName          = document.querySelector("#lastName");
    $pSuffix            = document.querySelector("#suffixName");
    $pMononym           = document.querySelector("#checkMononym");
    $pBirthdate         = document.querySelector("#birthDate");
    $pSex               = document.querySelector("#genderSelect");
    $pNationality       = document.querySelector("#Nationality");
    $pMobileNumber      = document.querySelector("#mobileNumber");
    $pEmailAdd          = document.querySelector("#emailAddress");
    $pStreet            = document.querySelector("#street");
    $pBarangay          = document.querySelector("#barangay");
    $pCity              = document.querySelector("#city");
    $pRegion            = document.querySelector("#region");
    $pProvince          = document.querySelector("#province");
    $pZipCode           = document.querySelector("#zipCode");

    $mPhilhealthId      = document.querySelector("#philhealthID");
    $selectMembershipType = document.querySelector("#membershipType");
    $mFirstName         = document.querySelector("#memberFirstname");
    $mMiddleName        = document.querySelector("#memberMiddlename");
    $mLastName          = document.querySelector("#memberLastname");
    $mSuffix            = document.querySelector("#memberSuffix");
    $mEmailAddress      = document.querySelector("#memberEmailAddress");
    $mContactNumber     = document.querySelector("#memberContactNumber");

    $TypeBenefit        = document.querySelector("#typeBenefit");
    $AdmissionDate      = document.querySelector("#admissionDate");
    $AdmissionTime      = document.querySelector("#admissionTime");
    $Availment          = document.querySelector("#AvailmentCode");
    $MedicalCode        = document.querySelector("#admissionCodeType");
    $AdmissionDiagnosis = document.querySelector("#AdmissionDiagnosis");


    $AddressBlock       = document.getElementById("address-data-container");
    $streetContainer            = document.getElementById("street-container");
    $addressDataContainer       = document.getElementById("address-details-container");
    $btnSubmitXmlData           = document.getElementById("btn-submit-xml-data");
    $Xmladdress                 =document.querySelector("#xmlAddress");


    let today = new Date().toISOString().split("T")[0]; // Get current date in YYYY-MM-DD format
    $pBirthdate.setAttribute("max", today);



    
}

var bindEvents = function() {
  
    $mFirstName.disabled = true;
    $mMiddleName.disabled = true;
    $mLastName.disabled = true;
    $mSuffix.disabled = true;
    $mEmailAddress.disabled = true;
    $mContactNumber.disabled = true;

    function convertTo24HourFormat(time12h) {
        let [time, modifier] = time12h.split(" ");
        let [hours, minutes] = time.split(":");
    
        if (modifier === "AM" && hours === "12") {
            hours = "00"; // Midnight case
        } else if (modifier === "PM" && hours !== "12") {
            hours = String(parseInt(hours, 10) + 12); // Convert PM hours
        }
    
        return `${hours}:${minutes}`;
    }

    $selectMembershipType.addEventListener("change",function(){
        $mFirstName.value = "";
        $mMiddleName.value = "";
        $mLastName.value = "";
        $mSuffix.value = "";
        $mEmailAddress.value = "";
        $mContactNumber.value = "";
        _select_membership_type = $selectMembershipType.value;
        if(_select_membership_type === "D"){
            
            $mFirstName.disabled = false;
            $mMiddleName.disabled = false;
            $mLastName.disabled = false;
            $mSuffix.disabled = false;
            $mEmailAddress.disabled = false;
            $mContactNumber.disabled = false;
        }
        else{
            $mFirstName.disabled = true;
            $mMiddleName.disabled = true;
            $mLastName.disabled = true;
            $mSuffix.disabled = true;
            $mEmailAddress.disabled = true;
            $mContactNumber.disabled = true;
        }
    });

    

   
    $pMononym.addEventListener("change", function(){
        if (this.checked) 
            {
                $pLastName.value        = "";
                $pMiddleName.value      = "";
                $pLastName.disabled     = true;
                $pMiddleName.disabled   = true;
                $pSuffix.value          = "";
                $pSuffix.disabled       = true;
                _is_mononym = this.checked;
        }
        else 
            {
                $pLastName.disabled     = false;
                $pMiddleName.disabled   = false;
                $pSuffix.disabled       = false;
                
        }
    });
    
    $pSex.addEventListener("change",function(){
        _select_gender  = $pSex.value;
    });

    $pBirthdate.addEventListener("change",function(){
        _select_birthday = $pBirthdate.value;
        
    });

    $TypeBenefit.addEventListener("change", function(){
        _select_benefit = $TypeBenefit.value;
    });

    $AdmissionDate.addEventListener("change",function(){
        _select_admission_date = $AdmissionDate.value;
    });

    $Availment.addEventListener("change",function(){
        _select_reason_availment = $Availment.value;
    });
    

    function validateFields() {
        let isValid = true;
        const fields = document.querySelectorAll("[data-error]");
        //console.log(fields)
        fields.forEach(field => {
            const errorElement = document.querySelector(field.dataset.error);
            const isMononymChecked = $pMononym.checked;
            if (!errorElement) {
                console.error(`Error element not found for field: ${field.id}`);
                return; 
            }

            if (isMononymChecked && (field.id === "lastName" || field.id === "middleName")) {
                errorElement.style.display = "none"; // Clear any previous error
                return;
            }

            if(_select_membership_type == "M"){
                var memberFirstname = $mFirstName.value;
                var memberMiddlename = $mMiddleName.value;
                var memberLastname = $mLastName.value;
                var memberSuffix = $mSuffix.value;
                var memberEmailAddress = $mEmailAddress.value;
                var memberContactNumber = $mContactNumber.value;

                //console.log(field.id);
                if ((field.id === "memberFirstname" && memberFirstname === "") ||
                    (field.id === "memberMiddlename" && memberMiddlename === "") ||
                    (field.id === "memberLastname" && memberLastname === "") ||
                    (field.id === "memberSuffix" && memberSuffix === "") ||
                    (field.id === "memberEmailAddress" && memberEmailAddress === "") ||
                    (field.id === "memberContactNumber" && memberContactNumber === "")) {
                    return; // Skip validation for these fields if they are blank
                }
            }
            
            if (!field.value.trim()) {
                console.log(errorElement)
                errorElement.textContent = "This field is required.";
                errorElement.style.display = "block";
                field.focus();
                isValid = false;
            } else {
                errorElement.style.display = "none";
            }
        });
        
        return isValid;
    }

    $btnSubmit.addEventListener("click", function(event){
        event.preventDefault();
        if(_select_membership_type == "D"){
            if ( validateFields()) {
                $confirmSaveModal.modal("show");
            };
        }
        else{
            if (validateFields()) {
                $confirmSaveModal.modal("show");
            }
        };
    });

    $btnCloseConfirmModal.addEventListener("click", function(event){
        $confirmSaveModal.modal("hide");
    });

    $btnConfirmSave.addEventListener("click",function(event){
        event.preventDefault();
        document.getElementById("loadingIndicator").style.display = "block";
        document.getElementById("responseMessage").style.display = "none";
        var suffix_val = "";
        if($pSuffix.value.trim() !== "" ){
            suffix_val = $pSuffix.value;
        }
        
        var dataForm= {
                "case_number": $caseNumber.value,
                "p_mononym": _is_mononym,  
                "p_first_name": $pFirstName.value,
                "p_middle_name": $pMiddleName.value,  
                "p_last_name": $pLastName.value,
                "p_suffix": suffix_val,  
                "p_birthday": _select_birthday,  
                "p_gender": _select_gender,    
                "p_nationality": $pNationality.value,
                "p_contact_number": $pMobileNumber.value,
                "p_email_address": $pEmailAdd.value,
                "p_street": $pStreet.value,
                "p_barangay": $pBarangay.value,
                "p_city": $pCity.value,
                "p_region": $pRegion.value,
                "p_province": $pProvince.value,
                "p_zip_code": $pZipCode.value,
                "patient_type": _select_membership_type, 
                "patient_pin": $mPhilhealthId.value, 
                "m_first_name": $mFirstName.value,
                "m_last_name": $mLastName.value,
                "m_middle_name": $mMiddleName.value,
                "m_suffix": $mSuffix.value, 
                "m_email_address": $mEmailAddress.value,
                "m_contact_number": $mContactNumber.value,
                "benefit_availment": _select_benefit,
                "reason_for_availment": _select_reason_availment, 
                "chief_complaint": $AdmissionDiagnosis.value, 
                "admission_code":$MedicalCode.value,  
                "admission_date": _select_admission_date,
                "admission_time": $AdmissionTime.value
        }
        $.ajax({
            url: "submit-admission",
            method: "POST",
            data: {
                jsonData:dataForm,
                csrf_test_name: $csrfToken 
            },
            success: function(response){
                
                document.getElementById("loadingIndicator").style.display = "none";
                var responseMessageDiv = document.getElementById("responseMessage");
                // Check if response contains JSON
                jsonResponse = JSON.parse(response);
                
                console.log(jsonResponse.api_response.status);

                if (jsonResponse.api_response.status != "success") {
                    
                    if (jsonResponse.api_response.errors.length > 0) {
                        console.log("error");
                        let errorList = "<ul style='color: red; text-align: left;'>";
                        jsonResponse.api_response.errors.forEach(function(error) {
                            errorList += `<li>${error}</li>`;
                        });
                        errorList += "</ul>";
                        responseMessageDiv.innerHTML = errorList;
                        responseMessageDiv.style.display = "block";
                    }
                }
                else{
                    reference_number = jsonResponse.api_response.reference_number;
                    alert("Admission successfully saved \nReference Numbers:\n" + reference_number);
                    
                    window.location.reload();
                }

                
                
            },
            error: function(response){
                document.getElementById("loadingIndicator").style.display = "none";
                console.error("Error response:", response)
            }
        });
    });
}


document.addEventListener("DOMContentLoaded", function() {
    init();
});