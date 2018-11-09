<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class T_skoring_ramah extends CI_Model {

	/** Private Var for datatable **/
    private $post  = array();
	private $table = "T_SKORING_RAMAH";
	private $pKey  = "ID_SKORING";
	private $column_order = array(NULL, 'ID_BATASAN','ID_COMPANY', 'NILAI_ASPEK', 'NILAI_SKORING', 'DATE_INSERT'); //set column for datatable order
    private $column_search = array('NM_COMPANY','NILAI_ASPEK', 'NILAI_SKORING', 'DATE_INSERT'); //set column for datatable search
    private $order = array("ID_BATASAN" => 'DESC'); //default order

    public function __construct(){
    	parent::__construct();
    	$this->post = $this->input->post();
        $this->db = $this->load->database('mso_prod', TRUE);
    }

	/** Fetch table **/
	public function get(){
		$this->db->distinct();
		$this->db->select('c.KRITERIA, a.ID_SKORING, a.ID_BATASAN, a.ID_COMPANY, a.NILAI_ASPEK, a.NILAI_SKORING, a.DATE_INSERT');
		$this->db->select('b.ID_KRITERIA, b.BATASAN');
		$this->db->select('c.ID_ASPEK');
		$this->db->select('d.ID_JENIS_ASPEK, d.ASPEK');
		$this->db->select('e.JENIS_ASPEK, e.BOBOT');
		$this->db->from($this->table . ' a');
		$this->db->join('M_BATASAN b', 'a.ID_BATASAN = b.ID_BATASAN', 'left');
		$this->db->join('M_KRITERIA c', 'b.ID_KRITERIA = c.ID_KRITERIA', 'left');
		$this->db->join('M_ASPEK d', 'c.ID_ASPEK = d.ID_ASPEK', 'left');
		$this->db->join('M_JENIS_ASPEK e', 'd.ID_JENIS_ASPEK = e.ID_JENIS_ASPEK', 'left');
	}

	/** Generate Query for DataTables **/
	public function get_query(){
		$this->get();
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

	/** Get data by id **/
	public function get_by_id($key){
		$this->db->where($this->pKey, $key);
		$this->db->order_by(key($this->order), $this->order[key($this->order)]);
		$query = $this->db->get($this->table);
		return $query->row();
	}

	public function get_nilai($id_jenis_aspek,$date){
		$this->get_query();
		if($id_jenis_aspek != "ALL") {
			$this->db->where('d.ID_JENIS_ASPEK', $id_jenis_aspek);
		}
		$this->db->where("TO_CHAR(DATE_INSERT,'mm/yyyy') = ",$date);
		$this->db->where('c.HIDDEN IS NULL');
		#echo $this->db->get_compiled_select();exit();
		$query = $this->db->get();
		return $query->result();
	}

	public function get_nilai_trend($id_jenis_aspek,$date){
		$this->get_query();
		if($id_jenis_aspek != "ALL") {
			$this->db->where('d.ID_JENIS_ASPEK', $id_jenis_aspek);
		}
		$this->db->where("TO_CHAR(DATE_INSERT,'yyyy') = ",$date);
		$this->db->where('c.HIDDEN IS NULL');
		#echo $this->db->get_compiled_select();exit();
		$query = $this->db->get();
		return $query->result();
	}

	/** Get where **/
	public function get_where($where){
		$this->db->where($where);
		$query = $this->db->get($this->table);
		return $query->result();
	}

	public function check_exists($id_batasan, $id_company, $date){
		$this->db->where('ID_BATASAN', $id_batasan);
		$this->db->where('ID_COMPANY', $id_company);
		$this->db->where("DATE_INSERT","to_date('".$date."','MM/YYYY')", FALSE);
		return (int) $this->db->get($this->table)->num_rows();
	}

	public function generate_report($id_jenis_aspek, $date){
		$this->get_query();
		if($id_jenis_aspek != "ALL") {
			$this->db->where('d.ID_JENIS_ASPEK', $id_jenis_aspek);
		}
		$this->db->where("TO_CHAR(DATE_INSERT,'MM/YYYY')","'$date'", FALSE);
		return $this->db->get()->result();
	}

	/** Count query result after filtered **/
	public function count_filtered(){
		$this->get_query();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Count all result **/
	public function count_all(){
		$this->get();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Count where **/
	public function count_where($where){
		$this->get();
		$this->db->where($where);
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	public function sum_skoring_where($where){
		$from = $this->db->get_compiled_select($this->get());
		$this->db->select('SUM (NILAI_SKORING) AS SUM_SKOR');
		$this->db->from("(".$from.")");
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result();
	}

	/** Execute insert query **/
	public function insert($data, $date) {
		$res = array();
		$this->db->set($this->pKey, "SEQ_".$this->pKey.".NEXTVAL", FALSE);
		$this->db->set("DATE_INSERT","TO_DATE('".$date."','MM/YYYY')", FALSE);
		$this->db->set($data);
		$this->db->insert($this->table);

		if ($this->db->affected_rows()==0) {
			$res['res'] = FALSE;
			$res['msg'] = $this->db->error();
		}else{
			$res['res'] = TRUE;
			$res['msg'] = '';
		}
		return $res;
	}

	/** Execute update query **/
	public function update($id,$data) {
		$this->db->where($this->pKey, $id);
		$this->db->update($this->table, $data);
		if ($this->db->affected_rows()==0) {
			$res['res'] = FALSE;
			$res['msg'] = $this->db->error();
		}else{
			$res['res'] = TRUE;
			$res['msg'] = '';
		}
		return $res;
	}

	/** Execute update where query **/
	public function update_where($where,$data,$date=NULL) {
		if ($date) $this->db->where("DATE_INSERT","to_date('".$date."','MM/YYYY')", FALSE);
		$this->db->where($where);
		$this->db->update($this->table, $data);
		if ($this->db->affected_rows()==0) {
			$res['res'] = FALSE;
			$res['msg'] = $this->db->error();
		}else{
			$res['res'] = TRUE;
			$res['msg'] = '';
		}
		return $res;
	}

	/** Execute delete query by pKey **/
	public function delete($id) {
		$res = array();
		$this->db->delete($this->table, array($this->pKey=>$id));
		if ($this->db->affected_rows()==0) {
			$res['res'] = FALSE;
			$res['msg'] = $this->db->error();
		}else{
			$res['res'] = TRUE;
			$res['msg'] = '';
		}
		return $res;
	}

	/** Execute delete query with where **/
	public function delete_where($where) {
		$res = array();
		$this->db->where($where);
		$this->db->delete($this->table);
		if ($this->db->affected_rows()==0) {
			$res['res'] = FALSE;
			$res['msg'] = $this->db->error();
		}else{
			$res['res'] = TRUE;
			$res['msg'] = '';
		}
		return $res;
	}

}

	/* End of file T_skoring_ramah.php */
	/* Location: ./application/models/T_skoring_ramah.php */
?>
