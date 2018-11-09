<?php

class M_Users extends DB_GOHELPS {

	//datalist:select all
	public function datalist(){
		$this->db->select("a.*, b.NM_LEVEL");
		$this->db->join("m_level b","a.ID_LEVEL=b.ID_LEVEL","left");
		return $this->db->get("m_users a")->result();
	}

	public function search(&$keyword){
		$this->db->like("a.USERNAME",$keyword);
		$this->db->select("a.*, b.NM_LEVEL");
		$this->db->join("m_level b","a.ID_LEVEL=b.ID_LEVEL","left");
		return $this->db->get("m_users a")->result();
	}

	//data:data per user
	public function data($where){
		$this->db->select("m_users.*, m_level.NM_LEVEL");
		$this->db->where($where);
		$this->db->join("m_level","m_level.ID_LEVEL = m_users.ID_LEVEL");
		return $this->db->get("m_users")->row();
	}
	//get: get 1 col by ID_USER

	public function get_data_by_id($id_user){
		$this->db->where("ID_USER",$id_user);
		$this->db->select("a.*, b.NM_LEVEL");
		$this->db->join("m_level b","a.ID_LEVEL=b.ID_LEVEL","left");
		return $this->db->get("m_users a")->row();
	}

	public function get_data_by_username($username,$skip_id=null){
		$this->db->where("USERNAME",$username);
		if($skip_id) $this->db->where("ID_USER != ", $skip_id);
		$this->db->select("a.*, b.NM_LEVEL");
		$this->db->join("m_level b","a.ID_LEVEL=b.ID_LEVEL","left");
		return $this->db->get("m_users a")->row();
	}

	public function get_data_by_name($username,$skip_id=null){
		return $this->get_data_by_username($username,$skip_id);
	}

	public function insert($data){
		$this->db->set($data);
		$this->db->insert("m_users");
		return $this->db->insert_id();
	}

	public function update($data,$id_user){
		$this->db->set($data);
		$this->db->where("ID_USER",$id_user);
		$this->db->update("m_users");
	}

	public function delete($ID_USER){
		$this->db->where("ID_USER",$ID_USER);
		$this->db->delete("m_users");
	}

	public function verification($USER,$PASS){
		return $this->db->query("call user_verification(?,?)",array($USER,$PASS))->row();
	}
}

