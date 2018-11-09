<?php
/*
 * =((C102*D72)+(N72*E102)+(C103*D82)+(N82*E103))/(G102+G103)


KOL QAF
=PRODUKSI_OPC*QAFTOTAL_OPC/PRODUKSI_TOTAL  



QAF PLANT

*/

class Qaf_daily Extends DB_QM {
	
	public function generate_report($DATA,$REPORT){
		switch($REPORT){
			case "cement":
				$this->db->query("call HITUNG_QAF_DAILY(?,?,?,?)",array($DATA['MONTH'],$DATA['YEAR'],$DATA['ID_PRODUCT'],$DATA['ID_AREA']));
			break;
			case "cs":
				$this->db->query("call HITUNG_QAF_CS(?,?,?,?)",array($DATA['MONTH'],$DATA['YEAR'],$DATA['ID_AREA'],$DATA['ID_PRODUCT']));
			break;
			case "st":
				$this->db->query("call HITUNG_QAF_ST(?,?,?,?)",array($DATA['MONTH'],$DATA['YEAR'],$DATA['ID_AREA'],$DATA['ID_PRODUCT']));
			break;
			case "clinker":
				$this->db->query("call HITUNG_QAF_CLINKER(?,?,?)",array($DATA['MONTH'],$DATA['YEAR'],$DATA['ID_AREA']));
			break;
			case "company":
				$this->db->query("call HITUNG_QAF_COMPANY(?,?,?)",array($DATA['MONTH'],$DATA['YEAR'],$DATA['ID_COMPANY']));
			break;
		}
	}
	
	public function report_company($DATA){ 
		$this->db->where("a.BULAN",$DATA['MONTH']);
		$this->db->where("a.TAHUN",$DATA['YEAR']);
		$this->db->where("c.ID_COMPANY",$DATA['ID_COMPANY']);
		$this->db->join("M_AREA b","a.ID_AREA=b.ID_AREA");
		$this->db->join("M_PLANT c","b.ID_PLANT=c.ID_PLANT and c.ID_COMPANY='".$DATA['ID_COMPANY']."'");
		$this->db->order_by("b.ID_AREA","asc");
		$s = $this->db->get("qaf_company a"); #die($this->db->last_query());
		return $s->result();
	}
	
	public function report($DATA){
		$this->db->where("a.BULAN",$DATA['MONTH']);
		$this->db->where("a.TAHUN",$DATA['YEAR']);
		$this->db->where("a.ID_PRODUCT",$DATA['ID_PRODUCT']);
		$this->db->where("a.ID_AREA",$DATA['ID_AREA']);
		$this->db->join("M_AREA b","a.ID_AREA=b.ID_AREA");
		$this->db->join("C_PARAMETER_ORDER c","a.ID_COMPONENT=c.ID_COMPONENT and b.ID_GROUPAREA=c.ID_GROUPAREA and c.DISPLAY='D'");
		$this->db->order_by("c.URUTAN","asc");
		$s = $this->db->get("qaf_daily a");# die($this->db->last_query());
		return $s->result();
	}
	
	public function report_cs($DATA){
		$this->db->where("a.BULAN",$DATA['MONTH']);
		$this->db->where("a.TAHUN",$DATA['YEAR']);
		$this->db->where("a.ID_AREA",$DATA['ID_AREA']);
		$this->db->where("a.ID_PRODUCT",$DATA['ID_PRODUCT']);
		$this->db->join("M_AREA b","a.ID_AREA=b.ID_AREA");
		$this->db->join("C_PARAMETER_ORDER c","a.ID_COMPONENT=c.ID_COMPONENT and b.ID_GROUPAREA=c.ID_GROUPAREA and c.DISPLAY='D'");
		$this->db->order_by("c.URUTAN","asc");
		$s = $this->db->get("QAF_CS a"); 
		#die($this->db->last_query());
		return $s->result();
	}
	
	public function report_st($DATA){
		$this->db->where("a.BULAN",$DATA['MONTH']);
		$this->db->where("a.TAHUN",$DATA['YEAR']);
		$this->db->where("a.ID_AREA",$DATA['ID_AREA']);
		$this->db->where("a.ID_PRODUCT",$DATA['ID_PRODUCT']);
		$this->db->join("M_AREA b","a.ID_AREA=b.ID_AREA");
		$this->db->join("C_PARAMETER_ORDER c","a.ID_COMPONENT=c.ID_COMPONENT and b.ID_GROUPAREA=c.ID_GROUPAREA and c.DISPLAY='D'");
		$this->db->order_by("c.URUTAN","asc");
		$s = $this->db->get("QAF_ST a"); 
		#die($this->db->last_query());
		return $s->result();
	}
	
