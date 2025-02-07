<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class ApiController extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function submit_admission()
    {
        $external_api = "http://192.168.8.1/submit_admission";

        $data = array(
            'patient_name' => $this->input->post('patient_name'),
            'admission_date' => $this->input->post('admission_date'),
            'hospital_id' => $this->input->post('hospital_id'),
        );

        $response = $this->call_external_api($external_api, $data);

        echo $response;
    }

    
    private function call_external_api($url, $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return json_encode(array('error' => $error_msg));
        }

        curl_close($ch);
        return $response;
    }

}



?>