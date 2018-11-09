<?php

class M_User_Level Extends DB_QM {
	
	public function datalist(){
		$this->db->order_by("a.ID_LEVEL_USER");
		return $this->db->get("M_LEVEL_USER a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NM_LEVEL_USER",$keyword);
		return $this->db->get("M_LEVEL_USER")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_LEVEL_USER")->row();
	}
	
	public function get_data_by_id($ID_LEVEL_USER){
		$this->db->where("ID_LEVEL_USER",$ID_LEVEL_USER);
		return $this->db->get("M_LEVEL_USER")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_LEVEL_USER !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_LEVEL_USER")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_LEVEL_USER","SEQ_ID_LEVEL_USER.NEXTVAL",FALSE);
		$this->db->insert("M_LEVEL_USER");
	}
	
	public function update($data,$ID_LEVEL_USER){
		$this->db->set($data);
		$this->db->where("ID_LEVEL_USER",$ID_LEVEL_USER);
		$this->db->update("M_LEVEL_USER");
	}
	
	public function delete($ID_LEVEL_USER){
		$this->db->where("ID_LEVEL_USER",$ID_LEVEL_USER);
		$this->db->delete("M_LEVEL_USER");
	}
	

}
