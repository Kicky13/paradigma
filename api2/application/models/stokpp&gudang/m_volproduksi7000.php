<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_volproduksi7000 extends CI_Model {

	public function get_realisasi($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $realisasi=$db->query("select org, sum(real) as REALISASI, tanggal from(
                  select com org, sum(kwantumx) as real, to_char(tgl_cmplt,'DD') tanggal
                  from zreport_rpt_real
                  where to_char(tgl_cmplt,'YYYYMM')='$date'
                    and ( (order_type <>'ZNL' and
                          (item_no like '121-301%' and item_no <> '121-301-0240')) or 
                          (item_no like '121-302%' and order_type <>'ZNL') 
                        ) 
                    and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                    and sold_to like '0000000%'
                  group by com, to_char(tgl_cmplt,'DD')
                  union
                  select vkorg org, sum(ton) as real, to_char(wadat_ist,'DD') tanggal 
                  from ZREPORT_ONGKOSANGKUT_MOD 
                  where VKORG='7000' and LFART='ZLR' 
                    and to_char(wadat_ist,'YYYYMM')='$date' 
                    and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                    and kunag like '0000000%'
                  group by vkorg, to_char(wadat_ist,'DD')
                  ) group by org, tanggal order by tanggal");
    return $realisasi->result();
  }

  public function get_realisasi_h($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $realisasi_h=$db->query("select org, sum(real) as REALISASI, tanggal from(
                  select com org, sum(kwantumx) as real, to_char(tgl_cmplt,'DD') tanggal
                  from zreport_rpt_real
                  where to_char(tgl_cmplt,'YYYYMMDD')='$date$hari'
                    and ( (order_type <>'ZNL' and
                          (item_no like '121-301%' and item_no <> '121-301-0240')) or 
                          (item_no like '121-302%' and order_type <>'ZNL') 
                        ) 
                    and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                    and sold_to like '0000000%'
                  group by com, to_char(tgl_cmplt,'DD')
                  union
                  select vkorg org, sum(ton) as real, to_char(wadat_ist,'DD') tanggal 
                  from ZREPORT_ONGKOSANGKUT_MOD 
                  where VKORG='7000' and LFART='ZLR' 
                    and to_char(wadat_ist,'YYYYMMDD')='$date$hari' 
                    and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                    and kunag like '0000000%'
                  group by vkorg, to_char(wadat_ist,'DD')
                  ) group by org, tanggal order by tanggal");
    return $realisasi_h->result();
  }

  public function get_ekspor($tahun,$bulan,$hari,$date)
  {
    $db=$this->load->database('default5',true);
    $ekspor=$db->query("SELECT TB1.ORG, NVL(TB6.PROGNOSE,0) PROG, TB3.RKAP, NVL(TB4.REAL_EKSPOR,0) REAL_EKSPOR, 
  NVL(TB5.RKAP_EKSPOR,0) RKAP_EKSPOR, NVL(TB1.PROGNOSE_HARIAN,0) PROGNOSE_HARIAN, NVL(TB7.REAL_EKSPOR,0) REAL_EKSPOR_CURAH FROM (
                    select * from (
                      select a.co org, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as prognose_harian
                      from sap_t_rencana_sales_type a
                      left join zreport_porsi_sales_region c on c.region=5
                           and c.vkorg= a.co and c.budat like '$date%' and c.tipe = a.tipe
                      left join (
                        select region, tipe,  sum(porsi) as total_porsi
                        from zreport_porsi_sales_region
                        where budat like '$date%' and vkorg = '7000'
                        group by region, tipe
                      )d on c.region = d.region and d.tipe = a.tipe
                      where co = '7000' and thn = '$tahun' and bln = '$bulan'
                      and prov!='0001' and prov!='1092'
                      group by co, thn, bln, c.budat
                    )
                    where budat = '$date$hari'
                
                ) TB1
                LEFT JOIN (
                    select co ORG, sum(quantum) as RKAP
                    from sap_t_rencana_sales_type 
                    where co = '7000' and thn = '$tahun' and bln = '$bulan' and prov!='0001' and prov!='1092'
                    group by co
                ) TB3
                ON TB1.ORG = TB3.ORG 
                LEFT JOIN (
                    select ORG, sum(real) as REAL_EKSPOR from(
                        select COM AS ORG, sum(kwantumx) as real
                        from zreport_rpt_real 
                        where to_char(tgl_cmplt,'YYYYMM')='$date' and com = '7000'
                            and propinsi_to='0001'
                        group by COM
                        union
                        select VKORG as ORG, sum(ton) as real 
                        from ZREPORT_ONGKOSANGKUT_MOD 
                        where VKORG='7000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$date'
                            and ((matnr like '121-301%' and matnr <> '121-301-0240')) 
                            and vkbur ='0001' 
                        group by VKORG)
                    GROUP BY ORG
                )TB4
                ON TB1.ORG = TB4.ORG
                LEFT JOIN (
                    select co ORG, sum(quantum) as RKAP_ekspor
                    from sap_t_rencana_sales_type 
                    where co = '7000' and thn = '$tahun' and bln = '$bulan' and prov = '0001'
                    group by co
                ) TB5
                ON TB1.ORG = TB5.ORG
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
                        where budat like '$date%' and vkorg = '7000'
                        group by region, tipe
                      )d on c.region = d.region and d.tipe = a.tipe
                      where co = '7000' and thn = '$tahun' and bln = '$bulan'
                      and prov!='0001' and prov!='1092'
                      group by co, thn, bln, c.budat
                    )
                    where budat > '$date$hari'
                  ) group by org 
                ) TB6
                ON TB1.ORG = TB6.ORG
                LEFT JOIN (
                    select ORG, sum(real) as REAL_EKSPOR from(
                        select COM AS ORG, sum(kwantumx) as real
                        from zreport_rpt_real 
                        where to_char(tgl_cmplt,'YYYYMM')='$date' and com = '7000'
                            and propinsi_to='0001' and ITEM_NO LIKE '121-302%'
                        group by COM
                        union
                        select VKORG as ORG, sum(ton) as real 
                        from ZREPORT_ONGKOSANGKUT_MOD 
                        where VKORG='7000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$date'
                            and ((matnr like '121-302%')) 
                            and vkbur ='0001' 
                        group by VKORG)
                    GROUP BY ORG
                )TB7 
                ON TB1.ORG = TB7.ORG");
    return $ekspor->result();
  }

  public function get_realisasilalu($tahunlalu,$bulan,$hari,$datelalu,$hariawal)
  {
    $db=$this->load->database('default5',true);
    $realisasilalu=$db->query("select org, sum(real) as REALISASI, tanggal from(
                  select com org, sum(kwantumx) as real, to_char(tgl_cmplt,'DD') tanggal
                  from zreport_rpt_real
                  where to_char(tgl_cmplt,'YYYYMMDD') BETWEEN $hariawal AND $datelalu$hari 
                    and ( (order_type <>'ZNL' and
                          (item_no like '121-301%' and item_no <> '121-301-0240')) or 
                          (item_no like '121-302%' and order_type <>'ZNL') 
                        ) 
                    and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                    and sold_to like '0000000%'
                  group by com, to_char(tgl_cmplt,'DD')
                  union
                  select vkorg org, sum(ton) as real, to_char(wadat_ist,'DD') tanggal 
                  from ZREPORT_ONGKOSANGKUT_MOD 
                  where VKORG='7000' and LFART='ZLR' 
                    and to_char(wadat_ist,'YYYYMMDD') BETWEEN $hariawal AND $datelalu$hari  
                    and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                    and kunag like '0000000%'
                  group by vkorg, to_char(wadat_ist,'DD')
                  ) group by org, tanggal order by tanggal");
    return $realisasilalu->result();
  }

  public function get_eksporlalu($tahunlalu,$bulan,$hari,$datelalu)
  {
    $db=$this->load->database('default5',true);
    $eksporlalu=$db->query("SELECT TB1.ORG, NVL(TB6.PROGNOSE,0) PROG, TB3.RKAP, NVL(TB4.REAL_EKSPOR,0) REAL_EKSPOR, 
  NVL(TB5.RKAP_EKSPOR,0) RKAP_EKSPOR, NVL(TB1.PROGNOSE_HARIAN,0) PROGNOSE_HARIAN, NVL(TB7.REAL_EKSPOR,0) REAL_EKSPOR_CURAH FROM (
                    select * from (
                      select a.co org, c.budat, sum(a.quantum * (c.porsi/d.total_porsi)) as prognose_harian
                      from sap_t_rencana_sales_type a
                      left join zreport_porsi_sales_region c on c.region=5
                           and c.vkorg= a.co and c.budat like '$datelalu%' and c.tipe = a.tipe
                      left join (
                        select region, tipe,  sum(porsi) as total_porsi
                        from zreport_porsi_sales_region
                        where budat like '$datelalu%' and vkorg = '7000'
                        group by region, tipe
                      )d on c.region = d.region and d.tipe = a.tipe
                      where co = '7000' and thn = '$tahunlalu' and bln = '$bulan'
                      and prov!='0001' and prov!='1092'
                      group by co, thn, bln, c.budat
                    )
                    where budat = '$datelalu$hari'
                
                ) TB1
                LEFT JOIN (
                    select co ORG, sum(quantum) as RKAP
                    from sap_t_rencana_sales_type 
                    where co = '7000' and thn = '$tahunlalu' and bln = '$bulan' and prov!='0001' and prov!='1092'
                    group by co
                ) TB3
                ON TB1.ORG = TB3.ORG 
                LEFT JOIN (
                    select ORG, sum(real) as REAL_EKSPOR from(
                        select COM AS ORG, sum(kwantumx) as real
                        from zreport_rpt_real 
                        where to_char(tgl_cmplt,'YYYYMM')='$datelalu' and com = '7000'
                            and propinsi_to='0001'
                        group by COM
                        union
                        select VKORG as ORG, sum(ton) as real 
                        from ZREPORT_ONGKOSANGKUT_MOD 
                        where VKORG='7000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$datelalu'
                            and ((matnr like '121-301%' and matnr <> '121-301-0240')) 
                            and vkbur ='0001' 
                        group by VKORG)
                    GROUP BY ORG
                )TB4
                ON TB1.ORG = TB4.ORG
                LEFT JOIN (
                    select co ORG, sum(quantum) as RKAP_ekspor
                    from sap_t_rencana_sales_type 
                    where co = '7000' and thn = '$tahunlalu' and bln = '$bulan' and prov = '0001'
                    group by co
                ) TB5
                ON TB1.ORG = TB5.ORG
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
                        where budat like '$datelalu%' and vkorg = '7000'
                        group by region, tipe
                      )d on c.region = d.region and d.tipe = a.tipe
                      where co = '7000' and thn = '$tahunlalu' and bln = '$bulan'
                      and prov!='0001' and prov!='1092'
                      group by co, thn, bln, c.budat
                    )
                    where budat > '$datelalu$hari'
                  ) group by org 
                ) TB6
                ON TB1.ORG = TB6.ORG
                LEFT JOIN (
                    select ORG, sum(real) as REAL_EKSPOR from(
                        select COM AS ORG, sum(kwantumx) as real
                        from zreport_rpt_real 
                        where to_char(tgl_cmplt,'YYYYMM')='$datelalu' and com = '7000'
                            and propinsi_to='0001' and ITEM_NO LIKE '121-302%'
                        group by COM
                        union
                        select VKORG as ORG, sum(ton) as real 
                        from ZREPORT_ONGKOSANGKUT_MOD 
                        where VKORG='7000' and LFART='ZLR' and to_char(wadat_ist,'YYYYMM')='$datelalu'
                            and ((matnr like '121-302%')) 
                            and vkbur ='0001' 
                        group by VKORG)
                    GROUP BY ORG
                )TB7 
                ON TB1.ORG = TB7.ORG
  ");
    return $eksporlalu->result();
}

