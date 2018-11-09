<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_stokklinkerperopco extends CI_Model {

	public function get_stokklinkerperopco()
	{
		$tgl_sekarang=date('Ym');
		// if(!empty($_GET['bulan'])&&!empty($_GET['tahun'])){
			$bulan=date('m');
			$tahun=date('Y');
      		$bulan = $bulan;
       		$tahun_bulan = $tahun;
        
        		// if ($bulan < 10) {
          //   		$bulan = '0'.$bulan;
         	// 	}

        		if ($bulan=='00') {
            		$bulan = '12';
            		$tahun_bulan =  $tahun_bulan -1;
        		}

		$tgl2=$tahun.$bulan;

		$db=$this->load->database('default5',true);
		$sql_terak=$db->query("SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
              SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
              FROM ZREPORT_REAL_STOK_DEMANDPL
              WHERE KODE_PRODUK = 1
                AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
							WHERE KODE_PRODUK = 1 
							AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '7000'),'YYYYMMDD')
                AND ORG = '7000'                 
            )TB1
            LEFT JOIN (
              SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = 1
                AND ORG = '7000'
            )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
            LEFT JOIN (
              SELECT ORG, MAX_STOK, MIN_STOK, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = 1
                AND ORG = '7000'
            )TB3 ON TB1.ORG = TB3.ORG AND TB1.TANGGAL = TB3.TANGGAL

UNION
SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
              SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
              FROM ZREPORT_REAL_STOK_DEMANDPL
              WHERE KODE_PRODUK = 1
                AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
							WHERE KODE_PRODUK = 1 
							AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '3000'),'YYYYMMDD')
                AND ORG = '3000'                 
            )TB1
            LEFT JOIN (
              SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = 1
                AND ORG = '3000'
            )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
            LEFT JOIN (
              SELECT ORG, MAX_STOK, MIN_STOK, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = 1
                AND ORG = '3000'
            )TB3 ON TB1.ORG = TB3.ORG AND TB1.TANGGAL = TB3.TANGGAL
UNION
SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
              SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
              FROM ZREPORT_REAL_STOK_DEMANDPL
              WHERE KODE_PRODUK = 1
                AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
							WHERE KODE_PRODUK = 1 
							AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '4000'),'YYYYMMDD')
                AND ORG = '4000'                 
            )TB1
            LEFT JOIN (
              SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = 1
                AND ORG = '4000'
            )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
            LEFT JOIN (
              SELECT ORG, MAX_STOK, MIN_STOK, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = 1
                AND ORG = '4000'
            )TB3 ON TB1.ORG = TB3.ORG AND TB1.TANGGAL = TB3.TANGGAL
-- UNION
-- SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
--               SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
--               FROM ZREPORT_REAL_STOK_DEMANDPL
--               WHERE KODE_PRODUK = 1
--                 AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
-- 							WHERE KODE_PRODUK = 1 
-- 							AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '6000'),'YYYYMMDD')
--                 AND ORG = '6000'                 
--             )TB1
--             LEFT JOIN (
--               SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
--               FROM ZREPORT_DEMAND_PLANNING
--               WHERE KODE_PRODUK = 1
--                 AND ORG = '6000'
--             )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
--             LEFT JOIN (
--               SELECT ORG, MAX_STOK, MIN_STOK, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
--               FROM ZREPORT_DEMAND_PLANNING
--               WHERE KODE_PRODUK = 1
--                 AND ORG = '6000'
--             )TB3 ON TB1.ORG = TB3.ORG AND TB1.TANGGAL = TB3.TANGGAL

            ");
				$realisasi_terak="";
				$min_stock_terak="";
				$max_stock_terak="";
	foreach ($sql_terak->result_array() as $rowID) {
				$org=$rowID['ORG'];
				$realisasi_terak=$rowID['REALISASI'];
				//$prognose+=$rowID['PROGNOSE'];
				$max_stock_terak=$rowID['MAX_STOK'];
				$min_stock_terak=$rowID['MIN_STOK'];

				$data['s'.$org]=array(
				//'org'=>$org,
				'realisasi'=>$realisasi_terak,
				//'prognose'=>$prognose,
				//'max_stock'=>$max_stock,
				//'min_stock'=>$min_stock,
				);
			}
			

		echo json_encode($data);

	}

}

/* End of file m_stokklinkerperopco.php */
/* Location: ./application/models/m_stokklinkerperopco.php */