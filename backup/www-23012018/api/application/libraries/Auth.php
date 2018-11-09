<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth {

    var $CI = NULL;

    function __construct() {
        $this->CI = & get_instance();
    }

    function GetLdapAccess($username, $password) {
        $ldap_server = "10.15.3.121";
        $auth_user = $username;
        $domain = "@smig.corp";
        $auth_pass = $password;

        $par4digma = $this->CI->load->database('default7', TRUE);
        $Query = $par4digma->query("SELECT USERNAME, EMAIL, LDAP_FLAG, PASS_NOAD FROM PAR4_ADMIN WHERE USERNAME = '" . $username . "'");
        $result = $Query->row();

        if ($result->LDAP_FLAG == '1') {
            if ($auth_pass == $result->PASS_NOAD) {
                $ldap_id = array('ldap_id' => $username);
                $this->CI->session->set_userdata($ldap_id);
                return true;
            } else {
                die('<b style="font-size: 32px; text-align="center"> Cek Kembali Username atau Password Anda!</b>');
            }
        } else if ($result->LDAP_FLAG != '1') {
            $connect = @ldap_connect($ldap_server);

            if (!($bind = @ldap_bind($connect, $auth_user . $domain, $auth_pass))) {
                die('<b style="font-size: 32px; text-align="center"> Cek Kembali Username atau Password Anda!</b>');
            }

            if (!empty($result->USERNAME)) {
                $ldap_id = array('ldap_id' => $username);
                $this->CI->session->set_userdata($ldap_id);
                return true;
            } else {
                show_error('<p style="color:red;">Properties LDAP untuk user : ' . $username . '@semenindonesia.com </p> <p><b>Username anda belum terecord di database Applikasi Plant Information System. <br> Hub Administrator <br> Untuk Menambahkan Username Anda</b></p> <p><a href="' . base_url() . '">Back To Login<a></p>', 404, $heading = 'LDAP ERROR');
            }
        }
    }

    function GetSesionLogin() {
        $ldap_id = $this->CI->session->userdata('ldap_id');
        if (empty($ldap_id)) {
            header('Location: ' . base_url() . 'index.php/ldap_access');
        } else {
            return true;
        }
    }

    function do_logout() {
        $this->CI->session->sess_destroy();
        header('Location: ' . base_url());
    }

}
