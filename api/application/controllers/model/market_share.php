<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Market_share extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_msnasional','ms',true);
    }
    
    function smi(){

      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $com = (empty($_GET['company']) ? '' : $_GET['company']);

      $param = array('month' => $month, 'year' => $year,'last_month' => $month-1, 'last_year' => $year-1, 'company' => $com);

      echo json_encode($param);

    }
    
    
}