public function get_realisasi_l($tahunlalu,$bulan,$hari,$datelalu )
  {
    $db=$this->load->database('default5',true);
    $realisasilalu1=$db->query("select org, sum(real) as REALISASI, tanggal from(
                  select com org, sum(kwantumx) as real, to_char(tgl_cmplt,'DD') tanggal
                  from zreport_rpt_real
                  where to_char(tgl_cmplt,'YYYYMM') = '$datelalu'
                    and ( (order_type <>'ZNL' and
                          (item_no like '121-301%' and item_no <> '121-301-0240')) or 
                          (item_no like '121-302%' and order_type <>'ZNL') 
                        ) 
                    and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                    and sold_to like '0000000%'
                  group by com, to_char(tgl_cmplt,'DD')
                  union
                  select vkorg org, sum(ton) as real, to_char(wadat_ist,'DD') tanggal 
                  from ZREPORT_ONGKOSANGKUT_MOD 
                  where VKORG='7000' and LFART='ZLR' 
                    and to_char(wadat_ist,'YYYYMM') = '$datelalu' 
                    and ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                    and kunag like '0000000%'
                  group by vkorg, to_char(wadat_ist,'DD')
                  ) group by org, tanggal order by tanggal");
    return $realisasilalu1->result();
  }

}

/* End of file m_volproduksi7000.php */
/* Location: ./application/models/stokpp&gudang/m_volproduksi7000.php */