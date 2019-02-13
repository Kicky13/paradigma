<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class msales_new extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default5', TRUE);
    }

    public function nampil_text()
    {
        echo "nyoba";
    }

    public function getSMIGThisDay()
    {
        $data = array();
        $tempDay = $this->get_detail_thisday();
        foreach ($tempDay as $value) {
            $data['perDay'][$value['NAMA_MATERIAL']] = $value;
        }
        $clinker = $this->checking_clinker_thisday();
        $checkClinker = $this->checkClinker($clinker);
        if ($checkClinker == 0) {
            $data['perDay']['CLINKER']['PRICE'] = 0;
            $data['perDay']['CLINKER']['REVENUE'] = 0;
            $data['perDay']['CLINKER']['VOLUME'] = 0;
        }
        $tempOpco = $this->get_detail_thisday_peropco();
        foreach ($tempOpco as $opco) {
            $data['perOpco'][$this->getCompanyName($opco['COMPANY'])] = $opco;
        }

        return $data;
    }

    public function checkClinker($data)
    {
        if ($data == '' || empty($data) || $data == null) {
            $clink_stat = 0;
        } else {
            $clink_stat = 1;
        }
        return $clink_stat;
    }

    public function getSMIGUpToday()
    {
        $data = array();
        $tempDay = $this->get_detail_upthisday();
        foreach ($tempDay as $value) {
            $data['upToday'][$value['NAMA_MATERIAL']] = $value;
        }
        $clinker = $this->checking_clinker_upthisday();
        $checkClinker = $this->checkClinker($clinker);
        if ($checkClinker == 0) {
            $data['upToday']['CLINKER']['PRICE'] = 0;
            $data['upToday']['CLINKER']['REVENUE'] = 0;
            $data['upToday']['CLINKER']['VOLUME'] = 0;
        }
        $tempOpco = $this->get_detail_upthisday_peropco();
        foreach ($tempOpco as $opco) {
            $data['perOpco'][$this->getCompanyName($opco['COMPANY'])] = $opco;
        }

        return $data;
    }

    public function getSMIGUpToMonth()
    {
        $data = array();
        $tempDay = $this->get_detail_upthismonth();
        foreach ($tempDay as $value) {
            $data['perMonth'][$value['NAMA_MATERIAL']] = $value;
        }
        $clinker = $this->checking_clinker_upthismonth();
        $checkClinker = $this->checkClinker($clinker);
        if ($checkClinker == 0) {
            $data['perMonth']['CLINKER']['PRICE'] = 0;
            $data['perMonth']['CLINKER']['REVENUE'] = 0;
            $data['perMonth']['CLINKER']['VOLUME'] = 0;
        }
        $tempOpco = $this->get_detail_upthismonth_peropco();
        foreach ($tempOpco as $opco) {
            $data['perOpco'][$this->getCompanyName($opco['COMPANY'])] = $opco;
        }

        return $data;
    }

    public function getCompanyName($company)
    {
        switch ($company) {
            case '2000':
                $opco = 'SI';
                break;
            case '3000':
                $opco = 'SP';
                break;
            case '4000':
                $opco = 'ST';
                break;
            case '5000':
                $opco = 'SG';
                break;
            case '6000':
                $opco = 'TL';
                break;
            default:
                $opco = 'SI';
                break;
        }
        return $opco;
    }

    public function checking_clinker_thisday()
    {
        $sql = "SELECT MATERIAL AS KODE_MATERIAL FROM MV_REVENUE
                WHERE TO_CHAR(budat, 'yyyymmdd') = TO_CHAR(CURRENT_DATE, 'yyyymmdd') AND MATERIAL IN '121-200'";

        $result = $this->db->query($sql);

        return $result->row();
    }

    public function get_detail_thisday()
    {
        $sql = "SELECT TO_CHAR (BUDAT, 'yyyymmdd') AS TANGGAL,
                    MATERIAL AS KODE_MATERIAL,
                    NAMA_MATERIAL,
                    SUM(TOTAL_QTY) AS VOLUME,
                    CASE SUM( TOTAL_QTY ) WHEN 0 THEN 0 ELSE (SUM( PENJUALAN ) / SUM( TOTAL_QTY ))
                    END AS PRICE,
                    SUM(REVENUE) AS REVENUE
                FROM MV_REVENUE
                WHERE TO_CHAR (budat, 'yyyymmdd') = TO_CHAR (CURRENT_DATE, 'yyyymmdd')
                GROUP BY MATERIAL,NAMA_MATERIAL,BUDAT
                ORDER BY BUDAT DESC";

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_detail_thisday_peropco()
    {
        $sql = "SELECT VKORG AS COMPANY,
                        TO_CHAR (BUDAT, 'yyyymmdd') AS TANGGAL,
                        SUM(TOTAL_QTY) AS VOLUME,
                        CASE SUM( TOTAL_QTY ) WHEN 0 THEN 0 ELSE (SUM( PENJUALAN ) / SUM( TOTAL_QTY ))
                        END AS PRICE,
                        SUM(REVENUE) AS REVENUE
                FROM MV_REVENUE
                WHERE TO_CHAR (budat, 'yyyymmdd') = TO_CHAR (CURRENT_DATE, 'yyyymmdd')
                GROUP BY VKORG,BUDAT
                ORDER BY BUDAT DESC";

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_rkaprev_thisday_peropco($date)
    {
        $sql = "SELECT REVREAL.VKORG, NVL(REVRKAP.RKAP_REVENU,0) AS RKAP_REVENUE
                FROM(
                    SELECT VKORG,
                        TO_CHAR (budat, 'yyyymmdd') AS DATEDAY,
                        SUM(REVENUE) AS REV_REAL 
                    FROM MV_REVENUE 
                    WHERE TO_CHAR (budat, 'yyyymm') = TO_CHAR (CURRENT_DATE, 'yyyymm') GROUP BY VKORG,BUDAT
                ) REVREAL
                LEFT JOIN(
                  SELECT
                        tbkkl.co,
                    tbmlll.budat,
                    SUM (
                                tbkkl.revenue * (
                           tbmlll.porsi / tbmlll.porsitot
                                )
                    ) AS rkap_revenu
                    FROM(SELECT CO, THN, BLN, SUM (rkap_rev) AS Revenue
                             FROM(SELECT tbm.CO, tbm.THN, BLN, CASE
                                                    WHEN SUM (tbm.quantum) = 0 THEN
                                                        0
                                                    ELSE
                                                        SUM (tbm.revenue)
                                                    END rkap_rev
                                                    FROM SAP_T_RENCANA_SALES_TYPE tbm
                                                    WHERE thn = TO_CHAR (CURRENT_DATE, 'yyyy') AND bln = TO_CHAR (CURRENT_DATE, 'mm') AND prov <> '1092' 
                                                    AND prov <> '0001'
                                                    GROUP BY CO, THN, BLN
                                                )
                                            GROUP BY CO, THN, BLN
                                        ) tbkkl
                                    LEFT JOIN (
                                        SELECT tbmpo.*, tbmposum.porsitot
                                        FROM( SELECT vkorg, budat, SUM (porsi) AS porsi
                                              FROM zreport_porsi_sales_region
                                              WHERE region = 5 AND budat LIKE '$date%'
                                              GROUP BY vkorg, budat
                                            ) tbmpo
                                        LEFT JOIN (
                                            SELECT vkorg, SUM (porsi) AS porsitot
                                            FROM zreport_porsi_sales_region
                                            WHERE region = 5
                                            AND budat LIKE '$date%'
                                            GROUP BY vkorg
                                        ) tbmposum ON (tbmpo.vkorg = tbmposum.vkorg)
                                        ORDER BY tbmpo.vkorg, tbmpo.budat
                                    ) tbmlll ON (tbkkl.co = tbmlll.vkorg)
                                    GROUP BY tbkkl.co, tbmlll.budat
                                    ORDER BY tbkkl.co, tbmlll.budat ASC
                                ) REVRKAP ON REVREAL.VKORG = REVRKAP.CO
                               AND REVREAL.DATEDAY = REVRKAP.BUDAT
                    WHERE VKORG in ('7000','6000','3000','4000') AND REVREAL.DATEDAY = TO_CHAR(CURRENT_DATE,'YYYYMMDD')";

        $result = $this->db->query($sql);

        return $result->result();
    }

    public function checking_clinker_upthisday()
    {
        $sql = "SELECT MATERIAL AS KODE_MATERIAL FROM MV_REVENUE
                WHERE TO_CHAR(budat, 'yyyymm') = TO_CHAR(CURRENT_DATE, 'yyyymm') AND MATERIAL IN '121-200'";

        $result = $this->db->query($sql);

        return $result->row();
    }

    public function get_detail_upthisday()
    {
        // $sql = "SELECT MATERIAL AS KODE_MATERIAL,
        //             NAMA_MATERIAL,
        //             SUM(TOTAL_QTY) AS VOLUME,
        //             SUM(PENJUALAN)/SUM(TOTAL_QTY) AS PRICE,
        //             SUM(REVENUE) AS REVENUE
        //         FROM MV_REVENUE
        //         WHERE TO_CHAR (budat, 'yyyymm') = TO_CHAR (CURRENT_DATE, 'yyyymm')
        //         GROUP BY MATERIAL,NAMA_MATERIAL";

        $sql = "SELECT SALES_UPDAILY.*,
                       TARREV_UPDAILY.TARGET_REV,
                       TARREV_UPDAILY.TARGET_VOL
                FROM
                (SELECT MATERIAL AS KODE_MATERIAL,
                NAMA_MATERIAL,
                SUM(TOTAL_QTY) AS VOLUME,
                CASE SUM( TOTAL_QTY ) WHEN 0 THEN 0 ELSE (SUM( PENJUALAN ) / SUM( TOTAL_QTY ))
                END AS PRICE,
                SUM(REVENUE) AS REVENUE
                FROM MV_REVENUE
                WHERE TO_CHAR (budat, 'yyyymm') = TO_CHAR (CURRENT_DATE, 'yyyymm')
                GROUP BY MATERIAL,NAMA_MATERIAL)SALES_UPDAILY
                LEFT JOIN
                (SELECT  TIPE, SUM(REVENU_RKAP) AS TARGET_REV, SUM(TARGET_RKAP) AS TARGET_VOL
                FROM ZREPORT_RPTREAL_RESUM
                WHERE TAHUN = TO_CHAR (CURRENT_DATE, 'yyyy') AND BULAN = TO_CHAR (CURRENT_DATE, 'mm')
                GROUP BY TIPE)TARREV_UPDAILY
                ON SALES_UPDAILY.KODE_MATERIAL = TARREV_UPDAILY.TIPE";

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_detail_upthisday_peropco()
    {
        // $sql = "SELECT VKORG AS COMPANY,
        //                 SUM(TOTAL_QTY) AS VOLUME,
        //                 SUM(PENJUALAN)/SUM(TOTAL_QTY) AS PRICE,
        //                 SUM(REVENUE) AS REVENUE
        //         FROM MV_REVENUE
        //         WHERE TO_CHAR (budat, 'yyyymm') = TO_CHAR (CURRENT_DATE, 'yyyymm')
        //         GROUP BY VKORG";

        $sql = "SELECT SALES_UPDAILY.*,
                       TARREV_UPDAILY.TARGET_REV
                FROM
                (SELECT VKORG AS COMPANY,
                SUM(TOTAL_QTY) AS VOLUME,
                CASE SUM( TOTAL_QTY ) WHEN 0 THEN 0 ELSE (SUM( PENJUALAN ) / SUM( TOTAL_QTY ))
                END AS PRICE,
                SUM(REVENUE) AS REVENUE
                FROM MV_REVENUE
                WHERE TO_CHAR (budat, 'yyyymm') = TO_CHAR (CURRENT_DATE, 'yyyymm')
                GROUP BY VKORG)SALES_UPDAILY
                LEFT JOIN
                (SELECT  COM, SUM(REVENU_RKAP) AS TARGET_REV
                FROM ZREPORT_RPTREAL_RESUM
                WHERE TAHUN = TO_CHAR (CURRENT_DATE, 'yyyy') AND BULAN = TO_CHAR (CURRENT_DATE, 'mm')
                GROUP BY COM)TARREV_UPDAILY
                ON SALES_UPDAILY.COMPANY = TARREV_UPDAILY.COM";

        $result = $this->db->query($sql);

        return $result->result_array();
    }


    public function checking_clinker_upthismonth()
    {
        $sql = "SELECT MATERIAL AS KODE_MATERIAL FROM MV_REVENUE
                WHERE TO_CHAR(budat, 'yyyy') = TO_CHAR(CURRENT_DATE, 'yyyy') AND MATERIAL IN '121-200'";

        $result = $this->db->query($sql);

        return $result->row();
    }

    public function get_detail_upthismonth()
    {
        // $sql = "SELECT MATERIAL AS KODE_MATERIAL,
        //             NAMA_MATERIAL,
        //             SUM(TOTAL_QTY) AS VOLUME,
        //             SUM(PENJUALAN)/SUM(TOTAL_QTY) AS PRICE,
        //             SUM(REVENUE) AS REVENUE
        //         FROM MV_REVENUE
        //         WHERE TO_CHAR (budat, 'yyyy') = TO_CHAR (CURRENT_DATE, 'yyyy')
        //         GROUP BY MATERIAL,NAMA_MATERIAL";

        $sql = "SELECT
                    SALES_UPDAILY.*,
                    TARREV_UPDAILY.TARGET_REV 
                FROM
                    (
                    SELECT
                        MATERIAL AS KODE_MATERIAL,
                        NAMA_MATERIAL,
                        SUM( TOTAL_QTY ) AS VOLUME,
                        CASE SUM( TOTAL_QTY ) WHEN 0 THEN 0 ELSE (SUM( PENJUALAN ) / SUM( TOTAL_QTY ))
                        END AS PRICE,
                        SUM( REVENUE ) AS REVENUE 
                    FROM
                        MV_REVENUE 
                    WHERE
                        TO_CHAR( budat, 'yyyymm' ) = TO_CHAR( CURRENT_DATE, 'yyyymm' ) 
                    GROUP BY
                        MATERIAL,
                        NAMA_MATERIAL 
                        ) SALES_UPDAILY LEFT JOIN (
                    SELECT
                        TIPE,
                        SUM( REVENU_RKAP ) AS TARGET_REV 
                    FROM
                        ZREPORT_RPTREAL_RESUM 
                    WHERE
                        TAHUN = TO_CHAR( CURRENT_DATE, 'yyyy' ) 
                    GROUP BY
                    TIPE 
                    ) TARREV_UPDAILY ON SALES_UPDAILY.KODE_MATERIAL = TARREV_UPDAILY.TIPE";

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_detail_upthismonth_peropco()
    {
        // $sql = "SELECT VKORG AS COMPANY,
        //                 SUM(TOTAL_QTY) AS VOLUME,
        //                 SUM(PENJUALAN)/SUM(TOTAL_QTY) AS PRICE,
        //                 SUM(REVENUE) AS REVENUE
        //         FROM MV_REVENUE
        //         WHERE TO_CHAR (budat, 'yyyy') = TO_CHAR (CURRENT_DATE, 'yyyy')
        //         GROUP BY VKORG";

        $sql = "SELECT SALES_UPDAILY.*,
                       TARREV_UPDAILY.TARGET_REV
                FROM
                (SELECT VKORG AS COMPANY,
                SUM(TOTAL_QTY) AS VOLUME,
                CASE SUM( TOTAL_QTY ) WHEN 0 THEN 0 ELSE (SUM( PENJUALAN ) / SUM( TOTAL_QTY ))
                END AS PRICE,
                SUM(REVENUE) AS REVENUE
                FROM MV_REVENUE
                WHERE TO_CHAR (budat, 'yyyy') = TO_CHAR (CURRENT_DATE, 'yyyy')
                GROUP BY VKORG)SALES_UPDAILY
                LEFT JOIN
                (SELECT  COM, SUM(REVENU_RKAP) AS TARGET_REV
                FROM ZREPORT_RPTREAL_RESUM
                WHERE TAHUN = TO_CHAR (CURRENT_DATE, 'yyyy')
                GROUP BY COM)TARREV_UPDAILY
                ON SALES_UPDAILY.COMPANY = TARREV_UPDAILY.COM";

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function get_data_tabel_province($comp, $datetype)
    {
        if ($comp == "smi") {
            $sql = "SELECT VKBUR_TXT AS PROVINCE,
                                SUM(TOTAL_QTY) AS VOLUME,
                                CASE SUM( TOTAL_QTY ) WHEN 0 THEN 0 ELSE (SUM( PENJUALAN ) / SUM( TOTAL_QTY ))
                                END AS PRICE,
                                SUM(REVENUE) AS REVENUE
                    FROM MV_REVENUE
                    WHERE TO_CHAR (budat, '$datetype') = TO_CHAR (CURRENT_DATE, '$datetype')
                    AND VKORG NOT IN '6000'
                    GROUP BY VKBUR_TXT
                    ORDER BY VKBUR_TXT";
        } else {
            $sql = "SELECT VKBUR_TXT AS PROVINCE,
                                SUM(TOTAL_QTY) AS VOLUME,
                                CASE SUM( TOTAL_QTY ) WHEN 0 THEN 0 ELSE (SUM( PENJUALAN ) / SUM( TOTAL_QTY ))
                                END AS PRICE,
                                SUM(REVENUE) AS REVENUE
                    FROM MV_REVENUE
                    WHERE TO_CHAR (budat, '$datetype') = TO_CHAR (CURRENT_DATE, '$datetype')
                    AND VKORG IN '$comp'
                    GROUP BY VKBUR_TXT
                    ORDER BY VKBUR_TXT";
        }

        $result = $this->db->query($sql);

        return $result->result();
    }

    public function get_data_detail($comp, $datetype)
    {
        if ($comp == "smi") {
            $sql = "SELECT SUM(TOTAL_QTY) AS VOLUME,
                    CASE SUM( TOTAL_QTY ) WHEN 0 THEN 0 ELSE (SUM( PENJUALAN ) / SUM( TOTAL_QTY ))
                    END AS PRICE,
                    SUM(REVENUE) AS REVENUE
                    FROM MV_REVENUE
                    WHERE TO_CHAR (budat, '$datetype') = TO_CHAR (CURRENT_DATE, '$datetype')
                    AND VKORG NOT IN '6000'";
        } else {
            $sql = "SELECT SUM(TOTAL_QTY) AS VOLUME,
                        CASE SUM( TOTAL_QTY ) WHEN 0 THEN 0 ELSE (SUM( PENJUALAN ) / SUM( TOTAL_QTY ))
                        END AS PRICE,
                        SUM(REVENUE) AS REVENUE
                    FROM MV_REVENUE
                    WHERE TO_CHAR (budat, '$datetype') = TO_CHAR (CURRENT_DATE, '$datetype')
                    AND VKORG IN '$comp'
                    GROUP BY VKORG
                    ORDER BY VKORG DESC";
        }

        $result = $this->db->query($sql);

        return $result->result();
    }

    public function get_data_detail_rkapblnini($comp)
    {
        if ($comp == "smi") {
            $sql = "SELECT SUM(REVENU_RKAP) AS TARGET_RKAP 
                    FROM ZREPORT_RPTREAL_RESUM 
                    WHERE BULAN IN TO_CHAR (CURRENT_DATE, 'mm') 
                    AND TAHUN IN TO_CHAR (CURRENT_DATE, 'yyyy')";
        } else {
            $sql = "SELECT SUM(REVENU_RKAP) AS TARGET_RKAP 
                    FROM ZREPORT_RPTREAL_RESUM 
                    WHERE BULAN IN TO_CHAR (CURRENT_DATE, 'mm') 
                    AND TAHUN IN TO_CHAR (CURRENT_DATE, 'yyyy') 
                    AND COM IN '$comp'";
        }

        // echo $sql;
        $result = $this->db->query($sql);

        return $result->result();
    }

    public function get_data_detail_rkapupblnini($comp)
    {
        if ($comp == "smi") {
            $sql = "SELECT SUM(REVENU_RKAP) AS TARGET_RKAP 
                    FROM ZREPORT_RPTREAL_RESUM 
                    WHERE TAHUN IN TO_CHAR (CURRENT_DATE, 'yyyy')";
        } else {
            $sql = "SELECT SUM(REVENU_RKAP) AS TARGET_RKAP 
                    FROM ZREPORT_RPTREAL_RESUM 
                    WHERE TAHUN IN TO_CHAR (CURRENT_DATE, 'yyyy') 
                    AND COM IN '$comp'";
        }

        // echo $sql;
        $result = $this->db->query($sql);

        return $result->result();
    }

    function getUpdateToday()
    {
        $jeniss = array('ZAK', 'Curah', 'Clinker');
        $data = array();
        foreach ($jeniss as $jenis) {
            $rkap = $this->getTodayRKAP($jenis);
            $mv = $this->getTodayMV($jenis);
            $data[$jenis] = array(
                'trev' => (isset($rkap['RKAP_REV']) && $rkap['RKAP_REV'] !== 0) ? $rkap['RKAP_REV'] : 0,
                'tvol' => (isset($rkap['RKAP_TON']) && $rkap['RKAP_TON'] !== 0) ? $rkap['RKAP_TON'] : 0,
                'volume' => (isset($mv['VOL']) && $mv['VOL'] !== 0) ? $mv['VOL'] : 0,
                'revenue' => (isset($mv['REV']) && $mv['REV'] !== 0) ? $mv['REV'] : 0,
            );
        }
        return $data;
    }

    function getTodayRKAP($jenis)
    {
        $part = explode('-', date('Y-m-d'));
        $query = "SELECT
	              NVL (SUM(TARGET_RKAP), 0) AS RKAP_TON,
	              NVL (SUM(REVENU_RKAP), 0) AS RKAP_REV
                  FROM
	              (
		            SELECT
			          COM,
			          PROPINSI,
			          TIPE,
			        (
				      CASE TIPE
				        WHEN '121-301' THEN
					      'ZAK'
				        WHEN '121-302' THEN
					      'Curah'
				        WHEN '121-200' THEN
					      'Clinker'
				      END
			        ) AS PRODUK,
			          TAHUN,
			          BULAN,
			          TARGET_RKAP,
			          REVENU_RKAP
		            FROM
			          ZREPORT_RPTREAL_RESUM
		            ORDER BY
			          TAHUN,
			          BULAN,
			          COM DESC
	              )
                WHERE
	              PRODUK = '" . $jenis . "'
                  AND TAHUN = '" . $part[0] . "'
                  AND BULAN = '" . $part[1] . "'";
        $data = $this->db->query($query);
        return $data->row_array();
    }

    function getTodayMV($jenis)
    {
        $part = explode('-', date('Y-m-d'));
        $query = "SELECT SUM (TOTAL_QTY) AS VOL, SUM (PENJUALAN) / SUM (TOTAL_QTY) AS PRICE, SUM (PENJUALAN) AS TOTALSALES, SUM (OA) AS OA, SUM (REVENUE) AS REV FROM MV_REVENUE WHERE NAMA_MATERIAL = '" . $jenis . "' AND BUDAT >= TO_DATE ('" . $part[0] . "/" . $part[1] . "/01', 'YYYY/MM/DD') AND BUDAT <= TO_DATE ('" . $part[0] . "/" . $part[1] . "/" . $part[2] . "', 'YYYY/MM/DD')";
        $data = $this->db->query($query);
        return $data->row_array();
    }
}
