<?php
header('Access-Control-Allow-Origin: *');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class market_share extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_msnasional','',true);
    }
    
    function index(){

      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $last_month = substr(('0'.($month-1)), -2);


      // $date = $year.'-'.$month;

      // $last_month = date('m', strtotime($date." -1 month"));
      
      $param = array(
        'month' => $month, 
        'year' => $year,
        'year2' => $year,
        'last_month' => $last_month, 
        'last_year' => $year-1, 
        'company' => $com
        );

      if ($last_month=='00') {
          $param['last_month'] = '12';
          $param['year2'] = $year-1;
      }


      $temp = array();

      if ($com==''||$com=='smi'||$com=='SMI') {
        # code...
        $temp['smi'] = $this->smi($param);
      }


      // $param = array('month' => $month, 'year' => $year,'last_month' => substr(('0'.($month-1)), -2), 'last_year' => $year-1, 'company' => $com);

      $result = $this->m_msnasional->get_ms($param);
      $company = 'default';
      foreach($result as $row) {
        # code...
        if ($row['KODE_PERUSAHAAN']=='110') {
          # code...
          $company = '7000';
        } else if ($row['KODE_PERUSAHAAN']=='102') {
          # code...
          $company = '3000';
        } else if ($row['KODE_PERUSAHAAN']=='112') {
          # code...
          $company = '4000';
        }



          $qty_bln = $row['QTY'];
          $qty_bln_kmrn = $row['REAL_BULAN'];

          $qty_thn_kmrn = $row['REAL_TAHUN'];

          $qty_thn_kum = $row['REAL_TAHUNINI_KUM'];
          $qty_thn_kmrn_kum = $row['REAL_TAHUN_KUM'];
          
          if ($qty_bln_kmrn == '0') {
            # code...
            $growth_mom = '0';
          }else {
            $growth_mom = round((($qty_bln - $qty_bln_kmrn) / $qty_bln_kmrn)*100,2);
          }

          if ($qty_thn_kmrn == '0') {
            # code...
            $growth_yoy = '0';
          }else {
            $growth_yoy = round((($qty_bln - $qty_thn_kmrn) / $qty_thn_kmrn)*100,2);
          }

           if ($qty_thn_kmrn_kum == '0') {
            # code...
            $growth_kum_yoy = '0';
          }else {
            $growth_kum_yoy = round((($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum)*100,2);
          }


        $temp[$company] = array(
            'NAMA' => $row['NAMA_PERUSAHAAN'],

            'VOLUME_BULAN' => $row['QTY'],
            'MS_BULAN' => round($row['QTY_REAL'],2),

            'LAST_VOLUME_BULAN' => $row['REAL_BULAN'],
            'LAST_MS_BULAN' => round($row['QTY_BULAN'],2),

            'MS_TAHUN_KUM' => round($row['QTY_TAHUNINI_KUM'],2),
            'TAHUN_VOLUME_KUM' => $row['REAL_TAHUNINI_KUM'],

            // 'LAST_VOLUME_TAHUN' => $row['REAL_TAHUN'],
            // 'LAST_MS_TAHUN' => round($row['QTY_TAHUN'],2),
            
            // 'LAST_MS_TAHUN_KUM' => '',
            // 'LAST_VOLUME_TAHUN_KUM' => $row['REAL_TAHUN_KUM'],

            'TARGET' => round($row['RKAP'])
            
          );

        // $temp[$company] = $row;
        $temp[$company]['GROWTH'] = array(
            'MOM' => $growth_mom,
            'YOY' => $growth_yoy,
            'KUM_YOY' => $growth_kum_yoy,
            // 'LAST_KUM_YOY' => ''
          );
      }

      echo json_encode($temp);

      // echo json_encode($result);

    }
    function smi($param){
      // $param = array('month' => $month, 'year' => $year,'last_month' => substr(('0'.($month-1)), -2), 'last_year' => $year-1, 'company' => $com);

      $result = $this->m_msnasional->get_ms_smi($param);
      $temp = array();
      foreach($result as $row) {
        # code...
          $qty_bln = $row['QTY'];
          $qty_bln_kmrn = $row['REAL_BULAN'];

          $qty_thn_kmrn = $row['REAL_TAHUN'];

          $qty_thn_kum = $row['REAL_TAHUNINI_KUM'];
          $qty_thn_kmrn_kum = $row['REAL_TAHUN_KUM'];
          
          if ($qty_bln_kmrn == '0') {
            # code...
            $growth_mom = '0';
          }else {
            $growth_mom = round((($qty_bln - $qty_bln_kmrn) / $qty_bln_kmrn)*100,2);
          }

          if ($qty_thn_kmrn == '0') {
            # code...
            $growth_yoy = '0';
          }else {
            $growth_yoy = round((($qty_bln - $qty_thn_kmrn) / $qty_thn_kmrn)*100,2);
          }

           if ($qty_thn_kmrn_kum == '0') {
            # code...
            $growth_kum_yoy = '0';
          }else {
            $growth_kum_yoy = round((($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum)*100,2);
          }


        $temp = array(
            'NAMA' => 'SMI',

            'VOLUME_BULAN' => $row['QTY'],
            'MS_BULAN' => round($row['QTY_REAL'],2),

            'LAST_VOLUME_BULAN' => $row['REAL_BULAN'],
            'LAST_MS_BULAN' => round($row['QTY_BULAN'],2),

            'MS_TAHUN_KUM' => round($row['QTY_TAHUNINI_KUM'],2),
            'TAHUN_VOLUME_KUM' => $row['REAL_TAHUNINI_KUM'],

            // 'LAST_VOLUME_TAHUN' => $row['REAL_TAHUN'],
            // 'LAST_MS_TAHUN' => round($row['QTY_TAHUN'],2),
            
            // 'LAST_MS_TAHUN_KUM' => '',
            // 'LAST_VOLUME_TAHUN_KUM' => $row['REAL_TAHUN_KUM'],

            'TARGET' => round($row['RKAP'])
            
          );

        // $temp = $row;
        $temp['GROWTH'] = array(
            'MOM' => $growth_mom,
            'YOY' => $growth_yoy,
            'KUM_YOY' => $growth_kum_yoy,
            // 'LAST_KUM_YOY' => ''
          );
      }

      // echo json_encode($temp);
      return $temp;

      // echo json_encode($result);

    }

    function sumByProvinsi($month, $year){
      $result_Sum = $this->m_msnasional->getSummaryProv('', $month, $year);
        $sumArr = array();
        foreach ($result_Sum as $key => $value) {
          # code...
          
          $sumArr[$value['PROPINSI']]['current'] = $value['SUM_CURRENT_MONTH'];
          $sumArr[$value['PROPINSI']]['last_month'] = $value['SUM_LAST_MONTH'];
          $sumArr[$value['PROPINSI']]['year'] = $value['SUM_YEAR_MONTH'];
          $sumArr[$value['PROPINSI']]['last_year'] = $value['SUM_LAST_YEAR_MONTH'];
          $sumArr[$value['PROPINSI']]['kum_year'] = $value['SUM_KUM_YEAR_CURRENT'];
          $sumArr[$value['PROPINSI']]['kum_last_year'] = $value['SUM_KUM_YEAR_LAST'];
        }

        return $sumArr;
    
    }
    //data per provinsi dengan parameter region, tahun, bulan dan company
    function detail2(){
        $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $com = (empty($_GET['company']) ? '' : $_GET['company']);
        $pulau = (empty($_GET['region']) ? '' : $_GET['region']);

        $result = $this->m_msnasional->get_detail_prov($pulau, $month, $year);
        $data = array();
        foreach ($result as $key => $value) {
          $kode = $value['KODE_PERUSAHAAN'];         # code...
          $kodeProv = $value['NM_PROV'];


          $qty_bln = $value['QTY'];
          $qty_bln_kmrn = $value['REAL_BULAN'];

          $qty_thn_kmrn = $value['REAL_TAHUN'];

          $qty_thn_kum =(double) $value['REAL_TAHUNINI_KUM'];
          $qty_thn_kmrn_kum =(double) $value['REAL_TAHUN_KUM'];

          
          if ($qty_bln_kmrn == '0') {
            # code...
            $growth_mom = '0';
          }else {
            $growth_mom = round((($qty_bln - $qty_bln_kmrn) / $qty_bln_kmrn)*100,2);
          }

          if ($qty_thn_kmrn == '0') {
            # code...
            $growth_yoy = '0';
          }else {
            $growth_yoy = round((($qty_bln - $qty_thn_kmrn) / $qty_thn_kmrn)*100,2);
          }

           if ($qty_thn_kmrn_kum == '0') {
            # code...
            $growth_kum_yoy = '0';
          }else {
            $growth_kum_yoy = round((($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum)*100,2);
            // echo "$growth_kum_yoy = round((($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum)*100,2) <br>";
          }


          $data[$kodeProv][$kode]= array(
              'PROVINSI' => $value['NM_PROV'] ,
              'KODE_PERUSAHAAN' => $value['KODE_PERUSAHAAN'],
              'PERUSAHAAN' => $value['NAMA_PERUSAHAAN'],
              'VOLUME_BULAN' => $value['QTY'],
              'MS_BULAN' =>(string) round($value['QTY_REAL'], 2),

              'LAST_VOLUME_BULAN' => $value['REAL_BULAN'],
              'LAST_MS_BULAN' =>(string) round($value['QTY_BULAN'],2),

              'VOLUME_TAHUN_KUM' =>$value['REAL_TAHUNINI_KUM'],
              'MS_TAHUN_KUM' =>(string) round($value['QTY_TAHUNINI_KUM'], 2),

              'LAST_VOLUME_TAHUN_KUM' =>$value['REAL_TAHUN_KUM'],
              'LAST_MS_TAHUN_KUM' => (string) round($value['QTY_TAHUN_KUM'], 2),
              'GROWTH_YOY' => (string) round($growth_yoy, 2)
            );
          // $data[$kodeProv][$kode]['GROWTH'] = array(
          //     'MOM' => $growth_mom,
          //     'YOY' => $growth_yoy,
          //     'KUM_YOY' => $growth_yoy
          //   );
        }

        echo json_encode($data);

    }

    function detail(){
        $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $com = (empty($_GET['company']) ? '' : $_GET['company']);
        $region = (empty($_GET['region']) ? '' : $_GET['region']);


        $paramProvinsi = "";
        if ($region!='') {
          // $paramProvinsi =  "AND PROPINSI = '$region' ";
          // $paramProvinsi2 = "a.PROPINSI = '$region' AND";
          if ($region == 'x') {
            $paramProvinsi =  "AND PROPINSI IN ('0001', '1092') ";
            $paramProvinsi2 = "a.PROPINSI IN ('0001', '1092') AND";
            $paramProvinsi3 = "WHERE TBNOW.PROPINSI IN ('0001', '1092')";
          }
          else
          if ($region == '1') {
            $paramProvinsi =  "AND PROPINSI IN ('1022', '1021', '1024', '1023', '1025', '1020') ";
            $paramProvinsi2 = "a.PROPINSI IN ('1022', '1021', '1024', '1023', '1025', '1020') AND";
            $paramProvinsi3 = "WHERE TBNOW.PROPINSI IN ('1022','1021','1024','1023','1025','1020')";
          } else if ($region == '2') {
            $paramProvinsi =  "AND PROPINSI IN ('1019', '1013', '1018', '1017', '1016', '1015', '1014', '1012', '1011', '1010') ";
            $paramProvinsi2 = "a.PROPINSI IN ('1019', '1013', '1018', '1017', '1016', '1015', '1014', '1012', '1011', '1010') AND";
            $paramProvinsi3 = "WHERE TBNOW.PROPINSI IN ('1019', '1013', '1018', '1017', '1016', '1015', '1014', '1012', '1011', '1010')";

          } else if ($region == '3') {
            $paramProvinsi =  "AND PROPINSI IN ('1029', '1043', '1030', '1031', '1032') ";
            $paramProvinsi2 = "a.PROPINSI IN ('1029', '1043', '1030', '1031', '1032') AND";
            $paramProvinsi3 = "WHERE TBNOW.PROPINSI IN ('1029', '1043', '1030', '1031', '1032')";

          } else if ($region == '4') {
            $paramProvinsi =  "AND PROPINSI IN ('1035', '1034', '1033', '1036', '1037', '1038') ";
            $paramProvinsi2 = "a.PROPINSI IN ('1035', '1034', '1033', '1036', '1037', '1038') AND";
            $paramProvinsi3 = "WHERE TBNOW.PROPINSI IN ('1035', '1034', '1033', '1036', '1037', '1038')";

          } else if ($region == '5') {
                  
            $paramProvinsi =  "AND PROPINSI IN ('1026', '1027', '1028') ";
            $paramProvinsi2 = "a.PROPINSI IN ('1026', '1027', '1028') AND";
            $paramProvinsi3 = "WHERE TBNOW.PROPINSI IN ('1026', '1027', '1028')";

          } else if ($region == '6') {
            $paramProvinsi =  "AND PROPINSI IN ('1039', '1041', '1040', '1042') ";
            $paramProvinsi2 = "a.PROPINSI IN ('1039', '1041', '1040', '1042') AND";
            $paramProvinsi3 = "WHERE TBNOW.PROPINSI IN ('1039', '1041', '1040', '1042')";
          } 

        } else {
          $paramProvinsi = " ";
          $paramProvinsi2 = " ";
          $paramProvinsi3 = " ";
        }
        
        $sumArr = $this->sumByProvinsi($month, $year);
        // echo json_encode($sumArr);

        $result = $this->m_msnasional->get_detail_prov($paramProvinsi, $paramProvinsi2, $month, $year);
        $data = array();
        foreach ($result as $key => $value) {
          $kode = $value['KODE_PERUSAHAAN'];         # code...
          $kodeProv = $value['NM_PROV'];
          $prov = $value['PROPINSI'];


          $qty_bln = $value['QTY'];
          $qty_bln_kmrn = $value['REAL_BULAN'];

          $qty_thn_kmrn = $value['REAL_TAHUN'];

          $qty_thn_kum =(double) $value['REAL_TAHUNINI_KUM'];
          $qty_thn_kmrn_kum =(double) $value['REAL_TAHUN_KUM'];


          $qty_blnthn_kmrin = $value['REAL_BLN_THN_KMRIN'];


          
          if ($qty_bln_kmrn == '0') {
            # code...
            $growth_mom = '0';
          }else {
            $growth_mom = round((($qty_bln - $qty_bln_kmrn) / $qty_bln_kmrn)*100,2);
          }

          if ($qty_thn_kmrn == '0') {
            # code...
            $growth_mom_last = '0';
          }else {
            $growth_mom_last = round((($qty_blnthn_kmrin - $qty_thn_kmrn) / $qty_thn_kmrn)*100,2);
          }


          if ($qty_thn_kmrn == '0') {
            # code...
            $growth_yoy = '0';
          }else {
            $growth_yoy = round((($qty_bln - $qty_thn_kmrn) / $qty_thn_kmrn)*100,2);
          }

           if ($qty_thn_kmrn_kum == '0') {
            # code...
            $growth_kum_yoy = '0';
          }else {
            $growth_kum_yoy = round((($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum)*100,2);
            // echo "$growth_kum_yoy = round((($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum)*100,2) <br>";
          }

          $ms_bln = ( floatval($value['QTY']) / floatval($sumArr[$prov]['current']) )*100;
          $ms_lastbln = ( floatval($value['REAL_BULAN']) / floatval($sumArr[$prov]['last_month']) )*100;
          $ms_thnkum = ( floatval($value['REAL_TAHUNINI_KUM']) / floatval($sumArr[$prov]['kum_year']) )*100;
          $ms_thnkumlast = ( floatval($value['REAL_TAHUN_KUM']) / floatval($sumArr[$prov]['kum_last_year']) )*100;

          $data[$kodeProv][$kode]= array(
              'PROVINSI' => $value['NM_PROV'] ,
              'KODE_PERUSAHAAN' => $value['KODE_PERUSAHAAN'],
              'PERUSAHAAN' => $value['NAMA_PERUSAHAAN'],
              'VOLUME_BULAN' => $value['QTY'],
              'MS_BULAN' =>(string) round( $ms_bln  , 2),

              'LAST_VOLUME_BULAN' => $value['REAL_BULAN'],
              'LAST_MS_BULAN' =>(string) round($ms_lastbln,2),

              'VOLUME_TAHUN_KUM' =>$value['REAL_TAHUNINI_KUM'],
              'MS_TAHUN_KUM' =>(string) round($ms_thnkum, 2),

              'LAST_VOLUME_TAHUN_KUM' =>$value['REAL_TAHUN_KUM'],
              'LAST_MS_TAHUN_KUM' => (string) round($ms_thnkumlast, 2),

              'GROWTH_YOY' => (string) round($growth_yoy, 2),
              'GROWTH_MOM' => (string) round($growth_mom, 2),
              'GROWTH_MOM_LAST' => (string) round($growth_mom_last, 2)
            );
          // $data[$kodeProv][$kode]['GROWTH'] = array(
          //     'MOM' => $growth_mom,
          //     'YOY' => $growth_yoy,
          //     'KUM_YOY' => $growth_yoy
          //   );
        }

        echo json_encode($data);

    }

    function getProv(){
      $result = $this->m_msnasional->get_provinsi();

     foreach ($result as $key => $value) {
     //   # code...

     //  // $json['PROVINSI']['KODE'] = $value['KD_PROV'];
     //  // $json['PROVINSI']['NAMA'] = $value['NM_PROV'];
     //  // $json['PROVINSI']['INISIAL'] = $value['NM_PROV_1'];

      $data[$value['NM_PROV_1']] = array(
          'KODE' => $value['KD_PROV'],
          'NAMA' => $value['NM_PROV'],
          'INISIAL' => $value['NM_PROV_1']

        );

     }

     $json['PROVINSI'] = $data;
      
      echo json_encode($json);
    }

    function dataProv3(){

      $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $last_month = substr(('0'.($month-1)), -2);

      $tag = $com;
      // $date = $year.'-'.$month;

      // $last_month = date('m', strtotime($date." -1 month"));
      
      $param = array(
        'month' => $month, 
        'year' => $year,
        'year2' => $year,
        'last_month' => $last_month, 
        'last_year' => $year-1, 
        'company' => $com
        );

      if ($last_month=='00') {
          $param['last_month'] = '12';
          $param['year2'] = $year-1;
      }
      $result = $this->m_msnasional->get_ms_com($param);

      // echo json_encode($param);

      //$result = oci_fetch_assoc($queryOracle);
      $temp = array();
      $company = $com;
      $jsonArray= array();
      foreach ($result as $row) {
        # code...
        // if ($row['KODE_PERUSAHAAN']=='110') {
        //   # code...
        //   $company = '7000';
        // } else if ($row['KODE_PERUSAHAAN']=='102') {
        //   # code...
        //   $company = '3000';
        // } else if ($row['KODE_PERUSAHAAN']=='112') {
        //   # code...
        //   $company = '4000';
        // }



          $qty_bln = $row['QTY'];
          $qty_bln_kmrn = $row['REAL_BULAN'];

          $qty_thn_kmrn = $row['REAL_TAHUN'];

          $qty_thn_kum = $row['REAL_TAHUNINI_KUM'];
          $qty_thn_kmrn_kum = $row['REAL_TAHUN_KUM'];

          $qty_bln_thn = $row['REAL_BLN_THN_KMRIN'];
          $qty_blnini_thn = $row['REAL_TAHUN'];
          
          if ($qty_bln_kmrn == '0') {
            # code...
            $growth_mom = '0';
          }else {
            $growth_mom = round((($qty_bln - $qty_bln_kmrn) / $qty_bln_kmrn)*100,2);
          }

          if ($qty_blnini_thn == '0') {
            # code...
            $growth_mom_thn = '0';
          }else {
            $growth_mom_thn = round((($qty_bln_thn - $qty_blnini_thn) / $qty_blnini_thn)*100,2);
          }

          if ($qty_thn_kmrn == '0') {
            # code...
            $growth_yoy = '0';
          }else {
            $growth_yoy = round((($qty_bln - $qty_thn_kmrn) / $qty_thn_kmrn)*100,2);
          }

           if ($qty_thn_kmrn_kum == '0') {
            # code...
            $growth_kum_yoy = '0';
          }else {
            $growth_kum_yoy = round((($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum)*100,2);
          }

          $namaProv = $row['NM_PROV'];
        $temp[$namaProv] = array(
            // 'NAMA' => $row['NAMA_PERUSAHAAN'],
            'PROV' => $row['NM_PROV'],
            'INISIAL_PROV' => $row['PROVINSI'],
            'VOLUME_BULAN' => $row['QTY'],
            'MS_BULAN' => round($row['QTY_REAL'],2),


            'LAST_VOLUME_BULAN' => $row['REAL_BULAN'],
            'LAST_MS_BULAN' => round($row['QTY_BULAN'],2),

            'MS_TAHUN_KUM' => round($row['QTY_TAHUNINI_KUM'],2),
            'TAHUN_VOLUME_KUM' => $row['REAL_TAHUNINI_KUM'],

            'LAST_VOLUME_TAHUN' => $row['REAL_TAHUN'],
            'LAST_MS_TAHUN' => round($row['QTY_TAHUN'],2),
            
            // 'LAST_MS_TAHUN_KUM' => '',
            // 'LAST_VOLUME_TAHUN_KUM' => $row['REAL_TAHUN_KUM'],

            'TARGET' => round($row['TARGET_RKAP'])
            
          );

        // $temp[$company] = $row;
        $temp[$namaProv]['GROWTH'] = array(
            'MOM' => $growth_mom,
            'LAST_MOM' => $growth_mom_thn,
            'YOY' => $growth_yoy,
            'KUM_YOY' => $growth_kum_yoy,
            // 'LAST_KUM_YOY' => ''
          );
         // $temp[$namaProv] = array(
            // $temp[$namaProv]['MOM'] = $growth_mom;
            // $temp[$namaProv]['LAST_MOM'] = $growth_mom_thn;
            // $temp[$namaProv]['YOY'] = $growth_yoy;
            // $temp[$namaProv]['KUM_YOY'] = $growth_kum_yoy;
            // 'LAST_KUM_YOY' => ''
          // );

        $orderby = 'LAST_MOM';
        $sortedtag = array();
        // usort($temp, 'sortByOrder');
        foreach ($temp as $key => $row)
        {
            $sortedtag[$key] = $row['GROWTH']['LAST_MOM'];
        }
        array_multisort($sortedtag, SORT_DESC, $temp);
      }
        $jsonArray[$company] = $temp;
      

      echo json_encode($jsonArray);

    }
    function dataProv(){

      $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $last_month = substr(('0'.($month-1)), -2);

      $tag = $com;
      // $date = $year.'-'.$month;

      // $last_month = date('m', strtotime($date." -1 month"));
      
      $param = array(
        'month' => $month, 
        'year' => $year,
        'year2' => $year,
        'last_month' => $last_month, 
        'last_year' => $year-1, 
        'company' => $com
        );

      if ($last_month=='00') {
          $param['last_month'] = '12';
          $param['year2'] = $year-1;
      }

      $sumArr = $this->sumByProvinsi($month, $year);
      $result = $this->m_msnasional->get_ms_com($param);

      // echo json_encode($param);

      //$result = oci_fetch_assoc($queryOracle);
      $temp = array();
      $company = $com;
      $jsonArray= array();
      foreach ($result as $row) {
        $prov = $row['PROPINSI'];
        # code...
        // if ($row['KODE_PERUSAHAAN']=='110') {
        //   # code...
        //   $company = '7000';
        // } else if ($row['KODE_PERUSAHAAN']=='102') {
        //   # code...
        //   $company = '3000';
        // } else if ($row['KODE_PERUSAHAAN']=='112') {
        //   # code...
        //   $company = '4000';
        // }



          $qty_bln = $row['QTY'];
          $qty_bln_kmrn = $row['REAL_BULAN'];

          $qty_thn_kmrn = $row['REAL_TAHUN'];

          $qty_thn_kum = $row['REAL_TAHUNINI_KUM'];
          $qty_thn_kmrn_kum = $row['REAL_TAHUN_KUM'];

          $qty_bln_thn = $row['REAL_BLN_THN_KMRIN'];
          $qty_blnini_thn = $row['REAL_TAHUN'];
          
          if ($qty_bln_kmrn == '0') {
            # code...
            $growth_mom = '0';
          }else {
            $growth_mom = round((($qty_bln - $qty_bln_kmrn) / $qty_bln_kmrn)*100,2);
          }

          if ($qty_blnini_thn == '0') {
            # code...
            $growth_mom_thn = '0';
          }else {
            $growth_mom_thn = round((($qty_bln_thn - $qty_blnini_thn) / $qty_blnini_thn)*100,2);
          }

          if ($qty_thn_kmrn == '0') {
            # code...
            $growth_yoy = '0';
          }else {
            $growth_yoy = round((($qty_bln - $qty_thn_kmrn) / $qty_thn_kmrn)*100,2);
          }

           if ($qty_thn_kmrn_kum == '0') {
            # code...
            $growth_kum_yoy = '0';
          }else {
            $growth_kum_yoy = round((($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum)*100,2);
          }
          $ms_bln = ( floatval($row['QTY']) / floatval($sumArr[$prov]['current']) )*100;
          $ms_lastbln = ( floatval($row['REAL_BULAN']) / floatval($sumArr[$prov]['last_month']) )*100;
          $ms_thnkum = ( floatval($row['REAL_TAHUNINI_KUM']) / floatval($sumArr[$prov]['kum_year']) )*100;
          $ms_thnkumlast = ( floatval($row['REAL_TAHUN_KUM']) / floatval($sumArr[$prov]['kum_last_year']) )*100;

          $namaProv = $row['NM_PROV'];
        $temp[$namaProv] = array(
            // 'NAMA' => $row['NAMA_PERUSAHAAN'],
            'PROV' => $row['NM_PROV'],
            'INISIAL_PROV' => $row['PROVINSI'],
            'VOLUME_BULAN' => $row['QTY'],
            // 'MS_BULAN' => round($row['QTY_REAL'],2),
            'MS_BULAN' => round($ms_bln,2),


            'LAST_VOLUME_BULAN' => $row['REAL_BULAN'],
            // 'LAST_MS_BULAN' => round($row['QTY_BULAN'],2),
            'LAST_MS_BULAN' => round($ms_lastbln,2),

            // 'MS_TAHUN_KUM' => round($row['QTY_TAHUNINI_KUM'],2),
            'MS_TAHUN_KUM' => round($ms_thnkum,2),
            'TAHUN_VOLUME_KUM' => $row['REAL_TAHUNINI_KUM'],

            'LAST_VOLUME_TAHUN' => $row['REAL_TAHUN'],
            // 'LAST_MS_TAHUN' => round($row['QTY_TAHUN'],2),
            'LAST_MS_TAHUN' => round($ms_thnkumlast,2),
            
            // 'LAST_MS_TAHUN_KUM' => '',
            // 'LAST_VOLUME_TAHUN_KUM' => $row['REAL_TAHUN_KUM'],

            'TARGET' => round($row['TARGET_RKAP'])
            
          );

        // $temp[$company] = $row;
        $temp[$namaProv]['GROWTH'] = array(
            'MOM' => $growth_mom,
            'LAST_MOM' => $growth_mom_thn,
            'YOY' => $growth_yoy,
            'KUM_YOY' => $growth_kum_yoy,
            // 'LAST_KUM_YOY' => ''
          );
         // $temp[$namaProv] = array(
            // $temp[$namaProv]['MOM'] = $growth_mom;
            // $temp[$namaProv]['LAST_MOM'] = $growth_mom_thn;
            // $temp[$namaProv]['YOY'] = $growth_yoy;
            // $temp[$namaProv]['KUM_YOY'] = $growth_kum_yoy;
            // 'LAST_KUM_YOY' => ''
          // );

        $orderby = 'LAST_MOM';
        $sortedtag = array();
        // usort($temp, 'sortByOrder');
        foreach ($temp as $key => $row)
        {
            $sortedtag[$key] = $row['GROWTH']['LAST_MOM'];
        }
        array_multisort($sortedtag, SORT_DESC, $temp);
        $jsonArray[$company] = $temp;

      }
      

      echo json_encode($jsonArray);

    }
    function sortByOrder($a, $b) {
        return $a['LAST_MOM'] - $b['LAST_MOM'];
    }

    function dataProv2(){

      $com = (empty($_GET['company']) ? '' : $_GET['company']);
      $month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
      $year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
      $last_month = substr(('0'.($month-1)), -2);


      // $date = $year.'-'.$month;

      // $last_month = date('m', strtotime($date." -1 month"));
      
      $param = array(
        'month' => $month, 
        'year' => $year,
        'year2' => $year,
        'last_month' => $last_month, 
        'last_year' => $year-1, 
        'company' => $com
        );

      if ($last_month=='00') {
          $param['last_month'] = '12';
          $param['year2'] = $year-1;
      }
      $result = $this->m_msnasional->get_ms_com2($param);

      // echo json_encode($param);

      //$result = oci_fetch_assoc($queryOracle);
      $temp = array();
      $company = 'default';
      $jsonArray= array();
      foreach ($result as $row) {
        # code...
        if ($row['KODE_PERUSAHAAN']=='110') {
          # code...
          $company = '7000';
        } else if ($row['KODE_PERUSAHAAN']=='102') {
          # code...
          $company = '3000';
        } else if ($row['KODE_PERUSAHAAN']=='112') {
          # code...
          $company = '4000';
        }



          $qty_bln = $row['QTY'];
          $qty_bln_kmrn = $row['REAL_BULAN'];

          $qty_thn_kmrn = $row['REAL_TAHUN'];

          $qty_thn_kum = $row['REAL_TAHUNINI_KUM'];
          $qty_thn_kmrn_kum = $row['REAL_TAHUN_KUM'];
          
          if ($qty_bln_kmrn == '0') {
            # code...
            $growth_mom = '0';
          }else {
            $growth_mom = round((($qty_bln - $qty_bln_kmrn) / $qty_bln_kmrn)*100,2);
          }

          if ($qty_thn_kmrn == '0') {
            # code...
            $growth_yoy = '0';
          }else {
            $growth_yoy = round((($qty_bln - $qty_thn_kmrn) / $qty_thn_kmrn)*100,2);
          }

           if ($qty_thn_kmrn_kum == '0') {
            # code...
            $growth_kum_yoy = '0';
          }else {
            $growth_kum_yoy = round((($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum)*100,2);
          }

          $namaProv = $row['NM_PROV'];
        $temp[$namaProv] = array(
            // 'NAMA' => $row['NAMA_PERUSAHAAN'],
            'PROV' => $row['NM_PROV'],
            'INISIAL_PROV' => $row['PROVINSI'],
            'VOLUME_BULAN' => $row['QTY'],
            'MS_BULAN' => round($row['QTY_REAL'],2),


            'LAST_VOLUME_BULAN' => $row['REAL_BULAN'],
            'LAST_MS_BULAN' => round($row['QTY_BULAN'],2),

            'MS_TAHUN_KUM' => round($row['QTY_TAHUNINI_KUM'],2),
            'TAHUN_VOLUME_KUM' => $row['REAL_TAHUNINI_KUM'],

            'LAST_VOLUME_TAHUN' => $row['REAL_TAHUN'],
            'LAST_MS_TAHUN' => round($row['QTY_TAHUN'],2),
            
            // 'LAST_MS_TAHUN_KUM' => '',
            // 'LAST_VOLUME_TAHUN_KUM' => $row['REAL_TAHUN_KUM'],

            'TARGET' => round($row['TARGET_RKAP'])
            
          );

        // $temp[$company] = $row;
        $temp[$namaProv]['GROWTH'] = array(
            'MOM' => $growth_mom,
            'YOY' => $growth_yoy,
            'KUM_YOY' => $growth_kum_yoy,
            // 'LAST_KUM_YOY' => ''
          );
        $jsonArray[$company] = $temp;
      }

      echo json_encode($jsonArray);

    }
    
    
}