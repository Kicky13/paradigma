<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class plant_gresik extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_plantgresik');
    }

    public function get_statefeed() {

        $this->M_plantgresik->get_statefeed();
    }
    
    public function get_emission() {

        $this->M_plantgresik->get_emission();
    }
    
    public function get_silo() {

        $this->M_plantgresik->get_silo();
    }
}