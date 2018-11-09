<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_project extends CI_Model {


	function get_project($param){
		$db = $this->load->database('default7',true);

        $pic = 'SEMEN PADANG';
		$sql = '  SELECT tbl1.*,  TBL3.*
            FROM (SELECT "Title" ,
                         "PIC_Project",
                         "Baseline_Start",
                         "Baseline_Finish",
                         "Completion",
                         "Investation_Number",
                         "OpCo",
                         "Year",
                         "Lokasi_Kota",
                         "Total_Project_Budget"
                    FROM PAR4DIGMA.PROJECT_NAME
                   WHERE "Baseline_Start" IS NOT NULL) TBL1
                 LEFT JOIN
        --          (SELECT DISTINCT "Title",
        --                  "Project_Name",
        --                  "Issue_Status",
        --                  "Priority",
        --                  "Description",
        --                  "Category",
        --                  "Due_Date",
        --                  "ID"
        --             FROM PAR4DIGMA.PROJECT_ISSUE) TBL2
        --             ON TBL1."Title" = TBL2."Project_Name"
        --          LEFT JOIN
                 (SELECT "Schedule_In_Progress",
                         "Project_Name",
                         "NVL" (SPI, 0)        SPI,
                         "NVL" (CPI, 0)        CPI,
                         "NVL" (EAC, 0)        EAC,
                         "NVL" ("PF_Plan", 0)  PF_plan,
                         "NVL" ("PF_Real", 0)  PF_Real,
                         "NVL" ("PF_Var", 0)   PF_var,
                         "NVL" (AC, 0)         AC,
                         "NVL" (EV, 0)         EV,
                         "NVL" (PV, 0)         PV,
                         "NVL" ("Commitment", 0)"Commitment",
                         "NVL" ("Cash_Out", 0) "Cash_Out",
                         "Update_Date",
                         "NVL" ("Remn_Order", 0)"Remn_Order",
                         "NVL" (KPI, 0)        KPI,
                         "ID"                  PS_ID,
                         "NVL" ("Created", 0) "Created"
                    FROM PAR4DIGMA.PROJECT_STATUS TBL3
                    WHERE "Created" IS NOT NULL) TBL3
                    ON TBL1."Title" = TBL3."Project_Name"
                    -- WHERE TBL1."PIC_Project" = \''.$pic.'\'
                     ORDER BY TBL3."Update_Date" ASC
				';
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}

    function get_project_stat($param){
        $db = $this->load->database('default7',true);
        $projectSql = '';
        $status = " TBL2.PROJECT_NAME_ISSUE IS NOT NULL  AND";
        if ($param['project']!='') {

             $projectSql = " AND TBL1.\"Title\" LIKE '%".$param['project']."%' ";
             $status = '';
            # code...
        }
        $sql = "
       SELECT
                tbl1.*, TBL2.*, TBL3.*
            FROM
                (
                    SELECT
                        \"Title\",
                        \"PIC_Project\",
                        \"Baseline_Start\",
                        \"Baseline_Finish\",
                        \"Completion\",
                        \"Investation_Number\",
                        \"OpCo\",
                        \"Year\",
                        \"Lokasi_Kota\",
                        \"Total_Project_Budget\"
                    FROM
                        PAR4DIGMA.PROJECT_NAME
                    WHERE
                        \"Baseline_Start\" IS NOT NULL
                ) TBL1
            LEFT JOIN (
                SELECT
                    \"Title\" NAME_OF_ISSUE,
                    \"Project_Name\" PROJECT_NAME_ISSUE,
                    \"Issue_Status\",
                    \"Priority\",
                    \"Description\",
                    \"Category\",
                    \"Due_Date\",
                    \"ID\"
                FROM
                    PAR4DIGMA.PROJECT_ISSUE
            ) TBL2 ON TBL1.\"Title\" = TBL2.PROJECT_NAME_ISSUE
            LEFT JOIN (
                SELECT
                    TBLSTATUS.*
                FROM
                    (
                        SELECT
                            \"Project_Name\",
                            \"MAX\" (
                                \"TO_DATE\" (
                                    \"Created\",
                                    'DD/MM/YYYY HH24:MI:SS'
                                )
                            ) CREATED
                        FROM
                            PAR4DIGMA.PROJECT_STATUS
                        GROUP BY
                            \"Project_Name\"
                    ) TBLMAX
                JOIN (
                    SELECT
                        \"Schedule_In_Progress\",
                        \"Project_Name\" AS PROJECT,
                        \"NVL\" (SPI, 0) SPI,
                        \"NVL\" (CPI, 0) CPI,
                        \"NVL\" (EAC, 0) EAC,
                        \"NVL\" (\"PF_Plan\", 0) PF_plan,
                        \"NVL\" (\"PF_Real\", 0) PF_Real,
                        \"NVL\" (\"PF_Var\", 0) PF_var,
                        \"NVL\" (AC, 0) AC,
                        \"NVL\" (EV, 0) EV,
                        \"NVL\" (PV, 0) PV,
                        \"NVL\" (\"Commitment\", 0) AS COMMIT,
                        \"NVL\" (\"Cash_Out\", 0) AS CASH_OUT,
                        \"Update_Date\",
                        \"NVL\" (\"Remn_Order\", 0) \"Remn_Order\",
                        \"NVL\" (KPI, 0) KPI,
                        \"ID\" PS_ID,
                        \"TO_DATE\" (
                            \"Created\",
                            'DD/MM/YYYY HH24:MI:SS'
                        ) CREATED
                    FROM
                        PAR4DIGMA.PROJECT_STATUS
                ) TBLSTATUS ON TBLMAX.\"Project_Name\" = TBLSTATUS.\"PROJECT\"
                AND TBLMAX.CREATED = TBLSTATUS.CREATED
            ) TBL3 ON TBL1.\"Title\" = TBL3.\"PROJECT\"
            WHERE
                
                $status
            TBL1.\"PIC_Project\" IS NOT NULL
            $projectSql
            ORDER BY
                TBL1.\"Title\", TBL2.\"Due_Date\" DESC


                ";
        $result = $db->query($sql);


        return $result->result_array();
        // return 'data';
    }

}

