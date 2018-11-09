<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class port_management extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_port_management');
    }

    public function get_data_port()
    {
        $this->load->model('m_port_management');
        $dstart = (empty($_GET['dstart']) ? date('d.m.Y') : $_GET['dstart']);
        $dfinish = (empty($_GET['dfinish']) ? date('d.m.Y') : $_GET['dfinish']);
        $dataport = $this->m_port_management->get_port_final($dstart, $dfinish);
        $pkk = $this->m_port_management->get_pkk_prot('1000001188');


        $i = 1;
        $tempPKK = "";
        $tempPelsandar = "";
        $tempKade = "";
        $kade = "";
        $tempNMKAPAL = "";
        $pesan = "";
        $pesanakhir = "";
        $jsondata = array();
        $NAMA_KAPAL = "";
        $idxsandar = -1;
//		 print_r(json_encode($dataport));
//		 exit;
        foreach ($dataport as $rows) {
            if ($rows->PKK != $tempPKK) {
                if ($rows->PEL_SANDAR != $tempPelsandar) {
                    $idxsandar++;
                }
                if ($rows->NM_KD != $tempKade) {
                    $kade = (strpos(strtolower($rows->NM_KD), "kade") !== false ? '' : 'Kade ') . ucwords(strtolower($rows->NM_KD));
                }

                $NAMA_KAPAL = (strpos(strtolower($rows->NM_KAPAL), "km") !== false ? "" : "Km. ") . ucwords(strtolower($rows->NM_KAPAL));
                $jsondata[$idxsandar][ucwords($rows->PEL_SANDAR)][$kade][$NAMA_KAPAL]['RENCANA_MUAT'] = number_format($rows->MUATAN, 0, ",", ".") . " MT";
                $jsondata[$idxsandar][ucwords($rows->PEL_SANDAR)][$kade][$NAMA_KAPAL]['TUJUAN'] = ucwords(strtolower($rows->PEL_TUJUAN));
                $jsondata[$idxsandar][ucwords($rows->PEL_SANDAR)][$kade][$NAMA_KAPAL]['PKK'] = ucwords(strtolower($rows->PKK));

                if ($rows->KEGIATAN == 1) {
                    $daftar = $this->convertMonthIndo(date_format(date_create(substr($rows->WAKTU_MULAI, 0, strrpos($rows->WAKTU_MULAI, ':', -1))), 'd F/H:i')) . " LT";
                    $jsondata[$idxsandar][ucwords($rows->PEL_SANDAR)][$kade][$NAMA_KAPAL]['DAFTAR'] = $daftar;
                }
            } else {
                if ($rows->KEGIATAN == 2) {
                    $labuh = $this->convertMonthIndo(date_format(date_create(substr($rows->WAKTU_MULAI, 0, strrpos($rows->WAKTU_MULAI, ':', -1))), 'd F/H:i')) . " LT";
                    $jsondata[$idxsandar][ucwords($rows->PEL_SANDAR)][$kade][$NAMA_KAPAL]['LABUH'] = $labuh;
                }

                if ($rows->KEGIATAN == 3) {
                    $sandar = $this->convertMonthIndo(date_format(date_create(substr($rows->WAKTU_MULAI, 0, strrpos($rows->WAKTU_MULAI, ':', -1))), 'd F/H:i')) . " LT";
                    $jsondata[$idxsandar][ucwords($rows->PEL_SANDAR)][$kade][$NAMA_KAPAL]['SANDAR'] = $sandar;
                }

                if ($rows->KEGIATAN == 4) {
                    $bongkar = $this->convertMonthIndo(date_format(date_create(substr($rows->WAKTU_MULAI, 0, strrpos($rows->WAKTU_MULAI, ':', -1))), 'd F/H:i')) . " LT";
                    $jsondata[$idxsandar][ucwords($rows->PEL_SANDAR)][$kade][$NAMA_KAPAL]['BONGKAR'] = $bongkar;
                    $timesheet = $this->m_port_management->get_pkk_prot($rows->PKK);

                    if (count($timesheet) > 0)
                        $jsondata[$idxsandar][ucwords($rows->PEL_SANDAR)][$kade][$NAMA_KAPAL]['TIMESHEET'] = $timesheet;
                    else
                        $jsondata[$idxsandar][ucwords($rows->PEL_SANDAR)][$kade][$NAMA_KAPAL]['TIMESHEET'] = 'TIMESHEET KOSONG';
                }

                if ($rows->KEGIATAN == 5) {
                    $tolak = $this->convertMonthIndo(date_format(date_create(substr($rows->WAKTU_MULAI, 0, strrpos($rows->WAKTU_MULAI, ':', -1))), 'd F/H:i')) . " LT";
                    $jsondata[$idxsandar][ucwords($rows->PEL_SANDAR)][$kade][$NAMA_KAPAL]['TOLAK'] = $tolak;
                }

                if ($rows->KEGIATAN == $rows->MAXKEGIATAN) {
                    $eta = $this->convertMonthIndo(date_format(date_create(substr($rows->ETA, 0, strrpos($rows->ETA, ':', -1))), 'd F/H:i')) . " LT";
                    $jsondata[$idxsandar][ucwords($rows->PEL_SANDAR)][$kade][$NAMA_KAPAL]['ETA'] = $eta;
                }

            }

            $i++;
            $tempPKK = $rows->PKK;
            $tempPelsandar = $rows->PEL_SANDAR;
            $tempKade = $rows->NM_KD;
            $tempNMKAPAL = $rows->NM_KAPAL;
        }
        $this->converttoJson($jsondata);
    }

    public function converttoJson($pesan)
    {
        $pesan = json_encode($pesan);
//        $pesan = str_replace("[", "", $pesan);
//        $pesan = str_replace("]", "", $pesan);
        print_r($pesan);
    }

    public function convertMonthIndo($string)
    {

        if (strpos(strtoupper($string), 'JANUARY') !== false) {
            $kembali = str_replace('JANUARY', 'Januari', strtoupper($string));
        } else if (strpos(strtoupper($string), 'FEBRUARY') !== false) {
            $kembali = str_replace('FEBRUARY', 'Februari', strtoupper($string));
        } else if (strpos(strtoupper($string), 'MARCH') !== false) {
            $kembali = str_replace('MARCH', 'Maret', strtoupper($string));
        } else if (strpos(strtoupper($string), 'APRIL') !== false) {
            $kembali = str_replace('APRIL', 'April', strtoupper($string));
        } else if (strpos(strtoupper($string), 'MAY') !== false) {
            $kembali = str_replace('MAY', 'Mei', strtoupper($string));
        } else if (strpos(strtoupper($string), 'JUNE') !== false) {
            $kembali = str_replace('JUNE', 'Juni', strtoupper($string));
        } else if (strpos(strtoupper($string), 'JULY') !== false) {
            $kembali = str_replace('JULY', 'Juli', strtoupper($string));
        } else if (strpos(strtoupper($string), 'AUGUST') !== false) {
            $kembali = str_replace('AUGUST', 'Agustus', strtoupper($string));
        } else if (strpos(strtoupper($string), 'SEPTEMBER') !== false) {
            $kembali = str_replace('SEPTEMBER', 'September', strtoupper($string));
        } else if (strpos(strtoupper($string), 'OCTOBER') !== false) {
            $kembali = str_replace('OCTOBER', 'Oktober', strtoupper($string));
        } else if (strpos(strtoupper($string), 'NOVEMBER') !== false) {
            $kembali = str_replace('NOVEMBER', 'November', strtoupper($string));
        } else if (strpos(strtoupper($string), 'DECEMBER') !== false) {
            $kembali = str_replace('DECEMBER', 'Desember', strtoupper($string));
        }

        $kembali = str_replace('S/D', 's/d', $kembali);
        return $kembali;
    }

}

/* End of file fin_cost.php */
/* Location: ./application/controllers/fin_cost.php */