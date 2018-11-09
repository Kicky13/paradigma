<?php

class M_hebat_report extends DB_QM {
	
	public function calculate_qaf_cement($year,$id_company){
		$this->db->query("call QAF_CEMENT_YEARLY(?,?)",array($year,$id_company));
	}
	
	public function calculate_qaf_cs($year,$id_company){
		$this->db->query("call QAF_CS_YEARLY(?,?)",array($year,$id_company));
	}
	
	public function calculate_qaf_st($year,$id_company){
		$this->db->query("call QAF_ST_YEARLY(?,?)",array($year,$id_company));
	}
	
	public function qaf_cement_progress($company, $tahun){
		$this->db->select('ID_COMPANY, TAHUN, BULAN, TOTAL_QAF AS NILAI');
		$this->db->from('V_QAF_CEMENT_PROGRESS');
		$this->db->where('ID_COMPANY', $company);
		$this->db->where('TAHUN', $tahun);
		$this->db->order_by('BULAN');
		$query = $this->db->get();
		return $query->result();
	}

	public function qaf_clinker_progress($company, $tahun){
		$this->db->select('ID_COMPANY, TAHUN, BULAN, TOTAL_QAF AS NILAI');
		$this->db->from('V_QAF_CLINKER_PROGRESS');
		$this->db->where('ID_COMPANY', $company);
		$this->db->where('TAHUN', $tahun);
		$this->db->order_by('BULAN');
		$query = $this->db->get();
		return $query->result();
	}

	public function qaf_st($company, $tahun){
		$this->db->select('ID_COMPANY, TAHUN, BULAN, TOTAL_QAF AS NILAI');
		$this->db->from('V_QAF_ST');
		$this->db->where('ID_COMPANY', $company);
		$this->db->where('TAHUN', $tahun);
		$this->db->order_by('BULAN');
		$query = $this->db->get();
		return $query->result();
	}

	public function qaf_cs($company, $tahun){
		$this->db->select('ID_COMPANY, TAHUN, BULAN, TOTAL_QAF AS NILAI');
		$this->db->from('V_QAF_CS');
		$this->db->where('ID_COMPANY', $company);
		$this->db->where('TAHUN', $tahun);
		$this->db->order_by('BULAN');
		$query = $this->db->get();
		return $query->result();
	}

	public function score_input_cement($company, $tahun){
		$this->db->select('ID_COMPANY, TAHUN, BULAN, SCORE AS NILAI');
		$this->db->from('V_SCORE_INPUT_CEMENT');
		$this->db->where('ID_COMPANY', $company);
		$this->db->where('TAHUN', $tahun);
		$this->db->order_by('BULAN');
		$query = $this->db->get();
		return $query->result();
	}

	public function score_input_production($company, $tahun){
		$this->db->select('ID_COMPANY, TAHUN, BULAN, SCORE AS NILAI');
		$this->db->from('V_SCORE_INPUT_PRODUCTION');
		$this->db->where('ID_COMPANY', $company);
		$this->db->where('TAHUN', $tahun);
		$this->db->order_by('BULAN');
		$query = $this->db->get();
		return $query->result();
	}

	public function score_ncqr($company, $tahun){
		$this->db->select('ID_COMPANY, TAHUN, BULAN, SCORE AS NILAI');
		$this->db->from('V_SCORE_NCQR');
		$this->db->where('ID_COMPANY', $company);
		$this->db->where('TAHUN', $tahun);
		$this->db->order_by('BULAN');
		$query = $this->db->get();
		return $query->result();
	}

	public function v_skoring_hebat($aspek='ALL', $bulan=6, $tahun=2017){
		if($aspek != 'ALL') $this->db->where('ID_ASPEK', $aspek);
		$this->db->where('BULAN', $bulan);
		$this->db->where('TAHUN', $tahun);
		$this->db->order_by('BULAN');
		$query = $this->db->get('V_SKORING_HEBAT');
		return $query->result();
	}

}

