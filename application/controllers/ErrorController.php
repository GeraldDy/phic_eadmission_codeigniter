<?php
class ErrorController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    // 404 error page
    public function page_missing()
    {
        $this->output->set_status_header(404);
        $this->load->view('error_template/page_missing');
    }

    // 500 error page (example)
    public function error_500()
    {
        $this->output->set_status_header(500);
        $this->load->view('error_template/internal_server');
    }
}
