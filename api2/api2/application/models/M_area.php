<?php

class M_area Extends DB_QM {
	
	public function datalist($ID_COMPANY=NULL,$ID_PLANT=NULL, $ID_GROUPAREA=NULL){
		$this->db->select("a.ID_AREA, a.KD_AREA, a.NM_AREA, b.ID_PLANT, b.KD_PLANT, b.NM_PLANT, c.ID_COMPANY, c.KD_COMPANY, c.NM_COMPANY, d.ID_GROUPAREA, d.NM_GROUPAREA");
		$this->db->from("M_AREA a");
		$this->db->join("M_PLANT b","a.ID_PLANT=b.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY c","b.ID_COMPANY=c.ID_COMPANY","LEFT");
		$this->db->join("M_GROUPAREA d","a.ID_GROUPAREA=d.ID_GROUPAREA","LEFT");
		$this->db->order_by("a.ID_AREA");
		if($ID_COMPANY) $this->db->where("c.ID_COMPANY",$ID_COMPANY);
		if($ID_PLANT) $this->db->where("a.ID_PLANT",$ID_PLANT);
		if($ID_GROUPAREA) $this->db->where("d.ID_GROUPAREA",$ID_GROUPAREA);
		return $this->db->get()->result();
	}
	
	public function grouplist($ID_COMPANY=NULL,$ID_PLANT=NULL, $ID_AREA=NULL, $SEMEN=FALSE){
		$this->db->select("a.ID_AREA, a.KD_AREA, a.NM_AREA, b.ID_PLANT, b.KD_PLANT, b.NM_PLANT, c.ID_COMPANY, c.KD_COMPANY, c.NM_COMPANY, d.ID_GROUPAREA, d.NM_GROUPAREA");
		$this->db->from("M_AREA a");
		$this->db->join("M_PLANT b","a.ID_PLANT=b.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY c","b.ID_COMPANY=c.ID_COMPANY","LEFT");
		$this->db->join("M_GROUPAREA d","a.ID_GROUPAREA=d.ID_GROUPAREA","LEFT");
		$this->db->order_by("a.ID_AREA");
		if($ID_COMPANY) $this->db->where("c.ID_COMPANY",$ID_COMPANY);
		if($ID_PLANT) $this->db->where("a.ID_PLANT",$ID_PLANT);
		if($ID_AREA) $this->db->where("a.ID_AREA",$ID_AREA);
		if($SEMEN) $this->db->where_in('d.ID_GROUPAREA', array(1,4)); #CEMENT, CLINKER
		return $this->db->get()->result();
	}
	
	public function list_area($ID_PLANT){
		$this->db->select("ID_AREA,NM_AREA");
		$this->db->where("ID_PLANT",$ID_PLANT);
		return $this->db->get("M_AREA")->result();
	}
	
	public function or_where($array=null, $arr=null){
		$this->db->select("a.ID_AREA, a.KD_AREA, a.NM_AREA, b.ID_PLANT, b.KD_PLANT, b.NM_PLANT, c.ID_COMPANY, c.KD_COMPANY, c.NM_COMPANY, d.ID_GROUPAREA, d.NM_GROUPAREA");
		$this->db->from("M_AREA a");
		$this->db->join("M_PLANT b","a.ID_PLANT=b.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY c","b.ID_COMPANY=c.ID_COMPANY");
		$this->db->join("M_GROUPAREA d","a.ID_GROUPAREA=d.ID_GROUPAREA","LEFT");
		$this->db->where_in("c.ID_COMPANY", $array);
		$this->db->where_in("d.ID_GROUPAREA", $arr);
		if ($this->USER->ID_PLANT) $this->db->where('b.ID_PLANT', $this->USER->ID_PLANT);
		if ($this->USER->ID_AREA) $this->db->where('a.ID_AREA', $this->USER->ID_AREA);
		$this->db->order_by("b.NM_PLANT", 'asc');
		$this->db->order_by("a.NM_AREA", 'asc');

		return $this->db->get()->result();
	}

	public function search(&$keyword){
		$this->db->like("NM_AREA",$keyword);
		return $this->db->get("M_AREA")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_AREA")->row();
	}
	
	public function get_data_by_id($ID_AREA){
		$this->db->where("ID_AREA",$ID_AREA);
		return $this->db->get("M_AREA")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_AREA !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_AREA")->row();
	}
	
	public function insert($data){
		$this->db->set("ID_AREA","SEQ_ID_AREA.NEXTVAL",FALSE);
		$this->db->set($data);
		$this->db->insert("M_AREA");
		//echo $this->db->last_query();exit();
	}
	
	public function update($data,$ID_AREA){
		$this->db->set($data);
		$this->db->where("ID_AREA",$ID_AREA);
		$this->db->update("M_AREA");
	}
	
	public function delete($ID_AREA){
		$this->db->where("ID_AREA",$ID_AREA);
		$this->db->delete("M_AREA");
	}
	

}
