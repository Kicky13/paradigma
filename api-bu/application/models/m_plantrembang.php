<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_plantrembang extends CI_Model {

    // <editor-fold defaultstate="collapsed" desc="PLANT OVERVIEW">
    public function get_statefeed() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang.RM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.RM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.CM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.CM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.KL1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.KL1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.FM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.FM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.FM2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.FM2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($seta);
    }

    public function get_emission() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang.RM_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.KL_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($seta);
    }

    public function get_silo() {
        $mySiloURL = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang.Silo_1_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.Silo_2_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.Silo_3_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.Silo_1_Percent%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.Silo_2_Percent%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.Silo_3_Percent%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($mySiloURL);
    }
    
    public function get_packer_machine() {
        $packer = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang_Packer.PM01_Bag_Rel%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Bag_Rel%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Bag_Rel%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Bag_Rel%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($packer);
    }
    
    public function get_palletizer() {
        $packer = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang_Palletizer.PZ01_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ01_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ01_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ01_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ01_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ01_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($packer);
    }
    
    public function get_mobile_loader() {
        $packer = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang_Packer.CS01_BK01_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK01_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK01_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK01_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK01_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK02_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK02_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK02_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK02_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK02_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_Level%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK01_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK01_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK01_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK01_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK01_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK02_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK02_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK02_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK02_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK02_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_Level%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK01_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK01_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK01_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK01_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK01_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK02_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK02_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK02_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK02_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK02_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_Level%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($packer);
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="PRODUCTION">

    public function get_totaltahun() {
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (strlen($bulan) < 2) {
            $month = '0' . $bulan;
        } else {
            $month = $bulan;
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }
        
        if (empty($_GET['bulan']) && empty($_GET['tahun'])){
            $sql = "SELECT
                                    SUM (RM1_PROD) AS rawmill,
                                    SUM (KL1_PROD) AS kiln,
                                    SUM (FM1_PROD) + SUM (FM2_PROD) AS finishmill
                            FROM
                                    PIS_SGR_PRODMONTH WHERE MONTH_PROD LIKE '%" . $tahun . "%'";
        } else {
            $sql = "SELECT
                                    SUM (RM1_PROD) AS rawmill,
                                    SUM (KL1_PROD) AS kiln,
                                    SUM (FM1_PROD) + SUM (FM2_PROD)AS finishmill
                            FROM
                                    PIS_SGR_PRODMONTH WHERE MONTH_PROD LIKE '" . $tahun . "-" . $month . "'";
        }

        $query = $db->query($sql);

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RAWMILL'], 2, ".", "");
            $kl = number_format($rowID['KILN'], 2, ".", "");
            $fm = number_format($rowID['FINISHMILL'], 2, ".", "");
        }

        $data = array('pabrik' => 'SGR',
            'rawmill' => $rm,
            'kiln' => $kl,
            'finishmill' => $fm
        );

        echo json_encode($data);
    }
    
    public function get_upto() {
        $db = $this->load->database('oramso', true);
        
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    SUM (RM1_PROD) AS rawmill,
                                    SUM (KL1_PROD) AS kiln,
                                    SUM (FM1_PROD) + SUM (FM2_PROD) AS finishmill
                            FROM
                                    PIS_SGR_PRODMONTH
                            WHERE
                                    MONTH_PROD LIKE '%$tahun%'");

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RAWMILL'], 2, ".", "");
            $kl = number_format($rowID['KILN'], 2, ".", "");
            $fm = number_format($rowID['FINISHMILL'], 2, ".", "");
        }

        $data = array('pabrik' => 'SGR',
            'rawmill' => $rm,
            'kiln' => $kl,
            'finishmill' => $fm
        );

        echo json_encode($data);
    }

    public function get_proddaily() {
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    *
                            FROM
                                    V_PIS_SGR_PLANT
                            WHERE
                                    TO_CHAR (OPDATE, 'YYYY-MM') = '" . $tahun . "-" . $bulan . "'
                            ORDER BY
                                    OPDATE ASC");

        foreach ($query->result_array() as $rowID) {
            $runHours [$rowID['TAGID']][] = $rowID['RUNHOURS'];
            $idJson [$rowID['TAGID']] = array('tagid' => $rowID['TAGID'],
                'name' => $rowID['TEXT'],
                'pabrik' => $rowID['PABRIK']
            );

            $seqTgl = date('d', strtotime($rowID['OPDATE']));
            if ($seqTgl != 0 or ! empty($seqTgl)) {
                $prod[$rowID['TAGID']][$seqTgl] = array(
                    'rate' => number_format($rowID['RATE'], 0, ",", "."),
                    'prod' => number_format($rowID['PROD'], 0, ",", "."));
            }
            $toprod[$rowID['TAGID']][] = number_format($rowID['PROD'], 0, ",", ".");
        }

        foreach ($idJson as $alpha) {
            $runHours_x[$alpha['tagid']] = array("plant" => $alpha['pabrik'],
                "name" => $alpha['name'],
                "tagid" => $alpha['tagid'],
                "runhours" => array_sum($runHours [$alpha['tagid']]),
                "tproduksi" => array_sum($toprod[$alpha['tagid']]),
                "produksi" => $prod[$alpha['tagid']],
            );
        }
        echo json_encode($runHours_x);
    } //unused

    public function get_prodmonth() {
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    TAHUN,
                                    BULAN,
                                    CEMENT,
                                    CLINKER
                            FROM
                                    PIS_RKAP_TOTAL
                            WHERE
                                    COMPANY = 5000
                            AND TAHUN = '" . $tahun . "'");

        foreach ($query->result_array() as $rowID) {
            $bln = $rowID['BULAN'];
            $panjang = strlen($bln);
            if ($panjang == 1) {
                $blnku = '0' . $bln;
            } else {
                $blnku = $bln;
            }
            $thn = $rowID['TAHUN'];
            $month = $thn . '-' . $blnku;
            $rkap_cement = $rowID['CEMENT'];
            $rkap_clinker = $rowID['CLINKER'];

            $rkap[$month] = array(
                "rkap_cement" => $rkap_cement,
                "rkap_clinker" => $rkap_clinker
            );
        }

        $query_data = $db->query("SELECT
                                        MONTH_PROD,
                                        RM1_PROD,
                                        KL1_PROD,
                                        FM1_PROD,
                                        FM2_PROD
                                FROM
                                        PIS_SGR_PRODMONTH
                                WHERE MONTH_PROD LIKE '$tahun-%'
                                ORDER BY
                                        MONTH_PROD");

        foreach ($query_data->result_array() as $rowID) {
            $month = $rowID['MONTH_PROD'];

            $rm1 = $rowID['RM1_PROD'];

            $kl1 = $rowID['KL1_PROD'];

            $fm_rb1 = $rowID['FM1_PROD']; 
            $fm_rb2 = $rowID['FM2_PROD'];

            $to_prod[$month] = array(
                "rm1" => number_format($rm1, 2, ".", ""),
                "kl1" => number_format($kl1, 2, ".", ""),
                "fm_rb1" => number_format($fm_rb1, 2, ".", ""),
                "fm_rb2" => number_format($fm_rb2, 2, ".", "")
            );
        }

        $myJSON = array(
            "rkap" => $rkap,
            "prod" => $to_prod
        );
        echo '{"5000":' . json_encode($myJSON) . '}';
    }

    public function get_prodjop() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                    SUM (RM1_PROD) AS RM1_PROD,
                    SUM (RM1_JOP) AS RM1_JOP,
                    SUM (KL1_PROD) AS KL1_PROD,
                    SUM (KL1_JOP) AS KL1_JOP,
                    SUM (FM1_PROD) AS FM1_PROD,
                    SUM (FM1_JOP) AS FM1_JOP,
                    SUM (FM2_PROD) AS FM2_PROD,
                    SUM (FM2_JOP) AS FM2_JOP
            FROM
                    PIS_SGR_PRODDAILY
                        WHERE
                    TO_CHAR (DATE_PROD, 'YYYY-MM') LIKE '$tahun-$bulan'");

        foreach ($query->result_array() as $rowID) {
            $rm1_prod = $rowID['RM1_PROD'];
            $rm1_jop = $rowID['RM1_JOP'];
            $kl1_prod = $rowID['KL1_PROD'];
            $kl1_jop = $rowID['KL1_JOP'];
            $fm1_prod = $rowID['FM1_PROD'];
            $fm1_jop = $rowID['FM1_JOP'];
            $fm2_prod = $rowID['FM2_PROD'];
            $fm2_jop = $rowID['FM2_JOP'];
        }

        $data = array('pabrik' => 'Tuban',
            'rm1_prod' => number_format($rm1_prod, 2, ".", ""),
            'rm1_jop' => number_format($rm1_jop, 2, ".", ""),
            'kl1_prod' => number_format($kl1_prod, 2, ".", ""),
            'kl1_jop' => number_format($kl1_jop, 2, ".", ""),
            'fm1_prod' => number_format($fm1_prod, 2, ".", ""),
            'fm1_jop' => number_format($fm1_jop, 2, ".", ""),
            'fm2_prod' => number_format($fm2_prod, 2, ".", ""),
            'fm2_jop' => number_format($fm2_jop, 2, ".", ""),
        );

        echo json_encode($data);
    }
