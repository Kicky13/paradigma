<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends DB_QM {

	/** Private Var for datatable **/
	private $post  = array();
	private $table = "v_karyawan";
	private $pKey  = "MK_NOPEG";
	private $order = array("MK_NAMA" => 'asc'); //default order
	private $column_order  = array(NULL, 'MK_NAMA'); //set column for datatable order
	private $column_search = array('MK_NAMA'); //set column for datatable search
	private $db_hris;

  public function __construct(){
  	parent::__construct();
  	$this->post = $this->input->post();
		$this->db_hris = $this->load->database('v_hris', TRUE);
  }

	public function get_sql(){
		$this->db_hris->select("SUBSTRING(a.MK_EMAIL, 1, LOCATE('@', a.MK_EMAIL) -1) as USERNAME");
		$this->db_hris->select("a.MK_NAMA, a.MK_EMAIL, TRIM(LEADING '0' FROM a.mk_nopeg) AS MK_NOPEG");
		$this->db_hris->select("CONCAT(TRIM(LEADING '0' FROM a.mk_nopeg), CONCAT(' ',UPPER(CONCAT(CONCAT(a.MK_CCTR_TEXT, ' ('), CONCAT(a.COMPANY_TEXT, ')'))))) AS MK_CCTR_TEXT");
		$this->db_hris->from($this->table . ' a');
		$this->db_hris->where("mk_action_text !='Terminasi'");
		$this->db_hris->where("mk_emp_group_text ='Active'");
		if (isset($this->order)) $this->db_hris->order_by(key($this->order), $this->order[key($this->order)]);
	}

	public function get_list(){
		$this->get_sql();
		$query = $this->db_hris->get();
		return $query->result();
	}

	public function get_username($username=''){
		$this->get_sql();
		$this->db_hris->like('a.MK_NAMA', "$username", 'BOTH');
		$this->db_hris->or_like('a.MK_NOPEG', "$username", 'BOTH');
		if (is_numeric($username)) {
			$this->db_hris->order_by('a.MK_NOPEG', 'asc');
		}else {
			$this->db_hris->order_by('a.MK_NAMA', 'asc');
		}
		#echo $this->db_hris->get_compiled_select();exit();
		$query = $this->db_hris->get();
		return $query->result();
	}

	public function get_id($id=''){
		$this->get_sql();
		$this->db_hris->where('a.MK_NOPEG', $id);
		$query = $this->db_hris->get();
		return $query->result();
	}

	public function where_id($id=''){
		$this->get_sql();
		$this->db_hris->where('a.MK_NOPEG', $id);
		$query = $this->db_hris->get();
		return $query->result();
	}

	/** Count query result after filtered **/
	public function count_filtered(){
		$this->get_query();
		$query = $this->db_hris->get();
		return (int) $query->num_rows();
	}

	/** Count all result **/
	public function count_all(){
		$this->get_sql();
		$query = $this->db_hris->get();
		return (int) $query->num_rows();
	}

}

/* End of file Employee.php */
/* Location: ./application/models/Employee.php */
?>
