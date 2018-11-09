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
        $select = "     
        TBREAL.TYPEM,
        TBREAL.TAHUN,
        TBREAL.BULAN,
        TBREAL.TGL,
        SUM(TBREAL.REALS) reals,
        SUM(TBRKAP.RKAP_JADI) rkap_jadi
        ";
        $paramCompany = " 
        where TBREAL.COM in ('7000','6000','3000','4000')  and tipe != '121-200' 
        GROUP BY TBREAL.TYPEM, TBREAL.TGL, TBREAL.BULAN, TBREAL.TAHUN
        ";
    }else{
        $select = "     
        tbreal.*,tbrkap.rkap_jadi 
        ";
        $paramCompany = " where TBREAL.COM = '{$param['company']}'";
    }


    
    
    
    // $sql = "select 

    //         $select

    //         FROM
    //             (select com,typem,substr(tanggal,0,4) as tahun,substr(tanggal,5,2) as bulan,substr(tanggal,7,2) as tgl , sum(reals) as reals FROM
    //             (select com, typem, tanggal, sum(real) as reals from (
    //             --semen gresik
    //             select com,typem, tanggal, sum(real) as real from(
    //                 select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
    //                 from zreport_rpt_real
    //                 where        
    //                 to_char(tgl_cmplt,'YYYYMM') like '{$param['tahun']}{$param['bulan']}%'
    //                 and ( (order_type <>'ZNL' and
    //                 (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
    //                 and order_type <>'ZNL') ) and (plant <>'2490' or plant <>'7490') and com = '7000' and no_polisi <> 'S11LO'
    //                 and sold_to like '0000000%'
    //                 group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
    //                 )
    //                 group by com,typem,tanggal
    //             UNION
    //             --semen padang 
    //                 select com, typem, tanggal, sum(real) as real from(
    //                 select vkorg as com, substr(matnr,0,7) as typem,to_char(WADAT_IST,'yyyymmdd') as tanggal, sum(ton) as real
    //                 from zreport_ongkosangkut_mod
    //                 where                
    //                 to_char(wadat_ist,'yyyymmdd') like '{$param['tahun']}{$param['bulan']}%'
    //                 and lfart <>'ZNL'
    //                 and ((matnr like '121-301%' and matnr <> '121-301-0240'  ) or (matnr like '121-302%'))
    //                 and vkorg = '3000'
    //                 and kunag not in ('0000040084','0000040147','0000040272')
    //                 group by vkorg,substr(matnr,0,7),to_char(WADAT_IST,'yyyymmdd')
    //                 )
    //                 group by com,typem, tanggal
    //             union
    //             -- semen tonasa 
    //                 select com,typem, tanggal, sum(real) as real from(
    //                 select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
    //                 from zreport_rpt_real_st
    //                 where        
    //                 to_char(tgl_cmplt,'YYYYMM') LIKE '{$param['tahun']}{$param['bulan']}%'
    //                 and ( (order_type <>'ZNL' and
    //                 (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
    //                 and order_type <>'ZNL') ) and com = '4000' and no_polisi <> 'S11LO'
    //                 and sold_to like '000000%'
    //                 and propinsi_to <> 10 
    //                 and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
    //                 and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
    //                 and ORDER_TYPE<>'ZLFE'
    //                 group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
    //                 union
    //                     select com,substr(item_no,0,7) as typem, to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
    //                 from zreport_rpt_real_st
    //                 where        
    //                 to_char(tgl_cmplt,'YYYYMM')like '{$param['tahun']}{$param['bulan']}%'
    //                 and com = '4000'
    //                 and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
    //                 and ORDER_TYPE='ZLFE'
    //                 group by com,substr(item_no,0,7), to_char(TGL_CMPLT,'YYYYMMDD')
    //                     union
    //                 select ti.COM,substr(item_no,0,7) as typem,to_char(TGL_DO,'YYYYMMDD') as tanggal,sum(ti.KWANTUMX) as real
    //                 from ZREPORT_RPT_REAL_NON70_ST ti
    //                 where ti.ITEM_NO LIKE '121-301%'
    //                 and item_no <> '121-301-0240'
    //                 and ti.COM='4000'
    //                     and to_char(TI.TGL_DO,'YYYYMM') LIKE '{$param['tahun']}{$param['bulan']}%'
    //                 and ti.ROUTE='ZR0001'
    //                 and ti.STATUS in ('50')
    //                 and ti.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
    //                 group by ti.COM,substr(item_no,0,7),to_char(TGL_DO,'YYYYMMDD')
    //                 )group by COM,typem,tanggal
    //             UNION
    //             --tlcc
    //             select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
    //             from zreport_rpt_real_tlcc
    //             where 
    //             to_char(TGL_SPJ,'yyyymm')like '{$param['tahun']}{$param['bulan']}%'
    //             and order_type <>'ZNL'
    //             and propinsi_to like '6%'
    //             and item_no like '121-3%'
    //             and com = '6000'
    //             group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
    //             union
    //             select com, substr(item_no,0,7) as typem,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(kwantumx) as real
    //             from zreport_rpt_real_tlcc where
    //                 to_char(TGL_SPJ,'yyyymm') like '{$param['tahun']}{$param['bulan']}%'
    //                 and order_type <>'ZNL'
    //                 and propinsi_to not like '6%'
    //                 and item_no like '121-3%'
    //                 and com = '6000'
    //             group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'YYYYMMDD')
    //             UNION
    //             --return
    //              select VKORG as com,substr(matnr,0,7) as typem,to_char(wadat_ist,'yyyymmdd') as tanggal, sum(ton) as real from ZREPORT_ONGKOSANGKUT_MOD
    //                  where VKORG in ('7000','6000','3000','4000') and LFART='ZLR' and
    //                  to_char(wadat_ist,'YYYYMM') like '{$param['tahun']}{$param['bulan']}%'
    //                  and  ((matnr like '121-301%' and matnr <> '121-301-0240') or (matnr like '121-302%'))
    //                  and kunag like '0000000%'
    //                  and kunnr not like '000000%'
    //                  and kunag not in ('0000040084','0000040147','0000040272','0000000888')  
    //                  and kunag not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
    //                  group by VKORG,vkbur,substr(matnr,0,7),to_char(WADAT_IST,'yyyymmdd')
    //             )
    //             GROUP BY com, typem,tanggal)
    //             group by com, typem,substr(tanggal,0,4),substr(tanggal,5,2),substr(tanggal,7,2))tbreal
    //             LEFT JOIN
    //             --rkap
    //             (SELECT TB4.com,TB4.TIPE,TB4.tahun,TB4.bulan,TB4.TANGGAL,((tb4.RKAP_H)*tb3.RKAP/100) as RKAP_JADI
    //             FROM
    //             (select tb1.com,TB1.TIPE,TB1.tahun,TB1.bulan,TB1.tanggal,TB1.PORSI,tb2.porsi_total, ((tb1.porsi/tb2.porsi_total)*100) as RKAP_H 
    //             from
    //             (select * from
    //             (SELECT vkorg as com,tipe,substr(budat,0,4) as tahun,substr(budat,5,2) as bulan,substr(budat,7,2) as tanggal,porsi
    //             from ZREPORT_PORSI_SALES_REGION
    //             where vkorg in ('7000','6000','3000','4000') and budat like '{$param['tahun']}{$param['bulan']}%' and region=5)) tb1
    //             LEFT JOIN (
    //             (SELECT vkorg,region,tipe,sum(porsi) as porsi_total 
    //             from ZREPORT_PORSI_SALES_REGION
    //             where vkorg in ('7000','6000','3000','4000') and budat like '{$param['tahun']}{$param['bulan']}%' and region=5
    //             GROUP BY vkorg,region,tipe) tb2
    //             ) on (TB1.com=TB2.vkorg and tb1.tipe=tb2.tipe)
    //             )tb4
    //             LEFT JOIN (
    //             (SELECT COM,TIPE,TAHUN,BULAN,sum(target_rkap) as  RKAP 
    //             from ZREPORT_RPTREAL_RESUM
    //             where COM in ('7000','6000','3000','4000') and TAHUN='{$param['tahun']}' and BULAN='{$param['bulan']}' AND TIPE<>'121-200'
    //             GROUP BY COM,TIPE,TAHUN,BULAN)tb3)
    //             on (TB4.com = TB3.com and TB4.TIPE=TB3.tipe and TB4.TAHUN=TB3.TAHUN and TB4.bulan=TB3.BULAN))tbrkap
    //             on TBREAL.COM=TBRKAP.COM and TBREAL.TYPEM=TBRKAP.TIPE and TBREAL.tahun=TBRKAP.tahun and TBREAL.bulan=TBRKAP.BULAN and TBREAL.tgl=TBRKAP.TANGGAL
    //             $paramCompany 

    //               ";

    $sql = "select 

            $select

            FROM
                (
                SELECT VKORG AS COM,
                    MATERIAL AS TYPEM,
                    TO_CHAR (budat, 'yyyy') AS TAHUN,
                    TO_CHAR (budat, 'mm') AS BULAN,
                    TO_CHAR (budat, 'dd') AS TGL,
                    SUM(TOTAL_QTY) AS REALS
                    FROM MV_REVENUE
                    WHERE TO_CHAR (budat, 'yyyymm') = '{$param['tahun']}{$param['bulan']}' GROUP BY VKORG,BUDAT,MATERIAL
                    ORDER BY BUDAT ASC)tbreal
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

