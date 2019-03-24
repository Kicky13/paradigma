<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class capex extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_capex');
        $this->load->library('session');
    }

    function getCAPEXSMIG()
    {
        $year = $this->input->post('year');
        $data = $this->m_capex->getMainCAPEXData($year);
        echo json_encode($data);
    }

    function getReportCAPEXPerCompany()
    {
        $year = $this->input->post('year');
        $data = $this->m_capex->getCAPEXPerCompany($year);
        echo json_encode($data);
    }

    function getCurrentProject()
    {
        $data = $this->m_capex->getCurrentProject($this->input->post('company'), $this->input->post('year'), $this->input->post('priority'));
        echo json_encode($data);
    }

    function getDataDashboard($year)
    {
        $data = $this->m_capex->getCAPEXPerCompany($year);
        echo json_encode($data);
    }

    function getByProject()
    {
        $year = $this->input->get('year', TRUE);
        $data = $this->m_capex->getDataByProject($year);
        echo json_encode($data);
    }

    function getByType()
    {
        $year = $this->input->get('year', TRUE);
        $data = $this->m_capex->getDataByType($year);
        echo json_encode($data);
    }

    function getDetailProject()
    {
        $year = $this->input->get('year', TRUE);
        $project = $this->input->get('project', TRUE);
        $company = $this->input->get('company', TRUE);
        $data = $this->m_capex->getDetailProject($company, $project, $year);
        echo json_encode($data);
    }

    function getDataDashboardNew($year)
    {
        $data = $this->m_capex->capexDashboardControl($year);
        echo json_encode($data);
    }
}