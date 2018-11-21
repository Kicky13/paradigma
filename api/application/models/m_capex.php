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
        $query = "SELECT COMPANY,
	              SUM (COST_BUD) AS COST_BUD,
	              SUM (COST_ACT) AS COST_ACT,
	              SUM (COST_COMIT) AS COST_COMIT,
	              SUM (COST_ROP) AS COST_ROP,
	              SUM (COST_ASSIG) AS COST_ASSIG,
	              SUM (COST_AVB) AS COST_AVB,
	              SUM (NVL(COST_CO, 0)) AS COST_CO
                  FROM(
		                SELECT
			              PRIORITY,
			              COMPANY,
			              COST_BUD,
			              COST_ACT,
			              COST_COMIT,
			              COST_ROP,
			              COST_ASSIG,
			              COST_AVB,
			              SUM (NVL(COST_CO, 0)) AS COST_CO
		                  FROM
			              (
				            SELECT
					          B.PSPRI PRIORITY,
					          B.CURR_PROJECT_C,
					          COMPANY,
					          SUM (BUDGET) AS COST_BUD,
					          SUM (ACTUAL) AS COST_ACT,
					          SUM (COMMITED) AS COST_COMIT,
					          SUM (RMORP) AS COST_ROP,
					          SUM (ASSIGMENT_COST) AS COST_ASSIG,
					          SUM (AVAILABLE) AS COST_AVB
				              FROM
					            CAPEX_SAP A
				                JOIN M_WBS B ON A .CURR_PROJECT = B.CURR_PROJECT_C
				                JOIN M_TYPE_INVESTASI C ON B.PSPRI = C.TYPE_INVESTASI_ACT
				                WHERE
					              A .GJAHR = '" . $year ."'
				                  AND B.LEVEL1 = '1'
				                  AND COMPANY = '" . $comp ."'
				                  AND B.CURR_PROJECT_C NOT LIKE 'P1%'
				              GROUP BY
					            B.PSPRI,
					            B.CURR_PROJECT_C,
					            COMPANY
				              ORDER BY
					            B.PSPRI
			              ) SAP
		                LEFT JOIN (
			              SELECT
				            PSPRI,
				            BUKRS,
				            PSPEL_TXT AS WBS,
				            SUM (NVL(FI_DMBTR, 0)) AS COST_CO
			            FROM
				          CAPEX_ACT
			            WHERE
				          FI_AUGDT LIKE '" . $year ."%'
			              AND BUKRS = '" . $comp ."'
			              AND CATEGORY = 'ACT'
			            GROUP BY
				          PSPRI,
				          BUKRS,
				          PSPEL_TXT
		                ) ACT ON ACT.WBS LIKE CONCAT (SAP.CURR_PROJECT_C, '%')
		              GROUP BY
			            PRIORITY,
			            COMPANY,
			            COST_BUD,
			            COST_ACT,
			            COST_COMIT,
			            COST_ROP,
			            COST_ASSIG,
			            COST_AVB
		      ORDER BY
			      PRIORITY
	          )
        GROUP BY
	      COMPANY
        ORDER BY
	      COMPANY";
        $data = $this->db->query($query);
        return $data->row_array();
    }

    function getCAPEXwDetailPSPRI($comp, $year)
    {
        $query = "SELECT PRIORITY, COMPANY, DESCRIPTION,
	              SUM (COST_BUD) AS COST_BUD,
	              SUM (COST_ACT) AS COST_ACT,
	              SUM (COST_COMIT) AS COST_COMIT,
	              SUM (COST_ROP) AS COST_ROP,
	              SUM (COST_ASSIG) AS COST_ASSIG,
	              SUM (COST_AVB) AS COST_AVB,
	              SUM (NVL(COST_CO, 0)) AS COST_CO
                  FROM(
		                SELECT
		                  DESCRIPTION,
			              PRIORITY,
			              COMPANY,
			              COST_BUD,
			              COST_ACT,
			              COST_COMIT,
			              COST_ROP,
			              COST_ASSIG,
			              COST_AVB,
			              SUM (NVL(COST_CO, 0)) AS COST_CO
		                  FROM
			              (
				            SELECT
				            C.DESCRIPTION DESCRIPTION,
					          B.PSPRI PRIORITY,
					          B.CURR_PROJECT_C,
					          COMPANY,
					          SUM (BUDGET) AS COST_BUD,
					          SUM (ACTUAL) AS COST_ACT,
					          SUM (COMMITED) AS COST_COMIT,
					          SUM (RMORP) AS COST_ROP,
					          SUM (ASSIGMENT_COST) AS COST_ASSIG,
					          SUM (AVAILABLE) AS COST_AVB
				              FROM
					            CAPEX_SAP A
				                JOIN M_WBS B ON A .CURR_PROJECT = B.CURR_PROJECT_C
				                JOIN M_TYPE_INVESTASI C ON B.PSPRI = C.TYPE_INVESTASI_ACT
				                WHERE
					              A .GJAHR = '" . $year ."'
				                  AND B.LEVEL1 = '1'
				                  AND COMPANY = '" . $comp ."'
				                  AND B.CURR_PROJECT_C NOT LIKE 'P1%'
				              GROUP BY
											C.DESCRIPTION,
					            B.PSPRI,
					            B.CURR_PROJECT_C,
					            COMPANY
				              ORDER BY
					            B.PSPRI
			              ) SAP
		                LEFT JOIN (
			              SELECT
				            PSPRI,
				            BUKRS,
				            PSPEL_TXT AS WBS,
				            SUM (NVL(FI_DMBTR, 0)) AS COST_CO
			            FROM
				          CAPEX_ACT
			            WHERE
				          FI_AUGDT LIKE '" . $year ."%'
			              AND BUKRS = '" . $comp . "'
			              AND CATEGORY = 'ACT'
			            GROUP BY
				          PSPRI,
				          BUKRS,
				          PSPEL_TXT
		                ) ACT ON ACT.WBS LIKE CONCAT (SAP.CURR_PROJECT_C, '%')
		              GROUP BY
									DESCRIPTION,
			            PRIORITY,
			            COMPANY,
			            COST_BUD,
			            COST_ACT,
			            COST_COMIT,
			            COST_ROP,
			            COST_ASSIG,
			            COST_AVB
		      ORDER BY
			      PRIORITY
	          )
        GROUP BY
        PRIORITY,
	      COMPANY,
	      DESCRIPTION
        ORDER BY
	      COMPANY, PRIORITY, DESCRIPTION";
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
	PRIORITY,
	COMPANY,
	SAP.CURR_PROJECT,
	COST_BUD,
	COST_ACT,
	COST_COMIT,
	COST_ROP,
	COST_ASSIG,
	COST_AVB,
	SUM (NVL(COST_CO, 0)) AS COST_CO
FROM
	(
		SELECT
			B.PSPRI AS PRIORITY,
			A .CURR_PROJECT,
			B.DESCRIPTION,
			COMPANY,
			SUM (BUDGET) AS COST_BUD,
			SUM (ASSIGMENT_COST) AS COST_ASSIG,
			SUM (RMORP) AS COST_ROP,
			SUM (AVAILABLE) AS COST_AVB,
			SUM (COMMITED) AS COST_COMIT,
			SUM (ACTUAL) AS COST_ACT
		FROM
			CAPEX_SAP A
		LEFT JOIN M_WBS B ON A .CURR_PROJECT = B.CURR_PROJECT_C
		AND B.COMPANY_CODE = A .COMPANY
		AND B.LEVEL1 = '1'
		WHERE
			A .GJAHR = '" . $year ."'
		AND COMPANY = '" . $company ."'
		AND B.PSPRI = '" . $priority ."'
		AND B.CURR_PROJECT_C NOT LIKE 'P1%'
		GROUP BY
			B.PSPRI,
			COMPANY,
			A .CURR_PROJECT,
			B.DESCRIPTION
		ORDER BY
			B.PSPRI,
			A .CURR_PROJECT
	) SAP
LEFT JOIN (
	SELECT
		PSPRI,
		BUKRS,
		PSPEL_TXT AS WBS,
		SUM (NVL(FI_DMBTR, 0)) AS COST_CO
	FROM
		CAPEX_ACT
	WHERE
		FI_AUGDT LIKE '" . $year ."%'
	AND BUKRS = '" . $company . "'
	AND CATEGORY = 'ACT'
	GROUP BY
		PSPRI,
		BUKRS,
		PSPEL_TXT
) ACT ON ACT.WBS LIKE CONCAT (SAP.CURR_PROJECT, '%')
GROUP BY
	PRIORITY,
	COMPANY,
	SAP.CURR_PROJECT,
	COST_BUD,
	COST_ACT,
	COST_COMIT,
	COST_ROP,
	COST_ASSIG,
	COST_AVB";
        $data = $this->db->query($query);
        return $data->result_array();
    }
}