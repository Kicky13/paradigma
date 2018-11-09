<?php

class C_qaf_component Extends DB_QM {
	
	public function datalist($ID_PLANT=NULL, $ID_GROUPAREA=NULL){		
		$this->db->select("a.*,b.NM_COMPANY, c.NM_PLANT");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY b","c.ID_COMPANY=b.ID_COMPANY","LEFT");
		if ($ID_PLANT) $this->db->where("a.ID_PLANT",$ID_PLANT);		
		if ($ID_GROUPAREA) $this->db->where("a.ID_GROUPAREA",$ID_GROUPAREA);		
		$this->db->order_by("a.ID_PARAMETER");
		return $this->db->get("C_QAF_COMPONENT a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NC_QAF_COMPONENT",$keyword);
		return $this->db->get("C_QAF_COMPONENT")->result();
	}
	
	public function data($where){
		$this->db->join("M_COMPONENT","C_QAF_COMPONENT.ID_COMPONENT=M_COMPONENT.ID_COMPONENT");
		$this->db->select("M_COMPONENT.ID_COMPONENT,M_COMPONENT.KD_COMPONENT");
		$this->db->where($where);
		$this->db->order_by("C_QAF_COMPONENT.ID_PARAMETER","ASC");
		$q = $this->db->get("C_QAF_COMPONENT"); 
		return $q->result();
	}
	
	public function or_where($plant='', $group=''){
		$this->db->select("a.*,b.NM_COMPANY, c.NM_PLANT,d.KD_COMPONENT, d.NM_COMPONENT");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY b","c.ID_COMPANY=b.ID_COMPANY","LEFT");
		$this->db->join("M_COMPONENT d","a.ID_COMPONENT=d.ID_COMPONENT","LEFT");
		$this->db->order_by("a.ID_COMPONENT");
		#$this->db->where_in("a.ID_PLANT", $plant);
		$this->db->where_in("a.ID_GROUPAREA", $group);
		#echo $this->db->last_query();exit();
		return $this->db->get("C_QAF_COMPONENT a")->result();
	}

	public function clean($ID_PLANT,$ID_GROUPAREA,$KEEP){
		#$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->where("ID_GROUPAREA",$ID_GROUPAREA);
		$this->db->where_not_in("ID_COMPONENT",$KEEP);
		$this->db->delete("C_QAF_COMPONENT");
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->insert("C_QAF_COMPONENT");
	}
	
	public function update($data,$ID_PLANT){
		$this->db->set($data);
		#$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->update("C_QAF_COMPONENT");
	}
	
	public function delete($ID_PLANT){
		#$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->delete("C_QAF_COMPONENT");
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
		$this->db->select("d.*,c.*,b.*");
		$this->db->join("M_GROUPAREA b","a.ID_GROUPAREA=b.ID_GROUPAREA");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT");
		$this->db->join("M_COMPANY d","c.ID_COMPANY=d.ID_COMPANY");
		if($ID_PLANT) $this->db->where("a.ID_PLANT",$ID_PLANT);
		return $this->db->get("C_QAF_COMPONENT a")->result();
	}
	
	public function configuration($ID_GROUPAREA){
		$this->db->select("a.ID_COMPONENT, b.KD_COMPONENT, b.NM_COMPONENT");
		$this->db->join("M_COMPONENT b","a.ID_COMPONENT=b.ID_COMPONENT");
		#$this->db->where("a.ID_PLANT",$ID_PLANT);
		$this->db->where("a.ID_GROUPAREA",$ID_GROUPAREA);
		return $this->db->get("C_QAF_COMPONENT a")->result();
	}
	
	public function qaf_grouparea(){
		$this->db->where("ID_GROUPAREA IN (1,4)",NULL,NULL); // (1) finishmill (2) clinker
		$this->db->order_by("ID_GROUPAREA","asc");
		return $this->db->get("M_GROUPAREA")->result();
	}

}
