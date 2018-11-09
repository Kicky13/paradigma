<?php

class M_Score_penanganan Extends DB_QM {
	
	public function datalist(){
		$this->db->order_by("a.ID_SCORE_PENANGANAN");
		return $this->db->get("M_SCORE_PENANGANAN a")->result();
	}

	public function search(&$keyword){
		$this->db->like("NM_SCORE_PENANGANAN",$keyword);
		return $this->db->get("M_SCORE_PENANGANAN")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_SCORE_PENANGANAN")->row();
	}
	
	public function get_data_by_id($ID_SCORE_PENANGANAN){
		$this->db->where("ID_SCORE_PENANGANAN",$ID_SCORE_PENANGANAN);
		return $this->db->get("M_SCORE_PENANGANAN")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_SCORE_PENANGANAN !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_SCORE_PENANGANAN")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_SCORE_PENANGANAN","SEQ_ID_SCORE_PENANGANAN.NEXTVAL",FALSE);
		$this->db->insert("M_SCORE_PENANGANAN");
	}
	
	public function update($data,$ID_SCORE_PENANGANAN){
		$this->db->set($data);
		$this->db->where("ID_SCORE_PENANGANAN",$ID_SCORE_PENANGANAN);
		$this->db->update("M_SCORE_PENANGANAN");
	}
	
	public function delete($ID_SCORE_PENANGANAN){
		$this->db->where("ID_SCORE_PENANGANAN",$ID_SCORE_PENANGANAN);
		$this->db->delete("M_SCORE_PENANGANAN");
	}
	
}
