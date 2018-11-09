<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_stokterak extends CI_Model {

	public function get_stokterak($tgl2)
	{
		// $tgl_sekarang=date('Ym');
		// if(!empty($_GET['bulan'])&&!empty($_GET['tahun'])){
		// 	$bulan=$_GET['bulan'];
		// 	$tahun=$_GET['tahun'];
		// 	$tgl2=$tahun.$bulan;
		// }else{
		// 	$tgl2=date('Ym');
		//  }

//     $sql_terak_sql="SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
//               SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
//               FROM ZREPORT_REAL_STOK_DEMANDPL
//               WHERE KODE_PRODUK = 1
//                 AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
//               WHERE KODE_PRODUK = 1 
//               AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '7000'),'YYYYMMDD')
//                 AND ORG = '7000'                 
//             )TB1
//             LEFT JOIN (
//               SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
//               FROM ZREPORT_DEMAND_PLANNING
//               WHERE KODE_PRODUK = 1
//                 AND ORG = '7000'
//             )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
//             LEFT JOIN (
//               SELECT ORG, MAX_STOK, MIN_STOK
//               FROM ZREPORT_SCM_MINMAX_STOK
//               WHERE KODE_PRODUK = 1
//                 AND ORG = '7000'
//             )TB3 ON TB1.ORG = TB3.ORG

// UNION
// SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
//               SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
//               FROM ZREPORT_REAL_STOK_DEMANDPL
//               WHERE KODE_PRODUK = 1
//                 AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
//               WHERE KODE_PRODUK = 1 
//               AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '3000'),'YYYYMMDD')
//                 AND ORG = '3000'                 
//             )TB1
//             LEFT JOIN (
//               SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
//               FROM ZREPORT_DEMAND_PLANNING
//               WHERE KODE_PRODUK = 1
//                 AND ORG = '3000'
//             )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
//             LEFT JOIN (
//               SELECT ORG, MAX_STOK, MIN_STOK
//               FROM ZREPORT_SCM_MINMAX_STOK
//               WHERE KODE_PRODUK = 1
//                 AND ORG = '3000'
//             )TB3 ON TB1.ORG = TB3.ORG
// UNION
// SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
//               SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
//               FROM ZREPORT_REAL_STOK_DEMANDPL
//               WHERE KODE_PRODUK = 1
//                 AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
//               WHERE KODE_PRODUK = 1 
//               AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '4000'),'YYYYMMDD')
//                 AND ORG = '4000'                 
//             )TB1
//             LEFT JOIN (
//               SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
//               FROM ZREPORT_DEMAND_PLANNING
//               WHERE KODE_PRODUK = 1
//                 AND ORG = '4000'
//             )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
//             LEFT JOIN (
//               SELECT ORG, MAX_STOK, MIN_STOK
//               FROM ZREPORT_SCM_MINMAX_STOK
//               WHERE KODE_PRODUK = 1
//                 AND ORG = '4000'
//             )TB3 ON TB1.ORG = TB3.ORG";

//     $sql_semen_sql="SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
//               SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
//               FROM ZREPORT_REAL_STOK_DEMANDPL
//               WHERE KODE_PRODUK = 2
//                 AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
//                             WHERE KODE_PRODUK = 2 
//                             AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '7000'),'YYYYMMDD')
//                 AND ORG = '7000'                 
//             )TB1
//             LEFT JOIN (
//               SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
//               FROM ZREPORT_DEMAND_PLANNING
//               WHERE KODE_PRODUK = 2
//                 AND ORG = '7000'
//             )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
//             LEFT JOIN (
//               SELECT ORG, MAX_STOK, MIN_STOK
//               FROM ZREPORT_SCM_MINMAX_STOK
//               WHERE KODE_PRODUK = 2
//                 AND ORG = '7000'
//             )TB3 ON TB1.ORG = TB3.ORG

// UNION
// SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
//               SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
//               FROM ZREPORT_REAL_STOK_DEMANDPL
//               WHERE KODE_PRODUK = 2
//                 AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
//                             WHERE KODE_PRODUK = 2 
//                             AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '3000'),'YYYYMMDD')
//                 AND ORG = '3000'                 
//             )TB1
//             LEFT JOIN (
//               SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
//               FROM ZREPORT_DEMAND_PLANNING
//               WHERE KODE_PRODUK = 2
//                 AND ORG = '3000'
//             )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
//             LEFT JOIN (
//               SELECT ORG, MAX_STOK, MIN_STOK
//               FROM ZREPORT_SCM_MINMAX_STOK
//               WHERE KODE_PRODUK = 2
//                 AND ORG = '3000'
//             )TB3 ON TB1.ORG = TB3.ORG
// UNION
// SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
//               SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
//               FROM ZREPORT_REAL_STOK_DEMANDPL
//               WHERE KODE_PRODUK = 2
//                 AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
//                             WHERE KODE_PRODUK = 2 
//                             AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '4000'),'YYYYMMDD')
//                 AND ORG = '4000'                 
//             )TB1
//             LEFT JOIN (
//               SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
//               FROM ZREPORT_DEMAND_PLANNING
//               WHERE KODE_PRODUK = 2
//                 AND ORG = '4000'
//             )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
//             LEFT JOIN (
//               SELECT ORG, MAX_STOK, MIN_STOK
//               FROM ZREPORT_SCM_MINMAX_STOK
//               WHERE KODE_PRODUK = 2
//                 AND ORG = '4000'
//             )TB3 ON TB1.ORG = TB3.ORG";


//       echo $sql_terak_sql;
//       echo  $sql_semen_sql;


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
              SELECT ORG, MAX_STOK, MIN_STOK
              FROM ZREPORT_SCM_MINMAX_STOK
              WHERE KODE_PRODUK = 1
                AND ORG = '7000'
            )TB3 ON TB1.ORG = TB3.ORG

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
              SELECT ORG, MAX_STOK, MIN_STOK
              FROM ZREPORT_SCM_MINMAX_STOK
              WHERE KODE_PRODUK = 1
                AND ORG = '3000'
            )TB3 ON TB1.ORG = TB3.ORG
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
              SELECT ORG, MAX_STOK, MIN_STOK
              FROM ZREPORT_SCM_MINMAX_STOK
              WHERE KODE_PRODUK = 1
                AND ORG = '4000'
            )TB3 ON TB1.ORG = TB3.ORG");
				$realisasi_terak="";
				$min_stock_terak="";
				$max_stock_terak="";
	foreach ($sql_terak->result_array() as $rowID) {
				//$org=$rowID['ORG'];
				$realisasi_terak+=$rowID['REALISASI'];
				// $prognose+=$rowID['PROGNOSE'];
				$max_stock_terak+=$rowID['MAX_STOK'];
				$min_stock_terak+=$rowID['MIN_STOK'];
			}
			// $data[$kode_produk]=array(
			// 	'org'=>$org,
			// 	'realisasi'=>$realisasi,
			// 	'prognose'=>$prognose,
			// 	'max_stock'=>$max_stock,
			// 	'min_stock'=>$min_stock,
			// 	);

