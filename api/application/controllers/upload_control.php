<?php
header('Access-Control-Allow-Origin: *');

class upload_control extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function uploadFile()
    {
        $text = $this->input->post('text');
        $task = $this->input->post('task');
        $folder = $this->input->post('folder');
        $date = Date('Y-m-d');
        $fname = $task . '_' . $date . ".json";//generates random name
        $url = $_SERVER['DOCUMENT_ROOT'] . "/dev/par4digma/jsonReport/" . $folder . "/" . $fname;

        $file = fopen($url, 'w');
        fwrite($file, $text);
        fclose($file);
        echo 'done';
    }
}