<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Volproduksi_smi extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//$this->load->model('stokpp&gudang/m_volproduksi3000');
		//$this->load->model('stokpp&gudang/m_volproduksi4000');
		//$this->load->model('stokpp&gudang/m_volproduksi7000');
                $this->load->model('stokpp&gudang/m_volproduksismig');
	}

	/*public function index()
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

		//3000 padang
		$realisasi3000=$this->m_volproduksi3000->get_realisasi($tahun,$bulan,$hari,$date);
		$realisasi_h3000=$this->m_volproduksi3000->get_realisasi_h($tahun,$bulan,$hari,$date);
		$realisasilalu3000=$this->m_volproduksi3000->get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
		$realisasilalu13000=$this->m_volproduksi3000->get_realisasilalu1($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
		$ekspor3000=$this->m_volproduksi3000->get_ekspor($tahun,$bulan,$hari,$date);
		$eksporlalu3000=$this->m_volproduksi3000->get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu);


		//tahun sekarang
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
			$smi['real_eks']por_sm3000=$e->REAL_EKSPOR;
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
		//end 3000 padang
		

		//7000 gresik
      $realisasi7000=$this->m_volproduksi7000->get_realisasi($tahun,$bulan,$hari,$date);
      $realisasi_h7000=$this->m_volproduksi7000->get_realisasi_h($tahun,$bulan,$hari,$date);
      $realisasilalu7000=$this->m_volproduksi7000->get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
      $realisasi_l7000=$this->m_volproduksi7000->get_realisasi_l($tahunlalu,$bulan,$hari,$datelalu);
      $ekspor7000=$this->m_volproduksi7000->get_ekspor($tahun,$bulan,$hari,$date);
      $eksporlalu7000=$this->m_volproduksi7000->get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu);

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
    //end 7000 gresik


    //4000 tonasa
    	$realisasi4000=$this->m_volproduksi4000->get_realisasi($tahun,$bulan,$hari,$date);
		$realisasilalu4000=$this->m_volproduksi4000->get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu);
		$realisasi_l4000=$this->m_volproduksi4000->get_realisasi_l($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
		$realisasi_h4000=$this->m_volproduksi4000->get_realisasi_h($tahun,$bulan,$hari,$date);
		$prognose4000=$this->m_volproduksi4000->get_prognose($tahun,$bulan,$hari,$date);
		$prognoselalu4000=$this->m_volproduksi4000->get_prognoselalu($tahunlalu,$bulan,$hari,$datelalu);
		$ekspor4000=$this->m_volproduksi4000->get_ekspor($tahun,$bulan,$hari,$date);
		$eksporlalu4000=$this->m_volproduksi4000->get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu);


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

    //end 4000 tonasa
    //growth
        $dom_real=(($real7000-$reallalu7000)+($real3000-$reallalu3000)+($real4000-$real_l4000))*100/($reallalu7000+$reallalu3000+$real_l4000);
	$dom_prog=((($real7000+$prog7000)+($real3000+$prog3000)+($real4000+$prog4000))-($real_l7000+$reallalu13000+$reallalu4000))*100/($real_l7000+$reallalu13000+$reallalu4000);

 if(((($real_ekspor_sm7000+$real_ekspor_tr7000)+$real_ekspor_sm3000+($real_ekspor_sm4000+$real_ekspor_tr4000)))!=0){
	$ekspor_real=((($real_ekspor_sm7000+$real_ekspor_tr7000)+$real_ekspor_sm3000+($real_ekspor_sm4000+$real_ekspor_tr4000))-(($real_ekspor_smlalu7000+$real_ekspor_trlalu7000)+$real_ekspor_smlalu3000)+($real_ekspor_smlalu4000+$real_ekspor_trlalu4000))*100/(($real_ekspor_smlalu7000+$real_ekspor_trlalu7000)+$real_ekspor_smlalu3000+($real_ekspor_smlalu4000+$real_ekspor_trlalu4000));
	// if($ekspor_real1==-100){
		}else{
			$ekspor_real=0;
		}
		if($ekspor_real!=0){
	$growth_selisih=((($real3000+$real_ekspor_sm4000)+($real4000+($real_ekspor_sm4000+$real_ekspor_tr4000))+($real7000+($real_ekspor_sm7000+$real_ekspor_tr7000)))-(($reallalu3000+$real_ekspor_smlalu3000)+($real_l4000+($real_ekspor_smlalu4000+$real_ekspor_trlalu4000))+($reallalu7000+($real_ekspor_smlalu7000+$real_ekspor_trlalu7000))))*100/(($reallalu3000+$real_ekspor_smlalu3000)+($real_l4000+($real_ekspor_smlalu4000+$real_ekspor_trlalu4000))+($reallalu7000+($real_ekspor_smlalu7000+$real_ekspor_trlalu7000)));
	}else{
		$growth_selisih=$dom_real;
	}
	//json
	    $data['smi']['dom']=array('real_sdk'=>$real_sdk7000+$real_sdk3000+$real_sdk4000,
	              'rkap_sdk'=>$rkap_sdk7000+$rkap_sdk3000+$rkap_sdk4000,
	              'selisih'=>($real_sdk7000-$rkap_sdk7000)+($real_sdk3000-$rkap_sdk3000)+($real_sdk4000-$rkap_sdk4000)
	              

	      );
	    $data['ekspor']=array('real_sm'=>$real_ekspor_sm7000+$real_ekspor_sm3000+$real_ekspor_sm4000,
	              'real_tr'=>$real_ekspor_tr7000+$real_ekspor_trlalu4000,
	              'rkap_eks'=>$rkap_eks7000+$rkap_ekspor3000+$rkap_ekspor4000,
	              

	      );
	    $data['growth']=array('dom_real'=>$dom_real,
								'dom_prog'=>$dom_prog,
								'ekspor_real'=>$ekspor_real,
								'total'=>$growth_selisih

				);
	    echo json_encode($data);
	}

        */
        
        
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
         
    function index_old(){
          $bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
          $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
          
          if($bulan==date('m')&&$tahun==date('Y')){
	      $hari=date('d');
	      $harilalu = $this->tgl_akhir($tahun,$bulan);
	    }else{
	      $hari=$this->tgl_akhir($tahun,$bulan);
	      $harilalu = $hari;

	    }
          $date=$tahun.$bulan;
          $tahunlalu=$tahun-1;
          $datelalu=$tahunlalu.$bulan;
          $hariawal=$datelalu.'01';

          //tahun sekarang
          $result = $this->m_volproduksismig->get_data($tahun,$bulan,$hari);
          $real_dom = 0;
          $real_dom_sdh = 0;
          $real_exp = 0;
          $rkap_dom = 0;
          $rkap_exp = 0;
          $terak_ekpor = 0;
          $total_prog = 0;
          $real_dom_lastyear = 0;
          $real_dom_sdh_lastyear = 0;
          $real_exp_lastyear = 0;
          $terak_ekpor_lastyear = 0;
          $real_dom_sdk = 0;
          foreach ($result as $value){
              $real_dom = $real_dom + $value['DOMESTIK'];
              // $real_dom_sdh = $real_dom_sdh + $value['DOM_SDH'];
              $real_exp = $real_exp + $value['EKSPOR'];
              $rkap_dom = $rkap_dom + $value['RKAP_DOMESTIK'];
              $rkap_exp = $rkap_exp + $value['RKAP_EKSPOR'];
              $terak_ekpor = $terak_ekpor + $value['REAL_TERAK'];
          }
          // untuk mengurangi jika bulan selected sama dengan bulan ini
          $real_dom_sdk = $real_dom;
          $real_dom_sdh2 = $real_dom_sdh;
          // $real_dom_sdh -= $real_exp;

          if($bulan == date('m')&&$tahun==date('Y')){
              $pengurang = $this->m_volproduksismig->get_dom_pengurang($tahun,$bulan,$hari);
              foreach($pengurang as $value){
                  $real_dom_sdk = $real_dom_sdk - $value->TOTAL;
              }
          } 

          // tahun lalu
          // grouth itu sampai hari ini.
          $result2 = $this->m_volproduksismig->get_data($tahunlalu,$bulan,$hari);
          foreach ($result2 as $vl2){
                $real_dom_lastyear = $real_dom_lastyear + $vl2['DOMESTIK'];
              	// $real_dom_sdh_lastyear = $real_dom_sdh_lastyear + $vl2['DOM_SDH'];

                $real_exp_lastyear = $real_exp_lastyear + $vl2['EKSPOR'];
                $terak_ekpor_lastyear = $terak_ekpor_lastyear + $vl2['REAL_TERAK'];
          }
          

          // prognose setelah hari berjalan
          $r_prognose = $this->m_volproduksismig->get_unrun_prognose($tahun,$bulan,$hari);
          foreach ($r_prognose as $vlProg){
              $total_prog = $total_prog + $vlProg->TOTAL_PROGNOSE;
          }
          
          // grwoth domestik
          // $growth_domestik = (($real_dom - $real_dom_lastyear) / $real_dom_lastyear ) * 100;
          // $growth_domestik_pprog = ((($real_dom + $total_prog) - ($real_dom_lastyear))  / $real_dom_lastyear ) *100;
          $growth_domestik = 0;
          $growth_domestik_pprog = 0;


          // if ($real_dom_sdh_lastyear!=0) {
          // 	# code...
          // 	$growth_domestik = (($real_dom_sdh - $real_dom_sdh_lastyear) / $real_dom_sdh_lastyear ) * 100;
          // 	$growth_domestik_pprog = ((($real_dom_sdh + $total_prog - $real_dom_sdh_lastyear))  / $real_dom_sdh_lastyear ) *100;

          	
          // }
          // growth expor
          // if ($real_exp_lastyear == 0 ) {
          // 	# code...
          // $growth_ekspor = 0;
          	
          // }else{
          // 	$growth_ekspor = (($real_exp  - $real_exp_lastyear) / $real_exp_lastyear)  * 100;

          // }
          // growth total
          // $growth_total = 0;
          // if ($real_dom_sdh_lastyear!=0&&$real_exp_lastyear!=0) {
          // 	$growth_total = ((($real_dom_sdh + $real_exp) - ($real_dom_sdh_lastyear+$real_exp_lastyear) ) / ($real_dom_sdh_lastyear+$real_exp_lastyear) ) *100 ;
          // }
          
          // $growth_total = ((($real_dom + $real_exp) - ($real_dom_lastyear+$real_exp_lastyear) ) / ($real_dom_lastyear+$real_exp_lastyear) ) *100 ;
          $final['smi']=array(
            "dom"=>array(
            	"real_sdk"=>$real_dom_sdk,
            	"rkap_sdk"=>$rkap_dom,
            	"selisih"=>$real_dom-$rkap_dom)
             
          );
          $final['ekspor'] = array("real_sm"=>$real_exp,"real_tr"=>$terak_ekpor,"rkap_eks"=>$rkap_exp);
          $final["growth"] = $this->growth();
          //  $final["growth"] = array(
          // 		"dom_real"		=>$growth_domestik,
          // 		"dom_prog"		=>$growth_domestik_pprog,
          // 		"ekspor_real"	=>$growth_ekspor,
          // 		"total"			=>$growth_total
          // );
         echo json_encode($final);
      }

    function growth(){
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

        $result = $this->m_volproduksismig->salesVolumeSMI($param, $tanggal, $hari);
        $eksporSG = $this->m_volproduksismig->sumEksporSG($date);
        $eksporSP = $this->m_volproduksismig->sumEksporSP($date);
        $eksporST = $this->m_volproduksismig->sumEksporST($date);

        foreach ($result as $key => $value) {
        	# code...
        	$smi['real_sdh'] += $value['REAL_SDH'];
        	$smi['real_sdk'] += $value['REAL_SDK'];
        	$smi['rkap_sdk'] += $value['RKAP_SDK'];
        	$smi['real_sdh_lalu'] += $value['REAL_SDH_TAHUNLALU'];
        	$smi['real_lalu'] += $value['REAL_TAHUNLALU'];
        	$smi['real_eks'] += $value['REAL_EKSPOR_TAHUNINI'];
        	$smi['real_eks_lalu'] += $value['REAL_EKSPOR_TAHUNLALU'];
        	$smi['prognose'] += $value['PROGNOSE'];


        }

        $json = array();
        $json['tanggal'] = $tanggal;
        $smi['real_sdh'] -= $smi['real_eks'];

        // $smi['real_sdk'] -= ($eksporSG['real_ekspor']+$eksporSP['real_ekspor']+$eksporST['real_ekspor']);

        $dom['selisih'] = $smi['real_sdk'] - $smi['rkap_sdk'];
        $dom['rkap_sdk'] = $smi['rkap_sdk'];
        $dom['real_sdk'] = $smi['real_sdk'];
        $dom['persen'] = ($smi['real_sdk']/$smi['rkap_sdk'])*100;

        $growth['dom_real'] = 0;
        if ($smi['real_sdh_lalu']!=0) {
        	$growth['dom_real'] = round((($smi['real_sdh'] - $smi['real_sdh_lalu'])/$smi['real_sdh_lalu'])*100,2);
        	# code...
        }

        $growth['dom_prog'] = 0;
        if ($smi['real_lalu']!=0) {
        	$growth['dom_prog'] = round(((($smi['real_sdh'] + $smi['prognose']) - $smi['real_lalu'])/$smi['real_lalu'])*100, 2);
        	# code...
        }

        $growth['ekspor_real'] = 0;
        if ($smi['real_eks_lalu'] != 0) {
        	# code...
        	$growth['ekspor_real'] = round((($smi['real_eks']-$smi['real_eks_lalu'])/$smi['real_eks_lalu'])*100, 2);
        	
        }

       

        $growth['total'] = 0;
        
        if ($smi['real_eks_lalu']!=0 && $smi['real_lalu']!=0) {
        	# code...
        	$growth['total'] = round(((($smi['real_eks']+$smi['real_sdh'])-($smi['real_eks_lalu']+$smi['real_lalu']))/($smi['real_eks_lalu']+$smi['real_lalu']))*100, 2);

        }
        
       
        $json['test'] = $param;
        $json['smi'] = $smi;
        $json['growth'] = $growth;
        $json['dom'] = $dom;

        return $growth;
        // echo json_encode($json);
        // echo json_encode($result);
    }

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

        $dataSG = $this->m_volproduksismig->sumSalesOpco('7000', $date);
        $dataSP = $this->m_volproduksismig->sumSalesOpco('3000', $date);
        $dataST = $this->m_volproduksismig->sumSales4000_rev('4000', $date);

        // $result = $this->m_volproduksismig->salesVolumeSMI($param, $tanggal, $hari);
        $eksporSG = $this->m_volproduksismig->sumEksporSG($date);
        $eksporSP = $this->m_volproduksismig->sumEksporSP($date);
        $eksporST = $this->m_volproduksismig->sumEksporST($date);

        $dataSMI = array(
            'ORG'      => 0,
            "RKAP_SDK" =>  0,
            "REAL_SDK" =>  0,
            "REAL_SDH" =>  0,
            "REAL_TAHUNLALU" =>  0,
            "PROGNOSE" =>  0,
            "RKAP_EKSPOR" =>  0,
            "REAL_SM_EKSPOR" =>  0,
            "REAL_TR_EKSPOR" =>  0,
            "REAL_SDH_TAHUNLALU" =>  0,
            "REAL_EKSPOR_TAHUNINI" =>  0,
            "REAL_EKSPOR_TAHUNLALU" =>  0



          );



        foreach ($dataSG as $key => $value) {
            $dataSMI[$key] += floatval( $value );
        }

        foreach ($dataSP as $key => $value) {
            $dataSMI[$key] += floatval( $value );
        }
        foreach ($dataST as $key => $value) {
            $dataSMI[$key] += floatval( $value );
        }

        // echo json_encode($dataST);

        $sumEkspor = 0;
           $eksSP = 0;
        if (isset($eksporSP['REAL_EKSPOR'])) {
          # code...
          $eksSP = $eksporSP['REAL_EKSPOR'];
        }
                             
           $eksST = 0;
        if (isset($eksporST['REAL_EKSPOR'])) {
          # code...
          // $eksST = $eksporST['REAL_EKSPOR'];
        }
         
           $eksSG = 0;
        if (isset($eksporSG['REAL_EKSPOR'])) {
          # code...
          $eksSG = $eksporSG['REAL_EKSPOR'];
        }
         

        
        $sumEkspor = $eksSP + $eksSG + $eksST ;

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

        $json['smi']['dom'] = $dom;
        $json['ekspor'] = $eks;
        $json['growth'] = $gro;

        // echo json_encode($dataSG);

        echo json_encode($json);
        // echo json_encode($result);
    }

}

/* End of file volproduksi_smi.php */
/* Location: ./application/controllers/volproduksi_smi.php */