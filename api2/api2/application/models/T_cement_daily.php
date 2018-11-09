<?php defined('BASEPATH') OR exit('No direct script access allowed');

class T_cement_daily Extends DB_QM {

	public function cek(){
		return "string";
	}

	public function table($MONTH,$ID_AREA){
		$this->db->select("to_char(a.DATE_DATA,'FXFMDD') AS DATE_DATA, b.ID_COMPONENT, b.NILAI, c.NM_MESIN_STATUS, a.MESIN_REMARK");
		$this->db->select("a.DATE_DATA, a.DATE_ENTRY, d.USERNAME as USER_ENTRY, e.USERNAME as USER_UPDATE");
		$this->db->join("D_CEMENT_DAILY b","a.ID_CEMENT_DAILY=b.ID_CEMENT_DAILY","LEFT");
		$this->db->join("M_MESIN_STATUS c","a.ID_MESIN_STATUS=c.ID_MESIN_STATUS","LEFT");
		$this->db->join("M_USERS d","a.USER_ENTRY=d.ID_USER","LEFT");
		$this->db->join("M_USERS e","a.USER_UPDATE=e.ID_USER","LEFT");
		$this->db->where("a.ID_AREA",$ID_AREA);
		$this->db->where("to_char(a.DATE_DATA,'MM/YYYY')",$MONTH,FALSE);
		$this->db->order_by("a.ID_CEMENT_DAILY","ASC",FALSE);
		$this->db->order_by("b.NO_FIELD","ASC");
		$q = $this->db->get("T_CEMENT_DAILY a");# echo $this->db->last_query();
		return $q->result();
	}

	public function datalist(){
		$this->db->order_by("a.ID_CEMENT_DAILY");
		return $this->db->get("T_CEMENT_DAILY a")->result();
	}

	public function search(&$keyword){
		$this->db->like("NM_CEMENT_DAILY",$keyword);
		return $this->db->get("T_CEMENT_DAILY")->result();
	}

	public function data($where){
		$this->db->where($where);
		return  $this->db->get("T_CEMENT_DAILY")->row();
	}


	public function data_where($where){
		$this->db->select("a.*, to_char(DATE_DATA,'DD') AS TANGGAL");
		$this->db->where($where);
		$this->db->order_by('a.ID_CEMENT_DAILY', 'asc');
		return  $this->db->get('T_CEMENT_DAILY a')->result();
	}

	public function data_where_prod($where){
		$this->db->select("a.*, to_char(DATE_DATA,'DD') AS TANGGAL, b.KD_PRODUCT");
		$this->db->from('T_CEMENT_DAILY a');
		$this->db->join('M_PRODUCT b', 'a.ID_PRODUCT = b.ID_PRODUCT', 'left');
		$this->db->where($where);
		$this->db->order_by('a.ID_PRODUCT', 'asc');
		$this->db->order_by('a.ID_CEMENT_DAILY', 'asc');#echo $this->db->get_compiled_select();exit();
		return  $this->db->get()->result();
	}

	public function get_id($ID_AREA,$ID_PRODUCT,$DATE_DATA){
		return $this->exists($ID_AREA, $ID_PRODUCT, $DATE_DATA)->ID_CEMENT_DAILY;
	}

	public function get_nilai($arr_dt, $arr_ida='', $arr_idc='', $group=null){
		//echo "TO_DATE('".$arr_dt[0]."','DD/MM/YYYY')";exit();
		$this->db->select('a.ID_CEMENT_DAILY, a.ID_AREA, b.ID_COMPONENT, e.KD_COMPONENT, e.NM_COMPONENT, b.NILAI, a.DATE_DATA');
		$this->db->select("CONCAT(d.NM_PLANT,CONCAT(' - ',c.KD_AREA)) AREA");
		$this->db->from('T_CEMENT_DAILY a');
		$this->db->join('D_CEMENT_DAILY b', 'b.ID_CEMENT_DAILY=a.ID_CEMENT_DAILY', 'left');
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
		$this->db->select("a.ID_AREA, b.ID_COMPONENT, e.KD_COMPONENT, e.NM_COMPONENT, f.V_MAX, f.V_MIN");
		$this->db->select("ROUND(AVG(b.NILAI),2) AS NILAI");
		if($periode=="Y"){
			$this->db->select("TO_CHAR(TO_DATE(a.DATE_DATA, 'DD/MM/YYYY'), 'Month') AS PERIODE");
			$this->db->select("TO_CHAR(TO_DATE(a.DATE_DATA, 'DD/MM/YYYY'), 'MM') AS URUT");
		}elseif ($periode=="M") {
			$this->db->select("TO_CHAR(a.DATE_DATA, 'DD') AS PERIODE");
			$this->db->select("TO_CHAR(a.DATE_DATA, 'DD') AS URUT");
		}

		$this->db->select("CONCAT(d.NM_PLANT, CONCAT(' - ', c.KD_AREA)) AS AREA");
		$this->db->from("T_CEMENT_DAILY a");
		$this->db->join('D_CEMENT_DAILY b', 'b.ID_CEMENT_DAILY=a.ID_CEMENT_DAILY', 'left');
		$this->db->join('M_AREA c', 'a.ID_AREA=c.ID_AREA', 'left');
		$this->db->join('M_PLANT d', 'c.ID_PLANT=d.ID_PLANT', 'left');
		$this->db->join('M_COMPONENT e', 'b.ID_COMPONENT=e.ID_COMPONENT', 'left');
		$this->db->join('C_RANGE_QAF f', 'e.ID_COMPONENT=f.ID_COMPONENT AND c.ID_GROUPAREA=f.ID_GROUPAREA AND d.ID_COMPANY = f.ID_COMPANY AND a.ID_PRODUCT = f.ID_PRODUCT AND f.V_MAX <= 999', 'left');
		if($periode=="Y"){
			$date = explode("/", $arr_dt);
			$date = end($date);
			$this->db->where("TO_CHAR(DATE_DATA, 'YYYY')=", $date);
		}elseif ($periode=="M") {
			$date = explode("/", $arr_dt);
			$date = $date[1]."/".$date[2];
			$this->db->where("TO_CHAR(DATE_DATA, 'MM/YYYY')=", $date);
		}

		$this->db->where_in('a.ID_AREA', $arr_ida);
		$this->db->where_in('f.ID_COMPONENT', $arr_idc[1]);
		#$this->db->where('d.ID_COMPANY=f.ID_COMPANY');
		#$this->db->where('a.ID_PRODUCT=f.ID_PRODUCT');
		if($group==1) $this->db->where("a.ID_PRODUCT", $arr_idc[0]);
		$this->db->group_by("a.ID_AREA");
		$this->db->group_by("b.ID_COMPONENT");
		$this->db->group_by("e.KD_COMPONENT");
		$this->db->group_by("e.NM_COMPONENT");
		$this->db->group_by("f.V_MAX");
		$this->db->group_by("f.V_MIN");
		if($periode=="Y"){
			$this->db->group_by("TO_CHAR(TO_DATE(a.DATE_DATA, 'DD/MM/YYYY'), 'Month')");
			$this->db->group_by("TO_CHAR(TO_DATE(a.DATE_DATA, 'DD/MM/YYYY'), 'MM')");
		}elseif ($periode=="M") {
			$this->db->group_by("TO_CHAR(a.DATE_DATA, 'DD')");
		}

		$this->db->group_by("CONCAT( d.NM_PLANT, CONCAT( ' - ', c.KD_AREA ))");
		$this->db->order_by("URUT", 'ASC');
		//echo $this->db->get_compiled_select();exit();
		return $this->db->get()->result();
	}

