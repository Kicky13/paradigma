<?php

class M_Level Extends DB_GOHELPS {
	
	public function datalist(){
		$this->db->select("a.*, count(b.ID_USER) as JML_USER");
		$this->db->join("m_users b","a.ID_LEVEL=b.ID_LEVEL","left");
		$this->db->group_by("a.ID_LEVEL");
		return $this->db->get("m_level a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NM_LEVEL",$keyword);
		return $this->db->get("m_level")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("m_level")->row();
	}
	
	public function get_by_id($ID_LEVEL){
		$this->db->select("m_level.*, count(m_users.id_level) as JML_USER");
		$this->db->where("m_level.ID_LEVEL",$ID_LEVEL);
		$this->db->join("m_users","m_level.ID_LEVEL=m_users.ID_LEVEL","left");
		$this->db->group_by("m_level.ID_LEVEL");
		return $this->db->get("m_level")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_LEVEL !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("m_level")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->insert("m_level");
	}
	
	public function update($data,$id){
		$this->db->set($data);
		$this->db->where("ID_LEVEL",$id);
		$this->db->update("m_level");
	}
	
	public function delete($ID_LEVEL){
		$this->db->where("ID_LEVEL",$ID_LEVEL);
		$this->db->delete("m_level");
	}
}