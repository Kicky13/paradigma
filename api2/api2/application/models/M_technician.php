<?php

class M_Technician Extends DB_QM {
	
	public function datalist(){
		$this->db->order_by("a.ID_TEKNISI");
		return $this->db->get("M_TEKNISI a")->result();
	}
	
	public function list_technician(){
		$this->db->where("a.KD_TEKNISI !=","2000");
		$this->db->order_by("a.ID_TEKNISI");
		return $this->db->get("M_TEKNISI a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NM_TEKNISI",$keyword);
		return $this->db->get("M_TEKNISI")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_TEKNISI")->row();
	}
	
	public function get_data_by_id($ID_TEKNISI){
		$this->db->where("ID_TEKNISI",$ID_TEKNISI);
		return $this->db->get("M_TEKNISI")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_TEKNISI !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_TEKNISI")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_TEKNISI","SEQ_ID_TEKNISI.NEXTVAL",FALSE);
		$this->db->insert("M_TEKNISI");
	}
	
	public function update($data,$ID_TEKNISI){
		$this->db->set($data);
		$this->db->where("ID_TEKNISI",$ID_TEKNISI);
		$this->db->update("M_TEKNISI");
	}
	
	public function delete($ID_TEKNISI){
		$this->db->where("ID_TEKNISI",$ID_TEKNISI);
		$this->db->delete("M_TEKNISI");
	}
	

}
