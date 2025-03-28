var $csrfToken;
var $table;
var $btnUploadXml;
var $xmlFile;
var $btnSubmitXmlData;
var $btnClearData;


let _encrypted_data = "";
var data_tables_data = [];
var xml_data = []
var init  = function() {
    cacheDom();
    bindEvents();
};
var cacheDom = function() {
    $csrfToken   = document.querySelector('input[name="csrf_test_name"]').value;
    $btnClearData = document.getElementById("btn-clear-table");
    $btnSubmitXmlData = document.getElementById("btn-submit-data");

    $btnSubmitXmlData.disabled = true;
    $table = $("#data-table");
    $table.DataTable({
        "paging": true,         // Enables pagination
        "searching": false,      // Enables search box
        "ordering": false,       // Enables sorting
        "info": false,           // Shows table info
        "lengthMenu": [5, 10, 25, 50, 100], // Dropdown for number of rows
        "pageLength": 10,       // Default page length
        "responsive": true,      // Enables responsiveness
        "columns": [ // Define the columns
        { "data": "member_pin" },
        { "data": "patient_type" },
        { "data": "patient_name" },
        { "data": "patient_suffix" },
        { "data": "patient_birthdate" },
        { "data": "patient_sex" },
        { "data": "patient_contact_number" },
        { "data": "patient_email_address" },
        { "data": "address" },
        { "data": "member_name" },
        { "data": "member_suffix" },
        { "data": "member_email_address" },
        { "data": "member_contact_number" },
        { "data": "availment_type" },
        { "data": "type_of_benefit" },
        { "data": "admission_date" },
        { "data": "admission_time" },
        { "data": "medical_code" },
        { "data": "admission_diagnosis" }
        
    ]
    });


    $btnUploadXml       = document.querySelector("#btn-upload-xml");
    $xmlFile            = document.querySelector("#xmlFile");
};
var bindEvents = function() {
    $btnUploadXml.addEventListener("click", function(event){
        
        let data_file = $xmlFile.files[0];
        
        if (data_file) {
            let reader = new FileReader();
    
            reader.onload = function(event) {
                _encrypted_data = event.target.result;
                console.log("XML Content:", _encrypted_data);
                // Process data after it's loaded
                processData(_encrypted_data);
                
            };
            reader.readAsText(data_file); // Read file as text
            $btnSubmitXmlData.disabled = false;
        } else {
            alert("No selected file");
            window.location.reload()
        }
    });


    function processData(data) {
        $btnUploadXml.disabled = true;
        $.ajax({
            url: "upload-xml",
            method: "POST",
            data: {
                encrypted_data: data,
                csrf_test_name: $csrfToken
            },
            success: function(response) {
               
                const jsonResponse = JSON.parse(response);
                console.log(jsonResponse);
                if (jsonResponse.http_code == 200){ 
                    let member_name = "";
                    let member_suffix = "";
                    let member_email_address = "";
                    let member_contact_number = "";
                    
                    let type_of_benefit = "";
                    let type_of_benefit_name= "";

                    let availment_type = "";
                    let availment_name = "";

                    let medical_code = "";
                    let case_rate_code = "";
                    
                    const claimArray = jsonResponse.api_response.eTRANSMITTAL.CLAIM;
                    
                    if (Array.isArray(claimArray)) {
                        claimArray.forEach((claimItem, index) => {

                            const case_rate = claimItem.ALLCASERATE;
                            if (Array.isArray(case_rate) == false) {
                        
                                if (case_rate.CASERATE.pICDCode != "" && case_rate.CASERATE.pRVSCode == "" ) {
                                    type_of_benefit= "2";
                                    type_of_benefit_name = "All Case Rate - ICD"
                                    medical_code = case_rate.CASERATE.pICDCode;
                                    availment_type= "2";
                                    availment_name = "In-Patient"
                                    case_rate_code= case_rate.CASERATE.pCaseRateCode;
                                }
                                else if (case_rate.CASERATE.pICDCode == "" && case_rate.CASERATE.pRVSCode != "") {
                                    type_of_benefit = "1";
                                    type_of_benefit_name = "All Case Rate - RVS"
                                    medical_code = case_rate.CASERATE.pRVSCode;
                                    availment_type= "";
                                    availment_name = "Out-Patient"
                                    case_rate_code= case_rate.CASERATE.pCaseRateCode;
                                }
                            };

                            if (claimItem.CF1.pPatientIs == "M"){
                                member_name = claimItem.CF1.pMemberFirstName + " " + claimItem.CF1.pMemberMiddleName + " " + claimItem.CF1.pMemberLastName;
                                member_suffix = claimItem.CF1.pMemberSuffix;
                                member_email_address = claimItem.CF1.pEmailAddress;
                                member_contact_number = claimItem.CF1.pMobileNo;
                            };

                           
                            data_tables_data.push({
                                "member_pin": claimItem.CF1.pMemberPIN,
                                "patient_type": claimItem.CF1.pPatientIs,
                                "patient_name": claimItem.CF1.pPatientLastName + ", " + claimItem.CF1.pPatientFirstName + " " + claimItem.CF1.pPatientMiddleName,
                                "patient_suffix": claimItem.CF1.pPatientSuffix,
                                "patient_birthdate": claimItem.CF1.pPatientBirthDate,
                                "patient_sex": claimItem.CF1.pPatientSex,
                                "patient_contact_number": claimItem.CF1.pMobileNo,
                                "patient_email_address": claimItem.CF1.pEmailAddress,
                                "address": claimItem.CF1.pMailingAddress + ", " + claimItem.CF1.pZipCode,
                                "member_name": member_name,
                                "member_suffix": member_suffix,
                                "member_email_address": member_email_address,
                                "member_contact_number": member_contact_number,
                                "patient_pin": claimItem.CF1.pPatientPIN,
                                "availment_type": availment_name,
                                "type_of_benefit": type_of_benefit_name,
                                "medical_code": medical_code,
                                "case_rate_code": case_rate_code,
                                "admission_diagnosis": claimItem.CF2.DIAGNOSIS.pAdmissionDiagnosis,
                                "admission_date": claimItem.CF2.pAdmissionDate,
                                "admission_time": claimItem.CF2.pAdmissionTime
                            });

                            xml_data.push({
                                "member_pin": claimItem.CF1.pMemberPIN,
                                "patient_type": claimItem.CF1.pPatientIs,
                                "pFirstname": claimItem.CF1.pPatientFirstName,
                                "pMiddlename": claimItem.CF1.pPatientMiddleName,
                                "pLastname": claimItem.CF1.pPatientLastName,
                                "patient_suffix": claimItem.CF1.pPatientSuffix,
                                "patient_birthdate": claimItem.CF1.pPatientBirthDate,
                                "patient_sex": claimItem.CF1.pPatientSex,
                                "patient_contact_number": claimItem.CF1.pMobileNo,
                                "patient_email_address": claimItem.CF1.pEmailAddress,
                                "address": claimItem.CF1.pMailingAddress + ", " + claimItem.CF1.pZipCode,
                                "mFirstname": claimItem.CF1.pMemberFirstName,
                                "mMiddlename": claimItem.CF1.pMemberMiddleName,
                                "mLastname": claimItem.CF1.pMemberLastName,
                                "member_suffix": member_suffix,
                                "member_email_address": member_email_address,
                                "member_contact_number": member_contact_number,
                                "patient_pin": claimItem.CF1.pPatientPIN,
                                "availment_type": availment_type,
                                "type_of_benefit": type_of_benefit,
                                "medical_code": medical_code,
                                "case_rate_code": case_rate_code,
                                "admission_diagnosis": claimItem.CF2.DIAGNOSIS.pAdmissionDiagnosis,
                                "admission_date": claimItem.CF2.pAdmissionDate,
                                "admission_time": claimItem.CF2.pAdmissionTime

                            })
                           
                        });
                    } 
                    else {
                        const case_rate = claimArray.ALLCASERATE;
                        if (Array.isArray(case_rate) == false) {
                            
                            if (case_rate.CASERATE.pICDCode != "" && case_rate.CASERATE.pRVSCode == "" ) {
                                type_of_benefit= "2";
                                type_of_benefit_name = "All Case Rate - ICD"
                                medical_code = case_rate.CASERATE.pICDCode;
                                availment_type= "2";
                                availment_name = "In-Patient"
                                case_rate_code= case_rate.CASERATE.pCaseRateCode;
                            }
                            else if (case_rate.CASERATE.pICDCode == "" && case_rate.CASERATE.pRVSCode != "") {
                                type_of_benefit = "1";
                                type_of_benefit_name = "All Case Rate - RVS"
                                medical_code = case_rate.CASERATE.pRVSCode;
                                availment_type= "";
                                availment_name = "Out-Patient"
                                case_rate_code= case_rate.CASERATE.pCaseRateCode;
                            }
                        };

                        if (claimArray.CF1.pPatientIs == "M"){
                            member_name = claimArray.CF1.pMemberFirstName + " " + claimArray.CF1.pMemberMiddleName + " " + claimArray.CF1.pMemberLastName;
                            member_suffix = claimArray.CF1.pMemberSuffix;
                            member_email_address = claimArray.CF1.pEmailAddress;
                            member_contact_number = claimArray.CF1.pMobileNo;

                            data_tables_data.push({
                                "member_pin": claimArray.CF1.pMemberPIN,
                                "patient_type": claimArray.CF1.pPatientIs,
                                "patient_name": claimArray.CF1.pPatientFirstName + " " + claimArray.CF1.pPatientMiddleName + " " + claimArray.CF1.pPatientLastName,
                                "patient_suffix": claimArray.CF1.pPatientSuffix,
                                "patient_birthdate": claimArray.CF1.pPatientBirthDate,
                                "patient_sex": claimArray.CF1.pPatientSex,
                                "patient_contact_number": claimArray.CF1.pMobileNo,
                                "patient_email_address": claimArray.CF1.pEmailAddress,
                                "address": claimArray.CF1.pMailingAddress + ", " + claimArray.CF1.pZipCode,
                                "member_name": member_name,
                                "member_suffix": member_suffix,
                                "member_email_address": member_email_address,
                                "member_contact_number": member_contact_number,
                                "patient_pin": claimArray.CF1.pPatientPIN,
                                "availment_type": availment_name,
                                "type_of_benefit": type_of_benefit_name,
                                "medical_code": medical_code,
                                "case_rate_code": case_rate_code,
                                "admission_diagnosis": claimArray.CF2.DIAGNOSIS.pAdmissionDiagnosis,
                                "admission_date": claimArray.CF2.pAdmissionDate,
                                "admission_time": claimArray.CF2.pAdmissionTime
                            });


                            xml_data.push({
                                "member_pin": claimArray.CF1.pMemberPIN,
                                "patient_type": claimArray.CF1.pPatientIs,
                                "pFirstname": claimArray.CF1.pPatientFirstName,
                                "pMiddlename": claimArray.CF1.pPatientMiddleName,
                                "pLastname": claimArray.CF1.pPatientLastName,
                                "patient_suffix": claimArray.CF1.pPatientSuffix,
                                "patient_birthdate": claimArray.CF1.pPatientBirthDate,
                                "patient_sex": claimArray.CF1.pPatientSex,
                                "patient_contact_number": claimArray.CF1.pMobileNo,
                                "patient_email_address": claimArray.CF1.pEmailAddress,
                                "address": claimArray.CF1.pMailingAddress + ", " + claimArray.CF1.pZipCode,
                                "mFirstname": claimArray.CF1.pMemberFirstName,
                                "mMiddlename": claimArray.CF1.pMemberMiddleName,
                                "mLastname": claimArray.CF1.pMemberLastName,
                                "member_suffix": member_suffix,
                                "member_email_address": member_email_address,
                                "member_contact_number": member_contact_number,
                                "patient_pin": claimArray.CF1.pPatientPIN,
                                "availment_type": availment_type,
                                "type_of_benefit": type_of_benefit,
                                "medical_code": medical_code,
                                "case_rate_code": case_rate_code,
                                "admission_diagnosis": claimArray.CF2.DIAGNOSIS.pAdmissionDiagnosis,
                                "admission_date": claimArray.CF2.pAdmissionDate,
                                "admission_time": claimArray.CF2.pAdmissionTime

                            })
                        };
                    }
                    $table.DataTable().clear().rows.add(data_tables_data).draw();
                }
                else{
                    alert(jsonResponse.message);
                    window.location.reload();
                }
                
            },
            error: function(response) {
                alert("Error uploading XML file");
            }

        });
    
    }

    $btnClearData.addEventListener("click", function(event){
        $table.DataTable().clear().draw();
        data_tables_data = [];
        $xmlFile.value = "";
        $btnSubmitXmlData.disabled = true;
        $btnUploadXml.disabled = false;
    });
    $btnSubmitXmlData.addEventListener("click", function(event){
        console.log("xml: ", xml_data);
        $.ajax({
            url:"submit-xml-data",
            method: "POST",
            data: {
                csrf_test_name: $csrfToken,
                data_dict: xml_data
            },
            success: function(response){
               
                var responseMessageDiv = document.getElementById("responseMessage");
                // Check if response contains JSON
                jsonResponse = JSON.parse(response);
                if( jsonResponse.http_code == 403 && jsonResponse.api_response['detail'].length > 0){

                    console.log(jsonResponse.api_response);
                    let errorList = "<ul style='color: red; text-align: left;'>";
                    jsonResponse.api_response['detail'].forEach(function(error) {
                        errorList += `<li>${error}</li>`;
                    });
                    errorList += "</ul>";
    
                    responseMessageDiv.innerHTML = errorList;
                    responseMessageDiv.style.display = "block";
                    

                }
                else {
                    console.log(jsonResponse.api_response.message)
                    reference_number = jsonResponse.api_response.message;
                    responseMessageDiv.innerHTML = `Admission successfully saved. Reference Number: ${reference_number}`;
                    responseMessageDiv.style.display = "block";
                    window.location.reload();
                }
            },
            error: function(response){
                document.getElementById("loadingIndicator").style.display = "none";
                alert("Error response:", response)
            }
        });
      
    });

};



document.addEventListener("DOMContentLoaded", function() {
    init();
});


