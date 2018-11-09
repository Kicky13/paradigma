<?php
/*
 * =((C102*D72)+(N72*E102)+(C103*D82)+(N82*E103))/(G102+G103)


KOL QAF
=PRODUKSI_OPC*QAFTOTAL_OPC/PRODUKSI_TOTAL  



QAF PLANT

*/

class Treport Extends DB_QM {
	
	public function dashboard_daily($DATE_START,$DATE_END,$ID_GROUPAREA,$ID_COMPANY,$ID_PLANT){ 
		if(in_array($ID_GROUPAREA,array(1,4))){
			return $this->cement_daily($DATE_START,$DATE_END,$ID_GROUPAREA,$ID_COMPANY,$ID_PLANT);
		}
		else{
			return $this->production_daily($DATE_START,$DATE_END,$ID_GROUPAREA,$ID_COMPANY,$ID_PLANT);
		}
	}
	
	public function cement_daily($DATE_START,$DATE_END,$ID_GROUPAREA,$ID_COMPANY,$ID_PLANT){
		$s = "
			select 
			  count(a.ID_CEMENT_DAILY) as JML_ROW, 
			  count(distinct(a.ID_AREA)) as JML_AREA,
			  count(distinct(a.ID_PRODUCT)) as JML_PRODUCT,
			  FLOOR(count(a.ID_CEMENT_DAILY)/count(distinct(a.ID_AREA))".(($ID_GROUPAREA==4)?"":"/count(distinct(a.ID_PRODUCT))").") AS JML_DATA,
			  floor(to_date('".$DATE_END."','DD/MM/YYYY') - to_date('".$DATE_START."','DD/MM/YYYY')) JML_HARI,
			  MAX(a.DATE_DATA) as TANGGAL_DATA,
			  MAX(a.DATE_ENTRY) as TANGGAL_ENTRI
			from 
			  T_CEMENT_DAILY a, 
			  M_AREA b,
			  M_PLANT c,
			  M_GROUPAREA d
			where 
			  a.ID_AREA=b.ID_AREA 
			  and b.ID_PLANT=c.ID_PLANT
			  and b.ID_GROUPAREA=d.ID_GROUPAREA
			  and b.ID_PLANT in (".$ID_PLANT.")
			  and c.ID_COMPANY=".$ID_COMPANY."  
			  and d.ID_GROUPAREA=".$ID_GROUPAREA."
			  and a.DATE_DATA >= to_date('".$DATE_START."','DD/MM/YYYY') 
			  and a.DATE_DATA <= to_date('".$DATE_END."','DD/MM/YYYY') 
		"; #echo $s; return;
		$s = @$this->db->query($s);
		
		return ($s)?$s->row():null;
	}
	
	public function production_daily($DATE_START,$DATE_END,$ID_GROUPAREA,$ID_COMPANY,$ID_PLANT){
		$s = "
			select 
			  count(a.ID_PRODUCTION_DAILY) as JML_ROW, 
			  count(distinct(a.ID_AREA)) as JML_AREA,
			  FLOOR(count(a.ID_PRODUCTION_DAILY)/count(distinct(a.ID_AREA))) AS JML_DATA,
			  floor(to_date('".$DATE_END."','DD/MM/YYYY') - to_date('".$DATE_START."','DD/MM/YYYY')) JML_HARI,
			  MAX(a.DATE_DATA) as TANGGAL_DATA,
			  MAX(a.DATE_ENTRY) as TANGGAL_ENTRI
			from 
			  T_PRODUCTION_DAILY a, 
			  M_AREA b,
			  M_PLANT c,
			  M_GROUPAREA d
			where 
			  a.ID_AREA=b.ID_AREA 
			  and b.ID_PLANT=c.ID_PLANT
			  and b.ID_GROUPAREA=d.ID_GROUPAREA
			  and b.ID_PLANT in (".$ID_PLANT.")
			  and c.ID_COMPANY=".$ID_COMPANY."  
			  and d.ID_GROUPAREA=".$ID_GROUPAREA."
			  and a.DATE_DATA >= to_date('".$DATE_START."','DD/MM/YYYY') 
			  and a.DATE_DATA <= to_date('".$DATE_END."','DD/MM/YYYY') 
		";	
		$s = @$this->db->query($s);
		return ($s)?$s->row():null;
	}
	
