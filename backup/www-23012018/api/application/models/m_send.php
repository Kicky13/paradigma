<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_send extends CI_Model {

    function register($param){
        $db = $this->load->database('default7', TRUE);
        $name = $param['nama'];
        $register = $param['registeredId'];

        // $sql = "SELECT * FROM NOTIFICATION WHERE USERNAME = '$name'";

        // $check = $db->query($sql);

        // if ($check->num_rows()==0) {
            $sql = "INSERT INTO \"NOTIFICATION\" (\"id\", \"USERNAME\") VALUES ('$register', '$name')";
            $insert = $db->query($sql);

            
            // $data = array(
            //         'id' => $register,
            //         'USERNAME' => $name
            // );

            // $insert = $db->insert('NOTIFICATION', $data);
            if ($insert) {
                return 1;
            }else{
                return 0;
            }
        // }else{
        //     return 2;
        // }
    }

}