$sql_semen=$db->query("SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
              SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
              FROM ZREPORT_REAL_STOK_DEMANDPL
              WHERE KODE_PRODUK = 2
                AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
                            WHERE KODE_PRODUK = 2 
                            AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '7000'),'YYYYMMDD')
                AND ORG = '7000'                 
            )TB1
            LEFT JOIN (
              SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = 2
                AND ORG = '7000'
            )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
            LEFT JOIN (
              SELECT ORG, MAX_STOK, MIN_STOK
              FROM ZREPORT_SCM_MINMAX_STOK
              WHERE KODE_PRODUK = 2
                AND ORG = '7000'
            )TB3 ON TB1.ORG = TB3.ORG

UNION
SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
              SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
              FROM ZREPORT_REAL_STOK_DEMANDPL
              WHERE KODE_PRODUK = 2
                AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
                            WHERE KODE_PRODUK = 2 
                            AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '3000'),'YYYYMMDD')
                AND ORG = '3000'                 
            )TB1
            LEFT JOIN (
              SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = 2
                AND ORG = '3000'
            )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
            LEFT JOIN (
              SELECT ORG, MAX_STOK, MIN_STOK
              FROM ZREPORT_SCM_MINMAX_STOK
              WHERE KODE_PRODUK = 2
                AND ORG = '3000'
            )TB3 ON TB1.ORG = TB3.ORG
