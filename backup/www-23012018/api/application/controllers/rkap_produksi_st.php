<?php
header('Access-Control-Allow-Origin:*');
defined('BASEPATH') OR exit('No direct script access allowed');

class Rkap_produksi_st extends CI_Controller {

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
        $plant = (empty($_GET['plant']) ? '' : $_GET['plant']);
        // $kode_produk = (empty($_GET['kode_produk']) ? 1 : $_GET['kode_produk']);
        $bulan=$this->bulan($bulan1);
        $tanggal = $tahun.'-'.$bulan1.'-'.$hari;
        $tanggal1 = $tahun.'-'.$bulan1.'-01';
        $tanggal2='2017-'.$bulan.'-31';
        $kode_produk1=array(1,2);
        foreach ($kode_produk1 as $kode_produk) {
        $sql=$this->db->query("
        					SELECT
								ORG,
								-- PLANT,
								KODE_PRODUK,
								YEAR,
								MONTH,
								SUM(RKAP) AS RKAP,
								SUM(PROGONOSE_PRODUK) AS PROGONOSE_PRODUK,
								SUM(PRONGNOSE_STOCK) AS PRONGNOSE_STOCK ,
								SUM(MIN_STOCK) AS MIN_STOCK,
								SUM(MAX_STOCK) AS MAX_STOCK, 
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH = '$bulan'
								-- AND TANGGAL = '$tanggal'
								AND KODE_PRODUK = '$kode_produk'
								AND PLANT LIKE '%$plant%'
							GROUP BY ORG,KODE_PRODUK,YEAR,MONTH
							        	");
        $total_row=$this->db->query("SELECT TANGGAL FROM ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH = '$bulan'
								AND PLANT LIKE '%$plant%'
								AND KODE_PRODUK = '$kode_produk'")->num_rows();
        foreach ($sql->result_array() as $row) {

        	$data['month'][$row['KODE_PRODUK']]=array( 		'ORG' =>	$row['ORG'],
									// 'PLANT' =>	$row['PLANT'],
									'KODE_PRODUK' =>	$row['KODE_PRODUK'],
									'YEAR' =>	$row['YEAR'],
									'MONTH' =>	$row['MONTH'],
									'RKAP' =>	$row['RKAP'],
									'PROGONOSE_PRODUK' =>	$row['PROGONOSE_PRODUK'],
									'PRONGNOSE_STOCK' =>	$row['PRONGNOSE_STOCK'],
									'MIN_STOCK' =>	$row['MIN_STOCK'],
									'MAX_STOCK' =>	$row['MAX_STOCK'],
									// 'JAM_OPERASI' =>	$row['JAM_OPERASI'],
									'KAPASITAS' =>	$row['KAPASITAS'],
									// 'CREATED_DATE' =>	$row['CREATED_DATE'],
									// 'CREATED_BY' =>	$row['CREATED_BY'],
									// 'UPDATE_DATE' =>	$row['UPDATE_DATE'],
									// 'UPDATE_BY' =>	$row['UPDATE_BY'],
									// 'TANGGAL' =>	$row['TANGGAL'],
									'HARI_OPERASI' =>$total_row
									);
        }

         $sql1=$this->db->query("
        					SELECT
								ORG,
								-- PLANT,
								KODE_PRODUK,
								YEAR,
								-- MONTH,
								SUM(RKAP) AS RKAP,
								SUM(PROGONOSE_PRODUK) AS PROGONOSE_PRODUK,
								SUM(PRONGNOSE_STOCK) AS PRONGNOSE_STOCK ,
								SUM(MIN_STOCK) AS MIN_STOCK,
								SUM(MAX_STOCK) AS MAX_STOCK, 
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								-- AND MONTH = '$bulan'
								-- AND TANGGAL BETWEEN '$tanggal1' AND  '$tanggal'
								AND KODE_PRODUK = '$kode_produk'
								AND PLANT LIKE '%$plant%'
							GROUP BY ORG,KODE_PRODUK,YEAR
							        	");
        $total_row1=$this->db->query("SELECT TANGGAL FROM ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH = '$bulan'
								AND PLANT IN (4301,4302,4303)
								AND KODE_PRODUK = '$kode_produk'
								AND PROGONOSE_PRODUK != 0")->num_rows();
        foreach ($sql1->result_array() as $row) {
        	$data['up_month'][$row['KODE_PRODUK']]=array( 'ORG' =>	$row['ORG'],
									// 'PLANT' =>	$row['PLANT'],
									'KODE_PRODUK' =>	$row['KODE_PRODUK'],
									'YEAR' =>	$row['YEAR'],
									// 'MONTH' =>	$row['MONTH'],
									'RKAP' =>	$row['RKAP'],
									'PROGONOSE_PRODUK' =>	$row['PROGONOSE_PRODUK'],
									'PRONGNOSE_STOCK' =>	$row['PRONGNOSE_STOCK'],
									'MIN_STOCK' =>	$row['MIN_STOCK'],
									'MAX_STOCK' =>	$row['MAX_STOCK'],
									// 'JAM_OPERASI' =>	$row['JAM_OPERASI'],
									'KAPASITAS' =>	$row['KAPASITAS'],
									// 'CREATED_DATE' =>	$row['CREATED_DATE'],
									// 'CREATED_BY' =>	$row['CREATED_BY'],
									// 'UPDATE_DATE' =>	$row['UPDATE_DATE'],
									// 'UPDATE_BY' =>	$row['UPDATE_BY'],
									// 'TANGGAL' =>	$row['TANGGAL'],
									'HARI_OPERASI' =>$total_row1
									);
        }


         $sql2=$this->db->query("
        					SELECT
								ORG,
								-- PLANT,
								KODE_PRODUK,
								YEAR,
								-- MONTH,
								SUM(RKAP) AS RKAP,
								SUM(PROGONOSE_PRODUK) AS PROGONOSE_PRODUK,
								SUM(PRONGNOSE_STOCK) AS PRONGNOSE_STOCK ,
								SUM(MIN_STOCK) AS MIN_STOCK,
								SUM(MAX_STOCK) AS MAX_STOCK, 
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH BETWEEN '1' AND '$bulan'
								AND KODE_PRODUK = '$kode_produk'
								AND PLANT LIKE '%$plant%'
							GROUP BY ORG,KODE_PRODUK,YEAR
							        	");
        $total_row2=$this->db->query("SELECT TANGGAL FROM ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH BETWEEN '1' AND '$bulan'
								AND PLANT IN (4301,4302,4303)
								AND KODE_PRODUK = '$kode_produk'
								AND PROGONOSE_PRODUK != 0")->num_rows();
        foreach ($sql2->result_array() as $row) {
        	$data['up_month2'][$row['KODE_PRODUK']]=array( 'ORG' =>	$row['ORG'],
									// 'PLANT' =>	$row['PLANT'],
									'KODE_PRODUK' =>	$row['KODE_PRODUK'],
									'YEAR' =>	$row['YEAR'],
									// 'MONTH' =>	$row['MONTH'],
									'RKAP' =>	$row['RKAP'],
									'PROGONOSE_PRODUK' =>	$row['PROGONOSE_PRODUK'],
									'PRONGNOSE_STOCK' =>	$row['PRONGNOSE_STOCK'],
									'MIN_STOCK' =>	$row['MIN_STOCK'],
									'MAX_STOCK' =>	$row['MAX_STOCK'],
									// 'JAM_OPERASI' =>	$row['JAM_OPERASI'],
									'KAPASITAS' =>	$row['KAPASITAS'],
									// 'CREATED_DATE' =>	$row['CREATED_DATE'],
									// 'CREATED_BY' =>	$row['CREATED_BY'],
									// 'UPDATE_DATE' =>	$row['UPDATE_DATE'],
									// 'UPDATE_BY' =>	$row['UPDATE_BY'],
									// 'TANGGAL' =>	$row['TANGGAL'],
									'HARI_OPERASI' =>$total_row2
									);
        }

    }
        	echo json_encode($data);	
	}

	public function rkap_plant()
	{
		$data=[];
		$bulan1 = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $hari = (empty($_GET['hari']) ? date('d') : $_GET['hari']);
        // $kode_produk = (empty($_GET['kode_produk']) ? 1 : $_GET['kode_produk']);

        $bulan=$this->bulan($bulan1);
        $hari1=intval($hari)+1;
        $tanggal = $tahun.'-'.$bulan1.'-'.$hari;
        $tanggal1 = $tahun.'-'.$bulan1.'-01';
        $tanggal2='2017-'.$bulan.'-31';
        $kode_produk1=array(1,2);
        if($bulan==date('m')){
        	$tanggal3 =  $tahun.'-'.$bulan1.'-'.$hari1;
        }else{
        	$tanggal3 =  $tanggal2;
        }
        foreach ($kode_produk1 as $kode_produk) {
        $sql=$this->db->query("
        					SELECT
								ORG,
								PLANT,
								KODE_PRODUK,
								YEAR,
								MONTH,
								SUM(RKAP) AS RKAP,
								SUM(PROGONOSE_PRODUK) AS PROGONOSE_PRODUK,
								SUM(PRONGNOSE_STOCK) AS PRONGNOSE_STOCK ,
								SUM(MIN_STOCK) AS MIN_STOCK,
								SUM(MAX_STOCK) AS MAX_STOCK, 
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH = '$bulan'
								AND TANGGAL = '$tanggal'
								AND KODE_PRODUK = '$kode_produk'
								AND PLANT IN (4301,4302,4303)
							GROUP BY ORG,PLANT,KODE_PRODUK,YEAR,MONTH
							        	");
        $total_row=$this->db->query("SELECT TANGGAL FROM ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH = '$bulan'
								AND PLANT IN (4301,4302,4303)
								AND KODE_PRODUK = '$kode_produk'
								AND TANGGAL = '$tanggal'
								GROUP BY TANGGAL")->num_rows();
        foreach ($sql->result_array() as $row) {

        	$data['month'][$row['KODE_PRODUK']][$row['PLANT']]=array( 		'ORG' =>	$row['ORG'],
									'PLANT' =>	$row['PLANT'],
									'KODE_PRODUK' =>	$row['KODE_PRODUK'],
									'YEAR' =>	$row['YEAR'],
									'MONTH' =>	$row['MONTH'],
									'RKAP' =>	$row['RKAP'],
									'PROGONOSE_PRODUK' =>	$row['PROGONOSE_PRODUK'],
									'PRONGNOSE_STOCK' =>	$row['PRONGNOSE_STOCK'],
									'MIN_STOCK' =>	$row['MIN_STOCK'],
									'MAX_STOCK' =>	$row['MAX_STOCK'],
									// 'JAM_OPERASI' =>	$row['JAM_OPERASI'],
									'KAPASITAS' =>	$row['KAPASITAS'],
									// 'CREATED_DATE' =>	$row['CREATED_DATE'],
									// 'CREATED_BY' =>	$row['CREATED_BY'],
									// 'UPDATE_DATE' =>	$row['UPDATE_DATE'],
									// 'UPDATE_BY' =>	$row['UPDATE_BY'],
									// 'TANGGAL' =>	$row['TANGGAL'],
									'HARI_OPERASI' =>$total_row
									);
        }

         $sql1=$this->db->query("
        					SELECT
								ORG,
								PLANT,
								KODE_PRODUK,
								YEAR,
								SUM(RKAP) AS RKAP,
								SUM(PROGONOSE_PRODUK) AS PROGONOSE_PRODUK,
								SUM(PRONGNOSE_STOCK) AS PRONGNOSE_STOCK ,
								SUM(MIN_STOCK) AS MIN_STOCK,
								SUM(MAX_STOCK) AS MAX_STOCK, 
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH = '$bulan'
								AND KODE_PRODUK = '$kode_produk'
								AND PLANT IN (4301,4302,4303)
							GROUP BY ORG,PLANT,KODE_PRODUK,YEAR
							        	");
         $total_row=$this->db->query("SELECT TANGGAL FROM ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH = '$bulan'
								AND PLANT IN (4301,4302,4303)
								AND TANGGAL BETWEEN '$tanggal1'
								AND '$tanggal'
								AND PROGONOSE_PRODUK <> 0
								AND KODE_PRODUK = '$kode_produk'
								AND PROGONOSE_PRODUK != 0
								GROUP BY TANGGAL")->num_rows();

        $sisa_hari=$this->db->query("SELECT TANGGAL FROM ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH = '$bulan'
								AND PLANT IN (4301,4302,4303)
								AND TANGGAL BETWEEN '$tanggal'
								AND '$tanggal2'
								AND PROGONOSE_PRODUK <> 0
								AND KODE_PRODUK = '$kode_produk'
								AND PROGONOSE_PRODUK != 0
								GROUP BY TANGGAL")->num_rows();
        

        foreach ($sql1->result_array() as $row) {
        	$sisa_prognose=$this->db->query("
        								SELECT PLANT,SUM(PROGONOSE_PRODUK) AS PROGONOSE_PRODUK FROM ZREPORT_RKAP_PRODUK_ST
										WHERE
										ORG = 4000
										AND YEAR = '$tahun'
										AND MONTH = '$bulan'
										AND PLANT = '".$row['PLANT']."'
										AND TANGGAL BETWEEN '$tanggal'
										AND '$tanggal2'
										AND PROGONOSE_PRODUK <> 0
										AND KODE_PRODUK = '$kode_produk'
										AND PROGONOSE_PRODUK != 0
										GROUP BY PLANT
										ORDER BY PLANT ASC

        					");

        	if($sisa_prognose->num_rows()>0){
        		$sisa_prognose1=$sisa_prognose->row();
        		$sisa_prognose2=$sisa_prognose1->PROGONOSE_PRODUK;
        	}else{
        		$sisa_prognose2=0;
        	}
        	$data['up_month'][$row['KODE_PRODUK']][$row['PLANT']]=array( 'ORG' =>	$row['ORG'],
									'PLANT' =>	$row['PLANT'],
									'KODE_PRODUK' =>	$row['KODE_PRODUK'],
									'YEAR' =>	$row['YEAR'],
									// 'MONTH' =>	$row['MONTH'],
									'RKAP' =>	$row['RKAP'],
									'PROGONOSE_PRODUK' =>	$row['PROGONOSE_PRODUK'],
									'PRONGNOSE_STOCK' =>	$row['PRONGNOSE_STOCK'],
									'MIN_STOCK' =>	$row['MIN_STOCK'],
									'MAX_STOCK' =>	$row['MAX_STOCK'],
									// 'JAM_OPERASI' =>	$row['JAM_OPERASI'],
									'KAPASITAS' =>	$row['KAPASITAS'],
									// 'CREATED_DATE' =>	$row['CREATED_DATE'],
									// 'CREATED_BY' =>	$row['CREATED_BY'],
									// 'UPDATE_DATE' =>	$row['UPDATE_DATE'],
									// 'UPDATE_BY' =>	$row['UPDATE_BY'],
									// 'TANGGAL' =>	$row['TANGGAL'],
									'HARI_OPERASI' =>$total_row,
									'SISA_HARI'=>$sisa_hari,
									'SISA_PROGNOSE'=>$sisa_prognose2
									);

        }

         $sql2=$this->db->query("
        					SELECT
								ORG,
								PLANT,
								KODE_PRODUK,
								YEAR,
								SUM(RKAP) AS RKAP,
								SUM(PROGONOSE_PRODUK) AS PROGONOSE_PRODUK,
								SUM(PRONGNOSE_STOCK) AS PRONGNOSE_STOCK ,
								SUM(MIN_STOCK) AS MIN_STOCK,
								SUM(MAX_STOCK) AS MAX_STOCK, 
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								-- AND MONTH = '$bulan'
								AND KODE_PRODUK = '$kode_produk'
								AND PLANT IN (4301,4302,4303)
							GROUP BY ORG,PLANT,KODE_PRODUK,YEAR
							        	");
        $total_row2=$this->db->query("SELECT TANGGAL FROM ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND PLANT IN (4301,4302,4303)
								-- AND MONTH =  '$bulan'
								AND KODE_PRODUK = '$kode_produk'
								AND PROGONOSE_PRODUK != 0")->num_rows();
        foreach ($sql2->result_array() as $row) {
        	$data['up_month2'][$row['KODE_PRODUK']][$row['PLANT']]=array( 'ORG' =>	$row['ORG'],
									'PLANT' =>	$row['PLANT'],
									'KODE_PRODUK' =>	$row['KODE_PRODUK'],
									'YEAR' =>	$row['YEAR'],
									// 'MONTH' =>	$row['MONTH'],
									'RKAP' =>	$row['RKAP'],
									'PROGONOSE_PRODUK' =>	$row['PROGONOSE_PRODUK'],
									'PRONGNOSE_STOCK' =>	$row['PRONGNOSE_STOCK'],
									'MIN_STOCK' =>	$row['MIN_STOCK'],
									'MAX_STOCK' =>	$row['MAX_STOCK'],
									// 'JAM_OPERASI' =>	$row['JAM_OPERASI'],
									'KAPASITAS' =>	$row['KAPASITAS'],
									// 'CREATED_DATE' =>	$row['CREATED_DATE'],
									// 'CREATED_BY' =>	$row['CREATED_BY'],
									// 'UPDATE_DATE' =>	$row['UPDATE_DATE'],
									// 'UPDATE_BY' =>	$row['UPDATE_BY'],
									// 'TANGGAL' =>	$row['TANGGAL'],
									'HARI_OPERASI' =>$total_row2
									);
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

	public function chart_month() {
		
		$data=[];
		$bulan1 = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $plant = (empty($_GET['plant']) ? '4301,4302,4303' : $_GET['plant']);
          $bulan=$this->bulan($bulan1);
          $kode_produk1 =array(1,2);
          foreach ($kode_produk1 as $kode_produk) {
			 $rkap=$this->db->query("
        					SELECT
								ORG,
								-- PLANT,
								KODE_PRODUK,
								YEAR,
								MONTH,
								SUM(RKAP) AS RKAP,
								SUM(PROGONOSE_PRODUK) AS PROGONOSE_PRODUK,
								SUM(PRONGNOSE_STOCK) AS PRONGNOSE_STOCK ,
								SUM(MIN_STOCK) AS MIN_STOCK,
								SUM(MAX_STOCK) AS MAX_STOCK, 
								SUM(KAPASITAS) AS KAPASITAS
							FROM
								ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH BETWEEN '1' AND '$bulan'
								AND KODE_PRODUK = '$kode_produk'
								AND PLANT IN ($plant)
							GROUP BY ORG,KODE_PRODUK,YEAR,MONTH"
					);

		foreach ($rkap->result_array() as $row) {
			
			$total_row=$this->db->query("SELECT TANGGAL FROM ZREPORT_RKAP_PRODUK_ST
							WHERE
								ORG = 4000
								AND YEAR = '$tahun'
								AND MONTH = '".$row['MONTH']."'
								AND PLANT IN ($plant)
								AND KODE_PRODUK = '$kode_produk'
								AND PROGONOSE_PRODUK != 0")->num_rows();
								
        	$data['rkap'][$row['KODE_PRODUK']][$row['MONTH']]=	array( 
									'RKAP' =>	$row['RKAP'],
									'PROGONOSE_PRODUK' =>	$row['PROGONOSE_PRODUK'],
									'HARI_OPERASI' =>	$total_row, 
									);
        }

        //real 
        $real = $this->db->query("SELECT
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
									KODE_PRODUK = '$kode_produk'
								AND
									YEAR = '$tahun'
									AND MONTH BETWEEN 1 AND $bulan
								GROUP BY
									ORG,KODE_PRODUK,YEAR,MONTH" 
								);


       	foreach ($real->result_array() as $row) {
       		$data['real'][$row['KODE_PRODUK']][$row['MONTH']]=array(
								'REAL' =>	$row['ACTUAL_PRODUK']
       			);
       	}
    }



    	echo json_encode($data);
	}

}

/* End of file rkap_produksi_st.php */
/* Location: ./application/controllers/rkap_produksi_st.php */