<?php
class AdmissionController extends CI_Controller {

	public $hospital_code; 
	public $cipher_key;


	public function __construct() {
        parent::__construct();
        $vAccreID = $this->input->cookie('accreid') ?? 'A91000007'; 
		$adm = $this->input->cookie('amd');
        $this->hospital_code = $this->get_hospital_code($vAccreID);
		$this->cipher_key = $this->get_cipher_key($this->hospital_code);
    }

	public function get_hospital_code($vAccreID){

		$this->load->helper('config');
		$api_config = get_config_ini('API_CREDENTIALS');
		$api_key = $api_config['API_KEY'];
		$app_key = $api_config['APP_KEY'];
		$api_url = $api_config['API_GET_HOSPITAL_CODE_URL'];
		$api_url_with_key = $api_url . '?accre_no=' . $vAccreID ;
		$ch = curl_init($api_url_with_key);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		$data = json_decode($response, true); // decode to associative array

		if (isset($data['status']) && $data['status'] === 'success') {
			$hospital_code = $data['hospital_code'];
			return $hospital_code;
		} else {
			log_message('debug', 'Error: No hospital code found.');
		}


		// if ($httpCode == 200) {
		// 	return $response;
		// 	log_message('debug', 'response: ' . $response['hospital_code']);
		// } else {
		// 	log_message('debug', 'hospital_code_error: '. $response);
		// 	return null;
		// }
	}

	public function get_cipher_key($hospital_code){

		if($hospital_code != null){
			$this->load->helper('config');
			$api_config = get_config_ini('API_CREDENTIALS');
			$api_key = $api_config['API_KEY'];
			$app_key = $api_config['APP_KEY'];
			$api_url = $api_config['API_GET_CIPHER_KEY_URL'];
			$api_url_with_key = $api_url . '?pmcc_code=' . $hospital_code ;
			log_message('debug', 'API URL: ' . $api_url_with_key);
			$ch = curl_init($api_url_with_key);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			

			$data = json_decode($response, true); // decode to associative array
			log_message('debug', 'response: '. $data['cipher_key']);
			if (isset($data['status']) && $data['status'] === 'success') {
				$cipher_key = $data['cipher_key'];
				return $cipher_key;
			} else {
				log_message('debug', 'Error: No cipher key.');
			}
		}
		
	}
	public function index()
	{
		//$vAccreID = $this->input->cookie('accreid');
	
		if ($this->hospital_code == null) {
			$this->load->view('error_template/internal_server');
		}
		else{
			$this->load->view('Admission/dashboard');
			// $this->load->helper('config');
			// $api_config = get_config_ini('API_CREDENTIALS');
			// $api_key = $api_config['API_KEY'];
			// $app_key = $api_config['APP_KEY'];
			// $api_url = $api_config['API_GET_LOGBOOK_DATA_URL'];			
			// $api_url_with_key = $api_url .$this->hospital_code.'?api_key=' . $api_key . '&app_key='. $app_key;

			// $ch = curl_init($api_url_with_key);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// curl_setopt($ch, CURLOPT_HTTPGET, true);
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

			// $response = curl_exec($ch);
			// $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			// curl_close($ch);
			// log_message('debug', 'response'. $response);

			// if ($httpCode == 200) {
			// 	$data['title'] = "Dashboard";
			// 	$data['admission_data'] = json_decode($response,true);
			// 	$this->load->view('Admission/dashboard',$data);
			// } else {
			// 	$this->load->view('error_template/internal_server');
			// }	
		}
	}
	
	
	public function admission_form_index(){
		$vAccreID = $this->input->cookie('accreid') || 'A91000007';
		$vUserName = $this->input->cookie('username');
		$vAdmissionMod = $this->input->cookie('adm');
		
		$data['title'] = "eAdmission Logbook";
		$this->load->view('Admission/admission_form', $data);
	}