UNION
SELECT TB1.ORG, TB1.REALISASI, TB2.PROGNOSE, TB3.MAX_STOK, TB3.MIN_STOK, TB1.MAX_DATE FROM (
              SELECT ORG, QTY_STOK REALISASI, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL, TO_CHAR(TANGGAL,'DD-MM-YYYY') MAX_DATE
              FROM ZREPORT_REAL_STOK_DEMANDPL
              WHERE KODE_PRODUK = 2
                AND TO_CHAR(TANGGAL,'YYYYMMDD') = TO_CHAR((SELECT MAx(TANGGAL) FROM ZREPORT_REAL_STOK_DEMANDPL 
                            WHERE KODE_PRODUK = 2 
                            AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2' AND ORG = '4000'),'YYYYMMDD')
                AND ORG = '4000'                 
            )TB1
            LEFT JOIN (
              SELECT ORG, PROG_STOK PROGNOSE, TO_CHAR(TANGGAL,'YYYYMMDD') TANGGAL
              FROM ZREPORT_DEMAND_PLANNING
              WHERE KODE_PRODUK = 2
                AND ORG = '4000'
            )TB2 ON TB1.ORG = TB2.ORG AND TB1.TANGGAL=TB2.TANGGAL
            LEFT JOIN (
              SELECT ORG, MAX_STOK, MIN_STOK
              FROM ZREPORT_SCM_MINMAX_STOK
              WHERE KODE_PRODUK = 2
                AND ORG = '4000'
            )TB3 ON TB1.ORG = TB3.ORG");

				$realisasi_semen="";
				$min_stock_semen="";
				$max_stock_semen="";
	foreach ($sql_semen->result_array() as $rowID) {
				//$org=$rowID['ORG'];
				$realisasi_semen+=$rowID['REALISASI'];
				// $prognose+=$rowID['PROGNOSE'];
				$max_stock_semen+=$rowID['MAX_STOK'];
				$min_stock_semen+=$rowID['MIN_STOK'];
			}

			$data['Terak']=array(
				// 'org'=>$org,
				//'realisasi'=>$realisasi,
				'prognose'=>$realisasi_terak,
				'max_stock'=>$max_stock_terak,
				'min_stock'=>$min_stock_terak
				);
			$data['Semen']=array(
				// 'org'=>$org,
				//'realisasi'=>$realisasi,
				'prognose'=>$realisasi_semen,
				'max_stock'=>$max_stock_semen,
				'min_stock'=>$min_stock_semen
				);

		echo json_encode($data);

// 		foreach ($sql->result_array() as $rowID) {
// 				//$org=$rowID['ORG'];
// 				//$realisasi=$rowID['REALISASI'];
// 				$prognose=$rowID['PROGNOSE'];
// 				$max_stock=$rowID['MAX_STOK'];
// 				$min_stock=$rowID['MIN_STOK'];
// 				if($rowID['KODE_PRODUK']==1){
// 				$kode_produk='Terak';
// 			}else{
// 				$kode_produk='Semen';
// 			}

// 			$data[$kode_produk]=array(
// 				// 'org'=>$org,
// 				//'realisasi'=>$realisasi,
// 				'prognose'=>$prognose,
// 				'max_stock'=>$max_stock,
// 				'min_stock'=>$min_stock,
// 				);
// 		}

// 		echo json_encode($data);


	}

}

/* End of file m_stokterak.php */
/* Location: ./application/models/m_stokterak.php */