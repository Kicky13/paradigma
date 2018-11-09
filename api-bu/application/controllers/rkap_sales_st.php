<?php
header('Access-Control-Allow-Origin:*');
defined('BASEPATH') OR exit('No direct script access allowed');

class Rkap_sales_st extends CI_Controller {
        Protected $path_upload = "";
	public function __construct()
	{
		parent::__construct();
                $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->db=$this->load->database('tonasa',true);
                
	}
        
        
        public function upload() {
            $this->load->view('upload/v_upload_rkap_sales');
        }
        
        public function _get_path_upload(){
            $tes = dirname(__FILE__);
            $pet_pat = str_replace('application/controllers/', '', $tes); 
            return $pet_pat;   
        }
        
        
        public function upload_rkap_sales() {
            
        $insert=0;
        $update=0;
        $this->path_upload = $this->_get_path_upload()."/model/".basename($_FILES['file']['name']);
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
                if($rowData[0][1]=='Wilayah I'){
                    $wilayah=1;
                }elseif ($rowData[0][1]=='Wilayah II') {
                    $wilayah=2;
                }elseif ($rowData[0][1]=='Wilayah III') {
                    $wilayah=3;
                }elseif ($rowData[0][1]=='Domestik') {
                    $wilayah=4;
                }elseif ($rowData[0][1]=='Ekspor') {
                    $wilayah=5;
                }elseif ($rowData[0][1]=='ICS') {
                    $wilayah=6;
                }
                
                if($rowData[0][3]=='Cement'){
                    $produk=1;
                }elseif ($rowData[0][3]=='Clinker') {
                    $produk=2;
                }
                
                $tanggal1 = date('Y-m-d',($rowData[0][12] - 25569) * 86400);
                $tanggal = date('Y-m-d',strtotime($tanggal1));
                
                $this->db->where(array('OPCO'=>$rowData[0][0],
                                       'WILAYAH'=>$wilayah,
                                       'DISTRIK'=>$rowData[0][2],
                                       'PRODUK'=>$produk,
                                       'KEMASAN'=>$rowData[0][4],
                                       'JENIS_PENJUALAN'=>$rowData[0][5],
                                       'DATE'=>$rowData[0][6],
                                       'INCOTERM'=>$rowData[0][11],
                                       'DATE'=>$tanggal,
                                       'OUTLET'=>$rowData[0][10]
                                       ));
                $query=$this->db->get('RKAP_DAILY');
                if($query->num_rows()>0){
                $this->db->where(array('OPCO'=>$rowData[0][0],
                                       'WILAYAH'=>$wilayah,
                                       'DISTRIK'=>$rowData[0][2],
                                       'PRODUK'=>$produk,
                                       'KEMASAN'=>$rowData[0][4],
                                       'JENIS_PENJUALAN'=>$rowData[0][5],
                                       'DATE'=>$rowData[0][6],
                                       'INCOTERM'=>$rowData[0][11],
                                       'DATE'=>$tanggal,
                                       'OUTLET'=>$rowData[0][10]
                                       ));
                
                $sql=$this->db->update('RKAP_DAILY',array('RKAP'=>$rowData[0][8],
                                                          'PROGNOSA'=>$rowData[0][9]
                                                        ));
                 $update++;
                }else{
                $this->db->insert('RKAP_DAILY',array(  'OPCO'=>$rowData[0][0],
                                                            'WILAYAH'=>$wilayah,
                                                            'DISTRIK'=>$rowData[0][2],
                                                            'PRODUK'=>$produk,
                                                            'KEMASAN'=>$rowData[0][4],
                                                            'JENIS_PENJUALAN'=>$rowData[0][5],
                                                            'DATE'=>$rowData[0][6],
                                                            'INCOTERM'=>$rowData[0][11],
                                                            'DATE'=>$tanggal,
                                                            'OUTLET'=>$rowData[0][10],
                                                            'RKAP'=>$rowData[0][8],
                                                            'PROGNOSA'=>$rowData[0][9]
                                                        ));
                  $insert++;
                }
                
        	}
            unlink($inputFileName);
                echo  json_encode(array('status'=>true,'msg'=>'Insert :'.$insert.'<br> Update : '.$update));
            
                }
        else{
    		echo json_encode(array('status'=>false,'msg'=>'Gagal Import Data'));
            }
            
        }
        
        

	public function index()
	{
		$data=array();
		$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
		$tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
		$hari = (empty($_GET['hari']) ? date('d') : $_GET['hari']);
		$tanggal = $tahun.'-'.$bulan.'-31';
		$tanggal1 = $tahun.'-'.$bulan.'-01';
                
		//BULAN INI
		$sql=$this->db->query("
								SELECT
									OPCO,
									SUM(RKAP) AS RKAP,
									SUM(PROGNOSA) AS PROGNOSA
								FROM
									zreport_rkap_sales_st
								WHERE
									OPCO = 4000
								AND
									POSTING_DATE = '$tanggal'
								GROUP BY OPCO
			");
		foreach ($sql->result_array() as $row) {
				$data['month']['days']=array(
								'OPCO'=>$row['OPCO'],
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
		}

		//KEMASAN
		$kemasan=array('BAG','CURAH');
		foreach ($kemasan as $value) {
		$sql_kemasan=$this->db->query("
									SELECT
										OPCO,
										KEMASAN,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											OPCO = 4000
										AND
											KEMASAN = '$value'
										AND
											POSTING_DATE = '$tanggal'
			");
			foreach ($sql_kemasan->result_array() as $row) {
				$data['month']['kemasan'][$row['KEMASAN']]=array(
								'OPCO'=>$row['OPCO'],
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
			}
		}

		//JENIS
		$jenis=array('DOMESTIK','EXPORT','ICS');
		foreach ($jenis as $value) {
		$sql_jenis=$this->db->query("
									SELECT
										OPCO,
										PRODUK,
										JENIS_PENJUALAN,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											OPCO = 4000
										AND
											JENIS_PENJUALAN = '$value'
										AND
											POSTING_DATE = '$tanggal'
			");
			foreach ($sql_jenis->result_array() as $row) {
				$data['month']['jenis'][$row['JENIS_PENJUALAN']]=array(
								'OPCO'=>$row['OPCO'],
								'PRODUK'=>$row['PRODUK'],
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
			}
		}


		//WILAYAH
		$wilayah=array('WILAYAH I','WILAYAH II','WILAYAH III');
		foreach ($wilayah as $value) {
		$sql_wilayah=$this->db->query("
									SELECT
										OPCO,
										PRODUK,
										WILAYAH,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											OPCO = 4000
										AND
											WILAYAH = '$value'
										AND
											POSTING_DATE = '$tanggal'
			");
			foreach ($sql_wilayah->result_array() as $row) {
				$data['month']['wilayah'][$row['WILAYAH']]=array(
								'OPCO'=>$row['OPCO'],
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
			}
		}

		//inctorm
		$incoterm=array('FOB','FOT','CIF','FRANCO');
		foreach ($incoterm as $value) {
		$sql_incoterm=$this->db->query("
									SELECT
										OPCO,
										PRODUK,
										INCOTERM,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											OPCO = 4000
										AND
											INCOTERM = '$value'
										AND
											POSTING_DATE = '$tanggal'
			");
			foreach ($sql_incoterm->result_array() as $row) {
				$data['month']['incoterm'][$row['INCOTERM']]=array(
								'OPCO'=>$row['OPCO'],
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
			}
		}

		//UP BULAN
		$sql=$this->db->query("
								SELECT
									OPCO,
									SUM(RKAP) AS RKAP,
									SUM(PROGNOSA) AS PROGNOSA
								FROM
									zreport_rkap_sales_st
								WHERE
									OPCO = 4000
								AND
									POSTING_DATE BETWEEN '$tanggal1' AND '$tanggal'
								GROUP BY OPCO
			");
		foreach ($sql->result_array() as $row) {
				$data['up_month']['days']=array(
								'OPCO'=>$row['OPCO'],
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
		}

		//KEMASAN
		$kemasan=array('BAG','CURAH');
		foreach ($kemasan as $value) {
		$sql_kemasan=$this->db->query("
									SELECT
										OPCO,
										KEMASAN,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											OPCO = 4000
										AND
											KEMASAN = '$value'
										AND
											POSTING_DATE BETWEEN '$tanggal1' AND '$tanggal'
			");
			foreach ($sql_kemasan->result_array() as $row) {
				$data['up_month']['kemasan'][$row['KEMASAN']]=array(
								'OPCO'=>$row['OPCO'],
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
			}
		}

		//JENIS
		$jenis=array('DOMESTIK','EXPORT','ICS');
		foreach ($jenis as $value) {
		$sql_jenis=$this->db->query("
									SELECT
										OPCO,
										PRODUK,
										JENIS_PENJUALAN,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											OPCO = 4000
										AND
											JENIS_PENJUALAN = '$value'
										AND
											POSTING_DATE BETWEEN '$tanggal1' AND '$tanggal'
			");
			foreach ($sql_jenis->result_array() as $row) {
				$data['up_month']['jenis'][$row['JENIS_PENJUALAN']]=array(
								'OPCO'=>$row['OPCO'],
								'PRODUK'=>$row['PRODUK'],
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
			}
		}


		//WILAYAH
		$wilayah=array('WILAYAH I','WILAYAH II','WILAYAH III');
		foreach ($wilayah as $value) {
		$sql_wilayah=$this->db->query("
									SELECT
										OPCO,
										PRODUK,
										WILAYAH,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											OPCO = 4000
										AND
											WILAYAH = '$value'
										AND
											POSTING_DATE BETWEEN '$tanggal1' AND '$tanggal'
			");
			foreach ($sql_wilayah->result_array() as $row) {
				$data['up_month']['wilayah'][$row['WILAYAH']]=array(
								'OPCO'=>$row['OPCO'],
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
			}
		}

		//inctorm
		$incoterm=array('FOB','FOT','CIF','FRC');
		foreach ($incoterm as $value) {
		$sql_incoterm=$this->db->query("
									SELECT
										OPCO,
										PRODUK,
										INCOTERM,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											OPCO = 4000
										AND
											INCOTERM = '$value'
										AND
											POSTING_DATE BETWEEN '$tanggal1' AND '$tanggal'
			");
			foreach ($sql_incoterm->result_array() as $row) {
				$data['up_month']['incoterm'][$row['INCOTERM']]=array(
								'OPCO'=>$row['OPCO'],
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
			}
		}

		//ALL
		$sql_all = $this->db->query("
										SELECT
											POSTING_DATE,
											SUM(RKAP) AS RKAP,
											SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											POSTING_DATE BETWEEN '$tanggal1' AND '$tanggal'
		");
		foreach ($sql_all->result_array() as $row) { 
			$data['up_month']['total']=array(
										'RKAP'=>$row['RKAP'],
										'PROGNOSA'=>$row['PROGNOSA']
										);
		}

		echo json_encode($data);

	}

	public function chart()
	{
		$data=array();
		$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
		$tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
		$hari = (empty($_GET['hari']) ? date('d') : $_GET['hari']);
		$tanggal = $tahun.'-'.$bulan.'-31';
		$tanggal1 = $tahun.'-'.$bulan.'-01';

		//KEMASAN
		$kemasan=array('BAG','CURAH');
		foreach ($kemasan as $value) {
			$sql_kemasan=$this->db->query("
									SELECT
										OPCO,
										KEMASAN,
										POSTING_DATE,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
									FROM
										zreport_rkap_sales_st
									WHERE
										OPCO = 4000
									AND KEMASAN = '$value'
									AND POSTING_DATE BETWEEN '$tanggal1' AND '$tanggal'
									GROUP BY POSTING_DATE
			");
			foreach ($sql_kemasan->result_array() as $row) {
				$data['daily']['kemasan'][date('j',strtotime($row['POSTING_DATE']))][$row['KEMASAN']]=array(
					'RKAP'=>$row['RKAP'],
					'PROGNOSA'=>$row['PROGNOSA']
				);
			}
		}

		//JENIS
		$jenis=array('DOMESTIK','EXPORT','ICS');
		foreach ($jenis as $value) {
		$sql_jenis=$this->db->query("
									SELECT
										OPCO,
										PRODUK,
										JENIS_PENJUALAN,
										POSTING_DATE,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											OPCO = 4000
										AND
											JENIS_PENJUALAN = '$value'
										AND
											POSTING_DATE BETWEEN '$tanggal1' AND '$tanggal'
										GROUP BY POSTING_DATE
			");
			foreach ($sql_jenis->result_array() as $row) {
				$data['daily']['jenis'][date('j',strtotime($row['POSTING_DATE']))][$row['JENIS_PENJUALAN']]=array(
								'PRODUK'=>$row['PRODUK'],
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
			}
		}

		
		//WILAYAH
		$wilayah=array('WILAYAH I','WILAYAH II','WILAYAH III');
		foreach ($wilayah as $value) {
		$sql_wilayah=$this->db->query("
									SELECT
										OPCO,
										PRODUK,
										WILAYAH,
										POSTING_DATE,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											OPCO = 4000
										AND
											WILAYAH = '$value'
										AND
											POSTING_DATE BETWEEN '$tanggal1' AND '$tanggal'
			");
			foreach ($sql_wilayah->result_array() as $row) {
				$data['daily']['wilayah'][date('j',strtotime($row['POSTING_DATE']))][$row['WILAYAH']]=array(
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
			}
		}

		
		//inctorm
		$incoterm=array('FOB','FOT','CIF','FRC');
		foreach ($incoterm as $value) {
		$sql_incoterm=$this->db->query("
									SELECT
										OPCO,
										PRODUK,
										INCOTERM,
										POSTING_DATE,
										SUM(RKAP) AS RKAP,
										SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											OPCO = 4000
										AND
											INCOTERM = '$value'
										AND
											POSTING_DATE BETWEEN '$tanggal1' AND '$tanggal'
			");
			foreach ($sql_incoterm->result_array() as $row) {
				$data['daily']['incoterm'][date('j',strtotime($row['POSTING_DATE']))][$row['INCOTERM']]=array(
								'RKAP'=>$row['RKAP'],
								'PROGNOSA'=>$row['PROGNOSA']
					);
			}
		}
		
		
		//ALL
		$sql_all = $this->db->query("
										SELECT
											POSTING_DATE,
											SUM(RKAP) AS RKAP,
											SUM(PROGNOSA) AS PROGNOSA
										FROM
											zreport_rkap_sales_st
										WHERE
											POSTING_DATE LIKE '$tahun-$bulan%'
										GROUP BY
											POSTING_DATE
										ORDER BY
											POSTING_DATE
		");
		foreach ($sql_all->result_array() as $row) { 
			$data['daily']['all'][][date('j',strtotime($row['POSTING_DATE']))]=array(
													'RKAP'=>$row['RKAP'],
													'PROGNOSA'=>$row['PROGNOSA']
													);
		}
		
		echo json_encode($data);

	}
}

/* End of file rkap_sales_st.php */
/* Location: ./application/controllers/rkap_sales_st.php */