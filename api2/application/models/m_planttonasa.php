<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_planttonasa extends CI_Model {

    public function get_statefeed() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Tonasa%202\/3.CM1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.CM1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.FM1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.FM1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM1_TNS2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM1_TNS3_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.FM1_TNS2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.FM1_TNS3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL1_TNS2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL1_TNS3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM1_TNS2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM1_TNS3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.CM_TNS2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL_TNS2_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.KL_TNS3_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.CM_TNS3_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.CM1_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.CM2_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.FM1_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.FM2_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.KL_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.RM1_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.RM2_TNS4_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.CM1_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.CM2_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.FM1_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.FM2_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.KL_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.RM1_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.RM2_TNS4_MOTOR%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CM_TNS5_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.FM1_TNS5_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.FM2_TNS5_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.KL_TNS5_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.RM_TNS5_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.CM_TNS5_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.FM1_TNS5_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.FM2_TNS5_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.KL_TNS5_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.RM_TNS5_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.KL_TNS4_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.KL_TNS5_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM_TNS2_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%202\/3.RM_TNS3_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%204.RM_TNS4_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tonasa%205.RM_TNS5_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }

    public function get_silo() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A%5B{%22name%22%3A%22Tonasa%205.Silo_Meter_51%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22Tonasa%205.Silo_Meter_52%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22Tonasa%205.Silo_Meter_53%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22Tonasa%205.Silo_Tonage_51%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22Tonasa%205.Silo_Tonage_52%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22Tonasa%205.Silo_Tonage_53%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22Tonasa%204.Silo_41_Percent%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22Tonasa%204.Silo_42_Percent%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%2C{%22name%22%3A%22Tonasa%204.Silo_43_Percent%22%2C%22props%22%3A%5B{%22name%22%3A%22Value%22}%5D}%5D%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
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
                SUM (RM2_PROD) AS RM2_PROD,
                SUM (RM2_JOP) AS RM2_JOP,
                SUM (RM3_PROD) AS RM3_PROD,
                SUM (RM3_JOP) AS RM3_JOP,
                SUM (RM41_PROD) AS RM41_PROD,
                SUM (RM41_JOP) AS RM41_JOP,
                SUM (RM42_PROD) AS RM42_PROD,
                SUM (RM42_JOP) AS RM42_JOP,
                SUM (RM5_PROD) AS RM5_PROD,
                SUM (RM5_JOP) AS RM5_JOP,
                SUM (KL2_PROD) AS KL2_PROD,
                SUM (KL2_JOP) AS KL2_JOP,
                SUM (KL3_PROD) AS KL3_PROD,
                SUM (KL3_JOP) AS KL3_JOP,
                SUM (KL4_PROD) AS KL4_PROD,
                SUM (KL4_JOP) AS KL4_JOP,
                SUM (KL5_PROD) AS KL5_PROD,
                SUM (FM2_PROD) AS FM2_PROD,
                SUM (FM2_JOP) AS FM2_JOP,
                SUM (FM3_PROD) AS FM3_PROD,
                SUM (FM3_JOP) AS FM3_JOP,
                SUM (FM41_PROD) AS FM41_PROD,
                SUM (FM41_JOP) AS FM41_JOP,
                SUM (FM42_PROD) AS FM42_PROD,
                SUM (FM42_JOP) AS FM42_JOP,
                SUM (FM51_PROD) AS FM51_PROD,
                SUM (FM51_JOP) AS FM51_JOP,
                SUM (FM52_PROD) AS FM52_PROD,
                SUM (FM52_JOP) AS FM52_JOP,
                SUM (KL5_JOP) AS KL5_JOP
            FROM
                PIS_ST_PRODDAILY
            WHERE
                TO_CHAR (DATE_PROD, 'YYYY-MM') LIKE '$tahun-$bulan'");

        foreach ($query->result_array() as $rowID) {
            $rm2_prod = $rowID['RM2_PROD'];
            $rm2_jop = $rowID['RM2_JOP'];
            $rm3_prod = $rowID['RM3_PROD'];
            $rm3_jop = $rowID['RM3_JOP'];
            $rm41_prod = $rowID['RM41_PROD'];
            $rm41_jop = $rowID['RM41_JOP'];
            $rm42_prod = $rowID['RM42_PROD'];
            $rm42_jop = $rowID['RM42_JOP'];
            $rm5_prod = $rowID['RM5_PROD'];
            $rm5_jop = $rowID['RM5_JOP'];
            $kl2_prod = $rowID['KL2_PROD'];
            $kl2_jop = $rowID['KL2_JOP'];
            $kl3_prod = $rowID['KL3_PROD'];
            $kl3_jop = $rowID['KL3_JOP'];
            $kl4_prod = $rowID['KL4_PROD'];
            $kl4_jop = $rowID['KL4_JOP'];
            $kl5_prod = $rowID['KL5_PROD'];
            $fm2_prod = $rowID['FM2_PROD'];
            $fm2_jop = $rowID['FM2_JOP'];
            $fm3_prod = $rowID['FM3_PROD'];
            $fm3_jop = $rowID['FM3_JOP'];
            $fm41_prod = $rowID['FM41_PROD'];
            $fm41_jop = $rowID['FM41_JOP'];
            $fm42_prod = $rowID['FM42_PROD'];
            $fm42_jop = $rowID['FM42_JOP'];
            $fm51_prod = $rowID['FM51_PROD'];
            $fm51_jop = $rowID['FM51_JOP'];
            $fm52_prod = $rowID['FM52_PROD'];
            $fm52_jop = $rowID['FM52_JOP'];
            $kl5_jop = $rowID['KL5_JOP'];
        }

        $data = array('pabrik' => 'Tonasa',
            'rm2_prod' => number_format($rm2_prod, 2, ".", ""),
            'rm2_jop' => number_format($rm2_jop, 2, ".", ""),
            'rm3_prod' => number_format($rm3_prod, 2, ".", ""),
            'rm3_jop' => number_format($rm3_jop, 2, ".", ""),
            'rm41_prod' => number_format($rm41_prod, 2, ".", ""),
            'rm41_jop' => number_format($rm41_jop, 2, ".", ""),
            'rm42_prod' => number_format($rm42_prod, 2, ".", ""),
            'rm42_jop' => number_format($rm42_jop, 2, ".", ""),
            'rm5_prod' => number_format($rm5_prod, 2, ".", ""),
            'rm5_jop' => number_format($rm5_jop, 2, ".", ""),
            'kl2_prod' => number_format($kl2_prod, 2, ".", ""),
            'kl2_jop' => number_format($kl2_jop, 2, ".", ""),
            'kl3_prod' => number_format($kl3_prod, 2, ".", ""),
            'kl3_jop' => number_format($kl3_jop, 2, ".", ""),
            'kl4_prod' => number_format($kl4_prod, 2, ".", ""),
            'kl4_jop' => number_format($kl4_jop, 2, ".", ""),
            'kl5_prod' => number_format($kl5_prod, 2, ".", ""),
            'fm2_prod' => number_format($fm2_prod, 2, ".", ""),
            'fm2_jop' => number_format($fm2_jop, 2, ".", ""),
            'fm3_prod' => number_format($fm3_prod, 2, ".", ""),
            'fm3_jop' => number_format($fm3_jop, 2, ".", ""),
            'fm41_prod' => number_format($fm41_prod, 2, ".", ""),
            'fm41_jop' => number_format($fm41_jop, 2, ".", ""),
            'fm42_prod' => number_format($fm42_prod, 2, ".", ""),
            'fm42_jop' => number_format($fm42_jop, 2, ".", ""),
            'fm51_prod' => number_format($fm51_prod, 2, ".", ""),
            'fm51_jop' => number_format($fm51_jop, 2, ".", ""),
            'fm52_prod' => number_format($fm52_prod, 2, ".", ""),
            'fm52_jop' => number_format($fm52_jop, 2, ".", ""),
            'kl5_jop' => number_format($kl5_jop, 2, ".", "")
        );

        echo json_encode($data);
    }

    public function get_totaltahun() {
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if(strlen($bulan)<2){
            $month = '0'.$bulan;
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
                                    SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM41_PROD) + SUM (RM42_PROD) + SUM (RM5_PROD) AS rawmill,
                                    SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) + SUM (KL5_PROD) AS kiln,
                                    SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM41_PROD) + SUM (FM42_PROD) + SUM (FM51_PROD) + SUM (FM52_PROD) AS finishmill
                            FROM
                                    PIS_ST_PRODMONTH
                            WHERE
                                    MONTH_PROD LIKE '%" . $tahun . "%'";
        } else  {
            $sql = "SELECT
                                    SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM41_PROD) + SUM (RM42_PROD) + SUM (RM5_PROD) AS rawmill,
                                    SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) + SUM (KL5_PROD) AS kiln,
                                    SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM41_PROD) + SUM (FM42_PROD) + SUM (FM51_PROD) + SUM (FM52_PROD) AS finishmill
                            FROM
                                    PIS_ST_PRODMONTH
                            WHERE
                                    MONTH_PROD LIKE '" . $tahun . "-" . $month . "'";
        }
        $query = $db->query($sql);

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RAWMILL'], 2, ".", "");
            $kl = number_format($rowID['KILN'], 2, ".", "");
            $fm = number_format($rowID['FINISHMILL'], 2, ".", "");
        }

        $data = array('pabrik' => 'Tonasa',
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
                                    SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM41_PROD) + SUM (RM42_PROD) + SUM (RM5_PROD) AS rawmill,
                                    SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) + SUM (KL5_PROD) AS kiln,
                                    SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM41_PROD) + SUM (FM42_PROD) + SUM (FM51_PROD) + SUM (FM52_PROD) AS finishmill
                            FROM
                                    PIS_ST_PRODMONTH
                            WHERE
                                    MONTH_PROD LIKE '%" . $tahun . "%'");

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RAWMILL'], 2, ".", "");
            $kl = number_format($rowID['KILN'], 2, ".", "");
            $fm = number_format($rowID['FINISHMILL'], 2, ".", "");
        }

        $data = array('pabrik' => 'Tonasa',
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
                                    V_PIS_ST_PLANT
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
                                    COMPANY = 4000
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
                                        RM2_PROD,
                                        RM3_PROD,
                                        RM41_PROD,
                                        RM41_JOP,
                                        RM42_PROD,
                                        RM5_PROD,
                                        KL2_PROD,
                                        KL3_PROD,
                                        KL4_PROD,
                                        KL5_PROD,
                                        FM2_PROD,
                                        FM3_PROD,
                                        FM41_PROD,
                                        FM42_PROD,
                                        FM51_PROD,
                                        FM52_PROD
                                FROM
                                        PIS_ST_PRODMONTH
                                WHERE MONTH_PROD LIKE '$tahun-%'
                                ORDER BY
                                        MONTH_PROD");

        foreach ($query_data->result_array() as $rowID) {
            $month = $rowID['MONTH_PROD'];

            $rm2 = $rowID['RM2_PROD'];
            $rm3 = $rowID['RM3_PROD'];
            $rm4 = $rowID['RM41_PROD'] + $rowID['RM42_PROD'];
            $rm5 = $rowID['RM5_PROD'];

            $kl2 = $rowID['KL2_PROD'];
            $kl3 = $rowID['KL3_PROD'];
            $kl4 = $rowID['KL4_PROD'];
            $kl5 = $rowID['KL5_PROD'];

            $fm_tns2 = $rowID['FM2_PROD'];
            $fm_tns3 = $rowID['FM3_PROD'];
            $fm_tns4 = $rowID['FM41_PROD'] + $rowID['FM42_PROD'];
            $fm_tns5 = $rowID['FM51_PROD'] + $rowID['FM52_PROD'];

            $to_prod[$month] = array(
                "rm2" => number_format($rm2, 2, ".", ""),
                "rm3" => number_format($rm3, 2, ".", ""),
                "rm4" => number_format($rm4, 2, ".", ""),
                "rm5" => number_format($rm5, 2, ".", ""),
                "kl2" => number_format($kl2, 2, ".", ""),
                "kl3" => number_format($kl3, 2, ".", ""),
                "kl4" => number_format($kl4, 2, ".", ""),
                "kl5" => number_format($kl5, 2, ".", ""),
                "fm_tns2" => number_format($fm_tns2, 2, ".", ""),
                "fm_tns3" => number_format($fm_tns3, 2, ".", ""),
                "fm_tns4" => number_format($fm_tns4, 2, ".", ""),
                "fm_tns5" => number_format($fm_tns5, 2, ".", "")
            );
        }

        $myJSON = array(
            "rkap" => $rkap,
            "prod" => $to_prod
        );
        echo '{"7000":' . json_encode($myJSON) . '}';
    }

}
