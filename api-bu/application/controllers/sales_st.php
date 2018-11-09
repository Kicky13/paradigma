<?php
header('Access-Control-Allow-Origin:*');
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_st extends CI_Controller {

    public function __construct()   {
        parent::__construct();
        $this->db= $this->load->database('tonasa',true);
    }

    public function index()   {

        $bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $tanggal = $tahun.'-'.$bulan.'-01';
        $bulan_now = $tahun.'-'.$bulan;
        $tanggal_now = $tahun.'-'.$bulan.'-'.date('d');
        $tanggal_last = $tahun.'-'.$bulan.'-31';
        $tahun_prev = $tahun-1;
        $tanggal_prev = $tahun_prev.'-'.$bulan.'-01'; 
        $bulan_prev= $tahun_prev.'-'.$bulan; 

        //OVERVIEW
        // $sql_real=$this->db->query("SELECT SUM(TON) AS TON FROM T_ZCSD2155 WHERE WADAT_IST = '".$tanggal."' AND LFART IN ('ZLFP','ZLF','ZLC')")->row();
        $sql_rkap=$this->db->query("SELECT SUM(RKAP) AS RKAP,SUM(PROGNOSA) AS PROGNOSA FROM RKAP_DAILY WHERE DATE_FORMAT(DATE,'%Y-%m')='".$bulan_now."'")->row();
        $sql_real_prev=$this->db->query("SELECT SUM(TON) AS TON FROM T_ZCSD2155 WHERE WADAT_IST = '".$tanggal_prev."' AND LFART IN ('ZLFP','ZLF','ZLC')")->row();
        $sql_rkap_prev=$this->db->query("SELECT SUM(RKAP) AS RKAP,SUM(PROGNOSA) AS PROGNOSA FROM RKAP_DAILY WHERE DATE_FORMAT(DATE,'%Y-%m')='".$bulan_prev."'")->row();

        //tahun sekarang
        $sql_real_klinker_ekspor=$this->db->query("SELECT SUM(TON) AS TON FROM KLINKER_EKSPORT_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_now'")->row();
        $sql_real_klinker_ics=$this->db->query("SELECT SUM(TON) AS TON FROM KLINKER_ICS_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_now'")->row();
        $sql_real_klinker_no_ics=$this->db->query("SELECT SUM(TON) AS TON FROM KLINKER_NO_ICS_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_now'")->row();

        $sql_real_wilayah_ekspor=$this->db->query("SELECT SUM(TON) AS TON FROM WILAYAH_EKSPORT_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_now'")->row();
        $sql_real_wilayah_ics=$this->db->query("SELECT SUM(TON) AS TON FROM WILAYAH_ICS_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_now'")->row();
        $sql_real_wilayah_no_ics=$this->db->query("SELECT SUM(TON) AS TON FROM WILAYAH_NO_ICS_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_now'")->row();


        $tot_real=$sql_real_klinker_ekspor->TON+$sql_real_klinker_ics->TON+$sql_real_klinker_no_ics->TON+$sql_real_wilayah_ekspor->TON+$sql_real_wilayah_ics->TON+$sql_real_wilayah_no_ics->TON;


        //tahun lalu
        $sql_real_klinker_ekspor_prev=$this->db->query("SELECT SUM(TON) AS TON FROM KLINKER_EKSPORT_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_prev'")->row();
        $sql_real_klinker_ics_prev=$this->db->query("SELECT SUM(TON) AS TON FROM KLINKER_ICS_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_prev'")->row();
        $sql_real_klinker_no_ics_prev=$this->db->query("SELECT SUM(TON) AS TON FROM KLINKER_NO_ICS_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_prev'")->row();

        $sql_real_wilayah_ekspor_prev=$this->db->query("SELECT SUM(TON) AS TON FROM WILAYAH_EKSPORT_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_prev'")->row();
        $sql_real_wilayah_ics_prev=$this->db->query("SELECT SUM(TON) AS TON FROM WILAYAH_ICS_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_prev'")->row();
        $sql_real_wilayah_no_ics_prev=$this->db->query("SELECT SUM(TON) AS TON FROM WILAYAH_NO_ICS_V WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_prev'")->row();

         $tot_real_prev=$sql_real_klinker_ekspor_prev->TON+$sql_real_klinker_ics_prev->TON+$sql_real_klinker_no_ics_prev->TON+$sql_real_wilayah_ekspor_prev->TON+$sql_real_wilayah_ics_prev->TON+$sql_real_wilayah_no_ics_prev->TON;


        // $data['TOTAL']=array('REAL'=>$sql_real->TON,'RKAP'=>$sql_rkap->RKAP,'REAL PREV'=>$sql_real_prev->TON);
        $data['TOTAL']=array('REAL'=>$tot_real,'RKAP'=>$sql_rkap->RKAP,'REAL PREV'=>$tot_real_prev);
        
        //CHART
        $chart_real=$this->db->query("SELECT WADAT_IST,SUM(TON)AS TON FROM T_ZCSD2155 WHERE DATE_FORMAT(WADAT_IST,'%Y-%m') = '".$tahun."-".$bulan."' AND LFART IN ('ZLFP','ZLF','ZLC') GROUP BY WADAT_IST");
        foreach ($chart_real->result() as $row) {
            $chart_rkap=$this->db->query("SELECT SUM(RKAP) AS RKAP,SUM(PROGNOSA) AS PROGNOSA FROM RKAP_DAILY WHERE DATE='".$row->WADAT_IST."'")->row();
            $data['CHART'][]=array('RKAP'=>$chart_rkap->RKAP,'PROGNOSA'=>$chart_rkap->PROGNOSA,'REAL'=>$row->TON);
        }

        //RKAP, PROGNOSA & HARI OPERASI WILAYAH
        $wilayah=array('1','2','3');
        foreach ($wilayah as $value) {
            $wilayah_rkap=$this->db->query("SELECT OPCO,KEMASAN,SUM(RKAP) AS RKAP ,SUM(PROGNOSA) AS PROGNOSA FROM RKAP_DAILY WHERE OPCO=4000 AND WILAYAH='$value' AND DATE_FORMAT(DATE,'%Y-%m') = '".$tahun."-".$bulan."'");
            $wilayah_hari=$this->db->query("SELECT DATE FROM RKAP_DAILY WHERE OPCO=4000 AND WILAYAH='$value' AND DATE_FORMAT(DATE,'%Y-%m') = '".$tahun."-".$bulan."' AND PROGNOSA !=0 GROUP BY DATE")->num_rows();
            $wilayah_sisa_hari=$this->db->query("
                SELECT
                    RKAP_DAILY.WILAYAH,
                    RKAP_DAILY.PROGNOSA,
                    T_ZCSD2155.TON AS REALISASI,
                    T_ZCSD2155.WADAT_IST,
                    ZREPORT_SCM_KABIRO_SALES.ID_PROV
                FROM
                    RKAP_DAILY
                    INNER JOIN ZREPORT_SCM_KABIRO_SALES ON ZREPORT_SCM_KABIRO_SALES.ORG = RKAP_DAILY.OPCO AND ZREPORT_SCM_KABIRO_SALES.ID_REGION = RKAP_DAILY.WILAYAH
                    INNER JOIN T_ZCSD2155 ON T_ZCSD2155.VKORG = ZREPORT_SCM_KABIRO_SALES.ORG AND T_ZCSD2155.VKBUR = ZREPORT_SCM_KABIRO_SALES.ID_PROV
                WHERE
                    RKAP_DAILY.WILAYAH='$value'
                    AND RKAP_DAILY.DATE BETWEEN '$tanggal_now' AND '$tanggal_last'
                    AND T_ZCSD2155.WADAT_IST BETWEEN '$tanggal_now' AND '$tanggal_last'
                    AND RKAP_DAILY.PROGNOSA != 0
                    AND T_ZCSD2155.TON = 0
                GROUP BY
                    T_ZCSD2155.WADAT_IST")->num_rows();

            foreach ($wilayah_rkap->result_array() as $row) {
                $data['RKAP']['WILAYAH'][]=$row['RKAP'];
                $data['PROGNOSA']['WILAYAH'][]=$row['PROGNOSA'];
                $data['HARI_OPERASI']['WILAYAH'][]=$wilayah_hari;
                $data['SISA_HARI_OPERASI']['WILAYAH'][]=$wilayah_sisa_hari;
            }
        }


        $jenis=array('Domestik','Ekspor','ICS');
        foreach ($jenis as $value) {
            $wilayah_rkap=$this->db->query("SELECT OPCO,KEMASAN,SUM(RKAP) AS RKAP ,SUM(PROGNOSA) AS PROGNOSA FROM RKAP_DAILY WHERE OPCO=4000 AND JENIS_PENJUALAN='$value' AND DATE_FORMAT(DATE,'%Y-%m') = '".$tahun."-".$bulan."'");
            $wilayah_hari=$this->db->query("SELECT DATE FROM RKAP_DAILY WHERE OPCO=4000 AND JENIS_PENJUALAN='$value' AND DATE_FORMAT(DATE,'%Y-%m') = '".$tahun."-".$bulan."' AND PROGNOSA !=0 GROUP BY DATE")->num_rows();
            $wilayah_sisa_hari=$this->db->query("
                SELECT
                    RKAP_DAILY.JENIS_PENJUALAN,
                    RKAP_DAILY.PROGNOSA,
                    T_ZCSD2155.TON AS REALISASI,
                    T_ZCSD2155.WADAT_IST,
                    ZREPORT_SCM_KABIRO_SALES.ID_PROV
                FROM
                    RKAP_DAILY
                    INNER JOIN ZREPORT_SCM_KABIRO_SALES ON ZREPORT_SCM_KABIRO_SALES.ORG = RKAP_DAILY.OPCO AND ZREPORT_SCM_KABIRO_SALES.ID_REGION = RKAP_DAILY.WILAYAH
                    INNER JOIN T_ZCSD2155 ON T_ZCSD2155.VKORG = ZREPORT_SCM_KABIRO_SALES.ORG AND T_ZCSD2155.VKBUR = ZREPORT_SCM_KABIRO_SALES.ID_PROV
                WHERE
                    RKAP_DAILY.JENIS_PENJUALAN='$value'
                    AND RKAP_DAILY.DATE BETWEEN '$tanggal_now' AND '$tanggal_last'
                    AND T_ZCSD2155.WADAT_IST BETWEEN '$tanggal_now' AND '$tanggal_last'
                    AND RKAP_DAILY.PROGNOSA != 0
                    AND T_ZCSD2155.TON = 0
                GROUP BY
                    T_ZCSD2155.WADAT_IST")->num_rows();
            foreach ($wilayah_rkap->result_array() as $row) {
                $data['RKAP']['WILAYAH'][]=$row['RKAP'];
                $data['PROGNOSA']['WILAYAH'][]=$row['PROGNOSA'];
                $data['HARI_OPERASI']['WILAYAH'][]=$wilayah_hari;
                $data['SISA_HARI_OPERASI']['WILAYAH'][]=$wilayah_sisa_hari;
            }
        }

        //CLINKER
        $clinker=$this->db->query("SELECT SUM(RKAP) AS RKAP,SUM(PROGNOSA) AS PROGNOSA FROM RKAP_DAILY WHERE DATE_FORMAT(DATE,'%Y-%m')='$bulan_now' AND PRODUK = 2")->row();
        $data['RKAP']['WILAYAH'][]=$clinker->RKAP;
        $data['PROGNOSA']['WILAYAH'][]=$clinker->PROGNOSA;
        $data['HARI_OPERASI']['WILAYAH'][]=0;
        $data['SISA_HARI_OPERASI']['WILAYAH'][]=0;

        //PERCENT RKAP WILAYAH
        $i=0;
        foreach($data['PROGNOSA']['WILAYAH'] as $k => $v){
            if(isset($data['RKAP']['WILAYAH'][$i])){
                $data['PERCENT_RKAP']['WILAYAH'][]=($v/$data['RKAP']['WILAYAH'][$i])*100;
            }else{
                $data['PERCENT_RKAP']['WILAYAH'][]=0;
            }
            $i++;
        }
 
        //REAL WILAYAH
        // $wilayah_real=$this->db->query("SELECT T_ZCSD2155.VKORG,ZREPORT_SCM_KABIRO_SALES.ID_REGION,SUM(T_ZCSD2155.TON) AS REALISASI FROM ZREPORT_SCM_KABIRO_SALES INNER JOIN T_ZCSD2155 ON T_ZCSD2155.VKORG=ZREPORT_SCM_KABIRO_SALES.ORG AND T_ZCSD2155.VKBUR=ZREPORT_SCM_KABIRO_SALES.ID_PROV WHERE DATE_FORMAT(WADAT_IST,'%Y-%m') = '".$tahun."-".$bulan."' GROUP BY ZREPORT_SCM_KABIRO_SALES.ID_REGION");
        $wilayah_real=$this->db->query("SELECT
                                        ZREPORT_SCM_KABIRO_SALES.ID_REGION,
                                        Sum(WILAYAH_NO_ICS_V.TON) AS REALISASI
                                        FROM
                                        WILAYAH_NO_ICS_V
                                        INNER JOIN ZREPORT_SCM_KABIRO_SALES ON WILAYAH_NO_ICS_V.VKBUR = ZREPORT_SCM_KABIRO_SALES.ID_PROV
                                        WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$bulan_now'
                                        GROUP BY ID_REGION");
        foreach ($wilayah_real->result_array() as $row) {
            $data['REAL']['WILAYAH'][]=$row['REALISASI'];
        }
        $jenis_wil=array('WILAYAH_NO_ICS_V','WILAYAH_EKSPORT_V','WILAYAH_ICS_V');
        foreach ($jenis_wil as $value) {
            $wilayah_real=$this->db->query("SELECT SUM( $value.TON ) AS REALISASI FROM $value WHERE DATE_FORMAT(WADAT_IST,'%Y-%m') = '".$tahun."-".$bulan."'");
            foreach ($wilayah_real->result_array() as $row) {
                $retVal = (is_null($row['REALISASI'])) ? 0 : $row['REALISASI'] ;
                $data['REAL']['WILAYAH'][]=$retVal;
            }
        }
         $data['REAL']['WILAYAH'][]= $sql_real_klinker_ekspor->TON+$sql_real_klinker_ics->TON+$sql_real_klinker_no_ics->TON;

        //SISA PROGNOSA WILAYAH
        $j=0;
        foreach($data['PROGNOSA']['WILAYAH'] as $k => $v){
            if(isset($data['REAL']['WILAYAH'][$j])){
                $data['SISA_PROGNOSA']['WILAYAH'][]=$v-$data['REAL']['WILAYAH'][$j];
            }else{
                $data['SISA_PROGNOSA']['WILAYAH'][]=0;
            }
            $j++;
        } 

        //KAPASITAS SISA HARI WILAYAH
        $h=0;
        foreach($data['SISA_PROGNOSA']['WILAYAH'] as $k => $v){
            if($data['SISA_HARI_OPERASI']['WILAYAH'][$h] != 0){
                $data['KAPASITAS_SISA_HARI']['WILAYAH'][]=$v/$data['SISA_HARI_OPERASI']['WILAYAH'][$h];
            }else{
                $data['KAPASITAS_SISA_HARI']['WILAYAH'][]=0;
            }
            $h++;
        } 

        //KAPASITAS REAL WILAYAH
        $o=0;
        foreach($data['REAL']['WILAYAH'] as $k => $v){
            if($data['HARI_OPERASI']['WILAYAH'][$o] != 0){
                $data['KAPASITAS_REAL']['WILAYAH'][]=$v/$data['HARI_OPERASI']['WILAYAH'][$o];
            }else{
                $data['KAPASITAS_REAL']['WILAYAH'][]=0;
            }
            $o++;
        } 


        //RKAP, PROGNOSE & HARI OPERASI KEMASAN
        $kemasan=array('BAG','CURAH');
        foreach ($kemasan as $value) {
            $kemasan_rkap=$this->db->query("SELECT SUM(RKAP) AS RKAP ,SUM(PROGNOSA) AS PROGNOSA FROM RKAP_DAILY WHERE OPCO=4000 AND KEMASAN='$value' AND DATE_FORMAT(DATE,'%Y-%m') = '".$tahun."-".$bulan."'");
            $kemasan_hari=$this->db->query("SELECT DATE FROM RKAP_DAILY WHERE OPCO=4000 AND KEMASAN='$value' AND DATE_FORMAT(DATE,'%Y-%m') = '".$tahun."-".$bulan."' AND PROGNOSA !=0 GROUP BY DATE")->num_rows();
            $kemasan_sisa_hari=$this->db->query("
                SELECT
                    RKAP_DAILY.KEMASAN,
                    RKAP_DAILY.PROGNOSA,
                    T_ZCSD2155.TON AS REALISASI,
                    T_ZCSD2155.WADAT_IST,
                    ZREPORT_SCM_KABIRO_SALES.ID_PROV
                FROM
                    RKAP_DAILY
                    INNER JOIN ZREPORT_SCM_KABIRO_SALES ON ZREPORT_SCM_KABIRO_SALES.ORG = RKAP_DAILY.OPCO AND ZREPORT_SCM_KABIRO_SALES.ID_REGION = RKAP_DAILY.WILAYAH
                    INNER JOIN T_ZCSD2155 ON T_ZCSD2155.VKORG = ZREPORT_SCM_KABIRO_SALES.ORG AND T_ZCSD2155.VKBUR = ZREPORT_SCM_KABIRO_SALES.ID_PROV
                WHERE
                    RKAP_DAILY.KEMASAN='$value'
                    AND RKAP_DAILY.DATE BETWEEN '$tanggal_now' AND '$tanggal_last'
                    AND T_ZCSD2155.WADAT_IST BETWEEN '$tanggal_now' AND '$tanggal_last'
                    AND RKAP_DAILY.PROGNOSA != 0
                    AND T_ZCSD2155.TON = 0
                GROUP BY
                    T_ZCSD2155.WADAT_IST
                ")->num_rows();
            foreach ($kemasan_rkap->result_array() as $row) {
                $data['RKAP']['KEMASAN'][]=$row['RKAP'];
                $data['PROGNOSA']['KEMASAN'][]=$row['PROGNOSA'];
                $data['HARI_OPERASI']['KEMASAN'][]=$kemasan_hari;
                $data['SISA_HARI_OPERASI']['KEMASAN'][]=$kemasan_sisa_hari;
            }

        }

        $data['RKAP']['KEMASAN'][]=$clinker->RKAP;
        $data['PROGNOSA']['KEMASAN'][]=$clinker->PROGNOSA;
        $data['HARI_OPERASI']['KEMASAN'][]=0;
        $data['SISA_HARI_OPERASI']['KEMASAN'][]=0;

        //PERCENT RKAP WILAYAH
        $x=0;
        foreach($data['PROGNOSA']['KEMASAN'] as $k => $v){
            if(isset($data['RKAP']['KEMASAN'][$x])){
                $data['PERCENT_RKAP']['KEMASAN'][]=($v/$data['RKAP']['KEMASAN'][$x])*100;
            }else{
                $data['PERCENT_RKAP']['KEMASAN'][]=0;
            }
            $x++;
        }

        //REAL KEMASAN
        $real_kmsn = array('121-200%','121-301%','121-302%');
        foreach ($real_kmsn as $value) {
        $kemasan_real = $this->db->query("SELECT SUM(TON) AS REALISASI FROM T_ZCSD2155 WHERE DATE_FORMAT(WADAT_IST,'%Y-%m') = '".$tahun."-".$bulan."' AND MATNR LIKE '$value'");
        foreach ($kemasan_real->result_array() as $row) {
                $data['REAL']['KEMASAN'][]=$row['REALISASI'];
            }
        }
        // $data['REAL']['KEMASAN'][]= $sql_real_klinker_ekspor->TON+$sql_real_klinker_ics->TON+$sql_real_klinker_no_ics->TON;

        //SISA PROGNOSA KEMASAN
        $y=0;
        foreach($data['PROGNOSA']['KEMASAN'] as $k => $v){
            if(isset($data['REAL']['KEMASAN'][$y])){
                $data['SISA_PROGNOSA']['KEMASAN'][]=$v-$data['REAL']['KEMASAN'][$y];
            }else{
                $data['SISA_PROGNOSA']['KEMASAN'][]=0;
            }
            $y++;
        }

        //KAPASITAS SISA HARI KEMASAN
        $z=0;
        foreach($data['SISA_PROGNOSA']['KEMASAN'] as $k => $v){
            if($data['SISA_HARI_OPERASI']['KEMASAN'][$z] != 0){
                $data['KAPASITAS_SISA_HARI']['KEMASAN'][]=$v/$data['SISA_HARI_OPERASI']['KEMASAN'][$z];
            }else{
                $data['KAPASITAS_SISA_HARI']['KEMASAN'][]=0;
            }
            $z++;
        } 

        //KAPASITAS REAL KEMASAN
        $p=0;
        foreach($data['REAL']['KEMASAN'] as $k => $v){
            if(isset($data['HARI_OPERASI']['KEMASAN'][$p]) && $data['HARI_OPERASI']['KEMASAN'][$p] != 0){
                $data['KAPASITAS_REAL']['KEMASAN'][]=$v/$data['HARI_OPERASI']['KEMASAN'][$p];
            }else{
                $data['KAPASITAS_REAL']['KEMASAN'][]=0;
            }
            $p++;
        } 

        echo json_encode($data);
    }


    public function wilayah_detail()
    {
        $data=array();
        $bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
        $tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
        $ArryaWil=array(1,2,3);
        $tanggal=$tahun.'-'.$bulan;

        //rkap_propinsi
        $tot_real=0;
        $tot_rkap=0;
        $tot_prognosa=0;
        foreach ($ArryaWil as $wilayah) {
        $rkap_propinsi=$this->db->query("SELECT
                                            KODE_PROPINSI,
                                            DISTRIK,
                                            SUM(RKAP) AS RKAP,
                                            SUM(PROGNOSA) AS PROGNOSA
                                            FROM
                                            RKAP_DAILY
                                            WHERE
                                            DATE_FORMAT(DATE, '%Y-%m') = '$tanggal'
                                            AND WILAYAH = $wilayah
                                            GROUP BY KODE_PROPINSI
                                        ")->result_array(); 
         foreach ($rkap_propinsi as $row) {

        //realpropinsi
        $real_propinsi1=$this->db->query("SELECT
                                        WILAYAH_NO_ICS_V.VKORG,
                                        WILAYAH_NO_ICS_V.WERKS,
                                        -- SUM(WILAYAH_NO_ICS_V.NTGEW) AS NTGEW,
                                        SUM(WILAYAH_NO_ICS_V.TON) AS NTGEW,
                                        WILAYAH_NO_ICS_V.GEWEI,
                                        -- WILAYAH_NO_ICS_V.TON,
                                        WILAYAH_NO_ICS_V.KET_TON,
                                        WILAYAH_NO_ICS_V.VKBUR
                                        FROM
                                        WILAYAH_NO_ICS_V
                                        WHERE DATE_FORMAT(WADAT_IST,'%Y-%m')='$tanggal'
                                        AND WILAYAH_NO_ICS_V.VKBUR=".$row['KODE_PROPINSI']."
                                        GROUP BY
                                        WILAYAH_NO_ICS_V.VKBUR"
                                    );
            if($real_propinsi1->num_rows()>0){
                 $real_propinsi= $real_propinsi1->row();
                 $NTGEW=$real_propinsi->NTGEW;
            }else{
                 $NTGEW=0;
                 
            }
           
            if($row['RKAP']==0||is_null($row['RKAP'])){
                $PERCENT_REAL=0;
            }else{
                $PERCENT_REAL=($NTGEW/$row['RKAP'])*100;
            }

            if(is_null($row['PROGNOSA'])||$row['PROGNOSA']==0){
                $PERCENT_PROGNOSA=0;
            }else{
                $PERCENT_PROGNOSA=($NTGEW/$row['PROGNOSA'])*100;
            }

            
            

            $data[$wilayah][]=array('DISTRIK'=>$row['DISTRIK'],'REAL'=>$NTGEW,'RKAP'=>$row['RKAP'],'PROGNOSA'=>$row['PROGNOSA'],'PERCENT_REAL'=>$PERCENT_REAL,'PERCENT_PROGNOSA'=>$PERCENT_PROGNOSA);
            
        }
        $tot_rkap=$this->db->query("SELECT
                                    SUM(RKAP) AS RKAP,
                                    SUM(PROGNOSA) AS PROGNOSA
                                FROM
                                    RKAP_DAILY
                                WHERE
                                    DATE_FORMAT(DATE, '%Y-%m') = '$tanggal'
                                AND WILAYAH = $wilayah")->row();
        $tot_real=$this->db->query("SELECT
                                        ZREPORT_SCM_KABIRO_SALES.ID_REGION,
                                        SUM(WILAYAH_NO_ICS_V.TON) AS TON
                                        FROM
                                        WILAYAH_NO_ICS_V
                                        INNER JOIN ZREPORT_SCM_KABIRO_SALES ON WILAYAH_NO_ICS_V.VKBUR = ZREPORT_SCM_KABIRO_SALES.ID_PROV
                                        WHERE
                                        DATE_FORMAT(WADAT_IST,'%Y-%m') = '$tanggal'
                                        AND ID_REGION =$wilayah")->row();

        $data['TOTAL'][$wilayah]=array('REAL'=>$tot_real->TON,'RKAP'=>$tot_rkap->RKAP,'PROGNOSA'=>$tot_rkap->PROGNOSA);
         
    }

        echo json_encode($data);

    }


    public function bulan($bulan)
    {
        switch ($bulan) {
            case '01':
                $bln=1;
                break;
            case '02':
                    $bln=2;
                break;
            case '03':
                    $bln=3;
                    break;
            case '04':
                    $bln=4;
                    break;
            case '05':
                    $bln=5;
                    break;
            case '06':
                    $bln=6;
                    break;
            case '07':
                    $bln=7;
                    break;
            case '08':
                    $bln=8;
                    break;
            case '09':
                    $bln=9;
                    break;
            default:
                $bln = $bulan;
                break;
        }

        return $bln;
    }

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

