<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_daily_ms extends CI_Model {

  public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default5', TRUE);
    }

     function datasmig($tahun, $bulan, $hari) {
//        $whereBulan = "";
//        if ($bulan != 00) {
//            $whereBulan = "BULAN = '$bulan' AND";
//        }
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        $data = $this->db->query("SELECT
	TB1.PROV,
	TB8.NM_PROV,
	NVL (TB1.TARGET, 0) TARGET,
	NVL (TB2. REAL, 0) REAL,
	NVL (TB6.RKAP_MS, 0) RKAP_MS,
        NVL (TB8.QTY, 0) QTY,
        NVL (TB9.HASIL, 0) HASIL,
	CASE TB7.DEMAND_HARIAN
WHEN 0 THEN
	0
ELSE
	NVL (
		(
			(TB2. REAL / TB7.DEMAND_HARIAN) * 100
		),
		0
	)
END AS MARKETSHARE
FROM
	(
		SELECT
			A .prov,
			SUM (A .quantum) AS target
		FROM
			sap_t_rencana_sales_type A
		WHERE
			co != '6000'
		AND thn = '$tahun'
		AND bln = '$bulan'
		AND A .prov != '0001'
		AND A .prov != '1092'
		GROUP BY
			A .prov
	) TB1
LEFT JOIN (
	SELECT
		PROPINSI_TO,
		SUM (QTY) REAL
	FROM
		ZREPORT_SCM_REAL_SALES
	WHERE
		ORG != '6000'
	AND TAHUN = '$tahun'
	AND BULAN = '$bulan'
	AND HARI <= '$hari'
	AND PROPINSI_TO NOT IN ('1092', '0001')
	GROUP BY
		PROPINSI_TO
) TB2 ON TB1.PROV = TB2.PROPINSI_TO
LEFT JOIN (
	SELECT
		PROPINSI,
		SUM(QTY) RKAP_MS
	FROM
		ZREPORT_MS_RKAPMS
	WHERE KODE_PERUSAHAAN IN ('110','102','112')
	AND THN = '$tahun'
	AND STATUS = '0'
GROUP BY PROPINSI
) TB6 ON TB1.PROV = TB6.PROPINSI
LEFT JOIN (
	SELECT
	TB1.KD_PROV,
	(
		tb1.qty * (
			SELECT
				SUM (porsi) porsi
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat LIKE '$tahun$bulan%'
			AND c.budat <= '$tahun$bulan$hari'
		) / (
			SELECT
				SUM (porsi) porsi_total
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat LIKE '$tahun$bulan%'
		)
	) DEMAND_HARIAN
FROM
	(
		SELECT
			KD_PROV,
			SUM (qty) qty
		FROM
			ZREPORT_SCM_DEMAND_PROVINSI
		WHERE
			tahun = '$tahun'
		AND bulan = '$bulan'
		GROUP BY
			KD_PROV
	) tb1
) TB7 ON TB1.PROV = TB7.KD_PROV
LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                LEFT JOIN(
SELECT
	KD_PROV,
	QTY
FROM
	ZREPORT_SCM_DEMAND_PROVINSI
WHERE
	TAHUN = '$tahun'
AND BULAN = '$bulan'
)TB8 ON TB1.PROV = TB8.KD_PROV
LEFT JOIN(
SELECT
	PROPINSI_TO,
	SUM (QTY) HASIL
FROM
	ZREPORT_SCM_REAL_SALES
WHERE
	ORG != '6000'
AND tahun = '$tahun'
AND bulan = '$bulan'
AND hari <= '$hari'
AND PROPINSI_TO NOT IN ('0001', '1092')
AND item != '121-200'
GROUP BY
	PROPINSI_TO
)TB9 ON TB1.PROV = TB9.PROPINSI_TO
ORDER BY
	TB1.PROV");
        return $data->result_array();
    }

    function datas($org, $tahun, $bulan,$hari) {
        if (date('Ym') != $tahun . '' . $bulan) {
            $hari = date('t', strtotime($tahun . "-" . $bulan));
        } else {
            $hari = str_pad(($hari - 1), 2, '0', STR_PAD_LEFT);
        }
        if($org==7000){
            $kd_per=110;
        }elseif($org==3000){
            $kd_per=102;
        }elseif($org==4000){
            $kd_per=112;
        }
        $data = $this->db->query("SELECT
                                        TB1.PROV,
                                        TB8.NM_PROV,
                                        NVL (TB1.TARGET, 0) TARGET,
                                        NVL (TB2. REAL, 0) REAL,
                                        NVL (TB3.TARGET_REALH, 0) TARGET_REALH,
                                        NVL (TB4.HARIAN_MAX, 0) HARIAN_MAX,
                                        TB5.NAMA_KABIRO,
                                        NVL (TB6.RKAP_MS, 0) RKAP_MS,
                                        NVL (TB8.QTY, 0) QTY,
                                        NVL (TB9.HASIL, 0) HASIL,
                                        CASE TB7.DEMAND_HARIAN
                                WHEN 0 THEN
                                        0
                                ELSE
                                        NVL (
                                                (
                                                        (TB2. REAL / TB7.DEMAND_HARIAN) * 100
                                                ),
                                                0
                                        )
                                END AS MARKETSHARE
                                FROM
                                        (
                                                SELECT
                                                        A .prov,
                                                        SUM (A .quantum) AS target
                                                FROM
                                                        sap_t_rencana_sales_type A
                                                WHERE
                                                        co = '$org'
                                                AND thn = '$tahun'
                                                AND bln = '$bulan'
                                                AND A .prov != '0001'
                                                AND A .prov != '1092'
                                                GROUP BY
                                                        A .prov
                                        ) TB1
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                PROPINSI_TO,
                                                SUM (QTY) REAL
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        GROUP BY
                                                ORG,
                                                PROPINSI_TO
                                ) TB2 ON TB1.PROV = TB2.PROPINSI_TO
                                LEFT JOIN (
                                        SELECT
                                                prov,
                                                SUM (target_realh) AS target_realh
                                        FROM
                                                (
                                                        SELECT
                                                                *
                                                        FROM
                                                                (
                                                                        SELECT
                                                                                A .prov,
                                                                                c.budat,
                                                                                SUM (
                                                                                        A .quantum * (c.porsi / D .total_porsi)
                                                                                ) AS target_realh
                                                                        FROM
                                                                                sap_t_rencana_sales_type A
                                                                        LEFT JOIN zreport_m_provinsi b ON A .prov = b.kd_prov
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
                                                                        GROUP BY
                                                                                co,
                                                                                thn,
                                                                                bln,
                                                                                A .prov,
                                                                                c.budat
                                                                )
                                                        WHERE
                                                                budat <= '$tahun$bulan$hari'
                                                )
                                        GROUP BY
                                                prov
                                ) TB3 ON TB1.PROV = TB3.PROV
                                LEFT JOIN (
                                        SELECT
                                                ORG,
                                                PROPINSI_TO,
                                                MAX (QTY) HARIAN_MAX
                                        FROM
                                                ZREPORT_SCM_REAL_SALES
                                        WHERE
                                                ORG = '$org'
                                        AND TAHUN = '$tahun'
                                        AND BULAN = '$bulan'
                                        AND HARI <= '$hari'
                                        AND PROPINSI_TO NOT IN ('1092', '0001')
                                        GROUP BY
                                                ORG,
                                                PROPINSI_TO
                                ) TB4 ON TB1.PROV = TB4.PROPINSI_TO
                                LEFT JOIN (
                                        SELECT
                                                tb5.id_prov PROV,
                                                tb6.nama_kabiro
                                        FROM
                                                ZREPORT_SCM_KABIRO_SALES tb5
                                        LEFT JOIN ZREPORT_SCM_M_KABIRO tb6 ON tb5.id_kabiro = tb6.id_kabiro
                                        WHERE
                                                TB5.ORG = '$org'
                                ) TB5 ON TB1.PROV = TB5.PROV
                                LEFT JOIN (
                                        SELECT
                                                PROPINSI,
                                                QTY RKAP_MS
                                        FROM
                                                ZREPORT_MS_RKAPMS
                                        WHERE
                                                KODE_PERUSAHAAN = '$kd_per'
                                        AND THN = '$tahun'
                                        AND STATUS = '0'
                                ) TB6 ON TB1.PROV = TB6.PROPINSI
                                LEFT JOIN (
                                        SELECT
                                                TB1.KD_PROV,
                                                (
                                                        tb1.qty * tb2.porsi / tb3.porsi_total
                                                ) DEMAND_HARIAN
                                        FROM
                                                (
                                                        SELECT
                                                                KD_PROV,
                                                                SUM (qty) qty
                                                        FROM
                                                                ZREPORT_SCM_DEMAND_PROVINSI
                                                        WHERE
                                                                tahun = '$tahun'
                                                        AND bulan = '$bulan'
                                                        GROUP BY
                                                                KD_PROV
                                                ) tb1
                                        LEFT JOIN (
                                                SELECT
                                                        vkorg org,
                                                        SUM (porsi) porsi
                                                FROM
                                                        zreport_porsi_sales_region c
                                                WHERE
                                                        c.region = 5
                                                AND c.vkorg = '$org'
                                                AND c.budat LIKE '$tahun$bulan%'
                                                AND c.budat <= '$tahun$bulan$hari'
                                                GROUP BY
                                                        VKORG
                                        ) tb2 ON TB2.org = '$org'
                                        LEFT JOIN (
                                                SELECT
                                                        vkorg org,
                                                        SUM (porsi) porsi_total
                                                FROM
                                                        zreport_porsi_sales_region c
                                                WHERE
                                                        c.region = 5
                                                AND c.vkorg = '$org'
                                                AND c.budat LIKE '$tahun$bulan%'
                                                GROUP BY
                                                        VKORG
                                        ) tb3 ON TB2.org = tb3.org
                                ) TB7 ON TB1.PROV = TB7.KD_PROV
                                LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                LEFT JOIN(
SELECT
	KD_PROV,
	QTY
FROM
	ZREPORT_SCM_DEMAND_PROVINSI
WHERE
	TAHUN = '$tahun'
AND BULAN = '$bulan'
)TB8 ON TB1.PROV = TB8.KD_PROV
LEFT JOIN(
SELECT
	PROPINSI_TO,
	SUM (QTY) HASIL
FROM
	ZREPORT_SCM_REAL_SALES
WHERE
	org = '$org'
AND tahun = '$tahun'
AND bulan = '$bulan'
AND hari <= '$hari'
AND PROPINSI_TO NOT IN ('0001', '1092')
AND item != '121-200'
GROUP BY
	PROPINSI_TO
)TB9 ON TB1.PROV = TB9.PROPINSI_TO
ORDER BY
	TB1.PROV");
        return $data->result_array();
    }

    function getDetail($provinsi, $tahun, $bulan) {
        $tahunkemarin = $tahun - 1;
        $bulankemarin = $bulan - 1;
        $tahunbanding = $tahun;
        if($bulankemarin==0){
            $bulankemarin = 12;
            $tahunbanding = $tahun-1;
        }
        if (strlen($bulankemarin) == 1) {
            $bulankemarin = '0' . $bulankemarin;
        }
        $data['body'] = $this->db->query("SELECT TBL1.*, TBL2.NAMA_PERUSAHAAN, NVL(BAG.QTY_BAG,0) QTY_BAG, NVL(TBULK.QTY_BULK,0) QTY_BULK, NVL(TBL4.REAL_BULAN,0) REAL_BULAN, NVL(TBL4.QTY_BULAN,0) QTY_BULAN, NVL(TBL5.REAL_TAHUN,0) REAL_TAHUN, NVL(TBL5.QTY_TAHUN,0) QTY_TAHUN, 
            NVL(TBL6.REAL_TAHUN_KUM,0) REAL_TAHUN_KUM, NVL(TBL6.QTY_TAHUN_KUM,0) QTY_TAHUN_KUM, NVL(TBL7.REAL_TAHUNINI_KUM,0) REAL_TAHUNINI_KUM, NVL(TBL7.QTY_TAHUNINI_KUM,0) QTY_TAHUNINI_KUM, TBL8.NM_PROV, NVL(TBL9.TARGET_RKAP,0) TARGET_RKAP  
                    FROM (
                          SELECT a.KODE_PERUSAHAAN, a.PROPINSI, SUM(a.QTY_REAL) QTY, ((SUM(a.QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE PROPINSI = '$provinsi' AND BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'))*100) QTY_REAL 
                          FROM ZREPORT_MS_TRANS1 a
                          WHERE a.PROPINSI = '$provinsi' AND a.BULAN = '$bulan' AND a.TAHUN = '$tahun' AND a.STATUS = '0' 
                          GROUP BY a.KODE_PERUSAHAAN, a.PROPINSI
                          ) TBL1
                    LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2
                    ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                    LEFT JOIN (
                              SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY_BAG 
                              FROM ZREPORT_MS_TRANS1
                              WHERE TIPE = '121-301' AND PROPINSI = '$provinsi' AND BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0' 
                              GROUP BY KODE_PERUSAHAAN
                              ) BAG
                    ON TBL1.KODE_PERUSAHAAN = BAG.KODE_PERUSAHAAN
                    LEFT JOIN (
                              SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY_BULK 
                              FROM ZREPORT_MS_TRANS1
                              WHERE TIPE = '121-302' AND PROPINSI = '$provinsi' AND BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0' 
                              GROUP BY KODE_PERUSAHAAN
                              ) TBULK
                    ON TBL1.KODE_PERUSAHAAN = TBULK.KODE_PERUSAHAAN
                    LEFT JOIN (
                          SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) REAL_BULAN, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE STATUS = '0' AND BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' AND PROPINSI = '$provinsi'))*100 QTY_BULAN
                          FROM ZREPORT_MS_TRANS1 
                          WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' AND PROPINSI = '$provinsi'
                          GROUP BY KODE_PERUSAHAAN
                          ) TBL4
                    ON TBL1.KODE_PERUSAHAAN = TBL4.KODE_PERUSAHAAN
                    LEFT JOIN (
                          SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) REAL_TAHUN, ((SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE STATUS = '0' AND BULAN = '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi'))*100) QTY_TAHUN
                          FROM ZREPORT_MS_TRANS1 
                          WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi'
                          GROUP BY KODE_PERUSAHAAN
                          ) TBL5
                    ON TBL1.KODE_PERUSAHAAN = TBL5.KODE_PERUSAHAAN
                    LEFT JOIN (
                          SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) REAL_TAHUN_KUM, ((SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE STATUS = '0' AND BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi'))*100) QTY_TAHUN_KUM
                          FROM ZREPORT_MS_TRANS1 
                          WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi'
                          GROUP BY KODE_PERUSAHAAN
                          ) TBL6
                    ON TBL1.KODE_PERUSAHAAN = TBL6.KODE_PERUSAHAAN
                    LEFT JOIN (
                          SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) REAL_TAHUNINI_KUM, ((SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE STATUS = '0' AND BULAN <= '$bulan' AND TAHUN = '$tahun' AND PROPINSI = '$provinsi'))*100) QTY_TAHUNINI_KUM
                          FROM ZREPORT_MS_TRANS1 
                          WHERE BULAN <= '$bulan' AND TAHUN = '$tahun' AND PROPINSI = '$provinsi'
                          GROUP BY KODE_PERUSAHAAN
                          ) TBL7
                    ON TBL1.KODE_PERUSAHAAN = TBL7.KODE_PERUSAHAAN
                    LEFT JOIN ZREPORT_M_PROVINSI TBL8
                    ON TBL1.PROPINSI = TBL8.KD_PROV
                    LEFT JOIN 
                    (
                      SELECT PROPINSI, KODE_PERUSAHAAN, SUM(QTY) TARGET_RKAP FROM ZREPORT_MS_RKAPMS
                      WHERE THN = '$tahun' AND STATUS = '0'
                      GROUP BY PROPINSI, KODE_PERUSAHAAN
                    )TBL9
                    ON TBL1.PROPINSI = TBL9.PROPINSI AND TBL1.KODE_PERUSAHAAN = TBL9.KODE_PERUSAHAAN
                    ORDER BY TBL1.QTY_REAL DESC");
        
        $data['footer'] = $this->db->query("SELECT TBL1.PROPINSI, NVL(TBL1.QTY,0) QTY, NVL(TBL1.QTY_REAL,0) QTY_REAL, NVL(TBL2.REAL_BULAN,0) REAL_BULAN, NVL(TBL2.QTY_BULAN,0) QTY_BULAN, NVL(TBL3.REAL_TAHUN,0) REAL_TAHUN, NVL(TBL3.QTY_TAHUN,0) QTY_TAHUN, NVL(TBL4.REAL_TAHUNINI_KUM,0) REAL_TAHUNINI_KUM, NVL(TBL5.REAL_TAHUN_KUM,0) REAL_TAHUN_KUM    
                    FROM (SELECT PROPINSI, SUM(QTY_REAL) QTY, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'))*100 QTY_REAL 
                    FROM ZREPORT_MS_TRANS1 
                    WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND PROPINSI = '$provinsi' AND STATUS = '0' 
                    GROUP BY PROPINSI) TBL1
                    LEFT JOIN (
                              SELECT PROPINSI, SUM(QTY_REAL) REAL_BULAN, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' AND STATUS = '0'))*100 QTY_BULAN 
                              FROM ZREPORT_MS_TRANS1 
                              WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' AND PROPINSI = '$provinsi' AND STATUS = '0'
                              GROUP BY PROPINSI
                    ) TBL2
                    ON TBL1.PROPINSI = TBL2.PROPINSI
                    LEFT JOIN (
                              SELECT PROPINSI, SUM(QTY_REAL) REAL_TAHUN, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin' AND STATUS = '0'))*100 QTY_TAHUN 
                              FROM ZREPORT_MS_TRANS1 
                              WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi' AND STATUS = '0'
                              GROUP BY PROPINSI
                    ) TBL3
                    ON TBL1.PROPINSI = TBL3.PROPINSI
                    LEFT JOIN (
                              SELECT PROPINSI, SUM(QTY_REAL) REAL_TAHUNINI_KUM, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN <= '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'))*100 QTY_TAHUN 
                              FROM ZREPORT_MS_TRANS1 
                              WHERE BULAN <= '$bulan' AND TAHUN = '$tahun' AND PROPINSI = '$provinsi' AND STATUS = '0'
                              GROUP BY PROPINSI
                    ) TBL4
                    ON TBL1.PROPINSI = TBL4.PROPINSI
                    LEFT JOIN (
                              SELECT PROPINSI, SUM(QTY_REAL) REAL_TAHUN_KUM, (SUM(QTY_REAL)/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' AND STATUS = '0'))*100 QTY_TAHUN 
                              FROM ZREPORT_MS_TRANS1 
                              WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' AND PROPINSI = '$provinsi' AND STATUS = '0'
                              GROUP BY PROPINSI
                    ) TBL5
                    ON TBL1.PROPINSI = TBL5.PROPINSI");

        return $data;
    }

    function getDetail2($provinsi, $tahun, $bulan) {
        $data = $this->db->query("SELECT a.KODE_PERUSAHAAN, b.NAMA_PERUSAHAAN, SUM(QTY_REAL) QTY_REAL, (sum(a.QTY_REAL)/TBL1.REALISASI)*100 QTY, NVL(BAG.QTY_BAG,0) BAG, NVL(TBULK.QTY_BULK,0) BULK, TBL2.NM_PROV 
                FROM ZREPORT_MS_TRANS1 a 
                LEFT JOIN ZREPORT_MS_PERUSAHAAN b
                ON a.KODE_PERUSAHAAN = b.KODE_PERUSAHAAN
                LEFT JOIN
                  (
                  SELECT PROPINSI, SUM(QTY_REAL) REALISASI FROM ZREPORT_MS_TRANS1
                  WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0' 
                  GROUP BY PROPINSI
                  )TBL1
                ON a.PROPINSI = TBL1.PROPINSI
                LEFT JOIN
                  (
                  SELECT KD_PROV, NM_PROV FROM ZREPORT_M_PROVINSI
                  )TBL2
                ON a.PROPINSI = TBL2.KD_PROV
                LEFT JOIN
                  (
                  SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY_BAG 
                  FROM ZREPORT_MS_TRANS1
                  WHERE TIPE = '121-301' AND PROPINSI = '$provinsi'
                  GROUP BY KODE_PERUSAHAAN
                  ) BAG
                ON a.KODE_PERUSAHAAN = BAG.KODE_PERUSAHAAN
                LEFT JOIN
                  (
                  SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY_BULK 
                  FROM ZREPORT_MS_TRANS1
                  WHERE TIPE = '121-302' AND PROPINSI = '$provinsi'
                  GROUP BY KODE_PERUSAHAAN
                  ) TBULK
                ON a.KODE_PERUSAHAAN = TBULK.KODE_PERUSAHAAN
                WHERE a.PROPINSI = '$provinsi'
                GROUP BY a.KODE_PERUSAHAAN, b.NAMA_PERUSAHAAN, TBL1.REALISASI, TBL2.NM_PROV, BAG.QTY_BAG, TBULK.QTY_BULK");
        return $data->result_array();
    }

    function updateDate() {
        $data = $this->db->query("SELECT NVL(TO_CHAR(MAX(CREATE_DATE),'dd-mm-YYYY'),'01-01-1997') TGL_UPDATE FROM ZREPORT_MS_TRANS1");
        return $data->result_array();
    }

    function getSummary($tahun, $bulan) {
        $tahunkemarin = $tahun - 1;
        $bulankemarin = $bulan - 1;
        $tahunbanding = $tahun;
        if($bulankemarin==0){
            $bulankemarin = 12;
            $tahunbanding = $tahun-1;
        }
        if (strlen($bulankemarin) == 1) {
            $bulankemarin = '0' . $bulankemarin;
        }
        $data['body'] = $this->db->query("SELECT TBL3.KODE_PERUSAHAAN, TBL3.NAMA_PERUSAHAAN, TBL3.PRODUK, TBL3.INISIAL, TBL3.QTY, nvl(TBL3.REAL_BLN,0) QTY_REAL, nvl(TBL4.QTY,0) REAL_BULAN, 
nvl(TBL4.REAL_BLN_K,0) QTY_BULAN, nvl(TBL5.QTY,0) REAL_TAHUN, nvl(TBL5.REAL_THN_K,0) QTY_TAHUN, nvl(TBL6.QTY,0) REAL_TAHUNINI_KUM, nvl(TBL6.REAL_THN_K,0) QTY_TAHUNINI_KUM, nvl(TBL7.QTY,0) REAL_TAHUN_KUM, NVL(TBL8.RKAP,0) RKAP 
          FROM (SELECT * FROM (SELECT TBL1.KODE_PERUSAHAAN, TBL1.QTY QTY, TBL2.NAMA_PERUSAHAAN, TBL2.PRODUK, TBL2.INISIAL,
                ((TBL1.QTY/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulan' AND TAHUN = '$tahun'))*100) REAL_BLN
                FROM (SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY 
                      FROM ZREPORT_MS_TRANS1 
                      WHERE BULAN = '$bulan' AND TAHUN = '$tahun' 
                      GROUP BY KODE_PERUSAHAAN 
                      ORDER BY QTY DESC) TBL1
                JOIN ZREPORT_MS_PERUSAHAAN TBL2
                ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                ORDER BY TBL1.QTY DESC)
                ) TBL3
                JOIN 
                (SELECT TBL1.KODE_PERUSAHAAN, TBL1.QTY,
                ((TBL1.QTY/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding'))*100) REAL_BLN_K
                FROM (SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY 
                      FROM ZREPORT_MS_TRANS1 
                      WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' 
                      GROUP BY KODE_PERUSAHAAN 
                      ORDER BY QTY DESC) TBL1
                JOIN ZREPORT_MS_PERUSAHAAN TBL2
                ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                ORDER BY TBL1.QTY DESC) TBL4
                ON TBL3.KODE_PERUSAHAAN = TBL4.KODE_PERUSAHAAN
                LEFT JOIN 
                (SELECT TBL1.KODE_PERUSAHAAN, TBL1.QTY,
                ((TBL1.QTY/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin'))*100) REAL_THN_K
                FROM (SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY 
                      FROM ZREPORT_MS_TRANS1 
                      WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin' 
                      GROUP BY KODE_PERUSAHAAN 
                      ORDER BY QTY DESC) TBL1
                LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2
                ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                ORDER BY TBL1.QTY DESC) TBL5
                ON TBL3.KODE_PERUSAHAAN = TBL5.KODE_PERUSAHAAN
                LEFT JOIN 
                (SELECT TBL1.KODE_PERUSAHAAN, TBL1.QTY,
                ((TBL1.QTY/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN <= '$bulan' AND TAHUN = '$tahun'))*100) REAL_THN_K
                FROM (SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY 
                      FROM ZREPORT_MS_TRANS1 
                      WHERE BULAN <= '$bulan' AND TAHUN = '$tahun' 
                      GROUP BY KODE_PERUSAHAAN 
                      ORDER BY QTY DESC) TBL1
                LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2
                ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                ORDER BY TBL1.QTY DESC) TBL6
                ON TBL3.KODE_PERUSAHAAN = TBL6.KODE_PERUSAHAAN
                LEFT JOIN 
                (SELECT TBL1.KODE_PERUSAHAAN, TBL1.QTY,
                ((TBL1.QTY/(SELECT SUM(QTY_REAL) FROM ZREPORT_MS_TRANS1 WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin'))*100) REAL_THN_K
                FROM (SELECT KODE_PERUSAHAAN, SUM(QTY_REAL) QTY 
                      FROM ZREPORT_MS_TRANS1 
                      WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' 	
                      GROUP BY KODE_PERUSAHAAN 
                      ORDER BY QTY DESC) TBL1
                LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2
                ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
                ORDER BY TBL1.QTY DESC) TBL7
                ON TBL3.KODE_PERUSAHAAN = TBL7.KODE_PERUSAHAAN
                LEFT JOIN 
                  (SELECT KODE_PERUSAHAAN, (SUM(QTY)/COUNT(PROPINSI)) RKAP 
                    FROM ZREPORT_MS_RKAPMS
                    WHERE THN = '$tahun' AND STATUS = '0'
                    GROUP BY KODE_PERUSAHAAN) TBL8
                ON TBL3.KODE_PERUSAHAAN = TBL8.KODE_PERUSAHAAN
                ORDER BY TBL3.QTY DESC");
        //echo $this->db->last_query();
        $data['footer'] = $this->db->query("SELECT NVL(TBL1.QTY_REAL,0) REAL_BLN, NVL((SELECT SUM(QTY_REAL) QTY_REAL FROM ZREPORT_MS_TRANS1 
                    WHERE BULAN = '$bulankemarin' AND TAHUN = '$tahunbanding' AND STATUS = '0'),0) REAL_BLN_K, NVL(TBL3.QTY_REAL,0) REAL_THN_K, 
                  NVL(( SELECT  SUM(QTY_REAL) QTY_REAL 
                    FROM ZREPORT_MS_TRANS1 
                    WHERE BULAN <= '$bulan' AND TAHUN = '$tahun' AND STATUS = '0' ),0) REAL_THNINI_KUM,
                  NVL(( SELECT  SUM(QTY_REAL) QTY_REAL 
                    FROM ZREPORT_MS_TRANS1 
                    WHERE BULAN <= '$bulan' AND TAHUN = '$tahunkemarin' AND STATUS = '0' ),0) REAL_THN_KUM  
          FROM (SELECT BULAN, TAHUN, SUM(QTY_REAL) QTY_REAL 
                FROM ZREPORT_MS_TRANS1
                WHERE BULAN = '$bulan' AND TAHUN = '$tahun' AND STATUS = '0'
                GROUP BY BULAN, TAHUN) TBL1
                LEFT JOIN
                  (
                    SELECT BULAN, SUM(QTY_REAL) QTY_REAL 
                    FROM ZREPORT_MS_TRANS1 
                    WHERE BULAN = '$bulan' AND TAHUN = '$tahunkemarin' AND STATUS = '0' 
                    GROUP BY BULAN
                  ) TBL3
                ON TBL1.BULAN = TBL3.BULAN");
        return $data;
    }
    
    public function marketVolume($awal,$akhir,$tipe = NULL){
        $filter_tipe = !empty($tipe) ? " and tipe IN ('".$tipe."')" : "";  
        $sql = "
            select * from (
            SELECT KODE_PERUSAHAAN
		,NAMA_PERUSAHAAN
		,sum(QTY_REAL)  QTY  
		,to_char(to_date(bulan||'-'||tahun,'MM-YYYY'),'MM/YY') bulan
                FROM ZREPORT_MS_TRANS1
                WHERE tahun IS NOT NULL AND bulan IS NOT null
                $filter_tipe
                AND  tahun||''||bulan BETWEEN '$awal' AND '$akhir' 
                GROUP BY KODE_PERUSAHAAN,NAMA_PERUSAHAAN
                ,to_char(to_date(bulan||'-'||tahun,'MM-YYYY'),'MM/YY')
            )y ORDER BY to_date(y.bulan,'MM-YYYY')              
            ";
        
        return $this->db->query($sql)->result_array();
    }
    
    public function dataHistory($awal,$akhir){
        $sql = "SELECT zmt.KODE_PERUSAHAAN
                        ,zmt.NAMA_PERUSAHAAN
                        ,zmt.PROPINSI
                        ,zmp.NM_PROV
                        ,zmt.tahun||''||zmt.bulan TAHUNBULAN
                        ,zmt.QTY_REAL
                        ,zmt.TIPE
                FROM ZREPORT_MS_TRANS1 zmt
                INNER JOIN ZREPORT_M_PROVINSI zmp
                        ON zmp.kd_prov = zmt.propinsi
                WHERE zmt.tahun||''||zmt.bulan BETWEEN '$awal' AND '$akhir' 	
                order by to_number(zmt.KODE_PERUSAHAAN),zmt.tahun||''||zmt.bulan

        ";
        return $this->db->query($sql)->result_array();
    }

    function getRkap($tahun){
        $this->db->where("TAHUN",$tahun);
        $data = $this->db->get("ZREPORT_MS_RKAP");
        
        return $data->result_array();
    } 
	function getdetailSemua(){
		$sql = "SELECT DISTINCT
	TB1.PROV,
	TB8.NM_PROV,
	TB6.NAMA_PERUSAHAAN,
	NVL (TB1.TARGET, 0) TARGET,
	NVL (TB2. REAL, 0) REAL,
	NVL (TB6.RKAP_MS, 0) RKAP_MS,
        NVL (TB8.QTY, 0) QTY,
        NVL (TB9.HASIL, 0) HASIL,
	CASE TB7.DEMAND_HARIAN
WHEN 0 THEN
	0
ELSE
	NVL (
		(
			(TB2. REAL / TB7.DEMAND_HARIAN) * 100
		),
		0
	)
END AS MARKETSHARE
FROM
	(
		SELECT
			A .prov,
			SUM (A .quantum) AS target
		FROM
			sap_t_rencana_sales_type A
		WHERE
			co != '6000'
		AND thn = '2017'
		AND bln = '03'
		AND A .prov != '0001'
		AND A .prov != '1092'
		GROUP BY
			A .prov
	) TB1
LEFT JOIN (
	SELECT
		PROPINSI_TO,
		SUM (QTY) REAL
	FROM
		ZREPORT_SCM_REAL_SALES
	WHERE
		ORG != '6000'
	AND TAHUN = '2017'
	AND BULAN = '03'
	AND HARI <= '05'
	AND PROPINSI_TO NOT IN ('1092', '0001')
	GROUP BY
		PROPINSI_TO
) TB2 ON TB1.PROV = TB2.PROPINSI_TO
LEFT JOIN (
	SELECT
		PROPINSI,NAMA_PERUSAHAAN,
		SUM(QTY) RKAP_MS
	FROM
		ZREPORT_MS_RKAPMS
	WHERE KODE_PERUSAHAAN IN ('110','102','112')
	AND THN = '2017'
	AND STATUS = '0'
GROUP BY PROPINSI,NAMA_PERUSAHAAN
) TB6 ON TB1.PROV = TB6.PROPINSI
LEFT JOIN (
	SELECT
	TB1.KD_PROV,
	(
		tb1.qty * (
			SELECT
				SUM (porsi) porsi
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat = '201703'
			AND c.budat <= '20170305'
		) / (
			SELECT
				SUM (porsi) porsi_total
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat = '201703'
		)
	) DEMAND_HARIAN
FROM
	(
		SELECT
			KD_PROV,
			SUM (qty) qty
		FROM
			ZREPORT_SCM_DEMAND_PROVINSI
		WHERE
			tahun = '2017'
		AND bulan = '03'
		GROUP BY
			KD_PROV
	) tb1
) TB7 ON TB1.PROV = TB7.KD_PROV
LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                LEFT JOIN(
SELECT
	KD_PROV,
	QTY
FROM
	ZREPORT_SCM_DEMAND_PROVINSI
WHERE
	TAHUN = '2017'
AND BULAN = '03'
)TB8 ON TB1.PROV = TB8.KD_PROV
LEFT JOIN(
SELECT
	PROPINSI_TO,
	SUM (QTY) HASIL
FROM
	ZREPORT_SCM_REAL_SALES
WHERE
	ORG != '6000'
AND tahun = '2017'
AND bulan = '03'
AND hari <= '05'
AND PROPINSI_TO NOT IN ('0001', '1092')
AND item != '121-200'
GROUP BY
	PROPINSI_TO
)TB9 ON TB1.PROV = TB9.PROPINSI_TO
ORDER BY
	TB1.PROV";
	return $this->db->query($sql)->result_array();
	}
function getDetailSG(){
	$sql = "SELECT
	TB1.PROV,
	TB8.NM_PROV,
	TB6.NAMA_PERUSAHAAN,
	NVL (TB1.TARGET, 0) TARGET,
	NVL (TB2. REAL, 0) REAL,
	NVL (TB6.RKAP_MS, 0) RKAP_MS,
        NVL (TB8.QTY, 0) QTY,
        NVL (TB9.HASIL, 0) HASIL,
	CASE TB7.DEMAND_HARIAN
WHEN 0 THEN
	0
ELSE
	NVL (
		(
			(TB2. REAL / TB7.DEMAND_HARIAN) * 100
		),
		0
	)
END AS MARKETSHARE
FROM
	(
		SELECT
			A .prov,
			SUM (A .quantum) AS target
		FROM
			sap_t_rencana_sales_type A
		WHERE
			co != '6000'
		AND thn = '2017'
		AND bln = '03'
		AND A .prov != '0001'
		AND A .prov != '1092'
		GROUP BY
			A .prov
	) TB1
LEFT JOIN (
	SELECT
		PROPINSI_TO,
		SUM (QTY) REAL
	FROM
		ZREPORT_SCM_REAL_SALES
	WHERE
		ORG != '6000'
	AND TAHUN = '2017'
	AND BULAN = '03'
	AND HARI <= '05'
	AND PROPINSI_TO NOT IN ('1092', '0001')
	GROUP BY
		PROPINSI_TO
) TB2 ON TB1.PROV = TB2.PROPINSI_TO
LEFT JOIN (
	SELECT
		PROPINSI,NAMA_PERUSAHAAN,
		SUM(QTY) RKAP_MS
	FROM
		ZREPORT_MS_RKAPMS
	WHERE KODE_PERUSAHAAN = '110'
	AND THN = '2017'
	AND STATUS = '0'
GROUP BY PROPINSI,NAMA_PERUSAHAAN
) TB6 ON TB1.PROV = TB6.PROPINSI
LEFT JOIN (
	SELECT
	TB1.KD_PROV,
	(
		tb1.qty * (
			SELECT
				SUM (porsi) porsi
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat = '201702'
			AND c.budat <= '20170209'
		) / (
			SELECT
				SUM (porsi) porsi_total
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat = '201702'
		)
	) DEMAND_HARIAN
FROM
	(
		SELECT
			KD_PROV,
			SUM (qty) qty
		FROM
			ZREPORT_SCM_DEMAND_PROVINSI
		WHERE
			tahun = '2017'
		AND bulan = '02'
		GROUP BY
			KD_PROV
	) tb1
) TB7 ON TB1.PROV = TB7.KD_PROV
LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                LEFT JOIN(
SELECT
	KD_PROV,
	QTY
FROM
	ZREPORT_SCM_DEMAND_PROVINSI
WHERE
	TAHUN = '2017'
AND BULAN = '02'
)TB8 ON TB1.PROV = TB8.KD_PROV
LEFT JOIN(
SELECT
	PROPINSI_TO,
	SUM (QTY) HASIL
FROM
	ZREPORT_SCM_REAL_SALES
WHERE
	ORG != '6000'
AND tahun = '2017'
AND bulan = '02'
AND hari <= '09'
AND PROPINSI_TO NOT IN ('0001', '1092')
AND item != '121-200'
GROUP BY
	PROPINSI_TO
)TB9 ON TB1.PROV = TB9.PROPINSI_TO
ORDER BY
	TB1.PROV";
	return $this->db->query($sql)->result_array();
}
function getDetailSP(){
	$sql = "SELECT
	TB1.PROV,
	TB8.NM_PROV,
	TB6.NAMA_PERUSAHAAN,
	NVL (TB1.TARGET, 0) TARGET,
	NVL (TB2. REAL, 0) REAL,
	NVL (TB6.RKAP_MS, 0) RKAP_MS,
        NVL (TB8.QTY, 0) QTY,
        NVL (TB9.HASIL, 0) HASIL,
	CASE TB7.DEMAND_HARIAN
WHEN 0 THEN
	0
ELSE
	NVL (
		(
			(TB2. REAL / TB7.DEMAND_HARIAN) * 100
		),
		0
	)
END AS MARKETSHARE
FROM
	(
		SELECT
			A .prov,
			SUM (A .quantum) AS target
		FROM
			sap_t_rencana_sales_type A
		WHERE
			co != '6000'
		AND thn = '2017'
		AND bln = '02'
		AND A .prov != '0001'
		AND A .prov != '1092'
		GROUP BY
			A .prov
	) TB1
LEFT JOIN (
	SELECT
		PROPINSI_TO,
		SUM (QTY) REAL
	FROM
		ZREPORT_SCM_REAL_SALES
	WHERE
		ORG != '6000'
	AND TAHUN = '2017'
	AND BULAN = '02'
	AND HARI <= '09'
	AND PROPINSI_TO NOT IN ('1092', '0001')
	GROUP BY
		PROPINSI_TO
) TB2 ON TB1.PROV = TB2.PROPINSI_TO
LEFT JOIN (
	SELECT
		PROPINSI,NAMA_PERUSAHAAN,
		SUM(QTY) RKAP_MS
	FROM
		ZREPORT_MS_RKAPMS
	WHERE KODE_PERUSAHAAN = '102'
	AND THN = '2017'
	AND STATUS = '0'
GROUP BY PROPINSI,NAMA_PERUSAHAAN
) TB6 ON TB1.PROV = TB6.PROPINSI
LEFT JOIN (
	SELECT
	TB1.KD_PROV,
	(
		tb1.qty * (
			SELECT
				SUM (porsi) porsi
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat = '201702'
			AND c.budat <= '20170209'
		) / (
			SELECT
				SUM (porsi) porsi_total
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat = '201702'
		)
	) DEMAND_HARIAN
FROM
	(
		SELECT
			KD_PROV,
			SUM (qty) qty
		FROM
			ZREPORT_SCM_DEMAND_PROVINSI
		WHERE
			tahun = '2017'
		AND bulan = '02'
		GROUP BY
			KD_PROV
	) tb1
) TB7 ON TB1.PROV = TB7.KD_PROV
LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                LEFT JOIN(
SELECT
	KD_PROV,
	QTY
FROM
	ZREPORT_SCM_DEMAND_PROVINSI
WHERE
	TAHUN = '2017'
AND BULAN = '02'
)TB8 ON TB1.PROV = TB8.KD_PROV
LEFT JOIN(
SELECT
	PROPINSI_TO,
	SUM (QTY) HASIL
FROM
	ZREPORT_SCM_REAL_SALES
WHERE
	ORG != '6000'
AND tahun = '2017'
AND bulan = '02'
AND hari <= '09'
AND PROPINSI_TO NOT IN ('0001', '1092')
AND item != '121-200'
GROUP BY
	PROPINSI_TO
)TB9 ON TB1.PROV = TB9.PROPINSI_TO
ORDER BY
	TB1.PROV";
	return $this->db->query($sql)->result_array();
}
function getDetailST(){
	$sql = "SELECT
	TB1.PROV,
	TB8.NM_PROV,
	TB6.NAMA_PERUSAHAAN,
	NVL (TB1.TARGET, 0) TARGET,
	NVL (TB2. REAL, 0) REAL,
	NVL (TB6.RKAP_MS, 0) RKAP_MS,
        NVL (TB8.QTY, 0) QTY,
        NVL (TB9.HASIL, 0) HASIL,
	CASE TB7.DEMAND_HARIAN
WHEN 0 THEN
	0
ELSE
	NVL (
		(
			(TB2. REAL / TB7.DEMAND_HARIAN) * 100
		),
		0
	)
END AS MARKETSHARE
FROM
	(
		SELECT
			A .prov,
			SUM (A .quantum) AS target
		FROM
			sap_t_rencana_sales_type A
		WHERE
			co != '6000'
		AND thn = '2017'
		AND bln = '02'
		AND A .prov != '0001'
		AND A .prov != '1092'
		GROUP BY
			A .prov
	) TB1
LEFT JOIN (
	SELECT
		PROPINSI_TO,
		SUM (QTY) REAL
	FROM
		ZREPORT_SCM_REAL_SALES
	WHERE
		ORG != '6000'
	AND TAHUN = '2017'
	AND BULAN = '02'
	AND HARI <= '09'
	AND PROPINSI_TO NOT IN ('1092', '0001')
	GROUP BY
		PROPINSI_TO
) TB2 ON TB1.PROV = TB2.PROPINSI_TO
LEFT JOIN (
	SELECT
		PROPINSI,NAMA_PERUSAHAAN,
		SUM(QTY) RKAP_MS
	FROM
		ZREPORT_MS_RKAPMS
	WHERE KODE_PERUSAHAAN = '112'
	AND THN = '2017'
	AND STATUS = '0'
GROUP BY PROPINSI,NAMA_PERUSAHAAN
) TB6 ON TB1.PROV = TB6.PROPINSI
LEFT JOIN (
	SELECT
	TB1.KD_PROV,
	(
		tb1.qty * (
			SELECT
				SUM (porsi) porsi
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat = '201702'
			AND c.budat <= '20170209'
		) / (
			SELECT
				SUM (porsi) porsi_total
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat = '201702'
		)
	) DEMAND_HARIAN
FROM
	(
		SELECT
			KD_PROV,
			SUM (qty) qty
		FROM
			ZREPORT_SCM_DEMAND_PROVINSI
		WHERE
			tahun = '2017'
		AND bulan = '02'
		GROUP BY
			KD_PROV
	) tb1
) TB7 ON TB1.PROV = TB7.KD_PROV
LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                LEFT JOIN(
SELECT
	KD_PROV,
	QTY
FROM
	ZREPORT_SCM_DEMAND_PROVINSI
WHERE
	TAHUN = '2017'
AND BULAN = '02'
)TB8 ON TB1.PROV = TB8.KD_PROV
LEFT JOIN(
SELECT
	PROPINSI_TO,
	SUM (QTY) HASIL
FROM
	ZREPORT_SCM_REAL_SALES
WHERE
	ORG != '6000'
AND tahun = '2017'
AND bulan = '02'
AND hari <= '09'
AND PROPINSI_TO NOT IN ('0001', '1092')
AND item != '121-200'
GROUP BY
	PROPINSI_TO
)TB9 ON TB1.PROV = TB9.PROPINSI_TO
ORDER BY
	TB1.PROV";
	return $this->db->query($sql)->result_array();
}
function getDetailTlcc(){
	$sql = "SELECT
	TB1.PROV,
	TB8.NM_PROV,
	TB6.NAMA_PERUSAHAAN,
	NVL (TB1.TARGET, 0) TARGET,
	NVL (TB2. REAL, 0) REAL,
	NVL (TB6.RKAP_MS, 0) RKAP_MS,
        NVL (TB8.QTY, 0) QTY,
        NVL (TB9.HASIL, 0) HASIL,
	CASE TB7.DEMAND_HARIAN
WHEN 0 THEN
	0
ELSE
	NVL (
		(
			(TB2. REAL / TB7.DEMAND_HARIAN) * 100
		),
		0
	)
END AS MARKETSHARE
FROM
	(
		SELECT
			A .prov,
			SUM (A .quantum) AS target
		FROM
			sap_t_rencana_sales_type A
		WHERE
			co != '6000'
		AND thn = '2017'
		AND bln = '02'
		AND A .prov != '0001'
		AND A .prov != '1092'
		GROUP BY
			A .prov
	) TB1
LEFT JOIN (
	SELECT
		PROPINSI_TO,
		SUM (QTY) REAL
	FROM
		ZREPORT_SCM_REAL_SALES
	WHERE
		ORG != '6000'
	AND TAHUN = '2017'
	AND BULAN = '02'
	AND HARI <= '09'
	AND PROPINSI_TO NOT IN ('1092', '0001')
	GROUP BY
		PROPINSI_TO
) TB2 ON TB1.PROV = TB2.PROPINSI_TO
LEFT JOIN (
	SELECT
		PROPINSI,NAMA_PERUSAHAAN,
		SUM(QTY) RKAP_MS
	FROM
		ZREPORT_MS_RKAPMS
	WHERE KODE_PERUSAHAAN IN ('110','102','112')
	AND THN = '2017'
	AND STATUS = '0'
GROUP BY PROPINSI,NAMA_PERUSAHAAN
) TB6 ON TB1.PROV = TB6.PROPINSI
LEFT JOIN (
	SELECT
	TB1.KD_PROV,
	(
		tb1.qty * (
			SELECT
				SUM (porsi) porsi
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat = '201702'
			AND c.budat <= '20170209'
		) / (
			SELECT
				SUM (porsi) porsi_total
			FROM
				zreport_porsi_sales_region c
			WHERE
				c.region = 5
			AND c.vkorg != '6000'
			AND c.budat = '$201702'
		)
	) DEMAND_HARIAN
FROM
	(
		SELECT
			KD_PROV,
			SUM (qty) qty
		FROM
			ZREPORT_SCM_DEMAND_PROVINSI
		WHERE
			tahun = '2017'
		AND bulan = '02'
		GROUP BY
			KD_PROV
	) tb1
) TB7 ON TB1.PROV = TB7.KD_PROV
LEFT JOIN ZREPORT_M_PROVINSI TB8 ON TB1.prov = TB8.KD_PROV
                                LEFT JOIN(
SELECT
	KD_PROV,
	QTY
FROM
	ZREPORT_SCM_DEMAND_PROVINSI
WHERE
	TAHUN = '2017'
AND BULAN = '02'
)TB8 ON TB1.PROV = TB8.KD_PROV
LEFT JOIN(
SELECT
	PROPINSI_TO,
	SUM (QTY) HASIL
FROM
	ZREPORT_SCM_REAL_SALES
WHERE
	ORG != '6000'
AND tahun = '2017'
AND bulan = '02'
AND hari <= '09'
AND PROPINSI_TO NOT IN ('0001', '1092')
AND item != '121-200'
GROUP BY
	PROPINSI_TO
)TB9 ON TB1.PROV = TB9.PROPINSI_TO
ORDER BY
	TB1.PROV";
	return $this->db->query($sql)->result_array();
}
	}

