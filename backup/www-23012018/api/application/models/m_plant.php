<?php

class M_Plant Extends CI_Model {
	private $post  = array();
	private $table = "M_PLANT";
	private $pKey  = "ID_PLANT";
	private $column_order = array('ID_PLANT'); //set column for datatable order
    private $column_search = array('a.KD_PLANT', 'a.NM_PLANT', 'b.NM_COMPANY'); //set column for datatable search 
    private $order = array("a.ID_PLANT" => 'ASC'); //default order

	public function __construct(){
    	parent::__construct();
		$this->post = $this->input->post();
        $this->db = $this->load->database('mso_prod', TRUE);
	}

	public function datalist($ID_COMPANY=NULL, $ID_PLANT=NULL){

		$this->db->select("a.*,b.NM_COMPANY");
		$this->db->join("M_COMPANY b","a.ID_COMPANY=b.ID_COMPANY","LEFT");
		$this->db->order_by("a.ID_PLANT");
		if($ID_COMPANY) $this->db->where_in("a.ID_COMPANY", $ID_COMPANY);
		if($ID_PLANT) $this->db->where("a.ID_PLANT", $ID_PLANT);
		
		if($this->USER->ID_COMPANY) $this->db->where("a.ID_COMPANY", $this->USER->ID_COMPANY);
		if($this->USER->ID_PLANT) $this->db->where("a.ID_PLANT", $this->USER->ID_PLANT);
		
		return $this->db->get("M_PLANT a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NM_PLANT",$keyword);
		return $this->db->get("M_PLANT")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_PLANT")->row();
	}
	
	public function get_data_by_id($ID_PLANT){
		$this->db->where("ID_PLANT",$ID_PLANT);
		return $this->db->get("M_PLANT")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_PLANT !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_PLANT")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_PLANT","SEQ_ID_PLANT.NEXTVAL",FALSE);
		$this->db->insert("M_PLANT");
	}
	
	public function update($data,$ID_PLANT){
		$this->db->set($data);
		$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->update("M_PLANT");
	}
	
	public function delete($ID_PLANT){
		$this->db->where("ID_PLANT",$ID_PLANT);
		$this->db->delete("M_PLANT");
	}
	
	public function get_query(){
		$this->db->select("a.*,b.NM_COMPANY");
		$this->db->from($this->table . ' a');
		$this->db->join("M_COMPANY b","a.ID_COMPANY=b.ID_COMPANY","LEFT");
		if ($this->post['company'] && $this->post['company'] != 0) {
			$this->db->where('b.ID_COMPANY', $this->post['company']);
		}
		$this->db->order_by("a.ID_PLANT");
		#echo $this->db->get_compiled_select();exit();
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
		}elseif (isset($this->order)) {
			$this->db->order_by(key($this->order), $this->order[key($this->order)]);
		}
		#echo $this->db->get_compiled_select();exit();

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
