<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    
# SAP Connection #
require_once("../../sgg/include/connect/SAPDataModule_Connection.php");
$sap_con = New SAPDataModule_Connection();
$sap = $sap_con->getConnSAP(); //_Dev(); //getConnSAP();
#/SAP Connection #

#Koneksi###
$ora_con = $sap_con->koneksiSD_Dev();
if(!$ora_con || !$sap_con) { echo "Koneksi oracle gagal"; }

$tgl = '11';
$tahun = '2016';
$sqlDelete = " delete from zreport_rptreal_resum_daily where tahun='$tahun' and bulan = '$tgl' ";
$query= oci_parse($ora_con, $sqlDelete);
$sukses_del = oci_execute($query);
if(!$sukses_del) { echo "Gagal hapus";exit; } else{ echo "delete ok";
$sqlInsert = " insert into zreport_rptreal_resum_daily (com,tipe,tahun,bulan,tgl,real,rkap)
        select com,typem,tahun,bulan,tgl,sum(reals) reals,sum(rkap_jadi) rkap_jadi from (select tbreal.*,tbrkap.rkap_jadi FROM
                (select com,typem,substr(tanggal,0,4) as tahun,substr(tanggal,5,2) as bulan,substr(tanggal,7,2) as tgl , sum(reals) as reals FROM
                (select com, typem, tanggal, sum(real) as reals from (
                --semen gresik
                select com,typem, tanggal, sum(real) as real from(
                    select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                    from zreport_rpt_real
                    where        
                    to_char(tgl_cmplt,'YYYYMM') like '$tahun$tgl%'
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
                    to_char(wadat_ist,'yyyymmdd') like '$tahun$tgl%'
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
                    to_char(tgl_cmplt,'YYYYMM') LIKE '$tahun$tgl%'
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
                    to_char(tgl_cmplt,'YYYYMM')like '$tahun$tgl%'
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
                        and to_char(TI.TGL_DO,'YYYYMM') LIKE '$tahun$tgl%'
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
                to_char(TGL_SPJ,'yyyymm')like '$tahun$tgl%'
                and order_type <>'ZNL'
                and propinsi_to like '6%'
                and item_no like '121-3%'
                and com = '6000'
                group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
                union
                select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
                from zreport_rpt_real_tlcc where
                    to_char(TGL_SPJ,'yyyymm') like '$tahun$tgl%'
                    and order_type <>'ZNL'
                    and propinsi_to not like '6%'
                    and item_no like '121-3%'
                    and com = '6000'
                group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
                UNION
                --return
                 select VKORG as com,substr(matnr,0,7) as typem,to_char(wadat_ist,'yyyymmdd') as tanggal, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD
                     where VKORG in ('7000','6000','3000','4000') and LFART='ZLR' and
                     to_char(wadat_ist,'YYYYMM') like '$tahun$tgl%'
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
                where vkorg in ('7000','6000','3000','4000') and budat like '$tahun$tgl%' and region=5)) tb1
                LEFT JOIN (
                (SELECT vkorg,region,tipe,sum(porsi) as porsi_total 
                from ZREPORT_PORSI_SALES_REGION
                where vkorg in ('7000','6000','3000','4000') and budat like '$tahun$tgl%' and region=5
                GROUP BY vkorg,region,tipe) tb2
                ) on (TB1.com=TB2.vkorg and tb1.tipe=tb2.tipe)
                )tb4
                LEFT JOIN (
                (SELECT COM,TIPE,TAHUN,BULAN,sum(target_rkap) as  RKAP 
                from ZREPORT_RPTREAL_RESUM
                where COM in ('7000','6000','3000','4000') and TAHUN='$tahun' and BULAN='$tgl' AND TIPE<>'121-200'
                GROUP BY COM,TIPE,TAHUN,BULAN)tb3)
                on (TB4.com = TB3.com and TB4.TIPE=TB3.tipe and TB4.TAHUN=TB3.TAHUN and TB4.bulan=TB3.BULAN))tbrkap
                on TBREAL.COM=TBRKAP.COM and TBREAL.TYPEM=TBRKAP.TIPE and TBREAL.tahun=TBRKAP.tahun and TBREAL.bulan=TBRKAP.BULAN and TBREAL.tgl=TBRKAP.TANGGAL
                where TBREAL.COM in ('7000','6000','3000','4000')
				) 
		where com in ('7000','6000','3000','4000') group by com,typem,tahun,bulan,tgl order by tgl )";
$query_insert= oci_parse($ora_con, $sqlInsert);
$sukses_del = oci_execute($query);
if($sukses_del){
    echo 'sukses insert';
}else{
    echo 'gagal insert';
}

oci_free_statement($query);
oci_close($ora_con);
}