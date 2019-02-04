<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class plant_tonasa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_planttonasa');
    }

    public function get_statefeed() {

        $this->m_planttonasa->get_statefeed();
    }
    
    public function get_silo() {

        $this->m_planttonasa->get_silo();
    }
    
    public function get_emission() {

        $this->m_planttonasa->get_emission();
    }
    
    public function get_prodjop() {

        $this->m_planttonasa->get_prodjop();
    }
    
    public function get_totaltahun(){
        $this->m_planttonasa->get_totaltahun();
    }
    
    public function get_upto(){
        $this->m_planttonasa->get_upto();
    }
    
    public function get_prodmonth(){
        $this->m_planttonasa->get_prodmonth();
    }
    
    public function get_proddaily(){
        $this->m_planttonasa->get_proddaily();
    }
    
    public function get_btg_pwrmon() {
        $this->m_planttonasa->get_btg_pwrmon();
    }
    
    public function get_btg_power() {
        $this->m_planttonasa->get_btg_power();
    }
    
    public function get_btg_pltu() {
        $this->m_planttonasa->get_btg_pltu();
    }
    
    public function get_btg_status() {
        $this->m_planttonasa->get_btg_status();
    }
    
    public function get_btg_pwrdby() {
        $this->m_planttonasa->get_btg_pwrdby();
    }
    
    
    public function get_pm_dash() {
        $this->m_planttonasa->get_pm_dash();
    }

    public function get_pm_detail() {
        $this->m_planttonasa->get_pm_detail();
    }

    public function get_pm_note() {
        $this->m_planttonasa->get_pm_note();
    }
    
    public function get_oee() {
        $this->m_planttonasa->get_oee();
    }
    
    public function get_electical_sub() {
        $this->m_planttonasa->get_electical_sub();
    }
    
    public function get_data_prod() {
        $this->m_planttonasa->get_data_prod();
    }
    
    // <editor-fold defaultstate="collapsed" desc="QCX">
    function qm_cement() {
        $this->m_planttonasa->qm_cement();
    }
    
    function qm_clinker() {
        $this->m_planttonasa->qm_clinker();
    }
    // </editor-fold>
}
