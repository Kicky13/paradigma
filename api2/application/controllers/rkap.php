<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class rkap extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('M_rkapall');
    }
    
    public function get_rkap_month() {
        $this->M_rkapall->get_rkap_month();
    }
    
    public function get_rkap_year() {
        $this->M_rkapall->get_rkap_year();
    }
}