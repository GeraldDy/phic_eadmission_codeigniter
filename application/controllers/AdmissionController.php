<?php
class AdmissionController extends CI_Controller {
	public function index()
	{
        $data['title'] = "Admission Form";
		$this->load->view('Admission/admission_form', $data);
	}
}
