<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class pmequipment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_pmequipment');
    }

    public function get_yield() {
        $this->M_pmequipment->get_yield();
    }
    
    public function get_utilize() {
        $this->M_pmequipment->get_utilize();
    }
    
    public function get_efficiency() {
        $this->M_pmequipment->get_efficiency();
    }

}
