<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class M_volproduksismig extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $db=$this->load->database('default5',true);
  }

    function get_data($year,$month,$date){
        $db=$this->load->database('default5',true);
        $progrkap=$db->query("SELECT
              A .com,
              A .domestik,
              A .ekspor,
              NVL (b.domestik, 0) rkap_domestik,
              NVL (b.rkap_expor, 0) rkap_ekspor,
              c.REAL_EKSPOR REAL_TERAK
            FROM
              (
                SELECT
                  A .com,
                  NVL (A .domestik, 0) domestik,
                  NVL (b.ekspor, 0) ekspor
                FROM
                  (
                    SELECT
                      com,
                      SUM (realto) domestik
                    FROM
                      zreport_rptreal_resum
                    WHERE
                      tahun = '$year'
                    AND bulan = '$month'
                    AND com IN (
                      '7000',
                      '3000',
                      '4000'
                    )
                    AND propinsi != '0001'
                    AND tipe != '121-200'
                    GROUP BY
                      com
                  ) A
                LEFT JOIN (
                  SELECT
                    com,
                    SUM (realto) ekspor
                  FROM
                    zreport_rptreal_resum
                  WHERE
                    tahun = '$year'
                  AND bulan = '$month'
                  AND com IN (
                    '7000',
                    '3000',
                    '4000'
                  )
                  AND propinsi = '0001'
                  AND tipe != '121-200' -- ini di buang yg terak tlcc
                  GROUP BY
                    com
                ) b ON A .com = b.com
              ) A
            LEFT JOIN -- RKAP
            (
              SELECT
                A .org,
                NVL (A .rkap_sd, 0) domestik,
                NVL (b.rkap, 0) rkap_expor
              FROM
                (
                  SELECT
                    org,
                    SUM (target) rkap_sd
                  FROM
                    (
                      SELECT
                        A .co ORG,
                        c.budat,
                        SUM (
                          A .quantum * (c.porsi / D .total_porsi)
                        ) AS target
                      FROM
                        sap_t_rencana_sales_type A
                      LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                      AND c.vkorg = A .co
                      AND c.budat LIKE '$year$month%'
                      AND c.tipe = A .tipe
                      LEFT JOIN (
                        SELECT
                          region,
                          tipe,
                          SUM (porsi) AS total_porsi
                        FROM
                          zreport_porsi_sales_region
                        WHERE
                          budat LIKE '$year$month%'
                        AND VKORG = '7000'
                        GROUP BY
                          region,
                          tipe
                      ) D ON c.region = D .region
                      AND D .tipe = A .tipe
                      WHERE
                        co = '7000'
                      AND thn = '$year'
                      AND bln = '$month'
                      AND prov != '0001'
                      AND prov != '1092'
                      GROUP BY
                        co,
                        thn,
                        bln,
                        c.budat
                    )
                  WHERE
                    budat < '$year$month$date'
                  GROUP BY
                    org
                ) A
              LEFT JOIN --####################### RKAP EKSPOR SG ########################
              (
                SELECT
                  co ORG,
                  SUM (quantum) AS RKAP
                FROM
                  sap_t_rencana_sales_type
                WHERE
                  co = '7000'
                AND thn = '$year'
                AND bln = '$month'
                AND prov = '0001'
                GROUP BY
                  co
              ) b ON A .org = b.org --#################################################################
              UNION
                --####################### RKAP SD DOMESTIK SP ########################
                SELECT
                  A .org,
                  A .rkap_sd rkap_domestik,
                  b.rkap rkap_ekspor
                FROM
                  (
                    SELECT
                      org,
                      SUM (target) rkap_sd
                    FROM
                      (
                        SELECT
                          A .co ORG,
                          c.budat,
                          SUM (
                            A .quantum * (c.porsi / D .total_porsi)
                          ) AS target
                        FROM
                          sap_t_rencana_sales_type A
                        LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                        AND c.vkorg = A .co
                        AND c.budat LIKE '$year$month%'
                        AND c.tipe = A .tipe
                        LEFT JOIN (
                          SELECT
                            region,
                            tipe,
                            SUM (porsi) AS total_porsi
                          FROM
                            zreport_porsi_sales_region
                          WHERE
                            budat LIKE '$year$month%'
                          AND VKORG = '3000'
                          GROUP BY
                            region,
                            tipe
                        ) D ON c.region = D .region
                        AND D .tipe = A .tipe
                        WHERE
                          co = '3000'
                        AND thn = '$year'
                        AND bln = '$month'
                        AND prov != '0001'
                        AND prov != '1092'
                        GROUP BY
                          co,
                          thn,
                          bln,
                          c.budat
                      )
                    WHERE
                      budat < '$year$month$date'
                    GROUP BY
                      org
                  ) A
                LEFT JOIN --#################################################################
                --####################### RKAP EKSPOR SP ########################
                (
                  SELECT
                    co ORG,
                    SUM (quantum) AS RKAP
                  FROM
                    sap_t_rencana_sales_type
                  WHERE
                    co = '3000'
                  AND thn = '$year'
                  AND bln = '$month'
                  AND prov = '0001'
                  GROUP BY
                    co
                ) b ON A .org = b.org --#################################################################
                UNION
                  --####################### RKAP SD DOMESTIK ST ########################
                  SELECT
                    A .org,
                    A .rkap_sd AS rkap_domestik,
                    b.rkap rkap_ekpor
                  FROM
                    (
                      SELECT
                        org,
                        SUM (target) rkap_sd
                      FROM
                        (
                          SELECT
                            A .co ORG,
                            c.budat,
                            SUM (
                              A .quantum * (c.porsi / D .total_porsi)
                            ) AS target
                          FROM
                            sap_t_rencana_sales_type A
                          LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                          AND c.vkorg = A .co
                          AND c.budat LIKE '$year$month%'
                          AND c.tipe = A .tipe
                          LEFT JOIN (
                            SELECT
                              region,
                              tipe,
                              SUM (porsi) AS total_porsi
                            FROM
                              zreport_porsi_sales_region
                            WHERE
                              budat LIKE '$year$month%'
                            AND VKORG = '4000'
                            GROUP BY
                              region,
                              tipe
                          ) D ON c.region = D .region
                          AND D .tipe = A .tipe
                          WHERE
                            co = '4000'
                          AND thn = '$year'
                          AND bln = '$month'
                          AND prov != '0001'
                          AND prov != '1092'
                          GROUP BY
                            co,
                            thn,
                            bln,
                            c.budat
                        )
                      WHERE
                        budat < '$year$month$date'
                      GROUP BY
                        org
                    ) A
                  LEFT JOIN --#################################################################
                  --####################### RKAP EKSPOR ST ########################
                  (
                    SELECT
                      co ORG,
                      SUM (quantum) AS RKAP
                    FROM
                      sap_t_rencana_sales_type
                    WHERE
                      co = '4000'
                    AND thn = '$year'
                    AND bln = '$month'
                    AND prov = '0001'
                    GROUP BY
                      co
                  ) b ON A .org = b.org --#################################################################

            ) b ON A .com = b.org
            LEFT JOIN (
              --############################ EKSPOR TERAK SEMEN GRESIK ############################
              --##################################################################################
              SELECT
                com org,
                SUM (realto) REAL_EKSPOR
              FROM
                zreport_rptreal_resum
              WHERE
                tipe = '121-200'
              AND com IN (
                
                '3000',
                '4000',
                '7000'
              )
              AND bulan = '$month'
              AND tahun = '$year'
              AND propinsi = '0001'
              GROUP BY
                com
            ) c ON A .com = c.org
            ");
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

 /*function salesVolumeSMI($param, $tanggal, $lastday,$org, $date){
	$tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        if ($date == date("Ym")) {
//            echo 'sekarang';
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = str_pad($hari-1, 2, '0', STR_PAD_LEFT);
            //echo $tanggal;
        } else {
//            echo 'gak sekarang';
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $this->db->query("SELECT
                                        TB1.COM,
                                        NVL (TB1.REALISASI, 0) REAL_TAHUN_INI,
                                        NVL (TB3.REALISASI, 0) REAL_SDK,
                                        NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        NVL (TB4.REALISASI_TAHUN_LALU, 0) REAL_TAHUNLALU,
                                        NVL (tb5.target_rkap, 0) rkap_ekspor,
                                        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNINI,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU,
                                        NVL (tb7.REALISASI, 0) REAL_SDH_TAHUNLALU
                                FROM
                                        (
                                                SELECT
                                                        ORG COM,
                                                        SUM (QTY) REALISASI
                                                FROM
                                                        ZREPORT_SCM_REAL_SALES
                                                WHERE
                                                        ORG = '$org'
                                                AND TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND ITEM != '121-200'
                                                AND PROPINSI_TO NOT IN ('0001', '1092')
                                                GROUP BY
                                                        ORG
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT <= '$tahun$bulan$tglkmrn' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .co COM,
                                                                        SUM (
                                                                                A .quantum * (c.porsi / D .total_porsi)
                                                                        ) AS target,
                                                                        BUDAT
                                                                FROM
                                                                        sap_t_rencana_sales_type A
                                                                LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                                                AND c.vkorg = A .co
                                                                AND c.budat LIKE '$tahun$bulan%'
                                                                AND c.tipe = A .tipe
                                                                LEFT JOIN (
                                                                        SELECT
                                                                                region,
                                                                                tipe,
                                                                                SUM (porsi) AS total_porsi
                                                                        FROM
                                                                                zreport_porsi_sales_region
                                                                        WHERE
                                                                                budat LIKE '$tahun$bulan%'
                                                                        AND vkorg = '$org'
                                                                        GROUP BY
                                                                                region,
                                                                                tipe
                                                                ) D ON c.region = D .region
                                                                AND D .tipe = A .tipe
                                                                WHERE
                                                                        co = '$org'
                                                                AND thn = '$tahun'
                                                                AND bln = '$bulan'
                                                                AND prov != '0001'
                                                                AND prov != '1092'
                                                                GROUP BY
                                                                        co,
                                                                        budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB1.COM = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                ORG COM,
                                                SUM (QTY) REALISASI
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$tglkmrn'
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                ) TB3 ON TB1.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                ORG COM,
                                                SUM (QTY) REALISASI_TAHUN_LALU
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                ) TB4 ON TB1.COM = TB4.COM
                                LEFT JOIN (
                                        SELECT
                                                A .com,
                                                A .target_rkap,
                                                A .real_sm_ekspor,
                                                b.REAL_TR_EKSPOR
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                SUM (TARGET_RKAP) TARGET_RKAP,
                                                                SUM (realto) real_sm_ekspor
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                        GROUP BY
                                                                com
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        com,
                                                        SUM (realto) real_tr_ekspor
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        com = '$org'
                                                AND tahun = '$tahun'
                                                AND bulan = '$bulan'
                                                AND propinsi = '0001'
                                                AND tipe = '121-200'
                                                GROUP BY
                                                        com
                                        ) b ON A .com = b.com
                                ) TB5 ON TB1.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                tahun,
                                                                realto
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND (tahun = '$tahun' OR tahun = '$tahunlalu')
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                ) PIVOT (
                                                        SUM (realto) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON tb1.com = tb6.com
                                LEFT JOIN (
                                        SELECT
                                                ORG COM,
                                                SUM (QTY) REALISASI
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND ITEM != '121-200'
                                        AND PROPINSI_TO NOT IN ('0001', '1092')
                                        GROUP BY
                                                ORG
                                ) TB7 ON TB1.COM = TB7.COM");
//        echo $this->db->last_query();
        return $data->row_array();
}
 */
function salesVolumeSMI($param, $tanggal, $lastday){

      $hariini = $param['day'];
      $bulanini = $param['month'];
      $tahunini = $param['year'];

      $harilalu= $lastday;


      $tahunlalu = $tahunini -1;

      $sql ="
    SELECT
      TB1.COM ORG,
      NVL (TB1.RKAP, 0) RKAP_SDK,
      NVL (TB1.REALISASI, 0) REAL_SDK,
      NVL (TB2.TAHUN_INI_REALISASI, 0) REAL_SDH,
      NVL (TB2.TAHUN_LALU_REALISASI, 0) REAL_TAHUNLALU,
      NVL (TB3.PROGNOSE, 0) PROGNOSE,
      NVL (tb4.target_rkap, 0) rkap_ekspor,
      NVL (tb4.real_sm_ekspor, 0) real_sm_ekspor,
      NVL (tb4.real_tr_ekspor, 0) real_tr_ekspor,
      NVL (tb5.REALISASI, 0) REAL_SDH_TAHUNLALU,
      NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNini,
      NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU
    FROM
      (
        SELECT
          COM,
          SUM (RKAP) RKAP,
          SUM (REALISASI) REALISASI
        FROM
          (
            SELECT
              TO_CHAR (COM) COM,
              SUM (RKAP) RKAP,
              SUM (REAL) REALISASI
            FROM
              ZREPORT_RPTREAL_RESUM_DAILY TB1
            WHERE
              TB1.COM = '4000'
            AND tipe != '121-200'
            AND TB1.TAHUN = '$tahunini'
            AND TB1.BULAN = '$bulanini'
            AND TB1.TGL <= '$harilalu'
            GROUP BY
              TB1.COM
            UNION
              SELECT
                TO_CHAR ('4000') COM,
                0 RKAP,
                SUM (\"qty\") REALISASI
              FROM
                ZREPORT_REAL_ST_ADJ
              WHERE
                \"tahun\" = '$tahunini'
              AND \"bulan\" = '$bulanini'
              AND \"hari\" <= '$harilalu'
              GROUP BY
                '4000'
          )
        GROUP BY
          COM
      ) TB1
    LEFT JOIN (
      SELECT
        *
      FROM
        (
          SELECT
            COM,
            tahun,
            REAL REALISASI
          FROM
            ZREPORT_RPTREAL_RESUM_DAILY
          WHERE
            COM = '4000'
          AND tipe != '121-200'
          AND (TAHUN = '$tahunini' OR TAHUN = '$tahunlalu')
          AND BULAN = '$bulanini'
          UNION
            SELECT
              TO_CHAR ('4000') COM,
              \"tahun\" tahun,
              \"qty\" REALISASI
            FROM
              ZREPORT_REAL_ST_ADJ
            WHERE
              (
                \"tahun\" = '$tahunini'
                OR \"tahun\" = '$tahunlalu'
              )
            AND \"bulan\" = '$bulanini'
        ) PIVOT (
          SUM (REALISASI) AS realisasi FOR (tahun) IN (
            '$tahunini' AS tahun_ini,
            '$tahunlalu' AS tahun_lalu
          )
        )
    ) TB2 ON TB1.COM = TB2.COM
    LEFT JOIN (
      SELECT
        A .co COM,
        SUM (
          A .quantum * (c.porsi / D .total_porsi)
        ) AS prognose
      FROM
        sap_t_rencana_sales_type A
      LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
      AND c.vkorg = A .co
      AND c.budat LIKE '$tahunini$bulanini%'
      AND c.tipe = A .tipe
      LEFT JOIN (
        SELECT
          region,
          tipe,
          SUM (porsi) AS total_porsi
        FROM
          zreport_porsi_sales_region
        WHERE
          budat LIKE '$tahunini$bulanini%'
        AND vkorg = '4000'
        GROUP BY
          region,
          tipe
      ) D ON c.region = D .region
      AND D .tipe = A .tipe
      WHERE
        co = '4000'
      AND thn = '$tahunini'
      AND bln = '$bulanini'
      AND prov != '0001'
      AND prov != '1092'
      AND budat > '$tanggal'
      GROUP BY
        co
    ) TB3 ON TB1.COM = TB3.COM
    LEFT JOIN (
      SELECT
        A .com,
        A .target_rkap,
        A .real_sm_ekspor,
        b.REAL_TR_EKSPOR
      FROM
        (
          SELECT
            com,
            SUM (TARGET_RKAP) TARGET_RKAP,
            SUM (realto) real_sm_ekspor
          FROM
            ZREPORT_RPTREAL_RESUM
          WHERE
            com = '4000'
          AND tahun = '$tahunini'
          AND bulan = '$bulanini'
          AND propinsi = '0001'
          AND tipe != '121-200'
          GROUP BY
            com
        ) A
      LEFT JOIN (
        SELECT
          com,
          SUM (realto) real_tr_ekspor
        FROM
          ZREPORT_RPTREAL_RESUM
        WHERE
          com = '4000'
        AND tahun = '$tahunini'
        AND bulan = '$bulanini'
        AND propinsi = '0001'
        AND tipe = '121-200'
        GROUP BY
          com
      ) b ON A .com = b.com
    ) tb4 ON tb1.com = tb4.com
    LEFT JOIN (
      SELECT
        COM,
        SUM (REALISASI) REALISASI
      FROM
        (
          SELECT
            COM,
            SUM (REAL) REALISASI
          FROM
            ZREPORT_RPTREAL_RESUM_DAILY
          WHERE
            COM = '4000'
          AND tipe != '121-200'
          AND TAHUN = '$tahunlalu'
          AND BULAN = '$bulanini'
          AND TGL <= '$hariini'
          GROUP BY
            COM
          UNION
            SELECT
              TO_CHAR ('4000') COM,
              SUM (\"qty\") REALISASI
            FROM
              ZREPORT_REAL_ST_ADJ
            WHERE
              \"tahun\" = '$tahunlalu'
            AND \"bulan\" = '$bulanini'
            AND \"hari\" <= '$hariini'
            GROUP BY
              '4000'
        )
      GROUP BY
        COM
    ) TB5 ON TB1.COM = TB5.COM
    LEFT JOIN (
      SELECT
        *
      FROM
        (
          SELECT
            com,
            tahun,
            realto
          FROM
            ZREPORT_RPTREAL_RESUM
          WHERE
            com = '4000'
          AND (tahun = '$tahunini' OR tahun = '$tahunlalu')
          AND bulan = '$bulanini'
          AND propinsi = '0001'
          AND tipe != '121-200'
        ) PIVOT (
          SUM (realto) AS realisasi FOR (tahun) IN (
            '$tahunini' AS tahun_ini,
            '$tahunlalu' AS tahun_lalu
          )
        )
    ) tb6 ON tb1.com = tb6.com
    UNION
      SELECT
        TB1.COM ORG,
        NVL (TB4.RKAP_SDK, 0) RKAP_SDK,
        NVL (TB1.REALISASI, 0) REAL_SDK,
        NVL (TB2.TAHUN_INI_REALISASI, 0) REAL_SDH,
        NVL (TB2.TAHUN_LALU_REALISASI, 0) REAL_TAHUNLALU,
        NVL (TB3.PROGNOSE, 0) PROGNOSE,
        NVL (tb5.target_rkap, 0) rkap_ekspor,
        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
        NVL (tb6.REALISASI, 0) REAL_SDH_TAHUNLALU,
        NVL (tb7.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNini,
        NVL (tb7.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU
      FROM
        (
          SELECT
            COM,
            SUM (RKAP) RKAP,
            SUM (REAL) REALISASI
          FROM
            ZREPORT_RPTREAL_RESUM_DAILY TB1
          WHERE
            TB1.COM = '3000'
          AND tipe != '121-200'
          AND TB1.TAHUN = '$tahunini'
          AND TB1.BULAN = '$bulanini'
          AND TB1.TGL <= '$harilalu'
          GROUP BY
            TB1.COM
        ) TB1
      LEFT JOIN (
        SELECT
          *
        FROM
          (
            SELECT
              COM,
              REAL,
              TAHUN
            FROM
              ZREPORT_RPTREAL_RESUM_DAILY
            WHERE
              COM = '3000'
            AND tipe != '121-200'
            AND (TAHUN = '$tahunini' OR TAHUN = '$tahunlalu')
            AND BULAN = '$bulanini'
          ) PIVOT (
            SUM (REAL) AS realisasi FOR (tahun) IN (
              '$tahunini' AS tahun_ini,
              '$tahunlalu' AS tahun_lalu
            )
          )
      ) TB2 ON TB1.COM = TB2.COM
      LEFT JOIN (
        SELECT
          ORG COM,
          SUM (TARGET_REALH) PROGNOSE
        FROM
          (
            SELECT
              A .org,
              c.budat,
              SUM (
                A .target * (c.porsi / D .total_porsi)
              ) AS target_realh
            FROM
              ZREPORT_TARGET_PLANTSCO A
            LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
            AND c.budat LIKE '$tahunini$bulanini%'
            AND c.tipe = A .tipe
            LEFT JOIN (
              SELECT
                region,
                tipe,
                SUM (porsi) AS total_porsi
              FROM
                zreport_porsi_sales_region
              WHERE
                budat LIKE '$tahunini$bulanini%'
              AND VKORG = '3000'
              GROUP BY
                region,
                tipe
            ) D ON D .tipe = A .tipe
            WHERE
              DELETE_MARK = 0
            AND JENIS IS NULL
            AND ORG = '3000'
            AND BULAN = '$bulanini'
            AND TAHUN = '$tahunini'
            AND PLANT NOT IN ('0001', '1092')
            AND A .TIPE != '121-200'
            AND budat > '$tanggal'
            GROUP BY
              A .org,
              tahun,
              bulan,
              c.budat
          )
        GROUP BY
          ORG
      ) TB3 ON TB1.COM = TB3.COM
      LEFT JOIN (
        SELECT
          ORG COM,
          SUM (TARGET_REALH) RKAP_SDK
        FROM
          (
            SELECT
              A .org,
              c.budat,
              SUM (
                A .target * (c.porsi / D .total_porsi)
              ) AS target_realh
            FROM
              ZREPORT_TARGET_PLANTSCO A
            LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
            AND c.budat LIKE '$tahunini$bulanini$hariini%'
            AND c.tipe = A .tipe
            LEFT JOIN (
              SELECT
                region,
                tipe,
                SUM (porsi) AS total_porsi
              FROM
                zreport_porsi_sales_region
              WHERE
                budat LIKE '$tahunini$bulanini$hariini%'
              AND VKORG = '3000'
              GROUP BY
                region,
                tipe
            ) D ON D .tipe = A .tipe
            WHERE
              DELETE_MARK = 0
            AND JENIS IS NULL
            AND ORG = '3000'
            AND BULAN = '$bulanini'
            AND TAHUN = '$tahunini'
            AND PLANT NOT IN ('0001', '1092')
            AND A .TIPE != '121-200'
            AND budat <= '$hariini'
            GROUP BY
              A .org,
              tahun,
              bulan,
              c.budat
          )
        GROUP BY
          ORG
      ) TB4 ON TB1.COM = TB4.COM
      LEFT JOIN (
        SELECT
          A .com,
          A .target_rkap,
          A .real_sm_ekspor,
          b.REAL_TR_EKSPOR
        FROM
          (
            SELECT
              com,
              SUM (TARGET_RKAP) TARGET_RKAP,
              SUM (realto) real_sm_ekspor
            FROM
              ZREPORT_RPTREAL_RESUM
            WHERE
              com = '3000'
            AND tahun = '$tahunini'
            AND bulan = '$bulanini'
            AND propinsi = '0001'
            AND tipe != '121-200'
            GROUP BY
              com
          ) A
        LEFT JOIN (
          SELECT
            com,
            SUM (realto) real_tr_ekspor
          FROM
            ZREPORT_RPTREAL_RESUM
          WHERE
            com = '3000'
          AND tahun = '$tahunini'
          AND bulan = '$bulanini'
          AND propinsi = '0001'
          AND tipe = '121-200'
          GROUP BY
            com
        ) b ON A .com = b.com
      ) tb5 ON tb1.com = tb5.com
      LEFT JOIN (
        SELECT
          COM,
          SUM (REAL) REALISASI
        FROM
          ZREPORT_RPTREAL_RESUM_DAILY
        WHERE
          COM = '3000'
        AND tipe != '121-200'
        AND TAHUN = '$tahunlalu'
        AND BULAN = '$bulanini'
        AND TGL <= '$hariini'
        GROUP BY
          COM
      ) TB6 ON TB1.COM = TB6.COM
      LEFT JOIN (
        SELECT
          *
        FROM
          (
            SELECT
              com,
              tahun,
              realto
            FROM
              ZREPORT_RPTREAL_RESUM
            WHERE
              com = '3000'
            AND (tahun = '$tahunini' OR tahun = '$tahunlalu')
            AND bulan = '$bulanini'
            AND propinsi = '0001'
            AND tipe != '121-200'
          ) PIVOT (
            SUM (realto) AS realisasi FOR (tahun) IN (
              '$tahunini' AS tahun_ini,
              '$tahunlalu' AS tahun_lalu
            )
          )
      ) tb7 ON tb1.com = tb7.com
      UNION
        SELECT
          TB1.COM ORG,
          NVL (TB4.RKAP_SDK, 0) RKAP_SDK,
          NVL (TB1.REALISASI, 0) REAL_SDK,
          NVL (TB2.TAHUN_INI_REALISASI, 0) REAL_SDH,
          NVL (TB2.TAHUN_LALU_REALISASI, 0) REAL_TAHUNLALU,
          NVL (TB3.PROGNOSE, 0) PROGNOSE,
          NVL (tb5.target_rkap, 0) rkap_ekspor,
          NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
          NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
          NVL (tb6.REALISASI, 0) REAL_SDH_TAHUNLALU,
          NVL (tb7.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNini,
          NVL (tb7.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU
        FROM
          (
            SELECT
              COM,
              SUM (RKAP) RKAP,
              SUM (REAL) REALISASI
            FROM
              ZREPORT_RPTREAL_RESUM_DAILY TB1
            WHERE
              TB1.COM = '7000'
            AND tipe != '121-200'
            AND TB1.TAHUN = '$tahunini'
            AND TB1.BULAN = '$bulanini'
            AND TB1.TGL <= '$harilalu'
            GROUP BY
              TB1.COM
          ) TB1
        LEFT JOIN (
          SELECT
            *
          FROM
            (
              SELECT
                COM,
                REAL,
                TAHUN
              FROM
                ZREPORT_RPTREAL_RESUM_DAILY
              WHERE
                COM = '7000'
              AND tipe != '121-200'
              AND (TAHUN = '$tahunini' OR TAHUN = '$tahunlalu')
              AND BULAN = '$bulanini'
            ) PIVOT (
              SUM (REAL) AS realisasi FOR (tahun) IN (
                '$tahunini' AS tahun_ini,
                '$tahunlalu' AS tahun_lalu
              )
            )
        ) TB2 ON TB1.COM = TB2.COM
        LEFT JOIN (
          SELECT
            ORG COM,
            SUM (TARGET_REALH) PROGNOSE
          FROM
            (
              SELECT
                A .org,
                c.budat,
                SUM (
                  A .target * (c.porsi / D .total_porsi)
                ) AS target_realh
              FROM
                ZREPORT_TARGET_PLANTSCO A
              LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
              AND c.budat LIKE '$tahunini$bulanini%'
              AND c.tipe = A .tipe
              LEFT JOIN (
                SELECT
                  region,
                  tipe,
                  SUM (porsi) AS total_porsi
                FROM
                  zreport_porsi_sales_region
                WHERE
                  budat LIKE '$tahunini$bulanini%'
                AND VKORG = '7000'
                GROUP BY
                  region,
                  tipe
              ) D ON D .tipe = A .tipe
              WHERE
                DELETE_MARK = 0
              AND JENIS IS NULL
              AND ORG = '7000'
              AND BULAN = '$bulanini'
              AND TAHUN = '$tahunini'
              AND PLANT NOT IN ('0001', '1092')
              AND A .TIPE != '121-200'
              AND budat > '$tanggal'
              GROUP BY
                A .org,
                tahun,
                bulan,
                c.budat
            )
          GROUP BY
            ORG
        ) TB3 ON TB1.COM = TB3.COM
        LEFT JOIN (
          SELECT
            ORG COM,
            SUM (TARGET_REALH) RKAP_SDK
          FROM
            (
              SELECT
                A .org,
                c.budat,
                SUM (
                  A .target * (c.porsi / D .total_porsi)
                ) AS target_realh
              FROM
                ZREPORT_TARGET_PLANTSCO A
              LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
              AND c.budat LIKE '$tahunini$bulanini%'
              AND c.tipe = A .tipe
              LEFT JOIN (
                SELECT
                  region,
                  tipe,
                  SUM (porsi) AS total_porsi
                FROM
                  zreport_porsi_sales_region
                WHERE
                  budat LIKE '$tahunini$bulanini%'
                AND VKORG = '7000'
                GROUP BY
                  region,
                  tipe
              ) D ON D .tipe = A .tipe
              WHERE
                DELETE_MARK = 0
              AND JENIS IS NULL
              AND ORG = '7000'
              AND BULAN = '$bulanini'
              AND TAHUN = '$tahunini'
              AND PLANT NOT IN ('0001', '1092')
              AND A .TIPE != '121-200'
              AND budat <= '$hariini'
              GROUP BY
                A .org,
                tahun,
                bulan,
                c.budat
            )
          GROUP BY
            ORG
        ) TB4 ON TB1.COM = TB4.COM
        LEFT JOIN (
          SELECT
            A .com,
            A .target_rkap,
            A .real_sm_ekspor,
            b.REAL_TR_EKSPOR
          FROM
            (
              SELECT
                com,
                SUM (TARGET_RKAP) TARGET_RKAP,
                SUM (realto) real_sm_ekspor
              FROM
                ZREPORT_RPTREAL_RESUM
              WHERE
                com = '7000'
              AND tahun = '$tahunini'
              AND bulan = '$bulanini'
              AND propinsi = '0001'
              AND tipe != '121-200'
              GROUP BY
                com
            ) A
          LEFT JOIN (
            SELECT
              com,
              SUM (realto) real_tr_ekspor
            FROM
              ZREPORT_RPTREAL_RESUM
            WHERE
              com = '7000'
            AND tahun = '$tahunini'
            AND bulan = '$bulanini'
            AND propinsi = '0001'
            AND tipe = '121-200'
            GROUP BY
              com
          ) b ON A .com = b.com
        ) tb5 ON tb1.com = tb5.com
        LEFT JOIN (
          SELECT
            COM,
            SUM (REAL) REALISASI
          FROM
            ZREPORT_RPTREAL_RESUM_DAILY
          WHERE
            COM = '7000'
          AND tipe != '121-200'
          AND TAHUN = '$tahunlalu'
          AND BULAN = '$bulanini'
          AND TGL <= '$hariini'
          GROUP BY
            COM
        ) TB6 ON TB1.COM = TB6.COM
        LEFT JOIN (
          SELECT
            *
          FROM
            (
              SELECT
                com,
                tahun,
                realto
              FROM
                ZREPORT_RPTREAL_RESUM
              WHERE
                com = '7000'
              AND (tahun = '$tahunini' OR tahun = '$tahunlalu')
              AND bulan = '$bulanini'
              AND propinsi = '0001'
              AND tipe != '121-200'
            ) PIVOT (
              SUM (realto) AS realisasi FOR (tahun) IN (
                '$tahunini' AS tahun_ini,
                '$tahunlalu' AS tahun_lalu
              )
            )
        ) tb7 ON tb1.com = tb7.com

      ";

      $db=$this->load->database('default5',true);

      $data = $db->query($sql);

      return $data->result_array();




    }

  function sumEksporSG($date){
      $db=$this->load->database('default5',true);
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $db->query("SELECT
                                        ORG,
                                        SUM (REAL) AS REAL_EKSPOR
                                FROM
                                        (
                                                SELECT
                                                        COM AS ORG,
                                                        SUM (kwantumx) AS REAL,
                                                        TO_CHAR (tgl_cmplt, 'DD') tanggal
                                                FROM
                                                        zreport_rpt_real
                                                WHERE
                                                        TO_CHAR (tgl_cmplt, 'YYYYMM') = '$date'
                                                AND com = '7000'
                                                AND propinsi_to = '0001'
                                                GROUP BY
                                                        COM,
                                                        TO_CHAR (tgl_cmplt, 'DD')
                                                UNION
                                                        SELECT
                                                                VKORG AS ORG,
                                                                SUM (ton) AS REAL,
                                                                TO_CHAR (wadat_ist, 'DD') tanggal
                                                        FROM
                                                                ZREPORT_ONGKOSANGKUT_MOD
                                                        WHERE
                                                                VKORG = '7000'
                                                        AND LFART = 'ZLR'
                                                        AND TO_CHAR (wadat_ist, 'YYYYMM') = '$date'
                                                        AND (
                                                                (
                                                                        matnr LIKE '121-301%'
                                                                        AND matnr <> '121-301-0240'
                                                                )
                                                                OR matnr LIKE '121-302%'
                                                        )
                                                        AND vkbur = '0001'
                                                        GROUP BY
                                                                VKORG,
                                                                TO_CHAR (wadat_ist, 'DD')
                                        )
                                WHERE
                                        tanggal <= '$tglkmrn'
                                GROUP BY
                                        ORG");
        
        return $data->row_array();
    }
    
    function sumEksporSP($date){

      $db=$this->load->database('default5',true);
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $db->query("SELECT
                                        org,
                                        SUM (REAL) AS real_ekspor
                                FROM
                                        (
                                                SELECT
                                                        vkorg AS org,
                                                        SUM (ton) AS REAL,
                                                        TO_CHAR (wadat_ist, 'dd') tanggal
                                                FROM
                                                        zreport_ongkosangkut_mod
                                                WHERE
                                                        TO_CHAR (wadat_ist, 'yyyymm') = '$date'
                                                AND vkorg = '3000'
                                                AND vkbur = '0001'
                                                GROUP BY
                                                        vkorg,
                                                        TO_CHAR (wadat_ist, 'dd')
                                                UNION
                                                        SELECT
                                                                vkorg AS org,
                                                                SUM (ton) AS REAL,
                                                                TO_CHAR (wadat_ist, 'DD') tanggal
                                                        FROM
                                                                ZREPORT_ONGKOSANGKUT_MOD
                                                        WHERE
                                                                VKORG = '3000'
                                                        AND LFART = 'ZLR'
                                                        AND TO_CHAR (wadat_ist, 'YYYYMM') = '$date'
                                                        AND (
                                                                (
                                                                        matnr LIKE '121-301%'
                                                                        AND matnr <> '121-301-0240'
                                                                )
                                                                OR (matnr LIKE '121-302%')
                                                        )
                                                        AND vkbur = '0001'
                                                        GROUP BY
                                                                vkorg,
                                                                TO_CHAR (wadat_ist, 'DD')
                                        )
                                WHERE
                                        tanggal <= '$tglkmrn'
                                GROUP BY
                                        org");
        
        return $data->row_array();
    }
    
    function sumEksporST($date){
      $db=$this->load->database('default5',true);
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $db->query("SELECT
                                        ORG,
                                        SUM (REAL) AS REAL_EKSPOR
                                FROM
                                        (
                                                SELECT
                                                        com AS ORG,
                                                        '0001' AS propinsi_to,
                                                        SUM (kwantumx) AS REAL,
                                                        TO_CHAR (tgl_cmplt, 'DD') tanggal
                                                FROM
                                                        zreport_rpt_real_st
                                                WHERE
                                                        TO_CHAR (tgl_cmplt, 'YYYYMM') = '$date'
                                                AND com = '4000'
                                                AND SOLD_TO NOT IN (
                                                        '0000000835',
                                                        '0000000836',
                                                        '0000000837'
                                                ) --Pemakaian Sendiri
                                                AND ORDER_TYPE = 'ZLFE'
                                                AND (
                                                        ITEM_NO LIKE '121-301%'
                                                        OR ITEM_NO LIKE '121-302%'
                                                        OR ITEM_NO LIKE '121-200%'
                                                )
                                                GROUP BY
                                                        com,
                                                        propinsi_to,
                                                        TO_CHAR (tgl_cmplt, 'DD')
                                                UNION
                                                        SELECT
                                                                vkorg AS org,
                                                                vkbur AS propinsi_to,
                                                                SUM (ton) AS REAL,
                                                                TO_CHAR (wadat_ist, 'DD') tanggal
                                                        FROM
                                                                ZREPORT_ONGKOSANGKUT_MOD
                                                        WHERE
                                                                VKORG = '4000'
                                                        AND LFART = 'ZLR'
                                                        AND TO_CHAR (wadat_ist, 'YYYYMM') = '$date'
                                                        AND (
                                                                (
                                                                        matnr LIKE '121-301%'
                                                                        AND matnr <> '121-301-0240'
                                                                )
                                                                OR matnr LIKE '121-302%'
                                                                OR matnr LIKE '121-200%'
                                                        )
                                                        AND vkbur = '0001'
                                                        GROUP BY
                                                                vkorg,
                                                                vkbur,
                                                                TO_CHAR (wadat_ist, 'DD')
                                        )
                                WHERE
                                        tanggal <= '$tglkmrn'
                                GROUP BY
                                        ORG");
        
        return $data->row_array();
    }

    function sumSalesOpco($org, $date) {
      $db=$this->load->database('default5',true);
        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $db->query("SELECT
                                TB1.COM ORG,
                                NVL (TB_RKAP.RKAP, 0) RKAP_SDK,
                                -- NVL (TB1.RKAP, 0) RKAP_SDK,
                                NVL (TB1.REALISASI, 0) REAL_SDK,
                                NVL (TB2.TAHUN_INI_REALISASI, 0) REAL_SDH,
                                NVL (TB2.TAHUN_LALU_REALISASI, 0) REAL_TAHUNLALU,
                                NVL (TB3.PROGNOSE, 0) PROGNOSE,
                                NVL (tb4.target_rkap, 0) rkap_ekspor,
                                NVL (tb4.real_sm_ekspor, 0) real_sm_ekspor,
                                NVL (tb4.real_tr_ekspor, 0) real_tr_ekspor,
                                NVL (tb5.REALISASI, 0) REAL_SDH_TAHUNLALU,
                                NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNini,
                                NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU
                        FROM
                                (
                                        SELECT
                                                COM,
                                                SUM (RKAP) RKAP,
                                                SUM (REAL) REALISASI
                                        FROM
                                                ZREPORT_RPTREAL_RESUM_DAILY TB1
                                        WHERE
                                                TB1.COM = '$org'
                                        AND TB1.TAHUN = '$tahun'
                                        AND TB1.BULAN = '$bulan'
                                        AND TB1.TGL <= '$tglkmrn'
                                        AND tipe != '121-200'
                                        GROUP BY
                                                TB1.COM
                                ) TB1
                                 LEFT JOIN
                                        (
                                          SELECT
                                            org,
                                            SUM (target) rkap
                                          FROM
                                            (
                                              SELECT
                                                A .co ORG,
                                                c.budat,
                                                SUM (
                                                  A .quantum * (c.porsi / D .total_porsi)
                                                ) AS target
                                              FROM
                                                sap_t_rencana_sales_type A
                                              LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                              AND c.vkorg = A .co
                                              AND c.budat LIKE '$date%'
                                              AND c.tipe = A .tipe
                                              LEFT JOIN (
                                                SELECT
                                                  region,
                                                  tipe,
                                                  SUM (porsi) AS total_porsi
                                                FROM
                                                  zreport_porsi_sales_region
                                                WHERE
                                                  budat LIKE '$date%'
                                                AND VKORG = '$org'
                                                GROUP BY
                                                  region,
                                                  tipe
                                              ) D ON c.region = D .region
                                              AND D .tipe = A .tipe
                                              WHERE
                                                co = '$org'
                                              AND thn = '$tahun'
                                              AND bln = '$bulan'
                                              AND prov != '0001'
                                              AND prov != '1092'
                                              GROUP BY
                                                co,
                                                thn,
                                                bln,
                                                c.budat
                                            )
                                          WHERE
                                            budat <= '$tahun$bulan$tglkmrn'
                                          GROUP BY
                                            org
                                        )TB_RKAP ON TB1.COM = TB_RKAP.ORG
                        LEFT JOIN (
                                SELECT
                                        *
                                FROM
                                        (
                                                SELECT
                                                        COM,
                                                        REAL,
                                                        TAHUN
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM_DAILY
                                                WHERE
                                                        COM = '$org' AND tipe != '121-200'
                                                AND (TAHUN = '$tahun' OR TAHUN = '$tahunlalu')
                                                AND BULAN = '$bulan'
                                        ) PIVOT (
                                                SUM (REAL) AS realisasi FOR (tahun) IN (
                                                        '$tahun' AS tahun_ini,
                                                        '$tahunlalu' AS tahun_lalu
                                                )
                                        )
                        ) TB2 ON TB1.COM = TB2.COM
                        LEFT JOIN (
                                SELECT
                                        A .co COM,
                                        SUM (
                                                A .quantum * (c.porsi / D .total_porsi)
                                        ) AS prognose
                                FROM
                                        sap_t_rencana_sales_type A
                                LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                AND c.vkorg = A .co
                                AND c.budat LIKE '$date%'
                                AND c.tipe = A .tipe
                                LEFT JOIN (
                                        SELECT
                                                region,
                                                tipe,
                                                SUM (porsi) AS total_porsi
                                        FROM
                                                zreport_porsi_sales_region
                                        WHERE
                                                budat LIKE '$date%'
                                        AND vkorg = '$org'
                                        GROUP BY
                                                region,
                                                tipe
                                ) D ON c.region = D .region
                                AND D .tipe = A .tipe
                                WHERE
                                        co = '$org'
                                AND thn = '$tahun'
                                AND bln = '$bulan'
                                AND prov != '0001'
                                AND prov != '1092'
                                AND budat > '$tanggal'
                                GROUP BY
                                        co
                        ) TB3 ON TB1.COM = TB3.COM
                        LEFT JOIN (
                                SELECT
                                        A .com,
                                        A .target_rkap,
                                        A .real_sm_ekspor,
                                        b.REAL_TR_EKSPOR
                                FROM
                                        (
                                                SELECT
                                                        com,
                                                        SUM (TARGET_RKAP) TARGET_RKAP,
                                                        SUM (realto) real_sm_ekspor
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        com = '$org'
                                                AND tahun = '$tahun'
                                                AND bulan = '$bulan'
                                                AND propinsi = '0001'
                                                AND tipe != '121-200'
                                                GROUP BY
                                                        com
                                        ) A
                                LEFT JOIN (
                                        SELECT
                                                com,
                                                SUM (realto) real_tr_ekspor
                                        FROM
                                                ZREPORT_RPTREAL_RESUM
                                        WHERE
                                                com = '$org'
                                        AND tahun = '$tahun'
                                        AND bulan = '$bulan'
                                        AND propinsi = '0001'
                                        AND tipe = '121-200'
                                        GROUP BY
                                                com
                                ) b ON A .com = b.com
                        ) tb4 ON tb1.com = tb4.com
                        LEFT JOIN (
                                SELECT
                                        COM,
                                        SUM (REAL) REALISASI
                                FROM
                                        ZREPORT_RPTREAL_RESUM_DAILY
                                WHERE
                                        COM = '$org' AND tipe != '121-200'
                                AND TAHUN = '$tahunlalu'
                                AND BULAN = '$bulan'
                                AND TGL <= '$hari'
                                GROUP BY
                                        COM
                        ) TB5 ON TB1.COM = TB5.COM
                        LEFT JOIN (
                                SELECT
                                        *
                                FROM
                                        (
                                                SELECT
                                                        com,
                                                        tahun,
                                                        realto
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        com = '$org'
                                                AND (tahun = '$tahun' OR tahun = '$tahunlalu')
                                                AND bulan = '$bulan'
                                                AND propinsi = '0001'
                                                AND tipe != '121-200'
                                        ) PIVOT (
                                                SUM (realto) AS realisasi FOR (tahun) IN (
                                                        '$tahun' AS tahun_ini,
                                                        '$tahunlalu' AS tahun_lalu
                                                )
                                        )
                        ) tb6 ON tb1.com = tb6.com");
        //echo $db->last_query();
        return $data->row_array();
    }

    function sumSales4000($org, $date) {
      $db=$this->load->database('default5',true);
        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $db->query("SELECT
                                        TB1.COM ORG,
                                        NVL (TB1.RKAP, 0) RKAP_SDK,
                                         NVL (TB_RKAP.RKAP, 0) RKAP_SDK,
                                        NVL (TB1.REALISASI, 0) REAL_SDK,
                                        NVL (TB2.TAHUN_INI_REALISASI, 0) REAL_SDH,
                                        NVL (TB2.TAHUN_LALU_REALISASI, 0) REAL_TAHUNLALU,
                                        NVL (TB3.PROGNOSE, 0) PROGNOSE,
                                        NVL (tb4.target_rkap, 0) rkap_ekspor,
                                        NVL (tb4.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb4.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb5.REALISASI, 0) REAL_SDH_TAHUNLALU,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNini,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU
                                FROM
                                        (
                                                SELECT
                                                        COM,
                                                        SUM (RKAP) RKAP,
                                                        SUM (REALISASI) REALISASI
                                                FROM
                                                        (
                                                                SELECT
                                                                        TO_CHAR (COM) COM,
                                                                        SUM (RKAP) RKAP,
                                                                        SUM (REAL) REALISASI
                                                                FROM
                                                                        ZREPORT_RPTREAL_RESUM_DAILY TB1
                                                                WHERE
                                                                        TB1.COM = '$org' AND tipe != '121-200'
                                                                AND TB1.TAHUN = '$tahun'
                                                                AND TB1.BULAN = '$bulan'
                                                                AND TB1.TGL <= '$tglkmrn'
                                                                GROUP BY
                                                                        TB1.COM
                                                                UNION
                                                                        SELECT
                                                                                TO_CHAR ('$org') COM,
                                                                                0 RKAP,
                                                                                SUM (\"qty\") REALISASI
                                                                        FROM
                                                                                ZREPORT_REAL_ST_ADJ
                                                                        WHERE
                                                                                \"tahun\" = '$tahun'
                                                                        AND \"bulan\" = '$bulan'
                                                                        AND \"hari\" <= '$tglkmrn'
                                                                        GROUP BY
                                                                                '4000'
                                                        )
                                                GROUP BY
                                                        COM
                                        ) TB1
                                                  LEFT JOIN
                                        (
                                          SELECT
                                            org,
                                            SUM (target) rkap
                                          FROM
                                            (
                                              SELECT
                                                A .co ORG,
                                                c.budat,
                                                SUM (
                                                  A .quantum * (c.porsi / D .total_porsi)
                                                ) AS target
                                              FROM
                                                sap_t_rencana_sales_type A
                                              LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                              AND c.vkorg = A .co
                                              AND c.budat LIKE '$date%'
                                              AND c.tipe = A .tipe
                                              LEFT JOIN (
                                                SELECT
                                                  region,
                                                  tipe,
                                                  SUM (porsi) AS total_porsi
                                                FROM
                                                  zreport_porsi_sales_region
                                                WHERE
                                                  budat LIKE '$date%'
                                                AND VKORG = '$org'
                                                GROUP BY
                                                  region,
                                                  tipe
                                              ) D ON c.region = D .region
                                              AND D .tipe = A .tipe
                                              WHERE
                                                co = '$org'
                                              AND thn = '$tahun'
                                              AND bln = '$bulan'
                                              AND prov != '0001'
                                              AND prov != '1092'
                                              GROUP BY
                                                co,
                                                thn,
                                                bln,
                                                c.budat
                                            )
                                          WHERE
                                            budat <= '$tahun$bulan$tglkmrn'
                                          GROUP BY
                                            org
                                        )TB_RKAP ON TB1.COM = TB_RKAP.ORG
                       
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                tahun,
                                                                REAL REALISASI
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM_DAILY
                                                        WHERE
                                                                COM = '$org' AND tipe != '121-200'
                                                        AND (TAHUN = '$tahun' OR TAHUN = '$tahunlalu')
                                                        AND BULAN = '$bulan'
                                                        UNION
                                                                SELECT
                                                                        TO_CHAR ('4000') COM,
                                                                        \"tahun\" tahun,
                                                                        \"qty\" REALISASI
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        (
                                                                                \"tahun\" = '$tahun'
                                                                                OR \"tahun\" = '$tahunlalu'
                                                                        )
                                                                AND \"bulan\" = '$bulan'
                                                ) PIVOT (
                                                        SUM (REALISASI) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) TB2 ON TB1.COM = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                A .co COM,
                                                SUM (
                                                        A .quantum * (c.porsi / D .total_porsi)
                                                ) AS prognose
                                        FROM
                                                sap_t_rencana_sales_type A
                                        LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                        AND c.vkorg = A .co
                                        AND c.budat LIKE '$date%'
                                        AND c.tipe = A .tipe
                                        LEFT JOIN (
                                                SELECT
                                                        region,
                                                        tipe,
                                                        SUM (porsi) AS total_porsi
                                                FROM
                                                        zreport_porsi_sales_region
                                                WHERE
                                                        budat LIKE '$date%'
                                                AND vkorg = '$org'
                                                GROUP BY
                                                        region,
                                                        tipe
                                        ) D ON c.region = D .region
                                        AND D .tipe = A .tipe
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov != '0001'
                                        AND prov != '1092'
                                        AND budat > '$tanggal'
                                        GROUP BY
                                                co
                                ) TB3 ON TB1.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                A .com,
                                                A .target_rkap,
                                                A .real_sm_ekspor,
                                                b.REAL_TR_EKSPOR
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                SUM (TARGET_RKAP) TARGET_RKAP,
                                                                SUM (realto) real_sm_ekspor
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                        GROUP BY
                                                                com
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        com,
                                                        SUM (realto) real_tr_ekspor
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        com = '$org'
                                                AND tahun = '$tahun'
                                                AND bulan = '$bulan'
                                                AND propinsi = '0001'
                                                AND tipe = '121-200'
                                                GROUP BY
                                                        com
                                        ) b ON A .com = b.com
                                ) tb4 ON tb1.com = tb4.com
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REALISASI) REALISASI
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                SUM (REAL) REALISASI
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM_DAILY
                                                        WHERE
                                                                COM = '$org' AND tipe != '121-200'
                                                        AND TAHUN = '$tahunlalu'
                                                        AND BULAN = '$bulan'
                                                        AND TGL <= '$hari'
                                                        GROUP BY
                                                                COM
                                                        UNION
                                                                SELECT
                                                                        TO_CHAR ('4000') COM,
                                                                        SUM (\"qty\") REALISASI
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        \"tahun\" = '$tahunlalu'
                                                                AND \"bulan\" = '$bulan'
                                                                AND \"hari\" <= '$hari'
                                                                GROUP BY
                                                                        '4000'
                                                )
                                        GROUP BY
                                                COM
                                ) TB5 ON TB1.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                tahun,
                                                                realto
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND (tahun = '$tahun' OR tahun = '$tahunlalu')
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                ) PIVOT (
                                                        SUM (realto) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON tb1.com = tb6.com");
        //echo $this->db->last_query();
        return $data->row_array();
    }
    function sumSales4000_rev($org, $date) {
      $db=$this->load->database('default5',true);
        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $db->query("SELECT
                                        TB1.COM ORG,
                                        NVL (TB_RKAP.RKAP, 0) RKAP_SDK,
                                        NVL (TB_REAL.REALISASI, 0) REAL_SDK,
                                        -- NVL (TB1.REALISASI, 0) REAL_SDK,
                                        NVL (TB2.TAHUN_INI_REALISASI, 0) REAL_SDH,
                                        NVL (TB2.TAHUN_LALU_REALISASI, 0) REAL_TAHUNLALU,
                                        NVL (TB3.PROGNOSE, 0) PROGNOSE,
                                        NVL (tb4.target_rkap, 0) rkap_ekspor,
                                        NVL (tb4.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb4.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb5.REALISASI, 0) REAL_SDH_TAHUNLALU,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNini,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU
                                FROM
                                        (
                                                SELECT
                                                        COM,
                                                        SUM (RKAP) RKAP,
                                                        SUM (REALISASI) REALISASI
                                                FROM
                                                        (
                                                                SELECT
                                                                        TO_CHAR (COM) COM,
                                                                        SUM (RKAP) RKAP,
                                                                        SUM (REAL) REALISASI
                                                                FROM
                                                                        ZREPORT_RPTREAL_RESUM_DAILY TB1
                                                                WHERE
                                                                        TB1.COM = '$org' AND tipe != '121-200'
                                                                AND TB1.TAHUN = '$tahun'
                                                                AND TB1.BULAN = '$bulan'
                                                                AND TB1.TGL <= '$tglkmrn'
                                                                GROUP BY
                                                                        TB1.COM
                                                                UNION
                                                                        SELECT
                                                                                TO_CHAR ('$org') COM,
                                                                                0 RKAP,
                                                                                SUM (\"qty\") REALISASI
                                                                        FROM
                                                                                ZREPORT_REAL_ST_ADJ
                                                                        WHERE
                                                                                \"tahun\" = '$tahun'
                                                                        AND \"bulan\" = '$bulan'
                                                                        AND \"hari\" <= '$tglkmrn'
                                                                        GROUP BY
                                                                                '4000'
                                                        )
                                                GROUP BY
                                                        COM
                                        ) TB1
                                        LEFT JOIN
                                        (SELECT
                                            --  TB2.RKAP RKAP,
                                            TB2.COM,
                                            TB2.REALISASI - TB3.REALISASI REALISASI
                                          FROM
                                            (
                                              SELECT
                                                TO_CHAR (COM) COM,
                                                SUM (RKAP) RKAP,
                                                SUM (REAL) REALISASI
                                              FROM
                                                ZREPORT_RPTREAL_RESUM_DAILY TB1
                                              WHERE
                                                TB1.COM = '$org'
                                              AND tipe != '121-200'
                                              AND TB1.TAHUN = '$tahun'
                                              AND TB1.BULAN = '$bulan'
                                              AND TB1.TGL = '$hari'
                                              GROUP BY
                                                TB1.COM
                                            ) TB3
                                          LEFT JOIN (
                                            SELECT
                                              COM,
                                              SUM (RKAP) RKAP,
                                              SUM (REALISASI) REALISASI
                                            FROM
                                              (
                                                SELECT
                                                  TO_CHAR (COM) COM,
                                                  SUM (TARGET_RKAP) RKAP,
                                                  SUM (REALTO) REALISASI
                                                FROM
                                                  ZREPORT_RPTREAL_RESUM TB1
                                                WHERE
                                                  TB1.COM = '$org'
                                                AND tipe != '121-200'
                                                AND TB1.TAHUN = '$tahun'
                                                AND PROPINSI NOT IN ('0001', '1092')
                                                AND TB1.BULAN = '$bulan'
                                                GROUP BY
                                                  TB1.COM
                                                UNION
                                                  SELECT
                                                    TO_CHAR ('$org') COM,
                                                    0 RKAP,
                                                    SUM (\"qty\") REALISASI
                                                  FROM
                                                    ZREPORT_REAL_ST_ADJ
                                                  WHERE
                                                    \"tahun\" = '$tahun'
                                                  AND \"bulan\" = '$bulan'
                                                  GROUP BY
                                                    '$org'
                                              )
                                            GROUP BY
                                              COM
                                          ) TB2 ON TB3.COM = TB2.COM) TB_REAL ON TB1.COM = TB_REAL.COM
                                        LEFT JOIN
                                        (
                                          SELECT
                                            org,
                                            SUM (target) rkap
                                          FROM
                                            (
                                              SELECT
                                                A .co ORG,
                                                c.budat,
                                                SUM (
                                                  A .quantum * (c.porsi / D .total_porsi)
                                                ) AS target
                                              FROM
                                                sap_t_rencana_sales_type A
                                              LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                              AND c.vkorg = A .co
                                              AND c.budat LIKE '$date%'
                                              AND c.tipe = A .tipe
                                              LEFT JOIN (
                                                SELECT
                                                  region,
                                                  tipe,
                                                  SUM (porsi) AS total_porsi
                                                FROM
                                                  zreport_porsi_sales_region
                                                WHERE
                                                  budat LIKE '$date%'
                                                AND VKORG = '$org'
                                                GROUP BY
                                                  region,
                                                  tipe
                                              ) D ON c.region = D .region
                                              AND D .tipe = A .tipe
                                              WHERE
                                                co = '$org'
                                              AND thn = '$tahun'
                                              AND bln = '$bulan'
                                              AND prov != '0001'
                                              AND prov != '1092'
                                              GROUP BY
                                                co,
                                                thn,
                                                bln,
                                                c.budat
                                            )
                                          WHERE
                                            budat <= '$tahun$bulan$tglkmrn'
                                          GROUP BY
                                            org
                                        )TB_RKAP ON TB1.COM = TB_RKAP.ORG
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                tahun,
                                                                REAL REALISASI
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM_DAILY
                                                        WHERE
                                                                COM = '$org' AND tipe != '121-200'
                                                        AND (TAHUN = '$tahun' OR TAHUN = '$tahunlalu')
                                                        AND BULAN = '$bulan'
                                                        UNION
                                                                SELECT
                                                                        TO_CHAR ('4000') COM,
                                                                        \"tahun\" tahun,
                                                                        \"qty\" REALISASI
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        (
                                                                                \"tahun\" = '$tahun'
                                                                                OR \"tahun\" = '$tahunlalu'
                                                                        )
                                                                AND \"bulan\" = '$bulan'
                                                ) PIVOT (
                                                        SUM (REALISASI) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) TB2 ON TB1.COM = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                A .co COM,
                                                SUM (
                                                        A .quantum * (c.porsi / D .total_porsi)
                                                ) AS prognose
                                        FROM
                                                sap_t_rencana_sales_type A
                                        LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                                        AND c.vkorg = A .co
                                        AND c.budat LIKE '$date%'
                                        AND c.tipe = A .tipe
                                        LEFT JOIN (
                                                SELECT
                                                        region,
                                                        tipe,
                                                        SUM (porsi) AS total_porsi
                                                FROM
                                                        zreport_porsi_sales_region
                                                WHERE
                                                        budat LIKE '$date%'
                                                AND vkorg = '$org'
                                                GROUP BY
                                                        region,
                                                        tipe
                                        ) D ON c.region = D .region
                                        AND D .tipe = A .tipe
                                        WHERE
                                                co = '$org'
                                        AND thn = '$tahun'
                                        AND bln = '$bulan'
                                        AND prov != '0001'
                                        AND prov != '1092'
                                        AND budat > '$tanggal'
                                        GROUP BY
                                                co
                                ) TB3 ON TB1.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                A .com,
                                                A .target_rkap,
                                                A .real_sm_ekspor,
                                                b.REAL_TR_EKSPOR
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                SUM (TARGET_RKAP) TARGET_RKAP,
                                                                SUM (realto) real_sm_ekspor
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                        GROUP BY
                                                                com
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        com,
                                                        SUM (realto) real_tr_ekspor
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        com = '$org'
                                                AND tahun = '$tahun'
                                                AND bulan = '$bulan'
                                                AND propinsi = '0001'
                                                AND tipe = '121-200'
                                                GROUP BY
                                                        com
                                        ) b ON A .com = b.com
                                ) tb4 ON tb1.com = tb4.com
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REALISASI) REALISASI
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                SUM (REAL) REALISASI
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM_DAILY
                                                        WHERE
                                                                COM = '$org' AND tipe != '121-200'
                                                        AND TAHUN = '$tahunlalu'
                                                        AND BULAN = '$bulan'
                                                        AND TGL <= '$hari'
                                                        GROUP BY
                                                                COM
                                                        UNION
                                                                SELECT
                                                                        TO_CHAR ('4000') COM,
                                                                        SUM (\"qty\") REALISASI
                                                                FROM
                                                                        ZREPORT_REAL_ST_ADJ
                                                                WHERE
                                                                        \"tahun\" = '$tahunlalu'
                                                                AND \"bulan\" = '$bulan'
                                                                AND \"hari\" <= '$hari'
                                                                GROUP BY
                                                                        '4000'
                                                )
                                        GROUP BY
                                                COM
                                ) TB5 ON TB1.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                tahun,
                                                                realto
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND (tahun = '$tahun' OR tahun = '$tahunlalu')
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                ) PIVOT (
                                                        SUM (realto) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON tb1.com = tb6.com");
        //echo $this->db->last_query();
        return $data->row_array();
    }
    function sumSales6000($org, $date) {
        $db=$this->load->database('default5',true);
        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
            $tanggalkemarin = date('Ymd', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
            $tanggalkemarin = $tanggal;
        }
        $data = $db->query("SELECT
                                        TB1.COM ORG,
                                        -- NVL (TB1.RKAP, 0) RKAP_SDK,
                                        NVL (TB1.REALISASI, 0) REAL_SDK,
                                        NVL (TB_.RKAP_SDK, 0) RKAP_SDK,
                                        NVL (TB_.PROGNOSE, 0) PROGNOSE_,
                                        NVL (TB2.TAHUN_INI_REALISASI, 0) REAL_SDH,
                                        NVL (TB2.TAHUN_LALU_REALISASI, 0) REAL_TAHUNLALU,
                                        NVL (TB3.PROGNOSE, 0) PROGNOSE,
                                        NVL (tb5.target_rkap, 0) rkap_ekspor,
                                        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb6.REALISASI, 0) REAL_SDH_TAHUNLALU,
                                        NVL (tb7.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNini,
                                        NVL (tb7.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU
                                FROM
                                        (
                                                SELECT
                                                        COM,
                                                        SUM (RKAP) RKAP,
                                                        SUM (REAL) REALISASI
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM_DAILY TB1
                                                WHERE
                                                        TB1.COM = '$org' AND tipe != '121-200'
                                                AND TB1.TAHUN = '$tahun'
                                                AND TB1.BULAN = '$bulan'
                                                AND TB1.TGL <= '$tglkmrn'
                                                GROUP BY
                                                        TB1.COM
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                REAL,
                                                                TAHUN
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM_DAILY
                                                        WHERE
                                                                COM = '$org' AND tipe != '121-200'
                                                        AND (TAHUN = '$tahun' OR TAHUN = '$tahunlalu')
                                                        AND BULAN = '$bulan'
                                                ) PIVOT (
                                                        SUM (REAL) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) TB2 ON TB1.COM = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                ORG COM,
                                                SUM (TARGET_REALH) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                A .org,
                                                                c.budat,
                                                                SUM (
                                                                        A .target * (c.porsi / D .total_porsi)
                                                                ) AS target_realh
                                                        FROM
                                                                ZREPORT_TARGET_PLANTSCO A
                                                        LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
                                                        AND c.budat LIKE '$date%'
                                                        AND c.tipe = A .tipe
                                                        LEFT JOIN (
                                                                SELECT
                                                                        region,
                                                                        tipe,
                                                                        SUM (porsi) AS total_porsi
                                                                FROM
                                                                        zreport_porsi_sales_region
                                                                WHERE
                                                                        budat LIKE '$date%'
                                                                AND VKORG = '$org'
                                                                GROUP BY
                                                                        region,
                                                                        tipe
                                                        ) D ON D .tipe = A .tipe
                                                        WHERE
                                                                DELETE_MARK = 0
                                                        AND JENIS IS NULL
                                                        AND ORG = '$org'
                                                        AND BULAN = '$bulan'
                                                        AND TAHUN = '$tahun'
                                                        AND PLANT IN ('0001')
                                                        AND A .TIPE != '121-200'
                                                        AND budat > '$tanggal'
                                                        GROUP BY
                                                                A .org,
                                                                tahun,
                                                                bulan,
                                                                c.budat
                                                )
                                        GROUP BY
                                                ORG
                                ) TB3 ON TB1.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                ORG COM,
                                                SUM (TARGET_REALH) RKAP_SDK
                                        FROM
                                                (
                                                        SELECT
                                                                A .org,
                                                                c.budat,
                                                                SUM (
                                                                        A .target * (c.porsi / D .total_porsi)
                                                                ) AS target_realh
                                                        FROM
                                                                ZREPORT_TARGET_PLANTSCO A
                                                        LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
                                                        AND c.budat LIKE '$date%'
                                                        AND c.tipe = A .tipe
                                                        LEFT JOIN (
                                                                SELECT
                                                                        region,
                                                                        tipe,
                                                                        SUM (porsi) AS total_porsi
                                                                FROM
                                                                        zreport_porsi_sales_region
                                                                WHERE
                                                                        budat LIKE '$date%'
                                                                AND VKORG = '$org'
                                                                GROUP BY
                                                                        region,
                                                                        tipe
                                                        ) D ON D .tipe = A .tipe
                                                        WHERE
                                                                DELETE_MARK = 0
                                                        AND JENIS IS NULL
                                                        AND ORG = '$org'
                                                        AND BULAN = '$bulan'
                                                        AND TAHUN = '$tahun'
                                                        AND PLANT IN ('0001')
                                                        AND A .TIPE != '121-200'
                                                        AND budat <= '$tanggalkemarin'
                                                        GROUP BY
                                                                A .org,
                                                                tahun,
                                                                bulan,
                                                                c.budat
                                                )
                                        GROUP BY
                                                ORG
                                ) TB4 ON TB1.COM = TB4.COM
                                LEFT JOIN (
                                        SELECT
                                                A .com,
                                                A .target_rkap,
                                                A .real_sm_ekspor,
                                                b.REAL_TR_EKSPOR
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                SUM (TARGET_RKAP) TARGET_RKAP,
                                                                SUM (realto) real_sm_ekspor
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                        GROUP BY
                                                                com
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        com,
                                                        SUM (realto) real_tr_ekspor
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        com = '$org'
                                                AND tahun = '$tahun'
                                                AND bulan = '$bulan'
                                                AND propinsi = '0001'
                                                AND tipe = '121-200'
                                                GROUP BY
                                                        com
                                        ) b ON A .com = b.com
                                ) tb5 ON tb1.com = tb5.com
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REAL) REALISASI
                                        FROM
                                                ZREPORT_RPTREAL_RESUM_DAILY
                                        WHERE
                                                COM = '$org' AND tipe != '121-200'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND TGL <= '$tglkmrn'
                                        GROUP BY
                                                COM
                                ) TB6 ON TB1.COM = TB6.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                tahun,
                                                                realto
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND (tahun = '$tahun' OR tahun = '$tahunlalu')
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                ) PIVOT (
                                                        SUM (realto) AS realisasi FOR (tahun) IN (
                                                                '$tahun' AS tahun_ini,
                                                                '$tahunlalu' AS tahun_lalu
                                                        )
                                                )
                                ) tb7 ON tb1.com = tb7.com
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT < '$tanggal' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .org com,
                                                                        c.budat,
                                                                        SUM (
                                                                                A .target * (c.porsi / D .total_porsi)
                                                                        ) AS target
                                                                FROM
                                                                        ZREPORT_TARGET_PLANTSCO A
                                                                LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
                                                                AND c.budat LIKE '$date%'
                                                                AND c.tipe = A .tipe
                                                                LEFT JOIN (
                                                                        SELECT
                                                                                region,
                                                                                tipe,
                                                                                SUM (porsi) AS total_porsi
                                                                        FROM
                                                                                zreport_porsi_sales_region
                                                                        WHERE
                                                                                budat LIKE '$date%'
                                                                        AND VKORG = '$org'
                                                                        GROUP BY
                                                                                region,
                                                                                tipe
                                                                ) D ON D .tipe = A .tipe
                                                                WHERE
                                                                        DELETE_MARK = 0
                                                                AND JENIS IS NULL
                                                                AND ORG = '$org'
                                                                AND BULAN = '$bulan'
                                                                AND TAHUN = '$tahun'
                                                                AND PLANT IN ('0001')
                                                                AND A .TIPE != '121-200'
                                                                --AND budat > '$tanggal'
                                                                GROUP BY
                                                                        A .org,
                                                                        c.budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB_ ON TB1.COM = TB2.COM
                                ");
        //echo $this->db->last_query();
        return $data->row_array();
    }

    function sumSales6000New($org, $date) {
        $db=$this->load->database('default5',true);
        $tahun = substr($date, 0, 4);
        $tahunlalu = $tahun - 1;
        $bulan = substr($date, 4, 5);
        $hari = 0;
        if ($date == date("Ym")) {
            $hari = date("d");
            $tanggal = date("Ymd");
            $tglkmrn = date('d', strtotime($tanggal . "-1 days"));
        } else {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
            $tanggal = $tahun . "" . $bulan . "" . $hari;
            $tglkmrn = $hari;
        }
        $data = $db->query("SELECT
                                        TB1.COM,
                                        NVL (TB1.REALISASI, 0) REAL_TAHUNINI,
                                        NVL (TB2.RKAP_SDK, 0) RKAP_SDK,
                                        NVL (TB2.PROGNOSE, 0) PROGNOSE,
                                        NVL (TB3.REALISASI, 0) REAL_HARIINI,
                                        NVL (TB4.REALISASI_TAHUN_LALU, 0) REAL_TAHUNLALU,
                                        NVL (tb5.target_rkap, 0) rkap_ekspor,
                                        NVL (tb5.real_sm_ekspor, 0) real_sm_ekspor,
                                        NVL (tb5.real_tr_ekspor, 0) real_tr_ekspor,
                                        NVL (tb6.tahun_ini_REALISASI, 0) REAL_ekspor_TAHUNINI,
                                        NVL (tb6.tahun_lalu_REALISASI, 0) REAL_ekspor_TAHUNLALU,
                                        NVL (tb7.REALISASI, 0) REAL_SDH_TAHUNLALU
                                FROM
                                        (
                                                SELECT
                                                        COM,
                                                        SUM (REALTO) REALISASI
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        TAHUN = '$tahun'
                                                AND BULAN = '$bulan'
                                                AND TIPE != '121-200'
                                                AND PROPINSI NOT IN ('0001', '1092')
                                                AND COM = '$org'
                                                GROUP BY
                                                        COM
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                NVL (RKAP_SDK_TARGET, 0) RKAP_SDK,
                                                NVL (PROGNOSE_TARGET, 0) PROGNOSE
                                        FROM
                                                (
                                                        SELECT
                                                                COM,
                                                                CASE
                                                        WHEN BUDAT < '$tanggal' THEN
                                                                'TARGET'
                                                        ELSE
                                                                'PROGNOSE'
                                                        END AS TIPE,
                                                        TARGET
                                                FROM
                                                        (
                                                                SELECT
                                                                        A .org com,
                                                                        c.budat,
                                                                        SUM (
                                                                                A .target * (c.porsi / D .total_porsi)
                                                                        ) AS target
                                                                FROM
                                                                        ZREPORT_TARGET_PLANTSCO A
                                                                LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
                                                                AND c.budat LIKE '$date%'
                                                                AND c.tipe = A .tipe
                                                                LEFT JOIN (
                                                                        SELECT
                                                                                region,
                                                                                tipe,
                                                                                SUM (porsi) AS total_porsi
                                                                        FROM
                                                                                zreport_porsi_sales_region
                                                                        WHERE
                                                                                budat LIKE '$date%'
                                                                        AND VKORG = '$org'
                                                                        GROUP BY
                                                                                region,
                                                                                tipe
                                                                ) D ON D .tipe = A .tipe
                                                                WHERE
                                                                        DELETE_MARK = 0
                                                                AND JENIS IS NULL
                                                                AND ORG = '$org'
                                                                AND BULAN = '$bulan'
                                                                AND TAHUN = '$tahun'
                                                                AND PLANT NOT IN ('0001', '1092')
                                                                AND A .TIPE != '121-200'
                                                                --AND budat > '$tanggal'
                                                                GROUP BY
                                                                        A .org,
                                                                        c.budat
                                                        )
                                                ) PIVOT (
                                                        SUM (target) AS target FOR (TIPE) IN (
                                                                'TARGET' AS rkap_sdk,
                                                                'PROGNOSE' AS prognose
                                                        )
                                                )
                                ) TB2 ON TB1.COM = TB2.COM
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REAL) REALISASI
                                        FROM
                                                ZREPORT_RPTREAL_RESUM_DAILY
                                        WHERE
                                                TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND TIPE != '121-200'
                                        AND TGL = '$hari' --AND PROPINSI NOT IN ('0001', '1092')
                                        AND COM = '$org'
                                        GROUP BY
                                                COM
                                ) TB3 ON TB1.COM = TB3.COM
                                LEFT JOIN (
                                        SELECT
                                                COM,
                                                SUM (REALTO) REALISASI_TAHUN_LALU
                                        FROM
                                                ZREPORT_RPTREAL_RESUM
                                        WHERE
                                                COM = '$org'
                                        AND tipe != '121-200'
                                        AND TAHUN = '$tahunlalu'
                                        AND BULAN = '$bulan'
                                        AND PROPINSI NOT IN ('0001', '1092')
                                        GROUP BY
                                                COM
                                ) TB4 ON TB1.COM = TB4.COM
                                LEFT JOIN (
                                        SELECT
                                                A .com,
                                                A .target_rkap,
                                                A .real_sm_ekspor,
                                                b.REAL_TR_EKSPOR
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                SUM (TARGET_RKAP) TARGET_RKAP,
                                                                SUM (realto) real_sm_ekspor
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                        GROUP BY
                                                                com
                                                ) A
                                        LEFT JOIN (
                                                SELECT
                                                        com,
                                                        SUM (realto) real_tr_ekspor
                                                FROM
                                                        ZREPORT_RPTREAL_RESUM
                                                WHERE
                                                        com = '$org'
                                                AND tahun = '$tahun'
                                                AND bulan = '$bulan'
                                                AND propinsi = '0001'
                                                AND tipe = '121-200'
                                                GROUP BY
                                                        com
                                        ) b ON A .com = b.com
                                ) TB5 ON TB1.COM = TB5.COM
                                LEFT JOIN (
                                        SELECT
                                                *
                                        FROM
                                                (
                                                        SELECT
                                                                com,
                                                                tahun,
                                                                realto
                                                        FROM
                                                                ZREPORT_RPTREAL_RESUM
                                                        WHERE
                                                                com = '$org'
                                                        AND (tahun = '$tahun' OR tahun = '$tahunlalu')
                                                        AND bulan = '$bulan'
                                                        AND propinsi = '0001'
                                                        AND tipe != '121-200'
                                                ) PIVOT (
                                                        SUM (realto) AS realisasi FOR (tahun) IN (
                                                                '2017' AS tahun_ini,
                                                                '2016' AS tahun_lalu
                                                        )
                                                )
                                ) tb6 ON tb1.com = tb6.com
                                LEFT JOIN (
                                    SELECT
                                            COM,
                                            SUM (REAL) REALISASI
                                    FROM
                                            ZREPORT_RPTREAL_RESUM_DAILY
                                    WHERE
                                            COM = '$org'
                                    AND tipe != '121-200'
                                    AND TAHUN = '$tahunlalu'
                                    AND BULAN = '$bulan'
                                    AND TGL <= '$hari'
                                    GROUP BY
                                            COM
                                ) TB7 ON TB1.COM = TB7.COM");
        //echo $db->last_query();
        return $data->row_array();
    }
 
  
}
