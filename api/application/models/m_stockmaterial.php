<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_materialstock extends CI_Model {

    public function get_data_po() {
        $db = $this->load->database('default6', true);
        $sql = $db->query("SELECT
	SUM(PO.BRTWR) AS POVAL,
	SUM(PO.MENGE) AS POQTY
from TB_N_MATSGG B
LEFT JOIN TB_STR_PO PO ON B.MATNUM = PO.MATNR
where 
SUBSTR(PO.BEDAT, 0, 4) = '2016'
AND SUBSTR(PO.BEDAT, 5, 2) in ('01','02','03','04','05','06','07','08','09','10','11','12')");
    }

    public function get_data_rkap() {
        $sql = $db->query("select SUM (RKAP.VAL) AS rkapval,
	SUM (RKAP.QTY) AS rkapqty
from TB_N_MATSGG B
LEFT JOIN TB_N_RKAPSGG RKAP ON B.GRP = RKAP.GRP
where
RKAP.YRS = '2016'
AND RKAP.MTH = '1'");

        echo json_encode($data);
    }

    public function get_data_gr() {
        $sql = $db->query("select SUM (GR.DMBTR) AS GRQTY,
SUM (GR.MENGE) AS GRVAL
from TB_N_MATSGG B
LEFT JOIN TB_MKPF_MSEG GR ON B.MATNUM = GR.MATNR
where GR.MJAHR = '2016'
AND SUBSTR (GR.BUDAT, 5, 2) = '01'
AND GR.BLART = 'WE'");


        echo json_encode($data);
    }
}