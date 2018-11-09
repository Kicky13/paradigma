<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi_smig extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('stokpp&gudang/m_produksismig');
	}

	public function index()
	{
		$month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
	    $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
	    $date = "$year$month";
	    $this->m_produksismig->get_produksismig($date);
		
	}

	public function prod_data()
	{
		$month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
	    $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
	    $date = "$year$month";
		$terak = $this->m_produksismig->get_produksi_terak_smig($date);
		$semen = $this->m_produksismig->get_produksi_semen_smig($date);
		// $sementltemp = $this->m_produksismig->get_rkapsd_semen_tl($date);

		// $rkapsdstlc = (float) $sementltemp[RKAP_PRODUK];

		$tot_real_t = 0;
		$tot_rkap_t = 0;
		$tot_rkapsd_t = 0;
		$tot_prognose_t = 0;

		$tot_real_s = 0;
		$tot_rkap_s = 0;
		$tot_rkapsd_s = 0;
		$tot_prognose_s = 0;

		foreach ($terak as $key=>$value){
            
            $return["Terak_".$value->ORG] = array(
              "REALISASI"=>$value->REALISASI,
              "RKAP_SD"=>$value->RKAP_SD,
              "RKAP"=>$value->RKAP,
              "PROGNOSE"=>$value->PROGNOSE
            );

            if ($value->ORG != '6000') {
            	$temp1 = (float) $value->REALISASI;
            	$temp2 = (float) $value->RKAP_SD;
            	$temp3 = (float) $value->RKAP;
            	$temp4 = (float) $value->PROGNOSE;

            	$tot_real_t = $tot_real_t + $temp1;
				$tot_rkap_t = $tot_rkap_t + $temp2;
				$tot_rkapsd_t = $tot_rkapsd_t + $temp3;
				$tot_prognose_t = $tot_prognose_t + $temp4;
            	# code...
            }
             
        }

        $return["Terak_SMIG"] = array(
              "REALISASI"=>$tot_real_t,
              "RKAP_SD"=>$tot_rkap_t,
              "RKAP"=>$tot_rkapsd_t,
              "PROGNOSE"=>$tot_prognose_t
            );

        foreach ($semen as $key=>$value){
            
            if ($value->ORG != '6000') {
            	$return["Semen_".$value->ORG] = array(
              	"REALISASI"=>$value->REALISASI,
              	"RKAP_SD"=>$value->RKAP_SD,
              	"RKAP"=>$value->RKAP,
              	"PROGNOSE"=>$value->PROGNOSE
            	);
            	# code...
            }else{
            	$return["Semen_".$value->ORG] = array(
              	"REALISASI"=>$value->REALISASI,
              	"RKAP_SD"=>$value->RKAP_SD,
              	"RKAP"=>$value->RKAP,
              	"PROGNOSE"=>$value->PROGNOSE
            	);
            }
            

            if ($value->ORG != '6000') {
            	$temp1 = (float) $value->REALISASI;
            	$temp2 = (float) $value->RKAP_SD;
            	$temp3 = (float) $value->RKAP;
            	$temp4 = (float) $value->PROGNOSE;

            	$tot_real_s = $tot_real_s + $temp1;
				$tot_rkap_s = $tot_rkap_s + $temp2;
				$tot_rkapsd_s = $tot_rkapsd_s + $temp3;
				$tot_prognose_s = $tot_prognose_s + $temp4;
            	# code...
            }

        }

        $return["Semen_SMIG"] = array(
              "REALISASI"=>$tot_real_s,
              "RKAP_SD"=>$tot_rkap_s,
              "RKAP"=>$tot_rkapsd_s,
              "PROGNOSE"=>$tot_prognose_s
            );

        echo json_encode($return);
	}

	public function monthly(){
		  $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
	      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
	      $com = (empty($_GET['company']) ? '' : $_GET['company']);

	      $resultTerak = $this->m_produksismig->get_produksi_monthly($year, $month, $com, 1);
	      $resultSemen = $this->m_produksismig->get_produksi_monthly($year, $month, $com, 2);
          $arrayTemp = array();
	      $terak= array();

	      if ($com=='smi'||$com=='SMI') {
	      	# code...
	      	
	      }
	      foreach ($resultTerak as $key => $value) {
	      	# code...
	      	# 
	      	$pieces = explode("-", $value['TANGGAL']);
	      	$arrayTemp[$pieces[2]]['tanggal'] = $value['TANGGAL'];
	      	$arrayTemp[$pieces[2]]['rkap'] = $value['RKAP'];
	      	$arrayTemp[$pieces[2]]['prognose'] = $value['PROGNOSE'];
	      	$arrayTemp[$pieces[2]]['realisasi'] = $value['REALISASI'];
	      	// echo "$key -> ".$value['RKAP'];
	      }
          $terak[$com]=$arrayTemp;

	      //semen
	      $semen= array();
	      foreach ($resultSemen as $key => $value) {
	      	# code...
	      	
	      	$pieces = explode("-", $value['TANGGAL']);

	      	$arrayTemp[$pieces[2]]['tanggal'] = $value['TANGGAL'];
	      	$arrayTemp[$pieces[2]]['rkap'] = $value['RKAP'];
	      	$arrayTemp[$pieces[2]]['prognose'] = $value['PROGNOSE'];
	      	$arrayTemp[$pieces[2]]['realisasi'] = $value['REALISASI'];


	      	// echo "$key -> ".$value['RKAP'];
	      }
          $semen[$com]=$arrayTemp;

	      $json['terak'] = $terak;
	      $json['semen'] = $semen;

	      echo json_encode($json);
	}

    public function akumulatif(){
		  $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
	      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
	      $com = (empty($_GET['company']) ? '' : $_GET['company']);

	      $resultTerak = $this->m_produksismig->get_produksi_monthly($year, $month, $com, 1);
	      $resultSemen = $this->m_produksismig->get_produksi_monthly($year, $month, $com, 2);
	      $terak= array();

	      if ($com=='smi'||$com=='SMI') {
	      	# code...
	      	
	      }
          $total_rkap = 0;
          $total_prognose = 0;
          $total_real = 0;
	      foreach ($resultTerak as $key => $value) {
	      	# code...
	      	# 
	      	$total_rkap += $value['RKAP'];
	      	$total_prognose += $value['PROGNOSE'];
	      	$total_real += $value['REALISASI'];
	      	$pieces = explode("-", $value['TANGGAL']);
	      	$arrayTemp[$pieces[2]]['tanggal'] = $value['TANGGAL'];
	      	$arrayTemp[$pieces[2]]['rkap'] = $total_rkap;
	      	$arrayTemp[$pieces[2]]['prognose'] = $total_prognose;
	      	$arrayTemp[$pieces[2]]['realisasi'] = $total_real;
	      	// echo "$key -> ".$value['RKAP'];
	      }
	      $terak[$com]=$arrayTemp;

	      //semen
	      $semen= array();
          $total_rkap = 0;
          $total_prognose = 0;
          $total_real = 0;
	      foreach ($resultSemen as $key => $value) {
	      	# code...

	      	$total_rkap += $value['RKAP'];
	      	$total_prognose += $value['PROGNOSE'];
	      	$total_real += $value['REALISASI'];
          	$pieces = explode("-", $value['TANGGAL']);
	      	$arrayTemp[$pieces[2]]['tanggal'] = $value['TANGGAL'];
	      	$arrayTemp[$pieces[2]]['rkap'] = $total_rkap;
	      	$arrayTemp[$pieces[2]]['prognose'] = $total_prognose;
	      	$arrayTemp[$pieces[2]]['realisasi'] = $total_real;


	      	// echo "$key -> ".$value['RKAP'];
	      }
	      $semen[$com]=$arrayTemp;


	      $json['terak'] = $terak;
	      $json['semen'] = $semen;

	      echo json_encode($json);     
    }

}

/* End of file produksi_smig.php */
/* Location: ./application/controllers/produksi_smig.php */