<?php

class C_Parameter Extends DB_QM {
	
	public function datalist($ID_PLANT=NULL, $ID_GROUPAREA=NULL){		
		$this->db->select("a.*,b.NM_COMPANY, c.NM_PLANT");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY b","c.ID_COMPANY=b.ID_COMPANY","LEFT");
		if ($ID_PLANT) $this->db->where("a.ID_PLANT",$ID_PLANT);		
		if ($ID_GROUPAREA) $this->db->where("a.ID_GROUPAREA",$ID_GROUPAREA);		
		$this->db->order_by("a.ID_PARAMETER");
		return $this->db->get("C_PARAMETER a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NC_PARAMETER",$keyword);
		return $this->db->get("C_PARAMETER")->result();
	}
	
	public function data($where){
		$this->db->join("M_COMPONENT","C_PARAMETER.ID_COMPONENT=M_COMPONENT.ID_COMPONENT");
		$this->db->join("C_PARAMETER_ORDER","C_PARAMETER_ORDER.ID_GROUPAREA=C_PARAMETER.ID_GROUPAREA and C_PARAMETER_ORDER.DISPLAY=C_PARAMETER.DISPLAY and C_PARAMETER_ORDER.ID_COMPONENT=M_COMPONENT.ID_COMPONENT");
		$this->db->select("M_COMPONENT.KD_COMPONENT");
		$this->db->where("C_PARAMETER.ID_PLANT",$where['ID_PLANT']);
		$this->db->where("C_PARAMETER.DISPLAY",$where['DISPLAY']);
		$this->db->where("C_PARAMETER.ID_GROUPAREA",$where['ID_GROUPAREA']);
		$this->db->order_by("C_PARAMETER_ORDER.URUTAN","ASC");
		$q = $this->db->get("C_PARAMETER"); # die($this->db->last_query());
		return $q->result();
	}
	
	public function or_where($plant='', $group='', $dh_ly=''){
		$this->db->select("a.*,b.NM_COMPANY, c.NM_PLANT, d.KD_COMPONENT, d.NM_COMPONENT, e.URUTAN");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY b","c.ID_COMPANY=b.ID_COMPANY","LEFT");
		$this->db->join("M_COMPONENT d","a.ID_COMPONENT=d.ID_COMPONENT","LEFT");
		$this->db->join('C_PARAMETER_ORDER e', 'a.ID_COMPONENT = e.ID_COMPONENT AND a.ID_GROUPAREA=e.ID_GROUPAREA AND a.DISPLAY=e.DISPLAY', 'left');
		$this->db->order_by('e.URUTAN', 'asc');
		$this->db->where('a.DISPLAY', $dh_ly);
		$this->db->where_in("a.ID_PLANT", $plant);
		$this->db->where_in("a.ID_GROUPAREA", $group);

		return $this->db->get("C_PARAMETER a")->result();
	}

	public function get_data_by_id($ID_PLANT){
		$this->db->where("ID_PLANT",$ID_PLANT);
		return $this->db->get("C_PARAMETER")->row();
	}

	public function get_by_id($ID_PARAMETER){
		$this->db->where("ID_PARAMETER",$ID_PARAMETER);
		return $this->db->get("C_PARAMETER")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_PLANT !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("C_PARAMETER")->row();
	}
	
	public function clean($ID_PLANT,$ID_GROUPAREA,$KEEP,$DISPLAY){
		$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->where("ID_GROUPAREA",$ID_GROUPAREA);
		$this->db->where("DISPLAY",$DISPLAY);
		$this->db->where_not_in("ID_COMPONENT",$KEEP);
		$this->db->delete("C_PARAMETER");
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_PARAMETER","SEQ_ID_PARAMETER.NEXTVAL",FALSE);
		$this->db->insert("C_PARAMETER");
	}
	
	public function update($data,$ID_PLANT){
		$this->db->set($data);
		$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->update("C_PARAMETER");
	}
	
	public function delete($ID_PLANT){
		$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->delete("C_PARAMETER");
	}
	
	public function list_config($ID_PLANT){
		$this->db->distinct();
		$this->db->select("c.ID_PLANT, b.ID_GROUPAREA, d.NM_COMPANY, c.NM_PLANT, b.NM_GROUPAREA");
		$this->db->join("M_GROUPAREA b","a.ID_GROUPAREA=b.ID_GROUPAREA");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT");
		$this->db->join("M_COMPANY d","c.ID_COMPANY=d.ID_COMPANY");
		$this->db->where("a.ID_PLANT",$ID_PLANT);
		return $this->db->get("M_AREA a")->result();
	}
	
	public function list_grouparea($ID_PLANT){
		$this->db->distinct();
		$this->db->select("b.ID_GROUPAREA, b.NM_GROUPAREA");
		$this->db->join("M_GROUPAREA b","a.ID_GROUPAREA=b.ID_GROUPAREA");
		$this->db->where("a.ID_PLANT",$ID_PLANT);
		$this->db->order_by("b.ID_GROUPAREA","asc");
		return $this->db->get("M_AREA a")->result();
	}
	
	public function configuration($ID_PLANT,$ID_GROUPAREA,$DISPLAY){
		$this->db->select("a.ID_PARAMETER,a.ID_COMPONENT, b.KD_COMPONENT, b.NM_COMPONENT, c.URUTAN");
		$this->db->join("M_COMPONENT b","a.ID_COMPONENT=b.ID_COMPONENT");
		$this->db->join('C_PARAMETER_ORDER c', 'a.ID_COMPONENT = c.ID_COMPONENT AND a.ID_GROUPAREA=c.ID_GROUPAREA AND a.DISPLAY=c.DISPLAY', 'left');
		$this->db->where("a.ID_PLANT",$ID_PLANT);
		$this->db->where("a.ID_GROUPAREA",$ID_GROUPAREA);
		$this->db->where("a.DISPLAY",$DISPLAY);
		$this->db->order_by('URUTAN', 'asc');
		$this->db->order_by('KD_COMPONENT', 'asc');
		return $this->db->get("C_PARAMETER a")->result();
	}

}
