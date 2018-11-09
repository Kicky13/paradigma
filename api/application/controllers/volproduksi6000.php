<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class Volproduksi6000 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('stokpp&gudang/m_volproduksi6000');
		$this->load->model('stokpp&gudang/m_volproduksismig');
	}
	public function index_old()
	{

		//TLCC(6000)
		$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
		$tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
		if($bulan==date('m')){
			$hari=date('d');
		}else{
			$hari=$this->tgl_akhir($tahun,$bulan);
		}
		$tgl_akhir=$this->tgl_akhir($tahun,$bulan);
		$date=$tahun.$bulan;
		$tahunlalu=$tahun-1;
		$datelalu=$tahunlalu.$bulan;
		$hariawal=$datelalu.'01';

		$progrkap=$this->m_volproduksi6000->get_progrkap($tahun,$bulan,$hari,$date);
		$progrkaplalu=$this->m_volproduksi6000->get_progrkaplalu($tahunlalu,$bulan,$hari,$datelalu);
		$realisasi=$this->m_volproduksi6000->get_realisasi($tahun,$bulan,$hari,$date);
		$realisasilalu=$this->m_volproduksi6000->get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu,$hariawal);
		$realisasi_l=$this->m_volproduksi6000->get_realisasi_l($tahunlalu,$bulan,$hari,$datelalu);
		$realisasi_h=$this->m_volproduksi6000->get_realisasi_h($tahun,$bulan,$hari,$date);
		$ekspor=$this->m_volproduksi6000->get_ekspor($tahun,$bulan,$hari,$date);
		$eksporlalu=$this->m_volproduksi6000->get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu);

		//tahunlalu
		foreach ($progrkaplalu as $p) {
			$proglalu=$p->PROG;
			$rkaplalu=$p->RKAP;
		}
		$prog_hlalu=$rkaplalu/$tgl_akhir;
		$rkap_sdhlalu=($hari/$tgl_akhir)*$rkaplalu;
		if($bulan==date('m')){
		$rkap_sdklalu=$rkap_sdhlalu-$prog_hlalu;
	}else{
		$rkap_sdklalu=$rkap_sdhlalu;
	}
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
		$prog_h=$rkap/$tgl_akhir;
		$rkap_sdh=($hari/$tgl_akhir)*$rkap;
		if($bulan==date('m')){
		$rkap_sdk=$rkap_sdh-$prog_h;
	}else{
		$rkap_sdk=$rkap_sdh;
	}
		$real='';
		foreach ($realisasi as $r) {
			$real+=$r->REALISASI;
		}
		foreach ($realisasi_h as $r) {
			$real_h=$r->REALISASI;
		}
		if($bulan==date('m')){
		$real_sdk=$real-$real_h;
	}else{
		$real_sdk=$real;
	}
		foreach ($ekspor as $e) {
			$real_sm=$e->REAL_EKSPOR_SM;
			$real_tr=$e->REAL_EKSPOR_TR;
			$rkap_eks=$e->RKAP_EKSPOR;
		}


			$dom_real=($real-$reallalu)*100/$reallalu;
			$dom_prog=(($real+$prog)-$real_l)*100/$real_l;
			$ekspor_real1=(($real_sm+$real_tr)-($real_smlalu+$real_trlalu))*100/($real_smlalu+$real_trlalu);
			$growth_selisih=(($real+($real_sm+$real_tr))-($reallalu+($real_smlalu+$real_trlalu)))*100/($reallalu+($real_smlalu+$real_trlalu));
			if($ekspor_real1==-100){
				$ekspor_real=0;
			}
			else{
				$ekspor_real=$ekspor_real1;
			}
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
							'ekspor_real'=>$ekspor_real,
							'total'=>$growth_selisih

			);

		echo json_encode($data);


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

        $dataTL = $this->m_volproduksismig->sumSales6000New('6000', $date);

        // $result = $this->m_volproduksismig->salesVolumeSMI($param, $tanggal, $hari);
        // $eksporSP = $this->m_volproduksismig->sumEksporSP($date);

        $dataSMI = $dataTL;
      

        $sumEkspor = 0;
        // if (($eksporSG['REAL_EKSPOR']==&&$eksporSP['REAL_EKSPOR']==&&$eksporST['REAL_EKSPOR'])) {
        //  # code...
        // }
        // $sumEkspor = ($eksporSG['REAL_EKSPOR']+$eksporSP['REAL_EKSPOR']+$eksporST['REAL_EKSPOR']);
        $dataSMI['REAL_SDK'] = $dataSMI['REAL_TAHUNINI']-$dataSMI['REAL_HARIINI'];
        $dataSMI['REAL_SDH'] = $dataSMI['REAL_TAHUNINI'];

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

        $json['s6000']['dom'] = $dom;
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

/* End of file volproduksi.php */
/* Location: ./application/controllers/volproduksi.php */