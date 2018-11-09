<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_rkapall extends CI_Model {

    public function get_rkap_month() {
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['company'])) {
            switch ($_GET['company']) {
                case 3000 :
                    $myCompany = "WHERE COMPANY = 3000";
                    break;
                case 4000 :
                    $myCompany = "WHERE COMPANY = 4000";
                    break;
                case 5000 :
                    $myCompany = "WHERE COMPANY = 5000";
                    break;
                case 6000 :
                    $myCompany = "WHERE COMPANY = 6000";
                    break;
                case 7000 :
                    $myCompany = "WHERE COMPANY = 7000";
                    break;
                default :
                    $myCompany = "";
            }
        } else {
            $myCompany = "";
        }

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    BULAN,
                                    TAHUN,
                                    CLINKER,
                                    CEMENT
                            FROM
                                    PIS_RKAP_TOTAL
                            $myCompany
                            AND TAHUN = $tahun");

        foreach ($query->result_array() as $rowID) {
            $bulan = $rowID['BULAN'];
            $clinker = $rowID['CLINKER'];
            $cement = $rowID['CEMENT'];

            $data['s' . $bulan] = array(
                'bulan' => $bulan,
                'clinker' => $clinker,
                'cement' => $cement
            );
        }

        echo json_encode($data);
    }

    public function get_rkap_year() {
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['company'])) {
            switch ($_GET['company']) {
                case 3000 :
                    $myCompany = "WHERE COMPANY = 3000";
                    break;
                case 4000 :
                    $myCompany = "WHERE COMPANY = 4000";
                    break;
                case 5000 :
                    $myCompany = "WHERE COMPANY = 5000";
                    break;
                case 6000 :
                    $myCompany = "WHERE COMPANY = 6000";
                    break;
                case 7000 :
                    $myCompany = "WHERE COMPANY = 7000";
                    break;
                default :
                    $myCompany = "";
            }
        } else {
            $myCompany = "";
        }

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    COMPANY,
                                    SUM (CAST(clinker AS NUMERIC)) AS klinker,
                                    SUM (CAST(cement AS NUMERIC)) AS semen
                            FROM
                                    PIS_RKAP_TOTAL
                            $myCompany
                            AND tahun = $tahun
                            GROUP BY
                                    COMPANY");

        foreach ($query->result_array() as $rowID) {
            $company = $rowID['COMPANY'];
            $clinker = $rowID['KLINKER'];
            $cement = $rowID['SEMEN'];
            $data['s' . $company] = array(
                'company' => $company,
                'clinker' => $clinker,
                'cement' => $cement
            );
        }

        echo json_encode($data);
    }

}
