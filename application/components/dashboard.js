var $btnGenerateReport;
var $selectStartDate;
var $selectEndDate;
var $modal;
var $csrfToken;
var $table;
var xml_data = []


var init  = function() {
    cacheDom();
    bindEvents();
};


var cacheDom = function() {
    $btnGenerateReport = document.querySelector("#btn-generate-report");
    $csrfToken   = document.querySelector('input[name="csrf_test_name"]').value;
    $selectStartDate = document.querySelector("#start_date");
    $selectEndDate = document.querySelector("#end_date");
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
        { "data": "Reference Number" },
        { "data": "Admission Code" },
        { "data": "Admission Date" },
        { "data": "Date Submitted" }
     
        
    ]
    });
  
    


}
var bindEvents = function() {
    $btnGenerateReport.addEventListener("click", function() {
        event.preventDefault();
    

        var data = {

            start_date: $selectStartDate.value,
            end_date: $selectEndDate.value
        }
        $.ajax({
            url: "generate-admission-list",
            method: "POST",
            data: {
                jsonData:data,
                csrf_test_name: $csrfToken 
            },
            success: function(response) {
              
                var jsonResponse = JSON.parse(response);
                var data = jsonResponse.api_response;

                if (!Array.isArray(data)) {
                    console.error("Expected api_response to be an array, got:", data);
                    return;
                }
                var formattedData = data.map(function(item) {
                    return {
                        "Reference Number": item.referenceNo,
                        "Admission Code": item.admissionCode,
                        "Admission Date": item.admissionDate,
                        "Date Submitted": item.dateSubmitted
                    };
                });

                var table = $table.DataTable();
                table.clear().rows.add(formattedData).draw();


            },
            error: function(xhr, status, error) {
                console.error("Error generating report:", error);
            }
        });
        
    });

}

document.addEventListener("DOMContentLoaded", function() {
    init();
});
