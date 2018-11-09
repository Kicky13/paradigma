<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesvolume_smig extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('stokpp&gudang/m_salesvolume_smig');
	}

	public function index()
	{
	}

	public function monthly(){
		  $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
	      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
	      $com = (empty($_GET['company']) ? '' : $_GET['company']);

	     

	      if ($com=='smi'||$com=='SMI') {
	      	# code...
	      	$result = $this->sales_smi($month, $year);
	      	echo json_encode($result);
	      }else{
	      		 $resultDomestik = $this->m_salesvolume_smig->get_salesvolume_monthly($year, $month, $com);
			      $resultExport = $this->m_salesvolume_smig->get_salesvolume_monthly($year, $month, $com);
			      $arrayTemp = array();
			      $domestik= array();
	      	      foreach ($resultDomestik as $key => $value) {
	      	      	# code...
	      	      	# 
	      	      	// $pieces = explode("-", $value['TANGGAL']);
	      	      	$arrayTemp[$value['TANGGAL']]['tanggal'] = $value['TANGGAL'];
	      	      	$arrayTemp[$value['TANGGAL']]['rkap'] = (float)  $value['RKAP'];
	      	      	$arrayTemp[$value['TANGGAL']]['prognose'] = (float)  $value['PROGNOSE'];
	      	      	$arrayTemp[$value['TANGGAL']]['realisasi'] = (float)  $value['REAL'];
	      	      	// echo "$key -> ".$value['RKAP'];
	      	      }
	      	      $domestik[$com]=$arrayTemp;
	      
	      	      //semen
	      	      $export= array();
	      	      foreach ($resultExport as $key => $value) {
	      	      	# code...
	      	      	
	      	      	// $pieces = explode("-", $value['TANGGAL']);
	      
	      	      	$arrayTemp[$value['TANGGAL']]['tanggal'] = $value['TANGGAL'];
	      	      	$arrayTemp[$value['TANGGAL']]['rkap'] = (float) $value['RKAP'];
	      	      	$arrayTemp[$value['TANGGAL']]['prognose'] = (float) $value['PROGNOSE'];
	      	      	$arrayTemp[$value['TANGGAL']]['realisasi'] = (float) $value['REAL'];
	      
	      
	      	      	// echo "$key -> ".$value['RKAP'];
	      	      }
	      	      $export[$com]=$arrayTemp;
	      
	      
	      	      $json['domestik'] = $domestik;
	      	      $json['export'] = $export;
	      
	      	      echo json_encode($json);}
	}

    public function akumulatif(){
		  $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
	      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
	      $com = (empty($_GET['company']) ? '' : $_GET['company']);

	     

	      if ($com=='smi'||$com=='SMI') {
	      	# code...
	      	$opco = array('6000', '7000', '3000', '4000');
			      $domestik= array();
	      	      $export= array();

  	        $total_rkap_dom = 0;
            $total_prognose_dom = 0;
            $total_real_dom = 0;
            $total_rkap_eks = 0;
            $total_prognose_eks = 0;
            $total_real_eks = 0;

	      	foreach ($opco as $key) {
	      		# code...
	      		  $resultDomestik = $this->m_salesvolume_smig->get_salesvolume_monthly($year, $month, $key);
			      $resultExport = $this->m_salesvolume_smig->get_salesvolume_monthly($year, $month, $key);
	            
	      	      foreach ($resultDomestik as $key => $value) {
	      	      	# code...
	      	      	# 
	      	      	$total_rkap_dom += $value['RKAP'];
	      	      	$total_prognose_dom += $value['PROGNOSE'];
	      	      	$total_real_dom += $value['REAL'];
	      	      	// $pieces = explode("-", $value['TANGGAL']);
	      	      	$arrayTemp[$value['TANGGAL']]['tanggal'] = $value['TANGGAL'];
	      	      	$arrayTemp[$value['TANGGAL']]['rkap'] = $total_rkap_dom;
	      	      	$arrayTemp[$value['TANGGAL']]['prognose'] = $total_prognose_dom;
	      	      	$arrayTemp[$value['TANGGAL']]['realisasi'] = $total_real_dom;
	      	      	// echo "$key -> ".$value['RKAP'];
	      	      }
	      
	      	      //semen
	               
	      	      foreach ($resultExport as $key => $value) {
	      	      	# code...
	      
	      	      	$total_rkap_eks += $value['RKAP'];
	      	      	$total_prognose_eks += $value['PROGNOSE'];
	      	      	$total_real_eks += $value['REAL'];
	                	// $pieces = explode("-", $value['TANGGAL']);
	      	      	$arrayTemp[$value['TANGGAL']]['tanggal'] = $value['TANGGAL'];
	      	      	$arrayTemp[$value['TANGGAL']]['rkap'] = $total_rkap_eks;
	      	      	$arrayTemp[$value['TANGGAL']]['prognose'] = $total_prognose_eks;
	      	      	$arrayTemp[$value['TANGGAL']]['realisasi'] = $total_real_eks;
	      
	      
	      	      	// echo "$key -> ".$value['RKAP'];
	      	      }
	      	}
	  	    $domestik[$com]=$arrayTemp;
	  	    $export[$com]=$arrayTemp;


	      	
	      }else{
	      		  $resultDomestik = $this->m_salesvolume_smig->get_salesvolume_monthly($year, $month, $com);
			      $resultExport = $this->m_salesvolume_smig->get_salesvolume_monthly($year, $month, $com);
			      $domestik= array();
	                $total_rkap = 0;
	                $total_prognose = 0;
	                $total_real = 0;
	      	      foreach ($resultDomestik as $key => $value) {
	      	      	# code...
	      	      	# 
	      	      	$total_rkap += $value['RKAP'];
	      	      	$total_prognose += $value['PROGNOSE'];
	      	      	$total_real += $value['REAL'];
	      	      	// $pieces = explode("-", $value['TANGGAL']);
	      	      	$arrayTemp[$value['TANGGAL']]['tanggal'] = $value['TANGGAL'];
	      	      	$arrayTemp[$value['TANGGAL']]['rkap'] = $total_rkap;
	      	      	$arrayTemp[$value['TANGGAL']]['prognose'] = $total_prognose;
	      	      	$arrayTemp[$value['TANGGAL']]['realisasi'] = $total_real;
	      	      	// echo "$key -> ".$value['RKAP'];
	      	      }
	      	      $domestik[$com]=$arrayTemp;
	      
	      	      //semen
	      	      $export= array();
	                $total_rkap = 0;
	                $total_prognose = 0;
	                $total_real = 0;
	      	      foreach ($resultExport as $key => $value) {
	      	      	# code...
	      
	      	      	$total_rkap += $value['RKAP'];
	      	      	$total_prognose += $value['PROGNOSE'];
	      	      	$total_real += $value['REAL'];
	                	// $pieces = explode("-", $value['TANGGAL']);
	      	      	$arrayTemp[$value['TANGGAL']]['tanggal'] = $value['TANGGAL'];
	      	      	$arrayTemp[$value['TANGGAL']]['rkap'] = $total_rkap;
	      	      	$arrayTemp[$value['TANGGAL']]['prognose'] = $total_prognose;
	      	      	$arrayTemp[$value['TANGGAL']]['realisasi'] = $total_real;
	      
	      
	      	      	// echo "$key -> ".$value['RKAP'];
	      	      }
	      	      $export[$com]=$arrayTemp;
	      	  }


	      $json['domestik'] = $domestik;
	      $json['export'] = $export;

	      echo json_encode($json);     
    }

    public function sales_smi($month, $year){
    	  // $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
	      // $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
	      // $com = (empty($_GET['company']) ? '' : $_GET['company']);
	      $opco = array('sg'=>'7000','st'=> '4000','sp'=> '3000');
	      $tag = 'smi';
	       $domestik= array();
		      $export= array();

	      foreach ($opco as $key => $com) {
	      	// echo "$com -> $key";
	      // 	# code...
	      	 $resultDomestik = $this->m_salesvolume_smig->get_salesvolume_monthly($year, $month, $com);
		      // $resultExport = $this->m_salesvolume_smig->get_salesvolume_monthly($year, $month, $com);
		     
		      foreach ($resultDomestik as $key => $value) {
		      	# code...
		      	# 
		      	// $pieces = explode("-", $value['TANGGAL']);
		      	$arrayTemp[$value['TANGGAL']]['tanggal'] = $value['TANGGAL'];
		      	$arrayTemp[$value['TANGGAL']]['rkap'] = 0;
		      	$arrayTemp[$value['TANGGAL']]['prognose'] = 0;
		      	$arrayTemp[$value['TANGGAL']]['realisasi'] = 0;
		      	// echo "$key -> ".$value['RKAP'];
		      }
		      // $domestik[$tag]=$arrayTemp;

		      //semen
		      // foreach ($resultExport as $key => $value) {
		      // 	# code...
		      	
		      // 	// $pieces = explode("-", $value['TANGGAL']);

		      // 	$arrayTemp[$value['TANGGAL']]['tanggal'] = $value['TANGGAL'];
		      // 	$arrayTemp[$value['TANGGAL']]['rkap'] = 0;
		      // 	$arrayTemp[$value['TANGGAL']]['prognose'] = 0;
		      // 	$arrayTemp[$value['TANGGAL']]['realisasi'] = 0;


		      // 	// echo "$key -> ".$value['RKAP'];
		      // }
		      // $export[$tag]=$arrayTemp;

	      }

	      // $arrayTemp = $domestik['smi'];
	       foreach ($opco as $key => $com) {
	      	// echo "$com -> $key";
	      // 	# code...
	      	 $resultDomestik = $this->m_salesvolume_smig->get_salesvolume_monthly($year, $month, $com);
		     // $resultExport = $this->m_salesvolume_smig->get_salesvolume_monthly($year, $month, $com);
		     

		      foreach ($resultDomestik as $key => $value) {
		      	# code...
		      	# 
		      	// $pieces = explode("-", $value['TANGGAL']);
		      	$arrayTemp[$value['TANGGAL']]['tanggal'] = $value['TANGGAL'];
		      	$arrayTemp[$value['TANGGAL']]['rkap'] += (float) $value['RKAP'];
		      	$arrayTemp[$value['TANGGAL']]['prognose'] += (float) $value['PROGNOSE'];
		      	$arrayTemp[$value['TANGGAL']]['realisasi'] += (float) $value['REAL'];
		      	// echo "$key -> ".$value['RKAP'];
		      }
		       $domestik[$tag]=$arrayTemp;

		      //semen
		      // foreach ($resultExport as $key => $value) {
		      // 	# code...
		      	
		      // 	// $pieces = explode("-", $value['TANGGAL']);

		      // 	$arrayTemp[$value['TANGGAL']]['tanggal'] = $value['TANGGAL'];
		      // 	$arrayTemp[$value['TANGGAL']]['rkap'] += (float) $value['RKAP'];
		      // 	$arrayTemp[$value['TANGGAL']]['prognose'] += (float) $value['PROGNOSE'];
		      // 	$arrayTemp[$value['TANGGAL']]['realisasi'] += (float) $value['REAL'];


		      // 	// echo "$key -> ".$value['RKAP'];
		      // }
		      // $export[$tag]=$arrayTemp;


		      // $json['domestik'] = $domestik;
		      // $json['export'] = $export;
	      }
	      $json['domestik'] = $domestik;
		  // $json['export'] = $export;
	      
	      return $json;
    }

}

/* End of file salesvolume_smig.php */
/* Location: ./application/controllers/salesvolume_smig.php */