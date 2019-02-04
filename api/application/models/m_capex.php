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
}