<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Project_dash extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_project_dash','',true);
    }

 
     public function index(){
      $param = array();
      $result = $this->m_project_dash->get_project_dash_v2($param);
      $json = array();
      $tag = 0;
      

      foreach ($result as $key => $value) {

          $project = $value['PROJECT'];
          $json[$project]= array(
            'pic' => $value['PIC_Project'],
            'project' => $value['PROJECT'],
            'project_start' => $value ['PROJECT_START'],
            'project_finish' => $value ['PROJECT_FINISH'],
            'project_budget' => $value['TOTAL_BUDGET'],
            'commit' => $value['COMMIT'],
            'cash_out' => $value['CASH_OUT'],
            'spi' => $value['SPI'],
            'cpi' => $value['CPI'],
            'eac' => $value['EAC'],
            'remn_budget' => $value['Remn_Order'],
            'Schedule_In_Progress' => $value['Schedule_In_Progress']
        
            );
      }
      echo json_encode($json);

    }
    
    
}