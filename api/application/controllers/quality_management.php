<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class quality_management extends CI_Controller {
	
	//SI RAMAH
	public $ASPEK;
	public $NILAI = array();
	public $CATATAN;	
	public $LIST_COMPANY;
	
	//QAF
	public $NM_PRODUCT;

	public function __construct(){
		parent::__construct();

		//SI RAMAH
		$this->load->model('M_company');
		$this->load->model('M_jenis_aspek');
		$this->load->model('M_indikator');
		$this->load->model('T_skoring_ramah');
		
		//QAF
		$this->load->model("qaf_daily");
		$this->load->model("m_plant");
		$this->load->model("c_range_qaf");
		$this->load->model("m_area");
		$this->load->model("m_product");

		//NCQR
		$this->load->model('m_qm');

	}
	
	//SI RAMAH
	private function load_nilai($aspek, $date){
		$com_id = array();
		$jaspek = array();
		$result = array();
		$load   = $this->T_skoring_ramah->get_nilai($aspek,$date);
		foreach ($load as $key => $value) {
			$load[$key]->CATATAN = $this->M_indikator->get_catatan($value->ID_BATASAN, $value->NILAI_SKORING)->CATATAN;
		}

		//Group by company
		foreach ($load as $data) {
			$id_com = $data->ID_COMPANY;
			if(isset($com_id[$id_com])){
				$com_id[$id_com][] = $data;
			}else{
				$com_id[$id_com] = array($data);
			}
		}

		//Group by jenis aspek
		foreach ($load as $data) {
			$aspekj = $data->ID_JENIS_ASPEK;
			if(isset($jaspek[$aspekj])){
				$jaspek[$aspekj][] = $data;
			}else{
				$jaspek[$aspekj] = array($data);
			}
		}

		$result['comp']		= $com_id;
		$result['jaspek']	= $jaspek;
		return $result;
	}
	
	public function global_report(){
		$result = array();
		$date = $this->input->get('date');
		$date = str_replace("-", "/", $date);
		$this->JENIS_ASPEK 		= $this->M_jenis_aspek->get_list();
		$this->LIST_COMPANY 	= $this->M_company->list_company($this->USER->ID_COMPANY);
		exit;
		$this->NILAI = $this->load_nilai('ALL', $date);
		foreach ($this->LIST_COMPANY as $company) {
			$data = array();
			$opco    = short_opco($company->KD_COMPANY);
			$nilai   = empty($this->NILAI['comp']) ? array(0):$this->NILAI['comp'][$company->ID_COMPANY];
			$vSCORE  = ARRAY();
			$catatan = "";
			foreach ($this->JENIS_ASPEK as $aspek) {
			  $vSCORE[$aspek->ID_JENIS_ASPEK][BOBOT] = $aspek->BOBOT;
			  $vSCORE[$aspek->ID_JENIS_ASPEK][SCORE] = 0;
			  $vSCORE[$aspek->ID_JENIS_ASPEK][ITEM] = 0;                
			  foreach ($nilai as $nl) {
				if ($nl->NILAI_SKORING <= 2) {
				  if (strpos($catatan, $nl->CATATAN)===FALSE) {
					# code...
					$catatan .= (!empty($nl->CATATAN)) ? "<li>" . $nl->CATATAN . "</li>" : "";
				  }
				}

				if ($aspek->ID_JENIS_ASPEK==$nl->ID_JENIS_ASPEK) {
				  $vSCORE[$aspek->ID_JENIS_ASPEK][SCORE]  +=  $nl->NILAI_SKORING;
				  $vSCORE[$aspek->ID_JENIS_ASPEK][ITEM]   +=  1;
				}
			  }
			}
			$total = 0;
			foreach($vSCORE as $r){
			  @$total += ($r[SCORE] / (5*$r[ITEM]) * $r[BOBOT]);
			}

			$total = is_nan($total)?0:number_format($total, 2, ".", ".");
			
			$color = "#";
				
			if($total < 70 ) $color = "#FF0000";
			if($total >= 70 && $total < 85) $color = "#0000FF"; 
			if($total >= 85 && $total < 90) $color = "#00CC00"; 
			if($total >= 90) $color = "#FFC000";
			
			$data['opco'] = $opco;
			$data['total'] = $total;
			$data['catatan'] = $catatan;
			$data['color'] = $color;
			$result[]= $data;
			
		}
		print_r(json_encode($result));
	}
	
	public function report_score(){
		$date = $this->input->get('date');
		$date = str_replace("-", "/", $date);
		$this->JENIS_ASPEK 		= $this->M_jenis_aspek->get_list();
		$this->LIST_COMPANY 	= $this->M_company->list_company($this->USER->ID_COMPANY);
		$this->NILAI = $this->load_nilai('ALL', $date);
		print_r(json_encode($this->NILAI));
	}
	//END SI RAMAH
	
	//QAF
	public function get_area_by_group($ID_PLANT,$ID_GROUPAREA,$ID_PRODUCT){
		echo json_encode($this->qaf_daily->get_area_by_group($ID_PLANT,$ID_GROUPAREA,$ID_PRODUCT));
	}
	public function get_report_qaf(){
		$comp  = $this->input->get('company');
		$month = $this->input->get('month');
		$year  = $this->input->get('year');
		$prod  = $this->input->get('product');
		$this->load->model("m_plant");
		$this->load->model("c_range_qaf");
		$data_plant = $this->list_plant = $this->m_plant->datalist($comp);
		$data=array();
		if($prod=='cement'){
			foreach($data_plant as $plant){
				$products = $this->c_range_qaf->list_configured_product_qaf($plant->ID_PLANT, '1');
				foreach($products as $product){
					$id_area = $this->qaf_daily->get_area_by_group($plant->ID_PLANT,1,$product[ID_PRODUCT]);
					foreach($id_area as $area){
						$postParam = Array ( 'MONTH' => $month, 'YEAR' => $year, 'ID_COMPANY' => $comp, 'ID_PRODUCT' => $product[ID_PRODUCT], 'ID_AREA' => $area->ID_AREA, 'ID_PLANT' => $plant->ID_PLANT, 'ID_GROUPAREA' => 1 );
						$this->list_qaf = $this->qaf_daily->report($postParam);
						$data[$plant->NM_PLANT][$product[KD_PRODUCT]][$area->ID_AREA] = $this->list_qaf;
					}
				}
			}
			$datax = array();
			foreach($data as $key => $row1){
				$dataxx = array();
				foreach($row1 as $key2 => $row2){
					$dataxxx = array();
					foreach($row2 as $key3 => $row3){
						$dataxxxx = array();
						foreach($row3 as $key4 => $row4){
							if(count($dataxxxx)>0){
								$dataxxxx[0]->PERSEN_QAF += ((float) $row4->PERSEN_QAF);
							}else{
								$row4->PERSEN_QAF = (float) $row4->PERSEN_QAF;
								$dataxxxx[]=$row4;
							}
						}
						if($dataxxxx[0]->PERSEN_QAF<1){
							$dataxxxx[0]->PERSEN_QAF = $dataxxxx[0]->PERSEN_QAF;
						}else{
							$dataxxxx[0]->PERSEN_QAF = round($dataxxxx[0]->PERSEN_QAF / count($row3), 2);
						}
						$dataxxx[]=array("id"=>$key3,"data"=>$dataxxxx);					
					}
					$dataxx[]=array("kode"=>$key2,"data"=>$dataxxx);
				}
				$datax[]=array("plant"=>$key,"data"=>$dataxx);
			}
			echo json_encode($datax);
		}else{
			$dataplant = array();
			foreach($data_plant as $plant){
				$id_area = $this->qaf_daily->get_area_by_group($plant->ID_PLANT,4);
				foreach($id_area as $area){
					$postParam = Array ( 'MONTH' => $month, 'YEAR' => $year, 'ID_COMPANY' => $comp, 'ID_AREA' => $area->ID_AREA, 'ID_PLANT' => $plant->ID_PLANT, 'ID_GROUPAREA' => 4 );
					$this->list_qaf = $this->qaf_daily->report_clinker($postParam);
					unset($datax);
					foreach($this->list_qaf as $k => $v){
						if(isset($datax)){
							$datax->PERSEN_QAF = (float) $datax->PERSEN_QAF + (float) $v->PERSEN_QAF;
						}else{
							$datax = $v;
						}
					}
					if($datax->PERSEN_QAF<1){
						$datax->PERSEN_QAF = $datax->PERSEN_QAF;
					}else{
						$datax->PERSEN_QAF = round($datax->PERSEN_QAF / count($this->list_qaf), 2);
					} 
					if(!in_array($plant,$dataplant)){
						$data[]= array("plant"=>$plant->NM_PLANT, "data"=>array($datax));
						$dataplant[]=$plant;
					}else{
						$data[array_search($plant, $dataplant)]['data'][] = $datax;
					}
				}
			}
			echo json_encode($data);
		}
	}
	//END QAF
	
	// NCQR
	public function ncqr(){
		$opco = $this->input->get('comp');
		$year = $this->input->get('year');

		$data['Total'] = $this->m_qm->avg_score_ncqr($year);
		$data['Trend'] = $this->m_qm->get_dashboard($opco, $year);
		echo json_encode($data);
	}



}

/* End of file Par4digma.php */
/* Location: ./application/controllers/Par4digma.php */
?>
