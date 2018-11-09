<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test3000 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('stokpp&gudang/mtest3000');
	}
	public function index()
	{
		$bulan=date('m');
		$tahun=date('Y');
		$hari=date('d');
		$date=$tahun.$bulan;
		$tahunlalu=$tahun-1;
		$datelalu=$tahunlalu.$bulan;
		$hariawal=$datelalu.'01';

		$realisasi3000=$this->mtest3000->get_realisasi($tahun,$bulan,$hari,$date);
		$realisasi_h3000=$this->mtest3000->get_realisasi_h($tahun,$bulan,$hari,$date);
		$realisasilalu3000=$this->mtest3000->get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
		$realisasilalu13000=$this->mtest3000->get_realisasilalu1($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
		$ekspor3000=$this->mtest3000->get_ekspor($tahun,$bulan,$hari,$date);
		$eksporlalu3000=$this->mtest3000->get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu);

		//tahun sekaran
		$real3000='';
		foreach ($realisasi3000 as $r) {
			$real3000+=$r->REALISASI;
		}
		foreach ($realisasi_h3000 as $r) {
			$real_h3000=$r->REALISASI;
		}
		if($bulan==date('m')){
		$real_sdk3000=$real3000-$real_h3000;
	}else{
		$real_sdk3000=$real3000;
	}
		foreach ($ekspor3000 as $e) {
			$rkap3000=$e->RKAP;
			$prog_h3000=$e->PROGNOSE_HARIAN;
			$prog3000=$e->PROG;
			$real_ekspor_sm3000=$e->REAL_EKSPOR;
			$rkap_ekspor3000=$e->RKAP_EKSPOR;
			//$real_ekspor_tr3000=0;
		}

		if($bulan==date('m')){
		$rkap_sdk3000=$rkap3000-$prog3000-$prog_h3000;
	}else{
		$rkap_sdk3000=$rkap3000;
	}
		


		//tahun lalu
		$reallalu3000='';
		foreach ($realisasilalu3000 as $r) {
			$reallalu3000+=$r->REALISASI;
		}

		$reallalu13000='';
		foreach ($realisasilalu13000 as $r) {
			$reallalu13000+=$r->REALISASI;
		}

		foreach ($eksporlalu3000 as $e) {
			// $rkaplalu3000=$e->RKAP;
			// $prog_hlalu3000=$e->PROGNOSE_HARIAN;
			$real_ekspor_smlalu3000=$e->REAL_EKSPOR;
			$rkap_eksporlalu3000=$e->RKAP_EKSPOR;
			//$real_ekspor_trlalu3000=0;
		}


		//growth
		$dom_real3000=($real3000-$reallalu3000)*100/$reallalu3000;
			$dom_prog3000=(($real3000+$prog3000)-$reallalu13000)*100/$reallalu13000;
			 if($real_ekspor_smlalu3000!=0 ){
			$ekspor_real3000=($real_ekspor_sm3000-$real_ekspor_smlalu3000)*100/($real_ekspor_smlalu3000);
		}else{
			$ekspor_real3000=0;
		}

		//json
		$data['s3000']['dom']=array('real_sdk'=>$real_sdk3000,
							'rkap_sdk'=>$rkap_sdk3000,
							'selisih'=>$real_sdk3000-$rkap_sdk3000);
		$data['ekspor']=array('real_sm'=>$real_ekspor_sm3000,
								'real_tr'=>0,
								'ekspor_real'=>$rkap_ekspor3000);

		$data['growth']=array('dom_real'=>$dom_real3000,
							'dom_prog'=>$dom_prog3000,
							'ekspor_real'=>$ekspor_real3000	

			);
		echo json_encode($data);
	}


}

/* End of file test3000.php */
/* Location: ./application/controllers/test3000.php */