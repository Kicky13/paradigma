<?php

class M_Company Extends DB_QM {
	private $post  = array();
	private $table = "M_COMPANY";
	private $pKey  = "ID_COMPANY";
	private $column_order = array('URUTAN'); //set column for datatable order
    private $column_search = array('NM_COMPANY', 'KD_COMPANY', 'URUTAN'); //set column for datatable search 
    private $order = array("URUTAN" => 'ASC'); //default order

	public function __construct(){
		$this->post = $this->input->post();
	}

	public function datalist(){
		#$this->db->order_by("CASE a.KD_COMPANY WHEN '5000' THEN 1 WHEN '3000' THEN 2 WHEN '4000' THEN 3 WHEN '6000' THEN 4 END");
		$this->db->order_by('URUTAN', 'asc');
		return $this->db->get("M_COMPANY a")->result();
	}
	
	public function list_company(){
		$this->db->where("a.KD_COMPANY !=","2000");
		#$this->db->order_by("CASE a.KD_COMPANY WHEN '5000' THEN 1 WHEN '3000' THEN 2 WHEN '4000' THEN 3 WHEN '6000' THEN 4 END");
		$this->db->order_by('URUTAN', 'asc');
		return $this->db->get("M_COMPANY a")->result();
	}

	public function list_company_auth($ID_COMPANY=null){
		$this->db->where("a.KD_COMPANY !=","2000");
		if($ID_COMPANY) $this->db->where("a.ID_COMPANY",$ID_COMPANY);
		$this->db->order_by("CASE a.KD_COMPANY WHEN '5000' THEN 1 WHEN '3000' THEN 2 WHEN '4000' THEN 3 WHEN '6000' THEN 4 END");
		return $this->db->get("M_COMPANY a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NM_COMPANY",$keyword);
		return $this->db->get("M_COMPANY")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_COMPANY")->row();
	}
	
	public function get_data_by_id($ID_COMPANY){
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		return $this->db->get("M_COMPANY")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_COMPANY !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_COMPANY")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_COMPANY","SEQ_ID_COMPANY.NEXTVAL",FALSE);
		$this->db->insert("M_COMPANY");
	}
	
	public function update($data,$ID_COMPANY){
		$this->db->set($data);
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->update("M_COMPANY");
	}
	
	public function delete($ID_COMPANY){
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->delete("M_COMPANY");
	}
	
	public function get_query(){
		$this->db->select('*');
		$this->db->from($this->table);
	}

	public function get_list() {
		$this->get_query();
		$i = 0;

		//Loop column search
		foreach ($this->column_search as $item) {
			if($this->post['search']['value']){
				if($i===0){ //first loop
					$this->db->group_start(); //open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, strtoupper($this->post['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($this->post['search']['value']));
				}

				if(count($this->column_search) - 1 == $i){ //last loop
                    $this->db->group_end(); //close bracket
				}
			}
			$i++;
		}

		if(isset($this->post['order'])){ //order datatable
			$this->db->order_by($this->column_order[$this->post['order']['0']['column']], $this->post['order']['0']['dir']);
			#echo $this->db->get_compiled_select();exit();
		}elseif (isset($this->order)) {
			$this->db->order_by(key($this->order), $this->order[key($this->order)]);
		}

		if($this->post['length'] != -1){
			$this->db->limit($this->post['length'],$this->post['start']);
			$query = $this->db->get();
		}else{
			$query = $this->db->get();
		}

		return $query->result();
	}

	/** Count query result after filtered **/
	public function count_filtered(){
		$this->get_query();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Count all result **/
	public function count_all(){
		$this->get_query();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}	

}
