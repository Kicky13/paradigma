<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_stoks6000 extends CI_Model {

	public function get_stoks6000()
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
              AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '6000'),'YYYYMMDD')
                AND ORG = '6000'                 
            )TB1
            LEFT JOIN (
              SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = 1
                AND ORG = '6000'
            )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
            LEFT JOIN (
              SELECT ORG, MAX_STOK, MIN_STOK
              FROM ZREPORT_SCM_MINMAX_STOK
              WHERE KODE_PRODUK = 1
                AND ORG = '6000'
            )TB3 ON TB1.ORG = TB3.ORG");
				$realisasi_terak="";
				$min_stock_terak="";
				$max_stock_terak="";
			foreach ($sql_terak->result_array() as $rowID) {
				//$org=$rowID['ORG'];
				$realisasi_terak=$rowID['REALISASI'];
				// $prognose+=$rowID['PROGNOSE'];
				$max_stock_terak=$rowID['MAX_STOK'];
				$min_stock_terak=$rowID['MIN_STOK'];
			}

		$sql_semen=$db->query("SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
              SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
              FROM ZREPORT_REAL_STOK_DEMANDPL
              WHERE KODE_PRODUK = 2
                AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
                            WHERE KODE_PRODUK = 2 
                            AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '6000'),'YYYYMMDD')
                AND ORG = '6000'                 
            )TB1
            LEFT JOIN (
              SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = 2
                AND ORG = '6000'
            )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
            LEFT JOIN (
              SELECT ORG, MAX_STOK, MIN_STOK
              FROM ZREPORT_SCM_MINMAX_STOK
              WHERE KODE_PRODUK = 2
                AND ORG = '6000'
            )TB3 ON TB1.ORG = TB3.ORG");

				$realisasi_semen="";
				$min_stock_semen="";
				$max_stock_semen="";
	foreach ($sql_semen->result_array() as $rowID) {
				//$org=$rowID['ORG'];
				$realisasi_semen=$rowID['REALISASI'];
				// $prognose+=$rowID['PROGNOSE'];
				$max_stock_semen=$rowID['MAX_STOK'];
				$min_stock_semen=$rowID['MIN_STOK'];
			}

			$data['Terak']=array(
				// 'org'=>$org,
				//'realisasi'=>$realisasi,
				'realisasi'=>$realisasi_terak,
				'max_stock'=>$max_stock_terak,
				//'min_stock'=>$min_stock_terak
				);
			$data['Semen']=array(
				// 'org'=>$org,
				//'realisasi'=>$realisasi,
				'realisasi'=>$realisasi_semen,
				'max_stock'=>$max_stock_semen,
				//'min_stock'=>$min_stock_semen
				);

		echo json_encode($data);

 		}

 		public function get_stokpps6000()
 	{
 			$db=$this->load->database('default5',true);
			$sql=$db->query("SELECT TB1.ORG,TB1.KODE_PLANT,TB1.NAMA_PLANT,TB1.KAPASITAS,TB2.STOCK_SILO,TB4.JAM_CREATE
                FROM (SELECT ORG,KODE_PLANT,NAMA_PLANT,TYPE,KAPASITAS FROM ZREPORT_PETA_SILOPP WHERE ORG=6000)TB1
                LEFT JOIN (
                    With STOCK as (     
                            SELECT ORG,NMPLAN,TIPE,CREATE_DATE,SILO, QTY_ENTRY,
                            ROW_NUMBER() OVER(PARTITION BY ORG,NMPLAN,TIPE,SILO ORDER BY CREATE_DATE DESC) AS ranks
                            FROM ZREPORT_STOCK_SILO
                            WHERE SILO <> '00000SILOS'
                            GROUP BY ORG,NMPLAN, TIPE,CREATE_DATE,SILO,QTY_ENTRY )
                                          Select NMPLAN,NVL(SUM(QTY_ENTRY),0) AS STOCK_SILO from STOCK
                                          where ranks=1
                                          group by NMPLAN
                                          order by NMPLAN
                )TB2
                ON TB1.KODE_PLANT=TB2.NMPLAN
           --      LEFT JOIN (
           --          SELECT PLANT, SUM(KWANTUMX) AS KWANTUMX
											-- FROM ZREPORT_RPT_REAL
											-- WHERE PLANT LIKE '7%' AND 
											-- ITEM_NO LIKE '121-30%' AND 
											-- TO_CHAR(TGL_CMPLT,'YYYYMMDD') >= '20161111' AND
											-- TO_CHAR(TGL_CMPLT,'YYYYMMDD') <= '20161118'
											-- GROUP BY PLANT
											-- UNION
											-- SELECT WERKS PLANT, SUM(TON) AS KWANTUMX
											-- FROM ZREPORT_ONGKOSANGKUT_MOD
											-- WHERE VKORG IN ('3000','4000') AND
											-- TO_CHAR(WADAT_IST,'YYYYMMDD') >= '20161111' AND
											-- TO_CHAR(WADAT_IST,'YYYYMMDD') <= '20161118'
											-- GROUP BY WERKS
           --      )TB3
           --      ON TB1.KODE_PLANT=TB3.PLANT
								LEFT JOIN(
											SELECT NMPLAN,JAM_CREATE FROM ZREPORT_STOCK_SILO X
											WHERE JAM_CREATE = (SELECT MAX(jam_create) FROM ZREPORT_STOCK_SILO where NMPLAN = X.NMPLAN)
											GROUP BY NMPLAN,JAM_CREATE 
								)TB4
								ON TB1.KODE_PLANT=TB4.NMPLAN ORDER BY tb1.org");
		foreach ($sql->result_array() as $rowID) {
				$kode_plant=$rowID['KODE_PLANT'];
				$nama_plant=$rowID['NAMA_PLANT'];
				$org=$rowID['ORG'];
				$stock_silo=$rowID['STOCK_SILO'];
				$kapasitas=$rowID['KAPASITAS'];
				//$tipe=$rowID['TIPE'];
				//$kwantumx=$rowID['KWANTUMX'];
				$jam_create=$rowID['JAM_CREATE'];

				$data[]=array(
						'kode_plant'=>$kode_plant,
						'lokasi_plant'=>$nama_plant,
						//'opco'=>$org,
						'stock'=>$stock_silo,
						'kapasitas'=>$kapasitas,
						//'kwantumx'=>$kwantumx,
						//'jam_update'=>$jam_create
					);
		}
		echo '{"s6000:"'.json_encode($data).'}';
 	}

 	public function get_stokdetails6000()
 	{
 		$db=$this->load->database('default5',true);
		$sql_terak=$db->query("SELECT TB2.REALISASI_PROD,TB3.REALISASI_STOK, TB1.PROG_PRODUK, TB1.RKAP_PRODUK, TB1.PROG_STOK, TB1.MIN_STOK, 
            TB1.MAX_STOK, TB1.TANGGAL
                FROM (SELECT SUM(PROG_PRODUK) PROG_PRODUK, SUM(RKAP_PRODUK) RKAP_PRODUK, SUM(PROG_STOK) PROG_STOK, SUM(MIN_STOK) MIN_STOK, SUM(MAX_STOK) MAX_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_DEMAND_PLANNING 
                    WHERE KODE_PRODUK = 1 AND TO_CHAR(TANGGAL,'YYYYMM') = '201611' AND ORG=6000
                    GROUP BY TANGGAL)TB1
                LEFT JOIN (
                    SELECT SUM(QTY_PROD) REALISASI_PROD, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_REAL_PROD_DEMANDPL 
                    WHERE KODE_PRODUK = 1 AND TO_CHAR(TANGGAL,'YYYYMM') = '201611' and ORG=6000
                    GROUP BY TANGGAL
                )TB2
                ON TB1.TANGGAL = TB2.TANGGAL
                LEFT JOIN (
                    SELECT SUM(QTY_STOK) REALISASI_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_REAL_STOK_DEMANDPL 
                    WHERE KODE_PRODUK = 1 AND TO_CHAR(TANGGAL,'YYYYMM') = '201611' AND ORG=6000
										GROUP BY TANGGAL
                )TB3
                ON TB1.TANGGAL = TB3.TANGGAL ORDER BY TB1.TANGGAL ASC");

		foreach ($sql_terak->result_array() as $rowID) {
				$tanggal_terak=$rowID['TANGGAL'];
				$realisasi_prod_terak=$rowID['REALISASI_PROD'];
				$realisasi_stok_terak=$rowID['REALISASI_STOK'];
				$prog_produk_terak=$rowID['PROG_PRODUK'];
				$rkap_produk_terak=$rowID['RKAP_PRODUK'];
				$prog_stok_terak=$rowID['PROG_STOK'];
				$min_stok_terak=$rowID['MIN_STOK'];
				$max_stok_terak=$rowID['MAX_STOK'];
				

		$data_terak[$tanggal_terak]=array(
					'realisasi_stok'=>$realisasi_stok_terak,
					'realisasi_prod'=>$realisasi_prod_terak,
					'prog_produk'=>$prog_produk_terak,
					'rkap_produk'=>$rkap_produk_terak,
					'prog_stok'=>$prog_stok_terak,
					'min_stok'=>$min_stok_terak,
					'max_stok'=>$max_stok_terak
			);
		}

		$sql_semen=$db->query("SELECT TB2.REALISASI_PROD,TB3.REALISASI_STOK, TB1.PROG_PRODUK, TB1.RKAP_PRODUK, TB1.PROG_STOK, TB1.MIN_STOK, 
            TB1.MAX_STOK, TB1.TANGGAL
                FROM (SELECT SUM(PROG_PRODUK) PROG_PRODUK, SUM(RKAP_PRODUK) RKAP_PRODUK, SUM(PROG_STOK) PROG_STOK, SUM(MIN_STOK) MIN_STOK, SUM(MAX_STOK) MAX_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_DEMAND_PLANNING 
                    WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '201611' AND ORG=6000
                    GROUP BY TANGGAL)TB1
                LEFT JOIN (
                    SELECT SUM(QTY_PROD) REALISASI_PROD, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_REAL_PROD_DEMANDPL 
                    WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '201611' and ORG=6000
                    GROUP BY TANGGAL
                )TB2
                ON TB1.TANGGAL = TB2.TANGGAL
                LEFT JOIN (
                    SELECT SUM(QTY_STOK) REALISASI_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_REAL_STOK_DEMANDPL 
                    WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '201611' AND ORG=6000
										GROUP BY TANGGAL
                )TB3
                ON TB1.TANGGAL = TB3.TANGGAL ORDER BY TB1.TANGGAL ASC");

		foreach ($sql_semen->result_array() as $rowID) {
				$tanggal_semen=$rowID['TANGGAL'];
				$realisasi_prod_semen=$rowID['REALISASI_PROD'];
				$realisasi_stok_semen=$rowID['REALISASI_STOK'];
				$prog_produk_semen=$rowID['PROG_PRODUK'];
				$rkap_produk_semen=$rowID['RKAP_PRODUK'];
				$prog_stok_semen=$rowID['PROG_STOK'];
				$min_stok_semen=$rowID['MIN_STOK'];
				$max_stok_semen=$rowID['MAX_STOK'];
				

		$data_semen[$tanggal_semen]=array(
					'realisasi_stok'=>$realisasi_stok_semen,
					'realisasi_prod'=>$realisasi_prod_semen,
					'prog_produk'=>$prog_produk_semen,
					'rkap_produk'=>$rkap_produk_semen,
					'prog_stok'=>$prog_stok_semen,
					'min_stok'=>$min_stok_semen,
					'max_stok'=>$max_stok_semen
			);
		}
		$data['Terak'] = $data_terak;
		$data['Semen'] = $data_semen;
		echo json_encode($data);

		//echo '{"Terak":' . json_encode($data_terak) . '},'.'{"Semen":' . json_encode($data_semen) . '}';
	}
}

/* End of file m_stoks6000.php */
/* Location: ./application/models/stokpp&gudang/m_stoks6000.php */