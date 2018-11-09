<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    header("Access-Control-Allow-Origin: *");

class finance_cash_projection extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model(array('m_cash_projection'));
    }

    public function index() {
    }

    public function get_data() {
        $year           = isset($_GET['year']) ? $_GET['year'] : null;
        $month          = isset($_GET['month']) ? $_GET['month'] : null;

        $listDay=array();
        for($d=1; $d<=31; $d++){
            $time=mktime(12, 0, 0, $month, $d, $year);          
            if (date('m', $time)==$month)       
                $listDay[]=date('Ymd', $time);
        }

        $all = $_GET['CUR'] == 'ALL' ? TRUE : FALSE;

        $id = 0;

        $allData=array();
        foreach ($listDay as $k => $tgl) {
            if ($_GET['COM'] == "1000") {
                foreach (array('Bank', 'Rencana Pembayaran Hutang', 'Rencana Penerimaan Piutang') as $k => $v) {
                    if ($k == 0) {
                        $amount = $this->m_cash_projection->get_sum_hsl_bank_t2_holding($tgl, $_GET['COM'], $_GET['CUR'], TRUE, FALSE);
                        echopre($amount);
                        exit;
                        $count = $this->m_cash_projection->get_sum_hsl_bank_t2_holding($tgl, $_GET['COM'], $_GET['CUR'], FALSE, TRUE);
                        $amount_finance = $this->m_cash_projection->get_sum_hsl_bank_t2_holding($tgl, $_GET['COM'], $_GET['CUR'], FALSE, FALSE, TRUE);
                    } elseif ($k == 1) {
                        $amount = $this->m_cash_projection->get_data_hutang($_GET['COM'], $_GET['CUR'], $tgl, TRUE, FALSE);
                        $count = $this->m_cash_projection->get_data_hutang($_GET['COM'], $_GET['CUR'], $tgl, FALSE, TRUE);
                        $amount_finance = $amount;
                    } elseif ($k == 2) {
                        $amount = $this->m_cash_projection->get_data_piutang($_GET['COM'], $_GET['CUR'], $tgl, TRUE, FALSE);
                        $count = $this->m_cash_projection->get_data_piutang($_GET['COM'], $_GET['CUR'], $tgl, FALSE, TRUE);
                        $amount_finance = $amount;
                    } else {
                        $amount = $count = $amount_finance = 0;
                    }
                    $ret[$k]['F1'] = $v . ' <a>[ ' . $count . ' ITEM\'S]</a>';
                    $ret[$k]['F6'] = $this->parser_amount($amount, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                    $ret[$k]['F7'] = $this->parser_amount($amount_finance, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                    $ret[$k]['F8'] = $this->parser_amount($amount, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                    $ret[$k]['F9'] = $this->parser_amount($amount_finance, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                    $ret[$k]['F10'] = $this->parser_amount($amount, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                    $ret[$k]['F11'] = $this->parser_amount($amount_finance, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                    $ret[$k]['F12'] = $this->parser_amount($amount, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                    $ret[$k]['F13'] = $this->parser_amount($amount_finance, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                    $ret[$k]['F14'] = $this->parser_amount($amount, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                    $ret[$k]['F15'] = $this->parser_amount($amount_finance, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                }
            } else {
                foreach (array('Bank', 'Rencana Pembayaran Hutang', 'Rencana Penerimaan Piutang') as $k => $v) {
                    if ($k == 0) {
                        $amount = $this->m_cash_projection->get_sum_hsl_bank_t2($tgl, $_GET['COM'], $_GET['CUR'], TRUE, FALSE);
                        $count = $this->m_cash_projection->get_sum_hsl_bank_t2($tgl, $_GET['COM'], $_GET['CUR'], FALSE, TRUE);
                        $amount_finance = $this->m_cash_projection->get_sum_hsl_bank_t2($tgl, $_GET['COM'], $_GET['CUR'], FALSE, FALSE, TRUE);
                    } elseif ($k == 1) {
                        $amount = $this->m_cash_projection->get_data_hutang($_GET['COM'], $_GET['CUR'], $tgl, TRUE, FALSE);
                        $count = $this->m_cash_projection->get_data_hutang($_GET['COM'], $_GET['CUR'], $tgl, FALSE, TRUE);
                        $amount_finance = $amount;
                    } elseif ($k == 2) {
                        $amount = $this->m_cash_projection->get_data_piutang($_GET['COM'], $_GET['CUR'], $tgl, TRUE, FALSE);
                        $count = $this->m_cash_projection->get_data_piutang($_GET['COM'], $_GET['CUR'], $tgl, FALSE, TRUE);
                        $amount_finance = $amount;
                    } else {
                        $amount = $count = $amount_finance = 0;
                    }
                    $ret[$k]['F1'] = $v . ' <a>[ ' . $count . ' ITEM\'S]</a>';
                    $ret[$k]['F3'] = $this->parser_amount($amount, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                    $ret[$k]['F5'] = $this->parser_amount($amount_finance, $_GET['CUR'] == 'ALL' ? 'IDR' : $_GET['CUR']);
                }
            }
            $allData[]=$ret;
        }
        echo json_encode($allData);
    }

    public function get_currency() {
        if (isset($_GET['ALL']))
            $ret[] = array('id' => 'ALL', 'text' => 'ALL', 'selected' => 'true');
        foreach ($this->m_cash_projection->get_company() as $k => $v)
            if ($v['CURR'] == 'IDR' && !isset($_GET['ALL']))
                $ret[] = array('id' => $v['CURR'], 'text' => $v['CURR'], 'selected' => 'true');
            else
                $ret[] = array('id' => $v['CURR'], 'text' => $v['CURR']);

        echo json_encode($ret);
    }

    public function get_company_real() {
        if ($_SESSION['company_hris'] == '2000') {
            $holding = isset($_GET['HOLDING']) ? TRUE : FALSE;
            $ret = $this->m_cash_projection->get_company_real(FALSE, $holding);
        } else {
            $ret = $this->m_cash_projection->get_company_real($_SESSION['company_hris']);
        }
        echo json_encode($ret);
    }

    public function get_company() {
        $data = $this->m_cash_projection->get_company2();
        echo json_encode($data);
    }

    public function parser_amount($dt, $cur) {
        $ret = substr($dt, 0, 1) == '-' ? '(' . number_format(substr($dt, 1), '0', '', '') . ')' : number_format($dt, '0', '', '');
        return $ret;
    }

    public function empty_val($pos, $id) {
        $ret['ID'] = 'T3-' . $pos[1] . '-' . $pos[2] . '--' . $id;
        $ret['F1'] = '<a style="color:red">EMPTY</a>';
        $ret['state'] = 'open';

        return array($ret);
    }

    public function dwn_tgl($comp, $curr, $start_date, $end_date) {
        $col1 = "bgcolor='#00DBFF'";
        $col2 = "bgcolor='#00A2FF'";
        $data = json_decode($this->session->userdata('data_proj_download'));

//        exit;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=CASHPROJECTION_" . $comp . ".xls");

        echo "
            <table border='1'>
                <tr>
                    <td width='120' bgcolor='#00F2FF'><b><center>DATE</center></b></td>
                    <td width='120' bgcolor='#00F2FF'><b><center>DAY</center></b></td>
                    <td width='250' bgcolor='#00F2FF'><b><center>AMOUNT</center></b></td>
                </tr>";

        foreach ($data as $k => $v) {
            echo "<tr>
                <td>" . $v->F1 . "</td>
                <td>" . $v->F2 . "</td>
                <td>" . $v->F3 . "</td>
            </tr>";
        }
        echo "</table>";
    }

    public function dwn_bank($comp, $curr, $start_date, $end_date) {
        $col1 = "bgcolor='#00DBFF'";
        $col2 = "bgcolor='#00A2FF'";
        $start_date = date("Ymd", strtotime($start_date));
        $end_date = date("Ymd", strtotime($end_date));
        $data = $this->m_cash_projection->get_bank($comp, $curr, $start_date, $end_date);

//        exit;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=CASHPROJECTION_PER_BANK_" . $comp . ".xls");

        echo "
            <table border='1'>
                <tr>
                    <td width='120' bgcolor='#00F2FF'><b><center>DATE</center></b></td>
                    <td width='150' bgcolor='#00F2FF'><b><center>REKENING</center></b></td>
                    <td width='800' bgcolor='#00F2FF'><b><center>DESCRIPTION</center></b></td>
                    <td width='200' bgcolor='#00F2FF'><b><center>AMOUNT</center></b></td>
                    <td width='120' bgcolor='#00F2FF'><b><center>CURRENCY</center></b></td>
                </tr>";

        foreach ($data as $k => $v) {
            echo "<tr>
                <td><center>" . $v->TANGGAL . "</center></td>
                <td><center>" . $v->REK . "</center></td>
                <td>" . $v->TEXT1 . "</td>
                <td>" . $v->SUM . "</td>
                <td><center>" . $v->RWCUR . "</center></td>
            </tr>";
        }
        echo "</table>";
    }

    public function dwn_hutang($comp, $curr, $start_date, $end_date) {
        $col1 = "bgcolor='#00DBFF'";
        $col2 = "bgcolor='#00A2FF'";
        $start_date = date("Ymd", strtotime($start_date));
        $end_date = date("Ymd", strtotime($end_date));
        $data = $this->m_cash_projection->get_hutang($comp, $curr, $start_date, $end_date);

//        exit;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=CASHPROJECTION_RENCANA_PEMBAYARAN_HUTANG_" . $comp . ".xls");

        echo "
            <table border='1'>
                <tr>
                    <td width='180' bgcolor='#00F2FF'><b><center>COLLECT DATE</center></b></td>
                    <td width='180' bgcolor='#00F2FF'><b><center>DUE DATE</center></b></td>
                    <td width='150' bgcolor='#00F2FF'><b><center>VENDOR NUMBER</center></b></td>
                    <td width='300' bgcolor='#00F2FF'><b><center>NAME</center></b></td>
                    <td width='150' bgcolor='#00F2FF'><b><center>AMOUNT</center></b></td>
                </tr>";

        foreach ($data as $k => $v) {
            echo "<tr>
                <td><center>" . date('Y F d', strtotime($v->DATECOL)) . "</center></td>
                <td><center>" . date('Y F d', strtotime($v->DEFAULT_DUE_DATE)) . "</center></td>
                <td><center>" . $v->LIFNR . "</center></td>
                <td>" . $v->NAME1 . "</td>
                <td>" . $v->DMBTR . "</td>
            </tr>";
        }
        echo "</table>";
    }

    public function dwn_piutang($comp, $curr, $start_date, $end_date) {
        $col1 = "bgcolor='#00DBFF'";
        $col2 = "bgcolor='#00A2FF'";
        $start_date = date("Ymd", strtotime($start_date));
        $end_date = date("Ymd", strtotime($end_date));
        $data = $this->m_cash_projection->get_piutang($comp, $curr, $start_date, $end_date);

//        exit;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=CASHPROJECTION_RENCANA_PENERIMAAN_PIUTANG_" . $comp . ".xls");

        echo "
            <table border='1'>
                <tr>
                    <td width='200' bgcolor='#00F2FF'><b><center>DOCUMENT DATE</center></b></td>
                    <td width='200' bgcolor='#00F2FF'><b><center>DUE DATE</center></b></td>
                    <td width='150' bgcolor='#00F2FF'><b><center>DOCUMENT NUMBER</center></b></td>
                    <td width='300' bgcolor='#00F2FF'><b><center>NAME</center></b></td>
                    <td width='150' bgcolor='#00F2FF'><b><center>AMOUNT</center></b></td>
                </tr>";

        foreach ($data as $k => $v) {
            echo "<tr>
                <td><center>" . date('Y F d', strtotime($v->DOCUMENT_DATE)) . "</center></td>
                <td><center>" . date('Y F d', strtotime($v->NET_DUE_DATE)) . "</center></td>
                <td><center>" . $v->ACCOUNTING_DOCUMENT_NUMBER . "</center></td>
                <td>" . $v->ITEM_TEXT . "</td>
                <td>" . $v->AMOUNT_LCL_2 . "</td>
            </tr>";
        }
        echo "</table>";
    }

    public function download_template() {
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        //-----------HEADER STYLE---------------//
        $fontHeader = array(
            'borders' => array('allborders' =>
                array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'),
                ),
            ),
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '00FDFF')
            )
        );

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
        //-----------END OF HEADER STYLE---------------//

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'COMPANY');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'GL ACCOUNT');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'TANGGAL');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'CURRENCY');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'NILAI');

        $objPHPExcel->getActiveSheet()->setCellValue('A2', '2000');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', '11121151');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', '20180517');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'IDR');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', '10000000');

        //STYLING
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($fontHeader);

        //TITLE SHEET
        $title = 'IMPORT BANK FINANCE';
        $objPHPExcel->getActiveSheet()->setTitle($title);

        $objPHPExcel->setActiveSheetIndex(0);

        $filename = 'TEMPLATE BANK FINANCE.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
    }

    public function import_data() {
        if (!empty($_SESSION['ID_USER'])) {

            $this->load->library('PHPExcel');

            if (substr($_FILES['data_bank']['name'], -3) == 'xls' && $_FILES['data_bank']['error'] == 0) {
                //if($_FILES['data_bank']['type'] == 'application/vnd.ms-excel') {

                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['data_bank']['tmp_name']);

                foreach ($objPHPExcel->getAllSheets() as $k => $v) {

                    if ($k == 0) { //SHEET 1 ONLY
                        $sheets = $v->getTitle();

                        $dt = $v->toArray();

                        unset($dt[0]);

                        $ADDITIONAL = '0';
                        $if_311 = FALSE;

                        foreach (array_values($dt) as $kk => $vv) {
                            //START INSERT
                            $sts = '';

                            $data['COMPANY'] = $vv[0];
                            $data['GL_ACCOUNT'] = $vv[1];
                            $data['BUDAT'] = $vv[2];
                            $data['RWCUR'] = $vv[3];
                            $data['AMOUNT'] = $vv[4];
                            $data['CREATE_BY'] = $this->session->userdata('ID_USER');
                            $data['STATUS'] = '1';

                            $cek_data = $this->m_cash_projection->cek_exist($data);

                            if ($cek_data == '0') {
                                $status = $this->m_cash_projection->insert_bank_finance($data);
                                if ($status)
                                    $sts = "Data Bank Finance Berhasil ditambahkan";
                            } else {
                                $data2['AMOUNT'] = $data['AMOUNT'];
                                $data2['UPDATE_BY'] = $data['CREATE_BY'];
                                $cond['COMPANY'] = $data['COMPANY'];
                                $cond['GL_ACCOUNT'] = $data['GL_ACCOUNT'];
                                $cond['BUDAT'] = $data['BUDAT'];
                                $cond['RWCUR'] = $data['RWCUR'];

                                $status = $this->m_cash_projection->update_bank_finance($data2, $cond);
                                if ($status)
                                    $sts = "Data Bank Finance Berhasil diupdate";
                            }

                            echo $sts;
                        }
                    }
                }
            } else {

                echo 'SOME ERROR IN THE FILE!';
            }
        } else {

            echo 'PLEASE RE-LOGIN';
        }
    }

}

?>