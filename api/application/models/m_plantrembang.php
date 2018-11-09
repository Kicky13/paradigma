<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_plantrembang extends CI_Model {

    // <editor-fold defaultstate="collapsed" desc="PLANT OVERVIEW">
    public function get_statefeed() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang.RM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.RM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.CM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.CM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.KL1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.KL1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.FM1_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.FM1_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.FM2_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.FM2_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            'Rembang.RM1_Feed',
                                            'Rembang.RM1_Motor',
                                            'Rembang.CM1_Feed',
                                            'Rembang.CM1_Motor',
                                            'Rembang.KL1_Feed',
                                            'Rembang.KL1_Motor',
                                            'Rembang.FM1_Feed',
                                            'Rembang.FM1_Motor',
                                            'Rembang.FM2_Feed',
                                            'Rembang.FM2_Motor',
                                            'Rembang.KL1_Prod'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            'Rembang.RM1_Feed',
                                            'Rembang.RM1_Motor',
                                            'Rembang.CM1_Feed',
                                            'Rembang.CM1_Motor',
                                            'Rembang.KL1_Feed',
                                            'Rembang.KL1_Motor',
                                            'Rembang.FM1_Feed',
                                            'Rembang.FM1_Motor',
                                            'Rembang.FM2_Feed',
                                            'Rembang.FM2_Motor',
                                            'Rembang.KL1_Prod'
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

    public function get_emission() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang.RM_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.KL_Emisi%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            'Rembang.RM_Emisi',
                                            'Rembang.KL_Emisi'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            'Rembang.RM_Emisi',
                                            'Rembang.KL_Emisi'
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

    public function get_silo() {
        $mySiloURL = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang.Silo_1_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.Silo_2_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.Silo_3_Ton%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.Silo_1_Percent%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.Silo_2_Percent%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang.Silo_3_Percent%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            'Rembang.Silo_1_Ton',
                                            'Rembang.Silo_2_Ton',
                                            'Rembang.Silo_3_Ton',
                                            'Rembang.Silo_1_Percent',
                                            'Rembang.Silo_2_Percent',
                                            'Rembang.Silo_3_Percent'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            'Rembang.Silo_1_Ton',
                                            'Rembang.Silo_2_Ton',
                                            'Rembang.Silo_3_Ton',
                                            'Rembang.Silo_1_Percent',
                                            'Rembang.Silo_2_Percent',
                                            'Rembang.Silo_3_Percent'
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

    public function get_packer_machine() {
        $packer = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang_Packer.PM01_Bag_Rel%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM01_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Bag_Rel%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM02_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Bag_Rel%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM03_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Bag_Rel%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.PM04_Speed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
//        print file_get_contents($packer);
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            'Rembang_Packer.PM01_Bag_Rel',
                                            'Rembang_Packer.PM01_Op',
                                            'Rembang_Packer.PM01_Ophours',
                                            'Rembang_Packer.PM01_Opmin',
                                            'Rembang_Packer.PM01_Rdy',
                                            'Rembang_Packer.PM01_Rdyhours',
                                            'Rembang_Packer.PM01_Rdymin',
                                            'Rembang_Packer.PM01_Speed',
                                            'Rembang_Packer.PM02_Bag_Rel',
                                            'Rembang_Packer.PM02_Op',
                                            'Rembang_Packer.PM02_Ophours',
                                            'Rembang_Packer.PM02_Opmin',
                                            'Rembang_Packer.PM02_Rdy',
                                            'Rembang_Packer.PM02_Rdyhours',
                                            'Rembang_Packer.PM02_Rdymin',
                                            'Rembang_Packer.PM02_Speed',
                                            'Rembang_Packer.PM03_Bag_Rel',
                                            'Rembang_Packer.PM03_Op',
                                            'Rembang_Packer.PM03_Ophours',
                                            'Rembang_Packer.PM03_Opmin',
                                            'Rembang_Packer.PM03_Rdy',
                                            'Rembang_Packer.PM03_Rdyhours',
                                            'Rembang_Packer.PM03_Rdymin',
                                            'Rembang_Packer.PM03_Speed',
                                            'Rembang_Packer.PM04_Bag_Rel',
                                            'Rembang_Packer.PM04_Op',
                                            'Rembang_Packer.PM04_Ophours',
                                            'Rembang_Packer.PM04_Opmin',
                                            'Rembang_Packer.PM04_Rdy',
                                            'Rembang_Packer.PM04_Rdyhours',
                                            'Rembang_Packer.PM04_Rdymin',
                                            'Rembang_Packer.PM04_Speed'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            'Rembang_Packer.PM01_Bag_Rel',
                                            'Rembang_Packer.PM01_Op',
                                            'Rembang_Packer.PM01_Ophours',
                                            'Rembang_Packer.PM01_Opmin',
                                            'Rembang_Packer.PM01_Rdy',
                                            'Rembang_Packer.PM01_Rdyhours',
                                            'Rembang_Packer.PM01_Rdymin',
                                            'Rembang_Packer.PM01_Speed',
                                            'Rembang_Packer.PM02_Bag_Rel',
                                            'Rembang_Packer.PM02_Op',
                                            'Rembang_Packer.PM02_Ophours',
                                            'Rembang_Packer.PM02_Opmin',
                                            'Rembang_Packer.PM02_Rdy',
                                            'Rembang_Packer.PM02_Rdyhours',
                                            'Rembang_Packer.PM02_Rdymin',
                                            'Rembang_Packer.PM02_Speed',
                                            'Rembang_Packer.PM03_Bag_Rel',
                                            'Rembang_Packer.PM03_Op',
                                            'Rembang_Packer.PM03_Ophours',
                                            'Rembang_Packer.PM03_Opmin',
                                            'Rembang_Packer.PM03_Rdy',
                                            'Rembang_Packer.PM03_Rdyhours',
                                            'Rembang_Packer.PM03_Rdymin',
                                            'Rembang_Packer.PM03_Speed',
                                            'Rembang_Packer.PM04_Bag_Rel',
                                            'Rembang_Packer.PM04_Op',
                                            'Rembang_Packer.PM04_Ophours',
                                            'Rembang_Packer.PM04_Opmin',
                                            'Rembang_Packer.PM04_Rdy',
                                            'Rembang_Packer.PM04_Rdyhours',
                                            'Rembang_Packer.PM04_Rdymin',
                                            'Rembang_Packer.PM04_Speed'
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

    public function get_palletizer() {
        $packer = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang_Palletizer.PZ01_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ01_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ01_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ01_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ01_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ01_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ02_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ03_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Ophours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Palletizer.PZ04_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
//        print file_get_contents($packer);
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            'Rembang_Palletizer.PZ01_Op',
                                            'Rembang_Palletizer.PZ01_Ophours',
                                            'Rembang_Palletizer.PZ01_Opmin',
                                            'Rembang_Palletizer.PZ01_Rdy',
                                            'Rembang_Palletizer.PZ01_Rdyhours',
                                            'Rembang_Palletizer.PZ01_Rdymin',
                                            'Rembang_Palletizer.PZ02_Op',
                                            'Rembang_Palletizer.PZ02_Ophours',
                                            'Rembang_Palletizer.PZ02_Opmin',
                                            'Rembang_Palletizer.PZ02_Rdy',
                                            'Rembang_Palletizer.PZ02_Rdyhours',
                                            'Rembang_Palletizer.PZ02_Rdymin',
                                            'Rembang_Palletizer.PZ03_Op',
                                            'Rembang_Palletizer.PZ03_Ophours',
                                            'Rembang_Palletizer.PZ03_Opmin',
                                            'Rembang_Palletizer.PZ03_Rdy',
                                            'Rembang_Palletizer.PZ03_Rdyhours',
                                            'Rembang_Palletizer.PZ03_Rdymin',
                                            'Rembang_Palletizer.PZ04_Op',
                                            'Rembang_Palletizer.PZ04_Ophours',
                                            'Rembang_Palletizer.PZ04_Opmin',
                                            'Rembang_Palletizer.PZ04_Rdy',
                                            'Rembang_Palletizer.PZ04_Rdyhours',
                                            'Rembang_Palletizer.PZ04_Rdymin'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            'Rembang_Palletizer.PZ01_Op',
                                            'Rembang_Palletizer.PZ01_Ophours',
                                            'Rembang_Palletizer.PZ01_Opmin',
                                            'Rembang_Palletizer.PZ01_Rdy',
                                            'Rembang_Palletizer.PZ01_Rdyhours',
                                            'Rembang_Palletizer.PZ01_Rdymin',
                                            'Rembang_Palletizer.PZ02_Op',
                                            'Rembang_Palletizer.PZ02_Ophours',
                                            'Rembang_Palletizer.PZ02_Opmin',
                                            'Rembang_Palletizer.PZ02_Rdy',
                                            'Rembang_Palletizer.PZ02_Rdyhours',
                                            'Rembang_Palletizer.PZ02_Rdymin',
                                            'Rembang_Palletizer.PZ03_Op',
                                            'Rembang_Palletizer.PZ03_Ophours',
                                            'Rembang_Palletizer.PZ03_Opmin',
                                            'Rembang_Palletizer.PZ03_Rdy',
                                            'Rembang_Palletizer.PZ03_Rdyhours',
                                            'Rembang_Palletizer.PZ03_Rdymin',
                                            'Rembang_Palletizer.PZ04_Op',
                                            'Rembang_Palletizer.PZ04_Ophours',
                                            'Rembang_Palletizer.PZ04_Opmin',
                                            'Rembang_Palletizer.PZ04_Rdy',
                                            'Rembang_Palletizer.PZ04_Rdyhours',
                                            'Rembang_Palletizer.PZ04_Rdymin'
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

    public function get_mobile_loader() {
        $packer = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22Rembang_Packer.CS01_BK01_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK01_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK01_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK01_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK01_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK02_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK02_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK02_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK02_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_BK02_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS01_Level%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK01_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK01_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK01_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK01_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK01_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK02_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK02_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK02_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK02_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_BK02_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS02_Level%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK01_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK01_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK01_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK01_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK01_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK02_Op%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK02_Opmin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK02_Rdy%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK02_Rdyhours%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_BK02_Rdymin%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Rembang_Packer.CS03_Level%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
//        print file_get_contents($packer);
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            'Rembang_Packer.CS01_BK01_Op',
                                            'Rembang_Packer.CS01_BK01_Opmin',
                                            'Rembang_Packer.CS01_BK01_Rdy',
                                            'Rembang_Packer.CS01_BK01_Rdyhours',
                                            'Rembang_Packer.CS01_BK01_Rdymin',
                                            'Rembang_Packer.CS01_BK02_Op',
                                            'Rembang_Packer.CS01_BK02_Opmin',
                                            'Rembang_Packer.CS01_BK02_Rdy',
                                            'Rembang_Packer.CS01_BK02_Rdyhours',
                                            'Rembang_Packer.CS01_BK02_Rdymin',
                                            'Rembang_Packer.CS01_Level',
                                            'Rembang_Packer.CS02_BK01_Op',
                                            'Rembang_Packer.CS02_BK01_Opmin',
                                            'Rembang_Packer.CS02_BK01_Rdy',
                                            'Rembang_Packer.CS02_BK01_Rdyhours',
                                            'Rembang_Packer.CS02_BK01_Rdymin',
                                            'Rembang_Packer.CS02_BK02_Op',
                                            'Rembang_Packer.CS02_BK02_Opmin',
                                            'Rembang_Packer.CS02_BK02_Rdy',
                                            'Rembang_Packer.CS02_BK02_Rdyhours',
                                            'Rembang_Packer.CS02_BK02_Rdymin',
                                            'Rembang_Packer.CS02_Level',
                                            'Rembang_Packer.CS03_BK01_Op',
                                            'Rembang_Packer.CS03_BK01_Opmin',
                                            'Rembang_Packer.CS03_BK01_Rdy',
                                            'Rembang_Packer.CS03_BK01_Rdyhours',
                                            'Rembang_Packer.CS03_BK01_Rdymin',
                                            'Rembang_Packer.CS03_BK02_Op',
                                            'Rembang_Packer.CS03_BK02_Opmin',
                                            'Rembang_Packer.CS03_BK02_Rdy',
                                            'Rembang_Packer.CS03_BK02_Rdyhours',
                                            'Rembang_Packer.CS03_BK02_Rdymin',
                                            'Rembang_Packer.CS03_Level'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            'Rembang_Packer.CS01_BK01_Op',
                                            'Rembang_Packer.CS01_BK01_Opmin',
                                            'Rembang_Packer.CS01_BK01_Rdy',
                                            'Rembang_Packer.CS01_BK01_Rdyhours',
                                            'Rembang_Packer.CS01_BK01_Rdymin',
                                            'Rembang_Packer.CS01_BK02_Op',
                                            'Rembang_Packer.CS01_BK02_Opmin',
                                            'Rembang_Packer.CS01_BK02_Rdy',
                                            'Rembang_Packer.CS01_BK02_Rdyhours',
                                            'Rembang_Packer.CS01_BK02_Rdymin',
                                            'Rembang_Packer.CS01_Level',
                                            'Rembang_Packer.CS02_BK01_Op',
                                            'Rembang_Packer.CS02_BK01_Opmin',
                                            'Rembang_Packer.CS02_BK01_Rdy',
                                            'Rembang_Packer.CS02_BK01_Rdyhours',
                                            'Rembang_Packer.CS02_BK01_Rdymin',
                                            'Rembang_Packer.CS02_BK02_Op',
                                            'Rembang_Packer.CS02_BK02_Opmin',
                                            'Rembang_Packer.CS02_BK02_Rdy',
                                            'Rembang_Packer.CS02_BK02_Rdyhours',
                                            'Rembang_Packer.CS02_BK02_Rdymin',
                                            'Rembang_Packer.CS02_Level',
                                            'Rembang_Packer.CS03_BK01_Op',
                                            'Rembang_Packer.CS03_BK01_Opmin',
                                            'Rembang_Packer.CS03_BK01_Rdy',
                                            'Rembang_Packer.CS03_BK01_Rdyhours',
                                            'Rembang_Packer.CS03_BK01_Rdymin',
                                            'Rembang_Packer.CS03_BK02_Op',
                                            'Rembang_Packer.CS03_BK02_Opmin',
                                            'Rembang_Packer.CS03_BK02_Rdy',
                                            'Rembang_Packer.CS03_BK02_Rdyhours',
                                            'Rembang_Packer.CS03_BK02_Rdymin',
                                            'Rembang_Packer.CS03_Level'
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
    }

//unused

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
                                    PROBLEM_SLTN,
                                    PRIORITY
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
    // <editor-fold defaultstate="collapsed" desc="DASHBOARD PIS">
    public function raw_mill() {
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            '331BC01A01W01',
                                            '331WF01A01W01',
                                            '331WF02A01W01',
                                            '331WF03A01W01',
                                            '331BC02_S01',
                                            'PLC02_HLC01_SEL01',
                                            'PLC02_HLC01_SEL02',
                                            'PLC02_HLC01_SEL03',
                                            'PLC02_HLC01_SEL04',
                                            '331BC01A01F01',
                                            '331WF01A01F01',
                                            '331WF02A01F01',
                                            '331WF03A01F01',
                                            '331BC01I11F11',
                                            '331BC01I11F12',
                                            '331BC01I11F13',
                                            '331BC01I11F14',
                                            '331BC01I11A01CN',
                                            '331BC01I11B01CN',
                                            '331BC01I11C01CN',
                                            '331BC01I11D01CN',
                                            '341_TOTAL_POWER_CONS',
                                            '341_SPECPOWCON_MILL',
                                            '341_SPECPOWCON_TOTAL',
                                            '341BE01M01',
                                            '341BE01M01I01',
                                            'Rembang.RM1_Feed',
                                            '331GA01Y01Z41',
                                            '341BI01N01W01',
                                            '341RF01M01',
                                            '341RF01M01I01',
                                            '341HS01A01P01',
                                            '341VC01M01',
                                            '341BW01A01F01',
                                            '341RM01MD01M01',
                                            '341RM01MD01N91',
                                            '341RM01N01T01',
                                            '341RM01N02P01',
                                            '341RM01N06V01',
                                            '341RM01N05P01',
                                            '341RM01N04P01',
                                            '341RM01N03T01',
                                            '341SR01MD01U01',
                                            '341SR01MD01U01I01',
                                            '341SR01MD01U01S01',
                                            '341RF04M01I01',
                                            '341RF04M01',
                                            '341RF05M01I01',
                                            '341RF05M01',
                                            '341RF06M01I01',
                                            '341RF06M01',
                                            '341RF07M01I01',
                                            '341RF07M01',
                                            'RM_NA_TAGS1',
                                            '341DA01Y01Z01',
                                            '341FN02M01',
                                            '341FN02M01N91',
                                            '341DA02Y01Z41',
                                            'RM_NA_TAGS2',
                                            '341WS02A01F02',
                                            '341BF03N01T01',
                                            '341DA08Y01Z01',
                                            '341DA08D91Z41',
                                            '341FN03U01I01',
                                            '341FN03U01',
                                            'RM_NA_TAGS3',
                                            '341DA03Y01Z01',
                                            '341DA03D91Z42',
                                            '351SG05Y01Z41',
                                            '351SG04Y01Z41',
                                            '351BE02M01',
                                            '351BE02M01I01',
                                            '411BS01N01L01',
                                            '341DA04Y01Z41',
                                            '341DA05Y01Z01',
                                            '341DA04Y01Z42',
                                            '341DA06Y01Z01',
                                            '341DA06D91Z42',
                                            '351DV01Y01Z41',
                                            'RM_PRODUCT',
                                            'RM_PRODUCT_DAY',
                                            'RM_PRODUCT_YESTERDAY',
                                            'QCX_RM_Moisture',
                                            'QCX_RM_Residue_90',
                                            'QCX_RM_LSF',
                                            'QCX_RM_SIM',
                                            'QCX_RM_ALM',
                                            'QCX_RM_Residue_212'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            '331BC01A01W01',
                                            '331WF01A01W01',
                                            '331WF02A01W01',
                                            '331WF03A01W01',
                                            '331BC02_S01',
                                            'PLC02_HLC01_SEL01',
                                            'PLC02_HLC01_SEL02',
                                            'PLC02_HLC01_SEL03',
                                            'PLC02_HLC01_SEL04',
                                            '331BC01A01F01',
                                            '331WF01A01F01',
                                            '331WF02A01F01',
                                            '331WF03A01F01',
                                            '331BC01I11F11',
                                            '331BC01I11F12',
                                            '331BC01I11F13',
                                            '331BC01I11F14',
                                            '331BC01I11A01CN',
                                            '331BC01I11B01CN',
                                            '331BC01I11C01CN',
                                            '331BC01I11D01CN',
                                            '341_TOTAL_POWER_CONS',
                                            '341_SPECPOWCON_MILL',
                                            '341_SPECPOWCON_TOTAL',
                                            '341BE01M01',
                                            '341BE01M01I01',
                                            'Rembang.RM1_Feed',
                                            '331GA01Y01Z41',
                                            '341BI01N01W01',
                                            '341RF01M01',
                                            '341RF01M01I01',
                                            '341HS01A01P01',
                                            '341VC01M01',
                                            '341BW01A01F01',
                                            '341RM01MD01M01',
                                            '341RM01MD01N91',
                                            '341RM01N01T01',
                                            '341RM01N02P01',
                                            '341RM01N06V01',
                                            '341RM01N05P01',
                                            '341RM01N04P01',
                                            '341RM01N03T01',
                                            '341SR01MD01U01',
                                            '341SR01MD01U01I01',
                                            '341SR01MD01U01S01',
                                            '341RF04M01I01',
                                            '341RF04M01',
                                            '341RF05M01I01',
                                            '341RF05M01',
                                            '341RF06M01I01',
                                            '341RF06M01',
                                            '341RF07M01I01',
                                            '341RF07M01',
                                            'RM_NA_TAGS1',
                                            '341DA01Y01Z01',
                                            '341FN02M01',
                                            '341FN02M01N91',
                                            '341DA02Y01Z41',
                                            'RM_NA_TAGS2',
                                            '341WS02A01F02',
                                            '341BF03N01T01',
                                            '341DA08Y01Z01',
                                            '341DA08D91Z41',
                                            '341FN03U01I01',
                                            '341FN03U01',
                                            'RM_NA_TAGS3',
                                            '341DA03Y01Z01',
                                            '341DA03D91Z42',
                                            '351SG05Y01Z41',
                                            '351SG04Y01Z41',
                                            '351BE02M01',
                                            '351BE02M01I01',
                                            '411BS01N01L01',
                                            '341DA04Y01Z41',
                                            '341DA05Y01Z01',
                                            '341DA04Y01Z42',
                                            '341DA06Y01Z01',
                                            '341DA06D91Z42',
                                            '351DV01Y01Z41',
                                            'RM_PRODUCT',
                                            'RM_PRODUCT_DAY',
                                            'RM_PRODUCT_YESTERDAY',
                                            'QCX_RM_Moisture',
                                            'QCX_RM_Residue_90',
                                            'QCX_RM_LSF',
                                            'QCX_RM_SIM',
                                            'QCX_RM_ALM',
                                            'QCX_RM_Residue_212'
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

    public function cooler() {
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            '441KH01N01T01',
                                            '441KH01N02P01',
                                            'PLC04_HLC01_SEL01',
                                            '441CC01MD01A01S01',
                                            'COOLING_AIR',
                                            '441CC01MD01A01P02',
                                            '441CC01MD01A01P01',
                                            '441CC01MD01A01P05',
                                            '441CC01MD01A01P04',
                                            '441CC01MD01A01P03',
                                            '441CC01MD01A01P06',
                                            '441FN07U01',
                                            '441FN08U01',
                                            '441FN09U01',
                                            '441FN10U01',
                                            '441FN11U01',
                                            '441FN12U01',
                                            '441FN13U01',
                                            '441FN14U01',
                                            '441FN15U01',
                                            '441FN16U01',
                                            '441FN17U01',
                                            '441FN07N01F01',
                                            '441FN08N01F01',
                                            '441FN09N01F01',
                                            '441FN10N01F01',
                                            '441FN11N01F01',
                                            '441FN12N01F01',
                                            '441FN13N01F01',
                                            '441FN14N01F01',
                                            '441FN15N01F01',
                                            '441FN16N01F01',
                                            '441FN17N01F01',
                                            '441FN07N02P01',
                                            '441FN08N02P01',
                                            '441FN09N02P01',
                                            '441FN10N02P01',
                                            '441FN11N02P01',
                                            '441FN12N02P01',
                                            '441FN13N02P01',
                                            '441FN14N02P01',
                                            '441FN15N02P01',
                                            '441FN16N02P01',
                                            '441FN17N02P01',
                                            '441SG01Y01Z41',
                                            '441SG02Y01Z41',
                                            '441CR01MD01A01',
                                            '441CR01MD01A01J01',
                                            '451BI01N01L01',
                                            '521BI01N01L01',
                                            'CCS.Cooler.Clinker_Prod',
                                            'CLINKER_PRODUCT_DAY',
                                            'CLINKER_PRODUCT_YESTRDAY',
                                            'QCX_Clinker_LSF',
                                            'QCX_Clinker_FCao',
                                            'QCX_Clinker_C3S',
                                            'QCX_Clinker_Temp',
                                            '451DB03M01',
                                            '451DB03M01I01',
                                            '451DB02M01',
                                            '451DB02M01I01',
                                            '451SG02Y01Z41',
                                            '451SG01Y01Z41',
                                            '451BW02A01F01',
                                            '451BW01A01F01',
                                            '451DB01M01',
                                            '451DB01M01I01',
                                            'Cooler.NA_TAGS4',
                                            '441FN19U01I01',
                                            '441FN19U01',
                                            '441DA08Y01Z01',
                                            'Cooler.NA_TAGS1',
                                            'Cooler.NA_TAGS2',
                                            '441CV01M01',
                                            '441CV02M01',
                                            '441CV03M01',
                                            '441SG06Y01Z41',
                                            '441CV05M01',
                                            '441SG03Y01Z41',
                                            '441WS01N01T01',
                                            '441CV04M01',
                                            'Cooler.NA_TAGS3',
                                            '441DA07Y01Z01',
                                            '441CN01N03T01',
                                            '441FN18U01',
                                            '441FN18U01I01',
                                            '441DA06Y01Z41'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            '441KH01N01T01',
                                            '441KH01N02P01',
                                            'PLC04_HLC01_SEL01',
                                            '441CC01MD01A01S01',
                                            'COOLING_AIR',
                                            '441CC01MD01A01P02',
                                            '441CC01MD01A01P01',
                                            '441CC01MD01A01P05',
                                            '441CC01MD01A01P04',
                                            '441CC01MD01A01P03',
                                            '441CC01MD01A01P06',
                                            '441FN07U01',
                                            '441FN08U01',
                                            '441FN09U01',
                                            '441FN10U01',
                                            '441FN11U01',
                                            '441FN12U01',
                                            '441FN13U01',
                                            '441FN14U01',
                                            '441FN15U01',
                                            '441FN16U01',
                                            '441FN17U01',
                                            '441FN07N01F01',
                                            '441FN08N01F01',
                                            '441FN09N01F01',
                                            '441FN10N01F01',
                                            '441FN11N01F01',
                                            '441FN12N01F01',
                                            '441FN13N01F01',
                                            '441FN14N01F01',
                                            '441FN15N01F01',
                                            '441FN16N01F01',
                                            '441FN17N01F01',
                                            '441FN07N02P01',
                                            '441FN08N02P01',
                                            '441FN09N02P01',
                                            '441FN10N02P01',
                                            '441FN11N02P01',
                                            '441FN12N02P01',
                                            '441FN13N02P01',
                                            '441FN14N02P01',
                                            '441FN15N02P01',
                                            '441FN16N02P01',
                                            '441FN17N02P01',
                                            '441SG01Y01Z41',
                                            '441SG02Y01Z41',
                                            '441CR01MD01A01',
                                            '441CR01MD01A01J01',
                                            '451BI01N01L01',
                                            '521BI01N01L01',
                                            'CCS.Cooler.Clinker_Prod',
                                            'CLINKER_PRODUCT_DAY',
                                            'CLINKER_PRODUCT_YESTRDAY',
                                            'QCX_Clinker_LSF',
                                            'QCX_Clinker_FCao',
                                            'QCX_Clinker_C3S',
                                            'QCX_Clinker_Temp',
                                            '451DB03M01',
                                            '451DB03M01I01',
                                            '451DB02M01',
                                            '451DB02M01I01',
                                            '451SG02Y01Z41',
                                            '451SG01Y01Z41',
                                            '451BW02A01F01',
                                            '451BW01A01F01',
                                            '451DB01M01',
                                            '451DB01M01I01',
                                            'Cooler.NA_TAGS4',
                                            '441FN19U01I01',
                                            '441FN19U01',
                                            '441DA08Y01Z01',
                                            'Cooler.NA_TAGS1',
                                            'Cooler.NA_TAGS2',
                                            '441CV01M01',
                                            '441CV02M01',
                                            '441CV03M01',
                                            '441SG06Y01Z41',
                                            '441CV05M01',
                                            '441SG03Y01Z41',
                                            '441WS01N01T01',
                                            '441CV04M01',
                                            'Cooler.NA_TAGS3',
                                            '441DA07Y01Z01',
                                            '441CN01N03T01',
                                            '441FN18U01',
                                            '441FN18U01I01',
                                            '441DA06Y01Z41'
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

    public function kiln() {
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            '411BS01N01L01',
                                            '421FG01A01W01',
                                            '421GA01Y01Z41',
                                            '421BE02M01',
                                            '421BE02M01I01',
                                            '421BE01M01',
                                            '421BE01M01I01',
                                            '421DV02Y01Z41',
                                            '441AN02A01A01',
                                            '441AN02A01A02',
                                            '441AN02A01A03',
                                            'QCX_KF_LSF',
                                            'QCX_KF_SIM',
                                            'QCX_KF_ALM',
                                            'QCX_KF_Moisture',
                                            'QCX_KF_Residue_90',
                                            'PLC03_HLC01_SEL01',
                                            'PLC03_HLC01_SEL02',
                                            'PLC03_HLC01_SEL03',
                                            'PLC03_HLC01_SEL04',
                                            'KILN_FEED_FM',
                                            '421SP01Y01Z01',
                                            'Kiln.NA_TAGS1',
                                            '421SP02Y01Z01',
                                            'Kiln.NA_TAGS2',
                                            '421SP03Y01Z01',
                                            'Kiln.NA_TAGS3',
                                            '421RF07M01I01',
                                            '421RF07M01',
                                            '421RF06M01I01',
                                            '421RF06M01',
                                            '421RF08M01I01',
                                            '421RF08M01',
                                            '421RF09M01I01',
                                            '421RF09M01',
                                            '441DA01Y01Z01',
                                            'Kiln.NA_TAGS4',
                                            '441FN01U01I01',
                                            '441FN01U01',
                                            '441DA02Y01Z01',
                                            'Kiln.NA_TAGS5',
                                            '441FN02U01I01',
                                            '441FN02U01',
                                            '441CN11N03T01',
                                            '441CN11N04P01',
                                            '441CN12N13T01',
                                            '441CN12N14P01',
                                            '441CN22N13T01',
                                            '441CN22N14P01',
                                            '441CN21N03T01',
                                            '441CN21N04P01',
                                            '441CN13N03T01',
                                            '441CN13N04P01',
                                            '441CN23N03T01',
                                            '441CN23N04P01',
                                            '441CN14N03T01',
                                            '441CN14N04P01',
                                            '441CN24N03T01',
                                            '441CN24N04P01',
                                            '441CN15N03T01',
                                            '441CN15N04P01',
                                            '441CN25N03T01',
                                            '441CN25N04P01',
                                            '441CN16N03T01',
                                            '441CN16N04P01',
                                            '441CN26N03T01',
                                            '441CN26N04P01',
                                            '441DG11A01F02',
                                            'Kiln.IDLE_TAG1',
                                            '441DG21A01F02',
                                            'Kiln.IDLE_TAG2',
                                            '441DG12A01F02',
                                            'Kiln.IDLE_TAG3',
                                            '441DG22A01F02',
                                            'Kiln.IDLE_TAG4',
                                            '441CI01N03T01',
                                            '441KL01MD02N01P01',
                                            '441AN01A01A01',
                                            '441AN01A01A02',
                                            '441AN01A01A03',
                                            '441AN01A01A04',
                                            '441KL01A01S01',
                                            '441KL01MD02U01X01',
                                            '441KD01M01',
                                            '441KL01MD02U01',
                                            '441KL01MD02U01I01',
                                            '441KL01MD02U01J01',
                                            '441KL01MD02U01S01',
                                            'SPECIFIC_POWER_COMS',
                                            'PROD_CLINKER_KCAL_KG',
                                            '491DU01N01T01',
                                            '491DU01N02P01',
                                            '441KH01N01T01',
                                            '441KH01N02P01',
                                            '481PW01A01F01',
                                            '481BV11Y01Z41',
                                            '481FN01U01I01',
                                            '481FN01U01',
                                            '481PW01A01',
                                            '481BI01N01W01',
                                            '481PW03A01F01',
                                            '481PW03A01',
                                            '481BI03N01W01',
                                            '481PW02A01F01',
                                            '481PW02A01',
                                            '481BI02N01W01',
                                            '441AN03A01A01',
                                            '441AN03A01A02',
                                            '441AN03A01A03',
                                            'QCX_Clinker_LSF',
                                            'QCX_Clinker_FCao',
                                            'QCX_Clinker_C3S',
                                            'QCX_Clinker_Temp',
                                            'Kiln.TEMP_TAG1',
                                            'Kiln.TEMP_TAG2',
                                            'Kiln.TEMP_TAG3',
                                            'Kiln.TEMP_TAG4',
                                            'Kiln.TEMP_TAG5',
                                            'Kiln.TEMP_TAG6',
                                            'Kiln.TEMP_TAG7',
                                            'Kiln.TEMP_TAG8',
                                            'Kiln.TEMP_TAG9',
                                            'Rembang.KL1_Prod',
                                            'CLINKER_PRODUCT_DAY',
                                            'CLINKER_PRODUCT_YESTRDAY'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            '411BS01N01L01',
                                            '421FG01A01W01',
                                            '421GA01Y01Z41',
                                            '421BE02M01',
                                            '421BE02M01I01',
                                            '421BE01M01',
                                            '421BE01M01I01',
                                            '421DV02Y01Z41',
                                            '441AN02A01A01',
                                            '441AN02A01A02',
                                            '441AN02A01A03',
                                            'QCX_KF_LSF',
                                            'QCX_KF_SIM',
                                            'QCX_KF_ALM',
                                            'QCX_KF_Moisture',
                                            'QCX_KF_Residue_90',
                                            'PLC03_HLC01_SEL01',
                                            'PLC03_HLC01_SEL02',
                                            'PLC03_HLC01_SEL03',
                                            'PLC03_HLC01_SEL04',
                                            'KILN_FEED_FM',
                                            '421SP01Y01Z01',
                                            'Kiln.NA_TAGS1',
                                            '421SP02Y01Z01',
                                            'Kiln.NA_TAGS2',
                                            '421SP03Y01Z01',
                                            'Kiln.NA_TAGS3',
                                            '421RF07M01I01',
                                            '421RF07M01',
                                            '421RF06M01I01',
                                            '421RF06M01',
                                            '421RF08M01I01',
                                            '421RF08M01',
                                            '421RF09M01I01',
                                            '421RF09M01',
                                            '441DA01Y01Z01',
                                            'Kiln.NA_TAGS4',
                                            '441FN01U01I01',
                                            '441FN01U01',
                                            '441DA02Y01Z01',
                                            'Kiln.NA_TAGS5',
                                            '441FN02U01I01',
                                            '441FN02U01',
                                            '441CN11N03T01',
                                            '441CN11N04P01',
                                            '441CN12N13T01',
                                            '441CN12N14P01',
                                            '441CN22N13T01',
                                            '441CN22N14P01',
                                            '441CN21N03T01',
                                            '441CN21N04P01',
                                            '441CN13N03T01',
                                            '441CN13N04P01',
                                            '441CN23N03T01',
                                            '441CN23N04P01',
                                            '441CN14N03T01',
                                            '441CN14N04P01',
                                            '441CN24N03T01',
                                            '441CN24N04P01',
                                            '441CN15N03T01',
                                            '441CN15N04P01',
                                            '441CN25N03T01',
                                            '441CN25N04P01',
                                            '441CN16N03T01',
                                            '441CN16N04P01',
                                            '441CN26N03T01',
                                            '441CN26N04P01',
                                            '441DG11A01F02',
                                            'Kiln.IDLE_TAG1',
                                            '441DG21A01F02',
                                            'Kiln.IDLE_TAG2',
                                            '441DG12A01F02',
                                            'Kiln.IDLE_TAG3',
                                            '441DG22A01F02',
                                            'Kiln.IDLE_TAG4',
                                            '441CI01N03T01',
                                            '441KL01MD02N01P01',
                                            '441AN01A01A01',
                                            '441AN01A01A02',
                                            '441AN01A01A03',
                                            '441AN01A01A04',
                                            '441KL01A01S01',
                                            '441KL01MD02U01X01',
                                            '441KD01M01',
                                            '441KL01MD02U01',
                                            '441KL01MD02U01I01',
                                            '441KL01MD02U01J01',
                                            '441KL01MD02U01S01',
                                            'SPECIFIC_POWER_COMS',
                                            'PROD_CLINKER_KCAL_KG',
                                            '491DU01N01T01',
                                            '491DU01N02P01',
                                            '441KH01N01T01',
                                            '441KH01N02P01',
                                            '481PW01A01F01',
                                            '481BV11Y01Z41',
                                            '481FN01U01I01',
                                            '481FN01U01',
                                            '481PW01A01',
                                            '481BI01N01W01',
                                            '481PW03A01F01',
                                            '481PW03A01',
                                            '481BI03N01W01',
                                            '481PW02A01F01',
                                            '481PW02A01',
                                            '481BI02N01W01',
                                            '441AN03A01A01',
                                            '441AN03A01A02',
                                            '441AN03A01A03',
                                            'QCX_Clinker_LSF',
                                            'QCX_Clinker_FCao',
                                            'QCX_Clinker_C3S',
                                            'QCX_Clinker_Temp',
                                            'Kiln.TEMP_TAG1',
                                            'Kiln.TEMP_TAG2',
                                            'Kiln.TEMP_TAG3',
                                            'Kiln.TEMP_TAG4',
                                            'Kiln.TEMP_TAG5',
                                            'Kiln.TEMP_TAG6',
                                            'Kiln.TEMP_TAG7',
                                            'Kiln.TEMP_TAG8',
                                            'Kiln.TEMP_TAG9',
                                            'Rembang.KL1_Prod',
                                            'CLINKER_PRODUCT_DAY',
                                            'CLINKER_PRODUCT_YESTRDAY'
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

    public function finish_mill1() {
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            '521BI01N01L01',
                                            '541WF01A01W01',
                                            '541WF02A01W01_NA',
                                            '541WF03A01W01',
                                            '541WF04A01W01',
                                            '541WF01I11A01CN',
                                            '541WF01I11B01CN',
                                            '541WF01I11C01CN',
                                            '541WF01I11D01CN',
                                            '541WF01I11E01CN',
                                            '541WF01A01F01',
                                            '541WF02A01F01',
                                            '541WF03A01F01',
                                            '541WF04A01F01',
                                            '531FM01A01F01',
                                            '541_TOTAL_POWER_CONS',
                                            '541_SPECPOWCON_MILL',
                                            '541_SPECPOWCON_TOTAL',
                                            '541BE01M01',
                                            '541BE01M01I01',
                                            '541BW01A01F01',
                                            'PLC07_HLC01_SEL01',
                                            'PLC07_HLC01_SEL02',
                                            'PLC07_HLC01_SEL03',
                                            'PLC07_HLC01_SEL04',
                                            '541GA01Y01Z41',
                                            '541BI05N01W01',
                                            '541RF05MT01',
                                            '541BW02A01F01',
                                            '541GB01MT01',
                                            '541RM01MD01M01',
                                            '541RM01MD01M01J01',
                                            '541RM01A01XIW794',
                                            '541RM01A01XIW796',
                                            'CM1_PROD',
                                            'CM1_PROD_DAY',
                                            'CM1_PROD_YESTERDAY',
                                            '541DA04Y01Z01',
                                            'FM1.2DAMPVAL_1',
                                            '541RM01A01XIW904',
                                            '541RM01PD01P01',
                                            '541RM01N01T01',
                                            '541RM01N02P01',
                                            'FM1.2DAMPVAL_2',
                                            '541DA06Y01Z01',
                                            '491OP05N01P01',
                                            '541AH01FI01F01',
                                            '541RM01A01XIW916',
                                            '541WI01MT01',
                                            '441EP01N03T01',
                                            '441FN20U01I01',
                                            '441FN20U01',
                                            '541DA05Y01Z01',
                                            'FM1.2DAMPVAL_3',
                                            '541SR01U01I01',
                                            '541SR01U01S01',
                                            '541SR01U01',
                                            '541RM01N03T01',
                                            '541RM01N04P01',
                                            '541RF07M01I01',
                                            '541RF07M01',
                                            '541RF08M01I01',
                                            '541RF08M01',
                                            '541BF06N01P01',
                                            '541DA01Y01Z01',
                                            '541DA01Y01Z41',
                                            '541FN05U01I01',
                                            '541FN05U01',
                                            '541DA02Y01Z01',
                                            'FM1.2DAMPVAL_4',
                                            '541AM01A01A01_NA',
                                            '561BE01M01',
                                            '561BE01M01I01',
                                            'FM1.2DAMPVAL_5',
                                            '541DA03Y01Z01',
                                            '611CS01N01L01',
                                            '612CS01N01L01',
                                            '613CS01N01L01',
                                            'QCX_CM1_Blaine',
                                            'QCX_CM1_SO3',
                                            'QCX_CM1_Res'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            '521BI01N01L01',
                                            '541WF01A01W01',
                                            '541WF02A01W01_NA',
                                            '541WF03A01W01',
                                            '541WF04A01W01',
                                            '541WF01I11A01CN',
                                            '541WF01I11B01CN',
                                            '541WF01I11C01CN',
                                            '541WF01I11D01CN',
                                            '541WF01I11E01CN',
                                            '541WF01A01F01',
                                            '541WF02A01F01',
                                            '541WF03A01F01',
                                            '541WF04A01F01',
                                            '531FM01A01F01',
                                            '541_TOTAL_POWER_CONS',
                                            '541_SPECPOWCON_MILL',
                                            '541_SPECPOWCON_TOTAL',
                                            '541BE01M01',
                                            '541BE01M01I01',
                                            '541BW01A01F01',
                                            'PLC07_HLC01_SEL01',
                                            'PLC07_HLC01_SEL02',
                                            'PLC07_HLC01_SEL03',
                                            'PLC07_HLC01_SEL04',
                                            '541GA01Y01Z41',
                                            '541BI05N01W01',
                                            '541RF05MT01',
                                            '541BW02A01F01',
                                            '541GB01MT01',
                                            '541RM01MD01M01',
                                            '541RM01MD01M01J01',
                                            '541RM01A01XIW794',
                                            '541RM01A01XIW796',
                                            'CM1_PROD',
                                            'CM1_PROD_DAY',
                                            'CM1_PROD_YESTERDAY',
                                            '541DA04Y01Z01',
                                            'FM1.2DAMPVAL_1',
                                            '541RM01A01XIW904',
                                            '541RM01PD01P01',
                                            '541RM01N01T01',
                                            '541RM01N02P01',
                                            'FM1.2DAMPVAL_2',
                                            '541DA06Y01Z01',
                                            '491OP05N01P01',
                                            '541AH01FI01F01',
                                            '541RM01A01XIW916',
                                            '541WI01MT01',
                                            '441EP01N03T01',
                                            '441FN20U01I01',
                                            '441FN20U01',
                                            '541DA05Y01Z01',
                                            'FM1.2DAMPVAL_3',
                                            '541SR01U01I01',
                                            '541SR01U01S01',
                                            '541SR01U01',
                                            '541RM01N03T01',
                                            '541RM01N04P01',
                                            '541RF07M01I01',
                                            '541RF07M01',
                                            '541RF08M01I01',
                                            '541RF08M01',
                                            '541BF06N01P01',
                                            '541DA01Y01Z01',
                                            '541DA01Y01Z41',
                                            '541FN05U01I01',
                                            '541FN05U01',
                                            '541DA02Y01Z01',
                                            'FM1.2DAMPVAL_4',
                                            '541AM01A01A01_NA',
                                            '561BE01M01',
                                            '561BE01M01I01',
                                            'FM1.2DAMPVAL_5',
                                            '541DA03Y01Z01',
                                            '611CS01N01L01',
                                            '612CS01N01L01',
                                            '613CS01N01L01',
                                            'QCX_CM1_Blaine',
                                            'QCX_CM1_SO3',
                                            'QCX_CM1_Res'
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

    public function finish_mill2() {
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            '521BI01N01L01',
                                            '542WF01A01W01',
                                            '542WF02A01W01',
                                            '542WF03A01W01',
                                            '542WF04A01W01',
                                            '542WF01I11A01CN',
                                            '542WF01I11B01CN',
                                            '542WF01I11C01CN',
                                            '542WF01I11D01CN',
                                            '542WF01I11E01CN',
                                            '542WF01A01F01',
                                            '542WF02A01F01',
                                            '542WF03A01F01',
                                            '542WF04A01F01',
                                            '532FM01A01F01',
                                            '542_TOTAL_POWER_CONS',
                                            '542_SPECPOWCON_MILL',
                                            '542_SPECPOWCON_TOTAL',
                                            '542BE01M01',
                                            '542BE01M01I01',
                                            '542BW01A01F01',
                                            'PLC07_HLC01_SEL01',
                                            'PLC07_HLC01_SEL02',
                                            'PLC07_HLC01_SEL03',
                                            'PLC07_HLC01_SEL04',
                                            '542GA01Y01Z41',
                                            '542BI05N01W01',
                                            '542RF05MT01',
                                            '542BW02A01F01',
                                            '542GB01MT01',
                                            '542RM01MD01M01',
                                            '542RM01MD01M01J01',
                                            '542RM01A01XIW794',
                                            '542RM01A01XIW796',
                                            'CM2_PROD',
                                            'CM2_PROD_DAY',
                                            'CM2_PROD_YESTERDAY',
                                            '542DA04Y01Z01',
                                            'FM2.2DAMPVAL_1',
                                            '542RM01A01XIW904',
                                            '542RM01PD01P01',
                                            '542RM01N01T01',
                                            '542RM01N02P01',
                                            'FM2.2DAMPVAL_2',
                                            '542DA06Y01Z01',
                                            '491OP05N01P01',
                                            '542AH01FI01F01',
                                            '542RM01A01XIW916',
                                            '542WI01MT01',
                                            '441EP01N03T01',
                                            '441FN21U01I01',
                                            '441FN21U01',
                                            '542DA05Y01Z01',
                                            'FM2.2DAMPVAL_3',
                                            '542SR01U01I01',
                                            '542SR01U01S01',
                                            '542SR01U01',
                                            '542RM01N03T01',
                                            '542RM01N04P01',
                                            '542RF07M01I01',
                                            '542RF07M01',
                                            '542RF08M01I01',
                                            '542RF08M01',
                                            '542BF06N01P01',
                                            '542DA01Y01Z01',
                                            '542DA01Y01Z41',
                                            '542FN05U01I01',
                                            '542FN05U01',
                                            '542DA02Y01Z01',
                                            'FM2.2DAMPVAL_4',
                                            '542AM01A01A01_NA',
                                            '562BE01M01',
                                            '562BE01M01I01',
                                            'FM2.2DAMPVAL_5',
                                            '542DA03Y01Z01',
                                            '611CS01N01L01',
                                            '612CS01N01L01',
                                            '613CS01N01L01',
                                            'QCX_CM2_Blaine',
                                            'QCX_CM2_SO3',
                                            'QCX_CM2_Res'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            '521BI01N01L01',
                                            '542WF01A01W01',
                                            '542WF02A01W01',
                                            '542WF03A01W01',
                                            '542WF04A01W01',
                                            '542WF01I11A01CN',
                                            '542WF01I11B01CN',
                                            '542WF01I11C01CN',
                                            '542WF01I11D01CN',
                                            '542WF01I11E01CN',
                                            '542WF01A01F01',
                                            '542WF02A01F01',
                                            '542WF03A01F01',
                                            '542WF04A01F01',
                                            '532FM01A01F01',
                                            '542_TOTAL_POWER_CONS',
                                            '542_SPECPOWCON_MILL',
                                            '542_SPECPOWCON_TOTAL',
                                            '542BE01M01',
                                            '542BE01M01I01',
                                            '542BW01A01F01',
                                            'PLC07_HLC01_SEL01',
                                            'PLC07_HLC01_SEL02',
                                            'PLC07_HLC01_SEL03',
                                            'PLC07_HLC01_SEL04',
                                            '542GA01Y01Z41',
                                            '542BI05N01W01',
                                            '542RF05MT01',
                                            '542BW02A01F01',
                                            '542GB01MT01',
                                            '542RM01MD01M01',
                                            '542RM01MD01M01J01',
                                            '542RM01A01XIW794',
                                            '542RM01A01XIW796',
                                            'CM2_PROD',
                                            'CM2_PROD_DAY',
                                            'CM2_PROD_YESTERDAY',
                                            '542DA04Y01Z01',
                                            'FM2.2DAMPVAL_1',
                                            '542RM01A01XIW904',
                                            '542RM01PD01P01',
                                            '542RM01N01T01',
                                            '542RM01N02P01',
                                            'FM2.2DAMPVAL_2',
                                            '542DA06Y01Z01',
                                            '491OP05N01P01',
                                            '542AH01FI01F01',
                                            '542RM01A01XIW916',
                                            '542WI01MT01',
                                            '441EP01N03T01',
                                            '441FN21U01I01',
                                            '441FN21U01',
                                            '542DA05Y01Z01',
                                            'FM2.2DAMPVAL_3',
                                            '542SR01U01I01',
                                            '542SR01U01S01',
                                            '542SR01U01',
                                            '542RM01N03T01',
                                            '542RM01N04P01',
                                            '542RF07M01I01',
                                            '542RF07M01',
                                            '542RF08M01I01',
                                            '542RF08M01',
                                            '542BF06N01P01',
                                            '542DA01Y01Z01',
                                            '542DA01Y01Z41',
                                            '542FN05U01I01',
                                            '542FN05U01',
                                            '542DA02Y01Z01',
                                            'FM2.2DAMPVAL_4',
                                            '542AM01A01A01_NA',
                                            '562BE01M01',
                                            '562BE01M01I01',
                                            'FM2.2DAMPVAL_5',
                                            '542DA03Y01Z01',
                                            '611CS01N01L01',
                                            '612CS01N01L01',
                                            '613CS01N01L01',
                                            'QCX_CM2_Blaine',
                                            'QCX_CM2_SO3',
                                            'QCX_CM2_Res'
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
                                    COMPANY = 5000
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
            $plant = 'rmb1';
        }

        $query = $db->query("SELECT
                                    CATEGORY,
                                    EQUIPMENT,
                                    ROUND (DATA_INPUT, 0) AS DATA_INPUT
                            FROM
                                    MSO_PM_PERFORMANCE
                            WHERE
                                    COMPANY = 5000
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
            $plant = 'rmb1';
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
    // <editor-fold defaultstate="collapsed" desc="ARA : PdM">
    function ara_pdm() {
        
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Quality Management Online">
    function qm_cement() {
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            'Rembang.CM1_CMTYPE',
                                            'Rembang.CM2_CMTYPE',
                                            'QCX_CM1_Blaine',
                                            'QCX_CM1_Res',
                                            'QCX_CM1_SO3',
                                            'QCX_CM2_Blaine',
                                            'QCX_CM2_Res',
                                            'QCX_CM2_SO3',
                                            'QCX_CM1_C3S',
                                            'QCX_CM1_CaO',
                                            'QCX_CM1_FCaO',
                                            'QCX_CM1_H2OOut',
                                            'QCX_CM2_C3S',
                                            'QCX_CM2_CaO',
                                            'QCX_CM2_FCaO',
                                            'QCX_CM2_H2OOut'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            'Rembang.CM1_CMTYPE',
                                            'Rembang.CM2_CMTYPE',
                                            'QCX_CM1_Blaine',
                                            'QCX_CM1_Res',
                                            'QCX_CM1_SO3',
                                            'QCX_CM2_Blaine',
                                            'QCX_CM2_Res',
                                            'QCX_CM2_SO3',
                                            'QCX_CM1_C3S',
                                            'QCX_CM1_CaO',
                                            'QCX_CM1_FCaO',
                                            'QCX_CM1_H2OOut',
                                            'QCX_CM2_C3S',
                                            'QCX_CM2_CaO',
                                            'QCX_CM2_FCaO',
                                            'QCX_CM2_H2OOut'
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

    function qm_clinker() {
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
                                    tags_rmb
                            WHERE
                                    NAME IN (
                                            'QCX_Clinker_C3S',
                                            'QCX_Clinker_FCao',
                                            'QCX_Clinker_LSF',
                                            'QCX_Clinker_Temp'
                                    )
                            ORDER BY FIELD(
                                            NAME,
                                            'QCX_Clinker_C3S',
                                            'QCX_Clinker_FCao',
                                            'QCX_Clinker_LSF',
                                            'QCX_Clinker_Temp'
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
    // <editor-fold defaultstate="collapsed" desc="QMO Table Logger 146">
    function dump_qmtbl_cement() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('opcqmo', true);
        $ymd = $this->input->get('ymd');

        $query = $db->query("SELECT
                                    times.jam,
                                    times.datemonth,
                                    times.hourmin,
                                    cm1_type.val cm1_type,
                                    cm1_bl.val cm1_bl,
                                    cm1_res.val cm1_res,
                                    cm1_so3.val cm1_so3,
                                    cm1_c3s.val cm1_c3s,
                                    cm1_cao.val cm1_cao,
                                    cm1_fcao.val cm1_fcao,
                                    cm1_h2ot.val cm1_h2ot,
                                    cm2_type.val cm2_type,
                                    cm2_bl.val cm2_bl,
                                    cm2_res.val cm2_res,
                                    cm2_so3.val cm2_so3,
                                    cm2_c3s.val cm2_c3s,
                                    cm2_cao.val cm2_cao,
                                    cm2_fcao.val cm2_fcao,
                                    cm2_h2ot.val cm2_h2ot 
                            FROM
                                    (
                                    (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    DATE_FORMAT( date_log, '%m-%d' ) datemonth,
                                    DATE_FORMAT( date_log, '%H:%i' ) hourmin 
                            FROM
                                    qmo_cement_$ymd 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) times
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                            CASE
                                    `value` 
                                    WHEN 0 THEN
                                    'NONOPC' 
                                    WHEN 1 THEN
                                    'OPC' 
                                    END val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'Rembang.CM1_CMTYPE' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm1_type ON cm1_type.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                            CASE
                                    `value` 
                                    WHEN 0 THEN
                                    'NONOPC' 
                                    WHEN 1 THEN
                                    'OPC' 
                                    END val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'Rembang.CM2_CMTYPE' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm2_type ON cm2_type.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM1_Blaine' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm1_bl ON cm1_bl.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM1_Res' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm1_res ON cm1_res.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM1_SO3' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm1_so3 ON cm1_so3.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM1_C3S' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm1_c3s ON cm1_c3s.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM1_CaO' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm1_cao ON cm1_cao.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM1_FCaO' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm1_fcao ON cm1_fcao.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM1_H2OOut' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm1_h2ot ON cm1_h2ot.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM2_Blaine' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm2_bl ON cm2_bl.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM2_Res' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm2_res ON cm2_res.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM2_SO3' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm2_so3 ON cm2_so3.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM2_C3S' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm2_c3s ON cm2_c3s.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM2_CaO' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm2_cao ON cm2_cao.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM2_FCaO' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm2_fcao ON cm2_fcao.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_cement_$ymd 
                            WHERE
                                    machine_id = 'QCX_CM2_H2OOut' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cm2_h2ot ON cm2_h2ot.jam = times.jam 
                                    )");

        foreach ($query->result_array() as $rowID) {
            $jam = $rowID['jam'];
            $datemonth = $rowID['datemonth'];
            $hourmin = $rowID['hourmin'];
            $cm1_type = $rowID['cm1_type'];
            $cm1_bl = $rowID['cm1_bl'];
            $cm1_res = $rowID['cm1_res'];
            $cm1_so3 = $rowID['cm1_so3'];
            $cm1_c3s = $rowID['cm1_c3s'];
            $cm1_cao = $rowID['cm1_cao'];
            $cm1_fcao = $rowID['cm1_fcao'];
            $cm1_h2ot = $rowID['cm1_h2ot'];
            $cm2_type = $rowID['cm2_type'];
            $cm2_bl = $rowID['cm2_bl'];
            $cm2_res = $rowID['cm2_res'];
            $cm2_so3 = $rowID['cm2_so3'];
            $cm2_c3s = $rowID['cm2_c3s'];
            $cm2_cao = $rowID['cm2_cao'];
            $cm2_fcao = $rowID['cm2_fcao'];
            $cm2_h2ot = $rowID['cm2_h2ot'];

            $count = count($jam);

            $text[$hourmin] = array(
                'jam' => $jam,
                'datemonth' => $datemonth,
                'hourmin' => $hourmin,
                'cm1_type' => $cm1_type,
                'cm1_bl' => $cm1_bl,
                'cm1_res' => $cm1_res,
                'cm1_so3' => $cm1_so3,
                'cm1_c3s' => $cm1_c3s,
                'cm1_cao' => $cm1_cao,
                'cm1_fcao' => $cm1_fcao,
                'cm1_h2ot' => $cm1_h2ot,
                'cm2_type' => $cm2_type,
                'cm2_bl' => $cm2_bl,
                'cm2_res' => $cm2_res,
                'cm2_so3' => $cm2_so3,
                'cm2_c3s' => $cm2_c3s,
                'cm2_cao' => $cm2_cao,
                'cm2_fcao' => $cm2_fcao,
                'cm2_h2ot' => $cm2_h2ot
            );
        }

        echo json_encode($text);
    }

    function dump_qmtbl_clinker() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('opcqmo', true);
        $ymd = $this->input->get('ymd');

        $query = $db->query("SELECT
                                    times.jam,
                                    times.datemonth,
                                    times.hourmin,
                                    cl_c3s.val cl_c3s,
                                    cl_fcao.val cl_fcao,
                                    cl_lsf.val cl_lsf,
                                    cl_temp.val cl_temp 
                            FROM
                                    (
                                    (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    DATE_FORMAT( date_log, '%m-%d' ) datemonth,
                                    DATE_FORMAT( date_log, '%H:%i' ) hourmin 
                            FROM
                                    qmo_clinker_$ymd 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) times
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_clinker_$ymd 
                            WHERE
                                    machine_id = 'QCX_Clinker_C3S' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cl_c3s ON cl_c3s.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_clinker_$ymd 
                            WHERE
                                    machine_id = 'QCX_Clinker_FCao' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cl_fcao ON cl_fcao.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_clinker_$ymd 
                            WHERE
                                    machine_id = 'QCX_Clinker_LSF' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cl_lsf ON cl_lsf.jam = times.jam
                                    LEFT JOIN (
                            SELECT
                                    DATE_FORMAT( date_log, '%Y-%m-%d %H:%i' ) jam,
                                    TRUNCATE ( AVG( `value` ), 2 ) val 
                            FROM
                                    qmo_clinker_$ymd 
                            WHERE
                                    machine_id = 'QCX_Clinker_Temp' 
                            GROUP BY
                                    HOUR ( date_log ) 
                                    ) cl_temp ON cl_temp.jam = times.jam 
                                    )");

        foreach ($query->result_array() as $rowID) {
            $jam = $rowID['jam'];
            $datemonth = $rowID['datemonth'];
            $hourmin = $rowID['hourmin'];
            $cl_c3s = $rowID['cl_c3s'];
            $cl_fcao = $rowID['cl_fcao'];
            $cl_lsf = $rowID['cl_lsf'];
            $cl_temp = $rowID['cl_temp'];

            $count = count($jam);

            $text[$hourmin] = array(
                'jam' => $jam,
                'datemonth' => $datemonth,
                'hourmin' => $hourmin,
                'cl_c3s' => $cl_c3s,
                'cl_fcao' => $cl_fcao,
                'cl_lsf' => $cl_lsf,
                'cl_temp' => $cl_temp
            );
        }
        echo json_encode($text);
    }

    // </editor-fold>
}