	public function report_clinker($DATA){
		$this->db->where("a.BULAN",$DATA['MONTH']);
		$this->db->where("a.TAHUN",$DATA['YEAR']);
		$this->db->where("a.ID_AREA",$DATA['ID_AREA']);
		$this->db->join("M_AREA b","a.ID_AREA=b.ID_AREA");
		$this->db->join("C_PARAMETER_ORDER c","a.ID_COMPONENT=c.ID_COMPONENT and c.ID_GROUPAREA=4 and c.DISPLAY='H'");
		$this->db->order_by("c.URUTAN","asc");
		$s = $this->db->get("QAF_CLINKER a"); 
		#die($this->db->last_query());
		return $s->result();
	}
	
	public function component($DATA,$COMPONENT=NULL){ #var_dump($DATA); exit;
		//$this->db->distinct();
		
		$DISPLAY = ($DATA['ID_GROUPAREA'] == 1)?'D':'H';
		
		$this->db->select("b.*,c.V_MIN, c.V_MAX");
		$this->db->join("M_COMPONENT b","a.ID_COMPONENT=b.ID_COMPONENT");
		$this->db->join("C_RANGE_QAF c","a.ID_GROUPAREA=c.ID_GROUPAREA and a.ID_COMPONENT=c.ID_COMPONENT and b.ID_COMPONENT=c.ID_COMPONENT");
		$this->db->join("M_PLANT d","d.ID_COMPANY=c.ID_COMPANY and d.ID_COMPANY='".$DATA['ID_COMPANY']."' and d.ID_PLANT='".$DATA['ID_PLANT']."'");
		$this->db->join("C_PARAMETER_ORDER e","a.ID_GROUPAREA=e.ID_GROUPAREA and c.ID_GROUPAREA=e.ID_GROUPAREA and e.ID_COMPONENT=b.ID_COMPONENT and DISPLAY='".$DISPLAY."' ");
		$this->db->where("d.ID_COMPANY",$DATA['ID_COMPANY']);
		$this->db->where("a.ID_GROUPAREA",$DATA['ID_GROUPAREA']);
		$this->db->where("c.V_MIN IS NOT NULL",NULL,NULL);
		$this->db->where("c.V_MAX IS NOT NULL",NULL,NULL);
		if($COMPONENT) $this->db->where_in("b.ID_COMPONENT",$COMPONENT);
		if($DATA['ID_PRODUCT']) $this->db->where_in("c.ID_PRODUCT",$DATA['ID_PRODUCT']);
		$this->db->order_by("e.URUTAN","ASC");
		$s = $this->db->get("C_QAF_COMPONENT a"); #echo $this->db->last_query(); exit;
		return $s->result();
	}
	
	public function get_area_by_group($ID_PLANT,$ID_GROUPAREA,$ID_PRODUCT=NULL){
		$this->db->select("a.ID_AREA");
		$this->db->join("M_PLANT b","a.ID_PLANT=b.ID_PLANT");
		IF($ID_PRODUCT) $this->db->join("C_QAF_PRODUCT c","a.ID_PLANT=b.ID_PLANT and c.ID_GROUPAREA=a.ID_GROUPAREA and c.ID_PLANT=a.ID_PLANT and c.ID_PLANT=b.ID_PLANT");
		$this->db->where("a.ID_GROUPAREA",$ID_GROUPAREA);
		$this->db->where("a.ID_PLANT",$ID_PLANT);
		IF($ID_PRODUCT) $this->db->where("c.ID_PRODUCT",$ID_PRODUCT);
		$this->db->order_by("a.NM_AREA","asc");
		return $this->db->get("M_AREA a")->result();
	}
	
