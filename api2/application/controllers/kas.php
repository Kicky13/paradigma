<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_kas');
	}

	public function index()
	{
		$bulan=date('m');
		$tahun=date('Y');
		$this->m_kas->get_kas($bulan,$tahun);
	}

}

/* End of file kas.php */
/* Location: ./application/controllers/kas.php */