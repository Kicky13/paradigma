<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_plantpadang extends CI_Model {

    public function get_state() {
        $myGetURLPadang = 'http://mobile-pis.semenpadang.co.id/opcdaq?tags[]=$N11.R1M03M1.CV&tags[]=$N21.R2M03M1.CV&tags[]=$T_4R1.M03M1_M2.CV&tags[]=$T_4R2.M03M1.CV&tags[]=$T_5R1.M03M1.CV&tags[]=$T_5R2.M03M1.CV&tags[]=$N12.W1W03_05M1.CV&tags[]=$N22.W2W03_05M1.CV&tags[]=$T_4W1.W03_W05.CV&tags[]=$T_5W1.W03M1.CV&tags[]=$N12.K1M03M1.CV&tags[]=$N22.K2M03M1.CV&tags[]=$T_4K2.M03M1.CV&tags[]=$T_4K3.M03M1_FC.CV&tags[]=$T_5K1.M03M1.CV&tags[]=$N13.Z1M03M1.CV&tags[]=$N23.Z2M03M1.CV&tags[]=$T_4Z1.M03M1_M2.CV&tags[]=$T_4Z2.M03M1.CV&tags[]=$T_5Z1.M03M1.CV&tags[]=$T_5Z2.M03M1.CV&tags[]=$T_6R1.M03M01.CV&tags[]=$T_6W1.W04U01.CV&tags[]=$T_6K1.M03M01.CV&tags[]=$T_6Z1.M03M01.CV';
        print file_get_contents($myGetURLPadang);
    }

    public function get_feed() {
//        $myGetURLPadang = 'http://mobile-pis.semenpadang.co.id/opcdaq?tags%5B%5D=(%24N11.R1A01F1.CV%2B%24N11.R1E01F1.CV%2B%24N11.R1C07F1.CV%2B%24N11.R1D01F1.CV)*%24N11.R1M03M1.CV&tags%5B%5D=%24N21.R2A01F1.CV%2B%24N21.R2E01F1.CV%2B%24N21.R2C07F1.CV%2B%24N21.R2D01F1.CV&tags%5B%5D=IF(GT(%24T_4R1.M03M1_M2.CV%2C0)%2C(%24T_4R1.A01F1.CV*1.02%2B%24T_4R1.B01F1.CV*1.02%2B%24T_4R1.C01F1.CV*1.02%2B(%24T_4R1.J06F1_1.CV*1.2-%24T_4R1.C01F1.CV)*1.02)%2C0)&tags%5B%5D=IF(GT(%24T_4R2.M03M1.CV%2C0)%2C%24T_4R2.A01F1.CV*1.08%2B%24T_4R2.B01F1.CV*1.08%2B%24T_4R2.C01F1.CV*1.08%2B%24T_4R2.J06F1_2.CV*1.08%2C0)&tags%5B%5D=IF(EQ(%24T_5R1.M03M1.CV%2C32768)%2C%24T_5R1.A01M1F01.CV%2B%24T_5R1.C01M1F01.CV%2B%24T_5R1.D01M1F01.CV%2B%24T_5R1.E01M1F01.CV%2C0)&tags%5B%5D=IF(EQ(%24T_5R2.M03M1.CV%2C32768)%2C%24T_5R2.A11M1F01.CV%2B%24T_5R2.C11M1F01.CV%2B%24T_5R2.D11M1F01.CV%2B%24T_5R2.E11M1F01.CV%2C0)&tags%5B%5D=%24N12.W1A07_09F1.CV*%24N12.W1W03_05M1.CV&tags%5B%5D=%24N22.W2A07_09F1.CV*%24N22.W2W03_05M1.CV&tags%5B%5D=(%24T_4W1.A01F2.CV%2B%24T_4W1.A01F1_ORIGINAL.CV)*%24T_4W1.W03_W05.CV&tags%5B%5D=IF(EQ(%24T_5W1.W03M1.CV%2C32768)%2C%24T_5W1.A05A1F01.CV%2B%24T_5W1.B05A1F01.CV%2C0)&tags%5B%5D=%24N12.K1A01V1.CV*%24N12.K1M03M1.CV&tags%5B%5D=%24N22.K2A01V1.CV*%24N22.K2M03M1.CV&tags%5B%5D=%24T_4K2.S01S1.CV*%24T_4K2.M03M1.CV&tags%5B%5D=%24T_4K3.A01S1_FC.CV*%24T_4K3.M03M1_FC.CV&tags%5B%5D=IF(EQ(%24T_5K1.M03M1.CV%2C32768)%2C%24T_5K1.A02M1S01.CV%2C0)&tags%5B%5D=%24N13.Z1M03M1.CV*%24N13.Z1_MV_TOTAL.CV&tags%5B%5D=%24N23.Z2M03M1.CV*%24N23.Z2_MV_TOTAL.CV&tags%5B%5D=%24T_4Z1.M03M1_M2.CV*(%24T_4Z1.A01F1.CV)%2B(%24T_4Z1.B01F1.CV*1)%2B(%24T_4Z1.E01F1.CV*1)%2B(%24T_4Z1.D01F1.CV*1)&tags%5B%5D=%24T_4Z2.M03M1.CV*(%24T_4Z2.A01F1.CV)%2B(%24T_4Z2.B01F1.CV*1)%2B(%24T_4Z2.E01F1.CV*1)%2B(%24T_4Z2.D01F1.CV*1)&tags%5B%5D=IF(EQ(%24T_5Z1.M03M1.CV%2C32768)%2C%24T_5U1.U12A1F01.CV*1%2B%24T_5Z1.B01A1F01.CV*1%2B%24T_5Z1.C01A1F01.CV*1%2B%24T_5Z1.E01A1F01.CV*1%2C0)&tags%5B%5D=IF(EQ(%24T_5Z2.M03M1.CV%2C32768)%2C%24T_5U1.U02A1F01.CV%2B%24T_5Z2.B01A1F01.CV%2B%24T_5Z2.C01A1F01.CV%2B%24T_5Z2.E01A1F01.CV%2C0)&tags%5B%5D=(%24T_6R1.A01A01F01.CV%2B%24T_6R1.C01A01F01.CV%2B%24T_6R1.D01A01F01.CV%2B%24T_6R1.E01A01F01.CV)&tags%5B%5D=(%24T_6W1.A05A01F01.CV%2B%24T_6W1.B05A01F01.CV)&tags%5B%5D=%24T_6K1.TOTALFEED.CV&tags%5B%5D=%24T_6Z1.TOTALFEED.CV';
        $myGetURLPadang = 'http://mobile-pis.semenpadang.co.id/opcdaq?tags%5B%5D=(%24N11.R1A01F1.CV%2B%24N11.R1E01F1.CV%2B%24N11.R1C07F1.CV%2B%24N11.R1D01F1.CV)*%24N11.R1M03M1.CV&tags%5B%5D=%24N21.R2A01F1.CV%2B%24N21.R2E01F1.CV%2B%24N21.R2C07F1.CV%2B%24N21.R2D01F1.CV&tags%5B%5D=IF(GT(%24T_4R1.M03M1_M2.CV%2C0)%2C(%24T_4R1.A01F1.CV*1.02%2B%24T_4R1.B01F1.CV*1.02%2B%24T_4R1.C01F1.CV*1.02%2B(%24T_4R1.J06F1_1.CV*1.2-%24T_4R1.C01F1.CV)*1.02)%2C0)&tags%5B%5D=IF(GT(%24T_4R2.M03M1.CV%2C0)%2C%24T_4R2.A01F1.CV*1.08%2B%24T_4R2.B01F1.CV*1.08%2B%24T_4R2.C01F1.CV*1.08%2B%24T_4R2.J06F1_2.CV*1.08%2C0)&tags%5B%5D=IF(EQ(%24T_5R1.M03M1.CV%2C32768)%2C%24T_5R1.A01M1F01.CV%2B%24T_5R1.C01M1F01.CV%2B%24T_5R1.D01M1F01.CV%2B%24T_5R1.E01M1F01.CV%2C0)&tags%5B%5D=IF(EQ(%24T_5R2.M03M1.CV%2C32768)%2C%24T_5R2.A11M1F01.CV%2B%24T_5R2.C11M1F01.CV%2B%24T_5R2.D11M1F01.CV%2B%24T_5R2.E11M1F01.CV%2C0)&tags%5B%5D=%24N12.W1A07_09F1.CV*%24N12.W1W03_05M1.CV&tags%5B%5D=%24N22.W2A07_09F1.CV*%24N22.W2W03_05M1.CV&tags%5B%5D=(%24T_4W1.A01F2.CV%2B%24T_4W1.A01F1_ORIGINAL.CV)*%24T_4W1.W03_W05.CV&tags%5B%5D=IF(EQ(%24T_5W1.W03M1.CV%2C32768)%2C%24T_5W1.A05A1F01.CV%2B%24T_5W1.B05A1F01.CV%2C0)&tags%5B%5D=%24N12.K1A01V1.CV*%24N12.K1M03M1.CV&tags%5B%5D=%24N22.K2A01V1.CV*%24N22.K2M03M1.CV&tags%5B%5D=%24T_4K2.S01S1.CV*%24T_4K2.M03M1.CV&tags%5B%5D=%24T_4K3.A01S1_FC.CV*%24T_4K3.M03M1_FC.CV&tags%5B%5D=IF(EQ(%24T_5K1.M03M1.CV%2C32768)%2C%24T_5K1.A02M1S01.CV%2C0)&tags%5B%5D=%24N13.Z1M03M1.CV*%24N13.Z1_MV_TOTAL.CV&tags%5B%5D=%24N23.Z2M03M1.CV*%24N23.Z2_MV_TOTAL.CV&tags%5B%5D=%24T_4Z1.M03M1_M2.CV*(%24T_4Z1.A01F1.CV)%2B(%24T_4Z1.B01F1.CV*1)%2B(%24T_4Z1.E01F1.CV*1)%2B(%24T_4Z1.D01F1.CV*1)&tags%5B%5D=%24T_4Z2.M03M1.CV*(%24T_4Z2.A01F1.CV)%2B(%24T_4Z2.B01F1.CV*1)%2B(%24T_4Z2.E01F1.CV*1)%2B(%24T_4Z2.D01F1.CV*1)&tags%5B%5D=IF(EQ(%24T_5Z1.M03M1.CV%2C32768)%2C%24T_5U1.U12A1F01.CV*1%2B%24T_5Z1.B01A1F01.CV*1%2B%24T_5Z1.C01A1F01.CV*1%2B%24T_5Z1.E01A1F01.CV*1%2C0)&tags%5B%5D=IF(EQ(%24T_5Z2.M03M1.CV%2C32768)%2C%24T_5U1.U02A1F01.CV%2B%24T_5Z2.B01A1F01.CV%2B%24T_5Z2.C01A1F01.CV%2B%24T_5Z2.E01A1F01.CV%2C0)&tags%5B%5D=(%24T_6R1.A01A01F01.CV*%24T_6R1.M03M01.CV)&tags%5B%5D=(%24T_6W1.A05A01F01.CV*%24T_6W1.W04U01.CV)&tags%5B%5D=%24T_6K1.A01A01F01.CV&tags%5B%5D=%24T_6Z1.A01A01F01.CV*%24T_6Z1.M03M01.CV';
        print file_get_contents($myGetURLPadang);
    }

    public function get_emission() {
        $myGetURLPadang = 'http://mobile-pis.semenpadang.co.id/opcdaq?tags%5B%5D=%24N12.W1_SPARE1.CV&tags%5B%5D=%24N22.W2W01X3.CV&tags%5B%5D=%24T_4J1.P11X1_2.CV&tags%5B%5D=%24T_4J2.P11X1_2.CV&tags%5B%5D=%24T_5J1.P01N3A02.CV';
        print file_get_contents($myGetURLPadang);
    }

    public function get_silo() {
        $myGetURLPadang = 'http://mobile-pis.semenpadang.co.id/opcdaq?tags[]=$N23.P1L01Q1.CV&tags[]=$N23.P1L11Q1.CV&tags[]=$N23.P1L21Q1.CV&tags[]=$N23.P1L31Q1.CV&tags[]=$T_4Z1.P1L51.CV&tags[]=$T_4Z1.P1L61.CV&tags[]=$T_4Z1.P1L71.CV&tags[]=$T_4Z1.P1L81.CV&tags[]=$T_5Z1.L09N1L01.CV&tags[]=$T_5Z1.L11N1L01.CV&tags[]=$T_5Z2.L09N1L01.CV&tags[]=$T_5Z2.L11N1L01.CV&tags[]=$T_6P1.L01N01L01.CV&tags[]=$T_6P2.L01N01L01.CV';
        print file_get_contents($myGetURLPadang);
    }

    public function get_prodjop() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
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

        $query = $db->query("SELECT
                    	SUM (RM2_PROD) AS RM2_PROD,
                SUM (RM2_JOP) AS RM2_JOP,
                SUM (RM3_PROD) AS RM3_PROD,
                SUM (RM3_JOP) AS RM3_JOP,
                SUM (RM41_PROD) AS RM41_PROD,
                SUM (RM41_JOP) AS RM41_JOP,
                SUM (RM42_PROD) AS RM42_PROD,
                SUM (RM42_JOP) AS RM42_JOP,
                SUM (RM51_PROD) AS RM51_PROD,
                SUM (RM51_JOP) AS RM51_JOP,
                SUM (RM52_PROD) AS RM52_PROD,
                SUM (RM52_JOP) AS RM52_JOP,
                SUM (KL2_PROD) AS KL2_PROD,
                SUM (KL2_JOP) AS KL2_JOP,
                SUM (KL3_PROD) AS KL3_PROD,
                SUM (KL3_JOP) AS KL3_JOP,
                SUM (KL4_PROD) AS KL4_PROD,
                SUM (KL4_JOP) AS KL4_JOP,
                SUM (KL5_PROD) AS KL5_PROD,
                SUM (KL5_JOP) AS KL5_JOP,
                SUM (FM2_PROD) AS FM2_PROD,
                SUM (FM2_JOP) AS FM2_JOP,
                SUM (FM3_PROD) AS FM3_PROD,
                SUM (FM3_JOP) AS FM3_JOP,
                SUM (FM41_PROD) AS FM41_PROD,
                SUM (FM41_JOP) AS FM41_JOP,
                SUM (FM42_PROD) AS FM42_PROD,
                SUM (FM42_JOP) AS FM42_JOP,
                SUM (FM51_PROD) AS FM51_PROD,
                SUM (FM51_JOP) AS FM51_JOP,
                SUM (FM52_PROD) AS FM52_PROD,
                SUM (FM52_JOP) AS FM52_JOP,
                SUM (FMDM_PROD) AS FMDM_PROD,
                SUM (FMDM_JOP) AS FMDM_JOP,
                SUM (FM61_PROD) AS FM61_PROD,
                SUM (FM61_JOP) AS FM61_JOP,
                SUM (FM1_PROD) AS FM1_PROD,
                SUM (FM1_JOP) AS FM1_JOP,
                SUM (KL6_PROD) AS KL6_PROD,
                SUM (KL6_JOP) AS KL6_JOP,
                SUM (RM6_PROD) AS RM6_PROD,
                SUM (RM6_JOP) AS RM6_JOP
            FROM
                PIS_SP_PRODDAILY
            WHERE
                TO_CHAR (DATE_PROD, 'YYYY-MM') LIKE '$tahun-$bulan'");

        foreach ($query->result_array() as $rowID) {
            $rm2_prod = $rowID['RM2_PROD'];
            $rm2_jop = $rowID['RM2_JOP'];
            $rm3_prod = $rowID['RM3_PROD'];
            $rm3_jop = $rowID['RM3_JOP'];
            $rm41_prod = $rowID['RM41_PROD'];
            $rm41_jop = $rowID['RM41_JOP'];
            $rm42_prod = $rowID['RM42_PROD'];
            $rm42_jop = $rowID['RM42_JOP'];
            $rm51_prod = $rowID['RM51_PROD'];
            $rm51_jop = $rowID['RM51_JOP'];
            $rm52_prod = $rowID['RM52_PROD'];
            $rm52_jop = $rowID['RM52_JOP'];
            $kl2_prod = $rowID['KL2_PROD'];
            $kl2_jop = $rowID['KL2_JOP'];
            $kl3_prod = $rowID['KL3_PROD'];
            $kl3_jop = $rowID['KL3_JOP'];
            $kl4_prod = $rowID['KL4_PROD'];
            $kl4_jop = $rowID['KL4_JOP'];
            $kl5_prod = $rowID['KL5_PROD'];
            $kl5_jop = $rowID['KL5_JOP'];
            $fm2_prod = $rowID['FM2_PROD'];
            $fm2_jop = $rowID['FM2_JOP'];
            $fm3_prod = $rowID['FM3_PROD'];
            $fm3_jop = $rowID['FM3_JOP'];
            $fm41_prod = $rowID['FM41_PROD'];
            $fm41_jop = $rowID['FM41_JOP'];
            $fm42_prod = $rowID['FM42_PROD'];
            $fm42_jop = $rowID['FM42_JOP'];
            $fm51_prod = $rowID['FM51_PROD'];
            $fm51_jop = $rowID['FM51_JOP'];
            $fm52_prod = $rowID['FM52_PROD'];
            $fm52_jop = $rowID['FM52_JOP'];
            $fmdm_prod = $rowID['FMDM_PROD'];
            $fmdm_jop = $rowID['FMDM_JOP'];
            $fm61_prod = $rowID['FM61_PROD'];
            $fm61_jop = $rowID['FM61_JOP'];
            $fm1_prod = $rowID['FM1_PROD'];
            $fm1_jop = $rowID['FM1_JOP'];
            $kl6_prod = $rowID['KL6_PROD'];
            $kl6_jop = $rowID['KL6_JOP'];
            $rm6_prod = $rowID['RM6_PROD'];
            $rm6_jop = $rowID['RM6_JOP'];
        }

        $data = array('pabrik' => 'Padang',
            'rm2_prod' => number_format($rm2_prod, 2, ".", ""),
            'rm2_jop' => number_format($rm2_jop, 2, ".", ""),
            'rm3_prod' => number_format($rm3_prod, 2, ".", ""),
            'rm3_jop' => number_format($rm3_jop, 2, ".", ""),
            'rm41_prod' => number_format($rm41_prod, 2, ".", ""),
            'rm41_jop' => number_format($rm41_jop, 2, ".", ""),
            'rm42_prod' => number_format($rm42_prod, 2, ".", ""),
            'rm42_jop' => number_format($rm42_jop, 2, ".", ""),
            'rm51_prod' => number_format($rm51_prod, 2, ".", ""),
            'rm51_jop' => number_format($rm51_jop, 2, ".", ""),
            'rm52_prod' => number_format($rm52_prod, 2, ".", ""),
            'rm52_jop' => number_format($rm52_jop, 2, ".", ""),
            'kl2_prod' => number_format($kl2_prod, 2, ".", ""),
            'kl2_jop' => number_format($kl2_jop, 2, ".", ""),
            'kl3_prod' => number_format($kl3_prod, 2, ".", ""),
            'kl3_jop' => number_format($kl3_jop, 2, ".", ""),
            'kl4_prod' => number_format($kl4_prod, 2, ".", ""),
            'kl4_jop' => number_format($kl4_jop, 2, ".", ""),
            'kl5_prod' => number_format($kl5_prod, 2, ".", ""),
            'kl5_jop' => number_format($kl5_jop, 2, ".", ""),
            'fm2_prod' => number_format($fm2_prod, 2, ".", ""),
            'fm2_jop' => number_format($fm2_jop, 2, ".", ""),
            'fm3_prod' => number_format($fm3_prod, 2, ".", ""),
            'fm3_jop' => number_format($fm3_jop, 2, ".", ""),
            'fm41_prod' => number_format($fm41_prod, 2, ".", ""),
            'fm41_jop' => number_format($fm41_jop, 2, ".", ""),
            'fm42_prod' => number_format($fm42_prod, 2, ".", ""),
            'fm42_jop' => number_format($fm42_jop, 2, ".", ""),
            'fm51_prod' => number_format($fm51_prod, 2, ".", ""),
            'fm51_jop' => number_format($fm51_jop, 2, ".", ""),
            'fm52_prod' => number_format($fm52_prod, 2, ".", ""),
            'fm52_jop' => number_format($fm52_jop, 2, ".", ""),
            'fmdm_prod' => number_format($fmdm_prod, 2, ".", ""),
            'fmdm_jop' => number_format($fmdm_jop, 2, ".", ""),
            'fm61_prod' => number_format($fm61_prod, 2, ".", ""),
            'fm61_jop' => number_format($fm61_jop, 2, ".", ""),
            'fm1_prod' => number_format($fm1_prod, 2, ".", ""),
            'fm1_jop' => number_format($fm1_jop, 2, ".", ""),
            'kl6_prod' => number_format($kl6_prod, 2, ".", ""),
            'kl6_jop' => number_format($kl6_jop, 2, ".", ""),
            'rm6_prod' => number_format($rm6_prod, 2, ".", ""),
            'rm6_jop' => number_format($rm6_jop, 2, ".", "")
        );

        echo json_encode($data);
    }

    public function get_totaltahun() {
        $db = $this->load->database('oramso', true);
        if (!empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }
        if (strlen($bulan) < 2) {
            $month = '0' . $bulan;
        } else {
            $month = $bulan;
        }
        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        if (empty($_GET['bulan']) && empty($_GET['tahun'])) {
            $sql = "SELECT
                                    SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM41_PROD) + SUM (RM42_PROD) + SUM (RM51_PROD) + SUM (RM52_PROD) + SUM (RM6_PROD) AS rawmill,
                                    SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) + SUM (KL5_PROD) + SUM (KL6_PROD) AS kiln,
                                    SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM41_PROD) + SUM (FM42_PROD) + SUM (FM51_PROD) + SUM (FM52_PROD) + SUM (FMDM_PROD) + SUM (FM61_PROD) + SUM (FM1_PROD) AS finishmill
                            FROM
                                    PIS_SP_PRODMONTH WHERE MONTH_PROD LIKE '%" . $tahun . "%'";
        } else {
            $sql = "SELECT
                                    SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM41_PROD) + SUM (RM42_PROD) + SUM (RM51_PROD) + SUM (RM52_PROD) + SUM (RM6_PROD) AS rawmill,
                                    SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) + SUM (KL5_PROD) + SUM (KL6_PROD) AS kiln,
                                    SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM41_PROD) + SUM (FM42_PROD) + SUM (FM51_PROD) + SUM (FM52_PROD) + SUM (FMDM_PROD) + SUM (FM61_PROD) + SUM (FM1_PROD) AS finishmill
                            FROM
                                    PIS_SP_PRODMONTH WHERE MONTH_PROD LIKE '" . $tahun . "-" . $month . "'";
        }

        $query = $db->query($sql);

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RAWMILL'], 2, ".", "");
            $kl = number_format($rowID['KILN'], 2, ".", "");
            $fm = number_format($rowID['FINISHMILL'], 2, ".", "");
        }

        $data = array('pabrik' => 'Padang',
            'rawmill' => $rm,
            'kiln' => $kl,
            'finishmill' => $fm
        );

        echo json_encode($data);
    }

    public function get_upto() {
        $db = $this->load->database('oramso', true);

        if (!empty($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $query = $db->query("SELECT
                                    SUM (RM2_PROD) + SUM (RM3_PROD) + SUM (RM41_PROD) + SUM (RM42_PROD) + SUM (RM51_PROD) + SUM (RM52_PROD) + SUM (RM6_PROD) AS rawmill,
                                    SUM (KL2_PROD) + SUM (KL3_PROD) + SUM (KL4_PROD) + SUM (KL5_PROD) + SUM (KL6_PROD) AS kiln,
                                    SUM (FM2_PROD) + SUM (FM3_PROD) + SUM (FM41_PROD) + SUM (FM42_PROD) + SUM (FM51_PROD) + SUM (FM52_PROD) + SUM (FMDM_PROD) + SUM (FM61_PROD) + SUM (FM1_PROD) AS finishmill
                            FROM
                                    PIS_SP_PRODMONTH WHERE MONTH_PROD LIKE '%" . $tahun . "%'");

        foreach ($query->result_array() as $rowID) {
            $rm = number_format($rowID['RAWMILL'], 2, ".", "");
            $kl = number_format($rowID['KILN'], 2, ".", "");
            $fm = number_format($rowID['FINISHMILL'], 2, ".", "");
        }

        $data = array('pabrik' => 'Padang',
            'rawmill' => $rm,
            'kiln' => $kl,
            'finishmill' => $fm
        );

        echo json_encode($data);
    }

    public function get_proddaily() {
        $db = $this->load->database('oramso', true);
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

        $query = $db->query("SELECT
                                    *
                            FROM
                                    V_PIS_SP_PLANT
                            WHERE
                                    TO_CHAR (OPDATE, 'YYYY-MM') = '" . $tahun . "-" . $bulan . "'
                            ORDER BY
                                    OPDATE ASC");

        foreach ($query->result_array() as $rowID) {
            $runHours [$rowID['TAGID']][] = $rowID['RUNHOURS'];
            $idJson [$rowID['TAGID']] = array('tagid' => $rowID['TAGID'],
                'name' => $rowID['TEXT'],
                'pabrik' => $rowID['PABRIK']
            );

            $seqTgl = date('d', strtotime($rowID['OPDATE']));
            if ($seqTgl != 0 or ! empty($seqTgl)) {
                $prod[$rowID['TAGID']][$seqTgl] = array(
                    'rate' => number_format($rowID['RATE'], 0, ",", "."),
                    'prod' => number_format($rowID['PROD'], 0, ",", "."));
            }
            $toprod[$rowID['TAGID']][] = number_format($rowID['PROD'], 0, ",", ".");
        }

        foreach ($idJson as $alpha) {
            $runHours_x[$alpha['tagid']] = array("plant" => $alpha['pabrik'],
                "name" => $alpha['name'],
                "tagid" => $alpha['tagid'],
                "runhours" => array_sum($runHours [$alpha['tagid']]),
                "tproduksi" => array_sum($toprod[$alpha['tagid']]),
                "produksi" => $prod[$alpha['tagid']],
            );
        }
        echo json_encode($runHours_x);
    }

    public function get_prodmonth() {
        $db = $this->load->database('oramso', true);
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

        $query = $db->query("SELECT
                                    TAHUN,
                                    BULAN,
                                    CEMENT,
                                    CLINKER
                            FROM
                                    PIS_RKAP_TOTAL
                            WHERE
                                    COMPANY = 3000
                            AND TAHUN = '" . $tahun . "'");

        foreach ($query->result_array() as $rowID) {
            $bln = $rowID['BULAN'];
            $panjang = strlen($bln);
            if ($panjang == 1) {
                $blnku = '0' . $bln;
            } else {
                $blnku = $bln;
            }
            $thn = $rowID['TAHUN'];
            $month = $thn . '-' . $blnku;
            $rkap_cement = $rowID['CEMENT'];
            $rkap_clinker = $rowID['CLINKER'];

            $rkap[$month] = array(
                "rkap_cement" => $rkap_cement,
                "rkap_clinker" => $rkap_clinker
            );
        }

        $query_data = $db->query("SELECT
                                        MONTH_PROD,
                                        RM2_PROD,
                                        RM3_PROD,
                                        RM41_PROD,
                                        RM42_PROD,
                                        RM51_PROD,
                                        RM52_PROD,
                                        RM6_PROD,
                                        KL2_PROD,
                                        KL3_PROD,
                                        KL4_PROD,
                                        KL5_PROD,
                                        KL6_PROD,
                                        FM2_PROD,
                                        FM3_PROD,
                                        FM41_PROD,
                                        FM42_PROD,
                                        FM51_PROD,
                                        FMDM_PROD,
                                        FM52_PROD,
                                        FM61_PROD,
                                        FM1_PROD
                                FROM
                                        PIS_SP_PRODMONTH
                                WHERE MONTH_PROD LIKE '$tahun-%'
                                ORDER BY
                                        MONTH_PROD");

        foreach ($query_data->result_array() as $rowID) {
            $month = $rowID['MONTH_PROD'];

            $rm2 = $rowID['RM2_PROD'];
            $rm3 = $rowID['RM3_PROD'];
            $rm4 = $rowID['RM41_PROD'] + $rowID['RM42_PROD'];
            $rm5 = $rowID['RM51_PROD'] + $rowID['RM52_PROD'];
            $rm6 = $rowID['RM6_PROD'];

            $kl2 = $rowID['KL2_PROD'];
            $kl3 = $rowID['KL3_PROD'];
            $kl4 = $rowID['KL4_PROD'];
            $kl5 = $rowID['KL5_PROD'];
            $kl6 = $rowID['KL6_PROD'];

            $fm_ind1 = $rowID['FM1_PROD'];
            $fm_ind2 = $rowID['FM2_PROD'];
            $fm_ind3 = $rowID['FM3_PROD'];
            $fm_ind4 = $rowID['FM41_PROD'] + $rowID['FM42_PROD'];
            $fm_ind5 = $rowID['FM51_PROD'] + $rowID['FM52_PROD'];
            $fm_ind6 = $rowID['FM61_PROD'];
            $fm_dm = $rowID['FMDM_PROD'];

            $to_prod[$month] = array(
                "rm2" => number_format($rm2, 2, ".", ""),
                "rm3" => number_format($rm3, 2, ".", ""),
                "rm4" => number_format($rm4, 2, ".", ""),
                "rm5" => number_format($rm5, 2, ".", ""),
                "rm6" => number_format($rm6, 2, ".", ""),
                "kl2" => number_format($kl2, 2, ".", ""),
                "kl3" => number_format($kl3, 2, ".", ""),
                "kl4" => number_format($kl4, 2, ".", ""),
                "kl5" => number_format($kl5, 2, ".", ""),
                "kl6" => number_format($kl6, 2, ".", ""),
                "fm_ind1" => number_format($fm_ind1, 2, ".", ""),
                "fm_ind2" => number_format($fm_ind2, 2, ".", ""),
                "fm_ind3" => number_format($fm_ind3, 2, ".", ""),
                "fm_ind4" => number_format($fm_ind4, 2, ".", ""),
                "fm_ind5" => number_format($fm_ind5, 2, ".", ""),
                "fm_ind6" => number_format($fm_ind6, 2, ".", ""),
                "fm_dm" => number_format($fm_dm, 2, ".", "")
            );
        }

        $myJSON = array(
            "rkap" => $rkap,
            "prod" => $to_prod
        );
        echo '{"7000":' . json_encode($myJSON) . '}';
    }
    
    // <editor-fold defaultstate="collapsed" desc="PM Dashboard">
    function get_pm_dash() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
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

        $query = $db->query("SELECT
                                    TAHUN,
                                    PLANT,
                                    CATEGORY,
                                    ROUND ((AVG(DATA_INPUT)), 0) AS PERSEN
                            FROM
                                    MSO_PM_PERFORMANCE
                            WHERE
                                    COMPANY = 3000
                            AND TAHUN = $tahun
                            AND BULAN = '$bulan'
                            GROUP BY
                                    TAHUN,
                                    PLANT,
                                    CATEGORY
                            ORDER BY
                                    PLANT");
        foreach ($query->result_array() as $rowID) {
            $category = $rowID['CATEGORY'];
            $plant = $rowID['PLANT'];
            $percent = $rowID['PERSEN'];
            $tahun = $rowID['TAHUN'];

            $jml[$plant][$category] = array(
                'tahun' => $tahun,
                'persen' => $percent
            );
        }

        echo json_encode($jml);
    }

    function get_pm_detail() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
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
        if (!empty($_GET['plant'])) {
            $plant = $_GET['plant'];
        } else {
            $plant = 'ind2';
        }

        $query = $db->query("SELECT
                                    CATEGORY,
                                    EQUIPMENT,
                                    ROUND (DATA_INPUT, 0) AS DATA_INPUT
                            FROM
                                    MSO_PM_PERFORMANCE
                            WHERE
                                    COMPANY = 3000
                            AND TAHUN = $tahun
                            AND BULAN = '$bulan'
                            AND PLANT = '$plant'");
        foreach ($query->result_array() as $rowID) {
            $category = $rowID['CATEGORY'];
            $data = $rowID['DATA_INPUT'];
            $equipment = $rowID['EQUIPMENT'];

            $jml[$category][$equipment] = array(
                'data' => $data
            );
        }

        echo '{"' . $plant . '":' . json_encode($jml) . '}';
    }

    function get_pm_note() {
        header('Access-Control-Allow-Origin:*');
        $db = $this->load->database('oramso', true);
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
        if (!empty($_GET['plant'])) {
            $plant = $_GET['plant'];
        } else {
            $plant = 'ind2';
        }

        $query = $db->query("SELECT
                                    *
                            FROM
                                    MSO_PM_PERFORMANCE_NOTES
                            WHERE
                                    MONTH_PROD = '$tahun-$bulan'
                            AND PLANT = '$plant'
                            ORDER BY
                                    AREA");
        foreach ($query->result_array() as $rowID) {
            $plant = $rowID['PLANT'];
            $opco = $rowID['OPCO'];
            $area = $rowID['AREA'];
            $problem_id = $rowID['PROBLEM_ID'];
            $tgl = $rowID['TGL'];
            $equipment = $rowID['EQUIPMENT'];
            $problem_desc = $rowID['PROBLEM_DESC'];
            $duration = $rowID['DURATION'];
            $frequency = $rowID['FREQUENCY'];


            $jml[$area][$problem_id] = array(
                'plant' => $plant,
                'opco' => $opco,
                'tgl' => $tgl,
                'equipment' => $equipment,
                'problem_desc' => $problem_desc,
                'duration' => $duration,
                'frequency' => $frequency
            );
        }

        echo json_encode($jml);
    }

    // </editor-fold>

}
