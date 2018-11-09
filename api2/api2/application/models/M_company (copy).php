<?php

class M_Company Extends DB_QM {
	
	public function datalist(){
		$this->db->order_by("a.ID_COMPANY");
		return $this->db->get("M_COMPANY a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NM_COMPANY",$keyword);
		return $this->db->get("M_COMPANY")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_COMPANY")->row();
	}
	
	public function get_data_by_id($ID_COMPANY){
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		return $this->db->get("M_COMPANY")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_COMPANY !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_COMPANY")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_COMPANY","SEQ_ID_COMPANY.NEXTVAL",FALSE);
		$this->db->insert("M_COMPANY");
	}
	
	public function update($data,$ID_COMPANY){
		$this->db->set($data);
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->update("M_COMPANY");
	}
	
	public function delete($ID_COMPANY){
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->delete("M_COMPANY");
	}
	

}
