<?php

class C_range_component Extends DB_QM {

	/** Private Var for datatable **/
	private $post  = array();
	private $table = "C_COMPONENT_RANGE";
	private $pKey  = "ID_COMPONENT";
    private $order = array("a.KD_COMPONENT" => 'asc'); //default order

	private $column_order  = array(NULL, 'KD_COMPONENT','ID_COMPONENT'); //set column for datatable order
    private $column_search = array('KD_COMPONENT', 'NM_COMPONENT'); //set column for datatable search 

    public function __construct(){
    	parent::__construct();
    	$this->post = $this->input->post();
    }

	public function get_sql_nojoin(){
		$this->db->select('a.ID_COMPONENT_RANGE, a.ID_COMPONENT, a.V_MIN, a.V_MAX');
		$this->db->from('C_COMPONENT_RANGE a');
	}

	public function get_sql(){
		$this->db->select('a.ID_COMPONENT, a.KD_COMPONENT, a.NM_COMPONENT, b.V_MIN, b.V_MAX');
		$this->db->from('M_COMPONENT a');
		$this->db->join('C_COMPONENT_RANGE b', 'a.ID_COMPONENT = b.ID_COMPONENT', 'left');
		if (isset($this->order)) $this->db->order_by(key($this->order), $this->order[key($this->order)]);

	}

	/** Generate Query for DataTables **/
	public function get_query(){
		$this->get_sql();
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
	}

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

	public function get_id($id=''){
		$this->get_sql();
		$this->db->where('a.ID_COMPONENT', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function where_id_nojoin($id=''){
		$this->get_sql_nojoin();
		$this->db->where('a.ID_COMPONENT', $id);
		$query = $this->db->get();
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
		$this->get_sql();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_COMPONENT_RANGE","SEQ_ID_COMPONENT_RANGE.NEXTVAL",FALSE);
		$this->db->insert("C_COMPONENT_RANGE");
	}
	
	public function update($data, $ID_COMPONENT){
		$this->db->set($data);
		$this->db->where("ID_COMPONENT",$ID_COMPONENT);
		$this->db->update("C_COMPONENT_RANGE");
	}
	

}