	public function submitAdmission()
	{
		$this->load->helper('config');
		$api_config = get_config_ini('API_CREDENTIALS');
		$api_key = $api_config['API_KEY'];
		$api_url = $api_config['API_URL'];
		$app_key = $api_config['APP_KEY'];
		
		
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
		$formattedPBirthdate = $pBirthdate->format('Y-m-d');
		$formattedAdmDate = $AdmDate->format('Y-m-d');
		$pAge = $pBirthdate->diff(new DateTime)->y;

		$data_array = array(
			"hospital_code"=> $this->hospital_code,
			"case_number"=>  $decodeData['case_number'],
			"p_mononym"=> $mononym,
			"p_first_name"=> $decodeData['p_first_name'],
			"p_middle_name"=> $decodeData['p_middle_name'],
			"p_last_name"=> $decodeData['p_last_name'],
			"p_suffix"=> $decodeData['p_suffix'],
			"p_birthday"=> $formattedPBirthdate,  
			"p_gender"=> $decodeData['p_gender'],    
			"p_age"=> $pAge,
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
			"admission_time"=> $decodeData['admission_time'],
			"is_extracted" => "F"
		);

		log_message('debug', 'Admission form submitted: ' . json_encode($data_array));
		$api_url_with_key = $api_url ;
		log_message('debug', 'API URL: ' . $api_url_with_key);
        $ch = curl_init($api_url_with_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_array));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		$response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
		log_message('debug', 'response_submit: '. $response . "http_stats: ".$httpCode);
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

	public function xml_uploading_index(){
		if($this->cipher_key == null){
			$this->load->view('error_template/internal_server');
		}
		else{
			$this->load->view('Admission/xml_uploading');
		}
	}

