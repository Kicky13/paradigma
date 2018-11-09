<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template {

    protected $_CI;

    function __construct() {
        $this->_CI = &get_instance();
    }

    function display($template, $data = null) {
        $data['_css'] = $this->_CI->load->view('template/css', $data, true);
        $data['_header'] = $this->_CI->load->view('template/header', $data, true);
        $data['_menu'] = $this->_CI->load->view('template/menu', $data, true);
        $data['_content'] = $this->_CI->load->view($template, $data, true);
        $data['_footer'] = $this->_CI->load->view('template/footer', $data, true);
        $data['_js'] = $this->_CI->load->view('template/js', $data, true);
        $this->_CI->load->view('template/main', $data);
    }

    function send_mail($data) {
        $hash = md5(uniqid(time()));

        $header = "From: " . $data['from_name'] . " <" . $data['from'] . ">\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"" . $hash . "\"\r\n\r\n";
        $header .= "Content-Type: multipart/alternative; boundary=\"" . $hash . "\"\r\n\r\n";
        $header .= "This is a multi-part message in MIME format.\r\n";
        $header .= "--" . $hash . "\r\n";
        $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $header .= $data['message'] . "\r\n\r\n";

        // Message is already in header
        return mail($data['to'], $data['subject'], "", $header);
    }

}
