<?php

class T_cement_hourly Extends DB_QM {

	public function datalist(){
		$this->db->order_by("a.ID_CEMENT_HOURLY");
		return $this->db->get("T_CEMENT_HOURLY a")->result();
	}

	public function search(&$keyword){
		$this->db->like("NM_CEMENT_HOURLY",$keyword);
		return $this->db->get("T_CEMENT_HOURLY")->result();
	}

	public function data($where){
		$this->db->where($where);
		return  $this->db->get("T_CEMENT_HOURLY")->row();
	}


	public function data_where($where){
		$this->db->select("a.*, to_char(DATE_DATA,'DD') AS TANGGAL");
		$this->db->where($where);
		$this->db->order_by('a.ID_CEMENT_HOURLY', 'asc');
		return  $this->db->get('T_CEMENT_HOURLY a')->result();
	}

	public function data_where_prod($where){
		$this->db->select("a.*, to_char(DATE_DATA,'DD') AS TANGGAL, b.KD_PRODUCT");
		$this->db->from('T_CEMENT_HOURLY a');
		$this->db->join('M_PRODUCT b', 'a.ID_PRODUCT = b.ID_PRODUCT', 'left');
		$this->db->where($where);
		$this->db->order_by('a.ID_PRODUCT', 'asc');
		$this->db->order_by('a.ID_CEMENT_HOURLY', 'asc');
		return  $this->db->get()->result();
	}

	public function get_id($ID_AREA,$ID_PRODUCT,$DATE_DATA,$JAM_DATA){
		return $this->exists($ID_AREA,$ID_PRODUCT,$DATE_DATA,$JAM_DATA)->ID_CEMENT_HOURLY;
	}

	public function get_nilai($arr_dt, $arr_ida='', $arr_idc='', $group=null){
		$this->db->select('a.ID_CEMENT_HOURLY, a.ID_AREA, b.ID_COMPONENT, e.KD_COMPONENT, e.NM_COMPONENT, b.NILAI, a.DATE_DATA');
		$this->db->select("CONCAT(d.NM_PLANT,CONCAT(' - ',c.KD_AREA)) AREA");
		$this->db->from('T_CEMENT_HOURLY a');
		$this->db->join('D_CEMENT_HOURLY b', 'b.ID_CEMENT_HOURLY=a.ID_CEMENT_HOURLY', 'left');
		$this->db->join('M_AREA c', 'a.ID_AREA=c.ID_AREA', 'left');
		$this->db->join('M_PLANT d', 'c.ID_PLANT=d.ID_PLANT', 'left');
		$this->db->join('M_COMPONENT e', 'b.ID_COMPONENT=e.ID_COMPONENT', 'left');
		$this->db->where("DATE_DATA >=", "TO_DATE('".$arr_dt[0]."','DD/MM/YYYY')", FALSE);
		$this->db->where("DATE_DATA <=", "TO_DATE('".$arr_dt[1]."','DD/MM/YYYY')", FALSE);
		$this->db->where_in('a.ID_AREA', $arr_ida);
		if($group==1) $this->db->where("a.ID_PRODUCT", $arr_idc[0]);
		$this->db->where_in('b.ID_COMPONENT', ($group==1) ? $arr_idc[1]:$arr_idc);
		$this->db->order_by('e.KD_COMPONENT', 'asc');
		#echo $this->db->get_compiled_select();exit();
		return $this->db->get()->result();
	}

