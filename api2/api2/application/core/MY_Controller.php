<?php

/*
1 Administrator
2 User
3 -
*/

class QMUser extends CI_Controller {
	public $USER;
	public $PERM_READ = NULL;
	public $PERM_WRITE = NULL;
	public $MENU_LIST;
	public $APP = "QM";
	public $AKTIF_ID_GROUPMENU = 9; //dashboard
	public $AKTIF_ID_MENU = 87; //dashboard qm
	public $AKTIF_GROUPMENU = "DASHBOARD"; 
	public $AKTIF_MENU = "DASHBOARD QM"; 
	public $AKTIF_ACTION = 'view'; //default view (datalist
	
	public function __construct() {
        parent::__construct();
		
		if($this->session->has_userdata("APP")){
			$this->APP = $this->session->has_userdata("APP");
		}		
		
		if(!$this->session->has_userdata("USER")){
			redirect("login");
			die();
		}

		$data_user = $this->session->userdata("USER"); 
		unset($data_user->USERPASS);
		$this->USER = $data_user;
		unset($data_user);	
		
		//user authorized
		if($this->uri->segment(1) and $this->uri->segment(1) != "login"){
			$this->load->model("m_authority");
			$permition = $this->m_authority->permition($this->uri->segment(1),$this->USER->ID_USER); #echo $this->m_authority->get_sql();
			if($permition){
				$this->PERM_READ = $permition->PERM_READ;
				$this->PERM_WRITE = $permition->PERM_WRITE;
				$this->AKTIF_GROUPMENU = $permition->NM_GROUPMENU;
				$this->AKTIF_MENU = $permition->NM_MENU;
				$this->AKTIF_ID_GROUPMENU = $permition->ID_GROUPMENU;
				$this->AKTIF_ID_MENU = $permition->ID_MENU;
				$this->AKTIF_ACTION = $this->uri->segment(2);
			}
			else{
				redirect();
			}
			
			if(!$this->PERM_WRITE){
			//	unset($_POST);
			//	$_POST = NULL;
				if(in_array($this->uri->segment(2),array("add","new","create","auth","deauth","edit","update","del","delete","remove","hapus"))){
					redirect($this->uri->segment(1));
				}
			}
		}
		
    }
    
    public function __destruct(){
		foreach($this->db->queries as $q){
			$this->load->helper("file");
			#write_file(APPPATH  . "/logs/sql.log", $q."\n=================================================\n\n", 'a+');
		}
		
		//akses log
		if($this->USER->ID_USER){
			$this->load->model("m_access_log");
			$data[ID_USER] 		= $this->USER->ID_USER;
			$data[ID_GROUPMENU] = $this->AKTIF_ID_GROUPMENU;
			$data[ID_MENU] 		= $this->AKTIF_ID_MENU;
			$data[ACTION] 		= $this->ACTIVE_ACTION;
			$data[URL] 			= current_url();
			$data[IP_ADDRESS]	= $_SERVER['REMOTE_ADDR'];
			$this->m_access_log->insert($data);
			#var_dump($data);
		}
	}

}


class Home extends CI_Controller {
	public $USER;
	public $LANGUAGE = "en";

	public function __construct() {
        parent::__construct();
    }
    
    public function __destruct(){
		//akses log	
		$this->load->model("m_access_log");
		$data[ID_USER] 		= $this->USER->ID_USER;
		$data[ID_GROUPMENU] = $this->AKTIF_ID_GROUPMENU;
		$data[ID_MENU] 		= $this->AKTIF_ID_MENU;
		$data[ACTION] 		= (uri_string() == "login")?"login":$this->ACTIVE_ACTION;
		$data[URL] 			= current_url();
		$data[IP_ADDRESS]	= $_SERVER['REMOTE_ADDR'];
		$this->m_access_log->insert($data);
		#var_dump($data);
	}
	
}

