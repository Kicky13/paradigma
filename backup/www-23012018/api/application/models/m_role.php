<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_role extends CI_Model {

    function getListKaryawan(){
        $db = $this->load->database('default7', TRUE);

        $Query = $db->query("SELECT * FROM PAR4_USERLIST ORDER BY USERNAME");
        $Data = $Query->result_array();
        return $Data;
    }
    function getKaryawanRole($username){
        $db = $this->load->database('default7', TRUE);

        $Query = $db->query("SELECT * FROM PAR4_USERROLE WHERE USERNAME = '$username'");
        $Data = $Query->row_array();
        return $Data;
    
        # code...
    }

    function updateSuUser($name, $value){
        $db = $this->load->database('default7', TRUE);

        $sql = $db->query("UPDATE PAR4_USERLIST SET MENU_LEVEL ='$value' WHERE USERNAME = '$name' ");
        return $sql;
    }

    function updateRole($name, $values){
        $db = $this->load->database('default7', TRUE);
        $QueryIn =0;
        $QueryDel = $db->query("DELETE FROM PAR4_USERROLE WHERE USERNAME = '$name'");
        if ($QueryDel==1) {
           $QueryIn = $db->query("INSERT INTO PAR4_USERROLE VALUES ('$name' $values)");
        }
        

        // $Data = $Query->row_array();
        // return $Data;
        // 
        $var = array();
        if ($QueryDel==1 && $QueryIn==1) {
            return "success";
        }else if ($QueryDel!=1 && $QueryIn==1) {
            return "error 1";
        }else if ($QueryDel==1 && $QueryIn!=1) {
            return "error 2";
        }else if ($QueryDel!=1 && $QueryIn!=1) {
            return "error";
        }
        return false;
    }

    function dropColumn($data){
        $nama_column = $data['name'];
        $db = $this->load->database('default7', TRUE);
        $sql = "ALTER TABLE PAR4_USERROLE DROP COLUMN ".$nama_column;
        $query = $db->query($sql);
        return $query;
    }
    function addColumn($data){
        $nama_column = $data['name'];
        $default_column = $data['val'];

        $db = $this->load->database('default7', TRUE);
        $sql = "ALTER TABLE PAR4_USERROLE ADD ".$nama_column." varchar2(5) DEFAULT ".$default_column;
        $query = $db->query($sql);
        return $query;
    }

    function getHeaderRole(){
        $db = $this->load->database('default7', TRUE);

        $Query = $db->query("SELECT
                                COLUMN_NAME
                            FROM
                                ALL_TAB_COLUMNS
                            WHERE
                                TABLE_NAME = 'PAR4_USERROLE'
                            AND column_name NOT IN ('USERNAME')
        ");
        $Data = $Query->result_array();
        return $Data;
    }

    function getHeaderUser(){
        $db = $this->load->database('default7', TRUE);

        $Query = $db->query("SELECT
                                COLUMN_NAME
                            FROM
                                ALL_TAB_COLUMNS
                            WHERE
                                TABLE_NAME = 'PAR4_USERLIST'
                            AND column_name NOT IN ('ESELON', 'JABATAN', 'OPCO', 'EMAIL')");
        $Data = $Query->result_array();
        return $Data;
    }
    function getSearchKaryawan($param){

        $nama = strtolower($param['nama']);
        $nopeg = strtolower($param['nopeg']);
        $where = '';
        if ($nama) {
            $where = " WHERE USERNAME LIKE '%$nama%'" ;
        }
        if ($nopeg) {
            $where = " WHERE NOPEG LIKE '%$nopeg%'" ;
        }

        if ($nopeg && $nama) {
            $where = " WHERE NAME LIKE '%$nama%' OR NOPEG LIKE '%$nopeg%'" ;
        }

       
        $db = $this->load->database('default7', TRUE);

        $Query = $db->query("Select * from PAR4_USERLIST $where ORDER BY USERNAME ");
        // echo "Select * from PAR4_USERLIST $where ORDER BY USERNAME ";
        $Data = $Query->result_array();
        return $Data;
    }

    function initRoles(){
        $db = $this->load->database('default7', TRUE);

        $menu = array('PRODUCTION', 'SALES', 'SCM', 'FINANCE', 'PROJECT', 'INVENTORY', 'MAINTENANCE');

        $Query = $db->query("Select * from PAR4_USERLIST ORDER BY USERNAME");
        $Data = $Query->result_array();
       

        foreach ($Data as $key => $value) {
            echo "$key -> ".$value['MENU_LEVEL']."<br>";

           
            $sqlInit = "INSERT INTO PAR4_USERROLE VALUES ('".$value['USERNAME']."'";
            foreach ($menu as $key) {
                $sqlInit= $sqlInit.", '1'";
                 // $db->query($sqlInit);
            }
            $sqlInit = $sqlInit. " )";
             $db->query($sqlInit);

                
           
        }
        // return $Data;
    }
    function ListKaryawan($input) {
        $user_edit = $this->load->database('viewhris', TRUE);
        $user_list = $this->load->database('default7', TRUE);

        if (!empty($input['nama']) and empty($input['nopeg'])) {
            $Qhris = $user_edit->query("select a.mk_nama, a.mk_email, a.mk_nopeg, a.mk_eselon_code, a.company, a.mk_emp_subgroup from v_karyawan a where a.mk_nama like '%" . strtoupper($input['nama']) . "%' and  a.mjab_kode != '99999999' and a.mk_stat2 = 3");
        } else if (empty($input['nama']) and ! empty($input['nopeg'])) {
            $Qhris = $user_edit->query("select a.mk_nama, a.mk_email, a.mk_nopeg, a.mk_eselon_code, a.company, a.mk_emp_subgroup from v_karyawan a  where a.mk_nopeg like '%" . strtoupper($input['nopeg']) . "%' and  a.mjab_kode != '99999999' and a.mk_stat2 = 3");
        } else if (!empty($input['nama']) and ! empty($input['nopeg'])) {
            $Qhris = $user_edit->query("select a.mk_nama, a.mk_email, a.mk_nopeg, a.mk_eselon_code, a.company, a.mk_emp_subgroup from v_karyawan a where a.mk_nopeg like '%" . strtoupper($input['nopeg']) . "%' and a.mk_nama like '%" . strtoupper($input['nama']) . "%' and  a.mjab_kode != '99999999' and a.mk_stat2 = 3");
        } else {
            $Qhris = $user_edit->query("select a.mk_nama, a.mk_email, a.mk_nopeg, a.mk_eselon_code, a.company, a.mk_emp_subgroup from v_karyawan a where a.muk_kode='" . $input['unitkerja'] . "' and  a.mjab_kode != 99999999 and a.mk_stat2 = 3");
        }
        $data = $Qhris->result();
        $Query = $user_list->query("Select USERNAME, NAME, EMAIL, NOPEG, ESELON, OPCO, JABATAN, MENU_LEVEL from PAR4_USERLIST");
        $GetKar = $Query->result();
        foreach ($GetKar as $rows) {
            $Karlis[$rows->EMAIL] = $rows;
        }
        echo '<table class="table table-bordered" style="font-size:12px;">';
        echo '<tr>';
        echo '<th>Nopeg</th>';
        echo '<th>Nama</th>';
        echo '<th>Email</th>';
        echo '<th>Eselon</th>';
        echo '<th>Opco</th>';
        echo '<th>Kode Jabatan</th>';
        echo '</tr>';
        $i = 1;
        foreach ($data as $rows) {
            echo '<tr>';
            $matching = strtolower($rows->mk_email);
            if (empty($Karlis[$matching])) {
                echo "<td><button id='button" . $i . "' type='button' class='btn btn-warning' onclick='load_toform(" . $i . ")'><span id='a" . $i . "'>" . $rows->mk_nopeg . "</span></button></td>";
            } else {
                echo "<td><button type='button' class='btn btn-success disabled' ><span id='a" . $i . "'>" . $rows->mk_nopeg . "</span></button></td>";
            }
            echo "<td><span id='b" . $i . "'>" . $rows->mk_nama . "</span></td>";
            echo "<td><span id='c" . $i . "'>" . $rows->mk_email . "</span></td>";
            echo "<td><span id='d" . $i . "'>" . $rows->mk_eselon_code . "</span></td>";
            echo "<td><span id='e" . $i . "'>" . $rows->company . "</span></td>";
            echo "<td><span id='f" . $i . "'>" . $rows->mk_emp_subgroup . "</span></td>";
            echo '</tr>';
            $i++;
        }

        echo '</table>';
    }



    function SetKaryawabDaftar($input) {
        $user_edit = $this->load->database('default7', TRUE);

        $parts = explode("@", $input['email']);
        $username = $parts[0];

        $emp_numb = substr($input['nopeg'], -4);

        $user_edit->query("insert into PAR4_USERLIST "
                . "(USERNAME, NAME, EMAIL, NOPEG, ESELON, OPCO, JABATAN, MENU_LEVEL) "
                . "values('" . strtolower($username) . "',"
                . "'" . $input['nama'] . "','"
                . "" . strtolower($input['email']) . "',"
                . "'" . strtolower($emp_numb) . "',"
                . "'" . strtolower($input['eselon']) . "',"
                . "'" . strtolower($input['opco']) . "',"
                . "'" . strtolower($input['jabatan']) . "',"
                . "'" . strtolower($input['menu']) . "')");
        return true;
    }

    function ListKaryawanTerdaftar() {
        $user_edit = $this->load->database('default7', TRUE);
        $Query = $user_edit->query("Select NAME,USERNAME,EMAIL,NOPEG from PAR4_USERLIST ORDER BY USERNAME");
        $Data = $Query->result();
        foreach ($Data as $rows) {
            echo '<tr>';
            echo '<td>' . $rows->NAME . '</td>';
            echo '<td>' . $rows->USERNAME . '</td>';
            echo '<td>' . $rows->NOPEG . '</td>';
            echo '<td>' . $rows->EMAIL . '</td>';
            echo '<td><button type="button" class="btn btn-danger" onclick="delete_list(' . "'" . $rows->USERNAME . "'" . ')"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
            echo '</tr>';
        }
    }

    function HapusKaryawanTerdaftar($input) {
        $user_edit = $this->load->database('default7', TRUE);
        $Query = $user_edit->query("delete from PAR4_USERLIST where USERNAME = '" . $input . "'");
        return true;
    }

    function HitungKaryawanTerdaftar() {
        $user_edit = $this->load->database('default7', TRUE);
        $Query = $user_edit->query("SELECT COUNT(USERNAME) AS HITUNG FROM PAR4_USERLIST");
        
        foreach ($Query->result() as $rows) {
            $hitung = $rows->HITUNG;
        }
        echo json_encode($hitung);
    }
    
    function HitungSISITerdaftar() {
        $user_edit = $this->load->database('default7', TRUE);
        $Query = $user_edit->query("SELECT COUNT (USERNAME) AS SISI FROM PAR4_USERLIST WHERE NAME LIKE '%As SISI%'");
        
        foreach ($Query->result() as $rows) {
            $sisi = $rows->SISI;
        }
        echo json_encode($sisi);
    }

}