// </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="INSPECTION : PAR4DIGMA">
    public function get_ip_report_pie() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['plant'])) {
            $plant = $_GET['plant'];
        } else {
            $plant = 'tbn1';
        }

        $query = $db->query("SELECT
                                    CONDITION,
                                    SUM(COUNT) AS JML
                            FROM
                                    MSO_IP_REPORT
                            WHERE
                                    PLANT = '$plant'
                            AND OPCO = 5000
                            AND MONTH_PROD = '$tahun-$bulan'
                            GROUP BY CONDITION");

        foreach ($query->result_array() as $rowID) {
            $cond = $rowID['CONDITION'];
            $jml = $rowID['JML'];

            $note[$cond] = array(
                'jml' => $jml
            );
        }

        echo '{"data":' . json_encode($note) . '}';
    }

    public function get_ip_report_column() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['plant'])) {
            $plant = $_GET['plant'];
        } else {
            $plant = 'tbn1';
        }

        $query = $db->query("SELECT
                                    CONDITION,
                                    MACHINE,
                                    COUNT
                            FROM
                                    MSO_IP_REPORT
                            WHERE
                                    PLANT = '$plant'
                            AND OPCO = 5000
                            AND MONTH_PROD = '$tahun-$bulan'");

        foreach ($query->result_array() as $rowID) {
            $cond = $rowID['CONDITION'];
            $machine = $rowID['MACHINE'];
            $count = $rowID['COUNT'];

            $jml[$machine] = array(
                'jml' => $count
            );

            $note[$cond] = array(
                'mesin' => $jml
            );
        }

        echo json_encode($note);
    }

    public function get_ip_notes() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['plant'])) {
            $plant = $_GET['plant'];
        } else {
            $plant = 'tbn1';
        }

        $query = $db->query("SELECT
                                    PROBLEM_ID,
                                    EQUIPMENT,
                                    PROBLEM_DESC,
                                    PROBLEM_SLTN	
                            FROM
                                    MSO_IP_PROBLEMNOTES
                            WHERE
                                    MONTH_PROD = '$tahun-$bulan'
                            AND OPCO = 5000
                            AND PLANT = '$plant'");

        foreach ($query->result_array() as $rowID) {
            $notes = $rowID['PROBLEM_DESC'];
            $equipment = $rowID['EQUIPMENT'];
            $solution = $rowID['PROBLEM_SLTN'];
            $id = $rowID['PROBLEM_ID'];

            $note[$id] = array(
                'mesin' => $equipment,
                'catatan' => $notes,
                'solusi' => $solution
            );
        }

        echo '{"data":' . json_encode($note) . '}';
    }

    public function get_ip_tahun() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
        $query = $db->query("SELECT
                                    SUBSTR (MONTH_PROD, 0, 4) AS TAHUN
                            FROM
                                    MSO_IP_REPORT
                            WHERE OPCO = 5000
                            GROUP BY
                                    SUBSTR (MONTH_PROD, 0, 4)");

        foreach ($query->result_array() as $rowID) {
            $tahun = $rowID['TAHUN'];
            $count = count($tahun);
            $a = 0;
            for ($i = 0; $i < $count; $i++) {
                $a += $i;
            }
            $note[$a] = array(
                'tahun' => $tahun
            );
        }

        echo json_encode($note);
    }

    public function get_ip_dash() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    GOOD.PLANT,
                                    GOOD.GOOD,
                                    TOTAL.TOTAL
                            FROM
                                    (
                                            SELECT
                                                    PLANT,
                                                    SUM (COUNT) AS GOOD
                                            FROM
                                                    MSO_IP_REPORT
                                            WHERE
                                                    MONTH_PROD = '$tahun-$bulan'
                                            AND CONDITION = 'GOOD'
                                            AND OPCO = 5000
                                            GROUP BY
                                                    PLANT
                                    ) GOOD
                            JOIN (
                                    SELECT
                                            PLANT,
                                            SUM (COUNT) AS TOTAL
                                    FROM
                                            MSO_IP_REPORT
                                    WHERE
                                            MONTH_PROD = '$tahun-$bulan'
                                    AND OPCO = 5000
                                    GROUP BY
                                            PLANT
                                    ORDER BY
                                            PLANT
                            ) TOTAL ON GOOD.PLANT = TOTAL.PLANT");

        foreach ($query->result_array() as $rowID) {
            $good = $rowID['GOOD'];
            $total = $rowID['TOTAL'];
            $plant = $rowID['PLANT'];

            $note[$plant] = array(
                'good' => $good,
                'total' => $total
            );
        }

        echo json_encode($note);
    }

    // </editor-fold>
}
