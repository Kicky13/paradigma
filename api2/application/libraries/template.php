<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Template {

    protected $_CI;

    function __construct() {
        $this->_CI = &get_instance();
    }

    function display($template, $data = null) {
        $data['_css'] = $this->_CI->load->view('template/css', $data,true);
        $data['_header'] = $this->_CI->load->view('template/header', $data,true);
        $data['_menu'] = $this->_CI->load->view('template/menu', $data,true);
        $data['_content'] = $this->_CI->load->view($template, $data,true);
        $data['_footer'] = $this->_CI->load->view('template/footer', $data,true);
        $data['_js'] = $this->_CI->load->view('template/js', $data,true);
        $this->_CI->load->view('template/main', $data);
    }
 
}