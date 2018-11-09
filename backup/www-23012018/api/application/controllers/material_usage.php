<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class material_usage extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_material_usage');
    }
    
    public function get_coal_usage() {
        return $this->M_material_usage->get_coal_usage();
    }
    
    public function get_kraft_usage() {
        return $this->M_material_usage->get_kraft_usage();
    }

}
