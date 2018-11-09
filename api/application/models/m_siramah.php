<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_siramah extends CI_Model {

  public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default7', TRUE);
    }

    public function aspek_a(){
$sqla = "";		
		
$data = $this->db->query($sqla);
        return $data->result();
		//echo "test";
	
    }
	public function aspek_b(){
$sqlb = "";

$data_usd = $this->db->query($sqlb);
        return $data_usd->result_array();
	}

  
}        