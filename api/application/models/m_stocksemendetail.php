<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_stocksemendetail extends CI_Model {

	public function get_stocksemendetail()
	{
		$tgl_sekarang=date('Ym');
		if(!empty($_GET['bulan'])&&!empty($_GET['tahun'])){
			$bulan=$_GET['bulan'];
			$tahun=$_GET['tahun'];
			$tgl2=$tahun.$bulan;
		}else{
			$tgl2=date('Ym');
		 }
		 
		$db=$this->load->database('default5',true);
		$sql=$db->query("SELECT TB2.REALISASI_PROD,TB3.REALISASI_STOK, TB1.PROG_PRODUK, TB1.RKAP_PRODUK, TB1.PROG_STOK, TB1.MIN_STOK, 
            TB1.MAX_STOK, TB1.TANGGAL
                FROM (SELECT SUM(PROG_PRODUK) PROG_PRODUK, SUM(RKAP_PRODUK) RKAP_PRODUK, SUM(PROG_STOK) PROG_STOK, SUM(MIN_STOK) MIN_STOK, SUM(MAX_STOK) MAX_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_DEMAND_PLANNING 
                    WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2'
                    GROUP BY TANGGAL)TB1
                LEFT JOIN (
                    SELECT SUM(QTY_PROD) REALISASI_PROD, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_REAL_PROD_DEMANDPL 
                    WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2'
                    GROUP BY TANGGAL
                )TB2
                ON TB1.TANGGAL = TB2.TANGGAL
                LEFT JOIN (
                    SELECT SUM(QTY_STOK) REALISASI_STOK, TO_CHAR(TANGGAL,'DD') TANGGAL
                    FROM ZREPORT_REAL_STOK_DEMANDPL 
                    WHERE KODE_PRODUK = 2 AND TO_CHAR(TANGGAL,'YYYYMM') = '$tgl2'
										GROUP BY TANGGAL
                )TB3
                ON TB1.TANGGAL = TB3.TANGGAL ORDER BY TB1.TANGGAL ASC");
		foreach ($sql->result_array() as $rowID) {
				$realisasi_prod=$rowID['REALISASI_PROD'];
				$realisasi_stok=$rowID['REALISASI_STOK'];
				$prog_produk=$rowID['PROG_PRODUK'];
				$rkap_produk=$rowID['RKAP_PRODUK'];
				$prog_stok=$rowID['PROG_STOK'];
				$min_stok=$rowID['MIN_STOK'];
				$max_stok=$rowID['MAX_STOK'];
				$tanggal=$rowID['TANGGAL'];

		$data[$tanggal]=array(
					'realisasi_stok'=>$realisasi_stok,
					'realisasi_prod'=>$realisasi_prod,
					'prog_produk'=>$prog_produk,
					'rkap_produk'=>$rkap_produk,
					'prog_stok'=>$prog_stok,
					'min_stok'=>$min_stok,
					'max_stok'=>$max_stok
			);
		}

		echo '{"Semen":' . json_encode($data) . '}';
	}

}

/* End of file m_stocksemendetailterak.php */
/* Location: ./application/models/m_stocksemendetailterak.php */