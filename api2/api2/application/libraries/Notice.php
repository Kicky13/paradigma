<?php

Class Notice {
	public function __construct(){
		$this->msg = new stdClass();
		$this->CI =& get_instance();
	}
	
	public function success($msg){
		$this->build("success",$msg);
	}
	
	public function error($msg){ 
		$msg = (preg_match("/ORA-02292/",$msg))?"Can not delete data, dueto data being used.":$msg;
		$this->build("error",$msg);
	}
	
	public function warning($msg){
		$this->build("warning",$msg);
	}
	
	public function set($var,$msg){
		$this->build($var,$msg);
	}
	
	public function get($var=null){ 
		$notice = $this->CI->session->flashdata("notice"); 
		if($var) return $notice->$var;
		return $notice;
	}
	
	public function build($var,$msg){
		$notice = $this->CI->session->flashdata("notice");
		if(!$notice) $notice = new stdClass();
		$notice->$var = $msg;
		$this->CI->session->set_flashdata("notice",$notice);
		
	}
}
?>
