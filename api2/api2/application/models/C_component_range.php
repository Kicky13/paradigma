<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_component_range extends DB_QM {

	/** Private Var for datatable **/
	private $column_order = array(NULL, 'KD_COMPANY','KD_PLANT','ID_GROUPAREA'); //set column for datatable order
    private $column_search = array('NM_COMPANY','NM_PLANT','NM_AREA'); //set column for datatable search 
    private $order = array("ID_PARAMETER" => 'DESC'); //default order

	public function get_range_component($ID_GROUPAREA=NULL,$DISPLAY='D'){
		$this->db->select("a.*, b.ID_PLANT, b.ID_GROUPAREA, b.ID_COMPONENT, c.ID_COMPANY, f.NM_COMPONENT, e.NM_GROUPAREA, c.NM_PLANT, d.NM_COMPANY");
		$this->db->from("C_RANGE_COMPONENT a");
		$this->db->join("C_PARAMETER b","a.ID_PARAMETER=b.ID_PARAMETER","LEFT");
		$this->db->join("M_PLANT c","b.ID_PLANT=c.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY d","c.ID_COMPANY=d.ID_COMPANY","LEFT");
		$this->db->join("M_GROUPAREA e","b.ID_GROUPAREA=e.ID_GROUPAREA","LEFT");
		$this->db->join("M_COMPONENT f","b.ID_COMPONENT=f.ID_COMPONENT","LEFT");
		if($ID_GROUPAREA) $this->db->where('b.ID_GROUPAREA', $ID_GROUPAREA);
		if($DISPLAY) $this->db->where('b.DISPLAY', $DISPLAY);
		return $this->db->get()->result();
	}

	public function distinct_query(){
		$this->db->distinct();
		$this->db->select("c.ID_GROUPAREA, b.ID_COMPANY, b.ID_PLANT, e.NM_COMPANY, b.NM_PLANT, c.NM_GROUPAREA");
		$this->db->from("C_PARAMETER a");
		$this->db->join("M_PLANT b","a.ID_PLANT=b.ID_PLANT","LEFT");
		$this->db->join("M_GROUPAREA c","a.ID_GROUPAREA=c.ID_GROUPAREA","LEFT");
		$this->db->join("M_COMPONENT d","a.ID_COMPONENT=d.ID_COMPONENT","LEFT");
		$this->db->join("M_COMPANY e","b.ID_COMPANY=e.ID_COMPANY","LEFT");
	}

	public function query(){
		$this->db->select("a.*, d.NM_COMPONENT, d.KD_COMPONENT, c.NM_GROUPAREA, e.NM_COMPANY, b.ID_COMPANY, b.NM_PLANT");
		$this->db->from("C_PARAMETER a");
		$this->db->join("M_PLANT b","a.ID_PLANT=b.ID_PLANT","LEFT");
		$this->db->join("M_GROUPAREA c","a.ID_GROUPAREA=c.ID_GROUPAREA","LEFT");
		$this->db->join("M_COMPONENT d","a.ID_COMPONENT=d.ID_COMPONENT","LEFT");
		$this->db->join("M_COMPANY e","b.ID_COMPANY=e.ID_COMPANY","LEFT");
	}

	/** Generate Query for DataTables **/
	public function get_query($dis=NULL){
		$tes = ($dis===0) ? $this->distinct_query():$this->query();
		
		if($this->input->post('company')) 	$this->db->where("e.ID_COMPANY", $this->input->post('company'));
		if($this->input->post('plant')) 	$this->db->where("b.ID_PLANT", $this->input->post('plant'));
		if($this->input->post('grouparea')) $this->db->where("c.ID_GROUPAREA", $this->input->post('grouparea'));
		if($this->input->post('component')) $this->db->where("d.ID_COMPONENT", $this->input->post('component'));
		if($this->input->post('display'))   $this->db->where("a.DISPLAY", $this->input->post('display'));

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
	public function get_list($dis=null) {
		$this->get_query($dis);

		if($this->input->post('length') != -1){
			$this->db->limit($this->input->post('length'),$this->input->post('start'));
			$query = $this->db->get();
		}else{
			$query = $this->db->get();
		}

		return $query->result();
	}

	/** Count query result after filtered **/
	public function count_filtered($dis=null){
		$this->get_query($dis);
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Count all result **/
	public function count_all($dis=null){
		$tes = ($dis===0) ? $this->distinct_query():$this->query();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Count where **/
	public function count_where($dis=null,$where){
		$tes = ($dis===0) ? $this->distinct_query():$this->query();
		$this->db->where($where);
		$query = $this->db->get();
		return (int) $query->num_rows();
	}
	
	public function clean($ID_PARAMETER){
		$this->db->where("ID_PARAMETER", $ID_PARAMETER);
		$this->db->delete('C_RANGE_COMPONENT');
	}

	public function insert($data){
		$this->db->set("ID_RANGE_COMPONENT","SEQ_ID_C_RANGE_COMPONENT.NEXTVAL",FALSE);
		$this->db->set($data);
		$this->db->insert('C_RANGE_COMPONENT');
	}

}

/* End of file C_component_range.php */
/* Location: ./application/models/C_component_range.php */
?>
