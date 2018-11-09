<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_clinker extends CI_Model {

  public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default7', TRUE);
    }

    public function exchange(){
$sql = "select TO_CHAR(tanggal,'YYYYMMDD') tanggal, company,plant,c3s
from CLINKER
where company in ('7000','5000')
order by company asc";		
		
$data = $this->db->query($sql);
        return $data->result();
		//echo "test";
	
    }
	public function exchange_usd(){
$sqlusd = "";

$data_usd = $this->db->query($sqlusd);
        return $data_usd->result_array();
	}

  
}        