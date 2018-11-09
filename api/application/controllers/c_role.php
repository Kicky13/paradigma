<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class c_role extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->GetSesionLogin();
        $this->load->model('m_role');
    }

    public function index() {

        $this->load->view('/admin/edit_role');
    }
    function getKaryawan(){
       
        $data = $this->m_role->getListKaryawan();
        $list = array();
        foreach ($data as $key => $value) {
            $fetch = array();
            $lvldec = $value['MENU_LEVEL'];
            $lvlbin =(string) decbin($lvldec);
            $fetch['USERNAME'] = $value['USERNAME'];
            $fetch['NAME'] = $value['NAME'];
            $fetch['NOPEG'] = $value['NOPEG'];
            $fetch['UNLOCK'] = $value['MENU_LEVEL'];
            $fetch['val'] = $this->m_role->getKaryawanRole($value['USERNAME']);
            // echo "$lvldec-$lvlbin<br>";
            $list[$fetch['USERNAME']] = $fetch;
        }
        echo json_encode($list);
    }

    function GetActiveUser() {
        $this->load->model('m_admin');
        $data['active_user']['PAR4DIGMA'] = $this->m_admin->ListActiveUser();
        $data['most_visitor']['PAR4DIGMA'] = $this->m_admin->TotalVisitUser();
        $data['active_user']['BOD'] = $this->m_admin->ListActiveUser2();
        $data['most_visitor']['BOD'] = $this->m_admin->TotalVisitUser2();
        echo json_encode($data);
    }

    function searchKaryawan(){

        $input['nopeg'] = $this->input->post('nopeg');
        $input['nama'] = $this->input->post('nama');
       
        $data = $this->m_role->getSearchKaryawan($input);
        $list = array();
        foreach ($data as $key => $value) {
            $fetch = array();
            $lvldec = $value['MENU_LEVEL'];
            $lvlbin =(string) decbin($lvldec);
            $fetch['USERNAME'] = $value['USERNAME'];
            $fetch['NAME'] = $value['NAME'];
            $fetch['NOPEG'] = $value['NOPEG'];
            $fetch['UNLOCK'] = $value['MENU_LEVEL'];
            $fetch['val'] = $this->m_role->getKaryawanRole($value['USERNAME']);
            // echo "$lvldec-$lvlbin<br>";
            $list[$fetch['USERNAME']] = $fetch;
        }
        echo json_encode($list);
    }

    function roleList(){
        $dataR = $this->m_role->getHeaderRole();
        $tag = array();
        foreach ($dataR as $key => $value) {
            array_push($tag, $value['COLUMN_NAME']);
        }
        echo json_encode($tag);
    }

    function header(){
        $dataU = $this->m_role->getHeaderUser();
        $dataR = $this->m_role->getHeaderRole();
        $tag = array();
        foreach ($dataU as $key => $value) {
            // echo "$key -> $value";
            if ($value['COLUMN_NAME']=='MENU_LEVEL') {
                # code...
                array_push($tag, 'UNLOCK');
            }else{
                array_push($tag, $value['COLUMN_NAME']);
            }
            
        }
        foreach ($dataR as $key => $value) {
            // echo "$key -> $value";
            // if ($key!='USERNAME1' && $key!='ESELON' && $key!='MENU_LEVEL' && $key!='JABATAN' && $key!='OPCO' && $key!='EMAIL') {
                # code...
                array_push($tag, $value['COLUMN_NAME']);
            // }
            
        }
        echo json_encode($tag);
    }

    function newColumn(){
        $input['val'] = $this->input->post('value');
        $input['name'] = $this->input->post('name');
        $res = $this->m_role->addColumn($input);

        echo $res;
    }

    function dropColumn(){
        $input['name'] = $this->input->post('name');
        $res = $this->m_role->dropColumn($input);

        echo $res;
    }

    function updateRoles(){
        $json_request_body = file_get_contents('php://input');
        // echo $json_request_body;
        $file = json_decode($json_request_body);
        $nama = $file[0];
        $superuser = $file[1];
        $values = '';
        for ($i=2; $i < count($file)  ; $i++) { 
            $x = (string) $file[$i];
            $values = $values. ", '$x'";
        }

        $result['status'] = $this->m_role->updateRole($nama, $values);
        $result['su'] = $this->m_role->updateSuUser($nama, $superuser);

        echo json_encode($result);
        // echo "$values".count($file);
        // echo $json_request_body;
    }

    function initRoles(){
        $this->m_role->initRoles();
    }
}
