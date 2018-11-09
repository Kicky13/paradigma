<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class plant_padang extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_plantpadang');
    }

    public function get_state() {
        $this->m_plantpadang->get_state();
    }
    
    public function get_feed() {
        $this->m_plantpadang->get_feed();
    }
    
    public function get_emission() {
        $this->m_plantpadang->get_emission();
    }
    
    public function get_silo() {
        $this->m_plantpadang->get_silo();
    }
    
    public function get_prodjop() {
        $this->m_plantpadang->get_prodjop();
    }
    
    public function get_totaltahun(){
        $this->m_plantpadang->get_totaltahun();
    }
    
    public function get_upto(){
        $this->m_plantpadang->get_upto();
    }
    
    public function get_prodmonth(){
        $this->m_plantpadang->get_prodmonth();
    }
    
    public function get_proddaily(){
        $this->m_plantpadang->get_proddaily();
    }
}
