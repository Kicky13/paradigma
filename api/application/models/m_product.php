<?php

class M_Product Extends CI_Model {
	private $post  = array();
	private $table = "M_PRODUCT";
	private $pKey  = "ID_PRODUCT";
	private $column_order = array(NULL, 'ID_PRODUCT'); //set column for datatable order
    private $column_search = array('KD_PRODUCT', 'NM_PRODUCT'); //set column for datatable search 
    private $order = array("ID_PRODUCT" => 'ASC'); //default order

	public function __construct(){
		parent::__construct();
		$this->post = $this->input->post();
        $this->db = $this->load->database('mso_prod', TRUE);
	}

	public function datalist(){
		$this->db->order_by("a.ID_PRODUCT");
		return $this->db->get("M_PRODUCT a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NM_PRODUCT",$keyword);
		return $this->db->get("M_PRODUCT")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_PRODUCT")->row();
	}
	
	public function get_data_by_id($ID_PRODUCT){
		$this->db->where("ID_PRODUCT",$ID_PRODUCT);
		return $this->db->get("M_PRODUCT")->row();
	}
	
	public function get_id_by_name($name=''){
		$this->db->where("NM_PRODUCT", strtoupper(trim($name)));
		return $this->db->get("M_PRODUCT")->row()->ID_PRODUCT;
	}

	public function get_id_by_kode($name=''){
		$this->db->where("KD_PRODUCT", strtoupper(trim($name)));
		return $this->db->get("M_PRODUCT")->row()->ID_PRODUCT;
	}

	public function data_except_id($where,$skip_id){
		$this->db->where("ID_PRODUCT !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_PRODUCT")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_PRODUCT","SEQ_ID_PRODUCT.NEXTVAL",FALSE);
		$this->db->insert("M_PRODUCT");
	}
	
	public function update($data,$ID_PRODUCT){
		$this->db->set($data);
		$this->db->where("ID_PRODUCT",$ID_PRODUCT);
		$this->db->update("M_PRODUCT");
	}
	
	public function delete($ID_PRODUCT){
		$this->db->where("ID_PRODUCT",$ID_PRODUCT);
		$this->db->delete("M_PRODUCT");
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
