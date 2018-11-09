<?php

class M_Jabatan Extends DB_QM {
	
	public function datalist(){
		$this->db->order_by("a.ID_JABATAN");
		return $this->db->get("M_JABATAN a")->result();
	}
	
	public function list_jabatan(){
		$this->db->where("a.KD_JABATAN !=","2000");
		$this->db->order_by("a.ID_JABATAN");
		return $this->db->get("M_JABATAN a")->result();
	}

	public function list_jabatan_auth($ID_JABATAN=null){
		$this->db->where("a.KD_JABATAN !=","2000");
		if($ID_JABATAN) $this->db->where("a.ID_JABATAN",$ID_JABATAN);
		$this->db->order_by("a.ID_JABATAN");
		return $this->db->get("M_JABATAN a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NM_JABATAN",$keyword);
		return $this->db->get("M_JABATAN")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_JABATAN")->row();
	}
	
	public function get_data_by_id($ID_JABATAN){
		$this->db->where("ID_JABATAN",$ID_JABATAN);
		return $this->db->get("M_JABATAN")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_JABATAN !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_JABATAN")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_JABATAN","SEQ_ID_JABATAN.NEXTVAL",FALSE);
		$this->db->insert("M_JABATAN");
	}
	
	public function update($data,$ID_JABATAN){
		$this->db->set($data);
		$this->db->where("ID_JABATAN",$ID_JABATAN);
		$this->db->update("M_JABATAN");
	}
	
	public function delete($ID_JABATAN){
		$this->db->where("ID_JABATAN",$ID_JABATAN);
		$this->db->delete("M_JABATAN");
	}
	

}
