<?php

class M_cp Extends DB_QM {
	
	public function datalist(){
		$this->db->order_by("ID_PARAMETER");
		return $this->db->get("D_PARAMETER")->result();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->insert("C_PARAMETER");
	}

	

}
