<?php

$route['default_controller'] = 'AdmissionController/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



// Custom route for AJAX submission
$route['submit-admission'] = 'AdmissionController/submitAdmission';



//route_for_api