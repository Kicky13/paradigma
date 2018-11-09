<?php

class M_Menu Extends DB_QM {
	private $post  = array();
	private $table = "M_MENU";
	private $pKey  = "ID_MENU";
	private $column_order = array('ID_MENU'); //set column for datatable order
    private $column_search = array('a.NM_MENU', 'a.URL_MENU', 'b.NM_GROUPMENU'); //set column for datatable search 
    private $order = array("b.NO_ORDER" => 'ASC'); //default order

	public function __construct(){
		$this->post = $this->input->post();
	}

	
	public function datalist(){
		$this->db->select("a.*, b.NM_GROUPMENU");
		$this->db->join("M_GROUPMENU b","a.ID_GROUPMENU=b.ID_GROUPMENU","LEFT");
		$this->db->where("a.APP",$this->APP);
		$this->db->order_by("b.NO_ORDER");
		$this->db->order_by("a.NO_ORDER");
		return $this->db->get("M_MENU a")->result();
	}
	
	public function search(&$keyword){
		$this->db->like("Nm_menu",$keyword);
		return $this->db->get("m_menu")->result();
	}
	
	public function data($where){
		$this->db->where($where);
		$this->db->where("APP",$this->APP);
		return  $this->db->get("m_menu")->row();
	}
	
	public function get_data_by_id($ID_MENU){
		$this->db->where("ID_MENU",$ID_MENU);
		return $this->db->get("M_MENU")->row();
	}
	
	public function data_except_id($where,$skip_id){
		$this->db->where("ID_MENU !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_MENU")->row();
	}
	
	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_MENU","SEQ_ID_MENU.NEXTVAL",FALSE);
		$this->db->set("APP",$this->APP);
		$this->db->insert("M_MENU");
	}
	
	public function update($data,$ID_MENU){
		$this->db->set($data);
		$this->db->where("ID_MENU",$ID_MENU);
		$this->db->update("M_MENU");
	}
	
	public function delete($ID_MENU){
		$this->db->where("ID_MENU",$ID_MENU);
		$this->db->delete("M_MENU");
	}
	
	public function list_active($ID_USER=NULL){
		$this->db->select("a.*, b.NM_GROUPMENU");
		$this->db->join("M_GROUPMENU b","a.ID_GROUPMENU=b.ID_GROUPMENU");
		$this->db->join("M_AUTHORITY c","a.ID_MENU=c.ID_MENU");
		$this->db->join("M_USERGROUP d","c.ID_USERGROUP=d.ID_USERGROUP");
		$this->db->join("M_USERS e","e.ID_USERGROUP=d.ID_USERGROUP and e.ID_USER='".$ID_USER."'");
		$this->db->order_by("b.NO_ORDER");
		$this->db->order_by("a.NO_ORDER");
		$this->db->where("a.ACTIVE","1");
		$this->db->where("a.APP",$this->APP);
		return $this->db->get("M_MENU a")->result();
	}

	public function get_query(){
		$this->db->select("a.*, b.NM_GROUPMENU");
		$this->db->from($this->table .' a');
		$this->db->join("M_GROUPMENU b","a.ID_GROUPMENU=b.ID_GROUPMENU","LEFT");
		$this->db->where("a.APP",$this->APP);
		if ($this->post['groupmenu']) {
			$this->db->where('b.ID_GROUPMENU', $this->post['groupmenu']);
		}
		$this->db->order_by("b.NO_ORDER");
		$this->db->order_by("a.NO_ORDER");
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
