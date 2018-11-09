<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_competitor_tu extends CI_Model {

  public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default5', TRUE);
    }

    function getDataSemua(){
		$data = $this->db->query("SELECT
                                        TB1.ID,
                                        TB1.KODE_PERUSAHAAN,
                                        TB3.NAMA_PERUSAHAAN,
                                        TB1.FASILITAS KODE_FASILITAS,
                                        TB2.NAMA FASILITAS,
                                        TB1.NAMA NAMA_FASILITAS,
                                        TB1.LATITUDE,
                                        TB1.LONGITUDE,
                                        TB1.STATUS
                                FROM
                                        SCM_MI_PRSH_FASILITAS TB1
                                JOIN SCM_MI_M_FASILITAS TB2 ON TB1.FASILITAS = TB2.ID
                                JOIN ZREPORT_MS_PERUSAHAAN TB3 ON TB1.KODE_PERUSAHAAN = TB3.KODE_PERUSAHAAN");
    	// $data = $this->db->query("SELECT * FROM ZREPORT_MS_PRSH_FASILITAS");
		return $data->result_array();
	}       

}