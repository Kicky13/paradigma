<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test6000 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('stokpp&gudang/mtest6000');
	}
	public function index()
	{

		//TLCC(6000)
		$bulan=date('m');
		$tahun=date('Y');
		$hari=date('d');
		$date=$tahun.$bulan;
		$tahunlalu=$tahun-1;
		$datelalu=$tahunlalu.$bulan;
		$hariawal=$datelalu.'01';

		$tgl_skrg=date('d');	
		$progrkap=$this->mtest6000->get_progrkap($tahun,$bulan,$hari,$date);
		$progrkaplalu=$this->mtest6000->get_progrkaplalu($tahunlalu,$bulan,$hari,$datelalu);
		$realisasi=$this->mtest6000->get_realisasi($tahun,$bulan,$hari,$date);
		$realisasilalu=$this->mtest6000->get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
		$realisasi_l=$this->mtest6000->get_realisasi_l($tahunlalu,$bulan,$hari,$datelalu);
		$realisasi_h=$this->mtest6000->get_realisasi_h($tahun,$bulan,$hari,$date);
		$ekspor=$this->mtest6000->get_ekspor($tahun,$bulan,$hari,$date);
		$eksporlalu=$this->mtest6000->get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu);

		//tahunlalu
		foreach ($progrkaplalu as $p) {
			$proglalu=$p->PROG;
			$rkaplalu=$p->RKAP;
		}
		$prog_hlalu=$rkaplalu/30;
		$rkap_sdhlalu=($tgl_skrg/30)*$rkaplalu;
		$rkap_sdklalu=	$rkap_sdhlalu-$prog_hlalu;

		$reallalu='';
		foreach ($realisasilalu as $r) {
			$reallalu+=$r->REALISASI;
		}

		$real_l='';
		foreach ($realisasi_l as $r) {
			$real_l+=$r->REALISASI;
		}

		foreach ($eksporlalu as $e) {
			$real_smlalu=$e->REAL_EKSPOR_SM;
			$real_trlalu=$e->REAL_EKSPOR_TR;
			$rkap_ekslalu=$e->RKAP_EKSPOR;
		}


		//tahun skarang

		foreach ($progrkap as $p) {
			$prog=$p->PROG;
			$rkap=$p->RKAP;
		}
		$prog_h=$rkap/30;
		$rkap_sdh=(30/30)*$rkap;
		$rkap_sdk=$rkap_sdh-$prog_h;

		$real='';
		foreach ($realisasi as $r) {
			$real+=$r->REALISASI;
		}
		foreach ($realisasi_h as $r) {
			$real_h=$r->REALISASI;
		}

		$real_sdk=$real-$real_h;

		foreach ($ekspor as $e) {
			$real_sm=$e->REAL_EKSPOR_SM;
			$real_tr=$e->REAL_EKSPOR_TR;
			$rkap_eks=$e->RKAP_EKSPOR;
		}


			$dom_real=($real-$reallalu)*100/$reallalu;
			$dom_prog=(($real+$prog)-$real_l)*100/$real_l;
			$ekspor_real=(($real_sm+$real_tr)-($real_smlalu+$real_trlalu))*100/($real_smlalu+$real_trlalu);
		//json

		$data['s6000']['dom']=array('real_sdk'=>$real_sdk,
							'rkap_sdk'=>$rkap_sdk,
							'selisih'=>$real_sdk-$rkap_sdk,
							

			);
		$data['ekspor']=array('real_sm'=>$real_sm,
							'real_tr'=>$real_tr,
							'rkap_eks'=>$rkap_eks,
							

			);
		$data['growth']=array('dom_real'=>$dom_real,
							'dom_prog'=>$dom_prog,
							'ekspor_real'=>$ekspor_real

			);

		echo json_encode($data);


	}

}

/* End of file test6000.php */
/* Location: ./application/controllers/test6000.php */