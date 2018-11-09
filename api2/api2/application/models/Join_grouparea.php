<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Join_grouparea extends DB_QM {

	/** Private Var for datatable **/
	private $column_order = array(NULL, 'KD_COMPANY','KD_PLANT','ID_GROUPAREA'); //set column for datatable order
    private $column_search = array('NM_COMPANY','NM_PLANT','NM_AREA'); //set column for datatable search 
    private $order = array("ID_AREA" => 'DESC'); //default order

	/** Fetch table **/
	public function query(){
		$this->db->select("a.*, c.KD_PLANT, c.NM_PLANT, b.KD_GROUPAREA, b.NM_GROUPAREA, d.*");
		$this->db->from("M_AREA a");
		$this->db->join("M_GROUPAREA b","a.ID_GROUPAREA=b.ID_GROUPAREA","LEFT");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY d","c.ID_COMPANY=d.ID_COMPANY","LEFT");
	}

	public function get_grouparea_list($ID_PLANT=NULL){
		$this->query();
		$this->db->where('a.ID_PLANT', $ID_PLANT);
		$query = $this->db->get();
		return $query->result();
	}

	/** Generate Query for DataTables **/
	public function get_query(){
		$this->query();
		if($this->input->post('company')) 	$this->db->where("c.ID_COMPANY", $this->input->post('company'));
		if($this->input->post('plant')) 	$this->db->where("a.ID_PLANT", $this->input->post('plant'));
		if($this->input->post('grouparea')) $this->db->where("a.ID_GROUPAREA", $this->input->post('grouparea'));
		if($this->input->post('area')) 		$this->db->where("a.ID_AREA", $this->input->post('area'));

		//Loop column search
		$i = 0;
		foreach ($this->column_search as $item) {
			if($_POST['search']['value']){
				if($i===0){ //first loop
					$this->db->group_start(); //open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, strtoupper($_POST['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($_POST['search']['value']));
				}

				if(count($this->column_search) - 1 == $i){ //last loop
                    $this->db->group_end(); //close bracket
				}
			}
			$i++;
		}

		if(isset($_POST['order'])){ //order datatable
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif (isset($this->order)) {
			$this->db->order_by(key($this->order), $this->order[key($this->order)]);
		}
	}

	/** Execute get_query and return DataTables Data **/
	public function get_list() {
		$this->get_query();

		if($this->input->post('length') != -1){
			$this->db->limit($this->input->post('length'),$this->input->post('start'));
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
		$this->query();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Count where **/
	public function count_where($where){
		$this->query();
		$this->db->where($where);
		$query = $this->db->get();
		return (int) $query->num_rows();
	}
	

}

/* End of file Join_grouparea.php */
/* Location: ./application/models/Join_grouparea.php */
?>