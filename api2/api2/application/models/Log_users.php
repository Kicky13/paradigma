<?php

class Log_Users Extends DB_GOHELPS {
	public function set($ID_USER){
		$this->db->set("ID_USER",$ID_USER);
		$this->db->insert("log_users");
	}
}