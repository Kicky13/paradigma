<?php
class Tools
{
    function exportdata($table,$title,$desc,$namafile,$folderpath='')
    {
        $CI=& get_instance();
        $CI->load->library('phpexcel');
        $CI->load->database();
        $CI->load->library('PHPExcel/iofactory');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle($title)
                         ->setDescription($desc);
        $objPHPExcel->setActiveSheetIndex(0);
        
        $space=0;
        $space+=1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$space,$title);
        $space+=1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$space,$desc);
        $fields = $CI->db->list_fields($table);
        $countfield=count($fields)-1;
        $space+=2;
        $col=-1;
        for($colC=0;$colC<=$countfield;$colC++)
        {
            $col+=1;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$space,$fields[$colC]);
        }
        
        
        $result=$CI->db->get($table);
        $dataarray=array();
        $space+=1;
        foreach($result->result() as $row)
        {
            $dcol=-1;
            $dataarray=$row;
            foreach($dataarray as $row2)
            {
                $dcol+=1;                
            $objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($dcol,$space,$row2,PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $space+=1;
        }
        
        $col+=1;
        $space+=1;
                
        $filename=$namafile.'.xls';
        if($folderpath!="")
        {
            
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save($folderpath.'/'.$filename);
        }else{
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
                    
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
        
    }
    function importdata($file,$table,$startRow,$checkPrimary=FALSE,$preview)
    {
        $CI=& get_instance();
        $CI->load->database();
        $CI->load->library('PHPExcel');
        $CI->load->library('PHPExcel/IOFactory');
        $objPHPExcel = new PHPExcel();
        try{
            $inputFileType = IOFactory::identify($file);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($file);
        } catch (Exception $ex) {
            die("Tidak dapat mengakses file ".$ex->getMessage());
        }
        
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $awal=0;
        $tbl=0;
        $ret='';
        $isi=array();
        for ($row = $startRow-1; $row <= $highestRow; $row++){
            $awal++;
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
            $startCol=0;
            if($checkPrimary==TRUE)
            {
                $startCol=0;
            }else{
                $startCol=1;
            }
                    
            //$fields = $CI->db->list_fields($table);
            //$countfield=count($fields)-1;
            $countfield=7;
            
            $datacol = array('KODE','DESCRIPTION','GROUP','COMPANY','TAHUN','PERIODE_LALU','PERIODE_SEKARANG','CHG','SEMESTER');
            $dataxl1 = array();
            $dataxl=array();
            $colXl=-1;
            for($col=$startCol;$col<=$countfield;$col++)
            {
                $colXl+=1;                
                $dataxl[]=$rowData[0][$colXl];
                if ($rowData[0][0]=='KODE') {
                    $awal=0;
                }
            }

            if ($awal==1) {
                $tbl++;
                $isi[$tbl][]=$dataxl;
            } else {$isi[$tbl][]=$dataxl;}
            
            //For insert to table
            //$CI->db->insert($table,$data);
                        
        }

        $tahun = 0;
        foreach ($isi as $key => $value) {
            $awal=0;
            foreach ($value as $i) {
                $awal++;
                $dataxl1 = array();
                if ($awal==1) {
                    $ret .= '<table class="table table-hover"><thead>';
                    for ($i1=0; $i1 < $countfield; $i1++) { 
                        $ret.='<th style="text-align: center;">'.$i[$i1].'</th>';
                    }
                    $ret.="</thead><tbody>";
                } else {
                    $ret.='<tr>';
                        $ret.='<td style="text-align:left">'.$i[$i2].'</td>';
                    $ret.='</tr>';
                }
                if (count($dataxl1)>0) {
                    if ($dataxl1[0]>0) {
                        if ($preview==false) {
                            $data=array_combine($datacol,$dataxl1);

                            $CI->db->select ( 'count(KODE) as jml' )
                                ->from ( 'PEER_COMPARISON' );
                            $CI->db->where(array('TAHUN'=>$tahun,
                                                'KODE'=>$dataxl1[0]));
                            $query = $CI->db->get();
                            $duplicate = $query->result();
                            if ($duplicate[0]->jml>0) {
                                $CI->db->where(Array("KODE"=>$dataxl1[0],"TAHUN"=>$tahun));
                                $CI->db->update($table,$data);
                            } else $CI->db->insert($table,$data);
                                
                        }
                    }                    
                }
            }
            
        }
        return $ret;
    }        
}
?>