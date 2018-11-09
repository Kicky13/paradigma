<?php

class C_ncqr_product Extends DB_QM {
	
	public function datalist($ID_PLANT=NULL, $ID_GROUPAREA=NULL){		
		$this->db->select("a.*,b.NM_COMPANY, c.NM_PLANT");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY b","c.ID_COMPANY=b.ID_COMPANY","LEFT");
		if ($ID_PLANT) $this->db->where("a.ID_PLANT",$ID_PLANT);		
		if ($ID_GROUPAREA) $this->db->where("a.ID_GROUPAREA",$ID_GROUPAREA);		
		$this->db->order_by("a.ID_PARAMETER");
		return $this->db->get("C_NCQR_PRODUCT a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NC_NCQR_PRODUCT",$keyword);
		return $this->db->get("C_NCQR_PRODUCT")->result();
	}
	
	public function data($where){
		$this->db->join("M_PRODUCT","C_NCQR_PRODUCT.ID_PRODUCT=M_PRODUCT.ID_PRODUCT");
		$this->db->select("M_PRODUCT.ID_PRODUCT,M_PRODUCT.KD_PRODUCT");
		$this->db->where($where);
		$this->db->order_by("C_NCQR_PRODUCT.ID_PARAMETER","ASC");
		$q = $this->db->get("C_NCQR_PRODUCT"); 
		return $q->result();
	}
	
	public function or_where($plant='', $group='', $dh_ly=''){
		$this->db->select("a.*,b.NM_COMPANY, c.NM_PLANT, d.NM_PRODUCT");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY b","c.ID_COMPANY=b.ID_COMPANY","LEFT");
		$this->db->join("M_PRODUCT d","a.ID_PRODUCT=d.ID_PRODUCT","LEFT");
		$this->db->order_by("a.ID_PARAMETER");
		$this->db->where('a.DISPLAY', $dh_ly);
		$this->db->where_in("a.ID_PLANT", $plant);
		$this->db->where_in("a.ID_GROUPAREA", $group);

		return $this->db->get("C_NCQR_PRODUCT a")->result();
	}

	public function get_data_by_id($ID_PLANT){
		$this->db->where("ID_PLANT",$ID_PLANT);
		return $this->db->get("C_NCQR_PRODUCT")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_PLANT !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("C_NCQR_PRODUCT")->row();
	}
	
	public function clean($ID_PLANT,$ID_GROUPAREA,$KEEP){
		$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->where("ID_GROUPAREA",$ID_GROUPAREA);
		$this->db->where_not_in("ID_PRODUCT",$KEEP);
		$this->db->delete("C_NCQR_PRODUCT");
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->insert("C_NCQR_PRODUCT");
	}
	
	public function update($data,$ID_PLANT){
		$this->db->set($data);
		$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->update("C_NCQR_PRODUCT");
	}
	
	public function delete($ID_PLANT){
		$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->delete("C_NCQR_PRODUCT");
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
		return $this->db->get("C_NCQR_PRODUCT a")->result();
	}
	
	public function list_grouparea_cement($ID_PLANT){
		$this->db->distinct();
		$this->db->select("d.*,c.*,b.*");
		$this->db->join("M_GROUPAREA b","a.ID_GROUPAREA=b.ID_GROUPAREA");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT");
		$this->db->join("M_COMPANY d","c.ID_COMPANY=d.ID_COMPANY");
		if($ID_PLANT) $this->db->where("a.ID_PLANT",$ID_PLANT);
		$this->db->where("b.ID_GROUPAREA",1);
		return $this->db->get("C_NCQR_PRODUCT a")->result();
	}
	
	public function configuration($ID_PLANT,$ID_GROUPAREA){
		$this->db->select("a.ID_PRODUCT, b.KD_PRODUCT, b.NM_PRODUCT");
		$this->db->join("M_PRODUCT b","a.ID_PRODUCT=b.ID_PRODUCT");
		$this->db->where("a.ID_PLANT",$ID_PLANT);
		$this->db->where("a.ID_GROUPAREA",$ID_GROUPAREA);
		return $this->db->get("C_NCQR_PRODUCT a")->result();
	}
	
	public function ncqr_grouparea(){
		$this->db->where("ID_GROUPAREA IN (1)",NULL,NULL); // (1) finishmill (2) clinker
		$this->db->order_by("ID_GROUPAREA","asc");
		return $this->db->get("M_GROUPAREA")->result();
	}
	
	public function ncqr_area($ID_COMPANY=null,$ID_PLANT=NULL){
		$this->db->select("a.ID_AREA, a.KD_AREA, a.NM_AREA");
		$this->db->from("M_AREA a");
		$this->db->join("M_PLANT b","a.ID_PLANT=b.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY c","b.ID_COMPANY=c.ID_COMPANY","LEFT");
		$this->db->join("M_GROUPAREA d","a.ID_GROUPAREA=d.ID_GROUPAREA","LEFT");
		$this->db->order_by("a.ID_AREA");
		if($ID_COMPANY) $this->db->where("c.ID_COMPANY",$ID_COMPANY);
		if($ID_PLANT) $this->db->where("a.ID_PLANT",$ID_PLANT);
		$this->db->where_in("d.ID_GROUPAREA",array(1,4));
		return $this->db->get()->result();
	}

}
