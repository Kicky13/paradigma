<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class C_coalstock extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_coalstock');
    }
    
    public function get_bahan_chart() {
        $this->M_coalstock->get_bahan_chart();
    }
    
    public function get_data_bahan() {
        $this->M_coalstock->get_data_bahan();
    }
    
    public function tes() {
        $this->M_coalstock->tes();
    }
}