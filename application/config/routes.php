<?php

$route['default_controller'] = 'AdmissionController/index';
$route['admission_form'] = 'AdmissionController/admission_form_index';
$route['upload-xml-index'] = 'AdmissionController/xml_uploading_index';
$route['404_override'] = 'ErrorController/page_missing';
$route['error-500'] = 'ErrorController/error_500';
$route['translate_uri_dashes'] = FALSE;



// Custom route for AJAX submission
$route['submit-admission'] = 'AdmissionController/submitAdmission';
$route['upload-xml'] = 'AdmissionController/uploadXML';
$route['generate-admission-list'] = 'AdmissionController/GenerateAdmissionList';



$route['submit-xml-data'] = 'AdmissionController/submitXMLData';

//route_for_api