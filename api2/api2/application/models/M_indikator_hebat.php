<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_indikator_hebat extends DB_QM {

	/** Private Var for datatable **/
    private $post  = array();
	private $table = "M_INDIKATOR_HEBAT";
	private $pKey  = "ID_INDIKATOR";
	private $column_order = array(NULL, 'ID_INDIKATOR','RASIO_AWAL', 'RASIO_AKHIR', 'SKOR'); //set column for datatable order
    private $column_search = array('BATASAN','RASIO_AWAL', 'RASIO_AKHIR', 'SKOR', 'CATATAN'); //set column for datatable search 
    private $order = array("ID_INDIKATOR" => 'DESC'); //default order

    public function __construct(){
    	parent::__construct();
    	$this->post = $this->input->post();
    }

	/** Fetch table **/
	public function get(){
		$this->db->select('a.ID_INDIKATOR, a.ID_BATASAN, a.INDIKATOR, a.RASIO_AWAL, a.RASIO_AKHIR, a.SKOR, a.CATATAN');
		$this->db->select('b.BATASAN, b.ID_KRITERIA');
		$this->db->select('c.ID_ASPEK, c.KRITERIA, c.BOBOT');
		$this->db->select('d.ASPEK');
		$this->db->from($this->table . ' a');
		$this->db->join('M_BATASAN_HEBAT b', 'a.ID_BATASAN = b.ID_BATASAN', 'left');
		$this->db->join('M_KRITERIA_HEBAT c', 'b.ID_KRITERIA = c.ID_KRITERIA', 'left');
		$this->db->join('M_ASPEK_HEBAT d', 'c.ID_ASPEK = d.ID_ASPEK', 'left');
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
		$this->get();
		$this->db->where($this->pKey, $key);
		$this->db->order_by(key($this->order), $this->order[key($this->order)]);
		$query = $this->db->get();
		return $query->row();
	}

	/** Get where **/
	public function get_where($where){
		$this->db->where($where);
		$query = $this->db->get($this->table);
		return $query->result();
	}

	/** Get Skor **/
	public function get_skor($id_batasan, $nilai){
		$this->db->select('SKOR');
		$this->db->where('ID_BATASAN', $id_batasan);
		$this->db->where("$nilai BETWEEN RASIO_AWAL AND RASIO_AKHIR");
		$query = $this->db->get($this->table);
		
		if ((int) $query->num_rows() < 1) {
			$ret = 0;
		}else{
			$ret = $query->row()->SKOR;
		}

		return (int) $ret;
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
		$this->db->set($this->pKey,"SEQ_".$this->pKey."_HEBAT.NEXTVAL",FALSE);
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
		$this->db->delete($this->table, array($this->pKey=>$id));
	}

	/** Execute delete query with where **/
	public function delete_where($where) {
		$this->db->where($where);
		$this->db->delete($this->table);
	}

}
	
	/* End of file M_indikator_hebat.php */
	/* Location: ./application/models/M_indikator_hebat.php */
?>