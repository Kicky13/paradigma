<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_project_dash extends CI_Model {


	function get_project_dash($param){
		$db = $this->load->database('default7',true);
		$sql = '
		    SELECT Project_Name."PIC_Project",
    ("Project_Name")   AS PROJECT,
	("Baseline_Start") AS PROJECT_START,
	("Baseline_Finish") PROJECT_FINISH,
    ("Cash_Out")           AS CASH_OUT,
    ("Commitment")         AS COMMIT,
    ("Total_Project_Budget") AS TOTAL_BUDGET
        
    FROM PROJECT_STATUS
         JOIN PROJECT_NAME
            ON PROJECT_STATUS."Project_Name" = PROJECT_NAME."Title"
   WHERE "PIC_Project" IS NOT NULL
				';
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}

	function get_project_dash_v2($param){
			$db = $this->load->database('default7',true);
			$sql = '
			    SELECT
					tbl1.*, TBL2.*
				FROM
					(
						SELECT
							"Title",
							"PIC_Project",
							"Baseline_Start" AS PROJECT_START,
							"Baseline_Finish" AS PROJECT_FINISH,
							"Completion",
							"Investation_Number",
							"OpCo",
							"Year",
							"Lokasi_Kota",
							"Total_Project_Budget" AS TOTAL_BUDGET
						FROM
							PAR4DIGMA.PROJECT_NAME
						WHERE
							"Baseline_Start" IS NOT NULL
						AND "PIC_Project" IS NOT NULL
					) TBL1
				LEFT JOIN (
					SELECT
						TBLSTATUS.*
					FROM
						(
							SELECT
								"Project_Name",
								"MAX" (
									"TO_DATE" (
										"Created",
										\'DD/MM/YYYY HH24:MI:SS\'
									)
								) CREATED
							FROM
								PAR4DIGMA.PROJECT_STATUS
							GROUP BY
								"Project_Name"
						) TBLMAX
					JOIN (
						SELECT
							"Schedule_In_Progress",
							"Project_Name" AS PROJECT,
							"NVL" (SPI, 0) SPI,
							"NVL" (CPI, 0) CPI,
							"NVL" (EAC, 0) EAC,
							"NVL" ("PF_Plan", 0) PF_plan,
							"NVL" ("PF_Real", 0) PF_Real,
							"NVL" ("PF_Var", 0) PF_var,
							"NVL" (AC, 0) AC,
							"NVL" (EV, 0) EV,
							"NVL" (PV, 0) PV,
							"NVL" ("Commitment", 0) AS COMMIT,
							"NVL" ("Cash_Out", 0) AS CASH_OUT,
							"Update_Date",
							"NVL" ("Remn_Order", 0) "Remn_Order",
							"NVL" (KPI, 0) KPI,
							"ID" PS_ID,
							"TO_DATE" (
								"Created",
								\'DD/MM/YYYY HH24:MI:SS\'
							) CREATED
						FROM
							PAR4DIGMA.PROJECT_STATUS
					) TBLSTATUS ON TBLMAX."Project_Name" = TBLSTATUS."PROJECT"
					AND TBLMAX.CREATED = TBLSTATUS.CREATED
				) TBL2 ON TBL1."Title" = TBL2."PROJECT"
				WHERE
					TBL2."PROJECT" IS NOT NULL
				AND TBL1."Completion" = \'False\'
				ORDER BY
					TBL1."PIC_Project"
					';
			$result = $db->query($sql);


			return $result->result_array();
			// return 'data';
		}

	public function pic()
	{
		$this->db = $this->load->database('default7',true);
			
	}

	public function get_project()
	{

		$this->db = $this->load->database('default7',true);
		$pic='';
		$sql=$this->db->query('SELECT
									"PIC_Project"
				            FROM PAR4DIGMA.PROJECT_NAME
				            GROUP BY "PIC_Project"

				            ');
		foreach ($sql->result() as $a) {
			$sql1= $this->db->query("SELECT TB1.*,TB2.* FROM(SELECT
				                           \"Project_Name\",
				                           \"PF_Real\"
				                      FROM PAR4DIGMA.PROJECT_STATUS
				                     WHERE \"Created\" IS NOT NULL)TB1
				INNER JOIN
					(SELECT \"Title\",
									\"PIC_Project\",
				             \"Total_Project_Budget\"
				            FROM PAR4DIGMA.PROJECT_NAME
							WHERE \"PIC_Project\" IS NOT NULL)TB2
				ON TB1.\"Project_Name\"=TB2.\"Title\" WHERE TB2.\"PIC_Project\"='NEW CEMENT PLANTS'");
				foreach ($sql1->result() as $p) {
					echo $pic+=$p->PF_Real;
				}
			}

	}

}

