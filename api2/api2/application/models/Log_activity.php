<?php

class Log_activity Extends DB_QM {
	
	public function insert($data){
		$this->db->set("ID_LOG_ACTIVITY","SEQ_ID_LOG_ACTIVITY.NEXTVAL", FALSE);
		$this->db->set("ID_USER", $data['ID_USER']);
		$this->db->set("IP_ADDRESS", $data['IP_ADDRESS']);
		$this->db->set("CONTROLLER", $data['CONTROLLER']);
		$this->db->set("GET_ACCESS", $data['METHOD']);
		$this->db->set("DATA_LOG", $data['DATA']);
		$this->db->set("ACCESS_TIME", "SYSDATE", FALSE);
		$this->db->insert("LOG_ACTIVITY");
	}

}
