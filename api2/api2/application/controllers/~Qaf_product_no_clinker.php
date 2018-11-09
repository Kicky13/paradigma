<?php

class Qaf_product extends QMUser {
	
	public $list_config = array();
	public $list_plant = array();
	public $list_company = array();
	public $list_grouparea = array();
	public $list_product = array();
	
	public $ID_COMPANY;
	public $ID_PLANT;
	public $ID_GROUPAREA;
	public $DISPLAY;
	
	public function __construct(){
		parent::__construct();
		$this->load->model("c_qaf_product");
		$this->load->model("m_company");
		$this->load->model("m_plant");
		$this->load->model("m_product");
	}
	
	public function index(){
		$this->edit();
	}
	
	public function by_company($ID_COMPANY=NULL){
		$this->ID_COMPANY = $ID_COMPANY;
		$this->index();
	}
	
	public function add($ID_PLANT=NULL){
		$data_plant = $this->m_plant->get_data_by_id($ID_PLANT);
		$this->ID_PLANT = $ID_PLANT;
		$this->ID_COMPANY = $data_plant->ID_COMPANY;		
		$this->list_company = $this->m_company->datalist();
		$this->list_product = $this->m_product->datalist();
		$this->template->adminlte("v_qaf_product_assign");
	}
	
	public function create(){ 

		$this->c_qaf_product->clean($this->input->post("OPT_PRODUCT")); #echo $this->c_qaf_product->get_sql();
		
		foreach($this->input->post("OPT_PRODUCT") as $ID_PRODUCT){
			$data = false;
			$data['ID_PRODUCT'] 	= $ID_PRODUCT;
			@$this->c_qaf_product->insert($data); #echo $this->c_qaf_product->get_sql();
		}
	
		redirect("qaf_product");
	}
	
	public function edit($ID_PLANT=NULL,$ID_GROUPAREA=NULL){ #die("edit");
		$this->load->model("m_product");
		
		$this->list_product = $this->m_product->datalist();
		
		$this->template->adminlte("v_qaf_product_assign");
	}
	
	public function view($ID_PLANT=NULL,$ID_GROUPAREA=NULL,$DISPLAY=NULL){
		$this->load->model("m_product");
		$this->data_plant = $this->m_plant->get_data_by_id($ID_PLANT);
		
		$this->ID_PLANT = $ID_PLANT;
		$this->ID_GROUPAREA = $ID_GROUPAREA;
		$this->DISPLAY = $DISPLAY;
		$this->ID_COMPANY = $this->data_plant->ID_COMPANY;
		
		$this->list_company = $this->m_company->datalist();
		$this->list_plant = $this->m_plant->datalist($this->data_plant->ID_COMPANY);
		$this->list_grouparea = $this->c_qaf_product->list_grouparea($ID_PLANT);
		$this->list_product = $this->m_product->datalist();
		
		$this->template->adminlte("v_qaf_product_view");
	}
	
	// ajax
	public function list_config_grouparea($ID_PLANT=NULL){
		$data = $this->c_qaf_product->list_grouparea($ID_PLANT);  
		echo json_encode($data);
	}
	
	public function async_list_grouparea($ID_PLANT=NULL){
		$data = $this->c_qaf_product->list_grouparea($ID_PLANT);
		echo json_encode($data);
	}
	
	public function async_configuration($ID_PLANT=NULL,$ID_GROUPAREA=NULL){
		$data = $this->c_qaf_product->configuration();# echo $this->c_qaf_product->get_sql();
		echo json_encode($data);
	}
	
	public function qaf_grouparea(){
		$data = $this->c_qaf_product->qaf_grouparea();
		echo json_encode($data);
	}
}

