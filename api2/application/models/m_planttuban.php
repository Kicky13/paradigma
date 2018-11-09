<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_planttuban extends CI_Model {

    public function get_statefeed() {
        $seta = 'http://10.15.3.146:58725/OPCREST/getdata?message={%22tags%22%3A[{%22name%22%3A%22RM3_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22RM4_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL3_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL4_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM5_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM7_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM6_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM8_Tuban_Feed%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22RM3_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22RM4_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL3_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22KL4_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22CM3_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22CM4_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM5_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM7_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM6_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%20%22Tuban%203%2F4%20Accessories.Coal_Mill3_Product%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%20%22Tuban%203%2F4%20Accessories.Coal_Mill4_Product%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22FM8_Tuban_Motor%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203%2F4%20Accessories.Status_HRC_FM5%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}%2C{%22name%22%3A%22Tuban%203%2F4%20Accessories.Status_HRC_FM6%22%2C%22props%22%3A[{%22name%22%3A%22Value%22}]}]%2C%22status%22%3A%22OK%22%2C%22message%22%3A%22%22%2C%22token%22%3A%227e61b230-481d-4551-b24b-ba9046e3d8f2%22}&_=1469589103720';
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
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('default1', true);

        $query = $db->query("SELECT
                        TBH. SORT,
                        TBH.PNTIDC,
                        TBH.PLANTC,
                        TBH.PISJSON,
                        TBX.PNTTEXT,
                        TBX.VALUEDEFAULT,
                        TBX.ONRLT,
                        SYSDATE AS NOW,
                        HourTOCHAR ((SYSDATE - TBX.ONRLT) * 24) AS SEL
                FROM
                        (
                                SELECT
                                        TB1.*, TB2.*
                                FROM
                                        (
                                                SELECT
                                                        SORT,
                                                        PNTID AS PNTIDC,
                                                        LOCATION AS PLANTC,
                                                        PISJSON
                                                FROM
                                                        TEXT_CONFIG
                                                WHERE
                                                        FLAG = 1
                                                AND PNTID IN (
                                                        '666',
                                                        '750',
                                                        '510',
                                                        '3351',
                                                        '1193',
                                                        '1225',
                                                        '1055',
                                                        '1275',
                                                        '1141',
                                                        '6798',
                                                        '3213',
                                                        '2506',
                                                        '536',
                                                        '4991',
                                                        '697',
                                                        '4691',
                                                        '4807',
                                                        '4090',
                                                        '4478',
                                                        '4586',
                                                        '4731',
                                                        '4917',
                                                        '2498',
                                                        '8520',
                                                        '8691',
                                                        '8009'
                                                )
                                                GROUP BY
                                                        PNTID,
                                                        SORT,
                                                        LOCATION,
                                                        PISJSON
                                        ) tb1
                                LEFT JOIN (
                                        SELECT
                                                PNTID AS PNTIDM,
                                                TO_CHAR (
                                                        MAX (ONRLT),
                                                        'YYYYMMDD HH24:MI:SS'
                                                ) AS TIMESET,
                                                PLANT AS PLANTM
                                        FROM
                                                PLG_EVENT_NEW
                                        GROUP BY
                                                PNTID,
                                                PLANT
                                ) tb2 ON (
                                        tb1.PNTIDC = tb2.PNTIDM
                                        AND tb1.PLANTC = tb2.PLANTM
                                )
                        ) TBH
                LEFT JOIN PLG_EVENT_NEW TBX ON TBH.PNTIDM = TBX.PNTID
                AND TBH.TIMESET = TO_CHAR (
                        TBX.ONRLT,
                        'YYYYMMDD HH24:MI:SS'
                )
                AND TBH.PLANTM = TBX.PLANT
                ORDER BY
                        SORT ASC");

        foreach ($query->result_array() as $rowID) {
            if ($rowID['VALUEDEFAULT'] == "Stop" || $rowID['VALUEDEFAULT'] == "Not Ready") {
                $valueData = "False";
            } else if ($rowID['VALUEDEFAULT'] == null || $rowID['VALUEDEFAULT'] == " ") {
                $valueData = "True";
            } else {
                $valueData = $rowID['VALUEDEFAULT'];
            }

            $text[$rowID['PNTIDC']] [] = array(
                "datatype" => "string",
                "name" => "Value",
                "quality" => "true",
                "val" => $valueData);
            $go[] = array(
                "name" => $rowID['PNTIDC'],
                "props" => $text[$rowID['PNTIDC']]);
        }

        echo '({"message":"","status":"OK","tags":' . json_encode($go) . ',"token":"7e61b230-481d-4551-b24b-ba9046e3d8f2"});';
    }

    public function get_emissiontb12() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('default1', true);

        $query = $db->query("SELECT
                        TBH. SORT,
                        TBH.PNTIDC,
                        TBH.PLANTC,
                        TBH.PISJSON,
                        TBX.PNTTEXT,
                        TBX.VALUEDEFAULT,
                        TBX.ONRLT,
                        SYSDATE AS NOW,
                        HourTOCHAR ((SYSDATE - TBX.ONRLT) * 24) AS SEL
                FROM
                        (
                                SELECT
                                        TB1.*, TB2.*
                                FROM
                                        (
                                                SELECT
                                                        SORT,
                                                        PNTID AS PNTIDC,
                                                        LOCATION AS PLANTC,
                                                        PISJSON
                                                FROM
                                                        TEXT_CONFIG
                                                WHERE
                                                        FLAG = 1
                                                AND (
                                                        PISJSON IS NOT NULL
                                                        AND PISJSON IN (
                                                                'KL1_Tuban_EP',
                                                                'RM1_Tuban_EP',
                                                                'KL2_Tuban_EP',
                                                                'RM2_Tuban_EP'
                                                        )
                                                )
                                                GROUP BY
                                                        PNTID,
                                                        SORT,
                                                        LOCATION,
                                                        PISJSON
                                        ) tb1
                                LEFT JOIN (
                                        SELECT
                                                PNTID AS PNTIDM,
                                                TO_CHAR (
                                                        MAX (ONRLT),
                                                        'YYYYMMDD HH24:MI:SS'
                                                ) AS TIMESET,
                                                PLANT AS PLANTM
                                        FROM
                                                PLG_EVENT_NEW
                                        GROUP BY
                                                PNTID,
                                                PLANT
                                ) tb2 ON (
                                        tb1.PNTIDC = tb2.PNTIDM
                                        AND tb1.PLANTC = tb2.PLANTM
                                )
                        ) TBH
                LEFT JOIN PLG_EVENT_NEW TBX ON TBH.PNTIDM = TBX.PNTID
                AND TBH.TIMESET = TO_CHAR (
                        TBX.ONRLT,
                        'YYYYMMDD HH24:MI:SS'
                )
                AND TBH.PLANTM = TBX.PLANT
                ORDER BY
                        SORT ASC");

        foreach ($query->result_array() as $rowID) {
            if ($rowID['VALUEDEFAULT'] == "Stop" || $rowID['VALUEDEFAULT'] == "Not Ready") {
                $valueData = "False";
            } else if ($rowID['VALUEDEFAULT'] == null || $rowID['VALUEDEFAULT'] == " ") {
                $valueData = "True";
            } else {
                $valueData = $rowID['VALUEDEFAULT'];
            }

            $text[$rowID['PNTIDC']] [] = array(
                "datatype" => "string",
                "name" => "Value",
                "quality" => "true",
                "val" => $valueData);
            $go[] = array(
                "name" => $rowID['PNTIDC'],
                "props" => $text[$rowID['PNTIDC']]);
        }

        echo '({"message":"","status":"OK","tags":' . json_encode($go) . ',"token":"7e61b230-481d-4551-b24b-ba9046e3d8f2"});';
    }

    public function get_silotb12() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('default1', true);

        $query = $db->query("SELECT
	TBH. SORT,
	TBH.PNTIDC,
	TBH.PLANTC,
	TBH.TEXT,
	TBX.PNTTEXT,
	TBX.VALUEDEFAULT,
	TBX.ONRLT,
	SYSDATE AS NOW,
	HourTOCHAR ((SYSDATE - TBX.ONRLT) * 24) AS SEL
FROM
	(
		SELECT
			TB1.*, TB2.*
		FROM
			(
				SELECT
					SORT,
					PNTID AS PNTIDC,
					LOCATION AS PLANTC,
					TEXT
				FROM
					TEXT_CONFIG
				WHERE
					FLAG = 1 AND LOCATION IN (1, 2) AND TEXT LIKE '%Cement Silo%'
				GROUP BY
					PNTID,
					SORT,
					LOCATION,
					TEXT
			) tb1
		LEFT JOIN (
			SELECT
				PNTID AS PNTIDM,
				TO_CHAR (
					MAX (ONRLT),
					'YYYYMMDD HH24:MI:SS'
				) AS TIMESET,
				PLANT AS PLANTM
			FROM
				PLG_EVENT_NEW
			GROUP BY
				PNTID,
				PLANT
		) tb2 ON (
			tb1.PNTIDC = tb2.PNTIDM
			AND tb1.PLANTC = tb2.PLANTM
		)
	) TBH
LEFT JOIN PLG_EVENT_NEW TBX ON TBH.PNTIDM = TBX.PNTID
AND TBH.TIMESET = TO_CHAR (
	TBX.ONRLT,
	'YYYYMMDD HH24:MI:SS'
)
AND TBH.PLANTM = TBX.PLANT");

        foreach ($query->result_array() as $rowID) {
            if ($rowID['VALUEDEFAULT'] == "Stop" || $rowID['VALUEDEFAULT'] == "Not Ready") {
                $valueData = "False";
            } else if ($rowID['VALUEDEFAULT'] == null || $rowID['VALUEDEFAULT'] == " ") {
                $valueData = "True";
            } else {
                $valueData = $rowID['VALUEDEFAULT'];
            }

            $text[$rowID['PNTIDC']] [] = array(
                "datatype" => "string",
                "name" => "Value",
                "quality" => "true",
                "val" => $valueData);
            $go[] = array(
                "name" => $rowID['PNTIDC'],
                "props" => $text[$rowID['PNTIDC']]);
        }

        echo '({"message":"","status":"OK","tags":' . json_encode($go) . ',"token":"7e61b230-481d-4551-b24b-ba9046e3d8f2"});';
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
        
        if (empty($_GET['bulan']) && empty($_GET['tahun'])){
            $sql = "SELECT
                                    SUM (RM1_PROD) + SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM4_PROD) AS rawmill,
                                    SUM (KL1_PROD) + SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) AS kiln,
                                    SUM (FM1_PROD) + SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM4_PROD) + SUM (FM5_PROD) + SUM (FM6_PROD) + SUM (FM7_PROD) + SUM (FM8_PROD) + SUM (FM9_PROD) + SUM (FMA_PROD) + SUM (FMB_PROD) + SUM (FMC_PROD) AS finishmill
                            FROM
                                    PIS_SG_PRODMONTH WHERE MONTH_PROD LIKE '%" . $tahun . "%'";
        } else {
            $sql = "SELECT
                                    SUM (RM1_PROD) + SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM4_PROD) AS rawmill,
                                    SUM (KL1_PROD) + SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) AS kiln,
                                    SUM (FM1_PROD) + SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM4_PROD) + SUM (FM5_PROD) + SUM (FM6_PROD) + SUM (FM7_PROD) + SUM (FM8_PROD) + SUM (FM9_PROD) + SUM (FMA_PROD) + SUM (FMB_PROD) + SUM (FMC_PROD) AS finishmill
                            FROM
                                    PIS_SG_PRODMONTH WHERE MONTH_PROD LIKE '" . $tahun . "-" . $month . "'";
        }

        $query = $db->query($sql);

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
                                    SUM (FM1_PROD) + SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM4_PROD) + SUM (FM5_PROD) + SUM (FM6_PROD) + SUM (FM7_PROD) + SUM (FM8_PROD) + SUM (FM9_PROD) + SUM (FMA_PROD) + SUM (FMB_PROD) + SUM (FMC_PROD) AS finishmill
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
                                        FMC_PROD
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
                "fm_grs" => number_format($fm_grs, 2, ".", "")
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
            'fmc_jop' => number_format($fmc_jop, 2, ".", "")
        );

        echo json_encode($data);
    }

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
                            GROUP BY CONDITION");

        foreach ($query->result_array() as $rowID) {
            $cond = $rowID['CONDITION'];
            $jml = $rowID['JML'];
            
            $note[$cond] = array (
                'jml' => $jml
            );
        }

        echo '{"data":' . json_encode($note). '}';
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
                            AND MONTH_PROD = '$tahun-$bulan'");

        foreach ($query->result_array() as $rowID) {
            $cond = $rowID['CONDITION'];
            $machine = $rowID['MACHINE'];
            $count = $rowID['COUNT'];
            
            $jml[$machine] = array (
                'jml' => $count
            );
            
            $note[$cond] = array (
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
                            AND PLANT = '$plant'");

        foreach ($query->result_array() as $rowID) {
            $notes = $rowID['PROBLEM_DESC'];
            $equipment = $rowID['EQUIPMENT'];
            $solution = $rowID['PROBLEM_SLTN'];
            $id = $rowID['PROBLEM_ID'];
            
            $note[$id] = array (
                'mesin' => $equipment,
                'catatan' => $notes,
                'solusi' => $solution
            );
        }

        echo '{"data":' . json_encode($note). '}';
    }
    
    public function get_ip_tahun() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
        $query = $db->query("SELECT
                                    SUBSTR (MONTH_PROD, 0, 4) AS TAHUN
                            FROM
                                    MSO_IP_REPORT
                            GROUP BY
                                    SUBSTR (MONTH_PROD, 0, 4)");

        foreach ($query->result_array() as $rowID) {
            $tahun = $rowID['TAHUN'];
            $count = count($tahun);
            $a = 0;
            for($i = 0; $i < $count; $i++){
                $a += $i;
            }
            $note[$a] = array (
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
                                    GROUP BY
                                            PLANT
                                    ORDER BY
                                            PLANT
                            ) TOTAL ON GOOD.PLANT = TOTAL.PLANT");

        foreach ($query->result_array() as $rowID) {
            $good = $rowID['GOOD'];
            $total = $rowID['TOTAL'];
            $plant = $rowID['PLANT'];
            
            $note[$plant] = array (
                'good' => $good,
                'total' => $total
            );
        }

        echo json_encode($note);
    }

}
