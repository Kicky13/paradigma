<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class plant_rembang extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_plantrembang');
    }

    // <editor-fold defaultstate="collapsed" desc="PLANT OVERVIEW">
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

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="PRODUCTION">
    public function get_prodjop() {
        $this->m_plantrembang->get_prodjop();
    }

    public function get_totaltahun() {
        $this->m_plantrembang->get_totaltahun();
    }

    public function get_upto() {
        $this->m_plantrembang->get_upto();
    }

    public function get_prodmonth() {
        $this->m_plantrembang->get_prodmonth();
    }

    public function get_proddaily() {
        $this->m_plantrembang->get_proddaily();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="INSPECTION">
    public function get_ip_report_pie() {
        $this->m_plantrembang->get_ip_report_pie();
    }

    public function get_ip_report_column() {
        $this->m_plantrembang->get_ip_report_column();
    }

    public function get_ip_notes() {
        $this->m_plantrembang->get_ip_notes();
    }

    public function get_ip_tahun() {
        $this->m_plantrembang->get_ip_tahun();
    }

    public function get_ip_dash() {
        $this->m_plantrembang->get_ip_dash();
    }

    public function get_ip_report_detail() {
        $this->m_plantrembang->get_ip_report_detail();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="DASHBOARD PIS">
    public function raw_mill() {
        $this->m_plantrembang->raw_mill();
    }
    
    public function cooler() {
        $this->m_plantrembang->cooler();
    }
    
    public function kiln() {
        $this->m_plantrembang->kiln();
    }
    
    public function finish_mill1() {
        $this->m_plantrembang->finish_mill1();
    }
    
    public function finish_mill2() {
        $this->m_plantrembang->finish_mill2();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Performance">
    public function get_pm_dash() {
        $this->m_plantrembang->get_pm_dash();
    }

    public function get_pm_detail() {
        $this->m_plantrembang->get_pm_detail();
    }

    public function get_pm_note() {
        $this->m_plantrembang->get_pm_note();
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="ARA : PdM">
    function ara_pdm(){
        
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Quality Management Online">
    function qm_cement(){
        $this->m_plantrembang->qm_cement();
    }
    
    function qm_clinker(){
        $this->m_plantrembang->qm_clinker();
    }
    // </editor-fold>
        
    // <editor-fold defaultstate="collapsed" desc="QMO Table Logger 146">
    function dump_qmtbl_cement() {
        $this->m_plantrembang->dump_qmtbl_cement();
    }
    
    function dump_qmtbl_clinker() {
        $this->m_plantrembang->dump_qmtbl_clinker();
    }
    // </editor-fold>
}
