<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_volproduksi4000 extends CI_Model {

	 public function get_realisasi($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $sql="select org, sum(realisasi) realisasi, tanggal from (select org, sum(real) as realisasi, tanggal from(
                            select com as org, sum(kwantumx) as real, to_char(tgl_cmplt,'DD') tanggal
                            from zreport_rpt_real_st
                            where to_char(tgl_cmplt,'YYYYMM')='$date' 
                              and ( (order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) 
                                    or (item_no like '121-302%' and order_type <>'ZNL') ) 
                              and com = '4000' and no_polisi <> 'S11LO'
                              and sold_to like '000000%' and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                              and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                              and ORDER_TYPE<>'ZLFE'
                            group by com, to_char(tgl_cmplt,'DD')
                            union
                            select vkorg as org, sum(ton) as real, to_char(wadat_ist,'DD') tanggal
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='4000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$date' 
                              and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                              and kunnr not like '000000%'
                              and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                              and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                            group by vkorg, to_char(wadat_ist,'DD')
                            union
                            select ti.com as org,sum(ti.KWANTUMX) as real, to_char(tgl_cmplt,'DD') tanggal
                            from ZREPORT_RPT_REAL_NON70_ST ti
                            where ti.ITEM_NO LIKE '121-301%' and item_no <> '121-301-0240' and to_char(tgl_cmplt,'YYYYMM')='$date'
                              and ti.COM='4000' and ti.ROUTE='ZR0001' and ti.STATUS in ('50')
                              and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                            group by ti.com, to_char(tgl_cmplt,'DD')
                          )
                          group by org, tanggal --order by tanggal asc
                        UNION
                            select '4000' ORG, sum(\"qty\") realisasi, \"hari\" tanggal 
                            from ZREPORT_REAL_ST_ADJ
                            where \"tahun\" = '$tahun' and \"bulan\" = '$bulan'
                            GROUP BY '4000', \"hari\")
                        group by org, tanggal
                        order by tanggal";
    $realisasi=$db->query($sql);

    return $realisasi->result();
  }
public function get_realisasi_h($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
  $realisasi_h=$db->query("select org, sum(realisasi) realisasi, tanggal from (select org, sum(real) as realisasi, tanggal from(
                            select com as org, sum(kwantumx) as real, to_char(tgl_cmplt,'DD') tanggal
                            from zreport_rpt_real_st
                            where to_char(tgl_cmplt,'YYYYMMDD')='$date$hari' 
                              and ( (order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) 
                                    or (item_no like '121-302%' and order_type <>'ZNL') ) 
                              and com = '4000' and no_polisi <> 'S11LO'
                              and sold_to like '000000%' and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                              and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                              and ORDER_TYPE<>'ZLFE'
                            group by com, to_char(tgl_cmplt,'DD')
                            union
                            select vkorg as org, sum(ton) as real, to_char(wadat_ist,'DD') tanggal
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='4000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMMDD')='$date$hari' 
                              and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                              and kunnr not like '000000%'
                              and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                              and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                            group by vkorg, to_char(wadat_ist,'DD')
                            union
                            select ti.com as org,sum(ti.KWANTUMX) as real, to_char(tgl_cmplt,'DD') tanggal
                            from ZREPORT_RPT_REAL_NON70_ST ti
                            where ti.ITEM_NO LIKE '121-301%' and item_no <> '121-301-0240' and to_char(tgl_cmplt,'YYYYMM')='$date'
                              and ti.COM='4000' and ti.ROUTE='ZR0001' and ti.STATUS in ('50')
                              and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                            group by ti.com, to_char(tgl_cmplt,'DD')
                          )
                          group by org, tanggal --order by tanggal asc
                        UNION
                            select '4000' ORG, sum(\"qty\") realisasi, \"hari\" tanggal 
                            from ZREPORT_REAL_ST_ADJ
                            where \"tahun\" = '$tahun' and \"bulan\" = '$bulan' and \"hari\" = '$hari'
                            GROUP BY '4000', \"hari\")
                        group by org, tanggal
                        order by tanggal");

    return $realisasi_h->result();
  }

  public function get_prognose($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
      $prognose=$db->query("SELECT TB1.ORG, NVL(TB6.PROGNOSE,0) PROG, NVL(TB1.RKAP,0) RKAP,  
                    NVL(TB3.PROG_HARIAN,0) PROGNOSE_HARIAN  FROM (
                    select a.co org, sum(a.quantum) as rkap
                          from sap_t_rencana_sales_type a
                          where co = '4000' and thn = '$tahun' and bln = '$bulan' and prov!='0001' and prov!='1092'
                          group by a.co
                    ) TB1
                      LEFT JOIN (
                        select org, sum(prog_harian) as prog_harian 
                        from(
                          select * from (
                            select a.co org, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as prog_harian
                            from sap_t_rencana_sales_type a
                            left join zreport_porsi_sales_region c on c.region=5
                                 and c.vkorg= a.co and c.budat like '$date%' and c.tipe = a.tipe
                            left join (
                              select region, tipe,  sum(porsi) as total_porsi
                              from zreport_porsi_sales_region
                              where budat like '$date%' and vkorg = '4000'
                              group by region, tipe
                            )d on c.region = d.region and d.tipe = a.tipe
                            where co = '4000' and thn = '$tahun' and bln = '$bulan'
                            and prov!='0001' and prov!='1092'
                            group by co, thn, bln, c.budat
                          )
                          where budat = '$date$hari'
                        ) group by org
                      )TB3
                      ON TB1.ORG = TB3.ORG
                      LEFT JOIN (
                        select org, sum(prognose) as prognose 
                        from(
                          select * from (
                            select a.co org, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as prognose
                            from sap_t_rencana_sales_type a
                            left join zreport_porsi_sales_region c on c.region=5
                                 and c.vkorg= a.co and c.budat like '$date%' and c.tipe = a.tipe
                            left join (
                              select region, tipe,  sum(porsi) as total_porsi
                              from zreport_porsi_sales_region
                              where budat like '$date%' and vkorg = '4000'
                              group by region, tipe
                            )d on c.region = d.region and d.tipe = a.tipe
                            where co = '4000' and thn = '$tahun' and bln = '$bulan'
                            and prov!='0001' and prov!='1092'
                            group by co, thn, bln, c.budat
                          )
                          where budat > '$date$hari'
                        ) group by org
                      )TB6
                      ON TB1.ORG = TB6.ORG");
    return $prognose->result();
  }

  public function get_ekspor($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $ekspor=$db->query("select TB1.ORG, NVL(TB1.REAL_EKSPOR,0) REAL_EKSPOR_SM, NVL(TB3.REAL_EKSPOR,0) REAL_EKSPOR_TR, NVL(TB2.RKAP_EKSPOR,0) RKAP_EKSPOR FROM (
                      select org, sum(real_ekspor) real_ekspor from (select ORG, sum(real) as REAL_EKSPOR from(
                        select com as ORG, '0001' as propinsi_to , sum(kwantumx) as real
                        from zreport_rpt_real_st 
                        where         
                        to_char(tgl_cmplt,'YYYYMM')='$date'
                        and com = '4000'
                        and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                        and ORDER_TYPE='ZLFE' and ITEM_NO like '121-301%'
                        group by com, propinsi_to
                        union
                        select vkorg as org, vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='4000' and LFART='ZLR' and
                        to_char(wadat_ist,'YYYYMM')='$date'
                        and  ((matnr like '121-301%' and matnr <> '121-301-0240')) 
                        and vkbur ='0001' 
                        group by vkorg, vkbur
                        )
                        group by ORG
                        UNION
                        select ORG, qty real_ekspor from ZREPORT_SCM_REAL_EKSPOR_ST_ADJ
                        WHERE TAHUN = '$tahun' AND BULAN = '$bulan' AND TIPE = '121-301')
                        group by org
                      )TB1 
                      LEFT JOIN (
                        select a.co org, sum(a.quantum) as rkap_ekspor
                          from sap_t_rencana_sales_type a
                          where co = '4000' and thn = '$tahun' and bln = '$bulan' and a.prov='0001'
                          group by a.co
                      )TB2
                      ON TB1.ORG = TB2.ORG
                      LEFT JOIN (
                        select org, sum(real_ekspor) real_ekspor from (select ORG, sum(real) as REAL_EKSPOR from(
                          select com as ORG, '0001' as propinsi_to , sum(kwantumx) as real
                          from zreport_rpt_real_st 
                          where         
                          to_char(tgl_cmplt,'YYYYMM')='$date'
                          and com = '4000'
                          and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                          and ORDER_TYPE='ZLFE' and ITEM_NO like '121-302%'
                          group by com, propinsi_to
                          union
                          select vkorg as org, vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='4000' and LFART='ZLR' and
                          to_char(wadat_ist,'YYYYMM')='$date'
                          and  ((matnr like '121-302%')) 
                          and vkbur ='0001' 
                          group by vkorg, vkbur
                          )
                        group by ORG
                        UNION
                        select ORG, qty real_ekspor from ZREPORT_SCM_REAL_EKSPOR_ST_ADJ
                        WHERE TAHUN = '$tahun' AND BULAN = '$bulan' AND TIPE = '121-302')
                        group by org
                      )TB3
                      ON TB1.ORG = TB3.ORG");

    return $ekspor;
  }

  public function get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu)
  {
    $db=$this->load->database('default5',true);
    $realisasilalu=$db->query("select org, sum(realisasi) realisasi, tanggal from (select org, sum(real) as realisasi, tanggal from(
                            select com as org, sum(kwantumx) as real, to_char(tgl_cmplt,'DD') tanggal
                            from zreport_rpt_real_st
                            where to_char(tgl_cmplt,'YYYYMM')='$datelalu' 
                              and ( (order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) 
                                    or (item_no like '121-302%' and order_type <>'ZNL') ) 
                              and com = '4000' and no_polisi <> 'S11LO'
                              and sold_to like '000000%' and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                              and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                              and ORDER_TYPE<>'ZLFE'
                            group by com, to_char(tgl_cmplt,'DD')
                            union
                            select vkorg as org, sum(ton) as real, to_char(wadat_ist,'DD') tanggal
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='4000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$datelalu' 
                              and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                              and kunnr not like '000000%'
                              and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                              and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                            group by vkorg, to_char(wadat_ist,'DD')
                            union
                            select ti.com as org,sum(ti.KWANTUMX) as real, to_char(tgl_cmplt,'DD') tanggal
                            from ZREPORT_RPT_REAL_NON70_ST ti
                            where ti.ITEM_NO LIKE '121-301%' and item_no <> '121-301-0240' and to_char(tgl_cmplt,'YYYYMM')='$datelalu'
                              and ti.COM='4000' and ti.ROUTE='ZR0001' and ti.STATUS in ('50')
                              and ti.no_transaksi NOT IN(SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                            group by ti.com, to_char(tgl_cmplt,'DD')
                          )
                          group by org, tanggal --order by tanggal asc
                        UNION
                            select '4000' ORG, sum(\"qty\") realisasi, \"hari\" tanggal 
                            from ZREPORT_REAL_ST_ADJ
                            where \"tahun\" = '$tahunlalu' and \"bulan\" = '$bulan'
                            GROUP BY '4000', \"hari\")
                        group by org, tanggal
                        order by tanggal");

    return $realisasilalu->result();
  }

  public function get_realisasi_l($tahunlalu,$bulan,$hari,$datelalu,$hariawal)
  {
    $db=$this->load->database('default5',true);
    $realisasi_l=$db->query("select org, sum(realisasi) realisasi, tanggal from (select org, sum(real) as realisasi, tanggal from(
                            select com as org, sum(kwantumx) as real, to_char(tgl_cmplt,'DD') tanggal
                            from zreport_rpt_real_st
                            where to_char(tgl_cmplt,'YYYYMMDD') BETWEEN '$hariawal' AND '$datelalu$hari'
                              and ( (order_type <>'ZNL' and (item_no like '121-301%' and item_no <> '121-301-0240')) 
                                    or (item_no like '121-302%' and order_type <>'ZNL') ) 
                              and com = '4000' and no_polisi <> 'S11LO'
                              and sold_to like '000000%' and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                              and SOLD_TO not in ('0000000835','0000000836','0000000837') 

                              and ORDER_TYPE<>'ZLFE'
                            group by com, to_char(tgl_cmplt,'DD')
                            union
                            select vkorg as org, sum(ton) as real, to_char(wadat_ist,'DD') tanggal
                            from ZREPORT_ONGKOSANGKUT_MOD 
                            where VKORG='4000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMMDD') BETWEEN '$hariawal' AND '$datelalu$hari' 
                              and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                              and kunnr not like '000000%'
                              and kunag not in ('0000040084','0000040147','0000040272','0000000888')
                              and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                            group by vkorg, to_char(wadat_ist,'DD')
                            union
                            select ti.com as org,sum(ti.KWANTUMX) as real, to_char(tgl_cmplt,'DD') tanggal
                            from ZREPORT_RPT_REAL_NON70_ST ti
                            where ti.ITEM_NO LIKE '121-301%' and item_no <> '121-301-0240' and to_char(tgl_cmplt,'YYYYMMDD') BETWEEN '$hariawal' AND '$datelalu$hari'
                              and ti.COM='4000' and ti.ROUTE='ZR0001' and ti.STATUS in ('50')
                              and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                            group by ti.com, to_char(tgl_cmplt,'DD')
                          )
                          group by org, tanggal --order by tanggal asc
                        UNION
                            select '4000' ORG, sum(\"qty\") realisasi, \"hari\" tanggal 
                            from ZREPORT_REAL_ST_ADJ
                            where \"tahun\" = '2015' and \"bulan\" = '12'
                            GROUP BY '4000', \"hari\")
                        group by org, tanggal
                        order by tanggal");

    return $realisasi_l->result();
  }

  public function get_prognoselalu($tahunlalu,$bulan,$hari,$datelalu)
  {
    $db=$this->load->database('default5',true);
    $prognoselalu=$db->query("SELECT TB1.ORG, NVL(TB6.PROGNOSE,0) PROG, NVL(TB1.RKAP,0) RKAP,  
                    NVL(TB3.PROG_HARIAN,0) PROGNOSE_HARIAN  FROM (
                    select a.co org, sum(a.quantum) as rkap
                          from sap_t_rencana_sales_type a
                          where co = '4000' and thn = '$tahunlalu' and bln = '$bulan' and prov!='0001' and prov!='1092'
                          group by a.co
                    ) TB1
                      LEFT JOIN (
                        select org, sum(prog_harian) as prog_harian 
                        from(
                          select * from (
                            select a.co org, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as prog_harian
                            from sap_t_rencana_sales_type a
                            left join zreport_porsi_sales_region c on c.region=5
                                 and c.vkorg= a.co and c.budat like '$datelalu%' and c.tipe = a.tipe
                            left join (
                              select region, tipe,  sum(porsi) as total_porsi
                              from zreport_porsi_sales_region
                              where budat like '$datelalu%' and vkorg = '4000'
                              group by region, tipe
                            )d on c.region = d.region and d.tipe = a.tipe
                            where co = '4000' and thn = '$tahunlalu' and bln = '$bulan'
                            and prov!='0001' and prov!='1092'
                            group by co, thn, bln, c.budat
                          )
                          where budat = '$datelalu$hari'
                        ) group by org
                      )TB3
                      ON TB1.ORG = TB3.ORG
                      LEFT JOIN (
                        select org, sum(prognose) as prognose 
                        from(
                          select * from (
                            select a.co org, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as prognose
                            from sap_t_rencana_sales_type a
                            left join zreport_porsi_sales_region c on c.region=5
                                 and c.vkorg= a.co and c.budat like '$datelalu%' and c.tipe = a.tipe
                            left join (
                              select region, tipe,  sum(porsi) as total_porsi
                              from zreport_porsi_sales_region
                              where budat like '$datelalu%' and vkorg = '4000'
                              group by region, tipe
                            )d on c.region = d.region and d.tipe = a.tipe
                            where co = '4000' and thn = '$tahunlalu' and bln = '$bulan'
                            and prov!='0001' and prov!='1092'
                            group by co, thn, bln, c.budat
                          )
                          where budat > '$datelalu$hari'
                        ) group by org
                      )TB6
                      ON TB1.ORG = TB6.ORG");
    return $prognoselalu->result();
  }

  public function get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu)
  {
    $db=$this->load->database('default5',true);
    $eksporlalu=$db->query("select TB1.ORG, NVL(TB1.REAL_EKSPOR,0) REAL_EKSPOR_SM, NVL(TB3.REAL_EKSPOR,0) REAL_EKSPOR_TR, NVL(TB2.RKAP_EKSPOR,0) RKAP_EKSPOR FROM (
                      select org, sum(real_ekspor) real_ekspor from (select ORG, sum(real) as REAL_EKSPOR from(
                        select com as ORG, '0001' as propinsi_to , sum(kwantumx) as real
                        from zreport_rpt_real_st 
                        where         
                        to_char(tgl_cmplt,'YYYYMM')='$datelalu'
                        and com = '4000'
                        and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                        and ORDER_TYPE='ZLFE' and ITEM_NO like '121-301%'
                        group by com, propinsi_to
                        union
                        select vkorg as org, vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='4000' and LFART='ZLR' and
                        to_char(wadat_ist,'YYYYMM')='$datelalu'
                        and  ((matnr like '121-301%' and matnr <> '121-301-0240')) 
                        and vkbur ='0001' 
                        group by vkorg, vkbur
                        )
                        group by ORG
                        UNION
                        select ORG, qty real_ekspor from ZREPORT_SCM_REAL_EKSPOR_ST_ADJ
                        WHERE TAHUN = '$tahunlalu' AND BULAN = '$bulan' AND TIPE = '121-301')
                        group by org
                      )TB1 
                      LEFT JOIN (
                        select a.co org, sum(a.quantum) as rkap_ekspor
                          from sap_t_rencana_sales_type a
                          where co = '4000' and thn = '$tahunlalu' and bln = '$bulan' and a.prov='0001'
                          group by a.co
                      )TB2
                      ON TB1.ORG = TB2.ORG
                      LEFT JOIN (
                        select org, sum(real_ekspor) real_ekspor from (select ORG, sum(real) as REAL_EKSPOR from(
                          select com as ORG, '0001' as propinsi_to , sum(kwantumx) as real
                          from zreport_rpt_real_st 
                          where         
                          to_char(tgl_cmplt,'YYYYMM')='$datelalu'
                          and com = '4000'
                          and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                          and ORDER_TYPE='ZLFE' and ITEM_NO like '121-302%'
                          group by com, propinsi_to
                          union
                          select vkorg as org, vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='4000' and LFART='ZLR' and
                          to_char(wadat_ist,'YYYYMM')='$datelalu'
                          and  ((matnr like '121-302%')) 
                          and vkbur ='0001' 
                          group by vkorg, vkbur
                          )
                        group by ORG
                        UNION
                        select ORG, qty real_ekspor from ZREPORT_SCM_REAL_EKSPOR_ST_ADJ
                        WHERE TAHUN = '$tahunlalu' AND BULAN = '$bulan' AND TIPE = '121-302')
                        group by org
                      )TB3
                      ON TB1.ORG = TB3.ORG");

    return $eksporlalu->result();
  }

}

/* End of file m_volproduksi4000.php */
/* Location: ./application/models/stokpp&gudang/m_volproduksi4000.php */