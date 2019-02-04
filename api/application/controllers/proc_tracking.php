<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class proc_tracking extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_proc_tracking');
        $this->load->library('session');
    }

    function getData()
    {
        $data = $this->m_proc_tracking->getData('12', '2018');
        echo json_encode($data);
    }

    function testData()
    {
        $data = $this->m_proc_tracking->getDataPerCompany("12", "2018", "7000");
        echo json_encode($data);
    }

    function getDataPerCompany()
    {
        $data = $this->m_proc_tracking->getDataPerCompany($this->input->get('month'), $this->input->get('year'), $this->input->get('company'));
        echo json_encode($data);
    }
}