	public function exists($ID_AREA, $ID_PRODUCT, $DATE_DATA){
		if ($ID_PRODUCT !='') $this->db->where("ID_PRODUCT", $ID_PRODUCT);
		$this->db->where("ID_AREA", $ID_AREA);
		$this->db->where("TO_CHAR(DATE_DATA,'DD/MM/YYYY')", "'$DATE_DATA'", FALSE);
		return $this->db->get("T_CEMENT_DAILY")->row();
	}

	public function get_data_by_id($ID_CEMENT_DAILY){
		$this->db->where("ID_CEMENT_DAILY",$ID_CEMENT_DAILY);
		return $this->db->get("T_CEMENT_DAILY")->row();
	}

	public function data_except_id($where,$skip_id){
		$this->db->where("ID_CEMENT_DAILY !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("T_CEMENT_DAILY")->row();
	}

	public function insert($data){
		$this->db->select("SEQ_ID_CEMENT_DAILY.NEXTVAL as DATAID",FALSE);
		$ID_CEMENT_DAILY = $this->db->get("DUAL")->row()->DATAID;

		$this->db->set("ID_CEMENT_DAILY",$ID_CEMENT_DAILY);
		$this->db->set("ID_AREA",$data['ID_AREA']);
		$this->db->set("ID_PRODUCT",$data['ID_PRODUCT']);
		$this->db->set("ID_MESIN_STATUS",$data['ID_MESIN_STATUS']);
		$this->db->set("MESIN_REMARK",$data['MESIN_REMARK']);
		$this->db->set("DATE_DATA","to_date('".$data['DATE_DATA']."','dd/mm/yyyy')",FALSE);
		$this->db->set("DATE_ENTRY","to_date('".$data['DATE_ENTRY']."','dd/mm/yyyy')",FALSE);
		$this->db->set("USER_ENTRY",$data['USER_ENTRY']);

		$this->db->insert("T_CEMENT_DAILY");
		return $ID_CEMENT_DAILY;
	}

	public function update($data,$ID_CEMENT_DAILY){
		$this->db->set("ID_MESIN_STATUS",$data['ID_MESIN_STATUS']);
		$this->db->set("MESIN_REMARK",$data['MESIN_REMARK']);
		$this->db->set("DATE_ENTRY","to_date('".$data['DATE_ENTRY']."','dd/mm/yyyy')",FALSE);
		$this->db->set("USER_UPDATE",$data['USER_UPDATE']);

		$this->db->where("ID_CEMENT_DAILY",$ID_CEMENT_DAILY);
		$this->db->update("T_CEMENT_DAILY");
	}

	public function delete($ID_CEMENT_DAILY){
		$this->db->where("ID_CEMENT_DAILY",$ID_CEMENT_DAILY);
		$this->db->delete("T_CEMENT_DAILY");
	}

	public function d_exists($data){
		$this->db->where("ID_CEMENT_DAILY",$data[ID_CEMENT_DAILY]);
		$this->db->where("ID_COMPONENT",$data[ID_COMPONENT]);
		return $this->db->get("D_CEMENT_DAILY")->num_rows();
	}

	public function d_insert($data){
		$this->db->set($data);
		$this->db->insert("D_CEMENT_DAILY");
	}

	public function d_update($data){
		$this->db->set("NILAI",$data['NILAI']);
		$this->db->set("NO_FIELD",$data['NO_FIELD']);
		$this->db->where("ID_CEMENT_DAILY",$data[ID_CEMENT_DAILY]);
		$this->db->where("ID_COMPONENT",$data[ID_COMPONENT]);
		$this->db->update("D_CEMENT_DAILY");
	}


}
