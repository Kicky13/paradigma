<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Access Allowed');

class competitor extends CI_Controller {

    function __construct() {
       
        $this->load->model('M_competitor');
    }

    function index() {
        $data = array(
            'title' => 'Competitor Facility',
            'listperusahaan' => $this->ceklistPerusahaan(),
            'listfasilitas' => $this->ceklistFasilitas()
        );
        //$this->template->display('Competitor_view', $data);
    }
    
    function getData(){
        $data = $this->m_competitor->getDataFasilitas();
        $foto = $this->m_competitor->getFoto();
        $info = $this->m_competitor->getInfo();
        $perusahaan = $this->m_competitor->getPerusahaan();
		
        foreach($data as $key=>$value){
            $data[$key]['FOTO'] = array();
            foreach($foto as $f){
                if($value['ID'] == $f['ID_PRSH_FASILITAS']){
                    array_push($data[$key]['FOTO'], base_url()."upload/".$f['FOTO']);
                }
            }
            foreach($info as $inf){
                if($value['ID'] == $inf['ID_PRSH_FASILITAS']){
                    array_push($data[$key]['INFO'], $inf['INFO']);
                }
            }
			
        }
        echo json_encode($data);
    }

    function ceklistPerusahaan() {
        $data = $this->m_competitor->getPerusahaan();

        $jumlah = count($data);
        //$bagi = ceil($jumlah/2);

        $list = "<form id='fListPerusahaan'><ul class='list-group'><li class='list-group-item active'><input type='checkbox' style='margin-left: -2px;' id='checkAll' checked/>&nbsp;&nbsp; Check All/Uncheked All </li>";

        foreach ($data as $value) {
            $list .= "<li class='list-group-item'>";
            $list .= "<label class='checkbox-inline'>";
            $list .= "       <input id='cb".$value['KODE_PERUSAHAAN']."' type='checkbox' value='" . $value['KODE_PERUSAHAAN'] . "' checked>";
            $list .= $value['NAMA_PERUSAHAAN'];
            $list .= "</label>";
            $list .= "</li>";
        }

        $list .= "</ul></form>";

        return $list;
    }

    function ceklistFasilitas() {
        $data = $this->m_competitor->getFasilitas();

        //$jumlah = count($data);
        //$bagi = ceil($jumlah/2);

        $list = "<form id='fListFasilitas'><ul class='list-group'><li class='list-group-item active'><input type='checkbox' style='margin-left: -2px;' id='checkAlls' checked/>&nbsp;&nbsp;Check All/Uncheked All</li>";

        foreach ($data as $value) {
            $list .= "<li class='list-group-item'>";
            $list .= "<label class='checkbox-inline'>";
            $list .= "       <input id='cbf".$value['ID']."' type='checkbox' value='" . $value['ID'] . "' checked>";
            $list .= $value['NAMA'];
            $list .= "</label>";
            $list .= "</li>";
        }

        $list .= "</ul></form>";

        return $list;
    }
    
    function ceklistPropinsi() {
        $data = $this->m_competitor->getFasilitas();

        //$jumlah = count($data);
        //$bagi = ceil($jumlah/2);

        $list = "<form id='fListFasilitas'><ul class='list-group'><li class='list-group-item active'>PILIH FASILITAS</li><input type='checkbox' style='margin-left: 15px;' id='checkAlls' checked/>";

        foreach ($data as $value) {
            $list .= "<li class='list-group-item'>";
            $list .= "<label class='checkbox-inline'>";
            $list .= "       <input id='cbf".$value['ID']."' type='checkbox' value='" . $value['ID'] . "' checked>";
            $list .= $value['NAMA'];
            $list .= "</label>";
            $list .= "</li>";
        }

        $list .= "</ul></form>";

        return $list;
    }
    function getdataPerusahaan(){
		$result_perusahaan = $this->m_competitor->getDataSemua();
		$i = 1;
		foreach ($result_perusahaan as $key => $value) {
		$data[$i] = array(
	'kode_perusahaan' => $value->KODE_PERUSAHAAN,
	'nama_perusahaan' => $value->NAMA_PERUSAHAAN,
	'fasilitas' => $value->FASILITAS,
	'nama_fasilitas' => $value->NAMA_FASILITAS
	);
	$i++;
	}	
	echo json_encode($data);
	}
}