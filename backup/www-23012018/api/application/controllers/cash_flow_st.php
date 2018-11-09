<?php
header('Access-Control-Allow-Origin:*');
date_default_timezone_set('Asia/Ujung_Pandang');
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_flow_st extends CI_Controller {
	protected $path_upload = "";
	public function __construct()
	{
		parent::__construct();
		$this->db=$this->load->database('default7',true);
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
	}

	public function index()
	{
	$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $hari = (empty($_GET['hari']) ? date('d') : $_GET['hari']);

        $bulan_sekarang=$tahun.'-'.$bulan;
     	if($bulan==date('m')){
     		 $cek_data=$this->db->query("SELECT
										*
										FROM
											CF_DAILY
										WHERE NILAI <> 0")->row();
     		// $tanggal=date('Y-m-d',strtotime($cek_data->DATE);
     	}else{
     		$cek_data=$this->db->query("SELECT
										*
										FROM
											CF_DAILY
										WHERE NILAI <> 0 AND TO_CHAR('date','yyyy-mm') = '".$bulan_sekarang."'")->row();
     	}

     	$tanggal=date('Y-m-d',strtotime($cek_data->DATE));
        $tanggal1=$this->db->query("SELECT * FROM TIME_UPLOAD")->row();
				$saldo=$this->db->query("SELECT SUM(NILAI) FROM CF_ENDING_BALANCE WHERE TO_CHAR('DATE','yyyy-mm-dd') = '$tanggal'")->row();

		$begin_balance=$this->db->query("SELECT MIN(NILAI) AS NILAI FROM CF_DAILY WHERE TO_CHAR('date','yyyy-mm')'".date('Y-m',strtotime($tanggal))."-01' AND KET = 'Saldo Awal'")->row();

		$in=$this->db->query("SELECT
									SUM(NILAI) AS NILAI
									FROM
										CF_DAILY
									WHERE
										KET IN ('- Hasil Penjualan','- Pendapatan Bunga','- Pendapatan Lain','- Kompensasi')
									AND
										TO_CHAR('date','yyyy-mm-dd') = '$tanggal'")->row();

		$out=$this->db->query("SELECT
										SUM(NILAI) AS NILAI
									FROM
										CF_DAILY
									WHERE
										KET IN ('  - Pembayaran ke Pemasok','  - Pembayaran ke Karyawan','  - Pembayaran Bunga & Beban Keuangan','  - Pajak (PPh)','  - Pajak (PPN)','  - SCF','  - Kompensasi','- Perolehan Aktiva tetap - Capex Rutin','- Perolehan Project CP & PP','- Pembayaran Pinjaman Jangka Panjang',' - Pembayaran hutang sewa pembiayaan','- Pembayaran Deviden')
									AND
										TO_CHAR('date','yyyy-mm-dd') = '$tanggal'")->row();

		$data[]=array( 'SALDO'=>$saldo->NILAI,
					   'BEGINING_BALANCE'=>$begin_balance->NILAI,
					   'CASHIN'=>$in->NILAI,
					   'CASHOUT'=>$out->NILAI,
					   'LAST_UPDATE'=>date('d/m/Y H:i',strtotime($tanggal1->tanggal))
						);

		echo json_encode($data);
	}

	public function saldo_harian()
	{	

	$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $hari = (empty($_GET['hari']) ? date('d') : $_GET['hari']);
        $bulan_sekarang=$tahun.'-'.$bulan;
     	// if($bulan==date('m')){
     	// 	$hari1=$hari;
     	// }else{
     	// 	$hari1 = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
     	// }
     	// $tanggal_awal=$tahun.'-'.$bulan.'-01'.
     	// $tanggal=$tahun.'-'.$bulan.'-26';

     	$bulan_sekarang=$tahun.'-'.$bulan;
     	if($bulan==date('m')){
     		 $cek_data=$this->db->query("SELECT
                                                *
						FROM
						CF_DAILY
						WHERE NILAI <> 0")->row();
     		// $tanggal=date('Y-m-d',strtotime($cek_data->DATE);
     	}else{
     		$cek_data=$this->db->query("SELECT
						*
						FROM
						CF_DAILY
						WHERE NILAI <> 0 AND TO_CHAR('date','yyyy-mm') = '".$bulan_sekarang."'")->row();
     	}

     	// $tanggal_awal=$tahun.'-'.$bulan.'-01';
     	// $tanggal=$tahun.'-'.$bulan.'-26';

     	$tanggal=date('Y-m-d',strtotime($cek_data->DATE));
		$data=[];
		$sql=$this->db->query("SELECT DATE,SUM(NILAI) AS NILAI FROM CF_ENDING_BALANCE WHERE TO_CHAR('date','mm')'".date('m',strtotime($tanggal))."' AND NILAI <> 0 GROUP BY DATE");

		foreach ($sql->result() as $row) {
			$data[]=array('NILAI'=>$row->NILAI);
		}

		echo json_encode($data);
	}

	public function average()
	{
		$data=[];
		$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $hari = (empty($_GET['hari']) ? date('d') : $_GET['hari']);

     	$bulan_sekarang=$tahun.'-'.$bulan;
     	if($bulan==date('m')){
     		 $cek_data=$this->db->query("SELECT
										*
										FROM
											CF_DAILY
										WHERE NILAI <> 0")->row();
     		// $tanggal=date('Y-m-d',strtotime($cek_data->DATE);
     	}else{
     		$cek_data=$this->db->query("SELECT
										*
										FROM
											CF_DAILY
										WHERE NILAI <> 0 AND TO_CHAR('date','yyyy-mm') = '".$bulan_sekarang."'")->row();
     	}

     	// $tanggal_awal=$tahun.'-'.$bulan.'-01';
     	// $tanggal=$tahun.'-'.$bulan.'-26';

     	$tanggal=date('Y-m-d',strtotime($cek_data->DATE));


            $in=$this->db->query("SELECT
                                                                            SUM(NILAI) AS NILAI
                                                                            FROM
                                                                                    CF_DAILY
                                                                            WHERE
                                                                                    KET IN ('- Hasil Penjualan','- Pendapatan Bunga','- Pendapatan Lain','- Kompensasi')
                                                                            AND
                                                                                    TO_CHAR('date','yyyy-mm')'".date('Y-m',strtotime($tanggal))."'
                                                                                    GROUP BY DATE");

		$out=$this->db->query("SELECT
									SUM(NILAI) AS NILAI
									FROM
										CF_DAILY
									WHERE
										KET IN ('  - Pembayaran ke Pemasok','  - Pembayaran ke Karyawan','  - Pembayaran Bunga & Beban Keuangan','  - Pajak (PPh)','  - Pajak (PPN)','  - SCF','  - Kompensasi','- Perolehan Aktiva tetap - Capex Rutin','- Perolehan Project CP & PP','- Pembayaran Pinjaman Jangka Panjang',' - Pembayaran hutang sewa pembiayaan','- Pembayaran Deviden')
									AND
										TO_CHAR('date','yyyy-mm')'".date('Y-m',strtotime($tanggal))."'
									GROUP BY DATE");
                
                $out_rata=$this->db->query("SELECT
									SUM(NILAI) AS NILAI
									FROM
										CF_DAILY
									WHERE
										KET IN ('  - Pembayaran ke Pemasok','  - Pembayaran ke Karyawan','  - Pembayaran Bunga & Beban Keuangan','  - Pajak (PPh)','  - Pajak (PPN)','  - SCF','  - Kompensasi','- Perolehan Aktiva tetap - Capex Rutin','- Perolehan Project CP & PP','- Pembayaran Pinjaman Jangka Panjang',' - Pembayaran hutang sewa pembiayaan','- Pembayaran Deviden')
									AND
										TO_CHAR('date','yyyy-mm')'".date('Y-m',strtotime($tanggal))."'
									")->row();
                
                
                


		$rkap_in=$this->db->query("SELECT * FROM CF_AVERAGE_COLLECTION WHERE MONTH = 09")->row();
		$rkap_out=$this->db->query("SELECT * FROM CF_AVERAGE_PAYMENT WHERE MONTH = 09")->row();

		foreach ($in->result() as $in1) {
			$data['CASHIN'][]=array('NILAI'=>$in1->NILAI,'RKAP'=>$rkap_in->RKAP);
		}

		foreach ($out->result() as $out1) {
			$data['CASHOUT'][]=array('NILAI'=>$out1->NILAI,'RKAP'=>$rkap_out->RKAP);
		}
                             
                
                
		
		echo json_encode($data);

	}

	public function receipt()
	{
		
		$data=[];
		$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date(' 	') : $_GET['tahun']);
       	$bulan_sekarang=$tahun.'-'.$bulan;
     	if($bulan==date('m')){
     		 $cek_data=$this->db->query("SELECT
										*
										FROM
											CF_DAILY
										WHERE NILAI <> 0")->row();
     		// $tanggal=date('Y-m-d',strtotime($cek_data->DATE);
     	}else{
     		$cek_data=$this->db->query("SELECT
										*
										FROM
											CF_DAILY
										WHERE NILAI <> 0 AND TO_CHAR('date','yyyy-mm') = '".date('Y-m',strtotime($bulan_sekarang))."'")->row();
     	}

     	$tanggal1=$this->db->query("SELECT MAX(TANGGAL) AS tanggal FROM TIME_UPLOAD")->row();
        
     	$tanggal=date('Y-m-d',strtotime($cek_data->DATE));
   		$in=$this->db->query("SELECT
									SUM(NILAI) AS NILAI
									FROM
										CF_DAILY
									WHERE
										KET IN ('- Hasil Penjualan','- Pendapatan Bunga','- Pendapatan Lain','- Kompensasi')
									AND
										DATE = '$tanggal'")->row();
   		$in_upto=$this->db->query("SELECT
									SUM(NILAI) AS NILAI
									FROM
										CF_DAILY
									WHERE
										KET IN ('- Hasil Penjualan','- Pendapatan Bunga','- Pendapatan Lain','- Kompensasi')
									AND
										TO_CHAR('date','yyyy-mm')'".date('Y-m',strtotime($tanggal))."'")->row();

   		$in_detail=$this->db->query("SELECT
									KET,NILAI
									FROM
										CF_DAILY
									WHERE
										KET IN ('- Hasil Penjualan','- Pendapatan Bunga','- Pendapatan Lain','- Kompensasi')
									AND
										DATE ='$tanggal'");
   		$rkap_in=$this->db->query("SELECT * FROM CF_AVERAGE_COLLECTION WHERE MONTH = 09")->row();
   		$data['in_days']=array('NILAI'=>$in->NILAI,'NILAI_UPTO'=>$in_upto->NILAI);
   		foreach ($in_detail->result_array() as $row) {
   			$in_detail_upto=$this->db->query("SELECT KET,SUM(NILAI) AS NILAI_UPTO
									FROM
										CF_DAILY
									WHERE
										KET = '".$row['KET']."'
									AND
										DATE_FORMAT(DATE,'%Y-%m') ='".date('Y-m',strtotime($tanggal))."' GROUP BY KET")->row();
   			$data['in_detail'][]=array('KET'=>$row['KET'],'NILAI'=>$row['NILAI'],'NILAI_UPTO'=>$in_detail_upto->NILAI_UPTO,'RKAP'=>$rkap_in->RKAP);
   		}

   		// foreach ($in_detail_upto->result_array() as $row) {
   		// 	$data['in_detail_upto'][]=array('KET'=>$row['KET'],'NILAI'=>$row['NILAI']);
   		// }

   		$data['LAST_UPDATE']=array('TANGGAL'=>date('d/m/Y H:i',strtotime($tanggal1->tanggal)));
   		
   		echo json_encode($data);
	}

	public function disburstement()
	{
		
	$data=[];
	$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $tanggal=$tahun.'-'.$bulan.'-26';
       	$bulan_sekarang=$tahun.'-'.$bulan;
     	if($bulan==date('m')){
     		 $cek_data=$this->db->query("SELECT
										*
										FROM
											CF_DAILY
										WHERE NILAI <> 0")->row();
     		// $tanggal=date('Y-m-d',strtotime($cek_data->DATE);
     	}else{
     		$cek_data=$this->db->query("SELECT
										*
										FROM
											CF_DAILY
										WHERE NILAI <> 0 AND TO_CHAR('date','yyyy-mm') = '".date('Y-m',strtotime($tanggal))."'")->row();
     	}

     	// $tanggal_awal=$tahun.'-'.$bulan.'-01';
     	// $tanggal=$tahun.'-'.$bulan.'-26';
        $tanggal1=$this->db->query("SELECT MAX(TANGGAL) AS tanggal FROM TIME_UPLOAD")->row();

     	$tanggal=date('Y-m-d',strtotime($cek_data->DATE));
   		$out=$this->db->query("SELECT
										SUM(NILAI) AS NILAI
									FROM
										CF_DAILY
									WHERE
										KET IN ('  - Pembayaran ke Pemasok','  - Pembayaran ke Karyawan','  - Pembayaran Bunga & Beban Keuangan','  - Pajak (PPh)','  - Pajak (PPN)','  - SCF','  - Kompensasi','- Perolehan Aktiva tetap - Capex Rutin','- Perolehan Project CP & PP','- Pembayaran Pinjaman Jangka Panjang',' - Pembayaran hutang sewa pembiayaan','- Pembayaran Deviden')
									AND
										DATE = '$tanggal'")->row();
   		$out_upto=$this->db->query("SELECT
									SUM(NILAI) AS NILAI
									FROM
										CF_DAILY
									WHERE
										KET IN  ('  - Pembayaran ke Pemasok','  - Pembayaran ke Karyawan','  - Pembayaran Bunga & Beban Keuangan','  - Pajak (PPh)','  - Pajak (PPN)','  - SCF','  - Kompensasi','- Perolehan Aktiva tetap - Capex Rutin','- Perolehan Project CP & PP','- Pembayaran Pinjaman Jangka Panjang',' - Pembayaran hutang sewa pembiayaan','- Pembayaran Deviden')
									AND
										TO_CHAR('date','yyyy-mm')'".date('Y-m',strtotime($tanggal))."'")->row();

   		$out_detail=$this->db->query("SELECT
									KET,NILAI
									FROM
										CF_DAILY
									WHERE
									-- 	KET IN ('- Hasil Penjualan','- Pendapatan Bunga','- Pendapatan Lain','- Kompensasi')
									-- AND
										DATE ='$tanggal' LIMIT 7,15");
   		$data['out_days']=array('NILAI'=>$out->NILAI,'NILAI_UPTO'=>$out_upto->NILAI);
   		foreach ($out_detail->result_array() as $row) {
   			$KET=$this->strpos($row['KET']);
   			if($row['NILAI']==null){
   				$NILAI = '';
   			}else{  
   				$NILAI = number_format($row['NILAI']);
   			}
   			$out_detail_upto=$this->db->query("SELECT KET,SUM(NILAI) AS NILAI_UPTO
									FROM
										CF_DAILY
									WHERE
										KET  = '".$row['KET']."'
									 AND
										DATE_FORMAT(DATE,'%Y-%m') ='2017-10' GROUP BY KET")->row();
   			if($out_detail_upto->NILAI_UPTO==null){
   				$NILAI_UPTO = '';
   			}else{
   				$NILAI_UPTO = number_format($out_detail_upto->NILAI_UPTO);
   			}
   			$data['out_detail'][]=array('KET'=>$KET,'NILAI'=>$NILAI,'NILAI_UPTO'=>$NILAI_UPTO);
   		}

   		// foreach ($in_detail_upto->result_array() as $row) {
   		// 	$data['in_detail_upto'][]=array('KET'=>$row['KET'],'NILAI'=>$row['NILAI']);
   		// }

   		$data['LAST_UPDATE']=array('TANGGAL'=>date('d/m/Y H:i',strtotime($tanggal1->tanggal)));
   		
   		echo json_encode($data);
	}


	public function strpos($haystack)
	{
        // $needles=array('Aktivitas Operasi','Aktivitas Investasi','Aktivitas Pendanaan');
        // foreach($needles as $needle) {
               $res = strpos($haystack, 'Aktivitas');
               if($res!=false){
               	$ket='<strong>'.$haystack.'</strong>';
               }else{
               	$ket=$haystack;
               }
        // }
        return $ket;
       
	}

	public function upload()
	{
		$this->load->view('upload/v_upload_cashflow');
	}

	function _get_path_upload(){
        $tes = dirname(__FILE__);
        $pet_pat = str_replace('application/controllers/', '', $tes); 
        return $pet_pat;   
    }


	public function proses_upload_cashflow()
	{
		$bulan1=$this->input->post('bulan');
		$tahun=$this->input->post('tahun');
		$this->path_upload = $this->_get_path_upload()."/model/".basename($_FILES['file']['name']);
                error_reporting(E_ALL ^ E_NOTICE);
                $file = $_FILES['file']['tmp_name'];
                $cashflow_daily=$this->upload_cashflow_daily($bulan1,$tahun,$file);
                // $ending_balance= $this->upload_ending_balance($bulan1,$tahun,$file);
                echo json_encode(array('status'=>true,'msg'=>$cashflow_daily));
   	}

   	public function upload_cashflow_daily($bulan1,$tahun,$file)
   	{
   		
		$input_cashflow_daily=0;
		$update_cashflow_daily=0;
		$input_ending_balance=0;
		$update_ending_balance=0;
		$update_average_of_collection=0;
		$update_average_of_payment=0;
		$bulan=$this->bulan($bulan1);
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

            //cost_daily

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $aa=cal_days_in_month(CAL_GREGORIAN,$bulan1, $tahun);
            for ($i=1; $i <=$aa ; $i++) { 
            for ($row = 5; $row <= $highestRow; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][0]==""){
                    continue;
                }          
                $date=$this->tanggal($i,$bulan,$tahun);
                $this->db->where(array('date'=>$date,
                			"KET"=>$rowData[0][0]));
                $query=$this->db->get('CF_DAILY');
                if($query->num_rows()>0){
                $this->db->where(array('date'=>$date,
                			"KET"=>$rowData[0][0]));
                 $sql=$this->db->update('CF_DAILY',array(
					"NILAI"=>$rowData[0][$i]
                                                    ));
                 $update_cashflow_daily++;
                }else{
                $sql=$this->db->insert('CF_DAILY',array('DATE'=>$date,'KET'=>$rowData[0][0],'NILAI'=>$rowData[0][$i]));
                $input_cashflow_daily++;
            	}
        	}
        }


        	//ending balance
        	$sheet = $objPHPExcel->getSheet(1);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $aa=cal_days_in_month(CAL_GREGORIAN,$bulan1, $tahun);
            for ($i=1; $i <=$aa ; $i++) { 
            for ($row = 5; $row <= $highestRow; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][0]==""){
                    continue;
                }          
                $date=$this->tanggal($i,$bulan,$tahun);
                $this->db->where(array('date'=>$date,
                					   "KET"=>$rowData[0][0]));
                $query=$this->db->get('CF_ENDING_BALANCE');
                if($query->num_rows()>0){
                $this->db->where(array('date'=>$date,
                					   "KET"=>$rowData[0][0]));
                 $sql=$this->db->update('CF_ENDING_BALANCE',array(
													"NILAI"=>$rowData[0][$i]
                                                    ));
                 $update_ending_balance++;
                }else{
                $sql=$this->db->insert('CF_ENDING_BALANCE',array('DATE'=>$date,'KET'=>$rowData[0][0],'NILAI'=>$rowData[0][$i]));
                $input_ending_balance++;
            	}
        	}
        }


        //average of collection
        	$sheet = $objPHPExcel->getSheet(3);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 6; $row <=17; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][0]==""){
                    continue;
                }          
                $month=$this->month($rowData[0][0]);
                $this->db->where(array("MONTH"=>$month,"YEAR"=>$tahun));
                $query=$this->db->get('CF_AVERAGE_COLLECTION');
                if($query->num_rows()>0){
                 $this->db->where(array("MONTH"=>$month,"YEAR"=>$tahun));
                 $sql=$this->db->update('CF_AVERAGE_COLLECTION',array(
													"RKAP"=>$rowData[0][5],
            										"REAL"=>$rowData[0][6]
                                                    ));
                 $update_average_of_collection++;
                }else{
                // $sql=$this->db->insert('CF_ENDING_BALANCE',array('DATE'=>$date,'KET'=>$rowData[0][0],'NILAI'=>$rowData[0][$i]));
                // $input_ending_balance++;
            	}
        	}


         //average of payment
        	$sheet = $objPHPExcel->getSheet(3);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 25; $row <=36; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][0]==""){
                    continue;
                }          
                $month=$this->month($rowData[0][0]);
                $this->db->where(array("MONTH"=>$month,"YEAR"=>$tahun));
                $query=$this->db->get('CF_AVERAGE_PAYMENT');
                if($query->num_rows()>0){
                $this->db->where(array("MONTH"=>$month,"YEAR"=>$tahun));
                 $sql=$this->db->update('CF_AVERAGE_PAYMENT',array(
													"RKAP"=>$rowData[0][5],
            										"REAL"=>$rowData[0][6]
                                                    ));
                 $update_average_of_payment++;
                }else{
                // $sql=$this->db->insert('CF_ENDING_BALANCE',array('DATE'=>$date,'KET'=>$rowData[0][0],'NILAI'=>$rowData[0][$i]));
                // $input_ending_balance++;
            	}
        	}
            $this->db->insert('TIME_UPLOAD',array('TANGGAL'=> date('Y-m-d H:i:s')));
            unlink($inputFileName);
            return 'Casflow Daily<br>Insert :'.$input_cashflow_daily.'<br> Update : '.$update_cashflow_daily.
            		'<br><br>Ending Balance :'.$input_ending_balance.'<br> Update : '.$update_ending_balance.
            		'<br><br>Average Of Collection Update : '.$update_average_of_collection.
            		'<br><br>Average Of Payment Update : '.$update_average_of_payment;
            //return json_encode(array('status'=>true,'msg'=>'Casflow Daily<br>Insert :'.$insert.'<br> Update : '.$update));
            
                }
        else{
        	return 'Gagal Import Data';
    		//return json_encode(array('status'=>false,'msg'=>'Gagal Import Data'));
   		 }
   	}


   	public function upload_ending_balance($bulan1,$tahun,$file)
	{
		// $bulan1=$this->input->post('bulan');
		// $tahun=$this->input->post('tahun');
		$bulan=$this->bulan($bulan1);
		$input=0;
		$update=0;
		// $this->path_upload = $this->_get_path_upload()."/model/".basename($_FILES['file']['name']);
  //       error_reporting(E_ALL ^ E_NOTICE);
  //       $file = $_FILES['file']['tmp_name'];
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
            $sheet = $objPHPExcel->getSheet(1);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $aa=cal_days_in_month(CAL_GREGORIAN,$bulan1, $tahun);
            for ($i=1; $i <=$aa ; $i++) { 
            for ($row = 5; $row <= $highestRow; $row++){                
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][0]==""){
                    continue;
                }          
                $date=$this->tanggal($i,$bulan,$tahun);
                $this->db->where(array('date'=>$date,
                					   "KET"=>$rowData[0][0]));
                $query=$this->db->get('CF_ENDING_BALANCE');
                if($query->num_rows()>0){
                $this->db->where(array('date'=>$date,
                					   "KET"=>$rowData[0][0]));
                 $sql=$this->db->update('CF_ENDING_BALANCE',array(
													"NILAI"=>$rowData[0][$i]
                                                    ));
                 $update++;
                }else{
                $sql=$this->db->insert('CF_ENDING_BALANCE',array('DATE'=>$date,'KET'=>$rowData[0][0],'NILAI'=>$rowData[0][$i]));
                $insert++;
            	}
        	}
        }
            unlink($inputFileName);
            return 'Ending Balance<br>Insert :'.$insert.'<br> Update : '.$update;
            // return json_encode(array('status'=>true,'msg'=>'Ending Balance<br>Insert :'.$insert.'<br> Update : '.$update));
        }
        else{
        	return 'Gagal Import Data';
    		// return json_encode(array('status'=>false,'msg'=>'Gagal Import Data'));
   		 }


	}


   	public function tanggal($id,$bulan,$tahun)
	{
		switch ($id) {
			case 1:
				$d='01';
				break;
			case 2:
				$d='02';
				break;
			case 3:
				$d='03';
				break;
			case 4:
				$d='04';
				break;
			case 5:
				$d='05';
				break;
			case 6:
				$d='06';
				break;
			case 7:
				$d='07';
				break;
			case 8:
				$d='08';
				break;
			case 9:
				$d='09';
				break;
			default:
				$d=$id;
				break;
		}

		return $tahun.'-'.$bulan.'-'.$d;
	}

		public function bulan($id)
	{
		switch ($id) {
			case 1:
				$d='01';
				break;
			case 2:
				$d='02';
				break;
			case 3:
				$d='03';
				break;
			case 4:
				$d='04';
				break;
			case 5:
				$d='05';
				break;
			case 6:
				$d='06';
				break;
			case 7:
				$d='07';
				break;
			case 8:
				$d='08';
				break;
			case 9:
				$d='09';
				break;
			default:
				$d=$id;
				break;
		}
		
		return $id;
	}


	public function month($bulan)
	{
		switch ($bulan) {
			case 'JANUARI':
				$bln =1;
				break;
			case 'FEBRUARI':
				$bln =2;
				break;
			case 'MARET':
				$bln =3;
				break;
			case 'APRIL':
				$bln =4;
				break;
			case 'MEI':
				$bln =5;
				break;
			case 'JUNI':
				$bln =6;
				break;
			case 'JULI':
				$bln =7;
				break;
			case 'AGUSTUS':
				$bln =8;
				break;
			case 'SEPTEMBER':
				$bln =9;
				break;
			case 'OKTOBER':
				$bln =10;
				break;
			case 'NOVEMBER':
				$bln =11;
				break;
			case 'DESEMBER':
				$bln =12;
				break;
			default:
				$bln =0;
				break;
		}

		return $bln;
	}

}

/* End of file cash_flow_st.php */
/* Location: ./application/controllers/cash_flow_st.php */