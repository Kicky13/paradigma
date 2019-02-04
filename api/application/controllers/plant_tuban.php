<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class plant_tuban extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_planttuban');
    }

    // <editor-fold defaultstate="collapsed" desc="Tuban Real Time">
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

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="PIS Real Time Dashboard">
    public function get_mimic_tb34() {
        $this->m_planttuban->get_mimic_tb34();
    }

    public function raw_mill_tb4() {
        $this->m_planttuban->raw_mill_tb4();
    }

    public function finish_mill7_tb4() {
        $this->m_planttuban->finish_mill7_tb4();
    }

    public function finish_mill8_tb4() {
        $this->m_planttuban->finish_mill8_tb4();
    }

    public function kiln_tb4() {
        $this->m_planttuban->kiln_tb4();
    }

    public function cooler_tb4() {
        $this->m_planttuban->cooler_tb4();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Production">
    public function get_prodjop() {
        $this->m_planttuban->get_prodjop();
    }

    public function get_totaltahun() {
        $this->m_planttuban->get_totaltahun();
    }

    public function get_upto() {
        $this->m_planttuban->get_upto();
    }

    public function get_prodmonth() {
        $this->m_planttuban->get_prodmonth();
    }

    public function get_proddaily() {
        $this->m_planttuban->get_proddaily();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Inspection">
    public function get_ip_report_pie() {
        $this->m_planttuban->get_ip_report_pie();
    }

    public function get_ip_report_column() {
        $this->m_planttuban->get_ip_report_column();
    }

    public function get_ip_notes() {
        $this->m_planttuban->get_ip_notes();
    }

    public function get_ip_tahun() {
        $this->m_planttuban->get_ip_tahun();
    }

    public function get_ip_dash() {
        $this->m_planttuban->get_ip_dash();
    }

    public function get_ip_report_detail() {
        $this->m_planttuban->get_ip_report_detail();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Performance">

    public function get_pm_dash() {
        $this->m_planttuban->get_pm_dash();
    }

    public function get_pm_detail() {
        $this->m_planttuban->get_pm_detail();
    }

    public function get_pm_note() {
        $this->m_planttuban->get_pm_note();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Real Time Cigading">

    public function get_statefeedcgd() {
        $this->m_planttuban->get_statefeedcgd();
    }

    public function get_silocgd() {
        $this->m_planttuban->get_silocgd();
    }

    public function get_emisicgd() {
        $this->m_planttuban->get_emisicgd();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Real Time Gresik">

    public function get_packercgd() {
        $this->m_planttuban->get_packercgd();
    }

    public function get_statefeedgrs() {
        $this->m_planttuban->get_statefeedgrs();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="FMEA">
    public function get_fmea_level() {
        $this->m_planttuban->get_fmea_level();
    }

    public function get_fmea_exec() {
        $this->m_planttuban->get_fmea_exec();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Maintenance Cost">

    public function get_mt_quarter() {
        $this->m_planttuban->get_mt_quarter();
    }

    public function get_mt_chart_dept() {
        $this->m_planttuban->get_mt_chart_dept();
    }

    public function get_mt_table_dept() {
        $this->m_planttuban->get_mt_table_dept();
    }

    public function get_mt_chart_cost() {
        $this->m_planttuban->get_mt_chart_cost();
    }

    public function get_mt_table_cost() {
        $this->m_planttuban->get_mt_table_cost();
    }

    public function get_mt_rr() {
        $this->m_planttuban->get_mt_rr();
    }

    public function get_mt_rr_year() {
        $this->m_planttuban->get_mt_rr_year();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="PdM Concept by Akbar & Boss VIP">
    function get_pdmsampledata() {
        $this->m_planttuban->get_pdmsampledata();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="ARA : PdM">
    function ara_pdm() {
        $this->m_planttuban->ara_pdm();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="SHE Room Temp">
    function get_tb34_roomtemp() {
        $this->m_planttuban->get_tb34_roomtemp();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="OEE">
    function get_oee() {
        $this->m_planttuban->get_oee();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Third-party Material">
    function get_m3_tb34() {
        $this->m_planttuban->get_m3_tb34();
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="OPFM">
    function get_ofpm_fm7() {
        $this->m_planttuban->get_ofpm_fm7();
    }
    
    function get_ofpm_fm8() {
        $this->m_planttuban->get_ofpm_fm8();
    }

    // </editor-fold>
}
