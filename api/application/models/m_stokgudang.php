<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_stokgudang extends CI_Model {

	public function get_stokgudang()
	{
		$db=$this->load->database('default6',true);
		$sql=$db->query("SELECT crm_gudang.kd_distr, crm_gudang.kd_distrik, nm_distrik, kd_provinsi, crm_gudang.kd_gdg,  crm_gudang.org, crm_gudang.area, 
                                    crm_gudang.nm_gdg, nvl(crm_gudang.unloading_rate_ton,0) load_truk, stok, STOK_GDG_AVG.AVGSTOK, ((crm_gudang.kapasitas*40)/1000) as kapasitas, NVL(to_char(last_update,'yyyy/mm/dd'),'1970/12/12') as TGL_UPDATE, last_update, 
                                    round((stok/((crm_gudang.kapasitas*40)/1000)), 2)*100 STOK_LEVEL, LATITUDE, LONGITUDE, NM_DISTR, NVL(RILIS_GDG_AVG.QTY_RILIS,0) QTY_RILIS
                                    FROM
                                      (SELECT * FROM crm_gudang WHERE DELETE_MARK=0 AND LATITUDE IS NOT NULL AND LONGITUDE IS NOT NULL) CRM_GUDANG
                                    LEFT JOIN
                                      (
                                        select KODE_SHIPTO as KD_GDG, NAMA_SHIPTO as NM_GDG,
                                        QTY_STOK as STOK, LAST_UPDATEOLDF as last_update, '' as kd_material,0 as delete_mark
                                        from CRM_GUDANG_SERVICEM
                                      ) stok_gdg ON (stok_gdg.kd_gdg = crm_gudang.kd_gdg)
                                    LEFT JOIN 
                                      (
                                        SELECT kode_distrik as kd_distrik, distrik as nm_distrik, kode_provinsi as kd_provinsi from PT_MASTER_DISTRIK
                                      ) MASTER_DISTRIK on (CRM_GUDANG.kd_distrik = MASTER_DISTRIK.kd_distrik)
                                      LEFT JOIN
                                      (
                                        select KODE_SHIPTO AS KD_GDG, SUM(QTY_STOK) AS AVGSTOK
                                        from CRM_GUDANG_SERVICE where org='7000' AND TGL_RILIS = (SELECT TO_CHAR(CURRENT_DATE - INTERVAL '7' DAY,'DD-MON-YY') FROM DUAL) 
                                        GROUP BY KODE_SHIPTO
                                      ) STOK_GDG_AVG ON (STOK_GDG_AVG.KD_GDG = CRM_GUDANG.KD_GDG)
                                        LEFT JOIN
                                        (
                                        SELECT KODE_SHIPTO, SUM(QTY_RILIS) QTY_RILIS 
                                            FROM CRM_GUDANG_SERVICE
                                            WHERE TO_CHAR(TGL_RILIS,'YYYYMMDD') <= (SELECT TO_CHAR(CURRENT_DATE,'YYYYMMDD') FROM DUAL)
                                            AND TO_CHAR(TGL_RILIS,'YYYYMMDD') >= (SELECT TO_CHAR(CURRENT_DATE - INTERVAL '7' DAY,'YYYYMMDD') FROM DUAL)
                                            GROUP BY KODE_SHIPTO
                                        ) RILIS_GDG_AVG
                                        ON RILIS_GDG_AVG.KODE_SHIPTO = CRM_GUDANG.KD_GDG");

		// echo json_encode($sql->result_array());
	foreach ($sql->result_array() as $rowID) {
		$KD_DISTR=$rowID['KD_DISTR'];
		$KD_DISTRIK=$rowID['KD_DISTRIK'];
		$NM_DISTRIK=$rowID['NM_DISTRIK'];
		$KD_PROVINSI=$rowID['KD_PROVINSI'];
		$KD_GDG=$rowID['KD_GDG'];
		$ORG=$rowID['ORG'];
		$AREA=$rowID['AREA'];
		$NM_GDG=$rowID['NM_GDG'];
		$LOAD_TRUK=$rowID['LOAD_TRUK'];
		$STOK=$rowID['STOK'];
		$AVGSTOK=$rowID['AVGSTOK'];
		$KAPASITAS=$rowID['KAPASITAS'];
		$TGL_UPDATE=$rowID['TGL_UPDATE'];
		$LAST_UPDATE=$rowID['LAST_UPDATE'];
		$STOK_LEVEL=$rowID['STOK_LEVEL'];
		$LATITUDE=$rowID['LATITUDE'];
		$LONGITUDE=$rowID['LONGITUDE'];
		$NM_DISTR=$rowID['NM_DISTR'];
		$QTY_RILIS=$rowID['QTY_RILIS'];

		$data[]=array(	//'KD_DISTR'=>$KD_DISTR,
						//'KD_DISTRIK'=>$KD_DISTRIK,
						'NM_DISTRIK'=>$NM_DISTRIK,
						//'KD_PROVINSI'=>$KD_PROVINSI,
						'KD_GDG'=>$KD_GDG,
						'ORG'=>$ORG,
						'AREA'=>$AREA,
						'NM_GDG'=>$NM_GDG,
						'LOAD_TRUK'=>$LOAD_TRUK,
						'STOK'=>$STOK,
						'AVGSTOK'=>$AVGSTOK,
						'KAPASITAS'=>$KAPASITAS,
						//'TGL_UPDATE'=>$TGL_UPDATE,
						//'LAST_UPDATE'=>$LAST_UPDATE,
						'STOK_LEVEL'=>$STOK_LEVEL,
						'LATITUDE'=>$LATITUDE,
						'LONGITUDE'=>$LONGITUDE,
						'NM_DISTR'=>$NM_DISTR,
						'QTY_RILIS'=>$QTY_RILIS);
	}

	echo '{"smig":'.json_encode($data).'}';
	}
}

/* End of file m_stokgudang.php */
/* Location: ./application/models/m_stokgudang.php */