<?php
header('Access-Control-Allow-Origin:*');
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi_daily_st extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->db=$this->load->database('default7',TRUE);
	}

	public function index()
	{
		$data=[];
		$bulan1 = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
	    $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
	    $hari = (empty($_GET['hari']) ? date('d') : $_GET['hari']);
	    $plant = (empty($_GET['plant']) ? 4301 : $_GET['plant']);
		$kode_produk= (empty($_GET['kode_produk']) ? 1 : $_GET['kode_produk']);
    	$bulan=$this->bulan($bulan1);
		$tahun_lalu=intval($tahun)-1;

		$tanggal_awal=$tahun.'-'.$bulan.'-01';
		$tanggal_sekarang=$tahun.'-'.$bulan.'-'.$hari;
		$tanggal_akhir=$tahun.'-'.$bulan.'-31';

		if($bulan1==date('m')){
			$tanggal_real=$this->db->query("SELECT
																			MAX(TANGGAL) AS TANGGAL
																		FROM
																			ZREPORT_REAL_PRODUK_ST
																		WHERE
																			YEAR = $tahun
																		AND MONTH = $bulan
																		AND ACTUAL_PRODUK <> 0
																		AND PLANT =$plant
																		AND KODE_PRODUK =1")->row();

				$tanggal_real1 = date('Y-m-d', strtotime('+1 day', strtotime($tanggal_real->TANGGAL)));
				$b="AND ZREPORT_RKAP_PRODUK_ST.TANGGAL BETWEEN '$tanggal_real1' AND '$tanggal_akhir'";
				$a="AND ZREPORT_RKAP_PRODUK_ST.TANGGAL BETWEEN '$tanggal_awal' AND '$tanggal_real->TANGGAL'";
		}else{
			$a="";
			$b="";
		}
		//total
		$RKAP=$this->db->query("SELECT
																YEAR,SUM (RKAP) AS RKAP
															FROM
																ZREPORT_RKAP_PRODUK_ST
															WHERE
																YEAR IN ($tahun,$tahun_lalu)
															AND MONTH = $bulan
															AND KODE_PRODUK = $kode_produk
															GROUP BY YEAR")->result();
		foreach ($RKAP as $row) {
			$data['s'.$row->YEAR][]=array('RKAP'=>$row->RKAP);
			}

		$REAL=$this->db->query("SELECT
															YEAR,SUM (ACTUAL_PRODUK) AS REALISASI
																FROM
																	ZREPORT_REAL_PRODUK_ST
																WHERE
																	YEAR IN ($tahun,$tahun_lalu)
																AND MONTH = $bulan
																AND KODE_PRODUK = $kode_produk
																GROUP BY YEAR")->result();
		foreach ($REAL as $row) {
				$data['s'.$row->YEAR][]=array('REAL'=>$row->REALISASI);
		}


		//chart
			$RKAP_CHART=$this->db->query("SELECT
																		TANGGAL,
																		SUM (RKAP) AS RKAP,
																		SUM (PROGONOSE_PRODUK) AS PROGNOSE
																	FROM
																		ZREPORT_RKAP_PRODUK_ST
																	WHERE
																		YEAR = $tahun
																	AND MONTH = $bulan
																	AND KODE_PRODUK = $kode_produk
																	GROUP BY TANGGAL
																	ORDER BY
																		TANGGAL ASC")->result();
		foreach ($RKAP_CHART as $row) {
			$REAL_CHART=$this->db->query("SELECT
																		SUM (ACTUAL_PRODUK) AS REALISASI
																	FROM
																		ZREPORT_REAL_PRODUK_ST
																	WHERE
																		YEAR = $tahun
																	AND MONTH = $bulan
																	AND KODE_PRODUK = $kode_produk
																	AND TANGGAL = '$row->TANGGAL'")->row();

		$data['CHART'][]=array('RKAP'=>$row->RKAP,'PROGNOSE'=>$row->PROGNOSE,'REAL'=>$REAL_CHART->REALISASI);

		}

		//plant
		$RKAP_PLANT=$this->db->query("SELECT
															PLANT,
															SUM (RKAP) AS RKAP,
															SUM (PROGONOSE_PRODUK) AS PROGNOSE
														FROM
															ZREPORT_RKAP_PRODUK_ST
														WHERE
															YEAR = $tahun
														AND MONTH = $bulan
														AND KODE_PRODUK = $kode_produk
														AND PLANT IN (4301,4302,4303)
														GROUP BY
															PLANT
														ORDER BY PLANT ASC")->result();
			foreach ($RKAP_PLANT as $row) {
				$REAL_PLANT=$this->db->query("SELECT
																			SUM (ACTUAL_PRODUK) AS REALISASI
																		FROM
																			ZREPORT_REAL_PRODUK_ST
																		WHERE
																			YEAR = $tahun
																		AND MONTH = $bulan
																		AND KODE_PRODUK = $kode_produk
																		AND PLANT=$row->PLANT")->row();
				if($bulan1==date('m')){$SISA_PROGNOSE=$row->PROGNOSE-$REAL_PLANT->REALISASI;}else{$SISA_PROGNOSE=0;}
				// $SISA_PROGNOSE=intval($row->PROGNOSE)-intval($REAL_PLANT->REALISASI);
				$SISA_HARI=$this->db->query("SELECT
																			SUM(HARI_OPERASI) AS SISA_HARI
																		FROM
																			ZREPORT_RKAP_PRODUK_ST
																		WHERE
																		KODE_PRODUK = $kode_produk
																		AND MONTH=$bulan
																		AND YEAR = $tahun
																		AND PLANT =$row->PLANT
																		AND PROGONOSE_PRODUK <> 0
																		$b")->row();

				// $KAPASITAS_SISA=intval($SISA_PROGNOSE)/intval($SISA_HARI->SISA_HARI);
				if($bulan1==date('m')){$KAPASITAS_SISA=$SISA_PROGNOSE/$SISA_HARI->SISA_HARI;}else{$KAPASITAS_SISA=0;}
				if($bulan1==date('m')){$SISA_HARI1=$SISA_HARI->SISA_HARI;}else{$SISA_HARI1=0;}
				//total hari operasi
				$plant=$row->PLANT;
				if ($plant==4301&&$kode_produk==1) {
					$work_center="'RK21','RK31'";
				}elseif ($plant==4302&&$kode_produk==1){
					$work_center="'RK41'";
				}elseif ($plant==4303&&$kode_produk==1){
					$work_center="'RK51'";
				}elseif ($plant==4301&&$kode_produk==2) {
					$work_center="'FM22','FM32'";
				}elseif ($plant==4302&&$kode_produk==2){
					$work_center="'F191','F201'";
				}elseif ($plant==4303&&$kode_produk==2){
					$work_center="'FM51','FM52'";
				}


				$HARI_OPERASI=$this->db->query("SELECT WORK_CENTER,SUM (HARI_OPERASI) AS HARI_OPERASI
																				FROM
																					ZREPORT_RKAP_PRODUK_ST
																				WHERE
																				KODE_PRODUK = $kode_produk
																				AND MONTH=$bulan
																				AND YEAR = $tahun
																				AND RKAP <> 0
																				AND WORK_CENTER IN ($work_center)
																				$a
																				GROUP BY WORK_CENTER")->result();


					foreach ($HARI_OPERASI as $row1) {
							$REAL_WORKCENTER=$this->db->query("SELECT
																						SUM (ACTUAL_PRODUK) AS REALISASI
																					FROM
																						ZREPORT_REAL_PRODUK_ST
																					WHERE
																						YEAR = $tahun
																					AND MONTH = $bulan
																					AND KODE_PRODUK = $kode_produk
																					AND WORK_CENTER='$row1->WORK_CENTER'")->row();
							$KAPASITAS_REAL=intval($REAL_WORKCENTER->REALISASI)/intval($row1->HARI_OPERASI);
							$data['HARI_OPERASI'][$row1->WORK_CENTER]=array('HARI_OPERASI'=>$row1->HARI_OPERASI,'KAPASITAS_REAL'=>$KAPASITAS_REAL);
					}

					$data['PLANT'][$row->PLANT]	=array('RKAP'=>$row->RKAP,'PROGNOSE'=>$row->PROGNOSE,'REAL'=>$REAL_PLANT->REALISASI,'SISA_PROGNOSE'=>$SISA_PROGNOSE,'SISA_HARI'=>$SISA_HARI1,'KAPASITAS_SISA_HARI'=>$KAPASITAS_SISA);
			}

		echo json_encode($data);
	}

	public function detail_plant()
	{
		$data=[];
		$data1=array();
		$real_upto=0;
		$rkap_total=0;
		$kapasitas_real_total=0;
		$prognose_total=0;
		$sisa_prognose_total=0;
		$kapasitas_sisah_hari_total=0;
		$sisa_hari_operasi_total=0;
		$bulan1 = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
		$tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
		$hari = (empty($_GET['hari']) ? date('d') : $_GET['hari']);
		$plant = (empty($_GET['plant']) ? 4301 : $_GET['plant']);
		$kode_produk= (empty($_GET['kode_produk']) ? 1 : $_GET['kode_produk']);
		$bulan=$this->bulan($bulan1);
		$tahun_lalu=intval($tahun)-1;

		$tanggal_awal=$tahun.'-'.$bulan1.'-01';
		$tanggal_sekarang=$tahun.'-'.$bulan1.'-'.$hari;
		$tanggal_akhir=$tahun.'-'.$bulan1.'-31';
		if($bulan1==date('m')){
			$tanggal_real=$this->db->query("SELECT
																			MAX(TANGGAL) AS TANGGAL
																		FROM
																			ZREPORT_REAL_PRODUK_ST
																		WHERE
																			YEAR = $tahun
																		AND MONTH = $bulan
																		AND ACTUAL_PRODUK <> 0
																		AND PLANT =$plant
																		AND KODE_PRODUK =$kode_produk")->row();
				$tanggal_real1 = date('Y-m-d', strtotime('+1 day', strtotime($tanggal_real->TANGGAL)));
				$b="AND ZREPORT_RKAP_PRODUK_ST.TANGGAL BETWEEN '$tanggal_real1' AND '$tanggal_akhir'";
				$a="AND ZREPORT_RKAP_PRODUK_ST.TANGGAL BETWEEN '$tanggal_awal' AND '$tanggal_real->TANGGAL'";
		}else{
			$a="";
			$b="";
		}


				if ($plant==4301&&$kode_produk==1) {
					$work_center="'RK21','RK31'";
				}elseif ($plant==4302&&$kode_produk==1){
					$work_center="'RK41'";
				}elseif ($plant==4303&&$kode_produk==1){
					$work_center="'RK51'";
				}elseif ($plant==4301&&$kode_produk==2) {
					$work_center="'FM22','FM32'";
				}elseif ($plant==4302&&$kode_produk==2){
					$work_center="'F191','F201'";
				}elseif ($plant==4303&&$kode_produk==2){
					$work_center="'FM51','FM52'";
				}


		$rkap=$this->db->query("SELECT
															ZREPORT_RKAP_PRODUK_ST.WORK_CENTER,
															SUM(ZREPORT_RKAP_PRODUK_ST.RKAP) AS RKAP,
															SUM(ZREPORT_RKAP_PRODUK_ST.PROGONOSE_PRODUK) AS PROGONOSE_PRODUK,
															SUM(ZREPORT_REAL_PRODUK_ST.ACTUAL_PRODUK) AS ACTUAL_PRODUK
														FROM
															ZREPORT_RKAP_PRODUK_ST
														INNER JOIN ZREPORT_REAL_PRODUK_ST ON ZREPORT_RKAP_PRODUK_ST.ORG = ZREPORT_REAL_PRODUK_ST.ORG
														AND ZREPORT_RKAP_PRODUK_ST.PLANT = ZREPORT_REAL_PRODUK_ST.PLANT
														AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK = ZREPORT_REAL_PRODUK_ST.KODE_PRODUK
														AND ZREPORT_RKAP_PRODUK_ST. YEAR = ZREPORT_REAL_PRODUK_ST. YEAR
														AND ZREPORT_RKAP_PRODUK_ST. MONTH = ZREPORT_REAL_PRODUK_ST. MONTH
														AND ZREPORT_RKAP_PRODUK_ST.TANGGAL = ZREPORT_REAL_PRODUK_ST.TANGGAL
														AND ZREPORT_RKAP_PRODUK_ST.WORK_CENTER = ZREPORT_REAL_PRODUK_ST.WORK_CENTER
														WHERE ZREPORT_RKAP_PRODUK_ST.YEAR=$tahun
														AND ZREPORT_RKAP_PRODUK_ST.MONTH=$bulan
														AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK=$kode_produk
														AND ZREPORT_RKAP_PRODUK_ST.WORK_CENTER IN ($work_center)
														GROUP BY ZREPORT_RKAP_PRODUK_ST.WORK_CENTER")->result();


		foreach ($rkap as $row) {
			$hari_operasi=$this->db->query("SELECT
																SUM(ZREPORT_RKAP_PRODUK_ST.HARI_OPERASI) AS HARI_OPERASI
															FROM
																ZREPORT_RKAP_PRODUK_ST
															INNER JOIN ZREPORT_REAL_PRODUK_ST ON ZREPORT_RKAP_PRODUK_ST.ORG = ZREPORT_REAL_PRODUK_ST.ORG
															AND ZREPORT_RKAP_PRODUK_ST.PLANT = ZREPORT_REAL_PRODUK_ST.PLANT
															AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK = ZREPORT_REAL_PRODUK_ST.KODE_PRODUK
															AND ZREPORT_RKAP_PRODUK_ST. YEAR = ZREPORT_REAL_PRODUK_ST. YEAR
															AND ZREPORT_RKAP_PRODUK_ST. MONTH = ZREPORT_REAL_PRODUK_ST. MONTH
															AND ZREPORT_RKAP_PRODUK_ST.TANGGAL = ZREPORT_REAL_PRODUK_ST.TANGGAL
															AND ZREPORT_RKAP_PRODUK_ST.WORK_CENTER = ZREPORT_REAL_PRODUK_ST.WORK_CENTER
															WHERE ZREPORT_RKAP_PRODUK_ST.YEAR=$tahun
															AND ZREPORT_RKAP_PRODUK_ST.MONTH=$bulan
															AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK=$kode_produk
															AND ZREPORT_RKAP_PRODUK_ST.WORK_CENTER ='$row->WORK_CENTER'
															$a")->row();
				$sisa_hari_operasi=$this->db->query("SELECT
																	SUM(ZREPORT_RKAP_PRODUK_ST.HARI_OPERASI) AS HARI_OPERASI
																FROM
																	ZREPORT_RKAP_PRODUK_ST
																INNER JOIN ZREPORT_REAL_PRODUK_ST ON ZREPORT_RKAP_PRODUK_ST.ORG = ZREPORT_REAL_PRODUK_ST.ORG
																AND ZREPORT_RKAP_PRODUK_ST.PLANT = ZREPORT_REAL_PRODUK_ST.PLANT
																AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK = ZREPORT_REAL_PRODUK_ST.KODE_PRODUK
																AND ZREPORT_RKAP_PRODUK_ST. YEAR = ZREPORT_REAL_PRODUK_ST. YEAR
																AND ZREPORT_RKAP_PRODUK_ST. MONTH = ZREPORT_REAL_PRODUK_ST. MONTH
																AND ZREPORT_RKAP_PRODUK_ST.TANGGAL = ZREPORT_REAL_PRODUK_ST.TANGGAL
																AND ZREPORT_RKAP_PRODUK_ST.WORK_CENTER = ZREPORT_REAL_PRODUK_ST.WORK_CENTER
																WHERE ZREPORT_RKAP_PRODUK_ST.YEAR=$tahun
																AND ZREPORT_RKAP_PRODUK_ST.MONTH=$bulan
																AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK=$kode_produk
																AND ZREPORT_RKAP_PRODUK_ST.WORK_CENTER ='$row->WORK_CENTER'
																AND ZREPORT_RKAP_PRODUK_ST.PROGONOSE_PRODUK <> 0
																$b")->row();

				if($row->ACTUAL_PRODUK==NULL){
					$ACTUAL_PRODUK=0;
				}else{
					$ACTUAL_PRODUK=$row->ACTUAL_PRODUK;
				}

				if($sisa_hari_operasi->HARI_OPERASI==NULL){
					$HARI_OPERASI=0;
				}else{
					$HARI_OPERASI=$sisa_hari_operasi->HARI_OPERASI;
				}

				$sisa_prognose=$row->PROGONOSE_PRODUK-$row->ACTUAL_PRODUK;
				$percent_rkap=(intval($row->PROGONOSE_PRODUK)/intval($row->RKAP))*100;
				$kapasitas_sisah_hari=$sisa_prognose/$sisa_hari_operasi->HARI_OPERASI;
				$kapasitas_real=$row->ACTUAL_PRODUK/$hari_operasi->HARI_OPERASI;
				$real_upto+=$ACTUAL_PRODUK;
				$rkap_total+=$row->RKAP;
				$kapasitas_real_total+=$kapasitas_real;
				$prognose_total+=$row->PROGONOSE_PRODUK;
				$sisa_prognose_total+=$sisa_prognose;
				$kapasitas_sisah_hari_total+=$kapasitas_sisah_hari;
				//$sisa_hari_operasi_total+=$sisa_hari_operasi->HARI_OPERASI;
				$data1=array($row->RKAP,$row->PROGONOSE_PRODUK,$row->ACTUAL_PRODUK,$sisa_prognose,$hari_operasi->HARI_OPERASI,$sisa_hari_operasi->HARI_OPERASI,$kapasitas_sisah_hari,$kapasitas_real);
				$dataRkap[]=$row->RKAP;
				$dataPrognose[]=$row->PROGONOSE_PRODUK;
				$dataPercentRkap[]=$percent_rkap;
				$dataReal[]=$row->ACTUAL_PRODUK;
				// $dataSisaPrognose[]=$sisa_prognose;
				if($bulan1==date('m')){$dataSisaPrognose[]=$sisa_prognose;}else{$dataSisaPrognose[]=0;}
				$dataHariOperasi[]=$hari_operasi->HARI_OPERASI;
				if($bulan1==date('m')){$dataSisaHariOperasi[]=$sisa_hari_operasi->HARI_OPERASI;}else{$dataSisaHariOperasi[]=0;}
				// $dataSisaHariOperasi[]=$sisa_hari_operasi->HARI_OPERASI;
				// $dataKapasitasSisaHari[]=$kapasitas_sisah_hari;
				if($bulan1==date('m')){$dataKapasitasSisaHari[]=$kapasitas_sisah_hari;}else{$dataKapasitasSisaHari[]=0;}
				$dataKapasitasReal[]=$kapasitas_real;
				
				
			}
		$hari_operasi_total=$real_upto/$kapasitas_real_total;
		$precentase_rkap=(intval($prognose_total)/intval($rkap_total))*100;
		
		$dataKapasitasReal[]=$kapasitas_real_total;
		if($bulan1==date('m')){
			
			$sisa_hari_operasi_total=$sisa_prognose_total/$kapasitas_sisah_hari_total;
			$kapasitas_sisah_hari_total1=$kapasitas_sisah_hari_total;
			$sisa_prognose_total1=$sisa_prognose_total;

		}else{
			$sisa_hari_operasi_total=0;
			$kapasitas_sisah_hari_total1=0;
			$sisa_prognose_total1=0;
		}
		$dataRkap[]=$rkap_total;
		$dataReal[]=$real_upto;
		$dataHariOperasi[]=$hari_operasi_total;
		$dataPrognose[]=$prognose_total;
		$dataPercentRkap[]=$precentase_rkap;
		$dataSisaPrognose[]=$sisa_prognose_total1;
		$dataKapasitasSisaHari[]=$kapasitas_sisah_hari_total1;
		$dataSisaHariOperasi[]=$sisa_hari_operasi_total;

		$data=array($dataRkap, $dataPrognose, $dataPercentRkap, $dataReal, $dataSisaPrognose, $dataHariOperasi, $dataSisaHariOperasi, $dataKapasitasReal,$dataKapasitasSisaHari);
		echo json_encode($data);
}


	public function bulan($bulan)
	{
		switch ($bulan) {
			case '01':
				$bln=1;
				break;
			case '02':
					$bln=2;
				break;
			case '03':
					$bln=3;
					break;
			case '04':
					$bln=4;
					break;
			case '05':
					$bln=5;
					break;
			case '06':
					$bln=6;
					break;
			case '07':
					$bln=7;
					break;
			case '08':
					$bln=8;
					break;
			case '09':
					$bln=9;
					break;
			default:
				$bln = $bulan;
				break;
		}

		return $bln;
	}

}

/* End of file rkap_produksi_st.php */
/* Location: ./application/controllers/rkap_produksi_st.php */
