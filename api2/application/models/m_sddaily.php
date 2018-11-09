<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sddaily extends CI_Model {

    public function get_sddaily()
    {
        $db=$this->load->database('default5',true);
        if (!empty($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
} else {
    $bulan = date('m');
}

if (!empty($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
} else {
    $tahun = date('Y');
}

if (!empty($_GET['company'])) {
    switch ($_GET['company']) {
        case 1 :
            $company = 3000;
            break;
        case 2 :
            $company = 4000;
            break;
        case 3 :
            $company = 5000;
            break;
        case 4 :
            $company = 6000;
            break;
        case 5 :
            $company = 7000;
            break;
        default :
            $company = "";
    }
} else {
    $company = "";
}
$sql = $db->query("select com, item, tanggal, sum(real) as Real from (
------- Realnya sg 
select com,substr(ITEM_NO,0,7) as item,to_char(TGL_CMPLT,'YYYYMMDD') as tanggal, sum(KWANTUMX) as real
        from zreport_rpt_real 
        where
        to_char(TGL_CMPLT,'YYYYMM') LIKE '2016%' AND 
        ((ORDER_TYPE<> 'ZNL' and(ITEM_NO like '121-301%' and item_no <> '121-301-0240')) or (ITEM_NO like '121-302%' and order_type <>'ZNL'))
        group by com,to_char(TGL_CMPLT,'YYYYMMDD') ,substr(ITEM_NO,0,7)
------- realnya padang
UNION
select vkorg as com, substr(matnr,0,7) as item,to_char(wadat_ist,'yyyymmdd') as tanggal, sum(ton) as real
    from zreport_ongkosangkut_mod
    where                
    to_char(wadat_ist,'yyyymm') ='2016%'
    and lfart <>'ZNL'
    and ((matnr like '121-301%' and matnr <> '121-301-0240'  ) or (matnr like '121-302%')  or (matnr like '121-200%' and  vkbur='0001'))
    and vkorg = '3000'
    and kunag not in ('0000040084','0000040147','0000040272')
    group by vkorg, to_char(wadat_ist,'yyyymmdd'),substr(matnr,0,7)

------- realnya tonasa
UNION
select com, substr(item_no,0,7) as item, to_char(tgl_cmplt,'YYYYMMDD') as tanggal,sum(kwantumx) as real
    from zreport_rpt_real_st
    where        
    to_char(tgl_cmplt,'YYYYMM')='2016%'
    and ( (order_type <>'ZNL' and
    (item_no like '121-301%' and item_no <> '121-301-0240')) or (item_no like '121-302%'
    and order_type <>'ZNL') ) and com = '4000' 
    and sold_to like '000000%'
    and SOLD_TO not in ('0000040084','0000040147','0000040272','0000000888')
    and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
    and ORDER_TYPE<>'ZLFE'
    group by com,to_char(tgl_cmplt,'YYYYMMDD'),substr(item_no,0,7)
UNION   
------- realnya tonasa export
select com,substr(item_no,0,7) as item,  to_char(tgl_cmplt,'YYYYMMDD') as tanggal, sum(kwantumx) as real
    from zreport_rpt_real_st
    where        
    to_char(tgl_cmplt,'YYYYMM')='2016%' ---DATA HANYA ADA PADA TAHUN 2013 - 2016
    and com = '4000'
    and SOLD_TO not in ('0000000835','0000000836','0000000837') --Pemakaian Sendiri
    and ORDER_TYPE='ZLFE'
    group by com,substr(item_no,0,7), to_char(tgl_cmplt,'YYYYMMDD')
UNION
select a.COM,substr(item_no,0,7) as tipe,to_char(a.tgl_cmplt,'YYYYMMDD') as tanggal,sum(a.KWANTUMX) as real
    from ZREPORT_RPT_REAL_NON70_ST a
    where a.ITEM_NO LIKE '121-301%'
    and item_no <> '121-301-0240'
    and a.COM='4000'
    and a.ROUTE='ZR0001'
    and a.STATUS in ('50')
    and a.no_transaksi NOT IN( SELECT g.no_transaksi FROM zreport_rpt_real_st g where g.COM='4000')
    group by a.COM,to_char(a.tgl_cmplt,'YYYYMMDD'),substr(item_no,0,7)
------- real tlcc
union
select com,substr(item_no,0,7) as item,to_char(TGL_CMPLT,'yyyymmdd') as tanggal, sum(kwantumx) as real
    from zreport_rpt_real_tlcc where
    to_char(TGL_CMPLT,'yyyymm')='2016%'
    and order_type <>'ZNL'
    and propinsi_to like '6%'
    and item_no like '121-3%'
    and com = '6000'
    group by com,substr(item_no,0,7),to_char(TGL_CMPLT,'yyyymmdd')
union
select com,substr(item_no,0,7) as tipe,to_char(TGL_CMPLT,'yyyymmdd') as tanggal, sum(kwantumx) as real
    from zreport_rpt_real_tlcc where
    to_char(TGL_CMPLT,'yyyymm')='2016%'
    and order_type <>'ZNL'
    and propinsi_to not like '6%'
    and item_no like '121-3%'
    and com = '6000'
    group by com,substr(item_no,0,7), to_char(TGL_CMPLT,'yyyymmdd'))
where rownum < 100 and tanggal like '20161%'
group by com, item, tanggal
order by com, tanggal DESC");

foreach ($sql->result_array() as $rowID) {

    $company = $rowID['COM'];
    $tanggal = $rowID['TANGGAL'];
    $tipe = $rowID['ITEM'];
    $real_val = $rowID['REAL'];
    
    if ($tipe == '121-301'){
        $myType = 'curah';
    } else if ($tipe == '121-302') {
        $myType = 'zak';
    }
    $text[$myType][$tanggal]= array(
        "tipe" => $tipe,
        "tanggal" => $tanggal,
        "real" => $real_val
        );
}
echo '{"7000":'.json_encode($text).'}';
    }

}

/* End of file m_sddaily.php */
/* Location: ./application/models/m_sddaily.php */