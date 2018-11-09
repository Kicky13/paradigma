<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test7000 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('stokpp&gudang/mtest7000');
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

	    $realisasi7000=$this->mtest7000->get_realisasi($tahun,$bulan,$hari,$date);
	    $realisasi_h7000=$this->mtest7000->get_realisasi_h($tahun,$bulan,$hari,$date);
      $realisasilalu7000=$this->mtest7000->get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
	    $realisasi_l7000=$this->mtest7000->get_realisasi_l($tahunlalu,$bulan,$hari,$datelalu);
	    $ekspor7000=$this->mtest7000->get_ekspor($tahun,$bulan,$hari,$date);
	    $eksporlalu7000=$this->mtest7000->get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu);
	//tahun sekarang
    $real7000='';
    foreach ($realisasi7000 as $r) {
      $real7000+=$r->REALISASI;
    }

    foreach ($realisasi_h7000 as $r) {
      $real_h7000=$r->REALISASI;
    }
    if($bulan==date('m')){
  	 $real_sdk7000=$real7000-$real_h7000;
	}else{
	 $real_sdk7000=$real7000;
	}
   

    foreach ($ekspor7000 as $e) {
      $prog7000=$e->PROG;
      $rkap7000=$e->RKAP;
      $prog_h7000=$e->PROGNOSE_HARIAN;
      $real_ekspor_sm7000=$e->REAL_EKSPOR;
      $real_ekspor_tr7000=$e->REAL_EKSPOR_CURAH;
      $rkap_eks7000=$e->RKAP_EKSPOR;

    }
    if($bulan==date('m')){
    $rkap_sdk7000=$rkap7000-$prog_h7000-$prog7000;
	}else{
	$rkap_sdk7000=$rkap7000;
	}


    //tahun lalu
    $reallalu7000='';
    foreach ($realisasilalu7000 as $r) {
      $reallalu7000+=$r->REALISASI;
    }

    $real_l7000='';
    foreach ($realisasi_l7000 as $r) {
      $real_l7000+=$r->REALISASI;
    }

    foreach ($eksporlalu7000 as $e) {
      $proglalu7000=$e->PROG;
      $rkaplalu7000=$e->RKAP;
      $prog_hlalu7000=$e->PROGNOSE_HARIAN;
      $real_ekspor_smlalu7000=$e->REAL_EKSPOR;
      $real_ekspor_trlalu7000=$e->REAL_EKSPOR_CURAH;
      $rkap_ekslalu7000=$e->RKAP_EKSPOR;

    }

    //growth
    $dom_real=($real7000-$reallalu7000)*100/$reallalu7000;
			$dom_prog=(($real7000+$prog7000)-$real_l7000)*100/$real_l7000;
			if($real_ekspor_trlalu7000!=0){
			$ekspor_real=(($real_ekspor_sm7000+$real_ekspor_tr7000)-($real_ekspor_smlalu7000+$real_ekspor_trlalu7000))*100/($real_ekspor_smlalu7000+$real_ekspor_trlalu7000);
		}else{
			$ekspor_real=0;
		}

		//json
    $data['s7000']['dom']=array('real_sdk'=>$real_sdk7000,
              'rkap_sdk'=>$rkap_sdk7000,
              'selisih'=>$real_sdk7000-$rkap_sdk7000,
              

      );
    $data['ekspor']=array('real_sm'=>$real_ekspor_sm7000,
              'real_tr'=>$real_ekspor_tr7000,
              'rkap_eks'=>$rkap_eks7000,
              

      );
    $data['growth']=array('dom_real'=>$dom_real,
							'dom_prog'=>$dom_prog,
							'ekspor_real'=>$ekspor_real

			);

    echo json_encode($data);
	}

}

/* End of file test7000.php */
/* Location: ./application/controllers/test7000.php */