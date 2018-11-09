<?php

class M_Access_Log Extends DB_QM {
	private $post  = array();
	private $table = "V_ACCESS_LOG";
	private $pKey  = "LOG_ID";
	private $column_order = array('LOG_ID'); //set column for datatable order
  private $column_search = array('USERNAME', 'USERGROUP', 'COMPANY', 'GROUPMENU', 'MENU', 'URL', 'FROM_IP'); //set column for datatable search
  private $order = array("LOG_ID" => 'DESC'); //default order

	public function __construct(){
		$this->post = $this->input->post();
	}
	public function insert($data){
		$this->db->set($data);
		$this->db->insert("ACCESS_LOG");
	}

	public function perCompanyMonth($monthYear){
		$this->db->select('a.ID_COMPANY, a.COMPANY, COUNT(a.LOG_ID) AS JML_AKSES');
		$this->db->from($this->table.' a');
		$this->db->where("TO_CHAR(TO_DATE(a.TIME,'dd/mm/yyyy hh24:mi:ss'),'mm/yyyy')='".$monthYear."'");
		$this->db->where('a.ID_COMPANY IS NOT NULL');
		$this->db->group_by('a.ID_COMPANY, a.COMPANY');
		#echo $this->db->get_compiled_select();exit();
		return $this->db->get()->result();
	}

	public function perCompanyDate($monthYear){
		$this->db->select("a.ID_COMPANY, a.KD_COMPANY, a.COMPANY, COUNT(a.LOG_ID) AS JML_AKSES");
		$this->db->select("TO_CHAR(TO_DATE(a.TIME,'dd/mm/yyyy hh24:mi:ss'),'dd-mm-yyyy') AS TANGGAL");
		$this->db->from($this->table.' a');
		$this->db->where("TO_CHAR(TO_DATE(a.TIME,'dd/mm/yyyy hh24:mi:ss'),'mm/yyyy')='".$monthYear."'");
		$this->db->where('a.ID_COMPANY IS NOT NULL');
		$this->db->group_by('a.ID_COMPANY, a.KD_COMPANY, a.COMPANY');
		$this->db->group_by("TO_CHAR(TO_DATE(a.TIME,'dd/mm/yyyy hh24:mi:ss'),'dd-mm-yyyy')");
		$this->db->order_by('TANGGAL','asc');
		#echo $this->db->get_compiled_select();exit();
		return $this->db->get()->result();
	}

	public function topGroupmenu($monthYear){
		$this->db->select("TO_CHAR(a.WAKTU,'MM-YYYY') AS TANGGAL, b.NM_GROUPMENU, count(a.ID_ACCESS_LOG) as JML_AKSES");
		$this->db->from('ACCESS_LOG a');
		$this->db->join('M_GROUPMENU b', 'a.ID_GROUPMENU=b.ID_GROUPMENU', 'left');
		$this->db->where('a.ID_USER IS NOT NULL');
		$this->db->where('a.ID_GROUPMENU IS NOT NULL');
		$this->db->where("TO_CHAR( a.WAKTU, 'MM-YYYY' )=", $monthYear);
		$this->db->group_by("TO_CHAR(a.WAKTU,'MM-YYYY')");
		$this->db->group_by("b.NM_GROUPMENU");
		$this->db->limit(5);
		$this->db->order_by('JML_AKSES', 'desc');
		#echo $this->db->get_compiled_select();exit();
		return $this->db->get()->result();
	}

	public function topMenu($monthYear){
		$this->db->select('a.TANGGAL, b.NM_GROUPMENU, c.NM_MENU, a.JML_AKSES');
		$this->db->from('VAL_BULAN_PERMENU a');
		$this->db->join('M_GROUPMENU b', 'a.ID_GROUPMENU=b.ID_GROUPMENU', 'left');
		$this->db->join('M_MENU c', 'a.ID_MENU=c.ID_MENU', 'left');
		$this->db->where('a.TANGGAL', $monthYear);
		$this->db->limit(5);
		$this->db->order_by('a.JML_AKSES', 'desc');
		return $this->db->get()->result();
	}

	public function topUser(){
		$this->db->select('b.FULLNAME, a.JML_AKSES');
		$this->db->from('VAL_TOTAL_PERUSER a');
		$this->db->join('M_USERS b', 'a.ID_USER = b.ID_USER', 'left');
		$this->db->limit(5);
		$this->db->order_by('a.JML_AKSES', 'desc');
		return $this->db->get()->result();
	}

	public function get_query(){
		$this->db->select('*');
		$this->db->from($this->table);
		if($this->post['company']!='ALL') $this->db->where('ID_COMPANY', $this->post['company']);
		if($this->post['usergroup']!='ALL') $this->db->where('ID_USERGROUP', $this->post['usergroup']);
		if($this->post['groupmenu']!='ALL') $this->db->where('ID_GROUPMENU', $this->post['groupmenu']);
		if(!empty($this->post['time_start']) && !empty($this->post['time_end'])){
			$this->db->where("TIME BETWEEN '" . $this->post['time_start'] ."' AND '" . $this->post['time_end'] ."'");
			$this->db->order_by('LOG_ID', 'desc');
		}
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
