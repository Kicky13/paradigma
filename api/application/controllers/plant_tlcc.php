<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class plant_tlcc extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_planttlcc');
    }

    public function get_silo() {

        $this->M_planttlcc->get_silo();
    }
    
    public function get_emission() {

        $this->M_planttlcc->get_emission();
    }
    
    public function get_statefeed() {

        $this->M_planttlcc->get_statefeed();
    }
    
    public function get_prodjop(){
        $this->M_planttlcc->get_prodjop();
    }
    
    public function get_totaltahun(){
        $this->M_planttlcc->get_totaltahun();
    }
    
    public function get_upto(){
        $this->M_planttlcc->get_upto();
    }
    
    public function get_prodmonth(){
        $this->M_planttlcc->get_prodmonth();
    }
    
    public function get_proddaily(){
        $this->M_planttlcc->get_proddaily();
    }
    
    
    public function get_pm_dash() {
        $this->M_planttlcc->get_pm_dash();
    }

    public function get_pm_detail() {
        $this->M_planttlcc->get_pm_detail();
    }

    public function get_pm_note() {
        $this->M_planttlcc->get_pm_note();
    }
}
