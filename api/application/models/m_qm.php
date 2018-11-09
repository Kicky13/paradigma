<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_qm extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('oramso', TRUE);
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
	public function avg_score_ncqr($year){
		$s = "SELECT a.ID_COMPANY,a.NM_COMPANY,((SELECT sum(b.SCORE) FROM V_INCIDENT b WHERE a.ID_COMPANY=b.ID_COMPANY AND TO_CHAR(b.TANGGAL) LIKE '%-$year%')/(SELECT COUNT(b.ID_INCIDENT) FROM V_INCIDENT b WHERE a.ID_COMPANY=b.ID_COMPANY AND TO_CHAR(b.TANGGAL) LIKE '%-$year%')) AS AVG_SCORE FROM m_company a WHERE a.KD_COMPANY !=2000";
		$q = $this->db->query($s);
		return $q->result();
	}
	public function get_dashboard($opco, $year){
		$bln=0;
		if($year<date('y')){
			for($month=1;$month<=12;$month++){
				if($month<=9){
					$month = '0'.$month;
				}
				$bulan = strtoupper(date('M', strtotime($year."-".$month . '-01')));
				$data[$bln] = $this->ncqr($opco, $bulan, $year);
				$bln++;
			}
		}else{
			for($month=1;$month<=date('n');$month++){
				$bulan = strtoupper(date('M', strtotime($year."-".$month . '-01')));
				$data[$bln] = $this->ncqr($opco, $bulan, $year);
				$bln++;
			}
		}
		return $data;
	}
	private function ncqr($opco, $month ,$year){
		$r['TOTAL']  = (int)$this->n_total($opco, $month, $year);
		$r['BARU']   = (int)$this->n_baru($opco, $month, $year);
		$r['PROSES'] = (int)$this->n_proses($opco, $month, $year);
		$r['SOLVED'] = (int)$this->n_solved($opco, $month, $year);
		return $r;
	}
	private function n_total($ID_COMPANY, $MONTH, $YEAR){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("TO_CHAR(TANGGAL) LIKE '%-$MONTH-$YEAR%'");
		return $this->db->get("V_INCIDENT")->row()->JML;
	}
	private function n_baru($ID_COMPANY, $MONTH, $YEAR){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("DATE_SOLUTION IS NULL",NULL,FALSE);
		$this->db->where("TO_CHAR(TANGGAL) LIKE '%-$MONTH-$YEAR%'");
		return $this->db->get("V_INCIDENT")->row()->JML;
	}
	private function n_proses($ID_COMPANY, $MONTH, $YEAR){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("DATE_SOLUTION IS NOT NULL",NULL,FALSE);
		$this->db->where("ID_SOLUTION IS NULL",NULL,FALSE);
		$this->db->where("TO_CHAR(TANGGAL) LIKE '%-$MONTH-$YEAR%'");
		return $this->db->get("V_INCIDENT")->row()->JML;
	}
	private function n_solved($ID_COMPANY, $MONTH, $YEAR){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("ID_SOLUTION IS NOT NULL",NULL,FALSE);
		$this->db->where("TO_CHAR(TANGGAL) LIKE '%-$MONTH-$YEAR%'");
		return $this->db->get("V_INCIDENT")->row()->JML;
	}
}
