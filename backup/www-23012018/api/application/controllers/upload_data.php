<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_data extends CI_Controller {

	protected $path_upload = "";

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
	}

	public function index()
	{
		$this->load->view('upload/real_produksi');
	}

	 function _get_path_upload(){
        $tes = dirname(__FILE__);
        $pet_pat = str_replace('application/controllers/', '', $tes); 
        return $pet_pat;   
    }

    public function import_data_real_produksi()
    {
  
  		$paradigma = $this->load->database('default7',TRUE);

        $this->path_upload = $this->_get_path_upload() . "/model/" . basename($_FILES['file']['name']);
        error_reporting(E_ALL ^ E_NOTICE);
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
            $insert=0;
            $update=0;
            

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
                
                 $tanggal1 = date('Y-m-d',($rowData[0][5] - 25569) * 86400);
                 $tanggal = date('Y-m-d',strtotime($tanggal1));
                 if($rowData[0][2]=='Klinker'){
                 	$kode_produk=1;
                 }elseif ($rowData[0][2]=='Semen') {
                 	$kode_produk=2;	
                 }

                 if($rowData[0][1]=='RK21'||$rowData[0][1]=='RK31'||$rowData[0][1]=='FM22'||$rowData[0][1]=='FM32'){
                    $plant=4301;
                 }elseif ($rowData[0][1]=='RK41'||$rowData[0][1]=='F191'||$rowData[0][1]=='F201') {
                    $plant=4302;
                 }elseif ($rowData[0][1]=='RK51'||$rowData[0][1]=='FM51'||$rowData[0][1]=='FM52') {
                     $plant=4303;
                 }
                 // $jam_operasi=date('H:i:s',($rowData[0][6]/24));
                 $jam_operasi=PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][6], 'hh:mm:ss');

                $paradigma->where(array('ORG' => $rowData[0][0],
										'PLANT' => $plant,
										'KODE_PRODUK' => $kode_produk,
										'YEAR' => $rowData[0][3],
										'MONTH' => $rowData[0][4],
										'TANGGAL' => $tanggal,
                                        'WORK_CENTER'=>$rowData[0][1]
                						));
                $cari=$paradigma->get('ZREPORT_REAL_PRODUK_ST');
                if($cari->num_rows>0){
                    $paradigma->where(array('ORG' => $rowData[0][0],
                                        'PLANT' => $rowData[0][1],
                                        'KODE_PRODUK' => $kode_produk,
                                        'YEAR' => $rowData[0][3],
                                        'MONTH' => $rowData[0][4],
                                        'TANGGAL' => $tanggal
                                        ));
                     $sql=$paradigma->update('ZREPORT_REAL_PRODUK_ST',array(
                                    
                                                                        'JAM_OPERASI' => $jam_operasi,
                                                                        'ACTUAL_PRODUK' => $rowData[0][7],
                                                                        'KAPASITAS' => $rowData[0][8],
                                                                        'UPDATE_DATE' => date('Y-m-d H:i:s')
                                                                    ));

                     $update++;

                }else{             
                $sql=$paradigma->insert('ZREPORT_REAL_PRODUK_ST',array(
								                						'ORG' => $rowData[0][0],
																		'PLANT' => $plant,
																		'KODE_PRODUK' => $kode_produk,
																		'YEAR' => $rowData[0][3],
																		'MONTH' => $rowData[0][4],
																		'TANGGAL' => $tanggal,
																		'JAM_OPERASI' => $jam_operasi,
																		'ACTUAL_PRODUK' => $rowData[0][7],
																		'KAPASITAS' => $rowData[0][8],
                                                                        'WORK_CENTER'=>$rowData[0][1],
																		'CREATED_DATE' => date('Y-m-d H:i:s')
                													));
                $insert++;
                
        }
    }
    	unlink($inputFileName);
        echo '<table><tr><td>Insert Data</td><td> : </td><td>'.$insert.'</td></tr><tr><td>Update Data</td><td> : </td><td>'.$update.'</td></tr>';
    }else{
       	echo 'gagal';
        	//echo 'gagal';
       }
    }



    public function import_data_rkap_produksi()
    {
    	$paradigma = $this->load->database('default7',TRUE);

        $this->path_upload = $this->_get_path_upload() . "/model/" . basename($_FILES['file']['name']);
        error_reporting(E_ALL ^ E_NOTICE);
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
            $insert=0;
            $update=0;
            

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
                
                 $tanggal1 = date('Y-m-d',($rowData[0][5] - 25569) * 86400);
                 $tanggal = date('Y-m-d',strtotime($tanggal1));
                 if($rowData[0][2]=='Klinker'){
                 	$kode_produk=1;
                 }elseif ($rowData[0][2]=='Semen') {
                 	$kode_produk=2;	
                 }

                 if($rowData[0][1]=='RK21'||$rowData[0][1]=='RK31'||$rowData[0][1]=='FM22'||$rowData[0][1]=='FM32'){
                    $plant=4301;
                 }elseif ($rowData[0][1]=='RK41'||$rowData[0][1]=='F191'||$rowData[0][1]=='F201') {
                    $plant=4302;
                 }elseif ($rowData[0][1]=='RK51'||$rowData[0][1]=='FM51'||$rowData[0][1]=='FM52') {
                     $plant=4303;
                 }
                 // $jam_operasi=date('H:i:s',($rowData[0][6]/24));
                 $jam_operasi=PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][6], 'hh:mm:ss');
                 

                $paradigma->where(array('ORG' => $rowData[0][0],
										'PLANT' => $plant,
										'KODE_PRODUK' => $kode_produk,
										'YEAR' => $rowData[0][3],
										'MONTH' => $rowData[0][4],
										'TANGGAL' => $tanggal,
                                        'WORK_CENTER'=>$rowData[0][1]
                						));
                $cari=$paradigma->get('ZREPORT_RKAP_PRODUK_ST');
                if($cari->num_rows>0){
                    $paradigma->where(array('ORG' => $rowData[0][0],
                                        'PLANT' => $plant,
                                        'KODE_PRODUK' => $kode_produk,
                                        'YEAR' => $rowData[0][3],
                                        'MONTH' => $rowData[0][4],
                                        'TANGGAL' => $tanggal,
                                        'WORK_CENTER'=>$rowData[0][1]
                                        ));
                     $sql=$paradigma->update('ZREPORT_RKAP_PRODUK_ST',array(
                                        'JAM_OPERASI' => $jam_operasi,
                                        'RKAP' => $rowData[0][7],
                                        'PROGONOSE_PRODUK' => $rowData[0][8],
                                        'PRONGNOSE_STOCK' => $rowData[0][9],
                                        'MIN_STOCK' => $rowData[0][10],
                                        'MAX_STOCK' => $rowData[0][11],
                                        'KAPASITAS' => $rowData[0][12],
                                        'HARI_OPERASI' => $rowData[0][13],
                                        'UPDATE_DATE' => date('Y-m-d H:i:s')
                                    ));
                     $update++;
                }else{             
                $sql=$paradigma->insert('ZREPORT_RKAP_PRODUK_ST',array(
                						'ORG' => $rowData[0][0],
										'PLANT' => $plant,
										'KODE_PRODUK' => $kode_produk,
										'YEAR' => $rowData[0][3],
										'MONTH' => $rowData[0][4],
										'TANGGAL' => $tanggal,
										'JAM_OPERASI' => $jam_operasi,
										'RKAP' => $rowData[0][7],
										'PROGONOSE_PRODUK' => $rowData[0][8],
										'PRONGNOSE_STOCK' => $rowData[0][9],
										'MIN_STOCK' => $rowData[0][10],
										'MAX_STOCK' => $rowData[0][11],
                                        'KAPASITAS' => $rowData[0][12],
										'HARI_OPERASI' => $rowData[0][13],
                                        'WORK_CENTER'=>$rowData[0][1],
										'CREATED_DATE' => date('Y-m-d H:i:s')
                					));
                $insert++;
                
        }
    }
    	unlink($inputFileName);
        echo '<table><tr><td>Insert Data</td><td> : </td><td>'.$insert.'</td></tr><tr><td>Update Data</td><td> : </td><td>'.$update.'</td></tr>';
    }else{
       	echo 'gagal';
        	//echo 'gagal';
       }
    }


     public function import_data_rkap_sales()
    {
        $paradigma = $this->load->database('default7',TRUE);

        $this->path_upload = $this->_get_path_upload() . "/model/" . basename($_FILES['file']['name']);
        error_reporting(E_ALL ^ E_NOTICE);
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
            $insert=0;
            $update=0;
            

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
                
                 $tanggal1 = date('Y-m-d',($rowData[0][12] - 25569) * 86400);
                 $tanggal = date('Y-m-d',strtotime($tanggal1));
                 if($rowData[0][2]=='CLINKER'){
                    $kode_produk=1;
                 }elseif ($rowData[0][2]=='SEMEN') {
                    $kode_produk=2; 
                 }
                 // $jam_operasi=date('H:i:s',($rowData[0][6]/24));
                 // $jam_operasi=PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][6], 'hh:mm:ss');
                 

                $paradigma->where(array('OPCO' =>   $rowData[0][0],
                                        'WILAYAH' =>    $rowData[0][1],
                                        'DISTRIK' =>    $rowData[0][2],
                                        'PRODUK' => $rowData[0][3],
                                        'KEMASAN' =>    $rowData[0][4],
                                        'JENIS_PENJUALAN' =>    $rowData[0][5],
                                        'YEAR' =>   $rowData[0][6],
                                        'MONTH' =>  $rowData[0][7],
                                        'POSTING_DATE' =>   $tanggal,
                                        'INCOTERM' =>    $rowData[0][11],
                                        'OUTLET' =>   $rowData[0][10]
                                        ));
                $cari=$paradigma->get('ZREPORT_RKAP_SALES_ST');
                if($cari->num_rows>0){

                }else{             
                $sql=$paradigma->insert('ZREPORT_RKAP_SALES_ST',array(
                                        'OPCO' =>   $rowData[0][0],
                                        'WILAYAH' =>    $rowData[0][1],
                                        'PRODUK' => $rowData[0][3],
                                        'KEMASAN' =>    $rowData[0][4],
                                        'JENIS_PENJUALAN' =>    $rowData[0][5],
                                        'YEAR' =>   $rowData[0][6],
                                        'MONTH' =>  $rowData[0][7],
                                        'RKAP' =>   $rowData[0][8],
                                        'PROGNOSA' =>   $rowData[0][9],
                                        'OUTLET' => $rowData[0][10],
                                        'INCOTERM' =>   $rowData[0][11],
                                        'POSTING_DATE' =>   $tanggal,
                                        'CREATE_DATE' =>    date('Y-m-d H:i:s')
                                    ));
                $insert++;
                
        }
    }
        unlink($inputFileName);
        echo '<table><tr><td>Insert Data</td><td> : </td><td>'.$insert.'</td></tr><tr><td>Update Data</td><td> : </td><td>'.$update.'</td></tr>';
    }else{
        echo 'gagal';
            //echo 'gagal';
       }
    }

}

/* End of file upload_data.php */
/* Location: ./application/controllers/upload_data.php */