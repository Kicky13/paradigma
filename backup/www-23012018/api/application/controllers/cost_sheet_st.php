<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cost_sheet_st extends CI_Controller {
    protected $path_upload = "";
    public function __construct()
    {
      parent::__construct();
      $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
//      $this->db=$this->load->database('tonasa1',true);
      $this->db=$this->load->database('default7',true);
    }
    
    public function index() {
        $cs_header= $this->db->query("SELECT SUM(REAL_QTY) AS REALISASI,SUM(RKAP_QTY) AS RKAP FROM CS_HEADER WHERE YEAR = 2017 AND PERIODE = 9")->row();
        $data['CS_HEADER'][]=array('REAL'=>$cs_header->REALISASI,'RKAP'=>$cs_header->RKAP);
        echo json_encode($data);
    }   
 
    public function _get_path_upload(){
        $tes = dirname(__FILE__);
        $pet_pat = str_replace('application/controllers/', '', $tes); 
        return $pet_pat;   
    }

    public function upload()   {
        $this->load->view('upload/v_upload_costsheet');
    }
    
    public function upload_costsheet() {
        $insert=0;
        $update=0;
        $insert_header=0;
        $update_header=0;
        $this->path_upload = $this->_get_path_upload() . "/model/" . basename($_FILES['file']['name']);
        error_reporting(E_ALL ^ E_NOTICE);
        $file = $_FILES['file']['tmp_name'];
        if (move_uploaded_file($file, $this->path_upload)){
             
         $inputFileName = $this->path_upload;
         
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            } 
            
            //cost sheet detail
            $sheet = $objPHPExcel->getSheet(1);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 3; $row <= $highestRow; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][7]=="") {
                    continue;
                }

                if ($rowData[0][0]!="") {
                    $year = $rowData[0][0];
                }

                if ($rowData[0][1]!="") {
                    $period = $rowData[0][1];
                }

                if ($rowData[0][2]!="") {
                    $opco = $rowData[0][2]; 
                }
                
                if ($rowData[0][4]!="") {
                    $work_center = $rowData[0][4]; 
                }
                
                if ($rowData[0][3]!="") {
                    $plant = $rowData[0][3]; 
                }
                
                if ($rowData[0][5]!="") {
                    $material = $rowData[0][5]; 
                }
                
                if ($rowData[0][6]!="") {
                    $material_desc = $rowData[0][6]; 
                }
                
//                $this->db->where(array('OPCO' => $opco,
//                                         'YEAR' => $year,
//                                         'PERIODE' =>$period,
//                                         'MATERIAL' => $material,
//                                         'WORK_CENTER' => $work_center,
//                                         'PLANT' => $plant,
//                                         'MATERIAL_DESC' => $material_desc));
//                $cari= $this->db->get('CS_DETAIL');
//                if($cari->num_rows()>0){
//                    $this->db->where(array('OPCO' => $opco,
//                                         'YEAR' => $year,
//                                         'PERIODE' =>$period,
//                                         'MATERIAL' => $material,
//                                         'WORK_CENTER' => $work_center,
//                                         'PLANT' => $plant,
//                                         'MATERIAL_DESC' => $material_desc));
//                    $sql=$this->db->update('CS_DETAIL', array(
//                                         'EXPENSE_TYPE' => $rowData[0][7],
//                                         'EXPENSE'=>$rowData[0][8],
//                                         'EXPENSE_DESC'=>$rowData[0][9],
//                                         'YOY_REAL_QTY'=>$rowData[0][10],
//                                         'YOY_REAL_VALUE'=>$rowData[0][11],
//                                         'YOY_REAL_RPTON'=>$rowData[0][12],
//                                         'RKAP_QTY'=>$rowData[0][13],
//                                         'RKAP_VALUE'=>$rowData[0][14],
//                                         'RKAP_RPTON'=>$rowData[0][15],
//                                         'REAL_QTY'=>$rowData[0][16],
//                                         'REAL_VALUE'=>$rowData[0][17],
//                                         'REAL_RPTON'=>$rowData[0][18]
//                                        ));
//                   $update++;
                //}else{
                    
                $sql=$this->db->insert('CS_DETAIL', array('OPCO' => $opco,
                                         'YEAR' => $year,
                                         'PERIODE' =>$period,
                                         'MATERIAL' => $material,
                                         'WORK_CENTER' => $work_center,
                                         'PLANT' => $plant,
                                         'MATERIAL_DESC' => $material_desc,
                                         'EXPENSE_TYPE' => $rowData[0][7],
                                         'EXPENSE'=>$rowData[0][8],
                                         'EXPENSE_DESC'=>$rowData[0][9],
                                         'YOY_REAL_QTY'=>$rowData[0][10],
                                         'YOY_REAL_VALUE'=>$rowData[0][11],
                                         'YOY_REAL_RPTON'=>$rowData[0][12],
                                         'RKAP_QTY'=>$rowData[0][13],
                                         'RKAP_VALUE'=>$rowData[0][14],
                                         'RKAP_RPTON'=>$rowData[0][15],
                                         'REAL_QTY'=>$rowData[0][16],
                                         'REAL_VALUE'=>$rowData[0][17],
                                         'REAL_RPTON'=>$rowData[0][18]
                                        ));
                $insert++;
             //}
        }
        
        //cost_sheet header
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 3; $row <= $highestRow; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                
                $this->db->where(array('OPCO' => $rowData[0][2],
                                         'YEAR' => $rowData[0][0],
                                         'PERIODE' =>$rowData[0][1],
                                         'MATERIAL' => $rowData[0][5],
                                         'WORK_CENTER' => $rowData[0][4],
                                         'PLANT' => $rowData[0][3],
                                         'MATERIAL_DESC' => $rowData[0][6]));
                $cari= $this->db->get('CS_HEADER');
                if($cari->num_rows()>0){
                    $this->db->where(array('OPCO' => $rowData[0][2],
                                         'YEAR' => $rowData[0][0],
                                         'PERIODE' =>$rowData[0][1],
                                         'MATERIAL' => $rowData[0][5],
                                         'WORK_CENTER' => $rowData[0][4],
                                         'PLANT' => $rowData[0][3],
                                         'MATERIAL_DESC' => $rowData[0][6]));
                    $sql=$this->db->update('CS_HEADER', array(
                                         'RKAP_QTY' => $rowData[0][7],
                                         'REAL_QTY'=>$rowData[0][8]
                                        ));
                   $update_header++;
                }else{
                    
                $sql=$this->db->insert('CS_HEADER', array('OPCO' => $rowData[0][2],
                                         'YEAR' => $rowData[0][0],
                                         'PERIODE' =>$rowData[0][1],
                                         'MATERIAL' => $rowData[0][5],
                                         'WORK_CENTER' => $rowData[0][4],
                                         'PLANT' => $rowData[0][3],
                                         'MATERIAL_DESC' => $rowData[0][6],
                                         'RKAP_QTY' => $rowData[0][7],
                                         'REAL_QTY'=>$rowData[0][8]
                                        ));
                $insert_header++;
             }
                
            }
           unlink($inputFileName);
            echo json_encode(array('status'=>true,'msg'=>'CostSheet Header<br>Insert :'.$insert_header.'<br> Update : '.$update_header.'<br>CostSheet Detail<br>Insert :'.$insert.'<br> Update : '.$update));
    }else{
            echo json_encode(array('status'=>false,'msg'=>'Gagal Import Data'));
        }
    }

}

