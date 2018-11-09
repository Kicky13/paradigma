<?php
header('Access-Control-Allow-Origin:*');
date_default_timezone_set('Asia/Ujung_Pandang');
defined('BASEPATH') OR exit('No direct script access allowed');
class Cost_sheet_st extends CI_Controller {
	protected $path_upload = "";
	public function __construct()
	{
		parent::__construct();
		$this->db=$this->load->database('tonasa1',true);
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
	}

	public function index()
	{
		$year 		= (empty($_GET['tahun'])) ? date('Y') : $_GET['tahun'] ;
		$periode 	= (empty($_GET['bulan'])) ? date('m') : $_GET['bulan'] ;
		$year_prev 	= $year-1;

		//total
		$total 			= $this->db->query("SELECT SUM(RKAP_QTY) AS RKAP_QTY,SUM(REAL_QTY) AS REAL_QTY FROM CS_DETAIL WHERE OPCO =4000 AND YEAR = $year AND PERIODE = $periode GROUP BY YEAR")->row();
		$total_prev		= $this->db->query("SELECT SUM(RKAP_QTY) AS RKAP_QTY,SUM(REAL_QTY) AS REAL_QTY FROM CS_DETAIL WHERE OPCO =4000 AND YEAR = $year_prev  AND PERIODE = $periode GROUP BY YEAR");

		if ($total_prev->num_rows>0) {
			$total_prev->row();
			$tot_prev=$total_prev->REAL_QTY;
		} else {
			$tot_prev=0;
		}

			$rkap_qty = (is_null($total->RKAP_QTY)) ? 0  : $total->RKAP_QTY ;
		
		$data['TOTAL'] 	= array('REAL'=>$total->REAL_QTY,'RKAP'=>$rkap_qty,'REAL_PREV'=>$tot_prev);

		//expenses variable
		$total_rpton 	= 0;
		$total_value 	= 0;

		$variable   	= $this->db->query("SELECT EXPENSE_DESC,SUM(REAL_VALUE) AS REAL_VALUE,SUM(REAL_RPTON) AS REAL_RPTON FROM CS_DETAIL WHERE OPCO = 4000 AND YEAR = $year AND PERIODE = $periode AND EXPENSE_DESC IN ('Transfer Other Plant/Material','Bahan Bakar','Bahan Baku','Bahan Penolong','Kemasan','Listrik','Peniagaan') GROUP BY EXPENSE_DESC");
		
		foreach ($variable->result_array() as $row) {

			$total_value += $row['REAL_VALUE'];
			$total_rpton += $row['REAL_RPTON'];

			$data['VARIABLE'][]=array( 	'EXPENSE_DESC' 	=> $row['EXPENSE_DESC'],
										'REAL_VALUE'	=> $row['REAL_VALUE'],
										'RP' 			=> 0,
										'REAL_RPTON' 	=> $row['REAL_RPTON'],
									);
		}

		$data['VARIABLE'][]=array(	'EXPENSE_DESC' 	=> 'Total Variable',
									'TOTAL_VALUE' 	=> $total_value,
									'RP' 			=> 0,
									'TOTAL_RPTON' 	=> $total_rpton
								);

		//expanse fixed
		$total_value_fixed	= 0;
		$total_rpton_fixed 	= 0;
		$fixed				= $this->db->query("SELECT EXPENSE_DESC,SUM(REAL_VALUE) AS REAL_VALUE,SUM(REAL_RPTON) AS REAL_RPTON FROM CS_DETAIL WHERE OPCO =4000 AND YEAR = '$year' AND PERIODE = $periode AND EXPENSE_DESC IN ('Kapitalisasi Asset','Pajak Asuransi','Pemeliharaan','Tenaga Kerja','Urusan Umum Adm.') GROUP BY EXPENSE_DESC");
		
		foreach ($fixed->result_array() as $row) {

			$total_value_fixed	+= $row['REAL_VALUE'];
			$total_rpton_fixed 	+= $row['REAL_RPTON'];

			$data['FIXED'][]=array( 	'EXPENSE_DESC' 	=> $row['EXPENSE_DESC'],
										'REAL_VALUE'	=> $row['REAL_VALUE'],
										'RP' 			=> 0,
										'REAL_RPTON' 	=> $row['REAL_RPTON'],
									);
		}

			$data["FIXED"][]=array(		'EXPENSE_DESC' 	=> 'Total Fixed',
										'TOTAL_VALUE' 	=> $total_value_fixed,
										'RP' 			=> 0,
										'TOTAL_RPTON' 	=> $total_rpton_fixed
									);
		echo json_encode($data);
	}

	public function upload()
	{
		$this->load->view('upload/v_upload_costsheet_st');
	}

	public function _get_path_upload(){
        $tes = dirname(__FILE__);
        $pet_pat = str_replace('application/controllers/', '', $tes); 
        return $pet_pat;   
    }


