<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_planttlcc extends CI_Model {

    public function get_statefeed() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22TLCC.RM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.CM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.KL1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.FM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.FM2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.RM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.CM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.KL1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.FM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.FM2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.KL1_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.RM1_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.CM1_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }

    public function get_silo() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22TLCC.Silo1_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.Silo2_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.Silo1_Meter%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.Silo2_Meter%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.Silo3_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.Silo4_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.Silo_Cement_HCM1%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.Silo_Cement_HCM2%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
    }

    public function get_emission() {
        $myUrl = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22TLCC.KL1_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.RM1_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCC.CM1_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($myUrl);
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
                SUM (RM1_PROD) AS rm,
                SUM (KL1_PROD) AS kl,
                SUM (FMMP_PROD) + SUM (FMHCM_PROD) AS fm
        FROM
                PIS_TLCC_PRODMONTH WHERE MONTH_PROD LIKE '%" . $tahun . "%'";
        } else {
            $sql = "SELECT
                SUM (RM1_PROD) AS rm,
                SUM (KL1_PROD) AS kl,
                SUM (FMMP_PROD) + SUM (FMHCM_PROD) AS fm
        FROM
                PIS_TLCC_PRODMONTH WHERE MONTH_PROD LIKE '" . $tahun . "-" . $month . "'";
        }

        $query = $db->query($sql);

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RM'], 2, ".", "");
            $kl = number_format($rowID['KL'], 2, ".", "");
            $fm = number_format($rowID['FM'], 2, ".", "");
        }

        $data = array('pabrik' => 'TLCC',
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
                SUM (RM1_PROD) AS rm,
                SUM (KL1_PROD) AS kl,
                SUM (FMMP_PROD) + SUM (FMHCM_PROD) AS fm
        FROM
                PIS_TLCC_PRODMONTH WHERE MONTH_PROD LIKE '%" . $tahun . "%'");

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RM'], 2, ".", "");
            $kl = number_format($rowID['KL'], 2, ".", "");
            $fm = number_format($rowID['FM'], 2, ".", "");
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
                                    V_PIS_TLCC_PLANT
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
                                    COMPANY = 6000
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
                                        FMMP_PROD,
                                        FMHCM_PROD
                                FROM
                                        PIS_TLCC_PRODMONTH
                                WHERE MONTH_PROD LIKE '$tahun-%'
                                ORDER BY
                                        MONTH_PROD");

        foreach ($query_data->result_array() as $rowID) {
            $month = $rowID['MONTH_PROD'];

            $rm1 = $rowID['RM1_PROD'];

            $kl1 = $rowID['KL1_PROD'];

            $fm_mp = $rowID['FMMP_PROD'];
            $fm_gp = $rowID['FMHCM_PROD'];

            $to_prod[$month] = array(
                "rm1" => $rm1,
                "kl1" => $kl1,
                "fm_mp" => $fm_mp,
                "fm_gp" => $fm_gp
            );
        }

        $myJSON = array(
            "rkap" => $rkap,
            "prod" => $to_prod
        );
        echo '{"7000":' . json_encode($myJSON) . '}';
    }

    public function get_prodjop() {
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

        if (!empty($_GET['bulan']) and ! empty($_GET['tahun'])) {
            $where = "WHERE MONTH_PROD LIKE '" . $tahun . "-" . $bulan . "'";
        } else {
            $where = "";
        }

        $query = $db->query("SELECT
                    SUM (rm1_prod) AS prod_rm,
                    SUM (rm1_jop) AS jop_rm,
                    SUM (kl1_prod) AS prod_kl,
                    SUM (kl1_jop) AS jop_kl,
                    SUM (fmmp_prod) AS prod_fmmp,
                    SUM (fmmp_prod) AS jop_fmmp,
                    SUM (fmhcm_prod) AS prod_fmhcm,
                    SUM (fmhcm_prod) AS jop_fmhcm
            FROM
                    PIS_TLCC_PRODDAILY
            WHERE
                    TO_CHAR (DATE_PROD, 'YYYY-MM') LIKE '$tahun-$bulan'");

        foreach ($query->result_array() as $rowID) {
            $rm_prod = $rowID['PROD_RM'];
            $rm_jop = $rowID['JOP_RM'];
            $kl_prod = $rowID['PROD_KL'];
            $kl_jop = $rowID['JOP_KL'];
            $fmmp_prod = $rowID['PROD_FMMP'];
            $fmmp_jop = $rowID['JOP_FMMP'];
            $fmhcm_prod = $rowID['PROD_FMHCM'];
            $fmhcm_jop = $rowID['JOP_FMHCM'];
        }

        $data = array('pabrik' => 'TLCC',
            'rm_prod' => number_format($rm_prod, 2, ".", ""),
            'rm_jop' => number_format($rm_jop, 2, ".", ""),
            'kl_prod' => number_format($kl_prod, 2, ".", ""),
            'kl_jop' => number_format($kl_jop, 2, ".", ""),
            'fmmp_prod' => number_format($fmmp_prod, 2, ".", ""),
            'fmmp_jop' => number_format($fmmp_jop, 2, ".", ""),
            'fmhcm_prod' => number_format($fmhcm_prod, 2, ".", ""),
            'fmhcm_jop' => number_format($fmhcm_jop, 2, ".", "")
        );

        echo json_encode($data);
    }
    
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
                                    TAHUN,
                                    PLANT,
                                    CATEGORY,
                                    ROUND ((AVG(DATA_INPUT)), 0) AS PERSEN
                            FROM
                                    MSO_PM_PERFORMANCE
                            WHERE
                                    COMPANY = 6000
                            AND TAHUN = $tahun
                            AND BULAN = '$bulan'
                            GROUP BY
                                    TAHUN,
                                    PLANT,
                                    CATEGORY
                            ORDER BY
                                    PLANT");
        foreach ($query->result_array() as $rowID) {
            $category = $rowID['CATEGORY'];
            $plant = $rowID['PLANT'];
            $percent = $rowID['PERSEN'];
            $tahun = $rowID['TAHUN'];

            $jml[$plant][$category] = array(
                'tahun' => $tahun,
                'persen' => $percent
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
            $plant = 'mp';
        }

        $query = $db->query("SELECT
                                    CATEGORY,
                                    EQUIPMENT,
                                    ROUND (DATA_INPUT, 0) AS DATA_INPUT
                            FROM
                                    MSO_PM_PERFORMANCE
                            WHERE
                                    COMPANY = 6000
                            AND TAHUN = $tahun
                            AND BULAN = '$bulan'
                            AND PLANT = '$plant'");
        foreach ($query->result_array() as $rowID) {
            $category = $rowID['CATEGORY'];
            $data = $rowID['DATA_INPUT'];
            $equipment = $rowID['EQUIPMENT'];

            $jml[$category][$equipment] = array(
                'data' => $data
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
            $plant = 'mp';
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
    // <editor-fold defaultstate="collapsed" desc="OEE">
    function get_oee() {
        $oee = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22TLCCOEE.TLCC_FM1_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCCOEE.TLCC_FM1_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCCOEE.TLCC_FM1_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCCOEE.TLCC_FM2_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCCOEE.TLCC_FM2_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCCOEE.TLCC_FM2_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCCOEE.TLCC_KL_Availability%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCCOEE.TLCC_KL_OEE%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22TLCCOEE.TLCC_KL_Yield%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
        print file_get_contents($oee);
    }
    // </editor-fold>
}
