<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class c_emailstock extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
    }

    public function index() {
        $this->load->helper('form');
        $this->load->view('emailstock/email_notif');
    }

    public function send_mail() {
        $from_email = "admin.par4digma@semenindonesia.com";
        $to_email = $this->input->post('email');

        //Load email library 
        $this->load->library('email');

        $this->email->from($from_email, 'Admin PAR4DIGMA');
        $this->email->to($to_email);
        $this->email->subject('Email Test');
        $this->email->message('Dear bapak,<br><br>Tes email untuk Early Warning, dari http://par4digma.semenindonesia.com/api <br>Regards,<br>Admin PAR4DIGMA');

        //Send mail 
        if ($this->email->send())
            $this->session->set_flashdata("email_sent", "Email sent successfully.");
        else
            $this->session->set_flashdata("email_sent", "Error in sending Email.");
        $this->load->view('emailstock/email_notif');
    }

    public function send() {

        $this->load->library('email');
        $subject = 'PAR4DIGMA - SCM  Stock Warning';
        $message = '<p>This message has been sent for testing purposes.</p>';

        // Get full html:
                $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
            <title>' . html_escape($subject) . '</title>
            <style type="text/css">
                body {
                    font-family: Arial, Verdana, Helvetica, sans-serif;
                    font-size: 16px;
                }
            </style>
        </head>
        <body>
        ' . $message . '
        </body>
        </html>';
        // Also, for getting full html you may use the following internal method:
        //$body = $this->email->full_html($subject, $message);

        $result = $this->email
                ->from('yourusername@gmail.com')
                ->reply_to('yoursecondemail@somedomain.com')    // Optional, an account where a human being reads.
                ->to('therecipient@otherdomain.com')
                ->subject($subject)
                ->message($body)
                ->send();

        var_dump($result);
        echo '<br />';
        echo $this->email->print_debugger();


        exit;
    }

}
