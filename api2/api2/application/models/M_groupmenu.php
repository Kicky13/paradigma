<?php

class M_Groupmenu Extends DB_QM {
	private $post  = array();
	private $table = "M_GROUPMENU";
	private $pKey  = "ID_GROUPMENU";
	private $column_order = array('NO_ORDER'); //set column for datatable order
    private $column_search = array('NM_GROUPMENU', 'NO_ORDER'); //set column for datatable search 
    private $order = array("NO_ORDER" => 'ASC'); //default order

	public function __construct(){
		$this->post = $this->input->post();
	}

	public function datalist(){
		$this->db->order_by("a.NO_ORDER");
		$this->db->where("a.APP",$this->APP);
		return $this->db->get("M_GROUPMENU a")->result();
	}
	
	public function list_groupmenu(){
		$this->db->order_by("a.ID_GROUPMENU");
		$this->db->where("a.APP",$this->APP);
		return $this->db->get("M_GROUPMENU a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("NM_GROUPMENU",$keyword);
		return $this->db->get("M_GROUPMENU")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		$this->db->where("APP",$this->APP);
		return  $this->db->get("M_GROUPMENU")->row();
	}
	
	public function get_data_by_id($ID_GROUPMENU){
		$this->db->where("ID_GROUPMENU",$ID_GROUPMENU);
		return $this->db->get("M_GROUPMENU")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_GROUPMENU !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_GROUPMENU")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_GROUPMENU","SEQ_ID_GROUPMENU.NEXTVAL",FALSE);
		$this->db->set("APP",$this->APP);
		$this->db->insert("M_GROUPMENU");
	}
	
	public function update($data,$ID_GROUPMENU){
		$this->db->set($data);
		$this->db->where("ID_GROUPMENU",$ID_GROUPMENU);
		$this->db->update("M_GROUPMENU");
	}
	
	public function delete($ID_GROUPMENU){
		$this->db->where("ID_GROUPMENU",$ID_GROUPMENU);
		$this->db->delete("M_GROUPMENU");
	}
	
	public function get_query(){
		$this->db->select("*");
		$this->db->where("a.APP",$this->APP);
		$this->db->from($this->table .' a');
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
