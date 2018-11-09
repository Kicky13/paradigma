<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class plant_rembang extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_plantrembang');
    }

    public function get_statefeed() {
        $this->m_plantrembang->get_statefeed();
    }
    
    public function get_emission() {
        $this->m_plantrembang->get_emission();
    }
    
    public function get_silo() {
        $this->m_plantrembang->get_silo();
    }
    
    public function get_packer_machine() {
        $this->m_plantrembang->get_packer_machine();
    }
    
    public function get_palletizer() {
        $this->m_plantrembang->get_palletizer();
    }
    
    public function get_mobile_loader() {
        $this->m_plantrembang->get_mobile_loader();
    }

    public function get_prodjop() {
        $this->m_plantrembang->get_prodjop();
    }
    
    public function get_totaltahun(){
        $this->m_plantrembang->get_totaltahun();
    }
    
    public function get_upto(){
        $this->m_plantrembang->get_upto();
    }
    
    public function get_prodmonth(){
        $this->m_plantrembang->get_prodmonth();
    }
    
    public function get_proddaily(){
        $this->m_plantrembang->get_proddaily();
    }
    
    public function get_ip_report_pie(){
        $this->m_plantrembang->get_ip_report_pie();
    }
    
    public function get_ip_report_column(){
        $this->m_plantrembang->get_ip_report_column();
    }
    
    public function get_ip_notes(){
        $this->m_plantrembang->get_ip_notes();
    }
    
    public function get_ip_tahun(){
        $this->m_plantrembang->get_ip_tahun();
    }
    
    public function get_ip_dash(){
        $this->m_plantrembang->get_ip_dash();
    }
    
    public function get_ip_report_detail(){
        $this->m_plantrembang->get_ip_report_detail();
    }
}
