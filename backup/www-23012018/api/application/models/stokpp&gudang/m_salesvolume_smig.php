<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_salesvolume_smig extends CI_Model {

  public function get_salesvolume_monthly($year, $month, $opco){

    $sql = '';
   if ($opco == '7000' || $opco == '3000'){
    $sql = "SELECT
      tb1.*, NVL (tb2. REAL, 0) AS REAL
    FROM
      (
        SELECT
          org,
          TANGGAL,
          SUM (PROG) prognose,
          SUM (TARGET) rkap
        FROM
          (
            SELECT
              *
            FROM
              (
                SELECT
                  TO_CHAR (A .co) org,
                  SUBSTR (c.budat ,- 2) TANGGAL,
                  SUM (
                    A .quantum * (c.porsi / D .total_porsi)
                  ) AS TARGET,
                  SUM (
                    A .quantum * (c.porsi / D .total_porsi)
                  ) AS PROG
                FROM
                  sap_t_rencana_sales_type A
                LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
                AND c.vkorg = A .co
                AND c.budat LIKE '{$year}{$month}%'
                AND c.tipe = A .tipe
                LEFT JOIN (
                  SELECT
                    region,
                    tipe,
                    SUM (porsi) AS total_porsi
                  FROM
                    zreport_porsi_sales_region
                  WHERE
                    budat LIKE '{$year}{$month}%'
                  AND vkorg = '{$opco}'
                  GROUP BY
                    region,
                    tipe
                ) D ON c.region = D .region
                AND D .tipe = A .tipe
                WHERE
                  co = '{$opco}'
                AND thn = '{$year}'
                AND bln = '{$month}'
                AND prov != '0001'
                AND prov != '1092'
                GROUP BY
                  co,
                  thn,
                  bln,
                  c.budat
              )
            UNION
              SELECT
                ORG,
                hari tanggal,
                0 target,
                SUM (qty) PROG
              FROM
                ZREPORT_SCM_PROG_SALES_ADJ
              WHERE
                tahun = '{$year}'
              AND bulan = '{$month}'
              AND org = '{$opco}'
              GROUP BY
                org,
                hari
          )
        GROUP BY
          org,
          tanggal
        ORDER BY
          TANGGAL
      ) tb1
    LEFT JOIN (
      SELECT
        com,
        tgl tanggal,
        SUM (REAL) REAL
      FROM
        ZREPORT_RPTREAL_RESUM_DAILY
      WHERE
        com = '{$opco}'
      AND tipe != '121-200'
      AND tahun = '{$year}'
      AND bulan = '{$month}'
      GROUP BY
        com,
        TGL
      ORDER BY
        tgl
    ) tb2 ON (tb1.ORG = tb2.com)
    AND (tb1.TANGGAL = tb2.tanggal)
where (TB1.RKAP > 0 OR TB2.REAL > 0)
ORDER BY
  TB1.tanggal";
   }elseif ($opco == '4000'){
$sql = "SELECT
  tb1.*, NVL (tb2. REAL, 0) AS REAL
FROM
  (
    SELECT
      org,
      TANGGAL,
      SUM (PROG) prognose,
      SUM (TARGET) rkap
    FROM
      (
        SELECT
          *
        FROM
          (
            SELECT
              TO_CHAR (A .co) org,
              SUBSTR (c.budat ,- 2) TANGGAL,
              SUM (
                A .quantum * (c.porsi / D .total_porsi)
              ) AS TARGET,
              SUM (
                A .quantum * (c.porsi / D .total_porsi)
              ) AS PROG
            FROM
              sap_t_rencana_sales_type A
            LEFT JOIN zreport_porsi_sales_region c ON c.region = 5
            AND c.vkorg = A .co
            AND c.budat LIKE '{$year}{$month}%'
            AND c.tipe = A .tipe
            LEFT JOIN (
              SELECT
                region,
                tipe,
                SUM (porsi) AS total_porsi
              FROM
                zreport_porsi_sales_region
              WHERE
                budat LIKE '{$year}{$month}%'
              AND vkorg = '{$opco}'
              GROUP BY
                region,
                tipe
            ) D ON c.region = D .region
            AND D .tipe = A .tipe
            WHERE
              co = '{$opco}'
            AND thn = '{$year}'
            AND bln = '{$month}'
            AND prov != '0001'
            AND prov != '1092'
            GROUP BY
              co,
              thn,
              bln,
              c.budat
          )
        UNION
          SELECT
            ORG,
            hari tanggal,
            0 target,
            SUM (qty) PROG
          FROM
            ZREPORT_SCM_PROG_SALES_ADJ
          WHERE
            tahun = '{$year}'
          AND bulan = '{$month}'
          AND org = '{$opco}'
          GROUP BY
            org,
            hari
      )
    GROUP BY
      org,
      tanggal
    ORDER BY
      TANGGAL
  ) tb1
LEFT JOIN (
  SELECT
    com,
    tanggal,
    SUM (REAL) REAL
  FROM
    (
      SELECT
        com,
        tgl tanggal,
        SUM (REAL) REAL
      FROM
        ZREPORT_RPTREAL_RESUM_DAILY
      WHERE
        com = '{$opco}'
      AND tipe != '121-200'
      AND tahun = '{$year}'
      AND bulan = '{$month}'
      GROUP BY
        com,
        TGL
      UNION
        SELECT
          TO_CHAR ('{$opco}') COM,
          \"hari\",
          SUM (\"qty\") REALISASI
        FROM
          ZREPORT_REAL_ST_ADJ
        WHERE
          \"tahun\" = '{$year}'
        AND \"bulan\" = '{$month}'
        GROUP BY
          '{$opco}',
          \"hari\"
    )
  GROUP BY
    com,
    tanggal
  ORDER BY
    tanggal
) tb2 ON (tb1.ORG = tb2.com)
AND (tb1.TANGGAL = tb2.tanggal)
WHERE
  (TB1.RKAP > 0 OR TB2. REAL > 0)
ORDER BY
  TB1.tanggal";
   }elseif ($opco == '6000'){  
   
$sql = "SELECT
  TB2.ORG,
  TB2.TANGGAL,
  NVL (TB1. REAL, 0) REAL,
  NVL (TB2.TARGET, 0) RKAP,
  NVL (TB2.TARGET, 0) PROGNOSE
FROM
  (
    SELECT
      com,
      tgl tanggal,
      SUM (REAL) REAL
    FROM
      ZREPORT_RPTREAL_RESUM_DAILY
    WHERE
      com = '{$opco}'
    AND tipe != '121-200'
    AND tahun = '{$year}'
    AND bulan = '{$month}'
    GROUP BY
      com,
      TGL
    ORDER BY
      tgl
  ) TB1
RIGHT JOIN (
  SELECT
    *
  FROM
    (
      SELECT
        TO_CHAR (A .org) org,
        SUBSTR (c.budat ,- 2) TANGGAL,
        SUM (
          A .target * (c.porsi / D .total_porsi)
        ) AS TARGET,
        SUM (
          A .target * (c.porsi / D .total_porsi)
        ) AS PROG
      FROM
        ZREPORT_TARGET_PLANTSCO A
      LEFT JOIN zreport_porsi_sales_region c ON c.vkorg = A .org
      AND c.budat LIKE '{$year}{$month}%'
      AND c.tipe = A .tipe
      LEFT JOIN (
        SELECT
          tipe,
          SUM (porsi) AS total_porsi
        FROM
          zreport_porsi_sales_region
        WHERE
          budat LIKE '{$year}{$month}%'
        AND vkorg = '{$opco}'
        GROUP BY
          tipe
      ) D ON D .tipe = A .tipe
      WHERE
        org = '{$opco}'
      AND tahun = '{$year}'
      AND bulan = '{$month}'
      AND PLANT NOT IN ('0001', '1092')
      GROUP BY
        org,
        tahun,
        bulan,
        c.budat
    )
) TB2 ON TB2.ORG = TB1.COM
AND TB1.TANGGAL = TB2.TANGGAL
ORDER BY
  tb2.tanggal ASC";

   }

    $db=$this->load->database('default5',true);
            $result = $db->query($sql);
            return $result->result_array();
  }

}

/* End of file m_salesvolume_smig.php */
/* Location: ./application/models/stokpp&gudang/m_salesvolume_smig.php */