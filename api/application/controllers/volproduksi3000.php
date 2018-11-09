<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Volproduksi3000 extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('stokpp&gudang/m_volproduksi3000');
        $this->load->model('stokpp&gudang/m_volproduksismig');
	}
	public function index_old()
	{
		$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
		$tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
		if($bulan==date('m')){
	      $hari=date('d');
	    }else{
	      $hari=$this->tgl_akhir($tahun,$bulan);
	    }
		$date=$tahun.$bulan;
		$tahunlalu=$tahun-1;
		$datelalu=$tahunlalu.$bulan;
		$hariawal=$datelalu.'01';

		$realisasi3000=$this->m_volproduksi3000->get_realisasi($tahun,$bulan,$hari,$date);
		$realisasi_h3000=$this->m_volproduksi3000->get_realisasi_h($tahun,$bulan,$hari,$date);
		$realisasilalu3000=$this->m_volproduksi3000->get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
		$realisasilalu13000=$this->m_volproduksi3000->get_realisasilalu1($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
		$ekspor3000=$this->m_volproduksi3000->get_ekspor($tahun,$bulan,$hari,$date);
		$eksporlalu3000=$this->m_volproduksi3000->get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu);

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
			if($real_ekspor_sm3000!=0){
			$ekspor_real3000=($real_ekspor_sm3000-$real_ekspor_smlalu3000)*100/($real_ekspor_smlalu3000);
			}
			else{
				$ekspor_real3000=0;
			}
			if($ekspor_real3000!=0){
			$growth_selisih=(($real3000+$real_ekspor_sm3000)-($reallalu3000+$real_ekspor_smlalu3000))*100/($reallalu3000+$real_ekspor_smlalu3000);
		}else{
			$growth_selisih=$dom_real3000;
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
							'ekspor_real'=>$ekspor_real3000,
							'total'=>$growth_selisih

			);
		echo json_encode($data);
	}

   // function index(){
      
   // }
   // 
   function index(){
        $bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);

        $param['year'] = $tahun;
        $param['month'] = $bulan;
        $date = $tahun.$bulan;

        if ($bulan == date('m') && $tahun == date('Y')) {
            # code...
            $param['day'] = date('d');
            $tanggal = date('Ymd');
            $hari = date('d', strtotime($tanggal . "-1 days"));


            
        }else{
            $day = date('t', strtotime($tahun . "-" . $bulan));
            $param['day'] =$day;
            $tanggal = $tahun.$bulan.$day;
            $hari = $day;


        }

        $param['tanggal'] = $tanggal;
        $param['yesterday'] = $hari;
        $smi['real_sdh'] = 0;
        $smi['real_sdk'] = 0;
        $smi['rkap_sdk'] = 0;
        $smi['real_sdh_lalu'] = 0;
        $smi['real_eks'] = 0;
        $smi['real_eks_lalu'] = 0;
        $smi['real_lalu'] = 0;
        $smi['prognose'] = 0;

        $dataSP = $this->m_volproduksismig->sumSalesOpco('3000', $date);

        // $result = $this->m_volproduksismig->salesVolumeSMI($param, $tanggal, $hari);
        $eksporSP = $this->m_volproduksismig->sumEksporSP($date);

        $dataSMI = $dataSP;
      

        $sumEkspor = 0;
        if (isset($eksporSP['REAL_EKSPOR'])) {
         # code...
            $sumEkspor = ($eksporSP['REAL_EKSPOR']);
         
        }
        $dataSMI['REAL_SDK'] -= $sumEkspor;

        $dataSMI['REAL_SDH'] -= $dataSMI['REAL_EKSPOR_TAHUNINI'];

        if ($dataSMI['RKAP_SDK'] == 0) {
            $dataSMI['PERSEN'] = 0;
        } else {
            $dataSMI['PERSEN'] = round($dataSMI['REAL_SDK'] / $dataSMI['RKAP_SDK'] * 100);
        }

        $dataSMI['DEVIASI'] = $dataSMI['REAL_SDK'] - $dataSMI['RKAP_SDK'];

        if ($dataSMI['RKAP_EKSPOR'] == 0) {
            $dataSMI['PERSEN_EKSPOR'] = 0;
        } else {
            $dataSMI['PERSEN_EKSPOR'] = round(($dataSMI['REAL_SM_EKSPOR'] + $dataSMI['REAL_TR_EKSPOR']) / $dataSMI['RKAP_EKSPOR'] * 100);
        }
        
        ############## MENGHITUNG GROWTH ####################
        if ($dataSMI['REAL_SDH_TAHUNLALU'] == 0) {
            $dataSMI['GROWTH_DOM_REAL'] = 0;
        } else {
            $dataSMI['GROWTH_DOM_REAL'] = round((($dataSMI['REAL_SDH']-$dataSMI['REAL_SDH_TAHUNLALU'])/$dataSMI['REAL_SDH_TAHUNLALU'])*100,1);
        }
        if ($dataSMI['REAL_TAHUNLALU'] == 0) {
            $dataSMI['GROWTH_DOM_PROG'] = 0;
        } else {
            $dataSMI['GROWTH_DOM_PROG'] = round(((($dataSMI['REAL_SDH']+$dataSMI['PROGNOSE'])-$dataSMI['REAL_TAHUNLALU'])/$dataSMI['REAL_TAHUNLALU'])*100,1);
        }
        if ($dataSMI['REAL_EKSPOR_TAHUNLALU'] == 0) {
            $dataSMI['GROWTH_EKSPOR'] = 0;
        } else {
            $dataSMI['GROWTH_EKSPOR'] = round((($dataSMI['REAL_EKSPOR_TAHUNINI']-$dataSMI['REAL_EKSPOR_TAHUNLALU'])/$dataSMI['REAL_EKSPOR_TAHUNLALU'])*100,1);
        }
        if ($dataSMI['REAL_EKSPOR_TAHUNLALU'] == 0 && $dataSMI['REAL_TAHUNLALU'] == 0) {
            $dataSMI['GROWTH_TOTAL'] = 0;
        } else {
            $dataSMI['GROWTH_TOTAL'] = round(((($dataSMI['REAL_EKSPOR_TAHUNINI']+$dataSMI['REAL_SDH'])-($dataSMI['REAL_EKSPOR_TAHUNLALU']+$dataSMI['REAL_TAHUNLALU']))/($dataSMI['REAL_EKSPOR_TAHUNLALU']+$dataSMI['REAL_TAHUNLALU']))*100,1);
        }
        ######################################################
        $dom['real_sdk'] = $dataSMI['REAL_SDK'];
        $dom['rkap_sdk'] = $dataSMI['RKAP_SDK'];
        $dom['selisih'] = $dataSMI['DEVIASI'];

        $eks['real_sm'] = $dataSMI['REAL_SM_EKSPOR'];
        $eks['real_tr'] = $dataSMI['REAL_TR_EKSPOR'];
        $eks['rkap_eks'] = $dataSMI['RKAP_EKSPOR'];

        $gro['dom_real'] = $dataSMI['GROWTH_DOM_REAL'];
        $gro['dom_prog'] = $dataSMI['GROWTH_DOM_PROG'];
        $gro['ekspor_real'] = $dataSMI['GROWTH_EKSPOR'];
        $gro['total'] = $dataSMI['GROWTH_TOTAL'];

        $json['s3000']['dom'] = $dom;
        $json['ekspor'] = $eks;
        $json['growth'] = $gro;
        echo json_encode($json);

   }
   
	public function tgl_akhir($thn,$bln)
  {
    $bln1=str_replace(0, '', $bln);
    $bulan[1]='31';
    $bulan[2]='28';
    $bulan[3]='31';
    $bulan[4]='30';
    $bulan[5]='31';
    $bulan[6]='30';
    $bulan[7]='31';
    $bulan[8]='31';
    $bulan[9]='30';
    $bulan[10]='31';
    $bulan[11]='30';
    $bulan[12]='31';

    if ($thn%4==0){
    $bulan[02]=29;
    }

    return $bulan[$bln1];
  }

	

}

/* End of file volproduksi3000.php */
/* Location: ./application/controllers/volproduksi3000.php */