	public function uploadXML()
	{
		if($this->cipher_key == null){
			$this->load->view('error_template/internal_server');
		}
		else{
			$this->load->helper('config');
			$data = $this->input->post('encrypted_data');
			
			$api_config = get_config_ini('API_CREDENTIALS');
			$api_url = $api_config['API_DECRYPT_URL'];

			log_message('debug', 'this is cipher key: ' . $this->cipher_key);
			$api_url_with_key = $api_url . '?cipher_key=' . $this->cipher_key;
			log_message('debug', 'API URL: ' . $api_url_with_key);
			$ch = curl_init($api_url_with_key);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout after 30 seconds
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			log_message('debug', 'response: '. $response);

			if ($httpCode == 200) {
				libxml_use_internal_errors(true);
				$xmlObject = simplexml_load_string($response);
				if( $xmlObject === false){
					log_message('error', 'Invalid XML response received.');
					echo json_encode([
						'status' => 'error',
						'message' => 'Error on Decryption - Cipher Key not valid',
						'http_code' => 500
					]);
					exit;
				}
				else{
					log_message('debug', 'is xml ? = '. $xmlObject);
					function xmlToArray($xml) {
						$json = json_encode($xml);
						$array = json_decode($json, true);

						return removeAttributes($array);
					}
					function removeAttributes($data) {
						if (!is_array($data)) {
							return $data;
						}
						// If @attributes exist, merge them with the current array
						if (isset($data["@attributes"])) {
							$data = array_merge($data["@attributes"], $data);
							unset($data["@attributes"]);
						}
						// Recursively process child elements
						foreach ($data as $key => &$value) {
							$value = removeAttributes($value);
						}
						return $data;
					}
					$jsonArray = xmlToArray($xmlObject);
					$json = json_encode($jsonArray, JSON_PRETTY_PRINT);
					echo json_encode([
						'status' => 'success',
						'message' => 'Admission form submitted successfully!',
						'api_response' => json_decode($json, true),
						'http_code' => $httpCode
					]);
				}
				
			}
			else if ($httpCode == 0){
				echo json_encode([
					'status' => 'error',
					'message' => 'Error connecting to external API.',
					'http_code' => $httpCode
				]);
			}
			else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Failed to submit admission form to external API.',
					'http_code' => $httpCode,
					'api_response' => $response
				]);
			}

		}
		
	}

	public function submitXMLData()
	{
		$this->load->helper('config');
		$api_config = get_config_ini('API_CREDENTIALS');
		$api_key = $api_config['API_KEY'];
		$api_url = $api_config['API_URL'];
		$app_key = $api_config['APP_KEY'];
		$data = $this->input->post('data_dict');

		foreach ($data as $dict_data) {
			// Access individual properties directly
		
			//$dict_data = json_decode($dict_data_d, true);

			log_message("debug", "data: ". json_encode($dict_data));
			$AdmDateStr = $dict_data['admission_date']; 
			$pBirthdateStr = $dict_data['patient_birthdate'];
			$pBirthdate = DateTime::createFromFormat('d-m-Y', $pBirthdateStr);
			$pBdayFormatted = $pBirthdate->format('Y-m-d');
			$AdmDate = new DateTime($AdmDateStr);
			$formattedAdmDate = $AdmDate->format('Y-m-d');
			$pAge = $pBirthdate->diff(new DateTime)->y;

			$mononym = "N";
	
			if ($dict_data["pLastname"] == "" && $dict_data["pMiddlename"] == "") {
				$mononym = "Y";
			}
			
			
			$data_array = array(
				"hospital_code"=> $this->hospital_code,
				"case_number"=> $dict_data['case_number'] ,
				"p_mononym"=> $mononym,
				"p_first_name"=> $dict_data['pFirstname'],
				"p_middle_name"=> $dict_data['pMiddlename'],
				"p_last_name"=> $dict_data['pLastname'],
				"p_suffix"=>  $dict_data['patient_suffix'],
				"p_birthday"=> $pBdayFormatted,  
				"p_gender"=> $dict_data['patient_sex'],    
				"p_age"=> $pAge,
				"p_nationality"=> "",
				"p_contact_number"=> $dict_data['patient_contact_number'],
				"p_email_address"=> $dict_data['patient_email_address'],
				"p_address"=> $dict_data['address'],
				"patient_type"=> $dict_data['patient_type'],
				"patient_pin"=> $dict_data['member_pin'],
				"m_first_name"=> $dict_data['mFirstname'],
				"m_last_name"=> $dict_data['mLastname'],
				"m_middle_name"=> $dict_data['mLastname'],
				"m_suffix"=> $dict_data['member_suffix'], 
				"m_email_address"=> $dict_data['member_email_address'],
				"m_contact_number"=> $dict_data['member_contact_number'],
				"benefit_availment"=> $dict_data['type_of_benefit'],
				"reason_for_availment"=> $dict_data['availment_type'],
				"chief_complaint"=> $dict_data['admission_diagnosis'],
				"admission_code"=> $dict_data['medical_code'], 
				"admission_date"=> $formattedAdmDate,
				"admission_time"=> $dict_data['admission_time'],
				"is_extracted"=> "T"
			);

			log_message('debug', 'data: '. json_encode($data_array));
			
	
			$api_url_with_key = $api_url . '?api_key=' . $api_key . '&app_key='. $app_key ;
			log_message('debug', 'API URL: ' . $api_url_with_key);
			$ch = curl_init($api_url_with_key);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_array));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	
			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);


			$jsonResponse = json_decode($response, true);
			log_message('debug', 'response'. $response);
			if ($httpCode == 200) {
				echo json_encode([
					'status' => 'success',
					'message' => 'Admission form submitted successfully!',
					'api_response' => $jsonResponse
				]);
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Failed to submit admission form to external API.',
					'http_code' => $httpCode,
					'api_response' => $jsonResponse
				]);
			}
		}
		
	}

	public function GenerateAdmissionList()
	{
		$this->load->helper('config');
		$data = $this->input->post('jsonData');
		$start_date = $data["start_date"];
		$end_date = $data["end_date"];
		$f_start_date = new DateTime($start_date);
		$f_end_date = new DateTime($end_date);
		$formatted_start_date = $f_start_date->format('d-m-Y');
		$formatted_end_date = $f_end_date->format('d-m-Y');

		$api_config = get_config_ini('API_CREDENTIALS');
		$api_url = $api_config['API_GET_ADMISSION_DATA_URL'];
		$api_url_with_key = $api_url . '?pmcc_no='. $this->hospital_code . '&start_date=' . $formatted_start_date . '&end_date=' . $formatted_end_date;
		
		$ch = curl_init($api_url_with_key);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		$decodedResponse = json_decode($response, true); // decode as assoc array
		log_message('debug', 'response: '. $response);
		if ($httpCode == 200) {
				echo json_encode([
					'status' => 'success',
					'message' => 'Admission form submitted successfully!',
					'api_response' => $decodedResponse
				]);
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'Failed to submit admission form to external API.',
					'http_code' => $httpCode,
					'api_response' => $decodedResponse
				]);
			}

	}
}

