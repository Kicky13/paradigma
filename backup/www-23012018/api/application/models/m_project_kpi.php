<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_project_kpi extends CI_Model {


	function get_project_kpi($param){
		$db = $this->load->database('default7',true);
		$sql = '  SELECT tbl1.*
  FROM (  SELECT "KPI_This_Month" as KPI_OF, "KPI_Komunal" as KPI_UNTIL,  "Period"
            FROM PAR4DIGMA.KPI      
        ) TBL1
				';
		$result = $db->query($sql);


		return $result->result_array();
		// return 'data';
	}

}