	public function dashboard_hourly($DATE_START,$DATE_END,$ID_GROUPAREA,$ID_COMPANY,$ID_PLANT){ 
		if(in_array($ID_GROUPAREA,array(1,4))){
			return $this->cement_hourly($DATE_START,$DATE_END,$ID_GROUPAREA,$ID_COMPANY,$ID_PLANT);
		}
		else{
			return $this->production_hourly($DATE_START,$DATE_END,$ID_GROUPAREA,$ID_COMPANY,$ID_PLANT);
		}
	}
	
	public function cement_hourly($DATE_START,$DATE_END,$ID_GROUPAREA,$ID_COMPANY,$ID_PLANT){
		$s = "
			select 
			  count(a.ID_CEMENT_HOURLY) as JML_ROW, 
			  count(distinct(a.ID_AREA)) as JML_AREA,
			  count(distinct(a.ID_PRODUCT)) as JML_PRODUCT,
			  FLOOR(count(a.ID_CEMENT_HOURLY)/count(distinct(a.ID_AREA))".(($ID_GROUPAREA==4)?"":"/count(distinct(a.ID_PRODUCT))").") AS JML_DATA,
			  (floor(to_date('".$DATE_END."','DD/MM/YYYY') - to_date('".$DATE_START."','DD/MM/YYYY'))*24) JML_JAM,
			  MAX(a.DATE_DATA) as TANGGAL_DATA,
			  MAX(a.DATE_ENTRY) as TANGGAL_ENTRI
			from 
			  T_CEMENT_HOURLY a, 
			  M_AREA b,
			  M_PLANT c,
			  M_GROUPAREA d
			where 
			  a.ID_AREA=b.ID_AREA 
			  and b.ID_PLANT=c.ID_PLANT
			  and b.ID_GROUPAREA=d.ID_GROUPAREA
			  and b.ID_PLANT in (".$ID_PLANT.")
			  and c.ID_COMPANY=".$ID_COMPANY."  
			  and d.ID_GROUPAREA=".$ID_GROUPAREA."
			  and a.DATE_DATA >= to_date('".$DATE_START."','DD/MM/YYYY') 
			  and a.DATE_DATA <= to_date('".$DATE_END."','DD/MM/YYYY') 
		";
		$s = @$this->db->query($s);
		
		return ($s)?$s->row():null;
	}
	
	public function production_hourly($DATE_START,$DATE_END,$ID_GROUPAREA,$ID_COMPANY,$ID_PLANT){
		$s = "
			select 
			  count(a.ID_PRODUCTION_HOURLY) as JML_ROW, 
			  count(distinct(a.ID_AREA)) as JML_AREA,
			  FLOOR(count(a.ID_PRODUCTION_HOURLY)/count(distinct(a.ID_AREA))) AS JML_DATA,
			  (floor(to_date('".$DATE_END."','DD/MM/YYYY') - to_date('".$DATE_START."','DD/MM/YYYY'))*24) JML_JAM,
			  MAX(a.DATE_DATA) as TANGGAL_DATA,
			  MAX(a.DATE_ENTRY) as TANGGAL_ENTRI
			from 
			  T_PRODUCTION_HOURLY a, 
			  M_AREA b,
			  M_PLANT c,
			  M_GROUPAREA d
			where 
			  a.ID_AREA=b.ID_AREA 
			  and b.ID_PLANT=c.ID_PLANT
			  and b.ID_GROUPAREA=d.ID_GROUPAREA
			  and b.ID_PLANT in (".$ID_PLANT.")
			  and c.ID_COMPANY=".$ID_COMPANY."  
			  and d.ID_GROUPAREA=".$ID_GROUPAREA."
			  and a.DATE_DATA >= to_date('".$DATE_START."','DD/MM/YYYY') 
			  and a.DATE_DATA <= to_date('".$DATE_END."','DD/MM/YYYY') 
		";	
		$s = @$this->db->query($s);
		return ($s)?$s->row():null;
	}
	

}