	public function get_qtrend($arr_dt, $arr_ida='', $arr_idc='', $periode, $group=null){
		$range = ($group==1) ? "AND a.ID_PRODUCT=f.ID_PRODUCT":"";
		if ($periode=='D') {
			$this->db->select("a.ID_AREA, b.ID_COMPONENT, e.KD_COMPONENT, e.NM_COMPONENT, f.V_MIN, f.V_MAX");
			$this->db->select("ROUND(AVG(b.NILAI),2) AS NILAI");
			$this->db->select("CONCAT(d.NM_PLANT, CONCAT(' - ', c.KD_AREA)) AS AREA");
			$this->db->select("a.DATE_DATA AS PERIODE");
			$this->db->from("T_CEMENT_HOURLY a");
			$this->db->join('D_CEMENT_HOURLY b', 'b.ID_CEMENT_HOURLY=a.ID_CEMENT_HOURLY', 'left');
			$this->db->join('M_AREA c', 'a.ID_AREA=c.ID_AREA', 'left');
			$this->db->join('M_PLANT d', 'c.ID_PLANT=d.ID_PLANT', 'left');
			$this->db->join('M_COMPONENT e', 'b.ID_COMPONENT=e.ID_COMPONENT', 'left');
			$this->db->join('C_RANGE_QAF f', "b.ID_COMPONENT=f.ID_COMPONENT AND d.ID_COMPANY=f.ID_COMPANY $range AND f.V_MAX <= 999", 'left');
			$this->db->where("DATE_DATA >=", "TO_DATE('".$arr_dt[0]."','DD/MM/YYYY')", FALSE);
			$this->db->where("DATE_DATA <=", "TO_DATE('".$arr_dt[1]."','DD/MM/YYYY')", FALSE);
			$this->db->where_in('a.ID_AREA', $arr_ida);
			$this->db->where_in('f.ID_COMPONENT', $arr_idc[1]);
			if($group==1) $this->db->where("f.ID_PRODUCT", $arr_idc[0]);
			$this->db->group_by("a.ID_AREA");
			$this->db->group_by("b.ID_COMPONENT");
			$this->db->group_by("e.KD_COMPONENT");
			$this->db->group_by("e.NM_COMPONENT");
			$this->db->group_by("a.DATE_DATA");
			$this->db->group_by("CONCAT( d.NM_PLANT, CONCAT( ' - ', c.KD_AREA ))");
			$this->db->group_by("f.V_MIN");
			$this->db->group_by("f.V_MAX");
			$this->db->order_by("DATE_DATA", 'ASC');

		}elseif ($periode=='H') {
			$dt_start = explode(" ", $arr_dt[0]);
			$d_start  = $dt_start[0];
			$h_start  = ($dt_start[1]=='00') ? '24':$dt_start[1];

			$dt_end  = explode(" ", $arr_dt[1]);
			$d_end 	 = $dt_end[0];
			$h_end 	 = ($dt_end[1]=='00') ? '24':$dt_end[1];

			$this->db->select("a.ID_AREA, b.ID_COMPONENT, e.KD_COMPONENT, e.NM_COMPONENT, f.V_MIN, f.V_MAX");
			$this->db->select("ROUND(AVG(b.NILAI),2) AS NILAI");
			$this->db->select("CONCAT(d.NM_PLANT, CONCAT(' - ', c.KD_AREA)) AS AREA");
			$this->db->select("CONCAT(a.JAM_DATA, CONCAT(' - ', TO_CHAR(a.DATE_DATA,'dd/mm/yyyy'))) AS PERIODE");
			$this->db->select("a.JAM_DATA, a.DATE_DATA");
			$this->db->from("T_CEMENT_HOURLY a");
			$this->db->join('D_CEMENT_HOURLY b', 'b.ID_CEMENT_HOURLY=a.ID_CEMENT_HOURLY', 'left');
			$this->db->join('M_AREA c', 'a.ID_AREA=c.ID_AREA', 'left');
			$this->db->join('M_PLANT d', 'c.ID_PLANT=d.ID_PLANT', 'left');
			$this->db->join('M_COMPONENT e', 'b.ID_COMPONENT=e.ID_COMPONENT', 'left');
			$this->db->join('C_RANGE_QAF f', "b.ID_COMPONENT=f.ID_COMPONENT AND d.ID_COMPANY=f.ID_COMPANY $range AND f.V_MAX <= 999", 'left');
			$this->db->where("DATE_DATA >=", "TO_DATE('".$d_start."','DD/MM/YYYY')", FALSE);
			$this->db->where("JAM_DATA >=", $h_start, FALSE);
			$this->db->where("DATE_DATA <=", "TO_DATE('".$d_end."','DD/MM/YYYY')", FALSE);
			$this->db->where("JAM_DATA <=", $h_end, FALSE);
			$this->db->where_in('a.ID_AREA', $arr_ida);
			$this->db->where_in('b.ID_COMPONENT', $arr_idc[1]);
			if($group==1) $this->db->where("a.ID_PRODUCT", $arr_idc[0]);
			$this->db->group_by("a.ID_AREA");
			$this->db->group_by("b.ID_COMPONENT");
			$this->db->group_by("e.KD_COMPONENT");
			$this->db->group_by("e.NM_COMPONENT");
			$this->db->group_by("a.JAM_DATA, a.DATE_DATA");
			$this->db->group_by("CONCAT( d.NM_PLANT, CONCAT( ' - ', c.KD_AREA ))");
			$this->db->group_by("CONCAT(a.JAM_DATA, CONCAT(' - ', a.DATE_DATA))");
			$this->db->group_by("f.V_MIN");
			$this->db->group_by("f.V_MAX");
			$this->db->order_by("a.DATE_DATA", 'ASC');
			$this->db->order_by("a.JAM_DATA", 'ASC');
		}
		else{
			$this->db->select("a.ID_AREA, b.ID_COMPONENT, e.KD_COMPONENT, e.NM_COMPONENT, f.V_MIN, f.V_MAX");
			$this->db->select("ROUND(AVG(b.NILAI),2) AS NILAI");
			$this->db->select("a.JAM_DATA AS PERIODE");
			$this->db->select("CONCAT(d.NM_PLANT, CONCAT(' - ', c.KD_AREA)) AS AREA");
			$this->db->from("T_CEMENT_HOURLY a");
			$this->db->join('D_CEMENT_HOURLY b', 'b.ID_CEMENT_HOURLY=a.ID_CEMENT_HOURLY', 'left');
			$this->db->join('M_AREA c', 'a.ID_AREA=c.ID_AREA', 'left');
			$this->db->join('M_PLANT d', 'c.ID_PLANT=d.ID_PLANT', 'left');
			$this->db->join('M_COMPONENT e', 'b.ID_COMPONENT=e.ID_COMPONENT', 'left');
			$this->db->join('C_RANGE_QAF f', "b.ID_COMPONENT=f.ID_COMPONENT AND d.ID_COMPANY=f.ID_COMPANY $range AND f.V_MAX <= 999", 'left');
			$this->db->where("TO_CHAR(DATE_DATA, 'DD/MM/YYYY')=", $arr_dt);
			$this->db->where_in('a.ID_AREA', $arr_ida);
			$this->db->where_in('b.ID_COMPONENT', $arr_idc[1]);
			if($group==1) $this->db->where("a.ID_PRODUCT", $arr_idc[0]);
			$this->db->group_by("a.ID_AREA");
			$this->db->group_by("b.ID_COMPONENT");
			$this->db->group_by("e.KD_COMPONENT");
			$this->db->group_by("e.NM_COMPONENT");
			$this->db->group_by("a.JAM_DATA");
			$this->db->group_by("CONCAT( d.NM_PLANT, CONCAT( ' - ', c.KD_AREA ))");
			$this->db->group_by("f.V_MIN");
			$this->db->group_by("f.V_MAX");
			$this->db->order_by("JAM_DATA", 'ASC');
		}

		#echo $this->db->get_compiled_select();exit();
		return $this->db->get()->result();
	}

