<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lembar_saham extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_lembar_saham');
	}

	public function index()
	{
		$bulan=$this->input->get('bulan');
		$tahun=$this->input->get('tahun');
		$sql=$this->m_lembar_saham->get($bulan,$tahun);
		if($sql->num_rows>0){
		foreach ($sql->result_array() as $rowID) {
					$bulan=$rowID['BULAN'];
					$tahun=$rowID['TAHUN'];
					$smgr=$rowID['SMGR'];
					$intp=$rowID['INTP'];
					$smcb=$rowID['SMCB'];
					$ket=$rowID['KET'];
		$data[]=array(						'ket'=>$ket,
											'smgr'=>$smgr,
											'intp'=>$intp,
											'smcb'=>$smcb

			);
		}
	}else{
		$data[]=array(						'ket'=>'',
											'smgr'=>'0',
											'intp'=>'0',
											'smcb'=>'0'
											);
	}

		echo json_encode($data);
	}

	public function ev_sg()
	{
		$bulan=$this->input->get('bulan');
		$tahun=$this->input->get('tahun');
		$sql=$this->m_lembar_saham->get_ev($bulan,$tahun);
		if($sql->num_rows>0){
		foreach ($sql->result_array() as $rowID) {
					$bulan=$rowID['BULAN'];
					$tahun=$rowID['TAHUN'];
					$smgr=$rowID['SMGR'];
					$ket=$rowID['KET'];
		$data[]=array(						'ket'=>$ket,
											'smgr'=>$smgr

			);
		}
	}else{
		$data[]=array(						'ket'=>'',
											'smgr'=>'0'
											);
	}
	echo json_encode($data);
	}

}

/* End of file lembar_saham.php */
/* Location: ./application/controllers/lembar_saham.php */