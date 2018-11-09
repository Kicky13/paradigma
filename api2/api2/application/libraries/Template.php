<?php

class Template {

	private $CI;
	private $domain		= "qm.semenindonesia.co.id";
	private $site_descriptin = "";
	public $web_title 	= "";
	public $cat_alias 	= "all";
	public $admin_tool	= false;
	public $kepo_tool	= false;

	public $cat_list;
	public $recent_update_post;



	private $header		= array(); //
	public $meta;
	private $menu;
	private $path = "adminlte/";
	private $LANG;

	public $MENU_LIST;

	public function __construct(){
		$this->menu = new stdClass();
		$this->meta = new stdClass();
		$this->CI =& get_instance();
	}

	public function adminlte($view="index",$data=false){
		if(!$this->web_title){
			$this->web_title = $this->domain." ".$this->site_descriptin;
		}

		$file_header = __FUNCTION__."/".$this->CI->LANGUAGE."/header";
		$file_footer = __FUNCTION__."/".$this->CI->LANGUAGE."/footer";
		$file_view   = __FUNCTION__."/".$this->CI->LANGUAGE."/".$view;

		if(!@file_exists(APPPATH.'views/'.$file_header.'.php')){
		    $file_header = __FUNCTION__."/header";
		}

		if(!@file_exists(APPPATH.'views/'.$file_footer.'.php')){
		    $file_footer = __FUNCTION__."/footer";
		}

		if(!@file_exists(APPPATH.'views/'.$file_view.'.php')){
		    $file_view = __FUNCTION__."/".$view;
		}

		$data['notice'] = $this->CI->notice->get(); #var_dump($data['notice']);
		
		$data['menulist'] = $this->menu();
		
		
		$this->CI->load->view($file_header,$data);
		$this->CI->load->view($file_view,$data);
		$this->CI->load->view($file_footer);

	}

	public function login($view="login"){
		$data['notice'] = $this->CI->notice->get();
	//	$this->CI->load->view($this->path."header-login",$data);
		$this->CI->load->view($this->path.$view,$data);
	//	$this->CI->load->view($this->path."footer");
	}

	public function nostyle($view,$data=false){
		$this->path = "nostyle/";
		$data['notice'] = $this->CI->notice->get();
		$this->CI->load->view($this->path.$view,$data);
	}

	public function cetak($view,$data=false){
		$this->path = "cetak/";
		$this->CI->load->view($this->path."header-cetak",$data);
		$this->CI->load->view($this->path.$view,$data);
	}

	public function ajax_response($view,$data=false){
		$this->path = "ajax_response/";
		$data['notice'] = $this->CI->notice->get();
		$this->CI->load->view($this->path.$view,$data);
	}

	public function set_meta($name,$content){
		$this->meta->$name = $content;
	}

	public function set_menu($name){
		$this->menu->$name = true;
	}
	
	private function menu(){ 
		//sementara menunggu AD
		$this->CI->load->model("m_menu");
		$r = $this->CI->m_menu->list_active($this->CI->USER->ID_USER); #echo $this->CI->m_menu->get_sql();
		$menu = array();
		$paths = array();
		foreach($r as $i => $m){
			if(!$paths[$m->URL_MENU]){
				$paths[$m->URL_MENU] = 1;
				@$menu[$m->NM_GROUPMENU][$i]->PATH = $m->URL_MENU;
				@$menu[$m->NM_GROUPMENU][$i]->MENU = $m->NM_MENU;
			}
		}
		$paths = null;
		$r =null;
		return $menu;
	}
}

?>
