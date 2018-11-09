<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    header("Access-Control-Allow-Origin: *");

class finance_sales extends CI_Controller { 

    public function __construct() {
        parent::__construct();
        $this->load->model('m_finance_sales');
    }

    public function show_rev() {
        
        $time = $_GET['time'];
        $year = substr($time, 0, 4);
        $mon = substr($time, 5, 2);

        //SET PARAMETER
        foreach (range(2, 7) as $v)
            $param[1][$v . '000'] = $this->m_finance_sales->get_company_desc($v . '000');
        $param[2] = array('SEMEN' => 'CEMENT', 'TERAK' => 'CLINKER');
        $param[3] = array('PENJUALAN' => 'DALAM NEGERI', 'INTERCO' => 'ICS', 'EKS' => 'EKSPORT');
        $param[4] = array('F3' => array($time),
            'F4' => array(($year - 1) . '.' . $mon),
            'F6' => array($year . '.01', $year . '.' . $mon),
            'F7' => array(($year - 1) . '.01', ($year - 1) . '.' . $mon));
        $param[5] = array('F2' => array(($year) . '.' . $mon),
            'F5' => array(($year) . '.01', ($year + 1) . '.' . $mon));

        //GET DATA
        foreach ($param[1] as $k => $v) {
            foreach ($param[2] as $k2 => $v2) {
                foreach ($param[3] as $k3 => $v3) {
                    foreach ($param[4] as $k4 => $v4) {
                        $row[$k][$k2][$k3][$k4] = $this->m_finance_sales->get_dt_actual_rev(array('COMPANY' => $k, 'DES' => $k2, 'JENIS' => $k3, 'FISCAL_YEAR_PERIOD' => $v4));
                    }
                }
            }
        }

        foreach ($param[1] as $k => $v) {
            foreach ($param[2] as $k2 => $v2) {
                foreach ($param[5] as $k3 => $v3) {
                    $row[$k][$k2]['PENJUALAN'][$k3] = array_sum($this->m_finance_sales->get_dt_budgeting_rev(array('COMPANY' => $k, 'MATERIAL' => $k2, 'YEAR' => $v3)));
                    $row[$k][$k2]['INTERCO'][$k3] = 0;
                    $row[$k][$k2]['EKS'][$k3] = 0;
                }
            }
        }

        foreach ($param[1] as $k => $v) {
            foreach ($param[2] as $k2 => $v2) {
                foreach ($param[3] as $k3 => $v3) {
                    $row[$k][$k2][$k3]['F8'] = $row[$k][$k2][$k3]['F3'] && $row[$k][$k2][$k3]['F2'] ? ($row[$k][$k2][$k3]['F3'] / $row[$k][$k2][$k3]['F2']) : 0;
                    $row[$k][$k2][$k3]['F9'] = $row[$k][$k2][$k3]['F3'] && $row[$k][$k2][$k3]['F4'] ? ($row[$k][$k2][$k3]['F3'] / $row[$k][$k2][$k3]['F4']) : 0;
                    $row[$k][$k2][$k3]['F10'] = $row[$k][$k2][$k3]['F6'] && $row[$k][$k2][$k3]['F5'] ? ($row[$k][$k2][$k3]['F6'] / $row[$k][$k2][$k3]['F5']) : 0;
                    $row[$k][$k2][$k3]['F11'] = $row[$k][$k2][$k3]['F6'] && $row[$k][$k2][$k3]['F7'] ? ($row[$k][$k2][$k3]['F6'] / $row[$k][$k2][$k3]['F7']) : 0;
                }
            }
        }

        //START CLUSTRING
        foreach ($row as $k => $v)
            foreach ($v as $k2 => $v2)
                foreach ($v2 as $k3 => $v3)
                    foreach ($v3 as $k4 => $v4)
                        if ($_GET['typ'] == 'V1')
                            $cluster[$k2][$k][$k4][] = $v4;
                        elseif ($_GET['typ'] == 'V2')
                            $cluster[$k][$k2][$k4][] = $v4;
        foreach ($cluster as $k => $v)
            foreach ($v as $k2 => $v2)
                foreach ($v2 as $k3 => $v3)
                    $sum_cluster[$k][$k2][$k3] = array_sum($v3);

        foreach ($sum_cluster as $k => $v)
            foreach ($v as $k2 => $v2)
                foreach ($v2 as $k3 => $v3)
                    $cluster2[$k][$k3][] = $v3;
        foreach ($cluster2 as $k => $v)
            foreach ($v as $k2 => $v2)
                $sum_cluster2[$k][$k2] = array_sum($v2);

        //CHANGE TREE HIERARCHY
        if ($_GET['typ'] == 'V1') {
            $param1 = $param[2];
            $param2 = $param[1];
        } elseif ($_GET['typ'] == 'V2') {
            $param1 = $param[1];
            $param2 = $param[2];
        }

        //START MAKE TREE
        $id = 0;

        $ret[0]['ID'] = $id++;
        $ret[0]['F1'] = "<b><span class=\"change_lang_eng\">SALES RESULT</span><span class=\"change_lang_ina hidden\">HASIL PENJUALAN</span> (Rp Juta)</b>";
        $ret[1]['ID'] = $id++;
        $ret[1]['F1'] = "<b>Semen Indonesia</b>";
        $ret[1]['state'] = 'closed';

        $key = 1;
        $count2 = 0;
        foreach ($param1 as $k => $v) {

            $key2 = $count2++;

            $ret[$key]['children'][$key2]['ID'] = $id++;
            $ret[$key]['children'][$key2]['state'] = 'closed';

            if ($_GET['typ'] == 'V1')
                $ret[$key]['children'][$key2]['F1'] = $v;
            elseif ($_GET['typ'] == 'V2')
                $ret[$key]['children'][$key2]['F1'] = $k . ' - ' . $v;

            foreach (range(2, 11) as $v2)
                $ret[$key]['children'][$key2]['F' . $v2] = $this->num_format($sum_cluster2[$k]['F' . $v2]);

            $count3 = 0;
            foreach ($param2 as $k2 => $v2) {

                $key3 = $count3++;

                $ret[$key]['children'][$key2]['children'][$key3]['ID'] = $id++;
                $ret[$key]['children'][$key2]['children'][$key3]['state'] = 'closed';

                if ($_GET['typ'] == 'V1')
                    $ret[$key]['children'][$key2]['children'][$key3]['F1'] = $k2 . ' - ' . $v2;
                elseif ($_GET['typ'] == 'V2')
                    $ret[$key]['children'][$key2]['children'][$key3]['F1'] = $v2;

                foreach (range(2, 11) as $v2)
                    $ret[$key]['children'][$key2]['children'][$key3]['F' . $v2] = $this->num_format($sum_cluster[$k][$k2]['F' . $v2]);

                $count4 = 0;
                foreach ($param[3] as $k3 => $v3) {

                    $key4 = $count4++;

                    $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4]['ID'] = $id++;
                    $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4]['F1'] = $v3;

                    foreach ($param[4] as $k4 => $v4) {
                        if ($_GET['typ'] == 'V1')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4][$k4] = $this->num_format($row[$k2][$k][$k3][$k4]);
                        elseif ($_GET['typ'] == 'V2')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4][$k4] = $this->num_format($row[$k][$k2][$k3][$k4]);
                    }

