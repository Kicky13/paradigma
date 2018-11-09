<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenerateJsonEP extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default1',true);
		$queryOracle = $db->query("SELECT
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
									AND (PISJSON IS NOT NULL and PISJSON in('KL1_Tuban_EP','RM1_Tuban_EP','KL2_Tuban_EP','RM2_Tuban_EP'))
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
					AND TBH.PLANTM = TBX.PLANT ORDER BY SORT ASC");

			foreach ($queryOracle->result_array() as $rowID) {
				if($rowID['VALUEDEFAULT'] == "Stop" || $rowID['VALUEDEFAULT'] == "Not Ready"){
					$valueData = "False";
				}else if ($rowID['VALUEDEFAULT'] == null || $rowID['VALUEDEFAULT'] == " "){
					$valueData = "True";
				}else{
					$valueData = $rowID['VALUEDEFAULT'];
				}
					$text[$rowID['PISJSON']] []= array(
									"datatype"=>"string",
									"name"=> "Value",
									"quality"=> "true",
									"val"=>$valueData);
					$go[]=array( 
									"name"=>$rowID['PISJSON'],
									"props"=>$text[$rowID['PISJSON']]);

				}
			echo '({"message":"","status":"OK","tags":'.json_encode($go).',"token":"7e61b230-481d-4551-b24b-ba9046e3d8f2"});';
	}

}

/* End of file GenerateJsonEP.php */
/* Location: ./application/controllers/GenerateJsonEP.php */