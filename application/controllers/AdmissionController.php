<?php
class AdmissionController extends CI_Controller {

	public $hospital_code; 
	public $cipher_key;
	public function __construct() {
        parent::__construct();
        $vAccreID = $this->input->cookie('accreid') ?? 'A91000007'; 
        $this->hospital_code = $this->get_hospital_code($vAccreID);
		$this->cipher_key = $this->get_cipher_key($this->hospital_code);
		log_message('debug', 'cipher_key-'. $this->cipher_key);
    }

	public function get_hospital_code($vAccreID){
		$this->load->helper('config');
		$api_config = get_config_ini('API_CREDENTIALS');
		$api_key = $api_config['API_KEY'];
		$app_key = $api_config['APP_KEY'];
		$api_url = $api_config['API_GET_HOSPITAL_CODE_URL'];
		$api_url_with_key = $api_url . $vAccreID . '?api_key=' . $api_key . '&app_key='. $app_key ;
		log_message('debug', 'API URL: ' . $api_url_with_key);
		$ch = curl_init($api_url_with_key);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		log_message('debug', 'response'. $response);

		if ($httpCode == 200) {
			return $response;
		} else {
			return null;
		}
	}

	public function get_cipher_key($hospital_code){
		$this->load->helper('config');
		$api_config = get_config_ini('API_CREDENTIALS');
		$api_key = $api_config['API_KEY'];
		$app_key = $api_config['APP_KEY'];
		$api_url = $api_config['API_GET_CIPHER_KEY_URL'];
		$api_url_with_key = $api_url . '?api_key=' . $api_key . '&app_key='. $app_key . '&hospital_code=' . $hospital_code ;
		log_message('debug', 'API URL: ' . $api_url_with_key);
		$ch = curl_init($api_url_with_key);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		log_message('debug', 'response'. $response);

		if ($httpCode == 200) {
			return $response;
		} else {
			return null;
		}
	}
	public function index()
	{
		//$vAccreID = $this->input->cookie('accreid');
		$vAccreID = 'A91000007';
		$vUserName = $this->input->cookie('username');
		$vAdmissionMod = $this->input->cookie('adm');
		
	
		log_message('debug', 'hospital_code:'. $this->hospital_code);

		$this->load->helper('config');
		$api_config = get_config_ini('API_CREDENTIALS');
		$api_key = $api_config['API_KEY'];
		$app_key = $api_config['APP_KEY'];
		$api_url = $api_config['API_GET_LOGBOOK_DATA_URL'];
		
		$api_url_with_key = $api_url .$this->hospital_code.'?api_key=' . $api_key . '&app_key='. $app_key;
		log_message('debug', 'API URL: ' . $api_url_with_key);
		$ch = curl_init($api_url_with_key);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		log_message('debug', 'response'. $response);

		if ($httpCode == 200) {
			$data['title'] = "Dashboard";
			$data['admission_data'] = json_decode($response,true);
			$this->load->view('Admission/dashboard', $data);
		} else {
			return null;
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
		#$vAccreID = $this->input->cookie('accreid') ;
		$vAccreID ='A91000007';
		
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
		$pAge = $pBirthdate->diff(new DateTime)->y;
		
		log_message('debug', 'subnmit: ' . $this->hospital_code);
	
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

		
		$api_url_with_key = $api_url . '?api_key=' . $api_key. '&app_key='. $app_key ;
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

	public function xml_uploading_index(){
		$vAccreID = $this->input->cookie('accreid');
		$vUserName = $this->input->cookie('username');
		$vAdmissionMod = $this->input->cookie('adm');
		$this->load->view('Admission/xml_uploading');
	}
	public function uploadXML()
	{
		$this->load->helper('config');
		$data = $this->input->post('encrypted_data');
		
		$api_config = get_config_ini('API_CREDENTIALS');
		$api_url = $api_config['API_DECRYPT_URL'];

		$cipher_key = "PHilheaLthDuMmyciPHerKeyS"; 
		//$cipher_key = "DummyCipherKey300806"; A91000088 H12345
		log_message('debug', 'json_encode data: ' . $data);
		$api_url_with_key = $api_url . '?Cipherkey=' . $cipher_key;
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
		log_message('debug', 'response: '. $httpCode);

		
        if ($httpCode == 200) {
			$xmlObject = simplexml_load_string($response);
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

	public function submitXMLData()
	{
		$this->load->helper('config');
		$api_config = get_config_ini('API_CREDENTIALS');
		$api_key = $api_config['API_KEY'];
		$api_url = $api_config['API_URL'];
		$app_key = $api_config['APP_KEY'];
		#$vAccreID = $this->input->cookie('accreid') ;
		$vAccreID ='A91000007';
		$hospital_code = $this->hospital_code;
		$data = $this->input->post('data_dict');

		foreach ($data as $dict_data) {
			// Access individual properties directly
			log_message("debug" , "test " . $dict_data);
			//$dict_data = json_decode($dict_data_d, true);

			log_message("debug", "last_name: ". json_encode($dict_data["pLastname"]));
			$AdmDateStr = $dict_data['admission_date']; 

			$pBirthdateStr = $dict_data['patient_birthdate'];
			$pBirthdate = DateTime::createFromFormat('m-d-Y', $pBirthdateStr);
			$pAge = $pBirthdate->diff(new DateTime)->y;
			log_message('debug', 'data ' . $pBirthdateStr);

			$mononym = "N";
	
			if ($dict_data["pLastname"] == "" && $dict_data["pMiddlename"] == "") {
				$mononym = "Y";
			}
			
			
			$data_array = array(
				"hospital_code"=> $this->hospital_code,
				"case_number"=>  "",
				"p_mononym"=> $mononym,
				"p_first_name"=> $dict_data['pFirstname'],
				"p_middle_name"=> $dict_data['pMiddlename'],
				"p_last_name"=> $dict_data['pLastname'],
				"p_suffix"=>  $dict_data['patient_suffix'],
				"p_birthday"=> $pBirthdateStr,  
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
				"admission_date"=> $AdmDateStr,
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
}

