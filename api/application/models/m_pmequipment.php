<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_pmequipment extends CI_Model {

    public function get_yield() {
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['p'])) {
            $plant = $_GET['p'];
        } else {
            $plant = 'tbn1';
        }

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    *
                            FROM
                                    MSO_EQPT_PERFORMANCE_SG
                            WHERE
                                    PLANT = '$plant'
                            AND CATEGORY = 'YIELD'
                            AND TAHUN = $tahun");

//        foreach ($query->result_array() as $rowID) {
//            $runHours [$rowID['TAGID']][] = $rowID['RUNHOURS'];
//            $idJson [$rowID['TAGID']] = array('tagid' => $rowID['TAGID'],
//                'name' => $rowID['TEXT'],
//                'pabrik' => $rowID['PABRIK']
//            );
//
//            $seqTgl = date('d', strtotime($rowID['OPDATE']));
//            if ($seqTgl != 0 or ! empty($seqTgl)) {
//                $prod[$rowID['TAGID']][$seqTgl] = array(
//                    'rate' => number_format($rowID['RATE'], 0, ",", "."),
//                    'prod' => number_format($rowID['PROD'], 0, ",", "."));
//            }
//            $toprod[$rowID['TAGID']][] = number_format($rowID['PROD'], 0, ",", ".");
//        }
//
//        foreach ($idJson as $alpha) {
//            $runHours_x[$alpha['tagid']] = array(
//                "plant" => $alpha['pabrik'],
//                "name" => $alpha['name'],
//                "tagid" => $alpha['tagid'],
//                "runhours" => array_sum($runHours [$alpha['tagid']]),
//                "tproduksi" => array_sum($toprod[$alpha['tagid']]),
//                "produksi" => $prod[$alpha['tagid']],
//            );
//        }
        echo json_encode($query->result_array());
    }
    
    public function get_utilize() {
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['p'])) {
            $plant = $_GET['p'];
        } else {
            $plant = 'tbn1';
        }

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    *
                            FROM
                                    MSO_EQPT_PERFORMANCE_SG
                            WHERE
                                    PLANT = '$plant'
                            AND CATEGORY = 'UTILISASI'
                            AND TAHUN = $tahun");

//        foreach ($query->result_array() as $rowID) {
//            $runHours [$rowID['TAGID']][] = $rowID['RUNHOURS'];
//            $idJson [$rowID['TAGID']] = array('tagid' => $rowID['TAGID'],
//                'name' => $rowID['TEXT'],
//                'pabrik' => $rowID['PABRIK']
//            );
//
//            $seqTgl = date('d', strtotime($rowID['OPDATE']));
//            if ($seqTgl != 0 or ! empty($seqTgl)) {
//                $prod[$rowID['TAGID']][$seqTgl] = array(
//                    'rate' => number_format($rowID['RATE'], 0, ",", "."),
//                    'prod' => number_format($rowID['PROD'], 0, ",", "."));
//            }
//            $toprod[$rowID['TAGID']][] = number_format($rowID['PROD'], 0, ",", ".");
//        }
//
//        foreach ($idJson as $alpha) {
//            $runHours_x[$alpha['tagid']] = array(
//                "plant" => $alpha['pabrik'],
//                "name" => $alpha['name'],
//                "tagid" => $alpha['tagid'],
//                "runhours" => array_sum($runHours [$alpha['tagid']]),
//                "tproduksi" => array_sum($toprod[$alpha['tagid']]),
//                "produksi" => $prod[$alpha['tagid']],
//            );
//        }
        echo json_encode($query->result_array());
    }
    
    public function get_efficiency() {
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['p'])) {
            $plant = $_GET['p'];
        } else {
            $plant = 'tbn1';
        }

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    *
                            FROM
                                    MSO_EQPT_PERFORMANCE_SG
                            WHERE
                                    PLANT = '$plant'
                            AND CATEGORY = 'YIELD'
                            AND TAHUN = $tahun");

//        foreach ($query->result_array() as $rowID) {
//            $runHours [$rowID['TAGID']][] = $rowID['RUNHOURS'];
//            $idJson [$rowID['TAGID']] = array('tagid' => $rowID['TAGID'],
//                'name' => $rowID['TEXT'],
//                'pabrik' => $rowID['PABRIK']
//            );
//
//            $seqTgl = date('d', strtotime($rowID['OPDATE']));
//            if ($seqTgl != 0 or ! empty($seqTgl)) {
//                $prod[$rowID['TAGID']][$seqTgl] = array(
//                    'rate' => number_format($rowID['RATE'], 0, ",", "."),
//                    'prod' => number_format($rowID['PROD'], 0, ",", "."));
//            }
//            $toprod[$rowID['TAGID']][] = number_format($rowID['PROD'], 0, ",", ".");
//        }
//
//        foreach ($idJson as $alpha) {
//            $runHours_x[$alpha['tagid']] = array(
//                "plant" => $alpha['pabrik'],
//                "name" => $alpha['name'],
//                "tagid" => $alpha['tagid'],
//                "runhours" => array_sum($runHours [$alpha['tagid']]),
//                "tproduksi" => array_sum($toprod[$alpha['tagid']]),
//                "produksi" => $prod[$alpha['tagid']],
//            );
//        }
        echo json_encode($query->result_array());
    }

}
