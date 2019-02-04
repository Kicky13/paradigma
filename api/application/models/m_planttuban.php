<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_planttuban extends CI_Model {

    //<editor-fold defaultstate="collapsed" desc="PLANT">
    public function get_statefeed() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22RM3_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22RM4_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL3_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL4_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM5_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM7_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM6_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM8_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22RM3_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22RM4_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL3_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL4_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22CM3_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22CM4_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM5_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM7_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM6_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%20%22Tuban%203%2F4%20Accessories.Coal_Mill3_Product%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%20%22Tuban%203%2F4%20Accessories.Coal_Mill4_Product%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM8_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203%2F4%20Accessories.Status_HRC_FM5%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203%2F4%20Accessories.Status_HRC_FM6%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL3_PROD%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL4_PROD%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Motor_Power%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Motor_Power%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22RM4_Tuban_Blend1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_ExTemp11%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_ExTemp21%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Hood_Draft%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Depth_Cooler%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Motor_Power%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Motor_Vibration%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Motor_Vibration1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Silo_13_Meter%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Silo_14_Meter%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Silo_15_Meter%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Silo_16_Meter%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM1_HRC_Amp_Fix%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM1_HRC_Amp_Mov%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM2_HRC_Amp_Fix%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM2_HRC_Amp_Mov%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.FM3_HRC_Amp_Fix%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.FM3_HRC_Amp_Mov%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.FM4_HRC_Amp_Fix%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.FM4_HRC_Amp_Mov%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_HRC_Amp_Fix%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_HRC_Amp_Mov%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM6_HRC_Amp_Fix%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM6_HRC_Amp_Mov%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
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

    public function get_statefeedtb12() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban1.FM2_HRC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.RM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM9_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.RM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.CM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.KL1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.Atox_NewCoalMill_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM1_HRC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.KL1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM9_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.FM3_HRC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.FM4_HRC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.FM4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.RM2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.KL1_SLC_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.CM2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.FM4_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.RM2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.KL1_ILC_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.FM3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.FM3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.KL1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.FM9_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.Atox_NewCoalMill_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.CM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.CM2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.KL1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.KL1_PROD%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.KL1_PROD%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($seta);
    }

    public function get_emissiontb12() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban1.KL1_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.Cooler_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.RM2_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.Cooler_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($seta);
    }

    public function get_silotb12() {
        $mySiloURL = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban2.Silo6_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.Silo5_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.Silo7_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban2.Silo8_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.Silo2_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.Silo4_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.Silo1_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban1.Silo3_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($mySiloURL);
    }

    //</editor-fold>
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

        $data = array('pabrik' => 'SI',
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
                                    SUM (RM1_PROD) + SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM4_PROD) AS rawmill,
                                    SUM (KL1_PROD) + SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) AS kiln,
                                    SUM (FM1_PROD) + SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM4_PROD) + SUM (FM5_PROD) + SUM (FM6_PROD) + SUM (FM7_PROD) + SUM (FM8_PROD) + SUM (FM9_PROD) + SUM (FMA_PROD) + SUM (FMB_PROD) + SUM (FMC_PROD) + SUM (FMCGD_PROD) AS finishmill
                            FROM
                                    PIS_SG_PRODMONTH WHERE MONTH_PROD LIKE '%" . $tahun . "%'");

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RAWMILL'], 2, ".", "");
            $kl = number_format($rowID['KILN'], 2, ".", "");
            $fm = number_format($rowID['FINISHMILL'], 2, ".", "");
        }

        $data = array('pabrik' => 'TLCC',
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
                                    V_PIS_SG_PLANT
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
    }

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
                                    COMPANY = 7000
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
                                        RM2_PROD,
                                        RM3_PROD,
                                        RM4_PROD,
                                        KL1_PROD,
                                        KL2_PROD,
                                        KL3_PROD,
                                        KL4_PROD,
                                        FM1_PROD,
                                        FM2_PROD,
                                        FM3_PROD,
                                        FM4_PROD,
                                        FM5_PROD,
                                        FM6_PROD,
                                        FM7_PROD,
                                        FM8_PROD,
                                        FM9_PROD,
                                        FMA_PROD,
                                        FMB_PROD,
                                        FMC_PROD,
                                        FMCGD_PROD
                                FROM
                                        PIS_SG_PRODMONTH
                                WHERE MONTH_PROD LIKE '$tahun-%'
                                ORDER BY
                                        MONTH_PROD");

        foreach ($query_data->result_array() as $rowID) {
            $month = $rowID['MONTH_PROD'];

            $rm1 = $rowID['RM1_PROD'];
            $rm2 = $rowID['RM2_PROD'];
            $rm3 = $rowID['RM3_PROD'];
            $rm4 = $rowID['RM4_PROD'];

            $kl1 = $rowID['KL1_PROD'];
            $kl2 = $rowID['KL2_PROD'];
            $kl3 = $rowID['KL3_PROD'];
            $kl4 = $rowID['KL4_PROD'];

            $fm_tb1 = $rowID['FM1_PROD'] + $rowID['FM2_PROD'] + $rowID['FM9_PROD'];
            $fm_tb2 = $rowID['FM3_PROD'] + $rowID['FM4_PROD'];
            $fm_tb3 = $rowID['FM5_PROD'] + $rowID['FM6_PROD'];
            $fm_tb4 = $rowID['FM7_PROD'] + $rowID['FM8_PROD'];
            $fm_grs = $rowID['FMA_PROD'] + $rowID['FMB_PROD'] + $rowID['FMC_PROD'];
            $fm_cgd = $rowID['FMCGD_PROD'];

            $to_prod[$month] = array(
                "rm1" => number_format($rm1, 2, ".", ""),
                "rm2" => number_format($rm2, 2, ".", ""),
                "rm3" => number_format($rm3, 2, ".", ""),
                "rm4" => number_format($rm4, 2, ".", ""),
                "kl1" => number_format($kl1, 2, ".", ""),
                "kl2" => number_format($kl2, 2, ".", ""),
                "kl3" => number_format($kl3, 2, ".", ""),
                "kl4" => number_format($kl4, 2, ".", ""),
                "fm_tb1" => number_format($fm_tb1, 2, ".", ""),
                "fm_tb2" => number_format($fm_tb2, 2, ".", ""),
                "fm_tb3" => number_format($fm_tb3, 2, ".", ""),
                "fm_tb4" => number_format($fm_tb4, 2, ".", ""),
                "fm_grs" => number_format($fm_grs, 2, ".", ""),
                "fm_cgd" => number_format($fm_cgd, 2, ".", "")
            );
        }

        $myJSON = array(
            "rkap" => $rkap,
            "prod" => $to_prod
        );
        echo '{"7000":' . json_encode($myJSON) . '}';
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
                    SUM (RM2_PROD) AS RM2_PROD,
                    SUM (RM2_JOP) AS RM2_JOP,
                    SUM (RM3_PROD) AS RM3_PROD,
                    SUM (RM3_JOP) AS RM3_JOP,
                    SUM (RM4_PROD) AS RM4_PROD,
                    SUM (RM4_JOP) AS RM4_JOP,
                    SUM (KL1_PROD) AS KL1_PROD,
                    SUM (KL1_JOP) AS KL1_JOP,
                    SUM (KL2_PROD) AS KL2_PROD,
                    SUM (KL2_JOP) AS KL2_JOP,
                    SUM (KL3_PROD) AS KL3_PROD,
                    SUM (KL3_JOP) AS KL3_JOP,
                    SUM (KL4_PROD) AS KL4_PROD,
                    SUM (KL4_JOP) AS KL4_JOP,
                    SUM (FM1_PROD) AS FM1_PROD,
                    SUM (FM1_JOP) AS FM1_JOP,
                    SUM (FM2_PROD) AS FM2_PROD,
                    SUM (FM2_JOP) AS FM2_JOP,
                    SUM (FM3_PROD) AS FM3_PROD,
                    SUM (FM3_JOP) AS FM3_JOP,
                    SUM (FM4_PROD) AS FM4_PROD,
                    SUM (FM4_JOP) AS FM4_JOP,
                    SUM (FM5_PROD) AS FM5_PROD,
                    SUM (FM5_JOP) AS FM5_JOP,
                    SUM (FM6_PROD) AS FM6_PROD,
                    SUM (FM6_JOP) AS FM6_JOP,
                    SUM (FM7_PROD) AS FM7_PROD,
                    SUM (FM7_JOP) AS FM7_JOP,
                    SUM (FM8_PROD) AS FM8_PROD,
                    SUM (FM8_JOP) AS FM8_JOP,
                    SUM (FM9_PROD) AS FM9_PROD,
                    SUM (FM9_JOP) AS FM9_JOP,
                    SUM (FMA_PROD) AS FMA_PROD,
                    SUM (FMA_JOP) AS FMA_JOP,
                    SUM (FMB_PROD) AS FMB_PROD,
                    SUM (FMB_JOP) AS FMB_JOP,
                    SUM (FMC_PROD) AS FMC_PROD,
                    SUM (FMC_JOP) AS FMC_JOP
                    SUM (FMCGD_PROD) AS FMCGD_PROD,
                    SUM (FMCGD_JOP) AS FMCGD_JOP
            FROM
                    PIS_SG_PRODDAILY
                        WHERE
                    TO_CHAR (DATE_PROD, 'YYYY-MM') LIKE '$tahun-$bulan'");

        foreach ($query->result_array() as $rowID) {
            $rm1_prod = $rowID['RM1_PROD'];
            $rm1_jop = $rowID['RM1_JOP'];
            $rm2_prod = $rowID['RM2_PROD'];
            $rm2_jop = $rowID['RM2_JOP'];
            $rm3_prod = $rowID['RM3_PROD'];
            $rm3_jop = $rowID['RM3_JOP'];
            $rm4_prod = $rowID['RM4_PROD'];
            $rm4_jop = $rowID['RM4_JOP'];
            $kl1_prod = $rowID['KL1_PROD'];
            $kl1_jop = $rowID['KL1_JOP'];
            $kl2_prod = $rowID['KL2_PROD'];
            $kl2_jop = $rowID['KL2_JOP'];
            $kl3_prod = $rowID['KL3_PROD'];
            $kl3_jop = $rowID['KL3_JOP'];
            $kl4_prod = $rowID['KL4_PROD'];
            $kl4_jop = $rowID['KL4_JOP'];
            $fm1_prod = $rowID['FM1_PROD'];
            $fm1_jop = $rowID['FM1_JOP'];
            $fm2_prod = $rowID['FM2_PROD'];
            $fm2_jop = $rowID['FM2_JOP'];
            $fm3_prod = $rowID['FM3_PROD'];
            $fm3_jop = $rowID['FM3_JOP'];
            $fm4_prod = $rowID['FM4_PROD'];
            $fm4_jop = $rowID['FM4_JOP'];
            $fm5_prod = $rowID['FM5_PROD'];
            $fm5_jop = $rowID['FM5_JOP'];
            $fm6_prod = $rowID['FM6_PROD'];
            $fm6_jop = $rowID['FM6_JOP'];
            $fm7_prod = $rowID['FM7_PROD'];
            $fm7_jop = $rowID['FM7_JOP'];
            $fm8_prod = $rowID['FM8_PROD'];
            $fm8_jop = $rowID['FM8_JOP'];
            $fm9_prod = $rowID['FM9_PROD'];
            $fm9_jop = $rowID['FM9_JOP'];
            $fma_prod = $rowID['FMA_PROD'];
            $fma_jop = $rowID['FMA_JOP'];
            $fmb_prod = $rowID['FMB_PROD'];
            $fmb_jop = $rowID['FMB_JOP'];
            $fmc_prod = $rowID['FMC_PROD'];
            $fmc_jop = $rowID['FMC_JOP'];
            $fmcgd_prod = $rowID['FMCGD_PROD'];
            $fmcgd_jop = $rowID['FMCGD_JOP'];
        }

        $data = array('pabrik' => 'Tuban',
            'rm1_prod' => number_format($rm1_prod, 2, ".", ""),
            'rm1_jop' => number_format($rm1_jop, 2, ".", ""),
            'rm2_prod' => number_format($rm2_prod, 2, ".", ""),
            'rm2_jop' => number_format($rm2_jop, 2, ".", ""),
            'rm3_prod' => number_format($rm3_prod, 2, ".", ""),
            'rm3_jop' => number_format($rm3_jop, 2, ".", ""),
            'rm4_prod' => number_format($rm4_prod, 2, ".", ""),
            'rm4_jop' => number_format($rm4_jop, 2, ".", ""),
            'kl1_prod' => number_format($kl1_prod, 2, ".", ""),
            'kl1_jop' => number_format($kl1_jop, 2, ".", ""),
            'kl2_prod' => number_format($kl2_prod, 2, ".", ""),
            'kl2_jop' => number_format($kl2_jop, 2, ".", ""),
            'kl3_prod' => number_format($kl3_prod, 2, ".", ""),
            'kl3_jop' => number_format($kl3_jop, 2, ".", ""),
            'kl4_prod' => number_format($kl4_prod, 2, ".", ""),
            'kl4_jop' => number_format($kl4_jop, 2, ".", ""),
            'fm1_prod' => number_format($fm1_prod, 2, ".", ""),
            'fm1_jop' => number_format($fm1_jop, 2, ".", ""),
            'fm2_prod' => number_format($fm2_prod, 2, ".", ""),
            'fm2_jop' => number_format($fm2_jop, 2, ".", ""),
            'fm3_prod' => number_format($fm3_prod, 2, ".", ""),
            'fm3_jop' => number_format($fm3_jop, 2, ".", ""),
            'fm4_prod' => number_format($fm4_prod, 2, ".", ""),
            'fm4_jop' => number_format($fm4_jop, 2, ".", ""),
            'fm5_prod' => number_format($fm5_prod, 2, ".", ""),
            'fm5_jop' => number_format($fm5_jop, 2, ".", ""),
            'fm6_prod' => number_format($fm6_prod, 2, ".", ""),
            'fm6_jop' => number_format($fm6_jop, 2, ".", ""),
            'fm7_prod' => number_format($fm7_prod, 2, ".", ""),
            'fm7_jop' => number_format($fm7_jop, 2, ".", ""),
            'fm8_prod' => number_format($fm8_prod, 2, ".", ""),
            'fm8_jop' => number_format($fm8_jop, 2, ".", ""),
            'fm9_prod' => number_format($fm9_prod, 2, ".", ""),
            'fm9_jop' => number_format($fm9_jop, 2, ".", ""),
            'fma_prod' => number_format($fma_prod, 2, ".", ""),
            'fma_jop' => number_format($fma_jop, 2, ".", ""),
            'fmb_prod' => number_format($fmb_prod, 2, ".", ""),
            'fmb_jop' => number_format($fmb_jop, 2, ".", ""),
            'fmc_prod' => number_format($fmc_prod, 2, ".", ""),
            'fmc_jop' => number_format($fmc_jop, 2, ".", ""),
            'fmcgd_prod' => number_format($fmcgd_prod, 2, ".", ""),
            'fmcgd_jop' => number_format($fmcgd_jop, 2, ".", "")
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
                            AND MONTH_PROD = '$tahun-$bulan'
                            AND OPCO = 7000
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
                            AND OPCO = 7000
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
                                    PROBLEM_SLTN,
                                    PRIORITY
                            FROM
                                    MSO_IP_PROBLEMNOTES
                            WHERE
                                    MONTH_PROD = '$tahun-$bulan'
                            AND OPCO = 7000
                            AND PLANT = '$plant'");

        foreach ($query->result_array() as $rowID) {
            $notes = $rowID['PROBLEM_DESC'];
            $equipment = $rowID['EQUIPMENT'];
            $solution = $rowID['PROBLEM_SLTN'];
            $id = $rowID['PROBLEM_ID'];
            $priority = $rowID['PRIORITY'];

            $note[$id] = array(
                'mesin' => $equipment,
                'catatan' => $notes,
                'solusi' => $solution,
                'prioritas' => $priority
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
                            WHERE OPCO = 7000
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
        $bulan_1 = $bulan - 1;
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
                                            AND OPCO = 7000
                                            AND CONDITION = 'GOOD'
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
                                    AND OPCO = 7000
                                    GROUP BY
                                            PLANT
                                    ORDER BY
                                            PLANT
                            ) TOTAL ON GOOD.PLANT = TOTAL.PLANT");

//        if (count($query->result_array()) == 0) {
//            $query_1 = $db->query("SELECT
//                                    GOOD.PLANT,
//                                    GOOD.GOOD,
//                                    TOTAL.TOTAL
//                            FROM
//                                    (
//                                            SELECT
//                                                    PLANT,
//                                                    SUM (COUNT) AS GOOD
//                                            FROM
//                                                    MSO_IP_REPORT
//                                            WHERE
//                                                    MONTH_PROD = '$tahun-$bulan_1'
//                                            AND OPCO = 7000
//                                            AND CONDITION = 'GOOD'
//                                            GROUP BY
//                                                    PLANT
//                                    ) GOOD
//                            JOIN (
//                                    SELECT
//                                            PLANT,
//                                            SUM (COUNT) AS TOTAL
//                                    FROM
//                                            MSO_IP_REPORT
//                                    WHERE
//                                            MONTH_PROD = '$tahun-$bulan_1'
//                                    AND OPCO = 7000
//                                    GROUP BY
//                                            PLANT
//                                    ORDER BY
//                                            PLANT
//                            ) TOTAL ON GOOD.PLANT = TOTAL.PLANT");
//        } else {
//            $query = $db->query("SELECT
//                                    GOOD.PLANT,
//                                    GOOD.GOOD,
//                                    TOTAL.TOTAL
//                            FROM
//                                    (
//                                            SELECT
//                                                    PLANT,
//                                                    SUM (COUNT) AS GOOD
//                                            FROM
//                                                    MSO_IP_REPORT
//                                            WHERE
//                                                    MONTH_PROD = '$tahun-$bulan'
//                                            AND OPCO = 7000
//                                            AND CONDITION = 'GOOD'
//                                            GROUP BY
//                                                    PLANT
//                                    ) GOOD
//                            JOIN (
//                                    SELECT
//                                            PLANT,
//                                            SUM (COUNT) AS TOTAL
//                                    FROM
//                                            MSO_IP_REPORT
//                                    WHERE
//                                            MONTH_PROD = '$tahun-$bulan'
//                                    AND OPCO = 7000
//                                    GROUP BY
//                                            PLANT
//                                    ORDER BY
//                                            PLANT
//                            ) TOTAL ON GOOD.PLANT = TOTAL.PLANT");
//        }

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
    // <editor-fold defaultstate="collapsed" desc="PM Dashboard">
    function get_pm_dash() {
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
                                    DATA.TAHUN,
                                    DATA.PLANT,
                                    DATA.CATEGORY,
                                    DATA.PERSEN,
                                    WC.DATA_WC 
                            FROM
                                    (
                            SELECT
                                    TAHUN,
                                    PLANT,
                                    CATEGORY,
                                    ROUND(( AVG( DATA_INPUT )), 0 ) AS PERSEN 
                            FROM
                                    MSO_PM_PERFORMANCE 
                            WHERE
                                    COMPANY = 7000 
                                    AND TAHUN = $tahun 
                                    AND BULAN = '$bulan' 
                            GROUP BY
                                    TAHUN,
                                    PLANT,
                                    CATEGORY 
                                    ) DATA JOIN ( SELECT DISTINCT CATEGORY, DATA_WC FROM MSO_PM_PERFORMANCE_RKAP WHERE COMPANY = 7000 AND TAHUN = $tahun ) WC ON DATA.CATEGORY = WC.CATEGORY 
                            ORDER BY
                                    PLANT,
                                    CATEGORY");
        foreach ($query->result_array() as $rowID) {
            $category = $rowID['CATEGORY'];
            $plant = $rowID['PLANT'];
            $percent = $rowID['PERSEN'];
            $wc = $rowID['DATA_WC'];
            $tahun = $rowID['TAHUN'];

            $jml[$plant][$category] = array(
                'tahun' => $tahun,
                'persen' => $percent,
                'wc' => $wc
            );
        }

        echo json_encode($jml);
    }

    function get_pm_detail() {
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
                                    DATA.CATEGORY,
                                    DATA.EQUIPMENT,
                                    DATA.DATA_INPUT,
                                    WC.DATA_WC 
                            FROM
                                    (
                            SELECT DISTINCT
                                    CATEGORY,
                                    EQUIPMENT,
                                    ROUND( DATA_INPUT, 0 ) AS DATA_INPUT 
                            FROM
                                    MSO_PM_PERFORMANCE 
                            WHERE
                                    COMPANY = 7000 
                                    AND TAHUN = $tahun 
                                    AND BULAN = '$bulan' 
                                    AND PLANT = '$plant' 
                                    ) DATA JOIN ( SELECT CATEGORY, EQUIPMENT, DATA_WC FROM MSO_PM_PERFORMANCE_RKAP WHERE COMPANY = 7000 AND TAHUN = $tahun ) WC ON DATA.EQUIPMENT = WC.EQUIPMENT 
                                    AND DATA.CATEGORY = WC.CATEGORY 
                            ORDER BY
                                    CATEGORY,
                                    EQUIPMENT");
        foreach ($query->result_array() as $rowID) {
            $category = $rowID['CATEGORY'];
            $data = $rowID['DATA_INPUT'];
            $wc = $rowID['DATA_WC'];
            $equipment = $rowID['EQUIPMENT'];

            $jml[$category][$equipment] = array(
                'data' => $data,
                'wc' => $wc
            );
        }

        echo '{"' . $plant . '":' . json_encode($jml) . '}';
    }

    function get_pm_note() {
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
                                    *
                            FROM
                                    MSO_PM_PERFORMANCE_NOTES
                            WHERE
                                    MONTH_PROD = '$tahun-$bulan'
                            AND PLANT = '$plant'
                            ORDER BY
                                    AREA");
        foreach ($query->result_array() as $rowID) {
            $plant = $rowID['PLANT'];
            $opco = $rowID['OPCO'];
            $area = $rowID['AREA'];
            $problem_id = $rowID['PROBLEM_ID'];
            $tgl = $rowID['TGL'];
            $equipment = $rowID['EQUIPMENT'];
            $problem_desc = $rowID['PROBLEM_DESC'];
            $duration = $rowID['DURATION'];
            $frequency = $rowID['FREQUENCY'];


            $jml[$area][$problem_id] = array(
                'plant' => $plant,
                'opco' => $opco,
                'tgl' => $tgl,
                'equipment' => $equipment,
                'problem_desc' => $problem_desc,
                'duration' => $duration,
                'frequency' => $frequency
            );
        }

        echo json_encode($jml);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Cigading Plant Overview">
    function get_statefeedcgd() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Cigading.FM_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Cigading.FM_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
//        print file_get_contents($seta);

        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('opcclient', true);

        $query = $db->query("SELECT
                                    name,
                                    addr,
                                    type,
                                    datatype,
                                    quality,
                                    timestamp,
                                    REPLACE (value, \",\",\".\") AS value,
                                    alarm,
                                    severity,
                                    lo2,
                                    lo1,
                                    hi1,
                                    hi2,
                                    limlo2,
                                    limlo1,
                                    limhi1 limhi2,
                                    mlo2,
                                    mlo1,
                                    mhi1,
                                    mhi2,
                                    ket
                            FROM
                                    tags_cgd
                            WHERE
                                    NAME IN (
                                            'Cigading.FM.FM_Feed',
                                            'Cigading.FM.FM_Motor'
                                    )
                                    ORDER BY FIELD(
                                            NAME,
                                            'Cigading.FM.FM_Feed',
                                            'Cigading.FM.FM_Motor'
                                    )");

        foreach ($query->result_array() as $rowID) {
            if ($rowID['quality'] == 192) {
                $quality = TRUE;
            } else {
                $quality = FALSE;
            }

            $text[$rowID['name']] [] = array(
                "datatype" => $rowID['datatype'],
                "name" => "Value",
                "quality" => $quality,
                "val" => $rowID['value']);
            $go[] = array(
                "name" => $rowID['name'],
                "props" => $text[$rowID['name']]
            );
        }

        echo '({"message":"' . $rowID['timestamp'] . '","status":"OK","tags":' . json_encode($go) . ',"token":"SISI-agungxfz-160018-2017"});';
    }

    function get_silocgd() {
        $mySiloURL = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Cigading.Silo10K%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Cigading.Silo20K%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
//        print file_get_contents($mySiloURL);

        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('opcclient', true);

        $query = $db->query("SELECT
                                    name,
                                    addr,
                                    type,
                                    datatype,
                                    quality,
                                    timestamp,
                                    REPLACE (value, \",\",\".\") AS value,
                                    alarm,
                                    severity,
                                    lo2,
                                    lo1,
                                    hi1,
                                    hi2,
                                    limlo2,
                                    limlo1,
                                    limhi1 limhi2,
                                    mlo2,
                                    mlo1,
                                    mhi1,
                                    mhi2,
                                    ket
                            FROM
                                    tags_cgd
                            WHERE
                                    NAME IN (
                                            'Cigading.FM.Silo1_Percent_10K',
                                            'Cigading.Silo_Packer.Silo_Packer_20K'
                                    )
                                    ORDER BY FIELD(
                                            NAME,
                                            'Cigading.FM.Silo1_Percent_10K',
                                            'Cigading.Silo_Packer.Silo_Packer_20K'
                                    )");

        foreach ($query->result_array() as $rowID) {
            if ($rowID['quality'] == 192) {
                $quality = TRUE;
            } else {
                $quality = FALSE;
            }

            $text[$rowID['name']] [] = array(
                "datatype" => $rowID['datatype'],
                "name" => "Value",
                "quality" => $quality,
                "val" => $rowID['value']);
            $go[] = array(
                "name" => $rowID['name'],
                "props" => $text[$rowID['name']]
            );
        }

        echo '({"message":"' . $rowID['timestamp'] . '","status":"OK","tags":' . json_encode($go) . ',"token":"SISI-agungxfz-160018-2017"});';
    }

    function get_emisicgd() {
        $mySiloURL = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Cigading.FM_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
//        print file_get_contents($mySiloURL);

        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('opcclient', true);

        $query = $db->query("SELECT
                                    name,
                                    addr,
                                    type,
                                    datatype,
                                    quality,
                                    timestamp,
                                    REPLACE (value, \",\",\".\") AS value,
                                    alarm,
                                    severity,
                                    lo2,
                                    lo1,
                                    hi1,
                                    hi2,
                                    limlo2,
                                    limlo1,
                                    limhi1 limhi2,
                                    mlo2,
                                    mlo1,
                                    mhi1,
                                    mhi2,
                                    ket
                            FROM
                                    tags_cgd
                            WHERE
                                    NAME IN (
                                            'Cigading.FM.FM_Emisi'
                                    )
                                    ORDER BY FIELD(
                                            NAME,
                                            'Cigading.FM.FM_Emisi'
                                    )");

        foreach ($query->result_array() as $rowID) {
            if ($rowID['quality'] == 192) {
                $quality = TRUE;
            } else {
                $quality = FALSE;
            }

            $text[$rowID['name']] [] = array(
                "datatype" => $rowID['datatype'],
                "name" => "Value",
                "quality" => $quality,
                "val" => $rowID['value']);
            $go[] = array(
                "name" => $rowID['name'],
                "props" => $text[$rowID['name']]
            );
        }

        echo '({"message":"' . $rowID['timestamp'] . '","status":"OK","tags":' . json_encode($go) . ',"token":"SISI-agungxfz-160018-2017"});';
    }

    function get_packercgd() {
        $myURL = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Cigading_Packer.PMA_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Cigading_Packer.PMA_Bag_Counter%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Cigading_Packer.PMB_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Cigading_Packer.PMB_Bag_Counter%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
//        print file_get_contents($myURL);

        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('opcclient', true);

        $query = $db->query("SELECT
                                    name,
                                    addr,
                                    type,
                                    datatype,
                                    quality,
                                    timestamp,
                                    REPLACE (value, \",\",\".\") AS value,
                                    alarm,
                                    severity,
                                    lo2,
                                    lo1,
                                    hi1,
                                    hi2,
                                    limlo2,
                                    limlo1,
                                    limhi1 limhi2,
                                    mlo2,
                                    mlo1,
                                    mhi1,
                                    mhi2,
                                    ket
                            FROM
                                    tags_cgd
                            WHERE
                                    NAME IN (
                                            'Cigading_Packer.PMA_CP.Run',
                                            'Cigading_Packer.PMA_CP.Bag_Count',
                                            'Cigading_Packer.PMB_Simentari.Run',
                                            'Cigading_Packer.PMB_Simentari.Bag_Count'
                                    )
                                    ORDER BY FIELD(
                                            NAME,
                                            'Cigading_Packer.PMA_CP.Run',
                                            'Cigading_Packer.PMA_CP.Bag_Count',
                                            'Cigading_Packer.PMB_Simentari.Run',
                                            'Cigading_Packer.PMB_Simentari.Bag_Count'
                                    )");

        foreach ($query->result_array() as $rowID) {
            if ($rowID['quality'] == 192) {
                $quality = TRUE;
            } else {
                $quality = FALSE;
            }

            $text[$rowID['name']] [] = array(
                "datatype" => $rowID['datatype'],
                "name" => "Value",
                "quality" => $quality,
                "val" => $rowID['value']);
            $go[] = array(
                "name" => $rowID['name'],
                "props" => $text[$rowID['name']]
            );
        }

        echo '({"message":"' . $rowID['timestamp'] . '","status":"OK","tags":' . json_encode($go) . ',"token":"SISI-agungxfz-160018-2017"});';
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Gresik Plant Overview">
    function get_statefeedgrs() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('opcclient', true);

        $query = $db->query("SELECT
                                    name,
                                    addr,
                                    type,
                                    datatype,
                                    quality,
                                    timestamp,
                                    REPLACE (value, \",\",\".\") AS value,
                                    alarm,
                                    severity,
                                    lo2,
                                    lo1,
                                    hi1,
                                    hi2,
                                    limlo2,
                                    limlo1,
                                    limhi1 limhi2,
                                    mlo2,
                                    mlo1,
                                    mhi1,
                                    mhi2,
                                    ket
                            FROM
                                    tags_grs
                            WHERE
                                    NAME IN (
                                            'FM_Feed.FM_ABC.FMA_Feed',
                                            'FM_Feed.FM_ABC.FMB_Feed',
                                            'FM_Feed.FM_ABC.FMC_Feed',
                                            'FM_GRESIK.FMD.FMD_Feed',
                                            'FM_GRESIK.FMA.FMA_ONOFF',
                                            'FM_GRESIK.FMB.FMB_Motor',
                                            'FM_GRESIK.FMC.FMC_ONOFF',
                                            'FM_GRESIK.FMD.FMD_Motor',
                                            'FM_GRESIK.FMA.FMA_Motor'
                                    )
                                    ORDER BY FIELD(
                                            NAME,
                                            'FM_Feed.FM_ABC.FMA_Feed',
                                            'FM_Feed.FM_ABC.FMB_Feed',
                                            'FM_Feed.FM_ABC.FMC_Feed',
                                            'FM_GRESIK.FMD.FMD_Feed',
                                            'FM_GRESIK.FMA.FMA_ONOFF',
                                            'FM_GRESIK.FMB.FMB_Motor',
                                            'FM_GRESIK.FMC.FMC_ONOFF',
                                            'FM_GRESIK.FMD.FMD_Motor',
                                            'FM_GRESIK.FMA.FMA_Motor'
                                    )");

        foreach ($query->result_array() as $rowID) {
            if ($rowID['quality'] == 192) {
                $quality = TRUE;
            } else {
                $quality = FALSE;
            }

            $text[$rowID['name']] [] = array(
                "datatype" => $rowID['datatype'],
                "name" => "Value",
                "quality" => $quality,
                "val" => $rowID['value']);
            $go[] = array(
                "name" => $rowID['name'],
                "props" => $text[$rowID['name']]
            );
        }

        echo '({"message":"' . $rowID['timestamp'] . '","status":"OK","tags":' . json_encode($go) . ',"token":"SISI-agungxfz-160018-2017"});';
    }

    function get_silogrs() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('opcclient', true);

        $query = $db->query("SELECT
                                    name,
                                    addr,
                                    type,
                                    datatype,
                                    quality,
                                    timestamp,
                                    REPLACE (value, \",\",\".\") AS value,
                                    alarm,
                                    severity,
                                    lo2,
                                    lo1,
                                    hi1,
                                    hi2,
                                    limlo2,
                                    limlo1,
                                    limhi1 limhi2,
                                    mlo2,
                                    mlo1,
                                    mhi1,
                                    mhi2,
                                    ket
                            FROM
                                    tags_grs
                            WHERE
                                    NAME IN (
                                            'Cigading.FM.Silo1_Percent_10K',
                                            'Cigading.Silo_Packer.Silo_Packer_20K'
                                    )
                                    ORDER BY FIELD(
                                            NAME,
                                            'Cigading.FM.Silo1_Percent_10K',
                                            'Cigading.Silo_Packer.Silo_Packer_20K'
                                    )");

        foreach ($query->result_array() as $rowID) {
            if ($rowID['quality'] == 192) {
                $quality = TRUE;
            } else {
                $quality = FALSE;
            }

            $text[$rowID['name']] [] = array(
                "datatype" => $rowID['datatype'],
                "name" => "Value",
                "quality" => $quality,
                "val" => $rowID['value']);
            $go[] = array(
                "name" => $rowID['name'],
                "props" => $text[$rowID['name']]
            );
        }

        echo '({"message":"' . $rowID['timestamp'] . '","status":"OK","tags":' . json_encode($go) . ',"token":"SISI-agungxfz-160018-2017"});';
    }

    function get_emisigrs() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('opcclient', true);

        $query = $db->query("SELECT
                                    name,
                                    addr,
                                    type,
                                    datatype,
                                    quality,
                                    timestamp,
                                    REPLACE (value, \",\",\".\") AS value,
                                    alarm,
                                    severity,
                                    lo2,
                                    lo1,
                                    hi1,
                                    hi2,
                                    limlo2,
                                    limlo1,
                                    limhi1 limhi2,
                                    mlo2,
                                    mlo1,
                                    mhi1,
                                    mhi2,
                                    ket
                            FROM
                                    tags_grs
                            WHERE
                                    NAME IN (
                                            'Cigading.FM.FM_Emisi'
                                    )
                                    ORDER BY FIELD(
                                            NAME,
                                            'Cigading.FM.FM_Emisi'
                                    )");

        foreach ($query->result_array() as $rowID) {
            if ($rowID['quality'] == 192) {
                $quality = TRUE;
            } else {
                $quality = FALSE;
            }

            $text[$rowID['name']] [] = array(
                "datatype" => $rowID['datatype'],
                "name" => "Value",
                "quality" => $quality,
                "val" => $rowID['value']);
            $go[] = array(
                "name" => $rowID['name'],
                "props" => $text[$rowID['name']]
            );
        }

        echo '({"message":"' . $rowID['timestamp'] . '","status":"OK","tags":' . json_encode($go) . ',"token":"SISI-agungxfz-160018-2017"});';
    }

    function get_packergrs() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('opcclient', true);

        $query = $db->query("SELECT
                                    name,
                                    addr,
                                    type,
                                    datatype,
                                    quality,
                                    timestamp,
                                    REPLACE (value, \",\",\".\") AS value,
                                    alarm,
                                    severity,
                                    lo2,
                                    lo1,
                                    hi1,
                                    hi2,
                                    limlo2,
                                    limlo1,
                                    limhi1 limhi2,
                                    mlo2,
                                    mlo1,
                                    mhi1,
                                    mhi2,
                                    ket
                            FROM
                                    tags_grs
                            WHERE
                                    NAME IN (
                                            'Cigading_Packer.PMA_CP.Run',
                                            'Cigading_Packer.PMA_CP.Bag_Count',
                                            'Cigading_Packer.PMB_Simentari.Run',
                                            'Cigading_Packer.PMB_Simentari.Bag_Count'
                                    )
                                    ORDER BY FIELD(
                                            NAME,
                                            'Cigading_Packer.PMA_CP.Run',
                                            'Cigading_Packer.PMA_CP.Bag_Count',
                                            'Cigading_Packer.PMB_Simentari.Run',
                                            'Cigading_Packer.PMB_Simentari.Bag_Count'
                                    )");

        foreach ($query->result_array() as $rowID) {
            if ($rowID['quality'] == 192) {
                $quality = TRUE;
            } else {
                $quality = FALSE;
            }

            $text[$rowID['name']] [] = array(
                "datatype" => $rowID['datatype'],
                "name" => "Value",
                "quality" => $quality,
                "val" => $rowID['value']);
            $go[] = array(
                "name" => $rowID['name'],
                "props" => $text[$rowID['name']]
            );
        }

        echo '({"message":"' . $rowID['timestamp'] . '","status":"OK","tags":' . json_encode($go) . ',"token":"SISI-agungxfz-160018-2017"});';
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="FMEA">
    function get_fmea_level() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);

        $query = $db->query("SELECT
                                    CASE
                            WHEN \"Severity\" * \"Probability\" * \"Detection\" >= 192 THEN
                                    'HIGH'
                            WHEN \"Severity\" * \"Probability\" * \"Detection\" >= 65 THEN
                                    'MEDIUM'
                            WHEN \"Severity\" * \"Probability\" * \"Detection\" < 65 THEN
                                    'LOW'
                            ELSE
                                    NULL
                            END AS \"LEVEL\",
                             COUNT (*) AS JUMLAH,
                             ROUND (
                                    COUNT (*) / (
                                            SELECT
                                                    COUNT (*)
                                            FROM
                                                    MSO_FMEA
                                            WHERE
                                                    \"Asset\" IS NOT NULL
                                    ) * 100,
                                    2
                            ) AS PERSENTASE
                            FROM
                                    MSO_FMEA
                            WHERE
                                    \"Asset\" IS NOT NULL
                            GROUP BY
                                    CASE
                            WHEN \"Severity\" * \"Probability\" * \"Detection\" >= 192 THEN
                                    'HIGH'
                            WHEN \"Severity\" * \"Probability\" * \"Detection\" >= 65 THEN
                                    'MEDIUM'
                            WHEN \"Severity\" * \"Probability\" * \"Detection\" < 65 THEN
                                    'LOW'
                            ELSE
                                    NULL
                            END");

        foreach ($query->result_array() as $rowID) {
            $level = $rowID['LEVEL'];
            $jml = $rowID['JUMLAH'];
            $prs = $rowID['PERSENTASE'];

            $note[$level] = array(
                'jml' => $jml,
                'prs' => $prs
            );
        }

        echo '{"data":' . json_encode($note) . '}';
    }

    function get_fmea_exec() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);

        $query = $db->query("SELECT
                                    COUNT (*) AS TOTAL,
                                    COUNT (
                                            CASE
                                            WHEN \"ICPreventiveCtrl\" IS NOT NULL THEN
                                                    1
                                            END
                                    ) AS EXECUTED,
                                    COUNT (*) - COUNT (
                                            CASE
                                            WHEN \"ICPreventiveCtrl\" IS NOT NULL THEN
                                                    1
                                            END
                                    ) AS NOTEXECUTED
                            FROM
                                    MSO_FMEA
                            WHERE
                                    \"Asset\" IS NOT NULL");

        foreach ($query->result_array() as $rowID) {
            $tot = $rowID['TOTAL'];
            $exc = $rowID['EXECUTED'];
            $not = $rowID['NOTEXECUTED'];

            $note = array(
                'tot' => $tot,
                'exc' => $exc,
                'not' => $not
            );
        }

        echo '{"data":' . json_encode($note) . '}';
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Maint. Cost">
    function get_mt_quarter() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
        } else {
            $company = 7000;
        }
        $query = $db->query("SELECT
                                    VAL.BLN,
                                    VAL. MONTH,
                                    VAL. COST,
                                    RKAP.BULAN,
                                    RKAP.RKAP
                            FROM
                                    (
                                            SELECT
                                                    TO_CHAR (
                                                            TO_DATE (A . MONTH, 'MM'),
                                                            'MON'
                                                    ) BLN,
                                                    A . MONTH,
                                                    NVL (B. COST, 0) COST
                                            FROM
                                                    (
                                                            SELECT
                                                                    LEVEL AS MONTH
                                                            FROM
                                                                    DUAL CONNECT BY LEVEL <= 12
                                                    ) A
                                            LEFT JOIN (
                                                    SELECT
                                                            TO_NUMBER (MONTH) AS MONTH,
                                                            SUM (TO_NUMBER(OBJ_CURR)) AS COST
                                                    FROM
                                                            MSO_PM_MAINT_COST
                                                    WHERE
                                                            TAHUN = $tahun AND SUBSTR(COST_CNTR, 1, 1) = '7'
                                                    GROUP BY
                                                            MONTH
                                                    ORDER BY
                                                            MONTH
                                            ) B ON A . MONTH = B. MONTH
                                            ORDER BY
                                                    MONTH
                                    ) VAL
                            JOIN (
                                    SELECT
                                            X.BLN,
                                            X. MONTH,
                                            B.BULAN,
                                            NVL (B.RKAP, 0) RKAP
                                    FROM
                                            (
                                                    SELECT
                                                            TO_CHAR (
                                                                    TO_DATE (A . MONTH, 'MM'),
                                                                    'MON'
                                                            ) BLN,
                                                            A . MONTH
                                                    FROM
                                                            (
                                                                    SELECT
                                                                            LEVEL AS MONTH
                                                                    FROM
                                                                            DUAL CONNECT BY LEVEL <= 12
                                                            ) A
                                            ) X
                                    LEFT JOIN (
                                            SELECT
                                                    TO_CHAR (TO_DATE(BULAN, 'MM'), 'MON') BLN,
                                                    BULAN,
                                                    SUM (RKAP) RKAP
                                            FROM
                                                    MSO_PM_MAINT_COST_RKAP
                                            WHERE
                                                    TAHUN = $tahun AND COMPANY = $company
                                            GROUP BY
                                                    BULAN
                                            ORDER BY
                                                    BULAN
                                    ) B ON X.BLN = B.BLN
                                    ORDER BY
                                            X. MONTH
                            ) RKAP ON VAL.BLN = RKAP.BLN");

        foreach ($query->result_array() as $rowID) {
            $bln = $rowID['BLN'];
            $month = $rowID['MONTH'];
            $cost = $rowID['COST'];
            $bulan = $rowID['BULAN'];
            $rkap = $rowID['RKAP'];

            $jml[$bln] = array(
                'month' => $month,
                'cost' => $cost,
                'bulan' => $bulan,
                'rkap' => $rkap
            );
        }

        echo json_encode($jml);
    }

    function get_mt_rr() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
        } else {
            $company = 7000;
        }

        $query = $db->query("SELECT
                                    RKAP.BULAN,
                                    RKAP.BLN,
                                    NVL (REAL . COST, 0) COST,
                                    NVL (RKAP.RKAP, 0) RKAP
                            FROM
                                    (
                                            SELECT
                                                    Y. MONTH,
                                                    Y.BULAN,
                                                    X. COST
                                            FROM
                                                    (
                                                            SELECT
                                                                    TO_CHAR (TO_DATE(MONTH, 'MM'), 'MON') BULAN,
                                                                    SUM (OBJ_CURR) COST
                                                            FROM
                                                                    MSO_PM_MAINT_COST
                                                            WHERE
                                                                    TAHUN = $tahun AND SUBSTR(COST_CNTR, 1, 1) = '7'
                                                            GROUP BY
                                                                    MONTH
                                                    ) X
                                            RIGHT JOIN (
                                                    SELECT
                                                            TO_CHAR (
                                                                    TO_DATE (A . MONTH, 'MM'),
                                                                    'MON'
                                                            ) BULAN,
                                                            A . MONTH
                                                    FROM
                                                            (
                                                                    SELECT
                                                                            LEVEL AS MONTH
                                                                    FROM
                                                                            DUAL CONNECT BY LEVEL <= 12
                                                            ) A
                                            ) Y ON X.BULAN = Y.BULAN
                                            ORDER BY
                                                    Y. MONTH
                                    ) REAL
                            RIGHT JOIN (
                                    SELECT
                                            X.BULAN,
                                            X. MONTH,
                                            Y.BLN,
                                            Y.RKAP
                                    FROM
                                            (
                                                    SELECT
                                                            TO_CHAR (
                                                                    TO_DATE (A . MONTH, 'MM'),
                                                                    'MON'
                                                            ) BULAN,
                                                            A . MONTH
                                                    FROM
                                                            (
                                                                    SELECT
                                                                            LEVEL AS MONTH
                                                                    FROM
                                                                            DUAL CONNECT BY LEVEL <= 12
                                                            ) A
                                            ) X
                                    LEFT JOIN (
                                            SELECT
                                                    TO_CHAR (TO_DATE(BULAN, 'MM'), 'MON') BULAN,
                                                    BULAN BLN,
                                                    SUM (RKAP) RKAP
                                            FROM
                                                    MSO_PM_MAINT_COST_RKAP
                                            WHERE
                                                    TAHUN = $tahun AND COMPANY = $company
                                            GROUP BY
                                                    BULAN
                                    ) Y ON X.BULAN = Y.BULAN
                                    ORDER BY
                                            X. MONTH
                            ) RKAP ON REAL .BULAN = RKAP.BULAN
                            ORDER BY
                                    BLN");

        echo json_encode($query->result_array());
    }

    function get_mt_rr_year() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
        } else {
            $company = 7000;
        }

        $query = $db->query("SELECT
                                        REAL .TAHUN,
                                        REAL . COST,
                                        NVL (RKAP.RKAP, 0) RKAP
                                FROM
                                        (
                                                SELECT
                                                        TAHUN,
                                                        SUM (OBJ_CURR) AS COST
                                                FROM
                                                        MSO_PM_MAINT_COST
                                                WHERE
                                                        TAHUN BETWEEN $tahun-1
                                                AND $tahun AND SUBSTR(COST_CNTR, 1, 1) = '7'
                                                GROUP BY
                                                        TAHUN
                                        ) REAL
                                LEFT JOIN (
                                        SELECT
                                                TAHUN,
                                                SUM (RKAP) AS RKAP
                                        FROM
                                                MSO_PM_MAINT_COST_RKAP
                                        WHERE
                                                TAHUN BETWEEN $tahun-1
                                        AND $tahun AND COMPANY = $company
                                        GROUP BY
                                                TAHUN
                                ) RKAP ON REAL .TAHUN = RKAP.TAHUN ORDER BY REAL .TAHUN");

        echo json_encode($query->result_array());
    }

    function get_mt_chart_dept() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
        } else {
            $company = 7000;
        }

        $query = $db->query("SELECT
                                        VAL.BLN,
                                        VAL. MONTH,
                                        VAL.CHART,
                                        VAL. COST,
                                        VAL.CHART_CODE,
                                        RKAP.BULAN,
                                        RKAP.RKAP
                                FROM
                                        (
                                                SELECT
                                                        TO_CHAR (
                                                                TO_DATE (A . MONTH, 'MM'),
                                                                'MON'
                                                        ) BLN,
                                                        A . MONTH,
                                                        C.CHART,
                                                        NVL (B. COST, 0) COST,
                                                        C.CHART_CODE
                                                FROM
                                                        (
                                                                SELECT
                                                                        'E' KEY_COL,
                                                                        LEVEL AS MONTH
                                                                FROM
                                                                        DUAL CONNECT BY LEVEL <= 12
                                                        ) A
                                                LEFT JOIN (
                                                        SELECT DISTINCT
                                                                DEPART AS CHART,
                                                                CASE DEPART
                                                        WHEN 'DEPARTEMEN PRODUKSI  SEMEN' THEN
                                                                '50029279'
                                                        WHEN 'NON PABRIK' THEN
                                                                '99999999'
                                                        WHEN 'DEPARTEMEN PRODUKSI  TERAK I' THEN
                                                                '50029277'
                                                        WHEN 'DEPARTEMEN PRODUKSI  TERAK II' THEN
                                                                '50029278'
                                                        WHEN 'DEPARTEMEN JAMUT, K3 & LINGKUNGAN' THEN
                                                                '50036065'
                                                        WHEN 'DEPARTEMEN TEKNIK' THEN
                                                                '50036064'
                                                        WHEN 'BIRO PABRIK  GRESIK' THEN
                                                                '50029429'
                                                        WHEN 'DEPARTEMEN PRODUKSI BAHAN BAKU' THEN
                                                                '50029276'
                                                        END CHART_CODE,
                                                        'E' KEY_COL2
                                                FROM
                                                        MSO_PM_MAINT_COST
                                                WHERE
                                                        TAHUN = $tahun AND SUBSTR(COST_CNTR, 1, 1) = '7'
                                                ) C ON C.KEY_COL2 = A .KEY_COL
                                                LEFT JOIN (
                                                        SELECT
                                                                TO_NUMBER (MONTH) AS MONTH,
                                                                DEPART CHART,
                                                                SUM (TO_NUMBER(OBJ_CURR)) AS COST
                                                        FROM
                                                                MSO_PM_MAINT_COST
                                                        WHERE
                                                                TAHUN = $tahun AND SUBSTR(COST_CNTR, 1, 1) = '7'
                                                        GROUP BY
                                                                MONTH,
                                                                DEPART
                                                        ORDER BY
                                                                MONTH
                                                ) B ON A . MONTH = B. MONTH
                                                AND C.CHART = B.CHART
                                                ORDER BY
                                                        A . MONTH
                                        ) VAL
                                JOIN (
                                        SELECT
                                                X.BLN,
                                                X. MONTH,
                                                B.BULAN,
                                                NVL (B.RKAP, 0) RKAP
                                        FROM
                                                (
                                                        SELECT
                                                                TO_CHAR (
                                                                        TO_DATE (A . MONTH, 'MM'),
                                                                        'MON'
                                                                ) BLN,
                                                                A . MONTH
                                                        FROM
                                                                (
                                                                        SELECT
                                                                                LEVEL AS MONTH
                                                                        FROM
                                                                                DUAL CONNECT BY LEVEL <= 12
                                                                ) A
                                                ) X
                                        LEFT JOIN (
                                                SELECT
                                                        TO_CHAR (TO_DATE(BULAN, 'MM'), 'MON') BLN,
                                                        BULAN,
                                                        SUM (RKAP) RKAP
                                                FROM
                                                        MSO_PM_MAINT_COST_RKAP
                                                WHERE
                                                        TAHUN = $tahun AND COMPANY = $company
                                                GROUP BY
                                                        BULAN
                                                ORDER BY
                                                        BULAN
                                        ) B ON X.BLN = B.BLN
                                        ORDER BY
                                                X. MONTH
                                ) RKAP ON VAL.BLN = RKAP.BLN");
        foreach ($query->result_array() as $rowID) {
            $bln = $rowID['BLN'];
            $month = $rowID['MONTH'];
            $cost = $rowID['COST'];
            $chart = $rowID['CHART'];
            $chart_code = $rowID['CHART_CODE'];
            $bulan = $rowID['BULAN'];
            $rkap = $rowID['RKAP'];

            $jml["d" . $chart_code][$month] = array(
                'bln' => $bln,
                'bulan' => $bulan,
                'month' => $month,
                'cost' => $cost,
                'rkap' => $rkap,
                'chart' => $chart
            );
        }

        echo json_encode($jml);
    }

    function get_mt_table_dept() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
        } else {
            $company = 7000;
        }

        $query = $db->query("SELECT
                                        A .DEPART,
                                        A .CHART,
                                        A . COST,
                                        RKAP.RKAP,
                                        ROUND ((A . COST / RKAP.RKAP) * 100, 1) PERCENT
                                FROM
                                        (
                                                SELECT
                                                        DEPART,
                                                        CASE DEPART
                                                WHEN 'DEPARTEMEN PRODUKSI  SEMEN' THEN
                                                        '50029279'
                                                WHEN 'NON PABRIK' THEN
                                                        '99999999'
                                                WHEN 'DEPARTEMEN PRODUKSI  TERAK I' THEN
                                                        '50029277'
                                                WHEN 'DEPARTEMEN PRODUKSI  TERAK II' THEN
                                                        '50029278'
                                                WHEN 'DEPARTEMEN JAMUT, K3 & LINGKUNGAN' THEN
                                                        '50036065'
                                                WHEN 'DEPARTEMEN TEKNIK' THEN
                                                        '50036064'
                                                WHEN 'BIRO PABRIK  GRESIK' THEN
                                                        '50029429'
                                                WHEN 'DEPARTEMEN PRODUKSI BAHAN BAKU' THEN
                                                        '50029276'
                                                END CHART,
                                                SUM (TO_NUMBER(OBJ_CURR)) AS COST
                                        FROM
                                                MSO_PM_MAINT_COST
                                        WHERE
                                                TAHUN = $tahun AND SUBSTR(COST_CNTR, 1, 1) = '7'
                                        GROUP BY
                                                DEPART
                                        ORDER BY
                                                DEPART
                                        ) A
                                JOIN (
                                        SELECT
                                                MDEPT_CODE,
                                                SUM (RKAP) RKAP
                                        FROM
                                                MSO_PM_MAINT_COST_RKAP
                                        WHERE
                                                TAHUN = $tahun AND COMPANY = $company
                                        GROUP BY
                                                MDEPT_CODE
                                        ORDER BY
                                                MDEPT_CODE
                                ) RKAP ON A .CHART = RKAP.MDEPT_CODE");

        echo json_encode($query->result_array());
    }

    function get_mt_chart_cost() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
        } else {
            $company = 7000;
        }

        $query = $db->query("SELECT
                                        VAL.*, CASE VAL.CHART
                                WHEN 'OUTSOURCHING' THEN
                                        'O'
                                WHEN 'PEMAKAIAN SPARE PART' THEN
                                        'S'
                                END CHART_CODE,
                                 RKAP.BULAN,
                                 RKAP.RKAP
                                FROM
                                        (
                                                SELECT
                                                        TO_CHAR (
                                                                TO_DATE (A . MONTH, 'MM'),
                                                                'MON'
                                                        ) BLN,
                                                        A . MONTH,
                                                        C.CHART,
                                                        NVL (B. COST, 0) COST
                                                FROM
                                                        (
                                                                SELECT
                                                                        'E' KEY_COL,
                                                                        LEVEL AS MONTH
                                                                FROM
                                                                        DUAL CONNECT BY LEVEL <= 12
                                                        ) A
                                                LEFT JOIN (
                                                        SELECT DISTINCT
                                                                KELP_CE AS CHART,
                                                                'E' KEY_COL2
                                                        FROM
                                                                MSO_PM_MAINT_COST
                                                        WHERE
                                                                TAHUN = $tahun AND SUBSTR(COST_CNTR, 1, 1) = '7'
                                                ) C ON C.KEY_COL2 = A .KEY_COL
                                                LEFT JOIN (
                                                        SELECT
                                                                TO_NUMBER (MONTH) AS MONTH,
                                                                KELP_CE AS CHART,
                                                                SUM (TO_NUMBER(OBJ_CURR)) AS COST
                                                        FROM
                                                                MSO_PM_MAINT_COST
                                                        WHERE
                                                                TAHUN = $tahun AND SUBSTR(COST_CNTR, 1, 1) = '7'
                                                        GROUP BY
                                                                MONTH,
                                                                KELP_CE
                                                        ORDER BY
                                                                MONTH
                                                ) B ON A . MONTH = B. MONTH
                                                AND C.CHART = B.CHART
                                                ORDER BY
                                                        A . MONTH
                                        ) VAL
                                JOIN (
                                        SELECT
                                                X.BLN,
                                                X. MONTH,
                                                B.BULAN,
                                                NVL (B.RKAP, 0) RKAP
                                        FROM
                                                (
                                                        SELECT
                                                                TO_CHAR (
                                                                        TO_DATE (A . MONTH, 'MM'),
                                                                        'MON'
                                                                ) BLN,
                                                                A . MONTH
                                                        FROM
                                                                (
                                                                        SELECT
                                                                                LEVEL AS MONTH
                                                                        FROM
                                                                                DUAL CONNECT BY LEVEL <= 12
                                                                ) A
                                                ) X
                                        LEFT JOIN (
                                                SELECT
                                                        TO_CHAR (TO_DATE(BULAN, 'MM'), 'MON') BLN,
                                                        BULAN,
                                                        SUM (RKAP) RKAP
                                                FROM
                                                        MSO_PM_MAINT_COST_RKAP
                                                WHERE
                                                        TAHUN = $tahun AND COMPANY = $company
                                                GROUP BY
                                                        BULAN
                                                ORDER BY
                                                        BULAN
                                        ) B ON X.BLN = B.BLN
                                        ORDER BY
                                                X. MONTH
                                ) RKAP ON VAL.BLN = RKAP.BLN");
        foreach ($query->result_array() as $rowID) {
            $bln = $rowID['BLN'];
            $month = $rowID['MONTH'];
            $cost = $rowID['COST'];
            $chart = $rowID['CHART'];
            $chart_code = $rowID['CHART_CODE'];
            $bulan = $rowID['BULAN'];
            $rkap = $rowID['RKAP'];

            $jml[$chart_code][$month] = array(
                'bln' => $bln,
                'bulan' => $bulan,
                'month' => $month,
                'cost' => $cost,
                'rkap' => $rkap,
                'chart' => $chart
            );
        }

        echo json_encode($jml);
    }

    function get_mt_table_cost() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (!empty($_GET['company'])) {
            $company = $_GET['company'];
        } else {
            $company = 7000;
        }

        $query = $db->query("SELECT
                                    VAL.CHART,
                                    VAL. COST,
                                    RKAP.CHART_CODE,
                                    RKAP.RKAP,
                                    ROUND ((VAL. COST / RKAP.RKAP) * 100, 1) PERCENT
                            FROM
                                    (
                                            SELECT
                                                    KELP_CE CHART,
                                                    CASE KELP_CE
                                            WHEN 'OUTSOURCHING' THEN
                                                    'OS'
                                            WHEN 'PEMAKAIAN SPARE PART' THEN
                                                    'SP'
                                            END CHART_CODE,
                                            SUM (OBJ_CURR) COST
                                    FROM
                                            MSO_PM_MAINT_COST
                                    WHERE
                                            TAHUN = $tahun AND SUBSTR(COST_CNTR, 1, 1) = '7'
                                    GROUP BY
                                            KELP_CE
                                    ) VAL
                            JOIN (
                                    SELECT
                                            'SP' AS CHART_CODE,
                                            SUM (RKAP) * 0.6 AS RKAP
                                    FROM
                                            MSO_PM_MAINT_COST_RKAP
                                    WHERE
                                            TAHUN = $tahun AND COMPANY = $company
                                    UNION
                                            SELECT
                                                    'OS' AS CHART_CODE,
                                                    SUM (RKAP) * 0.4 AS RKAP
                                            FROM
                                                    MSO_PM_MAINT_COST_RKAP
                                            WHERE
                                                    TAHUN = $tahun AND COMPANY = $company
                            ) RKAP ON VAL.CHART_CODE = RKAP.CHART_CODE");

        echo json_encode($query->result_array());
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Dashboard PIS">
    public function get_mimic_tb34() {
        $mySiloURL = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Status_HRC1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Status_HRC2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Feed_Mill%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Sep_Damper%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Sep_Fan_Current%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Rate_WF3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Rate_WF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Rate_WF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Rate_RF1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Rate_RF2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Rate_WF2A%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM5_Rate_WFRT%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Feed_Tot%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Feed_Ctr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_GB_Vib1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_GB_Vib2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Prod_Ystd%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Prod_Clk%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cal_Bot_TT%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Status_IDFan1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Status_IDFan2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Status_Drive1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Status_Drive2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Feed_Ctrl%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M90%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M80%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M70%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M60%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M50%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M40%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M30%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M20%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M10%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Hood_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_CCB_Press1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_CCB_Press2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D11_F_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D11_R_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D12_F_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D12_R_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D21_F_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D21_R_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D22_F_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D22_R_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Opacity_Cooler%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Cooler_Air_Flow%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan08%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan09%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan10%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan11%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan12%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan13%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan14%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan15%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan16%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Speed_Ctr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Level_Max_Silo13%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Level_Max_Silo14%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Level_Max_Silo15%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Level_Max_Silo16%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Level_Max_Silo09%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Level_Max_Silo10%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($mySiloURL);
    }

    public function raw_mill_tb4() {
        $tags = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_LS_Belt_Weighter%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Mix_Belt_Weighter%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Iron_Feeder%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Silica_Feeder%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Recipe_feed1_th%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Recipe_feed2_th%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Recipe_feed3_th%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Recipe_feed4_th%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Recipe_feed1_QCX%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Recipe_feed2_QCX%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Recipe_feed3_QCX%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Recipe_feed4_QCX%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Volt_EP_Rect02%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Volt_EP_Rect03%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Volt_EP_Rect04%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Volt_EP_Rect05%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Volt_EP_Rect06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Volt_EP_Rect07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Volt_EP_Rect08%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Volt_EP_Rect09%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Amp_EP_Rect02%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Amp_EP_Rect03%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Amp_EP_Rect04%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Amp_EP_Rect05%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Amp_EP_Rect06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Amp_EP_Rect07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Amp_EP_Rect08%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Amp_EP_Rect09%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_EP_Spark_Rate02%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_EP_Spark_Rate03%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_EP_Spark_Rate04%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_EP_Spark_Rate05%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_EP_Spark_Rate06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_EP_Spark_Rate07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_EP_Spark_Rate08%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_EP_Spark_Rate09%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Feed_Tot%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Feed_Ctr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Feed_Pressure%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Sys_Grinding_Pressure%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_BC_Current%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_GB_Vib1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_GB_Vib2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Motor_Power%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Inlet_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Inlet_Pressure%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Louvre_damp05%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Louvre_damp03%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Sep_Current%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Sep_Power%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Sep_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Speed_Control%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Outlet_Pressure%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Outlet_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Louvre_damp01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_L1_Current_Mill_Fan%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Act_Power_Mill_Fan%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Water_Flow_Inject%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Water_Spray_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Dust_Meas_sys%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_LSF_Prod%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_SiM_Prod%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_AlM_Prod%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Mesh_Prod%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22RM4_Tuban_Blend1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22RM4_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Separator%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Mill_Fan%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Guilotine_damp02%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Guilotine_damp06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Bottom_gate%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Disch_gate334%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Disch_gate344%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.RM4_Diff_Pressure%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($tags);
    }

    public function finish_mill7_tb4() {
        $tags = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Clink_Silo_Level%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_BE02_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_BE01_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Feed_Reject%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_kWh_perton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Motor_Vibration%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Motor_Vibration1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Feed_Reject_Tot%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Motor_Power%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Status_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Drive%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Inlet_Temp01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_DP_Mill04%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Hyd_System_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Water_Injection_Flow%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Separator_Speed_Str%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Separator%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Outlet_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Outlet_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Calc_Diff_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Rotary_Curr06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Rotary_Curr07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Rotary_Feeder06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Rotary_Feeder07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Damp_F_Position%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Fan_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Fan_Pwr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Fan_Spd%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Fan%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Ctr_Flap_S_Position%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Damp_D_Position%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_BE_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Silo1_Ton_Est%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Silo2_Ton_Est%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Silo3_Ton_Est%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Silo4_Ton_Est%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_FCaO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_C3S%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Clink_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Reject_Extbelt_Flow%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_WF_Setpoint_Gypsum%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_WF_Trass%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_WF_Additive%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Flyash_Flow%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_QCX_SetPoint1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_QCX_SetPoint2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_QCX_SetPoint3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_QCX_SetPoint4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_QCX_SetPoint5%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Feed_Reject%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Blaine_PPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_SO3_PPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mesh_PPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Blaine_OPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_SO3_OPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mesh_OPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Prod_Today%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Prod_Yest%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_PXP_FM%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM7_Mill_Inlet_Temp02%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($tags);
    }

    public function finish_mill8_tb4() {
        $tags = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Clink_Silo_Level%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_BE02_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_BE01_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Feed_Reject%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_kWh_perton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Motor_Vibration%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Motor_Vibration1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Feed_Reject_Tot%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Motor_Power%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Status_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Drive%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Inlet_Temp01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_DP_Mill04%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Hyd_System_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Water_Injection_Flow%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Separator_Speed_Str%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Separator%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Outlet_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Outlet_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Calc_Diff_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Rotary_Curr06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Rotary_Curr07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Rotary_Feeder06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Rotary_Feeder07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Damp_F_Position%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Fan_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Fan_Pwr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Fan_Spd%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Fan%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Ctr_Flap_S_Position%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Damp_D_Position%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_BE_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Silo1_Ton_Est%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Silo2_Ton_Est%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Silo3_Ton_Est%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Silo4_Ton_Est%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_FCaO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_C3S%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Clink_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Reject_Extbelt_Flow%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_WF_Setpoint_Gypsum%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_WF_Trass%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_WF_Additive%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Flyash_Flow%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_QCX_SetPoint1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_QCX_SetPoint2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_QCX_SetPoint3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_QCX_SetPoint4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_QCX_SetPoint5%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Feed_Reject%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Blaine_PPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_SO3_PPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mesh_PPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Blaine_OPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_SO3_OPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mesh_OPC%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Prod_Today%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Prod_Yest%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_PXP_FM%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.FM8_Mill_Inlet_Temp02%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($tags);
    }

    public function cooler_tb4() {
        $tags = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_PXP%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Hood_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Hood_Draft%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Depth_Cooler%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Hyd_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_kW_Ton_Clinker%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D11_F_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D12_F_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D21_F_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D22_F_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D11_R_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D12_R_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D21_R_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_D22_R_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Cooler_Air_Flow%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan08%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Press_Fan09%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Pwr_06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Pwr_07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Pwr_08%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Pwr_09%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Pwr_10%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Pwr_11%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Pwr_12%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Pwr_13%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Pwr_14%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Pwr_15%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Pwr_16%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr_06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr_07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr_08%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr_09%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr_10%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr_11%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr_12%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr_13%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr_14%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr_15%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Speed_Ctr_16%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Flow_06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Flow_07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Flow_08%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Flow_09%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Flow_10%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Flow_11%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Flow_12%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Flow_13%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Flow_14%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Flow_15%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_Flow_16%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_06%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_07%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_08%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_09%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_10%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_11%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_12%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_13%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_14%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_15%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Fan_16%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Curr_Chr_Roll1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Curr_Chr_Roll2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Curr_Trans_Roll1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Curr_Trans_Roll2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Roll_Break%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Inlet_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Volt_Rect02%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Volt_Rect03%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Volt_Rect04%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Curr_Rect02%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Curr_Rect03%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Curr_Rect04%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Spark_Rect02%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Spark_Rect03%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Spark_Rect04%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Louvre_Damper%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Curr_Exc_Airfan%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Pwr_Exc_Airfan%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Spd_Exc_Airfan%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Exc_Airfan%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Opacity_Cooler%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Opacity_Measure%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Curr_Pan_Convy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Flow_Pan_Convy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Slidegate_Mtr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Slidegate%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Level_Offstandard%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.Cooler4_Clink_Silo_Level%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($tags);
    }

    public function kiln_tb4() {
        $tags = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22RM4_Tuban_Blend1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Chgover_Gate%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_BB01_Elevator%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_BB01_Elevator_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_BB02_Elevator%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_BB02_Elevator_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_RF04_Feeder_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_RF03_Feeder_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_RF06_Feeder_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_RF05_Feeder_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_IDFan1_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_IDFan1_DE_Vibr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_IDFan2_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_IDFan2_DE_Vibr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone12_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone11_Pres%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Ops_ExTemp21%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone21_Pres%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone13_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone13_Pres%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone23_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone23_Pres%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone14_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone14_Pres%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone23_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone23_Pres%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone15_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone15_Pres%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone25_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cyclone25_Pres%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cal_Bot_TT%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Tertiary_Air_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_DG11%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_DG21%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_DG12%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_DG22%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Inlet_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Inlet_O2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Drive_Torque%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_MD_Slave_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_MD_Slave_Pwr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_MD_Slave_Spd%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Status_Drive2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_MD_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_MD_Pwr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_MD_Spd%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Cooler_Avgpress%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Status_Drive1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Hyd_Unit_Spd%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Hoodtemp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Hoodpress%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Feed02%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Feed03%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Feed01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Curr_Indication%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Primary_Airfan_Press%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Primary_Airfan%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Primary_Airfan_Curr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Primary_Airfan_Flow%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Primary_Airfan_Press02%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Primary_Airfan_M01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Primary_Airfan_Damp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Indicator_Damp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Coal_Consump%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_LSF%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_SiM%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_AlM%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL4_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_FCaO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_C3S%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Clink_Temp%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Prod_Yest%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Prod_Clk%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Clink_Energy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M10%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M20%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M30%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M40%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M50%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M60%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M70%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M80%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Kiln_Temp_M90%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Status_IDFan1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_Status_IDFan2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_pH_Analyzer_O2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_pH_Analyzer_CO2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_pH_Analyzer_NO%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_PXP_Calc%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_PXP_Kiln%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_IDFan1_NDE_Vibr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203\/4%20Accessories.KL4_IDFan2_NDE_Vibr%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($tags);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="PdM Concept by Akbar & Boss VIP">
    function get_pdmsampledata() {
        $app = 'http://10.15.3.146:58725/OPCREST/getdata?message={"tags":[{"name":"PdM.FM7_547FN09U01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09U01I01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09U01J01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09U01S01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09VT01V01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09VT01V02","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09N21T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09N22T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09N23T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09N24T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09N25T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09TT01T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09TT02T01","props":[{"name":"Value"}]}],"status":"OK","message":"","token":"7e61b230-481d-4551-b24b-ba9046e3d8f2"}&_=1469589103720';
        print file_get_contents($app);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="ARA : PdM">
    function ara_pdm() {
        $app = 'http://10.15.3.146:58725/OPCREST/getdata?message={"tags":[{"name":"PdM.FM7_547FN09U01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09U01I01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09U01J01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09U01S01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09VT01V01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09VT01V02","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09N21T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09N22T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09N23T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09N24T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09N25T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09TT01T01","props":[{"name":"Value"}]},{"name":"PdM.FM7_547FN09TT02T01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09U01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09U01I01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09U01J01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09U01S01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09VT01V01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09VT01V02","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09N21T01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09N22T01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09N23T01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09N24T01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09N25T01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09TT01T01","props":[{"name":"Value"}]},{"name":"PdM.FM8_548FN09TT02T01","props":[{"name":"Value"}]}],"status":"OK","message":"","token":"7e61b230-481d-4551-b24b-ba9046e3d8f2"}&_=1469589103720';
        print file_get_contents($app);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="SHE Room Temp">
    function get_tb34_roomtemp() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban34HSE.RT_18A_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_23A_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_23B_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_23C_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_24_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_25_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_25A_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_25Drive_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_25MCC_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_26_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_26MCC_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_27_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_27MCC1_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_27MCC2_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_29_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_AN01_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_AN01_KL4_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_AN02_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_AN02_KL4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_AN1_CM_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_AN12_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_AN2_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_AN2_CM_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_AN3_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_ER16A_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_ER17_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_ER18_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_ER19_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_ER20_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_H3_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_HRB_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_HS1_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_LOW_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_PW01_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_PW02_TB4%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_PW1_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_PW23_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34HSE.RT_WF_TB3%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($seta);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="OEE">
    function get_oee() {
        $oee = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22TubanOEE.Tb1_Kiln_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb1_Kiln_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb1_Kiln_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb1_FM1_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb1_FM1_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb1_FM1_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb1_FM2_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb1_FM2_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb1_FM2_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb1_FM9_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb1_FM9_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb1_FM9_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb2_Kiln_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb2_Kiln_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb2_Kiln_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb2_FM3_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb2_FM3_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb2_FM3_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb2_FM4_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb2_FM4_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb2_FM4_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb3_Kiln_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb3_Kiln_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb3_Kiln_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb3_FM5_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb3_FM5_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb3_FM5_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb3_FM6_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb3_FM6_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb3_FM6_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb4_Kiln_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb4_Kiln_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb4_Kiln_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb4_FM7_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb4_FM7_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb4_FM7_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb4_FM8_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb4_FM8_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TubanOEE.Tb4_FM8_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($oee);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Third-party Material">
    function get_m3_tb34() {
        $m3 = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban34M3.513BI1LT751%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.513BI2LT752%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.513BI3LT753%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.513BI4LT754%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.513BI5LT755%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.523BI2WT763%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.523BI3WT760%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.537BI01LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.537BI02LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.538BI01LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.538BI02LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.547BI01LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.547BI02LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.547BI03LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.547BI04LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.548BI01LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.548BI02LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.548BI03LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34M3.548BI04LM01W01%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($m3);
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="OPFM">
    function get_ofpm_fm7() {
        $m3 = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban34OFPM.547BF05TR1P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547BF05TR1P02_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547BF05TR1P04_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547BF05TR1P04_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL01TT01T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL01TT01T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL01TT02T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL01TT02T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL01TT03T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL01TT03T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL01TT04T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL01TT04T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL01TT04T01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT01P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT01P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT01P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT02P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT02P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT02P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT03P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT03P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT03P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT04P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT04P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT04P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT05P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT05P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT05P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT06P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT06P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT06P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT07P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT07P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT07P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT08P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT08P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT08P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT09P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT09P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT09P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT10P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT10P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT10P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT11P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT11P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT11P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT12P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT12P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT12P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT13P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT13P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT13P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT14P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT14P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT14P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT15P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT15P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT15P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT21P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT21P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT22P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02PT22P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02TT01T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02TT01T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02TT01T01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02TT02T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02TT02T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547CL02TT02T01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09N21T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09N21T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09N22T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09N22T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09N23T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09N23T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09N24T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09N24T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09N25T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09N25T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09TT01T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09TT01T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09VT01V01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09VT01V01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09VT01V02_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547FN09VT01V02_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547HS01TT01T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547HS01TT01T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547HS01TT01T01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT04T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT04T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT05T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT05T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT06T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT06T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT07T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT07T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT08T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT08T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT09T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT09T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT10T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT10T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT10T01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT11T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT11T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT11T01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT12T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT12T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547RM01TT12T01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT01T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT01T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT02T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT02T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT03T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT03T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT04T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT04T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT05T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT05T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT06T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT06T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT07T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.547SR01TT07T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($m3);
    }
    
    function get_ofpm_fm8() {
        $m3 = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tuban34OFPM.548BF05TR1P04_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548BF05TR1P04_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL01TT01T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL01TT01T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL01TT02T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL01TT02T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL01TT03T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL01TT03T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL01TT04T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL01TT04T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL01TT04T01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT01P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT01P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT01P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT01P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT02P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT02P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT02P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT02P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT03P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT03P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT03P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT03P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT04P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT04P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT04P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT04P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT05P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT05P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT05P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT05P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT06P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT06P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT06P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT06P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT07P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT07P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT07P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT07P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT08P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT08P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT08P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT08P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT09P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT09P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT09P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT09P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT10P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT10P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT10P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT10P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT11P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT11P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT11P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT11P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT12P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT12P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT12P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT12P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT13P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT13P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT13P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT13P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT14P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT14P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT14P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT14P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT15P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT15P01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT15P01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT15P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT21P01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT21P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02PT22P01_L2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02TT01T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02TT01T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02TT01T01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02TT02T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548CL02TT02T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09N21T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09N21T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09N22T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09N22T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09N24T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09N24T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09N25T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09N25T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09TT01T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09TT01T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09TT02T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09TT02T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09VT01V01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09VT01V01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09VT01V02_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548FN09VT01V02_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548HS01TT01T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548HS01TT01T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548HS01TT01T01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT04T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT04T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT05T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT05T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT06T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT06T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT07T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT07T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT08T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT08T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT09T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT09T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT10T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT10T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT10T01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT11T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT11T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT11T01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT12T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT12T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548RM01TT12T01_L1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT01T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT01T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT02T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT02T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT03T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT03T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT04T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT04T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT05T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT05T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT06T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT06T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT07T01_H1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban34OFPM.548SR01TT07T01_H2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($m3);
    }

    // </editor-fold>
}
