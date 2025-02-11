<?php
class AdmissionController extends CI_Controller {
	public function index()
	{
		$vAccreID = $this->input->cookie('accreid');
		$vUserName = $this->input->cookie('username');
		$vAdmissionMod = $this->input->cookie('adm');
		
		$data['title'] = "Admission Form";
		// $this->load->view('Admission/admission_form', $data);
		if($vAccreID != null and $vUserName != null and $vAdmissionMod != null){
			$data['title'] = "Admission Form";
			$this->load->view('Admission/admission_form', $data);
		}
		else{
			echo json_encode([
				'status' => 'error',
                'message' => 'Missing Credentials.',
				'http_code' => 404]);
			
			$this->load->view('errors/html/error_404');
		}
		
	}
	public function submitAdmission()
	{
		$vAccreID = $this->input->cookie('accreid');
		// $vAccreID = 'A03000006';
		$this->load->helper('config');
		$api_config = get_config_ini('API_CREDENTIALS');

		$api_key = $api_config['API_KEY'];
		$api_url = $api_config['API_URL'];
		log_message('debug','api url'. $api_url);
		
		//Receive the POST data from ajax
		$data = $this->input->post('jsonData');
		$jsonData = json_encode($data);
		
		$mononym = "";
		$decodeData = json_decode($jsonData, true);
		
		if($decodeData['p_mononym'] === true) {
			$mononym = "Y";
			log_message('debug', 'mononym true' . $mononym);
		}
		else{
			$mononym = "N";
		}
		
		$AdmDate = new DateTime($decodeData['admission_date']);
		$pBirthdate = new DateTime($decodeData['p_birthday']);
		$formattedPBirthdate = $pBirthdate->format('m-d-Y');
		$formattedAdmDate = $AdmDate->format('m-d-Y');

	
		$data_array = array(
			"hospital_code"=> $vAccreID,
			"case_number"=>  $decodeData['case_number'],
			"p_mononym"=> $mononym,
			"p_first_name"=> $decodeData['p_first_name'],
			"p_middle_name"=> $decodeData['p_middle_name'],
			"p_last_name"=> $decodeData['p_last_name'],
			"p_suffix"=> $decodeData['p_suffix'],
			"p_birthday"=> $formattedPBirthdate,  
			"p_gender"=> $decodeData['p_gender'],    
			"p_nationality"=> $decodeData['p_nationality'],
			"p_contact_number"=> $decodeData['p_contact_number'],
			"p_email_address"=> $decodeData['p_email_address'],
			"p_address"=> $decodeData['p_street']." ".$decodeData['p_barangay']." ".$decodeData['p_city']." ".$decodeData['p_city']." ".$decodeData['p_region']." ".$decodeData['p_province']." ".$decodeData['p_zip_code'],
			"patient_type"=> $decodeData['patient_type'],
			"patient_pin"=> $decodeData['patient_pin'],
			"m_first_name"=> $decodeData['m_first_name'],
			"m_last_name"=> $decodeData['m_last_name'],
			"m_middle_name"=> $decodeData['m_middle_name'],
			"m_suffix"=> $decodeData['m_suffix'], 
			"m_email_address"=> $decodeData['m_email_address'],
			"m_contact_number"=> $decodeData['m_contact_number'],
			"benefit_availment"=> $decodeData['benefit_availment'],
			"reason_for_availment"=> $decodeData['reason_for_availment'],
			"chief_complaint"=> $decodeData['chief_complaint'],
			"admission_code"=> $decodeData['admission_code'], 
			"admission_date"=> $formattedAdmDate,
			"admission_time"=> $decodeData['admission_time']
		);

		log_message('debug', 'Admission form submitted: ' . json_encode($data_array));

		
		$api_url_with_key = $api_url . '?api_key=' . $api_key;
		log_message('debug', 'API URL: ' . $api_url_with_key);
        $ch = curl_init($api_url_with_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_array));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		$response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		log_message('debug', 'response'. $response);
        if ($httpCode == 200) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Admission form submitted successfully!',
                'api_response' => json_decode($response)
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to submit admission form to external API.',
				'http_code' => $httpCode,
                'api_response' => json_decode($response)
            ]);
        }
	}
}

