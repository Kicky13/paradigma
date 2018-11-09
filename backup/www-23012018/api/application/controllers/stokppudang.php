<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Stokppudang extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('stokpp&gudang/m_stoks7000');
		$this->load->model('stokpp&gudang/m_stoks6000');
		$this->load->model('stokpp&gudang/m_stoks3000');
		$this->load->model('stokpp&gudang/m_stoks4000');
		$this->load->model('m_stokgudang');
	}

	public function stoks4000()
	{
		
		$this->m_stoks4000->get_stoks4000();
	}

	public function stoks7000()
	{
		
		$this->m_stoks7000->get_stoks7000();
	}

	public function stoks3000()
	{

		$this->m_stoks3000->get_stoks3000();
	}

	public function stoks6000()
	{
		
		$this->m_stoks6000->get_stoks6000();
	}

	public function stokpps7000()
	{
		
		$this->m_stoks7000->get_stokpps7000();
	}

	public function stokpps6000()
	{
		
		$this->m_stoks6000->get_stokpps6000();
	}

	public function stokpps4000()
	{
		
		$this->m_stoks4000->get_stokpps4000();
	}

	public function stokpps3000()
	{
		
		$this->m_stoks3000->get_stokpps3000();
	}

	public function stokdetails4000()
	{
		
		$this->m_stoks4000->get_stokdetails4000();
	
	}

	public function stokdetails3000()
	{
		
		$this->m_stoks3000->get_stokdetails3000();
	
	}

	public function stokdetails6000()
	{
		
		$this->m_stoks6000->get_stokdetails6000();
	
	}

	public function stokdetails7000()
	{
		
		$this->m_stoks7000->get_stokdetails7000();
	
	}

	public function stokgudang()
	{
		
		$this->m_stokgudang->get_stokgudang();
	
	}


}

/* End of file stokppudang.php */
/* Location: ./application/controllers/stokppudang.php */