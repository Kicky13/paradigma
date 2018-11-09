<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_volproduksi3000 extends CI_Model {

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
                      group by vkorg, tanggal order by tanggal");
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
                          to_char(wadat_ist,'YYYYMMDD')='$date$hari'
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
                        where VKORG='3000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMMDD')='$date$hari'
                          and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                          and kunag not in ('0000040084','0000040147','0000040272') and vkbur not in ('0001','1092')
                        group by vkorg, to_char(wadat_ist,'DD')
                      )
                      group by vkorg, tanggal");
    return $realisasi_h->result();
  }
  
  /// amin //
  function get_data($year,$month,$date){
        $db=$this->load->database('default5',true);
        $progrkap=$db->query("SELECT a.com,
                    a.domestik,
                    a.ekspor,
                    NVL (b.domestik, 0)   rkap_domestik,
                    NVL (b.rkap_expor, 0) rkap_ekspor,c.REAL_EKSPOR REAL_TERAK
               FROM (SELECT a.com, NVL (a.domestik, 0) domestik, NVL (b.ekspor, 0) ekspor
                       FROM (  SELECT com, SUM (realto) domestik
                                 FROM zreport_rptreal_resum
                                WHERE     tahun = '$year'
                                      AND bulan = '$month'
                                      AND com IN ('7000',
                                                  '3000',
                                                  '4000',
                                                  '6000')
                                      AND propinsi != '0001' and tipe != '121-200'
                             GROUP BY com) a
                            LEFT JOIN (  SELECT com, SUM (realto) ekspor
                                           FROM zreport_rptreal_resum
                                          WHERE    tahun = '$year'
                                   AND bulan = '$month'
                                      AND com IN ('7000',
                                                  '3000',
                                                  '4000',
                                                  '6000')
                                      AND propinsi = '0001' and tipe != '121-200' -- ini di buang yg terak tlcc
                                       GROUP BY com) b
                               ON a.com = b.com) a
                    LEFT JOIN
                    -- RKAP
                    (SELECT a.org, NVL (a.rkap_sd, 0) domestik, NVL (b.rkap, 0) rkap_expor
                       FROM (  SELECT org, SUM (target) rkap_sd
                                 FROM (  SELECT a.co ORG,
                                                c.budat,
                                                SUM (a.quantum * (c.porsi / d.total_porsi))
                                                   AS target
                                           FROM sap_t_rencana_sales_type a
                                                LEFT JOIN zreport_porsi_sales_region c
                                                   ON     c.region = 5
                                                      AND c.vkorg = a.co
                                                      AND c.budat LIKE '$year$month%'
                                                      AND c.tipe = a.tipe
                                                LEFT JOIN
                                                (  SELECT region,
                                                          tipe,
                                                          SUM (porsi) AS total_porsi
                                                     FROM zreport_porsi_sales_region
                                                    WHERE     budat LIKE '$year$month%'
                                                          AND VKORG = '7000'
                                                 GROUP BY region, tipe) d
                                                   ON c.region = d.region AND d.tipe = a.tipe
                                          WHERE     co = '7000'
                                                AND thn = '$year'
                                                AND bln = '$month'
                                                AND prov != '0001'
                                                AND prov != '1092'
                                       GROUP BY co,
                                                thn,
                                                bln,
                                                c.budat)
                                WHERE budat < '$year$month$date'
                             GROUP BY org) a
                            LEFT JOIN
                            --####################### RKAP EKSPOR SG ########################
                            (  SELECT co ORG, SUM (quantum) AS RKAP
                                 FROM sap_t_rencana_sales_type
                                WHERE     co = '7000'
                                      AND thn = '$year'
                                      AND bln = '$month'
                                      AND prov = '0001'
                             GROUP BY co) b
                               ON a.org = b.org
                     --#################################################################
                     UNION
                     --####################### RKAP SD DOMESTIK SP ########################
                     SELECT a.org, a.rkap_sd rkap_domestik, b.rkap rkap_ekspor
                       FROM (  SELECT org, SUM (target) rkap_sd
                                 FROM (  SELECT a.co ORG,
                                                c.budat,
                                                SUM (a.quantum * (c.porsi / d.total_porsi))
                                                   AS target
                                           FROM sap_t_rencana_sales_type a
                                                LEFT JOIN zreport_porsi_sales_region c
                                                   ON     c.region = 5
                                                      AND c.vkorg = a.co
                                                      AND c.budat LIKE '$year$month%'
                                                      AND c.tipe = a.tipe
                                                LEFT JOIN
                                                (  SELECT region,
                                                          tipe,
                                                          SUM (porsi) AS total_porsi
                                                     FROM zreport_porsi_sales_region
                                                    WHERE     budat LIKE '$year$month%'
                                                          AND VKORG = '3000'
                                                 GROUP BY region, tipe) d
                                                   ON c.region = d.region AND d.tipe = a.tipe
                                          WHERE     co = '3000'
                                                AND thn = '$year'
                                                AND bln = '$month'
                                                AND prov != '0001'
                                                AND prov != '1092'
                                       GROUP BY co,
                                                thn,
                                                bln,
                                                c.budat)
                                WHERE budat < '$year$month$date'
                             GROUP BY org) a
                            LEFT JOIN
                            --#################################################################

                            --####################### RKAP EKSPOR SP ########################
                            (  SELECT co ORG, SUM (quantum) AS RKAP
                                 FROM sap_t_rencana_sales_type
                                WHERE     co = '3000'
                                      AND thn = '$year'
                                      AND bln = '$month'
                                      AND prov = '0001'
                             GROUP BY co) b
                               ON a.org = b.org
                     --#################################################################
                     UNION
                     --####################### RKAP SD DOMESTIK ST ########################
                     SELECT a.org, a.rkap_sd AS rkap_domestik, b.rkap rkap_ekpor
                       FROM (  SELECT org, SUM (target) rkap_sd
                                 FROM (  SELECT a.co ORG,
                                                c.budat,
                                                SUM (a.quantum * (c.porsi / d.total_porsi))
                                                   AS target
                                           FROM sap_t_rencana_sales_type a
                                                LEFT JOIN zreport_porsi_sales_region c
                                                   ON     c.region = 5
                                                      AND c.vkorg = a.co
                                                      AND c.budat LIKE '$year$month%'
                                                      AND c.tipe = a.tipe
                                                LEFT JOIN
                                                (  SELECT region,
                                                          tipe,
                                                          SUM (porsi) AS total_porsi
                                                     FROM zreport_porsi_sales_region
                                                    WHERE     budat LIKE '$year$month%'
                                                          AND VKORG = '4000'
                                                 GROUP BY region, tipe) d
                                                   ON c.region = d.region AND d.tipe = a.tipe
                                          WHERE     co = '4000'
                                                AND thn = '$year'
                                                AND bln = '$month'
                                                AND prov != '0001'
                                                AND prov != '1092'
                                       GROUP BY co,
                                                thn,
                                                bln,
                                                c.budat)
                                WHERE budat < '$year$month$date'
                             GROUP BY org) a
                            LEFT JOIN
                            --#################################################################

                            --####################### RKAP EKSPOR ST ########################
                            (  SELECT co ORG, SUM (quantum) AS RKAP
                                 FROM sap_t_rencana_sales_type
                                WHERE     co = '4000'
                                      AND thn = '$year'
                                      AND bln = '$month'
                                      AND prov = '0001'
                             GROUP BY co) b
                               ON a.org = b.org
                     --#################################################################
                     UNION
                     --####################### RKAP DOMESTIK TLCC ########################
                     SELECT TO_NUMBER (a.org) org, a.rkap rkap_domestik, b.rkap rkap_expor
                       FROM (  SELECT ORG, SUM (TARGET) AS RKAP
                                 FROM ZREPORT_TARGET_PLANTSCO
                                WHERE     DELETE_MARK = 0
                                      AND JENIS IS NULL
                                      AND ORG = '6000'
                                      AND BULAN = '$month'
                                      AND TAHUN = '$year'
                                      AND PLANT NOT IN ('0001', '1092')
                                      AND TIPE != '121-200'
                             GROUP BY org) a
                            --###################################################################

                            --####################### RKAP EKSPOR TLCC ########################
                            LEFT JOIN
                            (  SELECT ORG, SUM (TARGET) AS RKAP
                                 FROM ZREPORT_TARGET_PLANTSCO
                                WHERE     DELETE_MARK = 0
                                      AND JENIS IS NULL
                                      AND ORG = '6000'
                                      AND BULAN = '$month'
                                      AND TAHUN = '$year'
                                      AND PLANT = '0001'
                                      AND TIPE != '121-200'
                             GROUP BY org) b
                               ON a.org = b.org) b
                       ON a.com = b.org
                       left join 
                       (
                         --############################ EKSPOR TERAK SEMEN GRESIK ############################
                     --##################################################################################
SELECT com org, SUM (realto) REAL_EKSPOR
  FROM zreport_rptreal_resum
 WHERE     tipe = '121-200'
       AND  com  in ('6000','3000','4000','7000')
       AND bulan = '$month'
       AND tahun = '$year'
       AND propinsi = '0001'
     group by com
             ) c on a.com = c.org");
        return $progrkap->result_array();
    }
    
  function get_unrun_prognose($year,$month,$date){
       $db=$this->load->database('default5',true);
      $sql = "select sum(prognose_harian) total_prognose,org from (select a.co org, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as prognose_harian
                      from sap_t_rencana_sales_type a
                      left join zreport_porsi_sales_region c on c.region=5
                           and c.vkorg= a.co and c.budat like '$year$month%' and c.tipe = a.tipe
                      left join (
                        select region, tipe,  sum(porsi) as total_porsi
                        from zreport_porsi_sales_region
                        where budat like '$year$month%' and vkorg in ('7000','3000','4000')
                        group by region, tipe
                      )d on c.region = d.region and d.tipe = a.tipe
                      where co in ('7000','3000','4000') and thn = '$year' and bln = '$month'
                      and prov!='0001' and prov!='1092'
		      and budat > '$year$month$date'
                      group by co, thn, bln, c.budat
 	union 
	select to_number(a.org), c.budat, sum(a.target * (c.porsi/d.total_porsi)) as target_realh
                            from ZREPORT_TARGET_PLANTSCO a
                            left join zreport_porsi_sales_region c on
                              c.vkorg= a.org and c.budat like '$year$month%' and c.tipe = a.tipe
                            left join (
                              select region, tipe,  sum(porsi) as total_porsi
                              from zreport_porsi_sales_region
                              where budat like '$year$month%' and VKORG = '6000'
                              group by region, tipe
                            )d on d.tipe = a.tipe
                            where DELETE_MARK=0 and JENIS is null
                            and ORG='6000' and BULAN='12' and TAHUN='2016' and PLANT not in ('0001','1092')
                            and a.TIPE!='121-200' and budat > '$year$month$date'
                            group by a.org, tahun, bulan, c.budat
order by budat )

group by org";
//      echo $sql;exit;
      $result = $db->query($sql);
      return $result->result();
     
  }
  
 function get_dom_pengurang($year,$month,$date){
     $db=$this->load->database('default5',true);
     $sql = "select com,sum(real) total from zreport_rptreal_resum_daily 
                where tahun = '{$year}' and bulan = '{$month}' and tgl >='{$date}'
                group by com ";
     $result = $db->query($sql);
     return $result->result();
 }


}

/* End of file m_volproduksi3000.php */
/* Location: ./application/models/stokpp&gudang/m_volproduksi3000.php */