<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Msales_daily extends CI_Model {
    private $_sales;
    
function get_data($param){
    $this->_sales=$this->load->database('default5',true);
    $paramCompany = "";
    if($param['company'] == 'ALL'){
        $paramCompany = " where TBREAL.COM in ('7000','6000','3000','4000')  ";
    }else{
        $paramCompany = " where TBREAL.COM = '{$param['company']}'";
    }
    
    
    $sql = "select tbreal.*,tbrkap.rkap_jadi FROM
                (select com,typem,substr(tanggal,0,4) as tahun,substr(tanggal,5,2) as bulan,substr(tanggal,7,2) as tgl , sum(reals) as reals FROM
                (select com, typem, tanggal, sum(real) as reals from (
                --semen gresik
                select com,typem, tanggal, sum(real) as real from(
                    select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                    from zreport_rpt_real
                    where        
                    to_char(tgl_cmplt,'YYYYMM') like '{$param['tahun']}{$param['bulan']}%'
                    and ( (order_type <>'ZNL' and
                    (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
                    and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                    and sold_to like '0000000%'
                    group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
                    )
                    group by com,typem,tanggal
                UNION
                --semen padang 
                    select com, typem, tanggal, sum(real) as real from(
                    select vkorg as com, substr(matnr,0,7) as typem,to_char(WADAT_IST,'yyyymmdd') as tanggal, sum(ton) as real
                    from zreport_ongkosangkut_mod
                    where                
                    to_char(wadat_ist,'yyyymmdd') like '{$param['tahun']}{$param['bulan']}%'
                    and lfart <>'ZNL'
                    and ((matnr like '121-301%' and matnr <> '121-301-0240'  ) or (matnr like '121-302%'))
                    and vkorg = '3000'
                    and kunag not in ('0000040084','0000040147','0000040272')
                    group by vkorg,substr(matnr,0,7),to_char(WADAT_IST,'yyyymmdd')
                    )
                    group by com,typem, tanggal
                union
                -- semen tonasa 
                    select com,typem, tanggal, sum(real) as real from(
                    select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                    from zreport_rpt_real_st
                    where        
                    to_char(tgl_cmplt,'YYYYMM') LIKE '{$param['tahun']}{$param['bulan']}%'
                    and ( (order_type <>'ZNL' and
                    (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
                    and order_type <>'ZNL') ) and com = '4000' and no_polisi <> 'S11LO'
                    and sold_to like '000000%'
                    and propinsi_to <> 10 
                    and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                    and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                    and ORDER_TYPE<>'ZLFE'
                    group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
                    union
                        select com,substr(item_no,0,7) as typem, to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                    from zreport_rpt_real_st
                    where        
                    to_char(tgl_cmplt,'YYYYMM')like '{$param['tahun']}{$param['bulan']}%'
                    and com = '4000'
                    and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                    and ORDER_TYPE='ZLFE'
                    group by com,substr(item_no,0,7), to_char(TGL_CMPLT,'YYYYMMDD')
                        union
                    select ti.COM,substr(item_no,0,7) as typem,to_char(TGL_DO,'YYYYMMDD') as tanggal,sum(ti.KWANTUMX) as real
                    from ZREPORT_RPT_REAL_NON70_ST ti
                    where ti.ITEM_NO LIKE '121-301%'
                    and item_no <> '121-301-0240'
                    and ti.COM='4000'
                        and to_char(TI.TGL_DO,'YYYYMM') LIKE '{$param['tahun']}{$param['bulan']}%'
                    and ti.ROUTE='ZR0001'
                    and ti.STATUS in ('50')
                    and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                    group by ti.COM,substr(item_no,0,7),to_char(TGL_DO,'YYYYMMDD')
                    )group by COM,typem,tanggal
                UNION
                --tlcc
                select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                from zreport_rpt_real_tlcc
                where 
                to_char(TGL_SPJ,'yyyymm')like '{$param['tahun']}{$param['bulan']}%'
                and order_type <>'ZNL'
                and propinsi_to like '6%'
                and item_no like '121-3%'
                and com = '6000'
                group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
                union
                select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                from zreport_rpt_real_tlcc where
                    to_char(TGL_SPJ,'yyyymm') like '{$param['tahun']}{$param['bulan']}%'
                    and order_type <>'ZNL'
                    and propinsi_to not like '6%'
                    and item_no like '121-3%'
                    and com = '6000'
                group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
                UNION
                --return
                 select VKORG as com,substr(matnr,0,7) as typem,to_char(wadat_ist,'yyyymmdd') as tanggal, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD
                     where VKORG in ('7000','6000','3000','4000') and LFART='ZLR' and
                     to_char(wadat_ist,'YYYYMM') like '{$param['tahun']}{$param['bulan']}%'
                     and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
                     and kunag like '0000000%'
                     and kunnr not like '000000%'
                     and kunag not in ('0000040084','0000040147','0000040272','0000000888')  
                     and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                     group by VKORG,vkbur,substr(matnr,0,7),to_char(WADAT_IST,'yyyymmdd')
                )
                GROUP BY com, typem,tanggal)
                group by com, typem,substr(tanggal,0,4),substr(tanggal,5,2),substr(tanggal,7,2))tbreal
                LEFT JOIN
                --rkap
                (SELECT TB4.com,TB4.TIPE,TB4.tahun,TB4.bulan,TB4.TANGGAL,((tb4.RKAP_H)*tb3.RKAP/100) as RKAP_JADI
                FROM
                (select tb1.com,TB1.TIPE,TB1.tahun,TB1.bulan,TB1.tanggal,TB1.PORSI,tb2.porsi_total, ((tb1.porsi/tb2.porsi_total)*100) as RKAP_H 
                from
                (select * from
                (SELECT vkorg as com,tipe,substr(budat,0,4) as tahun,substr(budat,5,2) as bulan,substr(budat,7,2) as tanggal,porsi
                from ZREPORT_PORSI_SALES_REGION
                where vkorg in ('7000','6000','3000','4000') and budat like '{$param['tahun']}{$param['bulan']}%' and region=5)) tb1
                LEFT JOIN (
                (SELECT vkorg,region,tipe,sum(porsi) as porsi_total 
                from ZREPORT_PORSI_SALES_REGION
                where vkorg in ('7000','6000','3000','4000') and budat like '{$param['tahun']}{$param['bulan']}%' and region=5
                GROUP BY vkorg,region,tipe) tb2
                ) on (TB1.com=TB2.vkorg and tb1.tipe=tb2.tipe)
                )tb4
                LEFT JOIN (
                (SELECT COM,TIPE,TAHUN,BULAN,sum(target_rkap) as  RKAP 
                from ZREPORT_RPTREAL_RESUM
                where COM in ('7000','6000','3000','4000') and TAHUN='{$param['tahun']}' and BULAN='{$param['bulan']}' AND TIPE<>'121-200'
                GROUP BY COM,TIPE,TAHUN,BULAN)tb3)
                on (TB4.com = TB3.com and TB4.TIPE=TB3.tipe and TB4.TAHUN=TB3.TAHUN and TB4.bulan=TB3.BULAN))tbrkap
                on TBREAL.COM=TBRKAP.COM and TBREAL.TYPEM=TBRKAP.TIPE and TBREAL.tahun=TBRKAP.tahun and TBREAL.bulan=TBRKAP.BULAN and TBREAL.tgl=TBRKAP.TANGGAL
                $paramCompany 

                  ";


    
    $result = $this->_sales->query($sql);
  
  return $result->result();
}

function get_rkap_data($param){
    $this->_sales=$this->load->database('default5',true);
    $paramCompany = "";
    if($param['company'] == 'ALL'){
        $paramCompany = "IN ('4000','7000','3000','6000') ";
    }else{
        $paramCompany = " = '{$param['company']}'";
    }
   $sql = "SELECT
                        tahun,
                        bulan,
                        SUM (target_rkap) AS RKAP
                    FROM
                        ZREPORT_RPTREAL_RESUM
                    WHERE
                        com $paramCompany
                    AND tahun = '{$param['tahun']}'
                    AND bulan = '{$param['bulan']}'
                    GROUP BY
                        tahun,
                        bulan";
/*    '{$param['tahun']}'
        $sql = "SELECT
                        CO,
                        -- TIPE,
                        THN,
                        BLN,
                        SUM (quantum) AS RKAP
                    FROM
                        SAP_T_RENCANA_SALES_TYPE
                    WHERE
                        co = '" . $company . "'
                    AND thn = '" . $tahun . "'
                    AND bln = '" . $bulan . "'
                    GROUP BY
                        CO,
                        -- TIPE,
                        THN,
                        BLN";
    }
*/
     $result = $this->_sales->query($sql);
  
  return $result->row();
}


}
