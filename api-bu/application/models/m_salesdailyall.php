<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class m_salesdailyall extends CI_Model {
    private $_myTable = "ZREPORT_RPTREAL_RESUM";
    private $db ;     
    function get_data($param){
        $this->db=$this->load->database('default5',true);
        $result = $this->db->query("SELECT 
               tahun,
               bulan,
               SUM (target_rkap) trkap,
               SUM (realto)    trealto,
               SUM (revenu_real) revreal,
               SUM (revenu_rkap) revrkap,
               SUM (price_real) prreal,
               SUM (price_rkap) prrkap
          FROM zreport_rptreal_resum
         WHERE  tahun = '2016' 
      GROUP BY  tahun, bulan
      ORDER BY bulan");
      return $result->result();
    }
        
    
}