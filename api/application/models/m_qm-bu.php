<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_qm extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('qm', TRUE);
    }

	public function get_total_siramah($comp, $month, $year){
		$data=$this->db->query("SELECT AVG(NILAI_ASPEK) AS TOTAL 
			FROM T_SKORING_RAMAH 
			WHERE ID_COMPANY = '$comp' 
			AND DATE_INSERT = TO_DATE('$year-$month-01', 'YYYY-MM-DD')");
			
		return $data->result();
	}
	public function get_action_siramah($comp, $month, $year){
		$data=$this->db->query("SELECT
				T_SKORING_RAMAH.*, M_INDIKATOR.CATATAN
			FROM
				T_SKORING_RAMAH
			INNER JOIN M_INDIKATOR ON M_INDIKATOR.ID_BATASAN = T_SKORING_RAMAH.ID_BATASAN AND M_INDIKATOR.SKOR = T_SKORING_RAMAH.NILAI_SKORING
			WHERE
				ID_COMPANY = '$comp'
			AND DATE_INSERT = TO_DATE ('$year-$month-01', 'YYYY-MM-DD')
			AND (T_SKORING_RAMAH.NILAI_SKORING = '1' OR T_SKORING_RAMAH.NILAI_SKORING = '2')");
			
		return $data->result();
	}
	public function get_action_siramah_report(){
		$data=$this->db->query("SELECT
			A.KRITERIA,
			B.BATASAN
		FROM
			M_KRITERIA A
		LEFT JOIN M_BATASAN B ON B.ID_KRITERIA = A.ID_KRITERIA");
			
		return $data->result();
	}
}
