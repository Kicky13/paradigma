<?php

header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class c_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->GetSesionLogin();
        $this->load->model('m_admin');
    }

    public function index() {
        $this->load->view('/admin/edit_user');
    }
    
    function GetKaryawan() {
        $this->load->model('m_admin');
        $input = $this->input->post('input');
        $this->m_admin->ListKaryawan($input);
    }

    function GetKaryawanTerdaftar() {
        $this->load->model('m_admin');
        $this->m_admin->ListKaryawanTerdaftar();
    }
    
    function HitungKaryawanTerdaftar() {
        $this->load->model('m_admin');
        $this->m_admin->HitungKaryawanTerdaftar();
    }

    function HapusUser() {
        $input = $this->input->post('ldapname');
        $this->load->model('m_admin');
        $this->m_admin->HapusKaryawanTerdaftar($input);
    }

    function SimpanUser() {
        $this->load->model('m_admin');
        $input['nopeg'] = $this->input->post('nopeg');
        $input['nama'] = $this->input->post('nama');
        $input['email'] = $this->input->post('email');
        $input['eselon'] = $this->input->post('eselon');
        $input['opco'] = $this->input->post('opco');
        $input['jabatan'] = $this->input->post('jabatan');
        $input['menu'] = $this->input->post('menu');
        $this->m_admin->SetKaryawabDaftar($input);
    }
}
