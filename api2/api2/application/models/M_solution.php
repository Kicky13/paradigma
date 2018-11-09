<?php

class M_Solution Extends DB_QM {
	
	public function datalist(){
		$this->db->order_by("a.ID_SOLUTION");
		return $this->db->get("M_SOLUTION a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NM_SOLUTION",$keyword);
		return $this->db->get("M_SOLUTION")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_SOLUTION")->row();
	}
	
	public function get_data_by_id($ID_SOLUTION){
		$this->db->select("a.*");
		$this->db->where("a.ID_SOLUTION",$ID_SOLUTION);
		return $this->db->get("M_SOLUTION a")->row();
	}
	
	
	public function insert($data){
		//ID
		$this->db->select("SEQ_ID_SOLUTION.NEXTVAL");
		$r  = $this->db->get("DUAL")->row_array(); 
		$ID = $r['NEXTVAL'];
				
		$this->db->set($data);
		$this->db->set("ID_SOLUTION",$ID);
		$this->db->insert("M_SOLUTION");
		return $ID;
	}
	
	public function update($data,$ID_SOLUTION){
		$this->db->set($data);
		$this->db->where("ID_SOLUTION",$ID_SOLUTION);
		$this->db->update("M_SOLUTION");
	}
	
	public function delete($ID_SOLUTION){
		$this->db->where("ID_SOLUTION",$ID_SOLUTION);
		$this->db->delete("M_SOLUTION");
	}


}
