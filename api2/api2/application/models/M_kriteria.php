<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kriteria extends DB_QM {

	/** Private Var for datatable **/
    private $post  = array();
	private $table = "M_KRITERIA";
	private $pKey  = "ID_KRITERIA";
	private $column_order = array(NULL, 'ID_ASPEK','ASPEK'); //set column for datatable order
    private $column_search = array('JENIS_ASPEK', 'ASPEK', 'KRITERIA'); //set column for datatable search 
    private $order = array("ID_KRITERIA" => 'ASC'); //default order

    public function __construct(){
    	parent::__construct();
    	$this->post = $this->input->post();
    }

	/** Fetch table **/
	public function get(){
		$this->db->select('a.ID_KRITERIA, b.ID_ASPEK, c.JENIS_ASPEK, b.ASPEK, c.BOBOT, a.KRITERIA, a.HIDDEN');
		$this->db->from($this->table . ' a');
		$this->db->join('M_ASPEK b', 'a.ID_ASPEK = b.ID_ASPEK', 'left');
		$this->db->join('M_JENIS_ASPEK c', 'c.ID_JENIS_ASPEK = b.ID_JENIS_ASPEK', 'left');
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
		#echo $this->db->get_compiled_select();die();
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

	/** Get where **/
	public function get_where($where){
		$this->db->where($where);
		$query = $this->db->get($this->table);
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
		$this->get();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Count where **/
	public function count_where($where){
		$this->db->where($where);
		$query = $this->db->get($this->table);
		return (int) $query->num_rows();
	}

	/** Execute insert query **/
	public function insert($data) {
		$res = array();
		$this->db->set($this->pKey,"SEQ_".$this->pKey.".NEXTVAL",FALSE);
		$this->db->set($data);
		$this->db->insert($this->table);
	}

	/** Execute update query **/
	public function update($id,$data) {
		$this->db->where($this->pKey, $id);
		$this->db->update($this->table, $data);
	}

	/** Execute update where query **/
	public function update_where($where,$data) {
		$this->db->where($where);
		$this->db->update($this->table, $data);
	}

	/** Execute delete query by pKey **/
	public function delete($id) {
		$res = array();
		$this->db->delete($this->table, array($this->pKey=>$id));
	}

	/** Execute delete query with where **/
	public function delete_where($where) {
		$res = array();
		$this->db->where($where);
		$this->db->delete($this->table);
	}

	public function toggle_show($id='', $show=0){
		$show = ($show==0) ? NULL:1;
		$this->db->where($this->pKey, $id);
		$this->db->set('HIDDEN', $show);
		$this->db->update($this->table);
	}

}
	
	/* End of file M_jenis_aspek.php */
	/* Location: ./application/models/M_jenis_aspek.php */
?>