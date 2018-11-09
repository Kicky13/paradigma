<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class plant_tuban extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_planttuban');
    }

    public function get_statefeed() {

        $this->m_planttuban->get_statefeed();
    }
    
    public function get_statefeedtb12() {

        $this->m_planttuban->get_statefeedtb12();
    }
    
    public function get_emission() {

        $this->m_planttuban->get_emission();
    }
    
    public function get_emissiontb12() {

        $this->m_planttuban->get_emissiontb12();
    }
    
    public function get_silo() {

        $this->m_planttuban->get_silo();
    }
    
    public function get_silotb12() {

        $this->m_planttuban->get_silotb12();
    }
    
    public function get_opcdb() {

        $this->m_planttuban->get_opcdb();
    }
    
    public function get_prodjop() {

        $this->m_planttuban->get_prodjop();
    }
    
    public function get_totaltahun(){
        $this->m_planttuban->get_totaltahun();
    }
    
    public function get_upto(){
        $this->m_planttuban->get_upto();
    }
    
    public function get_prodmonth(){
        $this->m_planttuban->get_prodmonth();
    }
    
    public function get_proddaily(){
        $this->m_planttuban->get_proddaily();
    }
    
    public function get_ip_report_pie(){
        $this->m_planttuban->get_ip_report_pie();
    }
    
    public function get_ip_report_column(){
        $this->m_planttuban->get_ip_report_column();
    }
    
    public function get_ip_notes(){
        $this->m_planttuban->get_ip_notes();
    }
    
    public function get_ip_tahun(){
        $this->m_planttuban->get_ip_tahun();
    }
    
    public function get_ip_dash(){
        $this->m_planttuban->get_ip_dash();
    }
    
    public function get_ip_report_detail(){
        $this->m_planttuban->get_ip_report_detail();
    }
}
