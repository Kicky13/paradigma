<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test4000 extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('stokpp&gudang/mtest4000');
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

		$realisasi4000=$this->mtest4000->get_realisasi($tahun,$bulan,$hari,$date);
		$realisasilalu4000=$this->mtest4000->get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu);
		$realisasi_l4000=$this->mtest4000->get_realisasi_l($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
		$realisasi_h4000=$this->mtest4000->get_realisasi_h($tahun,$bulan,$hari,$date);
		$prognose4000=$this->mtest4000->get_prognose($tahun,$bulan,$hari,$date);
		$prognoselalu4000=$this->mtest4000->get_prognoselalu($tahunlalu,$bulan,$hari,$datelalu);
		$ekspor4000=$this->mtest4000->get_ekspor($tahun,$bulan,$hari,$date);
		$eksporlalu4000=$this->mtest4000->get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu);


		//tahun sekarang
		$real4000='';
		foreach ($realisasi4000 as $r) {
			$real4000+=$r->REALISASI;
		}

		foreach ($realisasi_h4000 as $r) {
			$real_h4000=$r->REALISASI;
		}
		if($bulan==date('m')){
		$real_sdk4000=$real4000-$real_h4000;
		}else{
			$real_sdk4000=$real4000;
		}
		foreach ($prognose4000 as $p) {
			$rkap4000=$p->RKAP;
			$prog4000=$p->PROG;
			$prog_h4000=$p->PROGNOSE_HARIAN;
		}
		if($bulan==date('m')){
			$rkap_sdk4000=$rkap4000-($prog4000+$prog_h4000);
		}else{
			$rkap_sdk4000=$rkap4000;
		}

		if($ekspor4000->num_rows>0){
		foreach ($ekspor4000->result() as $e) {
			
			$real_ekspor_sm4000=$e->REAL_EKSPOR_SM;
			$real_ekspor_tr4000=$e->REAL_EKSPOR_TR;
			$rkap_ekspor4000=$e->RKAP_EKSPOR;
		
		}
		}else{
			$real_ekspor_sm4000=0;
			$real_ekspor_tr4000=0;
			$rkap_ekspor4000=0;
		}


		//tahun lalu
		$reallalu4000='';
		foreach ($realisasilalu4000 as $r) {
			$reallalu4000+=$r->REALISASI;
		}

		$real_l4000='';
		foreach ($realisasi_l4000 as $r) {
			$real_l4000+=$r->REALISASI;
		}

		foreach ($prognoselalu4000 as $p) {
			$rkaplalu4000=$p->RKAP;
			$proglalu4000=$p->PROGNOSE_HARIAN;
		}


		foreach ($eksporlalu4000 as $e) {
			$real_ekspor_smlalu4000=$e->REAL_EKSPOR_SM;
			$real_ekspor_trlalu4000=$e->REAL_EKSPOR_TR;
			$rkap_eksporlalu4000=$e->RKAP_EKSPOR;
		}

		$dom_real4000=($real4000-$real_l4000)*100/$real_l4000;
		$dom_prog4000=(($real4000+$prog4000)-$reallalu4000)*100/$reallalu4000;
		if($real_ekspor_sm4000!=0){
		$ekspor_real4000=(($real_ekspor_sm4000+$real_ekspor_tr4000)-($real_ekspor_smlalu4000+$real_ekspor_trlalu4000))*100/($real_ekspor_smlalu4000+$real_ekspor_trlalu4000);
		}else{
		$ekspor_real4000=0;
		}

		///json
		$data['s4000']['dom']=array('real_sdk'=>$real_sdk4000,
									'rkap_sdk'=>$rkap_sdk4000,
									'selisih'=>$real_sdk4000-$rkap_sdk4000);

		$data['ekspor']=array('real_sm'=>$real_ekspor_sm4000,
									'real_tr'=>$real_ekspor_tr4000,
									'rkap_ekspor'=>$rkap_ekspor4000);

		$data['growth']=array('dom_real'=>$dom_real4000,
							'dom_prog'=>$dom_prog4000,
							'ekspor_real'=>$ekspor_real4000	

			);

		echo json_encode($data);

	}

}

/* End of file volproduksi4000.php */
/* Location: ./application/controllers/volproduksi4000.php */