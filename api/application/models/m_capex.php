<?php

class m_capex extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default3', TRUE);
    }

    function getMainCAPEXData($year)
    {
        $data = array();
        $comps = array(
            '2000',
            '3000',
            '4000',
            '5000',
            '7000'
        );
        foreach ($comps as $comp) {
            $capex = $this->getCAPEXByCompanyYear($comp, $year);
            if (count($capex) > 0) {
                $temp = array(
                    'company' => $comp,
                    'company_name' => $this->getCompanyName($comp),
                    'data' => $capex
                );
                array_push($data, $temp);
            }
        }
        return $data;
    }

    function getCAPEXByCompanyYear($comp, $year)
    {
        $query = "SELECT
	                COMPANY,
	                SUM (BUDGET) AS COST_BUD,
	                SUM (ACTUAL) AS COST_ACT,
	                SUM (COMMITED) AS COST_COMIT,
	                SUM (RMORP) AS COST_ROP,
	                SUM (ASSIGMENT_COST) AS COST_ASSIG,
	                SUM (AVAILABLE) AS COST_AVB,
	                SUM (NVL(CASHOUT,0)*100) AS COST_CO
                  FROM
	                CAPEX_SAP A
                  JOIN M_WBS B ON A .CURR_PROJECT = B.CURR_PROJECT_C
                  JOIN M_TYPE_INVESTASI C ON B.PSPRI = C.TYPE_INVESTASI_ACT
                  WHERE
	                A .GJAHR = '" . $year . "'
                    AND B.LEVEL1 = '1'
                    AND COMPANY = '" . $comp . "'
                    AND B.CURR_PROJECT_C NOT LIKE 'P1%'
                  GROUP BY
	                COMPANY";
        $data = $this->db->query($query);
        return $data->row_array();
    }

    function getCAPEXwDetailPSPRI($comp, $year)
    {
        $query = "SELECT
	                B.PSPRI PRIORITY,
	                C.DESCRIPTION,
	                COMPANY,
	                SUM (BUDGET) AS COST_BUD,
	                SUM (ACTUAL) AS COST_ACT,
	                SUM (COMMITED) AS COST_COMIT,
	                SUM (RMORP) AS COST_ROP,
	                SUM (ASSIGMENT_COST) AS COST_ASSIG,
	                SUM (AVAILABLE) AS COST_AVB,
	                SUM (NVL(CASHOUT,0)*100) AS COST_CO
                  FROM
	                CAPEX_SAP A
                  JOIN M_WBS B ON A .CURR_PROJECT = B.CURR_PROJECT_C
                  JOIN M_TYPE_INVESTASI C ON B.PSPRI = C.TYPE_INVESTASI_ACT
                  WHERE
	                A .GJAHR = '" . $year . "'
                    AND B.LEVEL1 = '1'
                    AND COMPANY = '" . $comp . "'
                    AND B.CURR_PROJECT_C NOT LIKE 'P1%'
                  GROUP BY
	                B.PSPRI,
	                C.DESCRIPTION,
	                COMPANY
                  ORDER BY
	                B.PSPRI";
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function getCAPEXPerCompany($year)
    {
        $data = array();
        $comps = array(
            '2000',
            '3000',
            '4000',
            '5000',
            '7000'
        );
        foreach ($comps as $comp) {
            $capex = $this->getCAPEXwDetailPSPRI($comp, $year);
            $temp = array(
                'company' => $comp,
                'company_name' => $this->getCompanyName($comp),
                'data' => $capex
            );
            array_push($data, $temp);
        }
        return $data;
    }

    function getCompanyName($code)
    {
        switch ($code) {
            case '1000':
                $name = 'Holding SMIG';
                break;
            case '2000':
                $name = 'PT. Semen Indonesia (Persero) Tbk.';
                break;
            case '3000':
                $name = 'PT. Semen Padang';
                break;
            case '4000':
                $name = 'PT. Semen Tonasa';
                break;
            case '5000':
                $name = 'PT. Semen Gresik';
                break;
            case '6000':
                $name = 'Thang Long Cement Company';
                break;
            case '7000':
                $name = 'PT. Semen Indonesia';
                break;
            case '8000':
                break;
        }
        return $name;
    }

    function getCurrentProject($company, $year, $priority)
    {
        $query = "SELECT
	                B.PSPRI AS PRIORITY,
	                A .CURR_PROJECT,
	                B.DESCRIPTION,
	                COMPANY,
	                SUM (BUDGET) AS COST_BUD,
	                SUM (ACTUAL) AS COST_ACT,
	                SUM (COMMITED) AS COST_COMIT,
	                SUM (RMORP) AS COST_ROP,
	                SUM (ASSIGMENT_COST) AS COST_ASSIG,
	                SUM (AVAILABLE) AS COST_AVB,
	                SUM (NVL(CASHOUT,0)*100) AS COST_CO
                  FROM
	                CAPEX_SAP A
                  LEFT JOIN M_WBS B ON A .CURR_PROJECT = B.CURR_PROJECT_C
                    AND B.COMPANY_CODE = A .COMPANY
                    AND B.LEVEL1 = '1'
                    AND B.CURR_PROJECT_C NOT LIKE 'P1%'
                  WHERE
	                A .GJAHR = '" . $year . "'
                    AND COMPANY = '" . $company . "'
                    AND B.PSPRI = '" . $priority . "'
                  GROUP BY
	                B.PSPRI,
	                COMPANY,
	                A .CURR_PROJECT,
	                B.DESCRIPTION
                  ORDER BY
	                COMPANY,
	                B.PSPRI,
	                A .CURR_PROJECT";
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function getDataByProject($year)
    {
        $data = array();
        $comps = array(
            '2000',
            '3000',
            '4000',
            '5000',
            '7000'
        );
        foreach ($comps as $comp) {
            $capex = $this->getProjectPerCompany($comp, $year);
            if (count($capex) > 0) {
                $temp = array(
                    'company' => $comp,
                    'company_name' => $this->getCompanyName($comp),
                    'data' => $capex
                );
                array_push($data, $temp);
            }
        }
        return $data;
    }

    function getDataByType($year)
    {
        $data = array();
        $comps = array(
            '2000',
            '3000',
            '4000',
            '5000',
            '7000'
        );
        foreach ($comps as $comp) {
            $capex = $this->getTypePerCompany($comp, $year);
            if (count($capex) > 0) {
                $temp = array(
                    'company' => $comp,
                    'company_name' => $this->getCompanyName($comp),
                    'data' => $capex
                );
                array_push($data, $temp);
            }
        }
        return $data;
    }

    function getProjectPerCompany($comp, $year)
    {
        $query = "SELECT
	              A .CURR_PROJECT,
	              B.DESCRIPTION,
	              SUM (BUDGET) AS COST_BUD,
	              SUM (ACTUAL) AS COST_ACT,
	              SUM (COMMITED) AS COST_COMIT,
	              SUM (RMORP) AS COST_ROP,
	              SUM (ASSIGMENT_COST) AS COST_ASSIG,
	              SUM (AVAILABLE) AS COST_AVB,
	              SUM (NVL(CASHOUT, 0) * 100) AS COST_CO
                  FROM CAPEX_SAP A
                  JOIN M_WBS B ON A .CURR_PROJECT = B.CURR_PROJECT_C
                  WHERE
	                A .GJAHR = '" . $year . "'
                    AND B.LEVEL1 = '1'
                    AND COMPANY = '" . $comp . "'
                    AND B.CURR_PROJECT_C NOT LIKE 'P1%'
                  GROUP BY
	                A .CURR_PROJECT,
	                B.DESCRIPTION
                  ORDER BY
	                A .CURR_PROJECT,
	                B.DESCRIPTION";
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function getTypePerCompany($comp, $year)
    {
        $query = "SELECT
	              B.PSPRI AS PRIORITY,
	              C.DESCRIPTION,
	              SUM (BUDGET) AS COST_BUD,
	              SUM (ACTUAL) AS COST_ACT,
	              SUM (COMMITED) AS COST_COMIT,
	              SUM (RMORP) AS COST_ROP,
	              SUM (ASSIGMENT_COST) AS COST_ASSIG,
	              SUM (AVAILABLE) AS COST_AVB,
	              SUM (NVL(CASHOUT, 0) * 100) AS COST_CO
                  FROM
	              CAPEX_SAP A
                  LEFT JOIN M_WBS B ON A .WBS = B.WBS
                  AND B.COMPANY_CODE = A .COMPANY
                  JOIN M_TYPE_INVESTASI C ON B.PSPRI = C.TYPE_INVESTASI_ACT
                  WHERE
	                A .GJAHR = '" . $year . "'
                    AND COMPANY = '" . $comp . "'
                    AND B.CURR_PROJECT_C NOT LIKE 'P1%'
                    AND A .LEVEL1 IN (
	                SELECT
		            MAX (LEVEL1)
	                FROM
		              CAPEX_SAP
	                  WHERE
		                A .GJAHR = '" . $year . "'
	                    AND COMPANY = '" . $comp . "'
	                    AND B.CURR_PROJECT_C NOT LIKE 'P1%'
                    )
                  GROUP BY
	                C.DESCRIPTION,
	                B.PSPRI
                  ORDER BY
	                B.PSPRI";
        $data = $this->db->query($query);
        return $data->result_array();
    }
    
    function getDetailProject($comp, $project, $year)
    {
        $query = "SELECT
	                B.PSPRI AS PRIORITY,
	                C.DESCRIPTION,
	                A.CURR_PROJECT,
	                SUM (BUDGET) AS COST_BUD,
	                SUM (ACTUAL) AS COST_ACT,
	                SUM (COMMITED) AS COST_COMIT,
	                SUM (RMORP) AS COST_ROP,
	                SUM (ASSIGMENT_COST) AS COST_ASSIG,
	                SUM (AVAILABLE) AS COST_AVB,
	                SUM (NVL(CASHOUT, 0) * 100) AS COST_CO
                  FROM
	                CAPEX_SAP A
                  LEFT JOIN M_WBS B ON A .WBS = B.WBS
                  AND B.COMPANY_CODE = A .COMPANY
                  JOIN M_TYPE_INVESTASI C ON B.PSPRI = C.TYPE_INVESTASI_ACT
                  WHERE
	                A .GJAHR = '" . $year . "'
                    AND COMPANY = '" . $comp . "'
                    AND A .CURR_PROJECT = '" . $project . "'
                    AND B.CURR_PROJECT_C NOT LIKE 'P1%'
                    AND A .LEVEL1 IN (
	              SELECT
		            MAX (LEVEL1)
	              FROM
		            CAPEX_SAP
	              WHERE
		            A .GJAHR = '" . $year . "'
	                AND COMPANY = '" . $comp . "'
	                AND A .CURR_PROJECT = '" . $project . "'
	                AND B.CURR_PROJECT_C NOT LIKE 'P1%'
                  )
                  GROUP BY
	                A.CURR_PROJECT,
	                C.DESCRIPTION,
	                B.PSPRI
                  ORDER BY
	                B.PSPRI";
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function capexDashboardControl($year)
    {
        $data = array();
        $opcos = array(
            '2000',
            '3000',
            '4000',
            '5000',
            '7000'
        );
        foreach ($opcos as $opco){
            if ($opco == '2000'){
                $pastDate = date('Ym', strtotime('-11 month')) . '00';
                $thisDate = date('Ym') . '31';
                $temp = array(
                    'company' => $this->getCompanyName($opco),
                    'companyCode' => $opco,
                    'DataUpToMonth' => $this->getDataCAPEXDashboardSMIG($opco, $pastDate, $thisDate),
                );
            } else {
                $perMonth = array();
                for ($i = 0; $i < 12; $i++){
                    if ($i != 0) {
                        $countDate = '-' . $i;
                        $thisDate = date('Ym', strtotime($countDate . ' month')) . '31';
                        $pastDate = date('Ym', strtotime($countDate . ' month')) . '00';
                    } else {
                        $thisDate = date('Ymd');
                        $pastDate = date('Ym') . '00';
                    }
                    $tempM = array(
                        'date' => date('Y-M'),
                        'graph' => $this->getDataCAPEXDashboardSMIG($opco, $pastDate, $thisDate),
                        'table' => $this->getDataCAPEXDashboardSMIG($opco)
                    );
                    array_push($perMonth, $tempM);
                }
                $temp = array(
                    'company' => $this->getCompanyName($opco),
                    'companyCode' => $opco,
                    'DataUpToMonth' => $perMonth,
                );
            }
            array_push($data, $temp);
        }
        return $data;
    }

    function getDataCAPEXDashboardSMIG($opco = '7000', $pastDate = 0, $thisDate = 0)
    {
        $query = "SELECT * FROM (
                SELECT
                    WBS,
                    DESCRIPTION,
                    BUKRS,
                    PSPRI,
                    SUM (TOT_BUDGET) AS TOT_BUDGET,
                    SUM (BUDGET) AS BUDGET,
                    SUM (PR) * 100 AS PR,
                    SUM (PO) * 100 AS PO,
                    SUM (GR) * 100 AS GR,
                    SUM (PLANNING) AS PLANNING,
                    SUM (INVOICE) * 100 AS INVOICE,
                    SUM (CASHOUT) * 100 AS CASHOUT
                FROM (
                    SELECT
                        A1.WBS,
                        A1.DESCRIPTION,
                        A1.COMPANY_CODE AS BUKRS,
                        A1.PSPRI,
                        SUM (A1.BUDGET) AS BUDGET,
                        SUM (B1.TOT_BUDGET) AS TOT_BUDGET,
                        0 AS PR,
                        0 AS PO,
                        0 AS PLANNING,
                        0 AS GR,
                        0 AS INVOICE,
                        0 AS CASHOUT
                    FROM
			(
                            ---------------- ORIGINAL BUDGET IN YEAR -----------
                            SELECT
                                A .WBS,
                                B.DESCRIPTION,
                                B.PSPRI,
                                B.COMPANY_CODE,
                                SUM (BUDGET) AS BUDGET
                            FROM
                                CAPEX_SAP A
                                LEFT JOIN M_WBS B ON A .WBS = B.WBS
                            WHERE
                                A .GJAHR IN ('2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019')
                                
                                
                                AND B.COMPANY_CODE = '" . $opco ."'
                                AND B.PSPRI IS NOT NULL
                                AND B.CURR_PROJECT_C NOT LIKE 'P1%'
                                -- AND A .BUDGET != '0'
                                AND A .LEVEL1 IN (
                                        SELECT
                                            MAX (A .LEVEL1)
                                        FROM
                                            CAPEX_SAP AA
                                            LEFT JOIN M_WBS BB ON AA.WBS = BB.WBS
                                        WHERE
                                            AA.GJAHR IN ('2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019')
                                            AND BB.COMPANY_CODE = B.COMPANY_CODE
                                            AND BB.CURR_PROJECT_C = B.CURR_PROJECT_C
				)
                            GROUP BY
                                A .WBS,
                                B.DESCRIPTION,
                                B.PSPRI,
                                B.COMPANY_CODE
                            ------------ END ORIGINAL BUDGET IN YEAR -----------
			) A1 LEFT JOIN (
                            ------------------ TOTAL BUDGET --------------------
                            SELECT
                                A .WBS,
                                B.DESCRIPTION,
                                B.PSPRI,
                                B.COMPANY_CODE,
                                SUM (BUDGET) AS TOT_BUDGET
                            FROM
                                CAPEX_SAP A
                                LEFT JOIN M_WBS B ON A .WBS = B.WBS
                            WHERE
                                B.CURR_PROJECT_C NOT LIKE 'P1%'
                                
                                
                                AND B.COMPANY_CODE = '" . $opco ."'
                                AND B.PSPRI IS NOT NULL
                                AND A .LEVEL1 IN (
                                    SELECT
                                        MAX (A .LEVEL1)
                                    FROM
                                        CAPEX_SAP AA
                                        LEFT JOIN M_WBS BB ON AA.WBS = BB.WBS
                                    WHERE
                                        BB.COMPANY_CODE = B.COMPANY_CODE
                                        AND BB.CURR_PROJECT_C = B.CURR_PROJECT_C
                                )
                            GROUP BY
                                A .WBS,
                                B .DESCRIPTION,
                                B.PSPRI,
                                B.COMPANY_CODE
                            ---------------- END TOTAL BUDGET ------------------
			) B1 ON A1.WBS = B1.WBS
                            AND A1.DESCRIPTION = B1.DESCRIPTION
                            AND A1.PSPRI = B1.PSPRI
                            AND A1.COMPANY_CODE = B1.COMPANY_CODE
                        GROUP BY
                            A1.WBS,
                            A1.DESCRIPTION,
                            A1.COMPANY_CODE,
                            A1.PSPRI
                    ----------------------- PR PO -------------------------
                UNION ALL
                    SELECT
                        A.PSPEL_TXT AS WBS,
                        B.DESCRIPTION,
                        BUKRS,
                        B.PSPRI,
                        0 AS BUDGET,
                        0 AS TOT_BUDGET,
                        SUM (MENGE_PR_SUM) AS PR,
                        SUM (PONETWR_LC) AS PO,
                        0 AS PLANNING,
                        0 AS GR,
                        0 AS INVOICE,
                        0 AS CASHOUT
                    FROM
                        CAPEX_ACT A
                        LEFT JOIN M_WBS B ON A .PSPEL_TXT = B.WBS
                    WHERE
                        ERDAT BETWEEN '" . $pastDate . "' AND '" . $thisDate . "'
                        
                        
                        AND BUKRS = '7000'
                        AND B.PSPRI IS NOT NULL
                        AND CATEGORY = 'ACT'
                        AND PSPEL_TXT NOT LIKE 'P1-%'
                    GROUP BY
                        A.PSPEL_TXT,
                        B.DESCRIPTION,
                        BUKRS,
                        B.PSPRI
                ----------------------- GR (DATA SAP) ----------------------
                UNION ALL
                    SELECT
                        A.PSPEL_TXT AS WBS,
                        B.DESCRIPTION,
                        BUKRS,
                        B.PSPRI,
                        0 AS BUDGET,
                        0 AS TOT_BUDGET,
                        0 AS PR,
                        0 AS PO,
                        0 AS PLANNING,
                        SUM (WTGBTR) AS GR,
                        0 AS INVOICE,
                        0 AS CASHOUT
                    FROM
                        CAPEX_ACT A
                        LEFT JOIN M_WBS B ON A .PSPEL_TXT = B.WBS
                    WHERE
                        BUDAT BETWEEN '" . $pastDate . "' AND '" . $thisDate . "'
                        
                        
                        AND BUKRS = '7000'
                        AND B.PSPRI IS NOT NULL
                        AND CATEGORY = 'ACT'
                        AND PSPEL_TXT NOT LIKE 'P1-%'
                        AND TWAER = 'IDR'
                        AND BLART = 'WE'
                    GROUP BY
                        A.PSPEL_TXT,
                        B.DESCRIPTION,
                        BUKRS,
                        B.PSPRI
                ----------------------- INVOICE (DATA SAP) ----------------------
                UNION ALL
                    SELECT
                        A.PSPEL_TXT AS WBS,
                        B.DESCRIPTION,
                        BUKRS,
                        B.PSPRI,
                        0 AS BUDGET,
                        0 AS TOT_BUDGET,
                        0 AS PR,
                        0 AS PO,
                        0 AS PLANNING,
                        0 AS GR,
                        SUM (WTGBTR) AS INVOICE,
                        0 AS CASHOUT
                    FROM
                        CAPEX_ACT A
                        LEFT JOIN M_WBS B ON A .PSPEL_TXT = B.WBS
                    WHERE
                        BUDAT BETWEEN '" . $pastDate . "' AND '" . $thisDate . "'
                        
                        
                        AND BUKRS = '" . $opco ."'
                        AND B.PSPRI IS NOT NULL
                        AND CATEGORY = 'ACT'
                        AND PSPEL_TXT NOT LIKE 'P1-%'
                        AND TWAER = 'IDR'
                        AND BLART = 'RE'
                    GROUP BY
                        A.PSPEL_TXT,
                        B.DESCRIPTION,
                        BUKRS,
                        B.PSPRI
                    ----------------------- PLANNING  CASHOUT ----------------------
                    ----------------------- GR INVOICE (DATA NON SAP) ----------------------
                UNION ALL
                    SELECT
                        A.PSPEL_TXT AS WBS,
                        B.DESCRIPTION,
                        BUKRS,
                        B.PSPRI,
                        0 AS BUDGET,
                        0 AS TOT_BUDGET,
                        0 AS PR,
                        0 AS PO,
                        SUM (PLANNING) AS PLANNING,
                        SUM (GR) AS GR,
                        SUM (INVOICE) AS INVOICE,
                        SUM (WKGBTR) AS CASHOUT
                    FROM
                        CAPEX_ACT A
                        LEFT JOIN M_WBS B ON A .PSPEL_TXT = B.WBS
                    WHERE
                        BUDAT BETWEEN '" . $pastDate . "' AND '" . $thisDate . "'
                        
                        
                        AND BUKRS = '" . $opco ."'
                        AND B.PSPRI IS NOT NULL
                        AND CATEGORY = 'ACT'
                        AND PSPEL_TXT NOT LIKE 'P1-%'
                        AND TWAER = 'IDR'
                    GROUP BY
                        A.PSPEL_TXT,
                        B.DESCRIPTION,
                        BUKRS,
                        B.PSPRI
                )WHERE
                    TOT_BUDGET != '0'
                    OR BUDGET != '0'
                    OR PR != '0'
                    OR PLANNING != '0'
                    OR PO != '0'
                    OR GR != '0'
                    OR INVOICE != '0'
                    OR CASHOUT != '0'
                GROUP BY
                    WBS,
                    BUKRS,
                    PSPRI,
                    DESCRIPTION
            )ORDER BY WBS DESC, BUKRS, PSPRI
            OFFSET 0 ROWS FETCH NEXT 20 ROWS ONLY";
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function getDataCAPEXDashboardPerYear($opco = '7000', $pastDate = 0, $thisDate = 0)
    {
        $string = 'Masih Kosong';
        return $string;
    }
}