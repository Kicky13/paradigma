<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Volproduksi7000 extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('stokpp&gudang/m_volproduksi7000');
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

    //growth
    $dom_real=($real7000-$reallalu7000)*100/$reallalu7000;
      $dom_prog=(($real7000+$prog7000)-$real_l7000)*100/$real_l7000;
      if($real_ekspor_trlalu7000!=0){
      $ekspor_real=(($real_ekspor_sm7000+$real_ekspor_tr7000)-($real_ekspor_smlalu7000+$real_ekspor_trlalu7000))*100/($real_ekspor_smlalu7000+$real_ekspor_trlalu7000);
    }else{
      $ekspor_real=0;
    }

    $growth_selisih=(($real7000+($real_ekspor_sm7000+$real_ekspor_tr7000))-($reallalu7000+($real_ekspor_smlalu7000+$real_ekspor_trlalu7000)))*100/($reallalu7000+($real_ekspor_smlalu7000+$real_ekspor_trlalu7000));

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
              'ekspor_real'=>$ekspor_real,
              'total'=>$growth_selisih

      );

    echo json_encode($data);
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

        // $result = $this->m_volproduksismig->salesVolumeSMI($param, $tanggal, $hari);
        $eksporSG = $this->m_volproduksismig->sumEksporSG($date);

        $dataSMI = $dataSG;
       

        $sumEkspor = 0;
        // if (($eksporSG['REAL_EKSPOR']==&&$eksporSP['REAL_EKSPOR']==&&$eksporST['REAL_EKSPOR'])) {
        //  # code...
        // }
        // $sumEkspor = ($eksporSG['REAL_EKSPOR']+$eksporSP['REAL_EKSPOR']+$eksporST['REAL_EKSPOR']);
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

        $json['s7000']['dom'] = $dom;
        $json['ekspor'] = $eks;
        $json['growth'] = $gro;
        echo json_encode($json);
        // echo json_encode($result);
    }

}

/* End of file volproduksi7000.php */
/* Location: ./application/controllers/volproduksi7000.php */