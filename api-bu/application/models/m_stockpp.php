<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_stockpp extends CI_Model {

	public function get_stockpp()
	{
		$db=$this->load->database('default5',true);
		$sql=$db->query("SELECT * FROM (SELECT TB1.ORG,TB1.KODE_PLANT,TB1.NAMA_PLANT,TB1.KAPASITAS,TB2.STOCK_SILO,TB4.JAM_CREATE
                FROM (SELECT ORG,KODE_PLANT,NAMA_PLANT,TYPE,KAPASITAS FROM ZREPORT_PETA_SILOPP )TB1
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
											-- TO_CHAR(TGL_CMPLT,'YYYYMMDD') >= '20161108' AND
											-- TO_CHAR(TGL_CMPLT,'YYYYMMDD') <= '20161115'
											-- GROUP BY PLANT
											-- UNION
											-- SELECT WERKS PLANT, SUM(TON) AS KWANTUMX
											-- FROM ZREPORT_ONGKOSANGKUT_MOD
											-- WHERE VKORG IN ('3000','4000') AND
											-- TO_CHAR(WADAT_IST,'YYYYMMDD') >= '20161108' AND
											-- TO_CHAR(WADAT_IST,'YYYYMMDD') <= '20161115'
											-- GROUP BY WERKS
           --      )TB3
           --      ON TB1.KODE_PLANT=TB3.PLANT
								LEFT JOIN(
											SELECT NMPLAN,JAM_CREATE FROM ZREPORT_STOCK_SILO X
											WHERE JAM_CREATE = (SELECT MAX(jam_create) FROM ZREPORT_STOCK_SILO where NMPLAN = X.NMPLAN)
											GROUP BY NMPLAN,JAM_CREATE 
								)TB4
								ON TB1.KODE_PLANT=TB4.NMPLAN ORDER BY tb1.org) WHERE ORG NOT IN '6000' AND KODE_PLANT != 2404 AND KODE_PLANT != 3301 AND KODE_PLANT != 4301 ");
		foreach ($sql->result_array() as $rowID) {
				$kode_plant=$rowID['KODE_PLANT'];
				$nama_plant=$rowID['NAMA_PLANT'];
				$org=$rowID['ORG'];
				$stock_silo=$rowID['STOCK_SILO'];
				$kapasitas=$rowID['KAPASITAS'];
				//$tipe=$rowID['TIPE'];
				//$kwantumx=$rowID['KWANTUMX'];
				$jam_create=$rowID['JAM_CREATE'];

				$data['s'.$org][]=array(
						'kode_plant'=>$kode_plant,
						'lokasi_plant'=>$nama_plant,
						'opco'=>$org,
						'stock'=>$stock_silo,
						'kapasitas'=>$kapasitas,
						//'kwantumx'=>$kwantumx,
						'jam_update'=>$jam_create
					);
		}
		echo json_encode($data);

	}

}

/* End of file m_stockpp.php */
/* Location: ./application/models/m_stockpp.php */