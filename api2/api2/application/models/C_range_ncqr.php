<?php

class C_range_ncqr Extends DB_QM {
	
	public function datalist($ID_PLANT=NULL, $ID_GROUPAREA=NULL){		
		$this->db->select("a.*,b.NM_COMPANY, c.NM_PLANT");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY b","c.ID_COMPANY=b.ID_COMPANY","LEFT");
		if ($ID_PLANT) $this->db->where("a.ID_PLANT",$ID_PLANT);		
		if ($ID_GROUPAREA) $this->db->where("a.ID_GROUPAREA",$ID_GROUPAREA);		
		$this->db->order_by("a.ID_PARAMETER");
		return $this->db->get("C_RANGE_NCQR a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NC_RANGE_NCQR",$keyword);
		return $this->db->get("C_RANGE_NCQR")->result();
	}
	
	public function data($where){
		$this->db->join("M_COMPONENT","C_RANGE_NCQR.ID_COMPONENT=M_COMPONENT.ID_COMPONENT");
		$this->db->select("M_COMPONENT.ID_COMPONENT,M_COMPONENT.KD_COMPONENT");
		$this->db->where($where);
		$this->db->order_by("C_RANGE_NCQR.ID_PARAMETER","ASC");
		$q = $this->db->get("C_RANGE_NCQR"); 
		return $q->result();
	}
	
	public function or_where($plant='', $group='', $dh_ly=''){
		$this->db->select("a.*,b.NM_COMPANY, c.NM_PLANT, d.NM_COMPONENT");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY b","c.ID_COMPANY=b.ID_COMPANY","LEFT");
		$this->db->join("M_COMPONENT d","a.ID_COMPONENT=d.ID_COMPONENT","LEFT");
		$this->db->order_by("a.ID_PARAMETER");
		$this->db->where('a.DISPLAY', $dh_ly);
		$this->db->where_in("a.ID_PLANT", $plant);
		$this->db->where_in("a.ID_GROUPAREA", $group);

		return $this->db->get("C_RANGE_NCQR a")->result();
	}

	public function get_data_by_id($ID_PLANT){
		$this->db->where("ID_PLANT",$ID_PLANT);
		return $this->db->get("C_RANGE_NCQR")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_PLANT !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("C_RANGE_NCQR")->row();
	}
	
	public function clean($ID_PLANT,$ID_GROUPAREA,$KEEP){
		$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->where("ID_GROUPAREA",$ID_GROUPAREA);
		$this->db->where_not_in("ID_COMPONENT",$KEEP);
		$this->db->delete("C_RANGE_NCQR");
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->insert("C_RANGE_NCQR");
	}
	
	public function update($data){
		$this->db->set($data);
		$this->db->where("ID_GROUPAREA",$data['ID_GROUPAREA']);
		$this->db->where("ID_PLANT",$data['ID_PLANT']);
		$this->db->where("ID_COMPONENT",$data['ID_COMPONENT']);
		$this->db->where("ID_PRODUCT",$data['ID_PRODUCT']);
		$this->db->update("C_RANGE_NCQR");
	}
	
	public function delete($ID_PLANT){
		$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->delete("C_RANGE_NCQR");
	}
	
	public function list_config($ID_PLANT){
		$this->db->distinct();
		$this->db->select("c.ID_PLANT, b.ID_GROUPAREA, d.NM_COMPANY, c.NM_PLANT, b.NM_GROUPAREA");
		$this->db->join("M_GROUPAREA b","a.ID_GROUPAREA=b.ID_GROUPAREA and b.ID_GROUPAREA IN (1,4)");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT");
		$this->db->join("M_COMPANY d","c.ID_COMPANY=d.ID_COMPANY");
		$this->db->where("a.ID_PLANT",$ID_PLANT);
		return $this->db->get("M_AREA a")->result();
	}
	
	public function list_grouparea($ID_PLANT){
		$this->db->distinct();
		$this->db->select("b.ID_GROUPAREA, b.NM_GROUPAREA");
		$this->db->join("M_GROUPAREA b","a.ID_GROUPAREA=b.ID_GROUPAREA and b.ID_GROUPAREA IN (1,4)");
		$this->db->order_by("b.ID_GROUPAREA","asc");
		// $this->db->where("a.ID_PLANT",$ID_PLANT);
		return $this->db->get("M_AREA a")->result();
	}
	
	public function list_configured_product($ID_PLANT,$ID_GROUPAREA){
		$this->db->distinct();
		$this->db->select("e.NM_COMPANY, d.NM_PLANT, c.NM_GROUPAREA");
		if($ID_GROUPAREA == '1') $this->db->select("b.*");
		$this->db->where("a.ID_PLANT",$ID_PLANT);
		$this->db->where("a.ID_GROUPAREA",$ID_GROUPAREA);
		if($ID_GROUPAREA == '1') $this->db->join("M_PRODUCT b","a.ID_PRODUCT=b.ID_PRODUCT");
		$this->db->join("M_GROUPAREA c","a.ID_GROUPAREA=c.ID_GROUPAREA");
		$this->db->join("M_PLANT d","a.ID_PLANT=d.ID_PLANT");
		$this->db->join("M_COMPANY e","d.ID_COMPANY=e.ID_COMPANY");
		return $this->db->get("C_NCQR_PRODUCT a")->result_array();
	}
	
	public function configuration($ID_PLANT,$ID_GROUPAREA,$ID_PRODUCT){
		$this->db->select("b.*,c.V_MIN, c.V_MAX");
		$this->db->join("M_COMPONENT b","a.ID_COMPONENT=b.ID_COMPONENT","LEFT");
		$this->db->join("M_GROUPAREA d","d.ID_GROUPAREA=a.ID_GROUPAREA and d.ID_GROUPAREA='$ID_GROUPAREA'","LEFT");
		$this->db->join("C_RANGE_NCQR c","c.ID_GROUPAREA='$ID_GROUPAREA' and c.ID_GROUPAREA=d.ID_GROUPAREA AND c.ID_COMPONENT=b.ID_COMPONENT and c.ID_PLANT=a.ID_PLANT ".(($ID_PRODUCT)?" and c.ID_PRODUCT=$ID_PRODUCT":""),"LEFT");
		$this->db->where("a.ID_PLANT",$ID_PLANT);
		$this->db->where("a.ID_GROUPAREA = d.ID_GROUPAREA",FALSE,FALSE);
		return $this->db->get("C_NCQR_COMPONENT a")->result_array();

	}
	
	public function if_exists($ID_PLANT,$ID_GROUPAREA,$ID_COMPONENT,$ID_PRODUCT){
		$this->db->where("ID_PRODUCT",$ID_PRODUCT);
		$this->db->where("ID_GROUPAREA",$ID_GROUPAREA);
		$this->db->where("ID_COMPONENT",$ID_COMPONENT);
		$this->db->where("ID_PLANT",$ID_PLANT);
		return $this->db->get("C_RANGE_NCQR")->num_rows();
	}
	
	public function ncqr_product($ID_PLANT, $ID_GROUPAREA){
		$this->db->select("b.*");
		$this->db->where("a.ID_PLANT",$ID_PLANT);
		$this->db->where("a.ID_GROUPAREA",$ID_GROUPAREA);
		$this->db->join("M_PRODUCT b","a.ID_PRODUCT=b.ID_PRODUCT");
		return $this->db->get("C_NCQR_PRODUCT a")->result();
	}

}
