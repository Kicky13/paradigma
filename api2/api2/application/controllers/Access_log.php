<?php

class Access_log extends QMUser {

	public $list_data = array();
	public $data_company;

	public function __construct(){
		parent::__construct();
		$this->load->helper("string");
		$this->load->helper("color");
		$this->load->model("m_access_log");
		$this->load->model("m_usergroup");
		$this->load->model("m_company");
		$this->load->model("m_groupmenu");
	}

	public function index(){
		$this->list_usergroup = $this->m_usergroup->datalist();
		$this->list_company = $this->m_company->list_company_auth($this->USER->ID_COMPANY);
		$this->list_groupmenu = $this->m_groupmenu->datalist();
		$this->template->adminlte("v_access_log");
	}

	public function get_list(){
		$list = $this->m_access_log->get_list();
		$data = array();
		$no   = $this->input->post('start');

		foreach ($list as $column) {
			$no++;
			$row = array();
			$row[] = $column->LOG_ID;
			$row[] = $no;
			$row[] = $column->TIME;
			$row[] = $column->USERNAME;
			$row[] = $column->USERGROUP;
			$row[] = $column->COMPANY;
			$row[] = $column->GROUPMENU;
			$row[] = $column->MENU;
			$row[] = $column->URL;
			$row[] = $column->FROM_IP;
			$data[] = $row;
		}

		$output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->m_access_log->count_all(),
            "recordsFiltered" => $this->m_access_log->count_filtered(),
            "data" => $data,
        );

		to_json($output);
	}

	public function dashboard(){
		$this->list_company = $this->m_company->list_company();
		$this->topGroupmenu = $this->m_access_log->topGroupmenu(date("m-Y"));
		$this->topMenu 			= $this->m_access_log->topMenu(date("m-Y"));
		$this->topUserList  = $this->m_access_log->topUser();
		$this->template->adminlte("v_access_log_dashboard");
	}

	public function opco_hit($tipe=NULL){
		if (empty($tipe)) {
			to_json($this->m_access_log->perCompanyMonth(date("m/Y")));
		}else {
			$opco  = array();
			$hasil = $this->m_access_log->perCompanyDate(date("m/Y"));

			//Group by company
			foreach ($hasil as $cp) {
				$id_com = $cp->ID_COMPANY;
				if(isset($opco[$id_com])){
					$opco[$id_com][] = (array) $cp;
				}else{
					$opco[$id_com] = array((array) $cp);
				}
			}


			usort($opco, function($a, $b) {
				return strtotime($a['TANGGAL']) - strtotime($b['TANGGAL']);
			});


			//Generate plotly data
			foreach ($opco as $key => $val) {
				foreach ($val as $dt) {
					$color = company_color_rgb($dt['KD_COMPANY']);
					$res[$key]['y'][] = $dt['JML_AKSES'];
					$res[$key]['x'][] = $dt['TANGGAL'];
					$res[$key]['type'] = 'scatter';
					$res[$key]['name'] = $dt['COMPANY'];
					$res[$key]['fill'] = "";
					$res[$key]['line'] = array('dash' => 'solid','width' => "3", "color" => "rgba($color,2)");
					$sort[$key] = strtotime($dt['TANGGAL']);
				}
			}
			$cek = count($opco);
			if ($cek > 0) {
				array_multisort($sort, SORT_DESC, $opco);
			}
			//var_dump($opco); die();
			$lay['autosize'] = false;
			$lay['yaxis'] 	 = array(
								"tickfont" => array("color" => "rgb(107, 107, 107)", "size" => 11),
								"ticks" => "outside",
								"tickwidth" => 1,
								"title" => "HIT",
								"ticklen" => 5,
								"autorange" => true,
								"showticklabels" => true,
								"titlefont" => array("color" => "rgb(107, 107, 107)", "size" => 12),
								"mirror" => true,
								"zeroline" => true,
								"showline" => true,
							);
			$lay["title"] = "ACCESS LOG STATISTIC ON ".strtoupper(date("F Y"));
			$lay["height"] = 400;
			$lay["width"] = 800;
			$lay["bargap"] = 0.25;
			$lay['xaxis'] 	 = array(
								"tickfont" => array("color" => "", "size" => 8),
								"ticks" => "outside",
								"tickwidth" => 1,
								"tickangle" => 40,
								"ticklen" => 5,
								"showticklabels" => true,
								"mirror" => true,
								"showline" => true
							);
			$lay['barmode'] = "group";
			$lay['margin'] = array("r" => 60, "b" => 60, "l" => 60, "t" => 80);

			$data['data'] 	= ($cek > 0) ? array_values($res): $res;
			$data['layout'] = $lay;
			to_json($data);
		}
	}
}

?>
