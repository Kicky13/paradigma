<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ldap_access extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($username == "" and $password == "") {
            $this->load->view('admin/loginTemplate');
        } else {
            $set = $this->auth->GetLdapAccess($username, $password);
            if ($set == true) {
                header('Location: ' . base_url().'index.php/c_admin');
            } else {
                $load['error'] = '<div class="alert alert-danger" role="alert">Kesalahan Dalam Username dan Password / Tidak Memiliki Akses untuk Masuk kedalam applikasi</div>';
                $this->load->view('admin/loginTemplate', $load);
            }
        }
    }

    function access() {
        $this->load->library('Auth');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->auth->GetLdapAccess($username, $password);
    }

    function logout() {
        $this->auth->do_logout();
    }

}
