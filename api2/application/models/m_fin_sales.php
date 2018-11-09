<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_fin_sales extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }
	public function get_rev_perform($comp, $date, $cat, $des){
		$data=$this->db->query("SELECT SUM(AMOUNT) AS JML
					FROM MW_KPP
					WHERE JENIS ='$cat'
					AND COMPANY='$comp'
					AND DES = '$des'
					AND FISCAL_YEAR_PERIOD IN ($date)");
		return $data->row();
	}
	
	public function get_vol_perform($comp, $date, $cat, $des){
		$data=$this->db->query("SELECT SUM(AMOUNT) AS JML
					FROM MW_KPV
					WHERE JENIS ='$cat'
					AND COMPANY='$comp'
					AND DES = '$des'
					AND FISCAL_YEAR_PERIOD IN ($date)");
		return $data->row();
	}
}

/* End of file m_cost_structure.php */
/* Location: ./application/models/m_cost_structure.php */