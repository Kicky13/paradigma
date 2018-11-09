<?php

class M_Opco Extends DB_QM {

    public function datalist() {
        $this->db->select("a.*,b.NM_AREA,c.NM_PLANT,d.NM_COMPANY");
        $this->db->join("M_AREA b", "a.ID_AREA=b.ID_AREA");
        $this->db->join("M_PLANT c", "b.ID_PLANT=c.ID_PLANT");
        $this->db->join("M_COMPANY d", "c.ID_COMPANY=d.ID_COMPANY");
        $this->db->where("a.DELETED", "0");
        $this->db->order_by("a.ID_OPCO");
        return $this->db->get("M_OPCO a")->result();
    }

    public function list_jabatan() {
        $this->db->where("a.KD_OPCO !=", "2000");
        $this->db->order_by("a.ID_OPCO");
        return $this->db->get("M_OPCO a")->result();
    }

    public function list_jabatan_auth($ID_OPCO = null) {
        $this->db->where("a.KD_OPCO !=", "2000");
        if ($ID_OPCO)
            $this->db->where("a.ID_OPCO", $ID_OPCO);
        $this->db->order_by("a.ID_OPCO");
        return $this->db->get("M_OPCO a")->result();
    }

    public function search(&$keyword) {
        $this->db->like("NM_OPCO", $keyword);
        return $this->db->get("M_OPCO")->result();
    }

    public function data($where) {
        $this->db->where($where);
        return $this->db->get("M_OPCO")->row();
    }

    public function get_data_by_id($ID_OPCO) {
        $this->db->select("a.*,b.ID_PLANT,c.ID_COMPANY,d.ID_GROUPAREA");
        $this->db->join("M_AREA b", "a.ID_AREA=b.ID_AREA");
        $this->db->join("M_PLANT c", "b.ID_PLANT=c.ID_PLANT");
        $this->db->join("M_GROUPAREA d", "b.ID_GROUPAREA=d.ID_GROUPAREA");
        $this->db->where("a.ID_OPCO", $ID_OPCO);
        $this->db->where("a.DELETED", "0");
        return $this->db->get("M_OPCO a")->row();
    }

    public function data_except_id($where, $skip_id) {
        $this->db->where("ID_OPCO !=", $skip_id);
        $this->db->where($where);
        return $this->db->get("M_OPCO")->row();
    }

    public function insert($data) {
        $this->db->set($data);
        $this->db->set("ID_OPCO", "SEQ_ID_OPCO.NEXTVAL", FALSE);
        $this->db->insert("M_OPCO");
    }

    public function update($data, $ID_OPCO) {
        $this->db->set($data);
        $this->db->where("ID_OPCO", $ID_OPCO);
        $this->db->where("DELETED", "0");
        $this->db->update("M_OPCO");
    }

    public function delete($ID_OPCO) {
        $this->db->set("DELETED", "1");
        $this->db->where("ID_OPCO", $ID_OPCO);
        $this->db->where("DELETED", "0");
        $this->db->update("M_OPCO");
    }

    public function notification_member($ID_AREA, $ID_JABATAN) {
        $this->db->select("d.NM_COMPANY, c.NM_PLANT, b.NM_AREA, e.NM_JABATAN, a.*");
        $this->db->join("M_AREA b", "a.ID_AREA=b.ID_AREA");
        $this->db->join("M_PLANT c", "b.ID_PLANT=c.ID_PLANT");
        $this->db->join("M_COMPANY d", "c.ID_COMPANY=d.ID_COMPANY");
        $this->db->join("M_JABATAN e", "a.ID_JABATAN=e.ID_JABATAN");
        $this->db->where("a.ID_AREA", $ID_AREA);
        $this->db->where("a.DELETED", "0");
        $this->db->where("a.ID_JABATAN", $ID_JABATAN);
        return $this->db->get("m_opco a")->result();
    }

}