	public function exists($ID_AREA,$ID_PRODUCT,$DATE_DATA,$JAM_DATA){
		$this->db->where("ID_AREA", $ID_AREA);
		if ($ID_PRODUCT !='') $this->db->where("ID_PRODUCT", $ID_PRODUCT);
		$this->db->where("JAM_DATA", $JAM_DATA);
		$this->db->where("TO_CHAR(DATE_DATA,'DD/MM/YYYY')", "'$DATE_DATA'", FALSE);
		return $this->db->get("T_CEMENT_HOURLY")->row();
	}

	public function get_data_by_id($ID_CEMENT_HOURLY){
		$this->db->where("ID_CEMENT_HOURLY",$ID_CEMENT_HOURLY);
		return $this->db->get("T_CEMENT_HOURLY")->row();
	}

	public function data_except_id($where,$skip_id){
		$this->db->where("ID_CEMENT_HOURLY !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("T_CEMENT_HOURLY")->row();
	}

	public function insert($data){
		$this->db->select("SEQ_ID_CEMENT_HOURLY.NEXTVAL as DATAID",FALSE);
		$ID_CEMENT_HOURLY = $this->db->get("DUAL")->row()->DATAID;

		$this->db->set("ID_CEMENT_HOURLY",$ID_CEMENT_HOURLY);
		$this->db->set("ID_AREA",$data['ID_AREA']);
		$this->db->set("ID_PRODUCT",$data['ID_PRODUCT']);
		$this->db->set("ID_MESIN_STATUS",$data['ID_MESIN_STATUS']);
		$this->db->set("MESIN_REMARK",$data['MESIN_REMARK']);
		$this->db->set("DATE_DATA","to_date('".$data['DATE_DATA']."','dd/mm/yyyy')",FALSE);
		$this->db->set("JAM_DATA",$data['JAM_DATA']);
		$this->db->set("DATE_ENTRY","to_date('".$data['DATE_ENTRY']."','dd/mm/yyyy')",FALSE);
		$this->db->set("JAM_ENTRY",$data['JAM_ENTRY']);
		$this->db->set("USER_ENTRY",$data['USER_ENTRY']);

		$this->db->insert("T_CEMENT_HOURLY");
		return $ID_CEMENT_HOURLY;
	}

	public function update($data,$ID_CEMENT_HOURLY){
		$this->db->set("ID_MESIN_STATUS",$data['ID_MESIN_STATUS']);
		$this->db->set("MESIN_REMARK",$data['MESIN_REMARK']);
		$this->db->set("DATE_ENTRY","to_date('".$data['DATE_ENTRY']."','dd/mm/yyyy')",FALSE);
		$this->db->set("JAM_ENTRY",$data['JAM_ENTRY']);
		$this->db->set("USER_UPDATE",$data['USER_UPDATE']);

		$this->db->where("ID_CEMENT_HOURLY",$ID_CEMENT_HOURLY);
		$this->db->update("T_CEMENT_HOURLY");
	}

	public function delete($ID_CEMENT_HOURLY){
		$this->db->where("ID_CEMENT_HOURLY",$ID_CEMENT_HOURLY);
		$this->db->delete("T_CEMENT_HOURLY");
	}

	public function d_exists($data){
		$this->db->where("ID_CEMENT_HOURLY",$data[ID_CEMENT_HOURLY]);
		$this->db->where("ID_COMPONENT",$data[ID_COMPONENT]);
		return $this->db->get("D_CEMENT_HOURLY")->num_rows();
	}

	public function d_insert($data){
		$this->db->set($data);
		$this->db->insert("D_CEMENT_HOURLY");
	}

	public function d_update($data){
		$this->db->set("NILAI",$data['NILAI']);
		$this->db->set("NO_FIELD",$data['NO_FIELD']);
		$this->db->where("ID_CEMENT_HOURLY",$data[ID_CEMENT_HOURLY]);
		$this->db->where("ID_COMPONENT",$data[ID_COMPONENT]);
		$this->db->update("D_CEMENT_HOURLY");
	}


}
