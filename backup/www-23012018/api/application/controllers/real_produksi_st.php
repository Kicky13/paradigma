<?php
header('Access-Control-Allow-Origin:*');
defined('BASEPATH') OR exit('No direct script access allowed');

class Real_produksi_st extends CI_Controller {

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
        $hari = (empty($_GET['hari']) ? date('Y') : $_GET['hari']);
        $plant = (empty($_GET['plant']) ? '4301,4302,4303' : $_GET['plant']);
        $kode_produk = (empty($_GET['kode_produk']) ? 1 : $_GET['kode_produk']);
        $bulan = $this->bulan($bulan1);
        $tanggal = $tahun.'-'.$bulan1.'-'.$hari;
        $tanggal1 = $tahun.'-'.$bulan1.'-01';
         $kode_produk = array(1,2);
        
        foreach ($kode_produk as $value) {
        	
        $sql=$this->db->query("SELECT
									ORG,
									KODE_PRODUK,
									YEAR,
									MONTH,
									SUM(ACTUAL_PRODUK) AS ACTUAL_PRODUK,
									SUM(KAPASITAS) AS KAPASITAS
								FROM
									ZREPORT_REAL_PRODUK_ST 
								WHERE
									ORG = 4000
								AND
									PLANT IN ($plant)
								AND
									KODE_PRODUK = '$value'
								AND
									YEAR = '$tahun'
								AND
									MONTH = '$bulan'
								AND TANGGAL = '$tanggal'
								GROUP BY
									ORG,KODE_PRODUK,YEAR,MONTH" 
								);
        $total_row=$this->db->query("SELECT PLANT,TANGGAL FROM ZREPORT_REAL_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND PLANT IN ($plant)
								AND MONTH = '$bulan'
								AND KODE_PRODUK = '$value'
								-- AND TANGGAL = '$tanggal'
								AND ACTUAL_PRODUK != 0
								GROUP BY TANGGAL,PLANT")->num_rows();
         $total_row1=$this->db->query("SELECT TANGGAL,PLANT FROM ZREPORT_REAL_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND PLANT IN ($plant)
								AND MONTH = '$bulan'
								AND KODE_PRODUK = '$value'
								AND ACTUAL_PRODUK != 0
								-- AND TANGGAL BETWEEN '$tanggal1' AND '$tanggal'
								GROUP BY TANGGAL,PLANT")->num_rows();
         $total_row2=$this->db->query("SELECT TANGGAL,PLANT FROM ZREPORT_REAL_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH BETWEEN 1 AND $bulan
								AND PLANT IN ($plant)
								AND KODE_PRODUK = '$value'
								AND ACTUAL_PRODUK != 0
								GROUP BY TANGGAL,PLANT")->num_rows();
       	$sql1 = $this->db->query("SELECT
									ORG,
									KODE_PRODUK,
									YEAR,
									-- MONTH,
									SUM(ACTUAL_PRODUK) AS ACTUAL_PRODUK,
									SUM(KAPASITAS) AS KAPASITAS
								FROM
									ZREPORT_REAL_PRODUK_ST 
								WHERE
									ORG = 4000
								AND
									PLANT IN ($plant)
								AND
									KODE_PRODUK = '$value'
								AND
									YEAR = '$tahun'
								AND
									MONTH = '$bulan'
								AND TANGGAL BETWEEN '$tanggal1' AND '$tanggal'
								GROUP BY
									ORG,KODE_PRODUK,YEAR" 
								);

       	 	$sql2 = $this->db->query("SELECT
									ORG,
									KODE_PRODUK,
									YEAR,
									-- MONTH,
									SUM(ACTUAL_PRODUK) AS ACTUAL_PRODUK,
									SUM(KAPASITAS) AS KAPASITAS
								FROM
									ZREPORT_REAL_PRODUK_ST 
								WHERE
									ORG = 4000
								AND
									PLANT IN ($plant)
								AND
									KODE_PRODUK = '$value'
								AND
									YEAR = '$tahun'
									AND MONTH BETWEEN 1 AND $bulan
								GROUP BY
									ORG,KODE_PRODUK,YEAR" 
								);


       	foreach ($sql->result_array() as $row) {
       		$data['month'][$row['KODE_PRODUK']]=array(
       							'ORG' =>	$row['ORG'],
								// 'PLANT' =>	$row['PLANT'],
								'KODE_PRODUK' =>	$row['KODE_PRODUK'],
								'YEAR' =>	$row['YEAR'],
								'MONTH' =>	$row['MONTH'],
								'ACTUAL_PRODUK' =>	$row['ACTUAL_PRODUK'],
								'KAPASITAS' =>	$row['KAPASITAS'],
								'HARI_OPERASI'=>$total_row
       			);
       	}
       	foreach ($sql1->result_array() as $row) {
       		$data['up_month'][$row['KODE_PRODUK']]=array(
       							'ORG' =>	$row['ORG'],
								// 'PLANT' =>	$row['PLANT'],
								'KODE_PRODUK' =>	$row['KODE_PRODUK'],
								'YEAR' =>	$row['YEAR'],
								'ACTUAL_PRODUK' =>	$row['ACTUAL_PRODUK'],
								'KAPASITAS' =>	$row['KAPASITAS'],
								'HARI_OPERASI'=>$total_row1
       			);
       	}

       	foreach ($sql2->result_array() as $row) {
       		$data['up_month2'][$row['KODE_PRODUK']]=array(
       							'ORG' =>	$row['ORG'],
								// 'PLANT' =>	$row['PLANT'],
								'KODE_PRODUK' =>	$row['KODE_PRODUK'],
								'YEAR' =>	$row['YEAR'],
								'ACTUAL_PRODUK' =>	$row['ACTUAL_PRODUK'],
								'KAPASITAS' =>	$row['KAPASITAS'],
								'HARI_OPERASI'=>$total_row2
       			);
       	}
       }

       	echo json_encode($data);
	}

	public function real_plant()
	{
		$data=[];
		$bulan1 = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $hari = (empty($_GET['hari']) ? date('Y') : $_GET['hari']);
        // $kode_produk = (empty($_GET['kode_produk']) ? 1 : $_GET['kode_produk']);
        $bulan = $this->bulan($bulan1);
        $tanggal = $tahun.'-'.$bulan1.'-'.$hari;
        $tanggal1 = $tahun.'-'.$bulan1.'-01';
        $plant=array('4301','4302','4303');
        $kode_produk1=array(1,2);
        foreach ($kode_produk1 as $kode_produk) {
        foreach ($plant as $value) {
     		 $sql=$this->db->query("SELECT
									ORG,
									PLANT,
									KODE_PRODUK,
									YEAR,
									MONTH,
									SUM(ACTUAL_PRODUK) AS ACTUAL_PRODUK,
									SUM(KAPASITAS) AS KAPASITAS
								FROM
									ZREPORT_REAL_PRODUK_ST 
								WHERE
									ORG = 4000
								AND
									PLANT = '$value'
								AND
									KODE_PRODUK = '$kode_produk'
								AND
									YEAR = '$tahun'
								AND
									MONTH = '$bulan'
								-- AND TANGGAL = '$tanggal'
								GROUP BY
									ORG,PLANT,KODE_PRODUK,YEAR,MONTH" 
								);
       	$sql1 = $this->db->query("SELECT
									ORG,
									PLANT,
									KODE_PRODUK,
									YEAR,
									MONTH,
									SUM(ACTUAL_PRODUK) AS ACTUAL_PRODUK,
									SUM(KAPASITAS) AS KAPASITAS
								FROM
									ZREPORT_REAL_PRODUK_ST 
								WHERE
									ORG = 4000
								AND
									PLANT = '$value'
								AND
									KODE_PRODUK = '$kode_produk'
								AND
									YEAR = '$tahun'
								AND
									MONTH = '$bulan'
								-- AND TANGGAL BETWEEN '$tanggal1' AND '$tanggal'
								GROUP BY
									ORG,PLANT,KODE_PRODUK,YEAR,MONTH" 
								);
       		$sql2 = $this->db->query("SELECT
									ORG,
									PLANT,
									KODE_PRODUK,
									YEAR,
									-- MONTH,
									SUM(ACTUAL_PRODUK) AS ACTUAL_PRODUK,
									SUM(KAPASITAS) AS KAPASITAS
								FROM
									ZREPORT_REAL_PRODUK_ST 
								WHERE
									ORG = 4000
								AND
									PLANT = '$value'
								AND
									KODE_PRODUK = '$kode_produk'
								AND
									YEAR = '$tahun'
								AND MONTH BETWEEN '$bulan1' AND '$bulan'
								GROUP BY
									ORG,PLANT,KODE_PRODUK,YEAR" 
								);
       	$total_row=$this->db->query("SELECT TANGGAL FROM ZREPORT_REAL_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND PLANT = '$value'
								AND MONTH = '$bulan'
								-- AND TANGGAL = '$tanggal'
								AND KODE_PRODUK = '$kode_produk'
								AND ACTUAL_PRODUK != 0")->num_rows();
         $total_row1=$this->db->query("SELECT TANGGAL FROM ZREPORT_REAL_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND PLANT = '$value'
								AND MONTH = '$bulan'
								-- AND TANGGAL BETWEEN '$tanggal1' AND  '$tanggal'
								AND KODE_PRODUK = '$kode_produk'
								AND ACTUAL_PRODUK != 0")->num_rows();
         $total_row2=$this->db->query("SELECT TANGGAL FROM ZREPORT_REAL_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH BETWEEN '$bulan1' AND '$bulan'
								AND PLANT = '$value'
								AND KODE_PRODUK = '$kode_produk'
								AND ACTUAL_PRODUK != 0")->num_rows();
       	foreach ($sql->result_array() as $row) {
       		$data['month'][$row['KODE_PRODUK']][$row['PLANT']]=array(
       							'ORG' =>	$row['ORG'],
								'PLANT' =>	$row['PLANT'],
								'KODE_PRODUK' =>	$row['KODE_PRODUK'],
								'YEAR' =>	$row['YEAR'],
								'MONTH' =>	$row['MONTH'],
								'ACTUAL_PRODUK' =>	$row['ACTUAL_PRODUK'],
								'KAPASITAS' =>	$row['KAPASITAS'],
								'HARI_OPERASI' =>	$total_row
       			);
       	}
       	foreach ($sql1->result_array() as $row) {
       		$data['up_month'][$row['KODE_PRODUK']][$row['PLANT']]=array(
       							'ORG' =>	$row['ORG'],
								'PLANT' =>	$row['PLANT'],
								'KODE_PRODUK' =>	$row['KODE_PRODUK'],
								'YEAR' =>	$row['YEAR'],
								'ACTUAL_PRODUK' =>	$row['ACTUAL_PRODUK'],
								'KAPASITAS' =>	$row['KAPASITAS'],
								'HARI_OPERASI' =>	$total_row1
       			);   		
        }

        foreach ($sql2->result_array() as $row) {
       		$data['up_month2'][$row['KODE_PRODUK']][$row['PLANT']]=array(
       							'ORG' =>	$row['ORG'],
								'PLANT' =>	$row['PLANT'],
								'KODE_PRODUK' =>	$row['KODE_PRODUK'],
								'YEAR' =>	$row['YEAR'],
								'ACTUAL_PRODUK' =>	$row['ACTUAL_PRODUK'],
								'KAPASITAS' =>	$row['KAPASITAS'],
								'HARI_OPERASI' =>	$total_row2
       			);   		
        }
	}
}
	echo json_encode($data);
}


	public function bulan($bulan)
	{
		switch ($bulan) {
			case '01':
				$bulan1=1;
			break;
			case '02':
				$bulan1=2;
			break;
			case '03':
				$bulan1=3;
			break;
			case '04':
				$bulan1=4;
			break;
			case '05':
				$bulan1=5;
			break;
			case '06':
				$bulan1=6;
			break;
			case '07':
				$bulan1=7;
			break;
			case '08':
				$bulan1=8;
			break;
			case '09':
				$bulan1=9;
			break;
			default:
				$bulan1=$bulan;
				break;
		}
	return $bulan1;
	}

	public function detail()
	{
		$data=[];
		$bulan1 = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $plant = (empty($_GET['plant']) ? '4301,4302,4303' : $_GET['plant']);
        // $kode_produk = (empty($_GET['kode_produk']) ? 1 : $_GET['kode_produk']);
        $bulan = $this->bulan($bulan1);

         $hari = (empty($_GET['hari']) ? date('Y') : $_GET['hari']);
         $tanggal = $tahun.'-'.$bulan1.'-'.$hari;
        $kode_produk1=array(1,2);
        foreach ($kode_produk1 as $kode_produk) {
        $sql=$this->db->query("SELECT
								ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK,
								ZREPORT_RKAP_PRODUK_ST.TANGGAL,
								SUM(ZREPORT_RKAP_PRODUK_ST.RKAP) RKAP,
								SUM(ZREPORT_RKAP_PRODUK_ST.PROGONOSE_PRODUK) PROGONOSE_PRODUK,
								SUM(ZREPORT_REAL_PRODUK_ST.ACTUAL_PRODUK) ACTUAL_PRODUK
								FROM
								ZREPORT_RKAP_PRODUK_ST
								INNER JOIN ZREPORT_REAL_PRODUK_ST ON ZREPORT_RKAP_PRODUK_ST.ORG = ZREPORT_REAL_PRODUK_ST.ORG AND ZREPORT_RKAP_PRODUK_ST.PLANT = ZREPORT_REAL_PRODUK_ST.PLANT AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK = ZREPORT_REAL_PRODUK_ST.KODE_PRODUK AND ZREPORT_RKAP_PRODUK_ST.YEAR = ZREPORT_REAL_PRODUK_ST.YEAR AND ZREPORT_RKAP_PRODUK_ST.MONTH = ZREPORT_REAL_PRODUK_ST.MONTH AND ZREPORT_RKAP_PRODUK_ST.TANGGAL = ZREPORT_REAL_PRODUK_ST.TANGGAL
								WHERE ZREPORT_RKAP_PRODUK_ST.ORG = 4000
								AND ZREPORT_RKAP_PRODUK_ST.PLANT IN ($plant)
								AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK = '$kode_produk'
								AND ZREPORT_RKAP_PRODUK_ST.YEAR = '$tahun'
								AND ZREPORT_RKAP_PRODUK_ST.MONTH = '$bulan'
								GROUP BY ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK, ZREPORT_RKAP_PRODUK_ST.TANGGAL 
								ORDER BY ZREPORT_RKAP_PRODUK_ST.TANGGAL
								        	");
											
        foreach ($sql->result_array() as $row) {
			$total_row=$this->db->query("SELECT TANGGAL FROM ZREPORT_REAL_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND PLANT IN ($plant)
								AND MONTH = '$bulan'
								AND TANGGAL = '".$row['TANGGAL']."'
								AND KODE_PRODUK = '$kode_produk'
								AND ACTUAL_PRODUK != 0")->num_rows();
        	$data[$row['KODE_PRODUK']][]=array(
					'RKAP' =>	$row['RKAP'],
					'PROGONOSE_PRODUK' =>	$row['PROGONOSE_PRODUK'],
					'HARI_OPERASI' =>	$total_row,
					'ACTUAL_PRODUK' =>	$row['ACTUAL_PRODUK']
        		);
        }
    }
		
        echo json_encode($data);
	}

	public function detail_up()
	{
		$data=[];
		// $bulan1 = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $plant = (empty($_GET['plant']) ? '4301' : $_GET['plant']);
        $bulan = $this->bulan($bulan1);
        $kode_produk1=array(1,2);
        foreach ($kode_produk1 as $kode_produk) {
        	# code...
        }
        $sql=$this->db->query("
        						SELECT
								ZREPORT_RKAP_PRODUK_ST.ORG,
								ZREPORT_RKAP_PRODUK_ST.TANGGAL,
								ZREPORT_RKAP_PRODUK_ST.PLANT,
								ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK,
								ZREPORT_RKAP_PRODUK_ST.YEAR,
								ZREPORT_RKAP_PRODUK_ST.MONTH,
								ZREPORT_RKAP_PRODUK_ST.RKAP,
								ZREPORT_RKAP_PRODUK_ST.PROGONOSE_PRODUK,
								ZREPORT_RKAP_PRODUK_ST.JAM_OPERASI,
								ZREPORT_REAL_PRODUK_ST.ACTUAL_PRODUK
								FROM
								ZREPORT_RKAP_PRODUK_ST
								INNER JOIN ZREPORT_REAL_PRODUK_ST ON ZREPORT_RKAP_PRODUK_ST.ORG = ZREPORT_REAL_PRODUK_ST.ORG AND ZREPORT_RKAP_PRODUK_ST.PLANT = ZREPORT_REAL_PRODUK_ST.PLANT AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK = ZREPORT_REAL_PRODUK_ST.KODE_PRODUK AND ZREPORT_RKAP_PRODUK_ST.YEAR = ZREPORT_REAL_PRODUK_ST.YEAR AND ZREPORT_RKAP_PRODUK_ST.MONTH = ZREPORT_REAL_PRODUK_ST.MONTH AND ZREPORT_RKAP_PRODUK_ST.TANGGAL = ZREPORT_REAL_PRODUK_ST.TANGGAL
								WHERE ZREPORT_RKAP_PRODUK_ST.ORG = 4000
								AND ZREPORT_RKAP_PRODUK_ST.PLANT = '$plant'
								AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK = '$kode_produk'
								AND ZREPORT_RKAP_PRODUK_ST.YEAR = '$tahun'
								-- AND ZREPORT_RKAP_PRODUK_ST.MONTH = '$bulan'
								ORDER BY ZREPORT_RKAP_PRODUK_ST.TANGGAL
								        	");
        foreach ($sql->result_array() as $row) {
        	$data[$row['KODE_PRODUK']][]=array(
					'ORG' => $row['ORG'],
					'TANGGAL' => $row['TANGGAL'],
					'PLANT' =>	$row['PLANT'],
					'KODE_PRODUK' =>	$row['KODE_PRODUK'],
					'YEAR' =>	$row['YEAR'],
					'MONTH' =>	$row['MONTH'],
					'RKAP' =>	$row['RKAP'],
					'PROGONOSE_PRODUK' =>	$row['PROGONOSE_PRODUK'],
					'JAM_OPERASI' =>	$row['JAM_OPERASI'],
					'ACTUAL_PRODUK' =>	$row['ACTUAL_PRODUK']
        		);
        }

        echo json_encode($data);
	}


	// public function detail_plant()
	// {

	// 	$data=[];
	// 	$bulan1 = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
 //        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
 //        $plant = (empty($_GET['plant']) ? '4301' : $_GET['plant']);
 //        $bulan = $this->bulan($bulan1);

 //        $hari = (empty($_GET['hari']) ? date('Y') : $_GET['hari']);
 //        $tanggal = $tahun.'-'.$bulan1.'-'.$hari;

	// 	$kode_produk1=array(1,2);
 //        foreach ($kode_produk1 as $kode_produk) {
 //        	if($kode_produk==1){
 //        		if($plant=='4301'){
	// 				$work_center1=array('RK21','RK31');
	// 			}elseif($plant=='4302'){
	// 				$work_center1=array('RK41');
	// 			}elseif ($plant) {
	// 				$work_center1=array('RK51');
	// 			}
 //        	}else{
 //        		if($plant=='4301'){
	// 				$work_center1=array('FM22','FM32');
	// 			}elseif($plant=='4302'){
	// 				$work_center1=array('F191','F201');
	// 			}elseif ($plant) {
	// 				$work_center1=array('FM51','FM52');
	// 			}
 //        	}

 //        	foreach ($work_center1 as $work_center) {
 //        	$sql=$this->db->query("
 // 							SELECT
	// 								ZREPORT_RKAP_PRODUK_ST.ORG,
	// 								ZREPORT_RKAP_PRODUK_ST.PLANT,
	// 								ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK,
	// 								ZREPORT_RKAP_PRODUK_ST.YEAR,
	// 								ZREPORT_RKAP_PRODUK_ST.MONTH,
	// 								ZREPORT_RKAP_PRODUK_ST.RKAP,
	// 								ZREPORT_RKAP_PRODUK_ST.PROGONOSE_PRODUK,
	// 								ZREPORT_RKAP_PRODUK_ST.PRONGNOSE_STOCK,
	// 								ZREPORT_RKAP_PRODUK_ST.TANGGAL,
	// 								ZREPORT_RKAP_PRODUK_ST.WORK_CENTER,
	// 								ZREPORT_RKAP_PRODUK_ST.HARI_OPERASI,
	// 								ZREPORT_REAL_PRODUK_ST.ACTUAL_PRODUK
	// 								FROM
	// 								ZREPORT_RKAP_PRODUK_ST
	// 								INNER JOIN ZREPORT_REAL_PRODUK_ST ON ZREPORT_RKAP_PRODUK_ST.TANGGAL = ZREPORT_REAL_PRODUK_ST.TANGGAL
	// 								WHERE
	// 								ZREPORT_RKAP_PRODUK_ST.PLANT = '$plant'
	// 								AND
	// 								ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK = '$kode_produk'
	// 								AND
	// 								ZREPORT_RKAP_PRODUK_ST.YEAR = '$tahun'
	// 								AND
	// 								ZREPORT_RKAP_PRODUK_ST.MONTH = '$bulan'
	// 								AND 
	// 								ZREPORT_RKAP_PRODUK_ST.WORK_CENTER = '$work_center'
	// 								g

	// 		");
	// 		$a=1;


											
 //        foreach ($sql->result_array() as $row) {

 //        	$data[$row['KODE_PRODUK']][$row['WORK_CENTER']][$a++]=array(
 //        			'tanggal'=>$row['TANGGAL'],
	// 				'RKAP' =>	$row['RKAP'],
	// 				'PROGONOSE_PRODUK' =>	$row['PROGONOSE_PRODUK'],
	// 				// 'HARI_OPERASI' =>	$total_row,
	// 				'ACTUAL_PRODUK' =>	$row['ACTUAL_PRODUK']
 //        		);
 //        }
 //    }
 //    }
		
 //        echo json_encode($data);
	// }

	// public function detail_plant()
	// {

	// 	$data=[];
	// 	$bulan1 = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
 //        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
 //        $plant = (empty($_GET['plant']) ? '4301' : $_GET['plant']);
 //        $bulan = $this->bulan($bulan1);

 //        $jumlah_tanggal=cal_days_in_month(CAL_GREGORIAN,$bulan, $tahun);
 //        $tanggal = $tahun.'-'.$bulan1.'-'.date('d');
 //        $tanggal_akhir=$tahun.'-'.$bulan1.'-'.$jumlah_tanggal;

 //        	// $a=1;
	// 	// $kode_produk=(empty($_GET['produk']) ? 1 : $_GET['produk']);
	// 	$kode_produk1=array(1,2);
	// 	foreach ($kode_produk1 as $kode_produk) {
 //        	if($kode_produk==1){
 //        		if($plant=='4301'){
	// 				$work_center1=array('RK21','RK31');
	// 			}elseif($plant=='4302'){
	// 				$work_center1=array('RK41');
	// 			}elseif ($plant) {
	// 				$work_center1=array('RK51');
	// 			}
 //        	}else{
 //        		if($plant=='4301'){
	// 				$work_center1=array('FM22','FM32');
	// 			}elseif($plant=='4302'){
	// 				$work_center1=array('F191','F201');
	// 			}elseif ($plant) {
	// 				$work_center1=array('FM51','FM52');
	// 			}
 //        	}
 //        foreach ($work_center1 as $work_center) {


 //        	 $sql=$this->db->query("SELECT
	// 							ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK,
	// 							ZREPORT_RKAP_PRODUK_ST.TANGGAL,
	// 							ZREPORT_RKAP_PRODUK_ST.WORK_CENTER,
	// 							SUM(ZREPORT_RKAP_PRODUK_ST.RKAP) RKAP,
	// 							SUM(ZREPORT_RKAP_PRODUK_ST.PROGONOSE_PRODUK) PROGONOSE_PRODUK,
	// 							SUM(ZREPORT_REAL_PRODUK_ST.ACTUAL_PRODUK) ACTUAL_PRODUK,
	// 							ZREPORT_RKAP_PRODUK_ST.HARI_OPERASI
	// 							FROM
	// 							ZREPORT_RKAP_PRODUK_ST
	// 							INNER JOIN ZREPORT_REAL_PRODUK_ST ON ZREPORT_RKAP_PRODUK_ST.ORG = ZREPORT_REAL_PRODUK_ST.ORG AND ZREPORT_RKAP_PRODUK_ST.PLANT = ZREPORT_REAL_PRODUK_ST.PLANT AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK = ZREPORT_REAL_PRODUK_ST.KODE_PRODUK AND ZREPORT_RKAP_PRODUK_ST.YEAR = ZREPORT_REAL_PRODUK_ST.YEAR AND ZREPORT_RKAP_PRODUK_ST.MONTH = ZREPORT_REAL_PRODUK_ST.MONTH AND ZREPORT_RKAP_PRODUK_ST.TANGGAL = ZREPORT_REAL_PRODUK_ST.TANGGAL
	// 							WHERE ZREPORT_RKAP_PRODUK_ST.ORG = 4000
	// 							AND ZREPORT_RKAP_PRODUK_ST.PLANT IN ($plant)
	// 							AND ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK = '$kode_produk'
	// 							AND ZREPORT_RKAP_PRODUK_ST.YEAR = '$tahun'
	// 							AND ZREPORT_RKAP_PRODUK_ST.MONTH = '$bulan'
	// 							AND ZREPORT_RKAP_PRODUK_ST.WORK_CENTER = '$work_center'
	// 							GROUP BY ZREPORT_RKAP_PRODUK_ST.KODE_PRODUK, ZREPORT_RKAP_PRODUK_ST.TANGGAL,ZREPORT_RKAP_PRODUK_ST.WORK_CENTER,ZREPORT_RKAP_PRODUK_ST.HARI_OPERASI
	// 							ORDER BY ZREPORT_RKAP_PRODUK_ST.TANGGAL");
 //        $sisa_hari=$this->db->query("
 //        							SELECT
	// 									SUM(HARI_OPERASI) AS SISA_HARI
	// 								FROM
	// 									ZREPORT_RKAP_PRODUK_ST
	// 								WHERE
	// 									TANGGAL BETWEEN '$tanggal'
	// 								AND '$tanggal_akhir'
	// 								AND PROGONOSE_PRODUK <> 0
	// 								AND PLANT = '$plant'
	// 								AND KODE_PRODUK = $kode_produk
	// 								AND WORK_CENTER = '$work_center'
 //        							")->row();
	// 	$data1=array();
	// 	$RKAP=0;		
	// 	$PROGONOSE_PRODUK=0;		
	// 	$ACTUAL_PRODUK=0;		
	// 	$HARI_OPERASI=0;		
 //        foreach ($sql->result_array() as $row) {
	// 		// $total_row=$this->db->query("SELECT TANGGAL FROM ZREPORT_REAL_PRODUK_ST
	// 		// 				WHERE
	// 		// 					ORG = 4000
	// 		// 					AND YEAR = '$tahun'
	// 		// 					AND PLANT IN ($plant)
	// 		// 					AND MONTH = '$bulan'
	// 		// 					AND TANGGAL = '".$row['TANGGAL']."'
	// 		// 					AND KODE_PRODUK = '$kode_produk'
	// 		// 					AND ACTUAL_PRODUK != 0")->num_rows();
	// 		$RKAP += $row['RKAP'];
	// 		$PROGONOSE_PRODUK += $row['PROGONOSE_PRODUK'];
	// 		$ACTUAL_PRODUK += $row['ACTUAL_PRODUK'];
	// 		$HARI_OPERASI+=$row['HARI_OPERASI'];
	// 		$SISA_HARI=$sisa_hari->SISA_HARI;
	// 		$data1[]=array(
	// 				'RKAP' =>	$row['RKAP'],
	// 				'PROGONOSE_PRODUK' =>	$row['PROGONOSE_PRODUK'],
					
	// 				'ACTUAL_PRODUK' =>	$row['ACTUAL_PRODUK']
 //        		);
        	
 //        }
 //        $data[$row['KODE_PRODUK']][]=array('nama_pabrik'=>$row['WORK_CENTER'],'RKAP'=>$RKAP,'PROGONOSE_PRODUK'=>$PROGONOSE_PRODUK,'ACTUAL_PRODUK'=>$ACTUAL_PRODUK,'HARI_OPERASI'=>$HARI_OPERASI,'SISA_HARI'=>$SISA_HARI,'data'=>$data1);

	// 	}
	// }

	// 	echo json_encode($data);
	// }

	public function detail_plant()
	{
		
		$data=[];
		$bulan1 = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $plant = (empty($_GET['plant']) ? '4301' : $_GET['plant']);
        $bulan = $this->bulan($bulan1);

        $jumlah_tanggal=cal_days_in_month(CAL_GREGORIAN,$bulan, $tahun);
        $tanggal = $tahun.'-'.$bulan1.'-'.date('d');
        $tanggal_akhir=$tahun.'-'.$bulan1.'-'.$jumlah_tanggal;
        $tanggal_akhir1=$tahun.'-'.$bulan1.'-27';

		$ACTUAL_PRODUK=0;
		$PROGONOSE_PRODUK=0;
		$RKAP=0;
		$HARI_OPERASI=0;

		$kode_produk1=array(1,2);
		foreach ($kode_produk1 as $kode_produk) {
        	if($kode_produk==1){
        		if($plant=='4301'){
					$work_center1=array('RK21','RK31');
				}elseif($plant=='4302'){
					$work_center1=array('RK41');
				}elseif ($plant) {
					$work_center1=array('RK51');
				}
        	}else{
        		if($plant=='4301'){
					$work_center1=array('FM22','FM32');
				}elseif($plant=='4302'){
					$work_center1=array('F191','F201');
				}elseif ($plant) {
					$work_center1=array('FM51','FM52');
				}
        	}
        foreach ($work_center1 as $work_center) {

		$rkap=$this->db->query("SELECT
									ORG,
									PLANT,
									KODE_PRODUK,
									YEAR,
									MONTH,
									RKAP,
									PROGONOSE_PRODUK,
									TANGGAL,
									WORK_CENTER,
									HARI_OPERASI
								FROM
									ZREPORT_RKAP_PRODUK_ST
								WHERE PLANT = '$plant'
								AND KODE_PRODUK = $kode_produk
								AND YEAR = '$tahun'
								AND MONTH = $bulan
								AND WORK_CENTER = '$work_center'
								");
		$sum_rkap=$this->db->query("SELECT
									-- ORG,
									-- PLANT,
									-- KODE_PRODUK,
									-- YEAR,
									-- MONTH,
									SUM(RKAP) AS RKAP,
									SUM(PROGONOSE_PRODUK) AS PROGONOSE_PRODUK,
									-- TANGGAL,
									-- WORK_CENTER,
									SUM(HARI_OPERASI) AS HARI_OPERASI
								FROM
									ZREPORT_RKAP_PRODUK_ST
									WHERE PLANT = '$plant'
									AND KODE_PRODUK = $kode_produk
									AND YEAR = '$tahun'
									AND MONTH = $bulan
									AND WORK_CENTER = '$work_center'")->row();
		$sum_real=$this->db->query("SELECT
										SUM(ACTUAL_PRODUK) AS ACTUAL_PRODUK
									FROM
										ZREPORT_REAL_PRODUK_ST
									WHERE 

										WORK_CENTER = '$work_center'
										AND PLANT = '$plant'
										AND KODE_PRODUK = '$kode_produk'
										AND MONTH = '$bulan'
										AND YEAR = '$tahun'
									")->row();
		$data1=array();
		foreach ($rkap->result_array() as $row) {
			$real=$this->db->query("SELECT
										ACTUAL_PRODUK
									FROM
										ZREPORT_REAL_PRODUK_ST
									WHERE 
										KODE_PRODUK = '$kode_produk'
										AND WORK_CENTER = '$work_center'
										AND TANGGAL = '".$row['TANGGAL']."'
									")->row();
			
			
			$data1[]=array(
					'RKAP' => $row['RKAP'],
					'PROGONOSE_PRODUK' => $row['PROGONOSE_PRODUK'],
					'ACTUAL_PRODUK' => $real->ACTUAL_PRODUK
        		);
			
		}


		$sisa_hari=$this->db->query("

        							SELECT
										SUM(HARI_OPERASI) AS SISA_HARI
									FROM
										ZREPORT_RKAP_PRODUK_ST
									WHERE
										TANGGAL BETWEEN '$tanggal'
									AND '$tanggal_akhir'
									AND PROGONOSE_PRODUK <> 0
									AND PLANT = '$plant'
									AND KODE_PRODUK = '$kode_produk'
									AND WORK_CENTER = '$work_center'
        							")->row();
		$hari_operasi=$this->db->query("

        							SELECT
										SUM(HARI_OPERASI) AS HARI_OPERASI
									FROM
										ZREPORT_RKAP_PRODUK_ST
									WHERE
										TANGGAL BETWEEN '2017-09-01'
									AND '$tanggal_akhir1'
									AND PROGONOSE_PRODUK <> 0
									AND PLANT = '$plant'
									AND KODE_PRODUK = '$kode_produk'
									AND WORK_CENTER = '$work_center'
        							")->row();
			$PROGONOSE_PRODUK = $sum_rkap->PROGONOSE_PRODUK;
			$ACTUAL_PRODUK = $sum_real->ACTUAL_PRODUK;
			$RKAP =$sum_rkap->RKAP;
			$HARI_OPERASI =number_format($hari_operasi->HARI_OPERASI,2); 
			if($sisa_hari->SISA_HARI=='' || $sisa_hari->SISA_HARI==null){
				$SISA_HARI = 0;
			}else{
				$SISA_HARI=$sisa_hari->SISA_HARI;
			}

		$data[$row['KODE_PRODUK']][]=array('nama_pabrik'=>$row['WORK_CENTER'],
												'RKAP'=>$RKAP,'PROGONOSE_PRODUK'=>$PROGONOSE_PRODUK,
												'ACTUAL_PRODUK'=>$ACTUAL_PRODUK,
												'HARI_OPERASI'=>$HARI_OPERASI,
												'SISA_HARI'=>$SISA_HARI,
												'data'=>$data1);
	}
}
		echo json_encode($data);
	}

}

/* End of file real_produksi_st.php */
/* Location: ./application/controllers/real_produksi_st.php */