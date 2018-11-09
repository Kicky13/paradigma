<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class quality_management extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('m_qm');
    }
	
	public function get_report_siramah(){
        $comp = $_GET['company'];
		$month = (empty($_GET['month']) ? date('m') : $_GET['month']);
		$year = (empty($_GET['year']) ? date('Y') : $_GET['year']);
		$data = array();
		$data['total'] = $this->m_qm->get_total_siramah($comp, $month, $year);
		$data['action'] = $this->m_qm->get_action_siramah($comp, $month, $year);
		print_r(json_encode($data));
	}

	public function get_report_siramah_score(){
		$data = array();
		$data = $this->m_qm->get_action_siramah_report();
		print_r(json_encode($data));
	}
}
