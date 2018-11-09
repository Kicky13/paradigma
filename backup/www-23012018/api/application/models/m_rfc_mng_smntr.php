<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_rfc_mng_smntr extends CI_Model {

  public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default7', TRUE);
    }

    public function nampil_text(){
    //     echo "string";
    }

  
    public function get_tabeldata($comp,$date){
    	// echo $comp;
    	IF($comp == "smi"){
    		$sql = "SELECT 
										SUM(NVL(\"Total\", 0)) AS TOTAL_PIUTANG,
										SUM(NVL(\"Belum_Tempo\", 0)) AS AKAN_TEMPO,
										SUM(NVL(\"Jatuh1_30\", 0)) AS TEMPO1_30,
										SUM(NVL(\"Jatuh31_60\", 0))AS TEMPO31_60,
										SUM(NVL(\"Jatuh61_120\", 0)) AS TEMPO61_120,
										SUM(NVL(\"Jatuh121_360\", 0)) AS TEMPO121_360,
										SUM(NVL(\"Jatuh361_720\", 0)) AS TEMPO361_720,
										SUM(NVL(\"Jatuh721_999\", 0)) AS TEMPO721_999,
										SUM(NVL(\"Lebih999\", 0))AS TEMPO999,
										SUM(NVL(\"Penyisih_Piutang\", 0)) AS P_PIUTANG,
										SUM(NVL(\"Piutang_Bersih\", 0))AS P_BERSIH,
										SUM(NVL(\"Rasio_Piutang\", 0)) AS R_PIUTANG,
										SUM(NVL(\"Penj_Bln_Jln\", 0))AS P_BLN_JLN
										FROM 
										PIUTANG_AGING
										WHERE \"Datum\" IN ('$date')";

          //   $data = $this->db->query("SELECT 
										// SUM(NVL(\"Total\", 0)) AS TOTAL_PIUTANG,
										// SUM(NVL(\"Belum_Tempo\", 0)) AS AKAN_TEMPO,
										// SUM(NVL(\"Jatuh1_30\", 0)) AS TEMPO1_30,
										// SUM(NVL(\"Jatuh31_60\", 0))AS TEMPO31_60,
										// SUM(NVL(\"Jatuh61_120\", 0)) AS TEMPO61_120,
										// SUM(NVL(\"Jatuh121_360\", 0)) AS TEMPO121_360,
										// SUM(NVL(\"Jatuh361_720\", 0)) AS TEMPO361_720,
										// SUM(NVL(\"Jatuh721_999\", 0)) AS TEMPO721_999,
										// SUM(NVL(\"Lebih999\", 0))AS TEMPO999,
										// SUM(NVL(\"Penyisih_Piutang\", 0)) AS P_PIUTANG,
										// SUM(NVL(\"Piutang_Bersih\", 0))AS P_BERSIH,
										// SUM(NVL(\"Rasio_Piutang\", 0)) AS R_PIUTANG,
										// SUM(NVL(\"Penj_Bln_Jln\", 0))AS P_BLN_JLN
										// FROM 
										// PIUTANG_AGING
										// WHERE \"Datum\" IN ('$date')");
        }else{
        	$sql = "SELECT 
										SUM(NVL(\"Total\", 0)) AS TOTAL_PIUTANG,
										SUM(NVL(\"Belum_Tempo\", 0)) AS AKAN_TEMPO,
										SUM(NVL(\"Jatuh1_30\", 0)) AS TEMPO1_30,
										SUM(NVL(\"Jatuh31_60\", 0))AS TEMPO31_60,
										SUM(NVL(\"Jatuh61_120\", 0)) AS TEMPO61_120,
										SUM(NVL(\"Jatuh121_360\", 0)) AS TEMPO121_360,
										SUM(NVL(\"Jatuh361_720\", 0)) AS TEMPO361_720,
										SUM(NVL(\"Jatuh721_999\", 0)) AS TEMPO721_999,
										SUM(NVL(\"Lebih999\", 0))AS TEMPO999,
										SUM(NVL(\"Penyisih_Piutang\", 0)) AS P_PIUTANG,
										SUM(NVL(\"Piutang_Bersih\", 0))AS P_BERSIH,
										SUM(NVL(\"Rasio_Piutang\", 0)) AS R_PIUTANG,
										SUM(NVL(\"Penj_Bln_Jln\", 0))AS P_BLN_JLN
										FROM 
										PIUTANG_AGING
										WHERE \"Datum\" IN ('$date')
										AND \"Company\" IN ('$comp')";

          //   $data = $this->db->query("SELECT 
										// SUM(NVL(\"Total\", 0)) AS TOTAL_PIUTANG,
										// SUM(NVL(\"Belum_Tempo\", 0)) AS AKAN_TEMPO,
										// SUM(NVL(\"Jatuh1_30\", 0)) AS TEMPO1_30,
										// SUM(NVL(\"Jatuh31_60\", 0))AS TEMPO31_60,
										// SUM(NVL(\"Jatuh61_120\", 0)) AS TEMPO61_120,
										// SUM(NVL(\"Jatuh121_360\", 0)) AS TEMPO121_360,
										// SUM(NVL(\"Jatuh361_720\", 0)) AS TEMPO361_720,
										// SUM(NVL(\"Jatuh721_999\", 0)) AS TEMPO721_999,
										// SUM(NVL(\"Lebih999\", 0))AS TEMPO999,
										// SUM(NVL(\"Penyisih_Piutang\", 0)) AS P_PIUTANG,
										// SUM(NVL(\"Piutang_Bersih\", 0))AS P_BERSIH,
										// SUM(NVL(\"Rasio_Piutang\", 0)) AS R_PIUTANG,
										// SUM(NVL(\"Penj_Bln_Jln\", 0))AS P_BLN_JLN
										// FROM 
										// PIUTANG_AGING
										// WHERE \"Datum\" IN ('$date')
										// AND \"Company\" IN ('$comp')");
        }
        // echo $sql;
        $data = $this->db->query($sql);
        return $data->row();
	}   

	public function get_tabeldataprev($comp,$dateprev){
		// echo $comp;
    	IF($comp == "smi"){
    		$sql = "SELECT 
										SUM(NVL(\"Total\", 0)) AS TOTAL_PIUTANG,
										SUM(NVL(\"Belum_Tempo\", 0)) AS AKAN_TEMPO,
										SUM(NVL(\"Jatuh1_30\", 0)) AS TEMPO1_30,
										SUM(NVL(\"Jatuh31_60\", 0))AS TEMPO31_60,
										SUM(NVL(\"Jatuh61_120\", 0)) AS TEMPO61_120,
										SUM(NVL(\"Jatuh121_360\", 0)) AS TEMPO121_360,
										SUM(NVL(\"Jatuh361_720\", 0)) AS TEMPO361_720,
										SUM(NVL(\"Jatuh721_999\", 0)) AS TEMPO721_999,
										SUM(NVL(\"Lebih999\", 0))AS TEMPO999,
										SUM(NVL(\"Penyisih_Piutang\", 0)) AS P_PIUTANG,
										SUM(NVL(\"Piutang_Bersih\", 0))AS P_BERSIH,
										SUM(NVL(\"Rasio_Piutang\", 0)) AS R_PIUTANG,
										SUM(NVL(\"Penj_Bln_Jln\", 0))AS P_BLN_JLN
										FROM 
										PIUTANG_AGING
										WHERE \"Datum\" IN ('$dateprev')";

          //   $data = $this->db->query("SELECT 
										// SUM(NVL(\"Total\", 0)) AS TOTAL_PIUTANG,
										// SUM(NVL(\"Belum_Tempo\", 0)) AS AKAN_TEMPO,
										// SUM(NVL(\"Jatuh1_30\", 0)) AS TEMPO1_30,
										// SUM(NVL(\"Jatuh31_60\", 0))AS TEMPO31_60,
										// SUM(NVL(\"Jatuh61_120\", 0)) AS TEMPO61_120,
										// SUM(NVL(\"Jatuh121_360\", 0)) AS TEMPO121_360,
										// SUM(NVL(\"Jatuh361_720\", 0)) AS TEMPO361_720,
										// SUM(NVL(\"Jatuh721_999\", 0)) AS TEMPO721_999,
										// SUM(NVL(\"Lebih999\", 0))AS TEMPO999,
										// SUM(NVL(\"Penyisih_Piutang\", 0)) AS P_PIUTANG,
										// SUM(NVL(\"Piutang_Bersih\", 0))AS P_BERSIH,
										// SUM(NVL(\"Rasio_Piutang\", 0)) AS R_PIUTANG,
										// SUM(NVL(\"Penj_Bln_Jln\", 0))AS P_BLN_JLN
										// FROM 
										// PIUTANG_AGING
										// WHERE \"Datum\" IN ('$dateprev')");
        }else{
        	$sql = "SELECT 
										SUM(NVL(\"Total\", 0)) AS TOTAL_PIUTANG,
										SUM(NVL(\"Belum_Tempo\", 0)) AS AKAN_TEMPO,
										SUM(NVL(\"Jatuh1_30\", 0)) AS TEMPO1_30,
										SUM(NVL(\"Jatuh31_60\", 0))AS TEMPO31_60,
										SUM(NVL(\"Jatuh61_120\", 0)) AS TEMPO61_120,
										SUM(NVL(\"Jatuh121_360\", 0)) AS TEMPO121_360,
										SUM(NVL(\"Jatuh361_720\", 0)) AS TEMPO361_720,
										SUM(NVL(\"Jatuh721_999\", 0)) AS TEMPO721_999,
										SUM(NVL(\"Lebih999\", 0))AS TEMPO999,
										SUM(NVL(\"Penyisih_Piutang\", 0)) AS P_PIUTANG,
										SUM(NVL(\"Piutang_Bersih\", 0))AS P_BERSIH,
										SUM(NVL(\"Rasio_Piutang\", 0)) AS R_PIUTANG,
										SUM(NVL(\"Penj_Bln_Jln\", 0))AS P_BLN_JLN
										FROM 
										PIUTANG_AGING
										WHERE \"Company\" IN ('$comp')
										AND \"Datum\" IN ('$dateprev')";
          //   $data = $this->db->query("SELECT 
										// SUM(NVL(\"Total\", 0)) AS TOTAL_PIUTANG,
										// SUM(NVL(\"Belum_Tempo\", 0)) AS AKAN_TEMPO,
										// SUM(NVL(\"Jatuh1_30\", 0)) AS TEMPO1_30,
										// SUM(NVL(\"Jatuh31_60\", 0))AS TEMPO31_60,
										// SUM(NVL(\"Jatuh61_120\", 0)) AS TEMPO61_120,
										// SUM(NVL(\"Jatuh121_360\", 0)) AS TEMPO121_360,
										// SUM(NVL(\"Jatuh361_720\", 0)) AS TEMPO361_720,
										// SUM(NVL(\"Jatuh721_999\", 0)) AS TEMPO721_999,
										// SUM(NVL(\"Lebih999\", 0))AS TEMPO999,
										// SUM(NVL(\"Penyisih_Piutang\", 0)) AS P_PIUTANG,
										// SUM(NVL(\"Piutang_Bersih\", 0))AS P_BERSIH,
										// SUM(NVL(\"Rasio_Piutang\", 0)) AS R_PIUTANG,
										// SUM(NVL(\"Penj_Bln_Jln\", 0))AS P_BLN_JLN
										// FROM 
										// PIUTANG_AGING
										// WHERE \"Company\" IN ('$comp')
										// AND \"Datum\" IN ('$dateprev')");
        }
        // echo $sql;
        $data = $this->db->query($sql);
        return $data->row();
	}        


}
