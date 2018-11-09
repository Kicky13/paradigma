<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_product extends DB_QM {

	/** Private Var for datatable **/
	private $table = "C_PRODUCT";
	private $pKey  = "ID_C_PRODUCT";
	private $column_order = array(NULL, 'KD_COMPANY','KD_PLANT','ID_GROUPAREA'); //set column for datatable order
    private $column_search = array('NM_COMPANY','NM_PLANT','NM_AREA'); //set column for datatable search 
    private $order = array("ID_C_PRODUCT" => 'desc'); //default order

	/** Fetch table **/
	public function get(){
		$this->db->select("a.ID_AREA, a.KD_AREA, a.NM_AREA, b.ID_PLANT, b.KD_PLANT, b.NM_PLANT, c.ID_COMPANY, c.KD_COMPANY, c.NM_COMPANY");
		$this->db->from("M_AREA a");
		$this->db->join("M_PLANT b","a.ID_PLANT=b.ID_PLANT","LEFT");
		$this->db->join("M_COMPANY c","b.ID_COMPANY=c.ID_COMPANY","LEFT");
	}

	/** Fetch table **/
	public function get_product(){
		$this->db->select("a.*, c.KD_PRODUCT, c.NM_PRODUCT");
		$this->db->from("C_PRODUCT a");
		$this->db->join("M_AREA b","b.ID_AREA = a.ID_AREA","LEFT");
		$this->db->join("M_PRODUCT c","c.ID_PRODUCT=a.ID_PRODUCT","LEFT");
		$this->db->join("M_PLANT d","b.ID_PLANT=d.ID_PLANT","LEFT");
	}

    public function datalist($ID_AREA=NULL, $ID_PLANT=NULL, $ID_COMPANY=NULL){		
    	$this->get_product();
		if($ID_COMPANY) $this->db->where("d.ID_COMPANY", $ID_COMPANY);
		if($ID_PLANT) $this->db->where("d.ID_PLANT", $ID_PLANT);
		if($ID_AREA) $this->db->where("a.ID_AREA", $ID_AREA);
		return $this->db->get()->result();
	}

	/** Generate Query for DataTables **/
	public function get_query_product(){
		$this->get_product();
		if(isset($this->post["id_area"])) $this->db->where("a.ID_AREA", $this->post["id_area"]);
		if(isset($this->post["id_plant"])) $this->db->where("d.ID_PLANT", $this->post["id_plant"]);
		if(isset($this->post["id_company"])) $this->db->where("d.ID_COMPANY", $this->post["id_company"]);
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
	public function get_list_product() {
		$this->get_query_product();

		if($this->input->post('length') != -1){
			$this->db->limit($this->input->post('length'),$this->input->post('start'));
			$query = $this->db->get();
		}else{
			$query = $this->db->get();
		}

		return $query->result();
	}

	/** Count query result after filtered **/
	public function count_filtered_product(){
		$this->get_query_product();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Count all result **/
	public function count_all_product(){
		$this->get_product();
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Generate Query for DataTables **/
	public function get_query(){
		$this->get();
		if(isset($this->post["company"])) $this->db->where("c.ID_COMPANY", $this->input->post("company"));
		if(isset($this->post["plant"])) $this->db->where("a.ID_PLANT", $this->input->post("plant"));
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

	public function or_where($array=''){
		$this->get_product();
		$this->db->where_in("a.ID_AREA", $array);
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
		$this->db->where($where);
		$query = $this->db->get($this->table);
		return (int) $query->num_rows();
	}

	public function clean($ID_AREA){
		$this->db->where("ID_AREA",$ID_AREA);
		$this->db->delete($this->table);
	}

	public function insert($data){
		$this->db->set("ID_C_PRODUCT","SEQ_ID_C_PRODUCT.NEXTVAL",FALSE);
		$this->db->set($data);
		$this->db->insert($this->table);
	}

	/** Execute insert query **/
	public function _insert($data) {
		$res = array();
		$this->db->insert($this->table, $data);
		if ($this->db->affected_rows()==0) {
			$res['res'] = FALSE;
			$res['msg'] = $this->db->error();
		}else{
			$res['res'] = $this->db->insert_id();
			$res['msg'] = '';
		}
		return $res;
	}

	/** Execute update query **/
	public function _update($id,$data) {
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
	public function _update_where($where,$data) {
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
	public function _delete($id) {
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
	public function _delete_where($where) {
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