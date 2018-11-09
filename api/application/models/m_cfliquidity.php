<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_cfliquidity extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }

    public function get_data_all($comp, $tgl) {
        $query = ""; $kolom = "";
        for ($i = 0; $i < count($tgl); $i++) {
           for($j = 0; $j < count($comp); $j++){
               $company = $comp[$j]['COMPANY'];
               $desc    = str_replace('.', '', $comp[$j]['DESCRIPTION']);
               $query = $query."SELECT $company AS ID, '$desc' AS JENIS, '$tgl[$i]' AS TANGGAL, DISPW, WRSHB AS JUMLAH FROM FDSB
                        WHERE BUKRS = '$company'
                        AND DATUM <= '$tgl[$i]'
                        UNION ALL
                        SELECT $company AS ID, '$desc' AS JENIS, '$tgl[$i]' AS TANGGAL, DISPW, WRSHB AS JUMLAH FROM FDSR
                        WHERE BUKRS = '$company'
                        AND DATUM <= '$tgl[$i]'
                        UNION ALL ";
            }
            $kolom = $kolom."$tgl[$i], ";
        }
        $query = rtrim($query,"UNION ALL ");
        $kolom = rtrim($kolom,", ");

        return $this->db->query("
        SELECT * FROM (
                    SELECT 'ALL.'|| KA.ID AS ID, KA.JENIS, KA.TANGGAL, 
                        CASE WHEN KA.DISPW = 'IDR' OR KA.DISPW = 'JPY' OR KA.DISPW = 'VND'
                        THEN ROUND(SUM((KA.JUMLAH*100)*NVL(MER.UKURS,1))) 
                        ELSE ROUND(SUM((KA.JUMLAH)*NVL(MER.UKURS,1))) 
                        END AS JUMLAH FROM (
                        SELECT ID, JENIS, TANGGAL, DISPW, SUM(JUMLAH) AS JUMLAH FROM (
                            $query
                        )
                        WHERE JUMLAH != 0
                        GROUP BY JENIS, TANGGAL, DISPW, ID
                        ) KA
                        LEFT JOIN M_EXCHANGE_RATE MER
                        ON KA.DISPW = MER.FCURR AND KA.TANGGAL = MER.GDATU
                        GROUP BY KA.ID, KA.JENIS, KA.TANGGAL, KA.DISPW
                    )
                PIVOT (
                        SUM(JUMLAH) FOR (TANGGAL) IN (
                            $kolom
                        )
                )
                ORDER BY ID
        ")
                        ->result_array();
    }

    public function get_data($comp, $tgl) {
        $query = ""; $kolom = "";
        for ($i = 0; $i < count($tgl); $i++) {
            $query = $query."SELECT DISPW AS JENIS, '$tgl[$i]' AS TANGGAL, WRSHB AS JUMLAH FROM FDSB
                        WHERE BUKRS = '$comp'
                        AND DATUM <= '$tgl[$i]'
                        UNION ALL
                        SELECT DISPW AS JENIS, '$tgl[$i]' AS TANGGAL, WRSHB AS JUMLAH FROM FDSR
                        WHERE BUKRS = '$comp'
                        AND DATUM <= '$tgl[$i]'
                        UNION ALL ";
            
            $kolom = $kolom."$tgl[$i], ";
        }
        $query = rtrim($query,"UNION ALL ");
        $kolom = rtrim($kolom,", ");
        
        return $this->db->query("
        SELECT * FROM (
                    SELECT '2.' || '$comp.' || JENIS AS ID, JENIS, TANGGAL, CASE WHEN JENIS = 'IDR' OR JENIS = 'JPY' OR JENIS = 'VND' THEN ROUND(SUM(JUMLAH)*100) ELSE ROUND(SUM(JUMLAH)) END AS JUMLAH FROM (
                        $query
                    )
                    WHERE JUMLAH != 0
                    GROUP BY JENIS, TANGGAL
                    )
                    PIVOT (
                            SUM(JUMLAH) FOR (TANGGAL) IN (
                                $kolom
                            )
                    )
                    ORDER BY JENIS
        ")
                        ->result_array();
    }
    public function get_kurs($tgl) {
        $data=$this->db->query("SELECT FCURR AS CURRENCY, GDATU AS TANGGAL, UKURS AS KURS FROM M_EXCHANGE_RATE WHERE GDATU LIKE ('%$tgl%') GROUP BY UKURS, GDATU, FCURR ORDER BY GDATU");
        return $data->result();
    }
}

/* End of file m_cfliquidity.php */
/* Location: ./application/models/m_cfliquidity.php */