<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_volproduksi6000 extends CI_Model {

	public function get_progrkap($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $progrkap=$db->query("SELECT TB0.ORG, NVL(TB2.PROG,0) PROG, NVL(TB1.RKAP,0) RKAP FROM (
                            SELECT '6000' ORG FROM DUAL
                      ) TB0
                      LEFT JOIN (
                      select ORG,sum(TARGET) as RKAP
                        from ZREPORT_TARGET_PLANTSCO where DELETE_MARK=0 and JENIS is null
                        and ORG='6000' and BULAN='$bulan' and TAHUN='$tahun' and PLANT not in ('0001','1092')
                        and TIPE!='121-200'
                        group by org
                      ) TB1 ON TB0.ORG = TB1.ORG
                      LEFT JOIN (
                        SELECT ORG, SUM(PROG) PROG 
                        FROM ZREPORT_RKAP_PROG_SALES 
                        WHERE ORG = '6000' AND THN = '$tahun' AND BLN = '$bulan' AND HARI > '$hari'
                        GROUP BY ORG
                      )TB2
                      ON TB0.ORG = TB2.ORG");

    return $progrkap->result();
  }

  public function get_realisasi($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $realisasi=$db->query("select com org,sum(kwantumx) as realisasi, to_char(TGL_SPJ,'dd') tanggal
                        from zreport_rpt_real_tlcc where
                        to_char(TGL_SPJ,'yyyymm')='$date'
                        and order_type <>'ZNL' 
                        and propinsi_to like '6%'
                        and item_no like '121-3%' 
                        and com = '6000'
                        group by com, to_char(TGL_SPJ,'dd')");

    return $realisasi->result();

}
  public function get_realisasi_h($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $realisasi_h=$db->query("select com org,sum(kwantumx) as realisasi, to_char(TGL_SPJ,'dd') tanggal
                        from zreport_rpt_real_tlcc where
                        to_char(TGL_SPJ,'yyyymmdd')='$date$hari'
                        and order_type <>'ZNL' 
                        and propinsi_to like '6%'
                        and item_no like '121-3%' 
                        and com = '6000'
                        group by com, to_char(TGL_SPJ,'dd')");
    return $realisasi_h->result();
  }

  public function get_realisasi_l($tahunlalu,$bulan,$hari,$datelalu)
  {
    $db=$this->load->database('default5',true);
    $realisasi_l=$db->query("select com org,sum(kwantumx) as realisasi, to_char(TGL_SPJ,'dd') tanggal
                        from zreport_rpt_real_tlcc where
                        to_char(TGL_SPJ,'yyyymm')='$datelalu'
                        and order_type <>'ZNL' 
                        and propinsi_to like '6%'
                        and item_no like '121-3%' 
                        and com = '6000'
                        group by com, to_char(TGL_SPJ,'dd')");
    return $realisasi_l->result();
  }
  

  public function get_ekspor($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $ekspor=$db->query("select TB0.ORG, NVL(TB1.REAL_EKSPOR,0) REAL_EKSPOR_SM, NVL(TB3.REAL_EKSPOR,0) REAL_EKSPOR_TR, NVL(TB2.RKAP_EKSPOR,0) RKAP_EKSPOR FROM (
                    select '6000' org from dual ) TB0
                    LEFT JOIN (
      select com as ORG,'0001' as prov,'EXPORT' as NM_PROV,sum(kwantumx) as REAL_EKSPOR 
                          from zreport_rpt_real_tlcc where
                          to_char(TGL_SPJ,'yyyymm')='$date'
                          and order_type <>'ZNL' 
                          and propinsi_to not like '6%'
                          and item_no like '121-301%' 
                          and com = '6000'
                        GROUP BY COM
                      )TB1 ON TB0.ORG = TB1.ORG
                      LEFT JOIN(
                      select ORG,sum(TARGET) as RKAP_EKSPOR
                        from ZREPORT_TARGET_PLANTSCO where DELETE_MARK=0 and JENIS is null
                        and ORG='6000' and BULAN='$bulan' and TAHUN='$tahun' and PLANT='0001'
                        and TIPE!='121-200'
                        group by org
                      )TB2 ON TB0.ORG = TB2.ORG
                      LEFT JOIN (
      select com as ORG,'0001' as prov,'EXPORT' as NM_PROV,sum(kwantumx) as REAL_EKSPOR 
                          from zreport_rpt_real_tlcc where
                          to_char(TGL_SPJ,'yyyymm')='$date'
                          and order_type <>'ZNL' 
                          and propinsi_to not like '6%'
                          and item_no like '121-302%' 
                          and com = '6000'
                        GROUP BY COM
                      )TB3 ON TB0.ORG = TB3.ORG");

      return $ekspor->result();


  }

  public function get_progrkaplalu($tahunlalu,$bulan,$hari,$datelalu)
  {
    $db=$this->load->database('default5',true);
        $progrkaplalu=$db->query("SELECT TB0.ORG, NVL(TB2.PROG,0) PROG, NVL(TB1.RKAP,0) RKAP FROM (
                            SELECT '6000' ORG FROM DUAL
                      ) TB0
                      LEFT JOIN (
                      select ORG,sum(TARGET) as RKAP
                        from ZREPORT_TARGET_PLANTSCO where DELETE_MARK=0 and JENIS is null
                        and ORG='6000' and BULAN='$bulan' and TAHUN='$tahunlalu' and PLANT not in ('0001','1092')
                        and TIPE!='121-200'
                        group by org
                      ) TB1 ON TB0.ORG = TB1.ORG
                      LEFT JOIN (
                        SELECT ORG, SUM(PROG) PROG 
                        FROM ZREPORT_RKAP_PROG_SALES 
                        WHERE ORG = '6000' AND THN = '$tahunlalu' AND BLN = '$bulan' AND HARI > '$hari'
                        GROUP BY ORG
                      )TB2
                      ON TB0.ORG = TB2.ORG");

    return $progrkaplalu->result();
  }

  public function get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu,$hariawal)
  {
    $db=$this->load->database('default5',true);
        $realisasilalu=$db->query("select com org,sum(kwantumx) as realisasi, to_char(TGL_SPJ,'dd') tanggal
                        from zreport_rpt_real_tlcc where
                        to_char(TGL_SPJ,'yyyymmdd') BETWEEN $hariawal AND $datelalu$hari
                        and order_type <>'ZNL' 
                        and propinsi_to like '6%'
                        and item_no like '121-3%' 
                        and com = '6000'
                        group by com, to_char(TGL_SPJ,'dd')");
    return $realisasilalu->result();
  }

  public function get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu)
  {
    $db=$this->load->database('default5',true);
        $eksporlalu=$db->query("select TB0.ORG, NVL(TB1.REAL_EKSPOR,0) REAL_EKSPOR_SM, NVL(TB3.REAL_EKSPOR,0) REAL_EKSPOR_TR, NVL(TB2.RKAP_EKSPOR,0) RKAP_EKSPOR FROM (
                    select '6000' org from dual ) TB0
                    LEFT JOIN (
      select com as ORG,'0001' as prov,'EXPORT' as NM_PROV,sum(kwantumx) as REAL_EKSPOR 
                          from zreport_rpt_real_tlcc where
                          to_char(TGL_SPJ,'yyyymm')='$datelalu'
                          and order_type <>'ZNL' 
                          and propinsi_to not like '6%'
                          and item_no like '121-301%' 
                          and com = '6000'
                        GROUP BY COM
                      )TB1 ON TB0.ORG = TB1.ORG
                      LEFT JOIN(
                      select ORG,sum(TARGET) as RKAP_EKSPOR
                        from ZREPORT_TARGET_PLANTSCO where DELETE_MARK=0 and JENIS is null
                        and ORG='6000' and BULAN='$bulan' and TAHUN='$tahunlalu' and PLANT='0001'
                        and TIPE!='121-200'
                        group by org
                      )TB2 ON TB0.ORG = TB2.ORG
                      LEFT JOIN (
      select com as ORG,'0001' as prov,'EXPORT' as NM_PROV,sum(kwantumx) as REAL_EKSPOR 
                          from zreport_rpt_real_tlcc where
                          to_char(TGL_SPJ,'yyyymm')='$datelalu'
                          and order_type <>'ZNL' 
                          and propinsi_to not like '6%'
                          and item_no like '121-302%' 
                          and com = '6000'
                        GROUP BY COM
                      )TB3 ON TB0.ORG = TB3.ORG");
      return $eksporlalu->result();
  }

}

/* End of file m_volproduksi6000.php */
/* Location: ./application/models/stokpp&gudang/m_volproduksi6000.php */