	public function upload_costsheet()
	{
		$bulan=$this->input->post('bulan');
		$tahun=$this->input->post('tahun');
		$this->path_upload = $this->_get_path_upload()."/model/".basename($_FILES['file']['name']);
        // error_reporting(E_ALL ^ E_NOTICE);
        $file = $_FILES['file']['tmp_name'];
        if (move_uploaded_file($file, $this->path_upload))
        {

        	$inputFileName = $this->path_upload;
         
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            } 

            //CS_HEADER
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][0]==""){
                    continue;
            	}

            	$opco			= $rowData[0][0];
            	$year			= $rowData[0][1];
            	$periode		= $rowData[0][2];
            	$plant			= $rowData[0][3];
            	$work_center	= $rowData[0][4];
            	$material		= $rowData[0][5];
            	$material_desc	= $rowData[0][6];
            	$rkap_qty		= $rowData[0][7];
            	$real_qty		= $rowData[0][8];

            	$search=array(	'OPCO'			=> $opco,
            					'YEAR'			=> $year,
            					'PERIODE'		=> $periode,
            					'PLANT'			=> $plant,
            					'WORK_CENTER'	=> $work_center,
            					'MATERIAL'		=> $material
            				);
            	$insert_data=array(	'OPCO'			=> $opco,
            						'YEAR'			=> $year,
            						'PERIODE'		=> $periode,
            						'PLANT'			=> $plant,
            						'WORK_CENTER'	=> $work_center,
            						'MATERIAL'		=> $material,
            						'MATERIAL_DESC'	=> $material_desc,
            						'RKAP_QTY'		=> $rkap_qty,
            						'REAL_QTY'		=> $real_qty
            					);
            	$update_data=array('RKAP_QTY'=>$rkap_qty,'REAL_QTY'=>$real_qty);

            	$this->db->where($search);
				$cek=$this->db->get('CS_HEADER');
				if ($cek->num_rows()>0) {
					$this->db->where($search);
					$this->db->update('CS_HEADER', $update_data);
				} else {
					$this->db->insert('CS_HEADER', $insert_data);
				}
            }

            //CS_DETAIL
            $sheet = $objPHPExcel->getSheet(1);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][0]==""){
                    continue;
            	}

            	$opco			= $rowData[0][0];
				$year			= $rowData[0][1];
				$periode		= $rowData[0][2];
				$plant			= $rowData[0][3];
				$work_center	= $rowData[0][4];
				$material		= $rowData[0][5];
				$material_desc	= $rowData[0][6];
				$expense_type	= $rowData[0][7];
				$expense		= $rowData[0][8];
				$expense_desc	= $rowData[0][9];
				$yoy_real_qty	= $rowData[0][10];
				$yoy_real_value	= $rowData[0][11];
				$yoy_real_rpton	= $rowData[0][12];
				$rkap_qty		= $rowData[0][13];
				$rkap_value		= $rowData[0][14];
				$rkap_rpton		= $rowData[0][15];
				$real_qty		= $rowData[0][16];
				$real_value		= $rowData[0][17];
				$real_rpton		= $rowData[0][18];

            	$search_detail=array(	'OPCO'			 =>	$opco,
										'YEAR'			 =>	$year,
										'PERIODE'		 =>	$periode,
										'PLANT' 		 =>	$plant,
										'WORK_CENTER'	 =>	$work_center,
										'MATERIAL' 		 =>	$material,
										'MATERIAL_DESC'  =>	$material_desc,
										'EXPENSE_TYPE' 	 =>	$expense_type,
										'EXPENSE'		 =>	$expense,
										'EXPENSE_DESC'	 =>	$expense_desc
            				);
            	$insert_detail=array(	'OPCO' 			=>	$opco,
										'YEAR'			=>	$year,
										'PERIODE' 		=>	$periode,
										'PLANT' 		=>	$plant,
										'WORK_CENTER' 	=>	$work_center,
										'MATERIAL' 		=>	$material,
										'MATERIAL_DESC' =>	$material_desc,
										'EXPENSE_TYPE' 	=>	$expense_type,
										'EXPENSE' 		=>	$expense,
										'EXPENSE_DESC' 	=>	$expense_desc,
										'YOY_REAL_QTY' 	=>	$yoy_real_qty,
										'YOY_REAL_VALUE'=>	$yoy_real_value,
										'YOY_REAL_RPTON'=>	$yoy_real_rpton,
										'RKAP_QTY' 		=>	$rkap_qty,
										'RKAP_VALUE' 	=>	$rkap_value,
										'RKAP_RPTON' 	=>	$rkap_rpton,
										'REAL_QTY' 		=>	$real_qty,
										'REAL_VALUE'	=>	$real_value,
										'REAL_RPTON' 	=>	$real_rpton
            					);
            	$update_detail=array( 	'YOY_REAL_QTY' 	=>	$yoy_real_qty,
										'YOY_REAL_VALUE'=>	$yoy_real_value,
										'YOY_REAL_RPTON'=>	$yoy_real_rpton,
										'RKAP_QTY' 		=>	$rkap_qty,
										'RKAP_VALUE' 	=>	$rkap_value,
										'RKAP_RPTON' 	=>	$rkap_rpton,
										'REAL_QTY' 		=>	$real_qty,
										'REAL_VALUE'	=>	$real_value,
										'REAL_RPTON' 	=>	$real_rpton
								);

            	$this->db->where($search);
				$cek=$this->db->get('CS_HEADER');
				if ($cek->num_rows()>0) {
					$this->db->where($search_detail);
					$this->db->update('CS_DETAIL', $update_detail);
				} else {
					$this->db->insert('CS_DETAIL', $insert_detail);
				}
            }
        }
	}

}

/* End of file cash_flow_st.php */
/* Location: ./application/controllers/cash_flow_st.php */