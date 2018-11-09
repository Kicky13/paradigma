<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_admin extends CI_Model {

    function ListKaryawan($input) {
        $user_edit = $this->load->database('viewhris', TRUE);
        $user_list = $this->load->database('default7', TRUE);

        if (!empty($input['nama']) and empty($input['nopeg'])) {
            $Qhris = $user_edit->query("select a.mk_nama, a.mk_email, a.mk_nopeg, a.mk_eselon_code, a.company, a.mk_emp_subgroup from v_karyawan a where a.mk_nama like '%" . strtoupper($input['nama']) . "%' and  a.mjab_kode != '99999999'");
        
        } else if (empty($input['nama']) and ! empty($input['nopeg'])) {
            $Qhris = $user_edit->query("select a.mk_nama, a.mk_email, a.mk_nopeg, a.mk_eselon_code, a.company, a.mk_emp_subgroup from v_karyawan a  where a.mk_nopeg like '%" . strtoupper($input['nopeg']) . "%' and  a.mjab_kode != '99999999'");
        } else if (!empty($input['nama']) and ! empty($input['nopeg'])) {
            $Qhris = $user_edit->query("select a.mk_nama, a.mk_email, a.mk_nopeg, a.mk_eselon_code, a.company, a.mk_emp_subgroup from v_karyawan a where a.mk_nopeg like '%" . strtoupper($input['nopeg']) . "%' and a.mk_nama like '%" . strtoupper($input['nama']) . "%' and  a.mjab_kode != '99999999'");
        } else {
            $Qhris = $user_edit->query("select a.mk_nama, a.mk_email, a.mk_nopeg, a.mk_eselon_code, a.company, a.mk_emp_subgroup from v_karyawan a where a.muk_kode='" . $input['unitkerja'] . "' and  a.mjab_kode != 99999999");
        }
        $data = $Qhris->result();
        
        $Query = $user_list->query("Select USERNAME, NAME, EMAIL, NOPEG, ESELON, OPCO, JABATAN, MENU_LEVEL from PAR4_USERLIST");
        $GetKar = $Query->result();
        foreach ($GetKar as $rows) {
            $Karlis[$rows->EMAIL] = $rows;
        }

        echo '<table class="table table-bordered search_result" style="font-size:12px;">';
        echo '<tr>';
        echo '<th style="width:10%; text-align:center;">Nopeg</th>';
        echo '<th style="width:30%">Nama</th>';
        echo '<th style="width:30%">Email</th>';
        echo '<th style="width:10%; text-align:center;">Eselon</th>';
        echo '<th style="width:10%; text-align:center;">Opco</th>';
        echo '<th style="width:10%; text-align:center;">Kode Jabatan</th>';
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
            echo "<td style='text-align:left'><span id='c" . $i . "'>" . $rows->mk_email . "</span></td>";
            echo "<td><span id='d" . $i . "'>" . $rows->mk_eselon_code . "</span></td>";
            echo "<td><span id='e" . $i . "'>" . $rows->company . "</span></td>";
            echo "<td align='center'><span id='f" . $i . "'>" . $rows->mk_emp_subgroup . "</span></td>";
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

        $user_edit->query("insert into PAR4_USERROLE (USERNAME) values ('" . strtolower($username) . "')");
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
            echo '<td><button type="button" class="btn btn-danger" onclick="delete_list(' . "'" . $rows->USERNAME . "'" . ')"><i class="fa fa-times" aria-hidden="true"></i></button><button type="button" class="btn btn-success" onclick="showModal(' . "'" . $rows->USERNAME . "'" . ')">role</button></td>';
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
        $Query = $user_edit->query("SELECT COUNT(USERNAME) AS HITUNG FROM PAR4_USERLIST WHERE USERNAME NOT IN ('helios.y', 'amin.erfandy', 'rahmady.liyantanto')");
        
        foreach ($Query->result() as $rows) {
            $hitung = $rows->HITUNG;
        }
        echo json_encode($hitung);
    }
    
    function ListActiveUser() {
        $user = $this->load->database('default7', TRUE);
        $Query = $user->query("SELECT NAME FROM PAR4_USERLIST WHERE ACTIVE_PAR='1'")->result_array();
        return $Query;
    }
    function TotalVisitUser() {
        $user = $this->load->database('default7', TRUE);
        $Query = $user->query("SELECT*FROM (SELECT NAME,VISIT_PAR AS TOTAL FROM PAR4_USERLIST ORDER BY VISIT_PAR DESC) WHERE ROWNUM<=5")->result_array();
        return $Query;
    }
    
    function ListActiveUser2() {
        $user = $this->load->database('default7', TRUE);
        $Query = $user->query("SELECT NAME FROM PAR4_USERLIST WHERE ACTIVE_BOD='1'")->result_array();
        return $Query;
    }
    function TotalVisitUser2() {
        $user = $this->load->database('default7', TRUE);
        $Query = $user->query("SELECT*FROM (SELECT NAME,VISIT_BOD AS TOTAL FROM PAR4_USERLIST ORDER BY VISIT_BOD DESC) WHERE ROWNUM<=5")->result_array();
        return $Query;
    }

}
