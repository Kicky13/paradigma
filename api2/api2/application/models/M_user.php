<?php

class M_user Extends DB_QM {
	private $post  = array();
	private $table = "M_USERS";
	private $pKey  = "ID_USER";
	private $column_order = array('ID_USER'); //set column for datatable order
    private $column_search = array('UPPER(FULLNAME)', 'UPPER(USERNAME)', 'UPPER(NM_USERGROUP)'); //set column for datatable search
    private $order = array("ID_USER" => 'ASC'); //default order

	public function __construct(){
		$this->post = $this->input->post();
	}

	public function datalist(){
		$this->db->select("a.*,b.NM_USERGROUP");
		$this->db->join("M_USERGROUP b","a.ID_USERGROUP=b.ID_USERGROUP","LEFT");
		$this->db->where("a.DELETED","0");
		$this->db->order_by("a.ID_USER");
		return $this->db->get("M_USERS a")->result();
	}

	public function search(&$keyword){
		$this->db->like("NM_USERS",$keyword);
		return $this->db->get("M_USERS")->result();
	}

	public function data($where){
		$this->db->select("a.*, b.NM_COMPANY, c.NM_PLANT, d.NM_AREA, e.*");
		$this->db->join("M_COMPANY b","a.ID_COMPANY=b.ID_COMPANY","LEFT");
		$this->db->join("M_PLANT c","a.ID_PLANT=c.ID_PLANT","LEFT");
		$this->db->join("M_AREA d","a.ID_AREA=d.ID_AREA","LEFT");
		$this->db->join("M_GROUPAREA e","e.ID_GROUPAREA=d.ID_GROUPAREA","LEFT");
		$this->db->where("lower(a.USERNAME)",$where['USERNAME']);
		$this->db->where("a.DELETED","0");
		return  $this->db->get("M_USERS a")->row();
	}

	public function get_data_by_id($ID_USER){
		$this->db->where("ID_USER",$ID_USER);
		return $this->db->get("M_USERS")->row();
	}

	public function data_except_id($where,$skip_id){
		$where['DELETED'] = "0";
		$this->db->where("ID_USER !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_USERS")->row();
	}

	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_USER","SEQ_ID_USER.NEXTVAL",FALSE);
		$this->db->insert("M_USERS");
	}

	public function update($data,$ID_USER){
		$this->db->set($data);
		$this->db->where("ID_USER",$ID_USER);
		$this->db->update("M_USERS");
	}

	public function delete($ID_USER){
		$this->db->set("DELETED","1");
		$this->db->where("ID_USER",$ID_USER);
		$this->db->update("M_USERS");
	}

	public function get_query(){
		$this->db->select("a.*,b.NM_USERGROUP");
		$this->db->from('M_USERS a');
		$this->db->join("M_USERGROUP b","a.ID_USERGROUP=b.ID_USERGROUP","LEFT");
		$this->db->where("a.DELETED","0");
		$this->db->order_by("a.ID_USER");
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
