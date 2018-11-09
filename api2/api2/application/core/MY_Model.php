<?php


class MY_Model extends CI_Model {
	public $error 		= "";
	public $insert_id	= "";
	public $sql			= "";
	
	public function __construct() {
        parent::__construct();
    }
	
	public function get_error(){
		$e = $this->db->error();
		$this->error = $e["message"];
		return $this->error;
	}
	
	public function insert_id(){
		$this->insert_id = $this->db->insert_id();
		return $this->insert_id;
	}
	
	public function get_sql(){
		$this->sql = $this->db->last_query();
		return $this->sql;
	}
	
	public function error(){
		return $this->get_error();
	}
}

class DB_QM extends MY_Model {
    public function __construct() {
        parent::__construct();
		$this->load->database();
    }
}

class QMDEV extends MY_Model {
    public function __construct() {
        parent::__construct();
		$this->load->database('dev');
    }
}
