<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_coalstock extends CI_Model {

    public function tes() {
        $db = $this->load->database('default5', true);

        $plant_group = $_GET['plant'];
        $opco = $_GET['opco'];

        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
            $bulan = $bulan - 1;
        }

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }
        
        $sql_new = $db->query("SELECT
                                *
                        FROM
                                (
                                        SELECT
                                                MAX (tgl_stok) TGL_STOK,
                                                KODE_KELOMPOK
                                        FROM
                                                ZREPORT_SCM_MM_STOK
                                        WHERE
                                                PLANT_GROUP = $plant_group
                                        AND ORG = $opco
                                        GROUP BY
                                                KODE_KELOMPOK
                                ) ll
                        JOIN (
                                SELECT
                                        KODE_KELOMPOK,
                                        TGL_STOK,
                                        QTY_STOK
                                FROM
                                        ZREPORT_SCM_MM_STOK
                                WHERE
                                        PLANT_GROUP = $plant_group
                                AND ORG = $opco
                                AND TO_CHAR (TGL_STOK, 'YYYY-MM') = '$tahun-$bulan'
                                ORDER BY
                                        TGL_STOK DESC
                        ) yy ON ll.tgl_stok = yy.tgl_stok
                        AND ll.kode_kelompok = yy.kode_kelompok");

        foreach ($sql_new->result_array() as $rowID) {
            $this_stock = $rowID['QTY_STOK'];
            $this_kode = $rowID['KODE_KELOMPOK'];
            $this_tgl = $rowID['TGL_STOK'];
            
            $data[$this_kode] = array(
                'stok' => $this_stock,
                'tgl' => $this_tgl
            );
        }
        echo json_encode($data);
    }

    public function get_bahan_chart() {
        $db = $this->load->database('default5', true);

        $material = $_GET['material'];
        $plant_group = $_GET['plant'];
        $opco = $_GET['opco'];

        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
            $bulan = $bulan - 1;
        }

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $sql = $db->query("SELECT
                                    TO_CHAR (ph.tanggal, 'DD') tanggal,
                                    ph.kode_kelompok,
                                    ph.qty_terima terima_prognose,
                                    ph.qty_pakai pakai_prognose,
                                    ph.qty_stok stok_prognose,
                                    zs.qty_terima,
                                    zs.qty_pakai,
                                    zs.qty_stok,
                                    zp.stok_min,
                                    (ROUND(zp.stok_min / 3) * 2) AS STOK_MIN2,
                                    (ROUND(zp.stok_min / 3) * 1) AS STOK_MIN3,
                                    zp.stok_max,
                                    zp.rp,
                                    zp.dead_stock
                            FROM
                                    zreport_scm_mm_prognose_harian ph
                            JOIN zreport_scm_mm_material_plant zp ON zp.KODE_KELOMPOK = ph.kode_kelompok
                            AND zp.PLANT_GROUP = ph.PLANT_GROUP
                            AND ph.org = zp.org
                            LEFT JOIN zreport_scm_mm_stok zs ON zs.KODE_KELOMPOK = ph.kode_kelompok
                            AND zs.plant_group = ph.plant_group
                            AND ph.tanggal = zs.TGL_STOK
                            AND zs.org = ph.org
                            WHERE
                                    ph.plant_group = '$plant_group'
                            AND SUBSTR (
                                    TO_CHAR (ph.tanggal, 'YYYY-MM-DD'),
                                    0,
                                    7
                            ) = '$tahun-$bulan'
                            AND ph.org = '$opco'
                            AND ph.kode_kelompok = $material
                            ORDER BY
                                    ph.tanggal ASC");

        foreach ($sql->result_array() as $rowID) {
            $tgl = $rowID['TANGGAL'];
            $kode_bahan = $rowID['KODE_KELOMPOK'];
            $terima_prog = $rowID['TERIMA_PROGNOSE'];
            $pakai_prog = $rowID['PAKAI_PROGNOSE'];
            $stok_prog = $rowID['STOK_PROGNOSE'];
            $qty_terima = $rowID['QTY_TERIMA'];
            $qty_pakai = $rowID['QTY_PAKAI'];
            $qty_stok = $rowID['QTY_STOK'];
            $qty_min = $rowID['STOK_MIN'];
            $qty_min2 = $rowID['STOK_MIN2'];
            $qty_min3 = $rowID['STOK_MIN3'];
            $qty_max = $rowID['STOK_MAX'];
            $rp = $rowID['RP'];
            $dead_stok = $rowID['DEAD_STOCK'];

            $data[$tgl] = array(
                'tgl' => $tgl,
                'kode_bahan' => $kode_bahan,
                'terima_prog' => $terima_prog,
                'pakai_prog' => $pakai_prog,
                'stok_prog' => $stok_prog,
                'qty_terima' => $qty_terima,
                'qty_pakai' => $qty_pakai,
                'qty_stok' => $qty_stok,
                'qty_min' => $qty_min,
                'qty_min2' => $qty_min2,
                'qty_min3' => $qty_min3,
                'qty_max' => $qty_max,
                'rp' => $rp,
                'dead_stok' => $dead_stok
            );
        }
        echo json_encode($data);
    }

    public function get_data_bahan() {
        $db = $this->load->database('default5', true);

        $plant_group = $_GET['plant'];
        $opco = $_GET['opco'];

        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
            $bulan = $bulan - 1;
        }

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $kode_kel = array(
           1000,
            1100,
            1200,
            1300,
            1400,
            1500,
            1600,
            1700,
            1800,
            1900,
            2000,
            2100,
            2200,
            2300,
            2400,
            2500,
			2600,
			2700
         );

        $sql_rkap = $db->query("SELECT
                                        kode_kelompok,
                                        target_pakai
                                FROM
                                        zreport_scm_mm_rkap
                                WHERE
                                        org = '$opco'
                                AND plant_group = '$plant_group'
                                AND tahun = '$tahun'
                                AND bulan = '$bulan'
                                AND kode_kelompok IN (
                                        1000,
                                        1100,
                                        1200,
                                        1300,
                                        1400,
                                        1500,
                                        1600,
                                        1700,
                                        1800,
                                        1900,
                                        2000,
                                        2100,
                                        2200,
                                        2300,
                                        2400,
                                        2500,
										2600,
										2700
                                )");

        foreach ($kode_kel as $key) {
            # code...
            $data_1[$key] = array(
                'rkap' => 0
            );
        }

        foreach ($sql_rkap->result_array() as $rowID) {
            $bahan = $rowID['KODE_KELOMPOK'];
            $rkap = $rowID['TARGET_PAKAI'];

            if (!empty($rowID['TARGET_PAKAI'])) {
                $rkap_ = $rkap;
            } else {
                $rkap_ = 0;
            }


            $data_1[$bahan] = array(
                'rkap' => $rkap_
            );
        }

        /* Query Lama */
        $sql = $db->query("SELECT
                                    ph.kode_kelompok,
                                    SUM (zs.qty_stok) total_upto,
                                    SUM (zs.qty_terima) penerimaan,
                                    SUM (zs.qty_pakai) pemakaian,
                                    SUM (ph.qty_pakai) prognose
                            FROM
                                    zreport_scm_mm_prognose_harian ph
                            JOIN zreport_scm_mm_material_plant zp ON zp.KODE_KELOMPOK = ph.kode_kelompok
                            AND zp.PLANT_GROUP = ph.PLANT_GROUP
                            AND ph.org = zp.org
                            LEFT JOIN zreport_scm_mm_stok zs ON zs.KODE_KELOMPOK = ph.kode_kelompok
                            AND zs.plant_group = ph.plant_group
                            AND ph.tanggal = zs.TGL_STOK
                            AND zs.org = ph.org
                            WHERE
                                    ph.plant_group = '$plant_group'
                            AND SUBSTR (
                                    TO_CHAR (ph.tanggal, 'YYYY-MM-DD'),
                                    0,
                                    7
                            ) = '$tahun-$bulan'
                            AND ph.org = '$opco'
                            AND ph.kode_kelompok IN (
                                    1000,
                                        1100,
                                        1200,
                                        1300,
                                        1400,
                                        1500,
                                        1600,
                                        1700,
                                        1800,
                                        1900,
                                        2000,
                                        2100,
                                        2200,
                                        2300,
                                        2400,
                                        2500,
										2600,
										2700
                            )
                            GROUP BY
                                    ph.kode_kelompok");
        //Kanggo disable 2400
//        if ($plant_group == '4401'){
//            $str_q = "SELECT
//                            *
//                    FROM
//                            (
//                                    SELECT
//                                            MAX (tgl_stok) TGL_STOK,
//                                            KODE_KELOMPOK
//                                    FROM
//                                            ZREPORT_SCM_MM_STOK
//                                    WHERE
//                                            PLANT_GROUP = $plant_group
//                                    AND ORG = $opco
//                                    GROUP BY
//                                            KODE_KELOMPOK
//                            ) ll
//                    JOIN (
//                            SELECT
//                                    KODE_KELOMPOK,
//                                    TGL_STOK,
//                                    QTY_STOK
//                            FROM
//                                    ZREPORT_SCM_MM_STOK
//                            WHERE
//                                    PLANT_GROUP = $plant_group
//                            AND ORG = $opco
//                            AND TO_CHAR (TGL_STOK, 'YYYY-MM') = '$tahun-$bulan'
//                            ORDER BY
//                                    TGL_STOK DESC
//                    ) yy ON ll.tgl_stok = yy.tgl_stok
//                    AND ll.kode_kelompok = yy.kode_kelompok
//                    WHERE LL.KODE_KELOMPOK NOT IN (2400)";
//        } else  {
//            $str_q = "SELECT
//                                *
//                        FROM
//                                (
//                                        SELECT
//                                                MAX (tgl_stok) TGL_STOK,
//                                                KODE_KELOMPOK
//                                        FROM
//                                                ZREPORT_SCM_MM_STOK
//                                        WHERE
//                                                PLANT_GROUP = $plant_group
//                                        AND ORG = $opco
//                                        GROUP BY
//                                                KODE_KELOMPOK
//                                ) ll
//                        JOIN (
//                                SELECT
//                                        KODE_KELOMPOK,
//                                        TGL_STOK,
//                                        QTY_STOK
//                                FROM
//                                        ZREPORT_SCM_MM_STOK
//                                WHERE
//                                        PLANT_GROUP = $plant_group
//                                AND ORG = $opco
//                                AND TO_CHAR (TGL_STOK, 'YYYY-MM') = '$tahun-$bulan'
//                                ORDER BY
//                                        TGL_STOK DESC
//                        ) yy ON ll.tgl_stok = yy.tgl_stok
//                        AND ll.kode_kelompok = yy.kode_kelompok";
//        }
        $sql_new = $db->query("SELECT
                                *
                        FROM
                                (
                                        SELECT
                                                MAX (tgl_stok) TGL_STOK,
                                                KODE_KELOMPOK
                                        FROM
                                                ZREPORT_SCM_MM_STOK
                                        WHERE
                                                PLANT_GROUP = $plant_group
                                        AND ORG = $opco
                                        GROUP BY
                                                KODE_KELOMPOK
                                ) ll
                        JOIN (
                                SELECT
                                        KODE_KELOMPOK,
                                        TGL_STOK,
                                        QTY_STOK
                                FROM
                                        ZREPORT_SCM_MM_STOK
                                WHERE
                                        PLANT_GROUP = $plant_group
                                AND ORG = $opco
                                AND TO_CHAR (TGL_STOK, 'YYYY-MM') = '$tahun-$bulan'
                                ORDER BY
                                        TGL_STOK DESC
                        ) yy ON ll.tgl_stok = yy.tgl_stok
                        AND ll.kode_kelompok = yy.kode_kelompok");

        foreach ($kode_kel as $key) {
            # code...
            $data_6[$key] = array(
                 'stok' => 0,
                'tgl' => 0
            );
        }

        foreach ($sql_new->result_array() as $rowID) {
            $this_stock = $rowID['QTY_STOK'];
            $this_kode = $rowID['KODE_KELOMPOK'];
            $this_tgl = $rowID['TGL_STOK'];
            
            $data_6[$this_kode] = array(
                'stok' => $this_stock,
                'tgl' => $this_tgl
            );
        }

        foreach ($kode_kel as $key) {
            # code...
            $data_2[$key] = array(
                'upto' => 0,
                'terima' => 0,
                'pakai' => 0,
                'prognose' => 0
            );
        }
        
        foreach ($sql->result_array() as $rowID) {
            $bahan = $rowID['KODE_KELOMPOK'];
            $upto = $rowID['TOTAL_UPTO'];
            $terima = $rowID['PENERIMAAN'];
            $pakai = $rowID['PEMAKAIAN'];
            $prognose = $rowID['PROGNOSE'];

            $data_2[$bahan] = array(
                'upto' => $upto,
                'terima' => $terima,
                'pakai' => $pakai,
                'prognose' => $prognose
            );
        }

        $sql_usage = $db->query("SELECT
                            zs.kode_kelompok,
                            AVG (zs.qty_pakai) stok
                    FROM
                            zreport_scm_mm_stok zs
                    JOIN (
                            SELECT
                                    MAX (st.TGL_STOK) TGL_STOK,
                                    st.kode_kelompok
                            FROM
                                    zreport_scm_mm_stok st
                            WHERE
                                    SUBSTR (
                                            TO_CHAR (st.tgl_stok, 'YYYY-MM-DD'),
                                            0,
                                            7
                                    ) = '$tahun-$bulan'
                            AND st.plant_group = '$plant_group'
                            AND st.org = '$opco'
                            AND st.kode_kelompok IN (
                                1000,
                                1100,
                                1200,
                                1300,
                                1400,
                                1500,
                                1600,
                                1700,
                                1800,
                                1900,
                                2000,
                                2100,
                                2200,
                                2300,
                                2400,
                                2500,
								2600,
								2700
                                )
                                GROUP BY
                                        kode_kelompok
                    ) T ON zs.TGL_STOK BETWEEN T .TGL_STOK - 7
                    AND T .TGL_STOK
                    AND zs.kode_kelompok = T .kode_kelompok
                    WHERE
                            zs.plant_group = '$plant_group'
                    AND zs.org = '$opco'
                    AND zs.kode_kelompok IN (
                                1000,
                                1100,
                                1200,
                                1300,
                                1400,
                                1500,
                                1600,
                                1700,
                                1800,
                                1900,
                                2000,
                                2100,
                                2200,
                                2300,
                                2400,
                                2500,
								2600,
								2700
                        )
                        GROUP BY
                                        zs.kode_kelompok");

        foreach ($kode_kel as $key) {
            # code...
           $data_3[$key] = array(
                'stok' => 0
            );
        }

        foreach ($sql_usage->result_array() as $rowID) {
            $bahan = $rowID['KODE_KELOMPOK'];
            $stok = $rowID['STOK'];

            $data_3[$bahan] = array(
                'stok' => $stok
            );
        }

        $sql_maxmin = $db->query("SELECT
                                        KODE_KELOMPOK,
                                        STOK_MAX,
                                        STOK_MIN,
                                        RP,
                                        DEAD_STOCK
                                FROM
                                        ZREPORT_SCM_MM_MATERIAL_PLANT
                                WHERE
                                        ORG = $opco
                                AND PLANT_GROUP = $plant_group
                                AND KODE_KELOMPOK IN (
                                        1000,
                                        1100,
                                        1200,
                                        1300,
                                        1400,
                                        1500,
                                        1600,
                                        1700,
                                        1800,
                                        1900,
                                        2000,
                                        2100,
                                        2200,
                                        2300,
                                        2400,
                                        2500,
										2600,
										2700
                                )");

        foreach ($kode_kel as $key) {
            # code...
            $data_4[$key] = array(
                'max' => 0,
                'min' => 0,
                'rp' => 0,
                'ds' => 0
            );
            
        }

        foreach ($sql_maxmin->result_array() as $rowID) {
            $bahan = $rowID['KODE_KELOMPOK'];
            $max = $rowID['STOK_MAX'];
            $min = $rowID['STOK_MIN'];
            $rp = $rowID['RP'];
            $ds = $rowID['DEAD_STOCK'];

            $data_4[$bahan] = array(
                'max' => $max,
                'min' => $min,
                'rp' => $rp,
                'ds' => $ds
            );
        }

		$sql_stock = $db->query("SELECT zs.kode_kelompok, 
		zs.qty_terima, 
		zs.qty_pakai, 
		zs.qty_stok,
		zp.stok_min,
		zp.stok_max,
		zp.rp,
                t.TGL_STOK
            FROM zreport_scm_mm_stok zs
            JOIN (
                    SELECT max(st.TGL_STOK) TGL_STOK, st.kode_kelompok FROM zreport_scm_mm_stok st
                    WHERE substr(to_char(st.tgl_stok,'YYYY-MM-DD'),0,7) = '$tahun-$bulan'
										AND st.plant_group = '$plant_group'
                        and st.org = '$opco'
                    GROUP BY kode_kelompok
            )t 	
                    ON t.TGL_STOK = zs.TGL_STOK AND zs.kode_kelompok = t.kode_kelompok
            JOIN zreport_scm_mm_material_plant zp
                    ON zp.KODE_KELOMPOK = zs.kode_kelompok AND zp.PLANT_GROUP = zs.PLANT_GROUP	
            WHERE zs.plant_group = '$plant_group' and substr(to_char(zs.tgl_stok,'YYYY-MM-DD'),0,7) ='$tahun-$bulan'
                and zs.org = '$opco'
        ");
        foreach ($kode_kel as $key) {
            # code...
            $data_5[$bahan] = array(
                'qty_terima' => 0,
                'qty_pakai' => 0,
                'qty_stok' => 0,
                'stok_min' => 0,
                'stok_max' => 0,
                'qty_rp' => 0,
                'update' => 0,
            );
        }

        foreach ($sql_stock->result_array() as $rowID) {
            $bahan = $rowID['KODE_KELOMPOK'];
            $qty_terima = $rowID['QTY_TERIMA'];
            $qty_pakai = $rowID['QTY_PAKAI'];
            $qty_stok = $rowID['QTY_STOK'];
            $stok_min = $rowID['STOK_MIN'];
            $stok_max = $rowID['STOK_MAX'];
            $qty_rp = $rowID['RP'];
            $tgl = $rowID['TGL_STOK'];

            $data_5[$bahan] = array(
                'qty_terima' => $qty_terima,
                'qty_pakai' => $qty_pakai,
                'qty_stok' => $qty_stok,
                'stok_min' => $stok_min,
                'stok_max' => $stok_max,
                'qty_rp' => $qty_rp,
                'update' => $tgl
            );
        }

        // Get Prognose Pemakaian Bulanan - Start

        $sql_proguse_v = $db->query("SELECT
                                    TO_CHAR (ph.tanggal, 'DD') tanggal,
                                    ph.kode_kelompok,
                                    ph.qty_pakai pakai_prognose,
                                    zs.qty_pakai
                            FROM
                                    zreport_scm_mm_prognose_harian ph
                            JOIN zreport_scm_mm_material_plant zp ON zp.KODE_KELOMPOK = ph.kode_kelompok
                            AND zp.PLANT_GROUP = ph.PLANT_GROUP
                            AND ph.org = zp.org
                            LEFT JOIN zreport_scm_mm_stok zs ON zs.KODE_KELOMPOK = ph.kode_kelompok
                            AND zs.plant_group = ph.plant_group
                            AND ph.tanggal = zs.TGL_STOK
                            AND zs.org = ph.org
                            WHERE ph.plant_group = '$plant_group' AND TO_CHAR (ph.tanggal, 'YYYY-MM') = '$tahun-$bulan'
                            AND ph.org = '$opco'
                            AND ph.kode_kelompok IN (1000, 1100, 1200, 1300, 1400, 1500, 1600, 1700,
                                        1800, 1900, 2000, 2100, 2200, 2300, 2400, 2500, 2600, 2700)
                            ORDER BY PH.KODE_KELOMPOK ASC");

        foreach ($kode_kel as $key) {
            # code...
            $data_7[$key] = array(
                'prog_use' => 0
            );
            
        }

        

        foreach ($kode_kel as $key) {
            $prog_use_value = 0;
            $prog_temp = 0;
            # code...
            foreach ($sql_proguse_v->result_array() as $rowID) {

                if ($key == $rowID['KODE_KELOMPOK'] ) {
                    # code...
                    if ($rowID['QTY_PAKAI'] != null) {
                        # code...
                        $prog_temp = $rowID['QTY_PAKAI'];
                        $prog_use_value = $prog_use_value + $prog_temp;
                    } else {
                        # code...
                        $prog_temp = $rowID['PAKAI_PROGNOSE'];
                        $prog_use_value = $prog_use_value + $prog_temp;
                    }
                    
                } 
                // $k_bahan = $rowID['KODE_KELOMPOK'];
                // $p_prog_est = $rowID['PAKAI_PROGNOSE'];
                // $qty_use = $rowID['QTY_PAKAI'];
            }

            $data_7[$key] = array(
                'prog_use' => $prog_use_value
            );
            
        }

        

        // Get Prognose Pemakaian Bulanan - End

        if (empty($data_1)) {
            $a = 0;
        } else {
            $a = $data_1;
        }
        if (empty($data_2)) {
            $b = 0;
        } else {
            $b = $data_2;
        }
        if (empty($data_3)) {
            $c = 0;
        } else {
            $c = $data_3;
        }
        if (empty($data_4)) {
            $d = 0;
        } else {
            $d = $data_4;
        }
        if (empty($data_5)) {
            $e = 0;
        } else {
            $e = $data_5;
        }
        if (empty($data_6)) {
            $f = 0;
        } else {
            $f = $data_6;
        }
        if (empty($data_7)) {
            $g = 0;
        } else {
            $g = $data_7;
        }
        $data = array(
            'rkap' => $a,
            'data' => $b,
            'stok' => $c,
            'maxmin' => $d,
            'last' => $e,
            'act_stok' => $f,
            'prog_pakai' => $g
        );

        echo json_encode($data);
    }

}
