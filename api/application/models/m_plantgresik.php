<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_plantgresik extends CI_Model {

    //<editor-fold defaultstate="collapsed" desc="PLANT">
    public function get_statefeed() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Gresik.FM8_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Gresik.FM8_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Gresik.FMA_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Gresik.FMA_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Gresik.FMB_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Gresik.FMB_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Gresik.FMC_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Gresik.FMC_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($seta);
    }

    public function get_emission() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22KL3_Tuban_EP%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL4_Tuban_EP%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22RM3_Tuban_EP%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22RM4_Tuban_EP%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($seta);
    }

    public function get_silo() {
        $mySiloURL = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Silo_Tuban_09%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Silo_Tuban_10%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Silo_Tuban_11%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Silo_Tuban_12%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Silo_Tuban_13%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Silo_Tuban_14%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Silo_Tuban_15%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Silo_Tuban_16%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($mySiloURL);
    }

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

        if (empty($_GET['bulan']) && empty($_GET['tahun'])) {
            $sql = "SELECT
                                    SUM (RM1_PROD) + SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM4_PROD) AS rawmill,
                                    SUM (KL1_PROD) + SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) AS kiln,
                                    SUM (FM1_PROD) + SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM4_PROD) + SUM (FM5_PROD) + SUM (FM6_PROD) + SUM (FM7_PROD) + SUM (FM8_PROD) + SUM (FM9_PROD) + SUM (FMA_PROD) + SUM (FMB_PROD) + SUM (FMC_PROD) + SUM (FMCGD_PROD) AS finishmill
                            FROM
                                    PIS_SG_PRODMONTH WHERE MONTH_PROD LIKE '%" . $tahun . "%'";
        } else {
            $sql = "SELECT
                                    SUM (RM1_PROD) + SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM4_PROD) AS rawmill,
                                    SUM (KL1_PROD) + SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) AS kiln,
                                    SUM (FM1_PROD) + SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM4_PROD) + SUM (FM5_PROD) + SUM (FM6_PROD) + SUM (FM7_PROD) + SUM (FM8_PROD) + SUM (FM9_PROD) + SUM (FMA_PROD) + SUM (FMB_PROD) + SUM (FMC_PROD) + SUM (FMCGD_PROD) AS finishmill
                            FROM
                                    PIS_SG_PRODMONTH WHERE MONTH_PROD LIKE '" . $tahun . "-" . $month . "'";
        }

        $query = $db->query($sql);

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RAWMILL'], 2, ".", "");
            $kl = number_format($rowID['KILN'], 2, ".", "");
            $fm = number_format($rowID['FINISHMILL'], 2, ".", "");
        }

        $data = array('pabrik' => 'Gresik',
            'rawmill' => $rm,
            'kiln' => $kl,
            'finishmill' => $fm
        );

        echo json_encode($data);
    }
}