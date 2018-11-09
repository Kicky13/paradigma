<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenerateJsonPlantPadang extends CI_Controller {

	public function index()
	{
		$db=$this->load->database('default4',true);
		$sql=$db->query("SELECT a.tag_name,a.waktu,b.value,b.quality FROM (select tag_name,max(timestamp) as waktu from log_padang where tag_name not in (
																		'N11.R1M03M1',
																		'N12.W1W03_05M1',
																		'N12.K1M03M1',
																		'N13.Z1M03M1',
																		'N21.R2M03M1',
																		'N22.W2W03_05M1',
																		'N22.K2M03M1',
																		'N23.Z2M03M1',
																		'T_4R1.M03M1_M2',
																		'T_4R2.M03M1',
																		'T_4W1.W03_W05',
																		'T_4K2.M03M1',
																		'T_4K3.M03M1_FC',
																		'T_4Z1.M03M1_M2',
																		'T_4Z2.M03M1',
																		'T_5R1.M03M1',
																		'T_5R2.M03M1',
																		'T_5W1.W03M1',
																		'T_5K1.M03M1',
																		'T_5Z1.M03M1',
																		'T_5Z2.M03M1')
							GROUP BY tag_name) a
							LEFT JOIN log_padang b ON a.tag_name = b.tag_name and a.waktu = b.timestamp
UNION
SELECT a.tag_name,a.waktu,b.value,b.quality FROM (select tag_name,max(timestamp) as waktu from log_padang where tag_name in (
																		'N11.R1M03M1',
																		'N12.W1W03_05M1',
																		'N12.K1M03M1',
																		'N13.Z1M03M1',
																		'N21.R2M03M1',
																		'N22.W2W03_05M1',
																		'N22.K2M03M1',
																		'N23.Z2M03M1',
																		'T_4R1.M03M1_M2',
																		'T_4R2.M03M1',
																		'T_4W1.W03_W05',
																		'T_4K2.M03M1',
																		'T_4K3.M03M1_FC',
																		'T_4Z1.M03M1_M2',
																		'T_4Z2.M03M1',
																		'T_5R1.M03M1',
																		'T_5R2.M03M1',
																		'T_5W1.W03M1',
																		'T_5K1.M03M1',
																		'T_5Z1.M03M1',
																		'T_5Z2.M03M1')
							GROUP BY tag_name) a
							LEFT JOIN log_padang b ON a.tag_name = b.tag_name and a.waktu = b.timestamp");
		foreach ($sql->result_array() as $rowID) {
			$idJson[$rowID['tag_name']] = array('tag_name' => $rowID['tag_name'],
										  'waktu'  => $rowID['waktu'],
										  'value' => $rowID['value'],
										  'quality' => $rowID['quality']
											);
	}
	
	echo json_encode($idJson);
	}

}

/* End of file GenerateJsonPlantPadang.php */
/* Location: ./application/controllers/GenerateJsonPlantPadang.php */