function get_last_update(){
    $this->_sales=$this->load->database('default5',true);

    $sql ="SELECT
                TO_CHAR(MAX (LAST_UPDATEDATE), 'DD/MM/YYYY HH:Mi:ss') AS LAST_UPDATE
            FROM
                ZREPORT_RPTREAL_RESUM_DAILY
            --WHERE
             --   COM = '4000'
             ";
      $result = $this->_sales->query($sql);
  
  return $result->row();
}

function get_data_rev($param){
    $this->_sales=$this->load->database('default5',true);

    $paramCompany = "";
    if($param['company'] == 'ALL'){
        $select = "
                    REVREAL.DATEDAY,
                    SUM(REVREAL.REV_REAL) AS REV_REAL,
                    SUM(REVRKAP.RKAP_REVENU) AS RKAP_REVENU
            ";
        $paramCompany = " where VKORG in ('7000','6000','3000','4000')  GROUP BY
                            REVREAL.DATEDAY";
    }else{
        $select = "
            REVREAL.*, REVRKAP.RKAP_REVENU
            ";
        $paramCompany = " where VKORG = '{$param['company']}'";
    }
    


    $sql = "SELECT
            
            $select

            FROM
                --real revenue
                (
                    
                    SELECT VKORG,
                        TO_CHAR (budat, 'yyyymmdd') AS DATEDAY,
                        SUM(REVENUE) AS REV_REAL 
                    FROM MV_REVENUE 
                    WHERE TO_CHAR (budat, 'yyyymm') = '{$param['tahun']}{$param['bulan']}' GROUP BY VKORG,BUDAT
                ) REVREAL
            LEFT JOIN --rkap revenue
            (
                SELECT
                    tbkkl.co,
                    tbmlll.budat,
                    SUM (
                        tbkkl.revenue * (
                            tbmlll.porsi / tbmlll.porsitot
                        )
                    ) AS rkap_revenu
                FROM
                    (
                        SELECT
                            CO,
                            THN,
                            BLN,
                            SUM (rkap_rev) AS Revenue
                        FROM
                            (
                                SELECT
                                    tbm.CO,
                                    tbm.THN,
                                    BLN,
                                    CASE
                                WHEN SUM (tbm.quantum) = 0 THEN
                                    0
                                ELSE
                                    SUM (tbm.revenue)
                                END rkap_rev
                                FROM
                                    SAP_T_RENCANA_SALES_TYPE tbm
                                WHERE
                                    thn = '{$param['tahun']}'
                                AND bln = {$param['bulan']}
                                AND prov <> '1092'
                                AND prov <> '0001'
                                GROUP BY
                                    CO,
                                    THN,
                                    BLN
                            )
                        GROUP BY
                            CO,
                            THN,
                            BLN
                    ) tbkkl
                LEFT JOIN (
                    SELECT
                        tbmpo.*, tbmposum.porsitot
                    FROM
                        (
                            SELECT
                                vkorg,
                                budat,
                                SUM (porsi) AS porsi
                            FROM
                                zreport_porsi_sales_region
                            WHERE
                                region = 5
                            AND budat LIKE '{$param['tahun']}{$param['bulan']}%'
                            GROUP BY
                                vkorg,
                                budat
                        ) tbmpo
                    LEFT JOIN (
                        SELECT
                            vkorg,
                            SUM (porsi) AS porsitot
                        FROM
                            zreport_porsi_sales_region
                        WHERE
                            region = 5
                        AND budat LIKE '{$param['tahun']}{$param['bulan']}%'
                        GROUP BY
                            vkorg
                    ) tbmposum ON (tbmpo.vkorg = tbmposum.vkorg)
                    ORDER BY
                        tbmpo.vkorg,
                        tbmpo.budat
                ) tbmlll ON (tbkkl.co = tbmlll.vkorg)
                GROUP BY
                    tbkkl.co,
                    tbmlll.budat
                ORDER BY
                    tbkkl.co,
                    tbmlll.budat ASC
            ) REVRKAP ON REVREAL.VKORG = REVRKAP.CO
            AND REVREAL.DATEDAY = REVRKAP.BUDAT
            
            $paramCompany

                -- GROUP BY REVREAL.VKORG";
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
                        SUM (target_rkap) AS RKAP,
                        SUM(revenu_rkap) AS REV_RKAP
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


function get_vol_data($param){
    $this->_sales=$this->load->database('default5',true);
    $paramCompany = "";
    if($param['company'] == 'ALL'){
        $paramCompany = "IN ('4000','7000','3000','6000') ";
    }else{
        $paramCompany = " = '{$param['company']}'";
    }
   $sql = "SELECT 	TO_CHAR (budat, 'yyyy') AS TAHUN,
				TO_CHAR (budat, 'mm') AS BULAN,
				TO_CHAR (budat, 'dd') AS TGL,
				SUM(TOTAL_QTY) AS REALS
				FROM MV_REVENUE
				WHERE TO_CHAR (budat, 'yyyymm') = '{$param['tahun']}{$param['bulan']}' 
				AND VKORG $paramCompany 
				GROUP BY BUDAT
				ORDER BY BUDAT ASC";
     $result = $this->_sales->query($sql);
  
  return $result->result();
}


function get_data_resum($param){
    $this->_sales=$this->load->database('default5',true);
        $group = '';
      if($param['company'] == 'ALL'){
         $select = "select sum(real) REALS, sum(rkap) RKAP_JADI,TAHUN,BULAN,TGL,tipe as TYPEM ";
         $paramCom = "and com in ('7000','6000','3000','4000') and tipe != '121-200' ";
         $group = "group by tipe,tahun,bulan,tgl";
      }else{
         $select = "select real REALS, rkap RKAP_JADI,TAHUN,BULAN,TGL,tipe as TYPEM ";
         $paramCom = "and COM in '{$param['company']}' and tipe != '121-200' ";
      }
    $result = $this->_sales->query("$select from zreport_rptreal_resum_daily "
            . "where tahun = '{$param['tahun']}' and bulan='{$param['bulan']}' $paramCom  $group ");
    return $result->result();
}

function get_data_resum_daily($param){
    $this->_sales=$this->load->database('default5',true);
        $group = '';
      if($param['company'] == 'ALL'){
         $select = "SELECT 	MATERIAL AS TYPEM, TO_CHAR (budat, 'yyyy') AS TAHUN, TO_CHAR (budat, 'mm') AS BULAN, TO_CHAR (budat, 'dd') AS TGL,SUM(TOTAL_QTY) AS REALS";
         $paramCom = "('7000','6000','3000','4000')";
         $group = "GROUP BY BUDAT, MATERIAL";
      }else{
         $select = "SELECT 	MATERIAL AS TYPEM, TO_CHAR (budat, 'yyyy') AS TAHUN, TO_CHAR (budat, 'mm') AS BULAN, TO_CHAR (budat, 'dd') AS TGL, SUM(TOTAL_QTY) AS REALS";
         $paramCom = "'{$param['company']}'";
         $group = "GROUP BY BUDAT, MATERIAL";
      }
    $result = $this->_sales->query("$select FROM MV_REVENUE "
            . "WHERE TO_CHAR (budat, 'yyyymm') = '{$param['tahun']}{$param['bulan']}' AND MATERIAL != '121-200' AND VKORG in $paramCom  $group ");
    return $result->result();
}


}
