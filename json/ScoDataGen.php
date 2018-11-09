<title>Json</title>

<?php
header('Access-Control-Allow-Origin: *');
$user = "DEVSD";
$pass = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass,$_ora_sco);

$orgv = 7000;
$tahun = 2016;
$bulan = 09;
$sql = "SELECT * FROM (select 7000 as company, tbm1.*,tbm2.NM_PROV,tbm2.NM_PROV_1,tbm2.ID_REGION,tbm2.URUT_BARU  from (
                select tb1.*,nvl(tb2.real,0) as real from (
                select a.prov, sum(a.quantum) as target
                from sap_t_rencana_sales_type a                             
                where co = '7000' and thn = '2016' and bln = '09' and a.prov!='0001' and a.prov!='1092'
                group by a.prov
                )tb1 left join (
                    select propinsi_to, sum(real) as real from(
                    select propinsi_to, sum(kwantumx) as real
                    from zreport_rpt_real 
                    where         
                    to_char(tgl_cmplt,'YYYYMM')='201609'
                    and ( (order_type <>'ZNL' and
                    (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
                    and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
                    and sold_to like '0000000%' 
                    group by propinsi_to
                    union
                    select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='7000' and LFART='ZLR' and
                    to_char(wadat_ist,'YYYYMM')='201609'
                    and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                    and kunag like '0000000%' 
                    group by vkbur
                    )
                    group by propinsi_to
                )tb2 on (tb1.prov=tb2.propinsi_to)
                )tbm1 left join ZREPORT_M_PROVINSI tbm2 on (tbm1.prov=tbm2.KD_PROV)
                where (TARGET>0 or REAL>0)
                order by tbm2.URUT_BARU asc)
UNION

SELECT * FROM (select 3000 as company, tbm1.*,tbm2.NM_PROV,tbm2.NM_PROV_1,tbm2.ID_REGION,tbm2.URUT_BARU  from (
                select tb1.*,nvl(tb2.real,0) as real from (
                select a.prov, sum(a.quantum) as target
                from sap_t_rencana_sales_type a                             
                where co = '3000' and thn = '2016' and bln = '09' and a.prov!='0001' and a.prov!='1092'
                group by a.prov
                )tb1 left join (
                    select propinsi_to, sum(real) as real from(
                    select vkbur as propinsi_to, sum(ton) as real
                    from zreport_ongkosangkut_mod 
                    where                 
                    to_char(wadat_ist,'yyyymm') ='201609'
                    and lfart <>'ZNL' 
                    and (
                      (matnr like '121-301%' and matnr <> '121-301-0240'  ) or                            
                      (matnr like '121-302%')
                    )
                    and vkorg = '3000'
                    and kunag not in ('0000040084','0000040147','0000040272') 
                    group by vkbur
                    union
                    select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='3000' and LFART='ZLR' and
                    to_char(wadat_ist,'YYYYMM')='201609'
                    and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                    and kunag not in ('0000040084','0000040147','0000040272') 
                    group by vkbur
                    )
                    group by propinsi_to
                )tb2 on (tb1.prov=tb2.propinsi_to)
                )tbm1 left join ZREPORT_M_PROVINSI tbm2 on (tbm1.prov=tbm2.KD_PROV)
                where (TARGET>0 or REAL>0)
                order by tbm2.URUT_BARU asc)
UNION
SELECT * FROM (select 4000 as company, tbm1.*,tbm2.NM_PROV,tbm2.NM_PROV_1,tbm2.ID_REGION,tbm2.URUT_BARU  from (
                select tb1.*,nvl(tb2.real,0) as real from (
                select a.prov, sum(a.quantum) as target
                from sap_t_rencana_sales_type a                             
                where co = '4000' and thn = '2016' and bln = '09' and a.prov!='0001' and a.prov!='1092'
                group by a.prov
                )tb1 left join (
                    select propinsi_to, sum(real) as real from(
                    select propinsi_to, sum(kwantumx) as real
                    from zreport_rpt_real_st 
                    where         
                    to_char(tgl_cmplt,'YYYYMM')='201609'
                    and ( (order_type <>'ZNL' and
                    (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
                    and order_type <>'ZNL') ) and com = '$orgv' and no_polisi <> 'S11LO'
                    and sold_to like '000000%' 
                    and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
                    and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                    and ORDER_TYPE<>'ZLFE'
                    group by propinsi_to
                    union
                    select vkbur as propinsi_to, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD where VKORG='4000' and LFART='ZLR' and
                    to_char(wadat_ist,'YYYYMM')='201609'
                    and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%')) 
                    and kunnr not like '000000%'
                    and kunag not in ('0000040084','0000040147','0000040272','0000000888') 
                    and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
                    group by vkbur
                    union
                    select ti.propinsi_to,sum(ti.KWANTUMX) as real 
                    from ZREPORT_RPT_REAL_NON70_ST ti 
                    where ti.ITEM_NO LIKE '121-301%'
                    and item_no <> '121-301-0240'
                    and ti.COM='4000'
                    and ti.ROUTE='ZR0001'
                    and ti.STATUS in ('50')
                    and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
                    group by ti.propinsi_to
                    )
                    group by propinsi_to
                )tb2 on (tb1.prov=tb2.propinsi_to)
                )tbm1 left join ZREPORT_M_PROVINSI tbm2 on (tbm1.prov=tbm2.KD_PROV)
                where (TARGET>0 or REAL>0)
                order by tbm2.URUT_BARU asc)";

$queryOracle = oci_parse($conn,$sql);
		oci_execute($queryOracle);
		while ($rowID=oci_fetch_array($queryOracle)){
		
			$co_code = $rowID['COMPANY'];
			$prov_desc = $rowID['NM_PROV_1'];		
			$target_val = $rowID['TARGET'];
			$real_val = $rowID['REAL'];
			
			$toAllTarget[$rowID['COMPANY']][] = number_format($rowID['TARGET'],0,",",".");
			$toAllReal[$rowID['COMPANY']][] = number_format($rowID['REAL'],0,",",".");
			
			$text[$rowID['COMPANY']]= array(
						"company"=>$co_code,
						"target"=> $target_val,
						"real"=>$real_val);
						
			/*$text[$rowID['COMPANY']]= array(
						"target"=> array_sum($toAllTarget[$rowID['COMPANY']]),
						"real"=>array_sum($toAllReal[$rowID['COMPANY']]));*/
			 
			$go[]=array($prov_desc=>$text[$rowID['COMPANY']]);
		}
		
		echo '({"message":"","status":"OK","tags":'.json_encode($go);
?>