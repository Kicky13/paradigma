<?php

class M_Authority Extends DB_QM {
	
	public function datalist($ID_USERGROUP){
		$this->db->select("ID_MENU");
		$this->db->where("ID_USERGROUP",$ID_USERGROUP);
		return $this->db->get("M_AUTHORITY a")->result();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->insert("M_AUTHORITY");
	}
	
	public function delete($data){
		$this->db->where($data);
		$this->db->delete("M_AUTHORITY");
	}
	
	public function permition($MENU_PATH,$ID_USER){
		$this->db->select("h.ID_GROUPMENU, h.NM_GROUPMENU, d.ID_MENU, d.NM_MENU, b.PERM_READ, b.PERM_WRITE, a.ID_COMPANY, a.ID_PLANT, a.ID_AREA, e.NM_COMPANY, f.NM_PLANT, g.NM_AREA");
		$this->db->join("M_USERGROUP b","a.ID_USERGROUP=b.ID_USERGROUP");
		$this->db->join("M_AUTHORITY c","c.ID_USERGROUP=b.ID_USERGROUP");
		$this->db->join("M_MENU d","c.ID_MENU=d.ID_MENU AND d.URL_MENU='".$MENU_PATH."'");
		$this->db->join("M_COMPANY e","a.ID_COMPANY=e.ID_COMPANY","LEFT");
		$this->db->join("M_PLANT f","a.ID_PLANT=f.ID_PLANT","LEFT");
		$this->db->join("M_AREA g","a.ID_AREA=g.ID_AREA","LEFT");
		$this->db->join("M_GROUPMENU h","d.ID_GROUPMENU=h.ID_GROUPMENU");
		$this->db->where("a.ID_USER=",$ID_USER);
		return $this->db->get("M_USERS a")->row();
	}
	
}