                    foreach ($param[5] as $k4 => $v4) {
                        if ($_GET['typ'] == 'V1')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4][$k4] = $this->num_format($row[$k2][$k][$k3][$k4]);
                        elseif ($_GET['typ'] == 'V2')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4][$k4] = $this->num_format($row[$k][$k2][$k3][$k4]);
                    }

                    foreach (range(8, 11) as $v4) {
                        if ($_GET['typ'] == 'V1')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4]['F' . $v4] = $this->num_format($row[$k2][$k][$k3]['F' . $v4]);
                        elseif ($_GET['typ'] == 'V2')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4]['F' . $v4] = $this->num_format($row[$k][$k2][$k3]['F' . $v4]);
                    }
                }
            }
        }

        echo json_encode($ret);
    }

    public function show_vol($dwn = null) {
        
        $time = $_GET['time'];
        $year = substr($time, 0, 4);
        $mon = substr($time, 5, 2);

        //SET PARAMETER
        foreach (range(2, 7) as $v)
            $param[1][$v . '000'] = $this->m_finance_sales->get_company_desc($v . '000');
        $param[2] = array('SEMEN' => 'CEMENT', 'TERAK' => 'CLINKER');
        $param[3] = array('PENJUALAN' => 'DALAM NEGERI', 'INTERCO' => 'ICS', 'EKS' => 'EKSPORT');
        $param[4] = array('F3' => array($time),
            'F4' => array(($year - 1) . '.' . $mon),
            'F6' => array($year . '.01', $year . '.' . $mon),
            'F7' => array(($year - 1) . '.01', ($year - 1) . '.' . $mon));
        $param[5] = array('F2' => array(($year) . '.' . $mon),
            'F5' => array(($year) . '.01', ($year + 1) . '.' . $mon));

        //GET DATA
        foreach ($param[1] as $k => $v) {
            foreach ($param[2] as $k2 => $v2) {
                foreach ($param[3] as $k3 => $v3) {
                    foreach ($param[4] as $k4 => $v4) {
                        $row[$k][$k2][$k3][$k4] = $this->m_finance_sales->get_dt_actual_vol(array('COMPANY' => $k, 'DES' => $k2, 'JENIS' => $k3, 'FISCAL_YEAR_PERIOD' => $v4));
                    }
                }
            }
        }

        foreach ($param[1] as $k => $v) {
            foreach ($param[2] as $k2 => $v2) {
                foreach ($param[5] as $k3 => $v3) {
                    $row[$k][$k2]['PENJUALAN'][$k3] = array_sum($this->m_finance_sales->get_dt_budgeting_vol(array('COMPANY' => $k, 'MATERIAL' => $k2, 'YEAR' => $v3)));
                    $row[$k][$k2]['INTERCO'][$k3] = 0;
                    $row[$k][$k2]['EKS'][$k3] = 0;
                }
            }
        }

        foreach ($param[1] as $k => $v) {
            foreach ($param[2] as $k2 => $v2) {
                foreach ($param[3] as $k3 => $v3) {
                    $row[$k][$k2][$k3]['F8'] = $row[$k][$k2][$k3]['F3'] && $row[$k][$k2][$k3]['F2'] ? ($row[$k][$k2][$k3]['F3'] / $row[$k][$k2][$k3]['F2']) : 0;
                    $row[$k][$k2][$k3]['F9'] = $row[$k][$k2][$k3]['F3'] && $row[$k][$k2][$k3]['F4'] ? ($row[$k][$k2][$k3]['F3'] / $row[$k][$k2][$k3]['F4']) : 0;
                    $row[$k][$k2][$k3]['F10'] = $row[$k][$k2][$k3]['F6'] && $row[$k][$k2][$k3]['F5'] ? ($row[$k][$k2][$k3]['F6'] / $row[$k][$k2][$k3]['F5']) : 0;
                    $row[$k][$k2][$k3]['F11'] = $row[$k][$k2][$k3]['F6'] && $row[$k][$k2][$k3]['F7'] ? ($row[$k][$k2][$k3]['F6'] / $row[$k][$k2][$k3]['F7']) : 0;
                }
            }
        }

        //START CLUSTRING
        foreach ($row as $k => $v)
            foreach ($v as $k2 => $v2)
                foreach ($v2 as $k3 => $v3)
                    foreach ($v3 as $k4 => $v4)
                        if ($_GET['typ'] == 'V1')
                            $cluster[$k2][$k][$k4][] = $v4;
                        elseif ($_GET['typ'] == 'V2')
                            $cluster[$k][$k2][$k4][] = $v4;
        foreach ($cluster as $k => $v)
            foreach ($v as $k2 => $v2)
                foreach ($v2 as $k3 => $v3)
                    $sum_cluster[$k][$k2][$k3] = array_sum($v3);

        foreach ($sum_cluster as $k => $v)
            foreach ($v as $k2 => $v2)
                foreach ($v2 as $k3 => $v3)
                    $cluster2[$k][$k3][] = $v3;
        foreach ($cluster2 as $k => $v)
            foreach ($v as $k2 => $v2)
                $sum_cluster2[$k][$k2] = array_sum($v2);

        //CHANGE TREE HIERARCHY
        if ($_GET['typ'] == 'V1') {
            $param1 = $param[2];
            $param2 = $param[1];
        } elseif ($_GET['typ'] == 'V2') {
            $param1 = $param[1];
            $param2 = $param[2];
        }

        //START MAKE TREE
        $id = 0;
        $jdl = "<b>SALES RESULT (Rp million)</b>";
        if ($dwn == null) {
            $jdl = "<b><span class=\"change_lang_eng\">SALES RESULT</span><span class=\"change_lang_ina hidden\">HASIL PENJUALAN</span> (Rp Juta)</b>";
        }
        $ret[0]['ID'] = $id++;
        $ret[0]['F1'] = $jdl;
        $ret[1]['ID'] = $id++;
        $ret[1]['F1'] = "<b>Semen Indonesia</b>";
        $ret[1]['state'] = 'closed';

        $key = 1;
        $count2 = 0;
        foreach ($param1 as $k => $v) {

            $key2 = $count2++;

            $ret[$key]['children'][$key2]['ID'] = $id++;
            $ret[$key]['children'][$key2]['state'] = 'closed';

            if ($_GET['typ'] == 'V1')
                $ret[$key]['children'][$key2]['F1'] = $v;
            elseif ($_GET['typ'] == 'V2')
                $ret[$key]['children'][$key2]['F1'] = $k . ' - ' . $v;

            foreach (range(2, 11) as $v2)
                $ret[$key]['children'][$key2]['F' . $v2] = $this->num_format($sum_cluster2[$k]['F' . $v2]);

            $count3 = 0;
            foreach ($param2 as $k2 => $v2) {

                $key3 = $count3++;

                $ret[$key]['children'][$key2]['children'][$key3]['ID'] = $id++;
                $ret[$key]['children'][$key2]['children'][$key3]['state'] = 'closed';

                if ($_GET['typ'] == 'V1')
                    $ret[$key]['children'][$key2]['children'][$key3]['F1'] = $k2 . ' - ' . $v2;
                elseif ($_GET['typ'] == 'V2')
                    $ret[$key]['children'][$key2]['children'][$key3]['F1'] = $v2;

                foreach (range(2, 11) as $v2)
                    $ret[$key]['children'][$key2]['children'][$key3]['F' . $v2] = $this->num_format($sum_cluster[$k][$k2]['F' . $v2]);

                $count4 = 0;
                foreach ($param[3] as $k3 => $v3) {

                    $key4 = $count4++;

                    $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4]['ID'] = $id++;
                    $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4]['F1'] = $v3;

                    foreach ($param[4] as $k4 => $v4) {
                        if ($_GET['typ'] == 'V1')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4][$k4] = $this->num_format($row[$k2][$k][$k3][$k4]);
                        elseif ($_GET['typ'] == 'V2')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4][$k4] = $this->num_format($row[$k][$k2][$k3][$k4]);
                    }

                    foreach ($param[5] as $k4 => $v4) {
                        if ($_GET['typ'] == 'V1')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4][$k4] = $this->num_format($row[$k2][$k][$k3][$k4]);
                        elseif ($_GET['typ'] == 'V2')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4][$k4] = $this->num_format($row[$k][$k2][$k3][$k4]);
                    }

                    foreach (range(8, 11) as $v4) {
                        if ($_GET['typ'] == 'V1')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4]['F' . $v4] = $this->num_format($row[$k2][$k][$k3]['F' . $v4]);
                        elseif ($_GET['typ'] == 'V2')
                            $ret[$key]['children'][$key2]['children'][$key3]['children'][$key4]['F' . $v4] = $this->num_format($row[$k][$k2][$k3]['F' . $v4]);
                    }
                }
            }
        }

        echo json_encode($ret);
    }
    function num_format($dt) {
        return number_format($dt, 0, '.', '');
    }
}
