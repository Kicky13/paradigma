<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_lembar_saham extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->db=$this->load->database('default5',true);
	}

	public function get($bulan,$tahun)
	{
		$this->db->where(array('BULAN'=>$bulan,
								'TAHUN'=>$tahun));						// 'TAHUN'=>$tahun));
		$sql=$this->db->get('LEMBAR_SAHAM');
		return $sql;
	}

	public function get_ev($bulan,$tahun)
	{
		$this->db->where(array('BULAN'=>$bulan,
								'TAHUN'=>$tahun));						// 'TAHUN'=>$tahun));
		$sql=$this->db->get('EV_SG');
		return $sql;
	}




}

/* End of file m_lembar_saham.php */
/* Location: ./application/models/m_lembar_saham.php */