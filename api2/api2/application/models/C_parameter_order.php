<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_parameter_order extends DB_QM {

	/** Private Var for datatable **/
	private $column_order = array(NULL, 'ID_C_PARAMETER_ORDER','ID_GROUPAREA','URUTAN'); //set column for datatable order
    private $column_search = array('ID_C_PARAMETER_ORDER','ID_GROUPAREA','URUTAN'); //set column for datatable search 
    private $order = array("URUTAN" => 'ASC'); //default order
    private $pKey = "ID_C_PARAMETER_ORDER";
    private $table = "C_PARAMETER_ORDER";

	public function query(){
		$this->db->select("a.ID_GROUPAREA, a.ID_COMPONENT, a.DISPLAY, a.URUTAN");
		$this->db->select("b.KD_GROUPAREA, b.NM_GROUPAREA");
		$this->db->select("c.KD_COMPONENT, c.NM_COMPONENT");
		$this->db->from($this->table . " a");
		$this->db->join('M_GROUPAREA b', 'a.ID_GROUPAREA = b.ID_GROUPAREA', 'left');
		$this->db->join('M_COMPONENT c', 'a.ID_COMPONENT = c.ID_COMPONENT', 'left');
		$this->db->order_by(key($this->order), $this->order[key($this->order)]);
	}

	public function get_component($group, $display=NULL){
		$this->query();
		$this->db->where('a.ID_GROUPAREA', $group);
		if($display) $this->db->where('a.DISPLAY', $display);
		#echo $this->db->get_compiled_select();exit();
		$query = $this->db->get();
		return $query->result();
	}

	public function get_where($where){
		$this->db->where($where);
		$query = $this->db->get($this->table);
		return $query->result();
	}

	public function check_exists($data){
		$this->db->where('ID_GROUPAREA', $data['ID_GROUPAREA']);
		$this->db->where('ID_COMPONENT', $data['ID_COMPONENT']);
		if($data['DISPLAY']) $this->db->where('DISPLAY', $data['DISPLAY']);
		$query = $this->db->get($this->table);
		return $query->result();
	}

	public function insert($data){
		$this->db->set($data);
		$this->db->insert($this->table);
	}

	/** Execute update where query **/
	public function update_where($where,$data) {
		$this->db->where($where);
		$this->db->update($this->table, $data);
	}

	public function update_urutan($data){
		$this->db->set('URUTAN', $data['URUTAN']);
		$this->db->where('ID_GROUPAREA', $data['ID_GROUPAREA']);
		$this->db->where('ID_COMPONENT', $data['ID_COMPONENT']);
		if($data['DISPLAY']) $this->db->where('DISPLAY', $data['DISPLAY']);
		//echo $this->db->get_compiled_select();exit();
		$this->db->update($this->table);
	}

	public function clean($ID_GROUPAREA,$KEEP,$DISPLAY){
		$this->db->where("ID_GROUPAREA",$ID_GROUPAREA);
		$this->db->where("DISPLAY",$DISPLAY);
		$this->db->where_not_in("ID_COMPONENT",$KEEP);
		//echo $this->db->get_compiled_select();exit();
		$this->db->delete("C_PARAMETER_ORDER");
	}

}

/* End of file C_parameter_order.php */
/* Location: ./application/models/C_parameter_order.php */
?>
