<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtest3000 extends CI_Model {

	public function get_realisasi($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $realisasi=$db->query("select vkorg org, sum(real) as realisasi, tanggal from(    
                        select vkorg, sum(ton) as real, to_char(wadat_ist,'DD') tanggal from ZREPORT_ONGKOSANGKUT_MOD 
                        where 
                          to_char(wadat_ist,'YYYYMM')='$date'
                          and LFART <> 'ZNL'
                          and  (
                            (matnr like '121-301%' and matnr <> '121-301-0240') or 
                            (matnr like '121-302%')
                          )
                        and vkorg = '3000' and vkbur not in ('0001','1092')
                        and kunag not in ('0000040084','0000040147','0000040272') 
                        group by vkorg, to_char(wadat_ist,'DD')
                        union
                        select vkorg, sum(ton) as real, to_char(wadat_ist,'DD') tanggal from ZREPORT_ONGKOSANGKUT_MOD 
                        where VKORG='3000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$date'
                          and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                          and kunag not in ('0000040084','0000040147','0000040272') and vkbur not in ('0001','1092')
                        group by vkorg, to_char(wadat_ist,'DD')
                      )
                      group by vkorg, tanggal");
    return $realisasi->result();
  }

  public function get_ekspor($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $ekspor=$db->query("SELECT TB1.ORG, NVL(TB6.PROG,0) PROG, TB3.RKAP, NVL(TB4.REAL_EKSPOR,0) REAL_EKSPOR, 
            NVL(TB5.RKAP_EKSPOR,0) RKAP_EKSPOR, NVL(TB1.PROGNOSE_HARIAN,0) PROGNOSE_HARIAN FROM (
                        select * from (
                            select a.co ORG, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as prognose_harian
                            from sap_t_rencana_sales_type a
                            left join zreport_porsi_sales_region c on c.region=5
                              and c.vkorg= a.co and c.budat like '$date%' and c.tipe = a.tipe
                            left join (
                              select region, tipe,  sum(porsi) as total_porsi
                              from zreport_porsi_sales_region
                              where budat like '$date%' and VKORG = '3000'
                              group by region, tipe
                            )d on c.region = d.region and d.tipe = a.tipe
                            where co = '3000' and thn = '$tahun' and bln = '$bulan'
                            and prov!='0001' and prov!='1092'
                            group by co, thn, bln, c.budat
                          )
                          where budat = '$date$hari'
                        ) TB1
                      LEFT JOIN (
                        select a.co org, sum(a.quantum) as rkap
                          from sap_t_rencana_sales_type a
                          where co = '3000' and thn = '$tahun' and bln = '$bulan' and a.prov!='0001' and a.prov!='1092'
                          group by a.co
                      )TB3
                      ON TB1.ORG = TB3.ORG 
                      LEFT JOIN (
                        select org, sum(real) as real_ekspor from(
                          select vkorg as org, sum(ton) as real
                          from zreport_ongkosangkut_mod 
                          where                 
                          to_char(wadat_ist,'yyyymm') ='$date'
                          and vkorg = '3000'
                          and vkbur='0001'
                          group by vkorg
                          union
                          select vkorg as org, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='3000' and LFART='ZLR' and
                          to_char(wadat_ist,'YYYYMM')='$date'
                          and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                          and vkbur ='0001' 
                          group by vkorg
                          )
                          group by org
                      )TB4
                      ON TB1.ORG = TB4.ORG
                      LEFT JOIN (
                        select a.co org, sum(a.quantum) as rkap_ekspor
                          from sap_t_rencana_sales_type a
                          where co = '3000' and thn = '$tahun' and bln = '$bulan' and a.prov='0001'
                          group by a.co
                      )TB5
                      ON TB1.ORG = TB5.ORG
                      LEFT JOIN (
                        select ORG,sum(target_realh) as prog 
                        from(
                          select * from (
                            select a.co ORG, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as target_realh
                            from sap_t_rencana_sales_type a
                            left join zreport_porsi_sales_region c on c.region=5
                              and c.vkorg= a.co and c.budat like '$date%' and c.tipe = a.tipe
                            left join (
                              select region, tipe,  sum(porsi) as total_porsi
                              from zreport_porsi_sales_region
                              where budat like '$date%' and VKORG = '3000'
                              group by region, tipe
                            )d on c.region = d.region and d.tipe = a.tipe
                            where co = '3000' and thn = '$tahun' and bln = '$bulan'
                            and prov!='0001' and prov!='1092'
                            group by co, thn, bln, c.budat
                          )
                          where budat > '$date$hari'
                        ) group by ORG
                    )TB6
                    ON TB1.ORG = TB6.ORG");
    return $ekspor->result();
  }


public function get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu,$hariawal)
  {
    $db=$this->load->database('default5',true);
    $realisasilalu=$db->query("select vkorg org, sum(real) as realisasi, tanggal from(    
                        select vkorg, sum(ton) as real, to_char(wadat_ist,'DD') tanggal from ZREPORT_ONGKOSANGKUT_MOD 
                        where 
                          to_char(wadat_ist,'YYYYMMDD') BETWEEN $hariawal AND $datelalu$hari
                          and LFART <> 'ZNL'
                          and  (
                            (matnr like '121-301%' and matnr <> '121-301-0240') or 
                            (matnr like '121-302%')
                          )
                        and vkorg = '3000' and vkbur not in ('0001','1092')
                        and kunag not in ('0000040084','0000040147','0000040272') 
                        group by vkorg, to_char(wadat_ist,'DD')
                        union
                        select vkorg, sum(ton) as real, to_char(wadat_ist,'DD') tanggal from ZREPORT_ONGKOSANGKUT_MOD 
                        where VKORG='3000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMMDD') BETWEEN $hariawal AND $datelalu$hari
                          and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                          and kunag not in ('0000040084','0000040147','0000040272') and vkbur not in ('0001','1092')
                        group by vkorg, to_char(wadat_ist,'DD')
                      )
                      group by vkorg, tanggal");
    return $realisasilalu->result();
  }

  public function get_realisasilalu1($tahunlalu,$bulan,$hari,$datelalu)
  {
    $db=$this->load->database('default5',true);
    $realisasi_l=$db->query("select vkorg org, sum(real) as realisasi, tanggal from(    
                        select vkorg, sum(ton) as real, to_char(wadat_ist,'DD') tanggal from ZREPORT_ONGKOSANGKUT_MOD 
                        where 
                          to_char(wadat_ist,'YYYYMM')='$datelalu'
                          and LFART <> 'ZNL'
                          and  (
                            (matnr like '121-301%' and matnr <> '121-301-0240') or 
                            (matnr like '121-302%')
                          )
                        and vkorg = '3000' and vkbur not in ('0001','1092')
                        and kunag not in ('0000040084','0000040147','0000040272') 
                        group by vkorg, to_char(wadat_ist,'DD')
                        union
                        select vkorg, sum(ton) as real, to_char(wadat_ist,'DD') tanggal from ZREPORT_ONGKOSANGKUT_MOD 
                        where VKORG='3000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$datelalu'
                          and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                          and kunag not in ('0000040084','0000040147','0000040272') and vkbur not in ('0001','1092')
                        group by vkorg, to_char(wadat_ist,'DD')
                      )
                      group by vkorg, tanggal");
    return $realisasi_l->result();
  }

  public function get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu)
  {
    $db=$this->load->database('default5',true);
    $eksporlalu=$db->query("SELECT TB1.ORG, TB1.REAL_EKSPOR, TB2.RKAP_EKSPOR FROM (select org, sum(real) as real_ekspor from(
                          select vkorg as org, sum(ton) as real
                          from zreport_ongkosangkut_mod 
                          where                 
                          to_char(wadat_ist,'yyyymm') ='$datelalu'
                          and vkorg = '3000'
                          and vkbur='0001'
                          group by vkorg
                          union
                          select vkorg as org, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='3000' and LFART='ZLR' and
                          to_char(wadat_ist,'YYYYMM')='$datelalu'
                          and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                          and vkbur ='0001' 
                          group by vkorg
                          )
                          group by org
                          )TB1
                          LEFT JOIN
                          (select a.co org, sum(a.quantum) as rkap_ekspor
                          from sap_t_rencana_sales_type a
                          where co = '3000' and thn = '$tahunlalu' and bln = '$bulan' and a.prov='0001'
                          group by a.co)TB2
                          ON TB1.ORG=TB2.ORG");
    return $eksporlalu->result();
  }

  public function get_realisasi_h($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $realisasi_h=$db->query("select vkorg org, sum(real) as realisasi, tanggal from(    
                        select vkorg, sum(ton) as real, to_char(wadat_ist,'DD') tanggal from ZREPORT_ONGKOSANGKUT_MOD 
                        where 
                          to_char(wadat_ist,'YYYYMM')='$date'
                          and LFART <> 'ZNL'
                          and  (
                            (matnr like '121-301%' and matnr <> '121-301-0240') or 
                            (matnr like '121-302%')
                          )
                        and vkorg = '3000' and vkbur not in ('0001','1092')
                        and kunag not in ('0000040084','0000040147','0000040272') 
                        group by vkorg, to_char(wadat_ist,'DD')
                        union
                        select vkorg, sum(ton) as real, to_char(wadat_ist,'DD') tanggal from ZREPORT_ONGKOSANGKUT_MOD 
                        where VKORG='3000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$date'
                          and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                          and kunag not in ('0000040084','0000040147','0000040272') and vkbur not in ('0001','1092')
                        group by vkorg, to_char(wadat_ist,'DD')
                      )
                      group by vkorg, tanggal");
    return $realisasi_h->result();
  }

}

/* End of file mtest3000.php */
/* Location: ./application/models/stokpp&gudang/mtest3000.php */