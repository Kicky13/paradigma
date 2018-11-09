<?php
header('Access-Control-Allow-Origin:*');
date_default_timezone_set('Asia/Ujung_Pandang');
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_flow_st extends CI_Controller {
  protected $path_upload = "";
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $this->db= $this->load->database('tonasa1',true);
  }


  public function data_terakhir($bulan,$bulan_sekarang)
  {
    $cek_data = ($bulan==date('m')) ? $this->db->query("SELECT MAX(DATE) AS tanggal FROM CF_DAILY_1 WHERE NILAI <> 0")->row() : $this->db->query("SELECT MAX(DATE) AS tanggal FROM CF_DAILY_1 WHERE NILAI <> 0 AND DATE_FORMAT(DATE,'%Y-%m') = '".$bulan_sekarang."'")->row();
      
      return $cek_data;
  }

  public function index()
  {
    $bulan  = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun  = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $hari   = (empty($_GET['hari'])  ? date('d') : $_GET['hari'] );
        $bulan_sekarang = $tahun.'-'.$bulan;
        $tanggal_awal = $tahun.'-'.$bulan.'-01';
        $cek_data   = $this->data_terakhir($bulan,$bulan_sekarang);
      $tanggal    = $cek_data->tanggal;
        $tanggal_upload = $this->db->query("SELECT MAX(TANGGAL) AS tanggal FROM TIME_UPLOAD")->row();


    $saldo      = $this->db->query("SELECT SUM(NILAI) AS NILAI FROM CF_DAILY_1 WHERE DATE = '$tanggal' AND KET='Kas dan Setara Kas Akhir Periode'")->row();
    $begin_balance  = $this->db->query("SELECT SUM(NILAI) AS NILAI FROM CF_DAILY_1 WHERE DATE = '$tanggal_awal' AND KET='Kas dan Setara Kas Awal Periode'")->row();
        $in       = $this->db->query("SELECT REALISASI AS NILAI FROM CF_AVERAGE_COLLECTION WHERE MONTH = '".date('m', strtotime($tanggal))."'")->row();
    $out      = $this->db->query("SELECT REALISASI AS NILAI FROM CF_AVERAGE_PAYMENT WHERE MONTH = '".date('m', strtotime($tanggal))."'")->row();

    $data[]=array( 'SALDO'=>$saldo->NILAI,
             'BEGINING_BALANCE'=>$begin_balance->NILAI,
             'CASHIN'=>$in->NILAI,
             'CASHOUT'=>$out->NILAI,
             'LAST_UPDATE'=>date('d/m/Y H:i',strtotime($tanggal_upload->tanggal))
            );

    echo json_encode($data);
  }

  public function saldo_harian()
  {
    $bulan  = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun  = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $hari   = (empty($_GET['hari'])  ? date('d') : $_GET['hari']);

      $bulan_sekarang = $tahun.'-'.$bulan;
      $cek_data   = $this->data_terakhir($bulan,$bulan_sekarang);
      $tanggal    = $cek_data->tanggal;

    $sql=$this->db->query("SELECT DATE,SUM(NILAI) AS NILAI FROM CF_DAILY_1 WHERE DATE_FORMAT(DATE,'%m')='".date('m',strtotime($tanggal))."' AND NILAI <> 0 AND KET='Kas dan Setara Kas Akhir Periode' GROUP BY DATE");
    foreach ($sql->result() as $row) { $data[] = array('NILAI'=>$row->NILAI);}
    echo json_encode($data);
  }

  public function average()
  {
    // $data=[];
    $bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $hari =  (empty($_GET['hari'])  ? date('d') : $_GET['hari']);

      $bulan_sekarang = $tahun.'-'.$bulan;
      $cek_data   = $this->data_terakhir($bulan,$bulan_sekarang);
      $tanggal    = $cek_data->tanggal;
      $bulan1 = $this->bulan($bulan);
        $in     = $this->db->query("SELECT SUM(NILAI) AS NILAI FROM CF_DAILY_1 WHERE KET IN ('- Penerimaan Pembayaran','- Penghasilan bunga yang diterima') AND DATE_FORMAT(DATE,'%Y-%m')='".date('Y-m',strtotime($tanggal))."' GROUP BY DATE");
    $out    = $this->db->query("SELECT SUM(NILAI) AS NILAI FROM CF_DAILY_1 WHERE KET IN ('- Pembayaran Kepada Pemasok','- Pembayaran Kepada  Karyawan','- Pembayaran Bunga dan Beban Keuangan','- Pembayaran Pajak ') AND DATE_FORMAT(DATE,'%Y-%m')='".date('Y-m',strtotime($tanggal))."' GROUP BY DATE");
    $rkap_in  = $this->db->query("SELECT * FROM CF_AVERAGE_COLLECTION WHERE MONTH = $bulan")->row();
    $rkap_out   = $this->db->query("SELECT * FROM CF_AVERAGE_PAYMENT WHERE MONTH = $bulan")->row();

    foreach ($in->result() as $in1) {
      $data['CASHIN'][]=array('NILAI'=>$in1->NILAI,'RKAP'=>$rkap_in->RKAP);
    }

    foreach ($out->result() as $out1) {
      $data['CASHOUT'][]=array('NILAI'=>str_replace('-','',$out1->NILAI),'RKAP'=>$rkap_out->RKAP);
    }
                
        for ($i = 1; $i <=12 ; $i++) {

          $tgl  = $tahun.'-'.$i;
          $sql  = $this->db->query("SELECT * FROM CF_DEPOSITO WHERE MONTH='$i' AND YEAR = '$tahun'")->row();

          $data['DEPOSITO'][] = array('NILAI'=>$sql->NILAI/1000000);
        }

    echo json_encode($data);

  }

  public function receipt()
  {

    // $data=[];
    $bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('  ') : $_GET['tahun']);
        $bulan_sekarang=$tahun.'-'.$bulan;
      if($bulan==date('m')){
         $cek_data=$this->db->query("SELECT
                    MAX(DATE) AS tanggal
                    FROM
                      CF_DAILY
                    WHERE NILAI <> 0")->row();
        // $tanggal=$cek_data->tanggal;
      }else{
        $cek_data=$this->db->query("SELECT
                    MAX(DATE) AS tanggal
                    FROM
                      CF_DAILY
                    WHERE NILAI <> 0 AND DATE_FORMAT(DATE,'%Y-%m') = '".date('Y-m',strtotime($bulan_sekarang))."'")->row();
      }

      $tanggal1=$this->db->query("SELECT MAX(TANGGAL) AS tanggal FROM TIME_UPLOAD")->row();

      $tanggal=$cek_data->tanggal;
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
                    DATE_FORMAT(DATE,'%Y-%m')='".date('Y-m',strtotime($tanggal))."'")->row();

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
      //  $data['in_detail_upto'][]=array('KET'=>$row['KET'],'NILAI'=>$row['NILAI']);
      // }

      $data['LAST_UPDATE']=array('TANGGAL'=>date('d/m/Y H:i',strtotime($tanggal1->tanggal)));

      echo json_encode($data);
  }

  public function disburstement()
  {

  // $data=[];
  $bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $tanggal=$tahun.'-'.$bulan.'-26';
        $bulan_sekarang=$tahun.'-'.$bulan;
      if($bulan==date('m')){
         $cek_data=$this->db->query("SELECT
                    MAX(DATE) AS tanggal
                    FROM
                      CF_DAILY
                    WHERE NILAI <> 0")->row();
        // $tanggal=$cek_data->tanggal;
      }else{
        $cek_data=$this->db->query("SELECT
                    MAX(DATE) AS tanggal
                    FROM
                      CF_DAILY
                    WHERE NILAI <> 0 AND DATE_FORMAT(DATE,'%Y-%m') = '".date('Y-m',strtotime($tanggal))."'")->row();
      }

      // $tanggal_awal=$tahun.'-'.$bulan.'-01';
      // $tanggal=$tahun.'-'.$bulan.'-26';
        $tanggal1=$this->db->query("SELECT MAX(TANGGAL) AS tanggal FROM TIME_UPLOAD")->row();

      $tanggal=$cek_data->tanggal;
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
                    DATE_FORMAT(DATE,'%Y-%m')='".date('Y-m',strtotime($tanggal))."'")->row();

      $out_detail=$this->db->query("SELECT
                  KET,NILAI
                  FROM
                    CF_DAILY
                  WHERE
                  --  KET IN ('- Hasil Penjualan','- Pendapatan Bunga','- Pendapatan Lain','- Kompensasi')
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
      //  $data['in_detail_upto'][]=array('KET'=>$row['KET'],'NILAI'=>$row['NILAI']);
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
        
    public function cash_flow_detail() {
        $bulan  = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun  = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        
        $bulan_sekarang = $tahun.'-'.$bulan;
      $cek_data   = $this->data_terakhir($bulan,$bulan_sekarang);
      $tanggal    = $cek_data->tanggal;

        $sql_today    = $this->db->query("SELECT *  FROM CF_DAILY_1 WHERE DATE_FORMAT(DATE,'%Y-%m-%d')='$tanggal'");
        foreach ($sql_today->result_array() as $row) {
            $ket=$this->strpos_detail($row['KET']);
            $sql_upto=$this->db->query("SELECT KET,SUM(NILAI) AS NILAI FROM CF_DAILY_2 WHERE KET ='".$row['KET']."' GROUP BY KET")->row();
            $data[]=array('DESC'=>$ket,'TODAY'=>$row['NILAI'],'UPTO'=>$sql_upto->NILAI);
        }
            
        echo json_encode($data);
            
    }


        
    public function strpos_detail($haystack)
  {
               $res = strpos($haystack, 'Kas');
               if($res!=false){
                   $ket='<strong>'.$haystack.'</strong>';
               }else{
                    $ket=$haystack;
               }
        return $ket;
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
        
    public function test() {
    $bulan1=$this->input->post('bulan');
    $tahun=$this->input->post('tahun');
    $this->path_upload = $this->_get_path_upload()."/model/".basename($_FILES['file']['name']);
                error_reporting(E_ALL ^ E_NOTICE);
                $file = $_FILES['file']['tmp_name'];
                $input_cashflow_daily=0;
    $update_cashflow_daily=0;
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
                $this->db->where(array("DATE"=>$date,
                      "KET"=>$rowData[0][0]));
                $query=$this->db->get('CF_DAILY_1');
                if($query->num_rows()>0){
                $this->db->where(array("DATE"=>$date,
                      "KET"=>$rowData[0][0]));
                 $sql=$this->db->update('CF_DAILY_1',array(
                                           "NILAI"=>$rowData[0][$i]
                                        ));
                 $update_cashflow_daily++;
                }else{
                $sql=$this->db->insert('CF_DAILY_1',array('DATE'=>$date,'KET'=>$rowData[0][0],'NILAI'=>$rowData[0][$i]));
                $input_cashflow_daily++;
              }
          }
            }
             echo json_encode(array('status'=>true,'msg'=>$input_cashflow_daily));
        }else{
            echo json_encode(array('status'=>false,'msg'=>'gagal upload'));
        }
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
                $this->db->where(array("DATE"=>$date,
                      "KET"=>$rowData[0][0]));
                $query=$this->db->get('CF_DAILY_1');
                if($query->num_rows()>0){
                $this->db->where(array("DATE"=>$date,
                      "KET"=>$rowData[0][0]));
                 $sql=$this->db->update('CF_DAILY_1',array(
                       "NILAI"=>$rowData[0][$i]
                                                    ));
                 $update_cashflow_daily++;
                }else{
                $sql=$this->db->insert('CF_DAILY_1',array('DATE'=>$date,'KET'=>$rowData[0][0],'NILAI'=>$rowData[0][$i]));
                $input_cashflow_daily++;
              }
          }
        }

        //upto cost_daily
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        for ($row = 5; $row <= $highestRow; $row++){
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                            NULL,
                                            TRUE,
                                            FALSE);
            if ($rowData[0][0]==""){
                continue;
            }
            $date=date('Y-m-d');
            $this->db->where(array("DATE"=>$date,
                  "KET"=>$rowData[0][0]));
            $query=$this->db->get('CF_DAILY_2');
            if($query->num_rows()>0){
            $this->db->where(array("DATE"=>$date,
                  "KET"=>$rowData[0][0]));
             $sql=$this->db->update('CF_DAILY_2',array(
                   "NILAI"=>$rowData[0][32]
                                                ));
            }else{
            $sql = $this->db->insert('CF_DAILY_2',array('DATE'=>$date,'KET'=>$rowData[0][0],'NILAI'=>$rowData[0][32]));
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
                $this->db->where(array("DATE"=>$date,
                             "KET"=>$rowData[0][0]));
                $query=$this->db->get('CF_ENDING_BALANCE');
                if($query->num_rows()>0){
                $this->db->where(array("DATE"=>$date,
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
                                "RKAP"=>$rowData[0][3],
                                "REALISASI"=>$rowData[0][4],
                                "RATA_RKAP"=>$rowData[0][5],
                                "RATA_REALISASI"=>$rowData[0][6]
                                                    ));
                 $update_average_of_collection++;
                }else{
                $sql = $this->db->insert('CF_AVERAGE_COLLECTION',array( "MONTH"          => $month,
                                                                        "YEAR"           => $tahun,
                                                                        "RKAP"           => $rowData[0][3],
                                                                        "REALISASI"      => $rowData[0][4],
                                                                        "RATA_RKAP"      => $rowData[0][5],
                                                                        "RATA_REALISASI" => $rowData[0][6]
                                                                      ));
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
                                                      "RKAP" => $rowData[0][3],
                                                      "REALISASI" => $rowData[0][4],
                                                      "RATA_RKAP" => $rowData[0][5],
                                                      "RATA_REALISASI" => $rowData[0][6]
                                                    ));
                 $update_average_of_payment++;
                }else{
                $sql=$this->db->insert('CF_AVERAGE_PAYMENT',array("MONTH" => $month,
                                                                  "YEAR" => $tahun,
                                                                  "RKAP" => $rowData[0][3],
                                                                  "REALISASI" => $rowData[0][4],
                                                                  "RATA_RKAP" => $rowData[0][5],
                                                                  "RATA_REALISASI" => $rowData[0][6]
                                                            ));
                // $input_ending_balance++;
              }
          }

          //deposito
          $sheet = $objPHPExcel->getSheet(3);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 41; $row <=52; $row++){
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                if ($rowData[0][0]==""){
                    continue;
                }
                $month=$this->month($rowData[0][1]);
                $year=$rowData[0][0];
                $this->db->where(array("MONTH"=>$month,"YEAR"=>$year));
                $query=$this->db->get('CF_DEPOSITO');
                if($query->num_rows()>0){
                $this->db->where(array("MONTH"=>$month,"YEAR"=>$year));
                 $sql=$this->db->update('CF_DEPOSITO',array(
                          "NILAI"=>$rowData[0][2]
                                                    ));
                 $update_average_of_payment++;
                }else{
                $sql = $this->db->insert('CF_DEPOSITO',array("MONTH"=>$month,
                                                              "YEAR"=>$year,
                                                              "NILAI"=>$rowData[0][2]
                                                            ));
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
                $this->db->where(array("DATE"=>$date,
                             "KET"=>$rowData[0][0]));
                $query=$this->db->get('CF_ENDING_BALANCE');
                if($query->num_rows()>0){
                $this->db->where(array("DATE"=>$date,
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


  public function bulan($id){
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