	public function qaf_produksi($DATA){
		$s = "select a.*,(
			select sum(b.persen_qaf) from qaf_daily b where b.id_area=a.id_area 
			AND b.BULAN = '".$DATA['MONTH']."'
			and b.TAHUN = '".$DATA['YEAR']."' 
			".(($DATA['ID_GROUPAREA']==1)?" AND b.ID_PRODUCT='".$DATA['ID_PRODUCT']."' ":"")."
			) as QAF,
			(select count(c.ID_COMPONENT) from C_QAF_COMPONENT c where c.ID_GROUPAREA=a.ID_GROUPAREA) JML_COMPONENT,
			(select 
				d.NILAI from D_PRODUCTION d, T_PRODUCTION e 
				where e.ID_PRODUCTION=d.ID_PRODUCTION and E.BULAN='".$DATA['MONTH']."' 
				AND e.TAHUN='".$DATA['YEAR']."' 
				AND E.ID_AREA=A.ID_AREA ".(($DATA['ID_GROUPAREA']==1)?" and D.ID_PRODUCT='".$DATA['ID_PRODUCT']."' ":"")."
			  ) as PRODUKSI
			from m_area a where a.id_plant='".$DATA['ID_PLANT']."' AND a.ID_GROUPAREA='".$DATA['ID_GROUPAREA']."' 		
		"; #echo "<pre>$s</pre>";
		return $this->db->query($s)->result();
	}
	
	public function qaf_produksi_cs($DATA){
            var_dump($DATA);
            
		$s = "select a.*,(
			select sum(b.persen_qaf) from qaf_cs b where b.id_area=a.id_area 
			AND b.BULAN = '".$DATA['MONTH']."'
			and b.TAHUN = '".$DATA['YEAR']."' 
			and b.BULAN IS NOT NULL
			".(($DATA['ID_GROUPAREA']==1)?" AND b.ID_PRODUCT='".$DATA['ID_PRODUCT']."' ":"")."
			) as QAF,
			(select count(c.ID_COMPONENT) from C_QAF_COMPONENT c where c.ID_GROUPAREA=a.ID_GROUPAREA) JML_COMPONENT,
			(select 
				d.NILAI from D_PRODUCTION d, T_PRODUCTION e 
				where e.ID_PRODUCTION=d.ID_PRODUCTION and E.BULAN='".$DATA['MONTH']."' 
				AND e.TAHUN='".$DATA['YEAR']."' 
				AND E.ID_AREA=A.ID_AREA ".(($DATA['ID_GROUPAREA']==1)?" and D.ID_PRODUCT='".$DATA['ID_PRODUCT']."' ":"")."
			  ) as PRODUKSI
			from m_area a where a.id_plant='".$DATA['ID_PLANT']."' AND a.ID_GROUPAREA='".$DATA['ID_GROUPAREA']."' 		
		"; #echo "<pre>$s</pre>";
		return $this->db->query($s)->result();
	}
	
	public function qaf_produksi_st($DATA){
		$s = "select a.*,(
			select sum(b.persen_qaf) from qaf_st b where b.id_area=a.id_area 
			AND b.BULAN = '".$DATA['MONTH']."'
			and b.TAHUN = '".$DATA['YEAR']."' 
			and b.BULAN IS NOT NULL
			".(($DATA['ID_GROUPAREA']==1)?" AND b.ID_PRODUCT='".$DATA['ID_PRODUCT']."' ":"")."
			) as QAF,
			(select count(c.ID_COMPONENT) from C_QAF_COMPONENT c where c.ID_GROUPAREA=a.ID_GROUPAREA) JML_COMPONENT,
			(select 
				d.NILAI from D_PRODUCTION d, T_PRODUCTION e 
				where e.ID_PRODUCTION=d.ID_PRODUCTION and E.BULAN='".$DATA['MONTH']."' 
				AND e.TAHUN='".$DATA['YEAR']."' 
				AND E.ID_AREA=A.ID_AREA ".(($DATA['ID_GROUPAREA']==1)?" and D.ID_PRODUCT='".$DATA['ID_PRODUCT']."' ":"")."
			  ) as PRODUKSI
			from m_area a where a.id_plant='".$DATA['ID_PLANT']."' AND a.ID_GROUPAREA='".$DATA['ID_GROUPAREA']."' 		
		"; #echo "<pre>$s</pre>";
		return $this->db->query($s)->result();
	}
	
	public function qaf_produksi_clinker($DATA){
		$s = "select a.*,(
			select sum(b.persen_qaf) from qaf_clinker b where b.id_area=a.id_area 
			AND b.BULAN = '".$DATA['MONTH']."'
			and b.TAHUN = '".$DATA['YEAR']."' 
			".(($DATA['ID_GROUPAREA']==1)?" AND b.ID_PRODUCT='".$DATA['ID_PRODUCT']."' ":"")."
			) as QAF,
			(select count(c.ID_COMPONENT) from C_QAF_COMPONENT c where c.ID_GROUPAREA=a.ID_GROUPAREA) JML_COMPONENT,
			(select 
				d.NILAI from D_PRODUCTION d, T_PRODUCTION e 
				where e.ID_PRODUCTION=d.ID_PRODUCTION and E.BULAN='".$DATA['MONTH']."' 
				AND e.TAHUN='".$DATA['YEAR']."' 
				AND E.ID_AREA=A.ID_AREA ".(($DATA['ID_GROUPAREA']==1)?" and D.ID_PRODUCT='".$DATA['ID_PRODUCT']."' ":"")."
			  ) as PRODUKSI
			from m_area a where a.id_plant='".$DATA['ID_PLANT']."' AND a.ID_GROUPAREA='".$DATA['ID_GROUPAREA']."' 		
		"; #echo "<pre>$s</pre>";
		return $this->db->query($s)->result();
	}

}
