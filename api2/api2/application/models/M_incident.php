<?php

class M_Incident Extends DB_QM {

	private $post  = array();
	private $table = "M_INCIDENT";
	private $pKey  = "ID_INCIDENT";
	private $column_order = array('ID_INCIDENT'); //set column for datatable order
    private $column_search = array('UPPER(SUBJECT)', 'UPPER(JUDUL_SOLUTION)'); //set column for datatable search
    private $order = array("ID_INCIDENT" => 'DESC'); //default order

	public function __construct(){
		$this->post = $this->input->post();
	}

	public function datalist(){
		#$this->db->where("a.ID_TEKNISI IS NULL",NULL,FALSE);
		#$this->db->order_by("a.ID_INCIDENT");
		#return $this->db->get("M_INCIDENT a")->result();
		return $this->solved_list();
	}

	public function assigned(){
		$this->db->select("a.*,b.NM_TEKNISI");
		$this->db->join("M_TEKNISI b","a.ID_TEKNISI=b.ID_TEKNISI");
		$this->db->where("a.ID_TEKNISI IS NOT NULL",NULL,FALSE);
		$this->db->where("a.ID_SOLUTION IS NULL",NULL,FALSE);
		$this->db->order_by("a.ID_INCIDENT");
		return $this->db->get("M_INCIDENT a")->result();
	}

	public function solved_list(){
		$this->db->select("a.*,b.NM_TEKNISI,c.JUDUL_SOLUTION");
		$this->db->join("M_TEKNISI b","a.ID_TEKNISI=b.ID_TEKNISI","LEFT");
		$this->db->join("M_SOLUTION c","a.ID_SOLUTION=c.ID_SOLUTION","LEFT");
		#$this->db->where("a.ID_TEKNISI IS NOT NULL",NULL,FALSE);
		#$this->db->where("a.ID_SOLUTION IS NOT NULL",NULL,FALSE);
		$this->db->order_by("a.ID_INCIDENT","DESC");
		return $this->db->get("M_INCIDENT a")->result();
	}


	public function get_solved_by_id($ID_INCIDENT){
		$this->db->select("a.*,b.NM_TEKNISI,c.JUDUL_SOLUTION,d.NM_COMPONENT,d.KD_COMPONENT,c.*,TO_CHAR(c.JAM,'DD-MM-YYYY HH24:MI') AS JAM_ANALISA");
		$this->db->join("M_TEKNISI b","a.ID_TEKNISI=b.ID_TEKNISI");
		$this->db->join("M_SOLUTION c","a.ID_SOLUTION=c.ID_SOLUTION");
		$this->db->join("M_COMPONENT d","a.ID_COMPONENT=d.ID_COMPONENT");
		$this->db->where("a.ID_TEKNISI IS NOT NULL",NULL,FALSE);
		$this->db->where("a.ID_SOLUTION IS NOT NULL",NULL,FALSE);
		$this->db->where("a.ID_INCIDENT",$ID_INCIDENT);
		$this->db->order_by("a.ID_INCIDENT");
		return $this->db->get("M_INCIDENT a")->row();
	}

	public function list_company(){
		$this->db->where("a.KD_INCIDENT !=","2000");
		$this->db->order_by("a.ID_INCIDENT");
		return $this->db->get("M_INCIDENT a")->result();
	}

	public function search(&$keyword){
		$this->db->like("NM_INCIDENT",$keyword);
		return $this->db->get("M_INCIDENT")->result();
	}

	public function data($where){
		$this->db->where($where);
		return  $this->db->get("M_INCIDENT")->row();
	}

	public function get_data_by_id($ID_INCIDENT){
		$this->db->select("a.*, b.*, c.*,TO_CHAR(c.JAM,'DD-MM-YYYY HH24:MI') AS JAM_ANALISA");
		$this->db->join("M_COMPONENT b","a.ID_COMPONENT=b.ID_COMPONENT");
		$this->db->join("D_INCIDENT c","a.ID_INCIDENT=c.ID_INCIDENT");
		$this->db->where("a.ID_INCIDENT",$ID_INCIDENT);
		return $this->db->get("M_INCIDENT a")->result();
	}

	public function data_except_id($where,$skip_id){
		$this->db->where("ID_INCIDENT !=",$skip_id);
		$this->db->where($where);
		return $this->db->get("M_INCIDENT")->row();
	}

	public function insert($data){
		$this->db->set($data);
		$this->db->set("ID_INCIDENT","SEQ_ID_INCIDENT.NEXTVAL",FALSE);
		$this->db->insert("M_INCIDENT");
	}

	public function update($data,$ID_INCIDENT){
		$this->db->set($data);
		$this->db->where("ID_INCIDENT",$ID_INCIDENT);
		$this->db->update("M_INCIDENT");
	}

	public function delete($ID_INCIDENT){
		$this->db->where("ID_INCIDENT",$ID_INCIDENT);
		$this->db->delete("M_INCIDENT");
	}

	public function assign($data,$ID_INCIDENT){
		$this->db->set($data);
		$this->db->where("ID_INCIDENT",$ID_INCIDENT);
		$this->db->update("M_INCIDENT");
	}

	public function solved($ID_SOLUTION,$ID_INCIDENT){
		$this->db->set("ID_SOLUTION",$ID_SOLUTION);
		$this->db->set("DATE_SOLUTION","SYSDATE",FALSE);
		$this->db->where("ID_INCIDENT",$ID_INCIDENT);
		$this->db->update("M_INCIDENT");
	}

	public function type(){
		return $this->db->get("M_INCIDENT_TYPE")->result();
	}

	public function report($data){
		$this->db->select("a.ID_INCIDENT, a.SUBJECT,to_char(a.TANGGAL,'dd-mm-yyyy hh24:mi') as TANGGAL,c.NM_INCIDENT_TYPE,d.FULLNAME,g.NM_COMPANY,f.NM_PLANT,e.NM_AREA,i.FULLNAME");
		$this->db->join("M_INCIDENT_TYPE c","a.ID_INCIDENT_TYPE=c.ID_INCIDENT_TYPE");
		$this->db->join("M_OPCO d","a.ID_AREA=d.ID_AREA and d.ID_JABATAN=3 and d.ID_AREA='".$data['ID_AREA']."'","LEFT");
		$this->db->join("M_AREA e","e.ID_AREA=a.ID_AREA");
		$this->db->join("M_PLANT f","e.ID_PLANT=f.ID_PLANT");
		$this->db->join("M_COMPANY g","f.ID_COMPANY=g.ID_COMPANY");
		$this->db->join("T_CEMENT_HOURLY h","a.ID_PRODUCTION_HOURLY=h.ID_CEMENT_HOURLY","LEFT");
		$this->db->join("M_USERS i","i.ID_USER=h.USER_ENTRY","LEFT");
		$this->db->where("a.ID_AREA",$data['ID_AREA']);
		if($data['ID_INCIDENT_TYPE']) $this->db->where("a.ID_INCIDENT_TYPE",$data['ID_INCIDENT_TYPE']);
		$this->db->where("a.TANGGAL >= to_date('".$data['STARTDATE']."','dd/mm/yyyy') AND to_date(to_char(a.TANGGAL,'DDMMYYYY'),'DDMMYYYY') <= to_date('".$data['ENDDATE']."','dd/mm/yyyy') ",FALSE,FALSE);
		$this->db->order_by("a.ID_INCIDENT");
		$r = $this->db->get("M_INCIDENT a"); #echo $this->db->last_query(); die();
		return $r->result();
	}


	public function get_dashboard($data){
		$r[TOTAL]  = (int)$this->n_total($data['ID_COMPANY'],$data['STARTDATE'],$data['ENDDATE']); #echo $this->db->last_query();
		$r[BARU]   = (int)$this->n_baru($data['ID_COMPANY'],$data['STARTDATE'],$data['ENDDATE']);
		$r[PROSES] = (int)$this->n_proses($data['ID_COMPANY'],$data['STARTDATE'],$data['ENDDATE']);
		$r[SOLVED] = (int)$this->n_solved($data['ID_COMPANY'],$data['STARTDATE'],$data['ENDDATE']);
		return $r;
	}

	public function get_dashboard_notifikasi($data){
		$r[MINOR1] = (int)$this->n_minor1($data['ID_COMPANY'],$data['STARTDATE'],$data['ENDDATE']);
		$r[MINOR2] = (int)$this->n_minor2($data['ID_COMPANY'],$data['STARTDATE'],$data['ENDDATE']);
		$r[MAYOR]  = (int)$this->n_mayor($data['ID_COMPANY'],$data['STARTDATE'],$data['ENDDATE']);
		$r[EQR]  = (int)$this->n_eqr($data['ID_COMPANY'],$data['STARTDATE'],$data['ENDDATE']);
		return $r;
	}

	private function n_total($ID_COMPANY,$STARTDATE,$ENDDATE){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("TANGGAL >= to_date('$STARTDATE','DD/MM/YYYY')",NULL,FALSE);
		$this->db->where("TANGGAL <= to_date('$ENDDATE','DD/MM/YYYY')",NULL,FALSE);
		return $this->db->get("V_INCIDENT")->row()->JML; #die($this->db->last_query());
	}

	private function n_baru($ID_COMPANY,$STARTDATE,$ENDDATE){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("DATE_SOLUTION IS NULL",NULL,FALSE);
		$this->db->where("TANGGAL >= to_date('$STARTDATE','DD/MM/YYYY')",NULL,FALSE);
		$this->db->where("TANGGAL <= to_date('$ENDDATE','DD/MM/YYYY')",NULL,FALSE);
		return $this->db->get("V_INCIDENT")->row()->JML;
	}

	private function n_proses($ID_COMPANY,$STARTDATE,$ENDDATE){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("DATE_SOLUTION IS NOT NULL",NULL,FALSE);
		$this->db->where("ID_SOLUTION IS NULL",NULL,FALSE);
		$this->db->where("TANGGAL >= to_date('$STARTDATE','DD/MM/YYYY')",NULL,FALSE);
		$this->db->where("TANGGAL <= to_date('$ENDDATE','DD/MM/YYYY')",NULL,FALSE);
		return $this->db->get("V_INCIDENT")->row()->JML;
	}

	private function n_solved($ID_COMPANY,$STARTDATE,$ENDDATE){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("ID_SOLUTION IS NOT NULL",NULL,FALSE);
		$this->db->where("TANGGAL >= to_date('$STARTDATE','DD/MM/YYYY')",NULL,FALSE);
		$this->db->where("TANGGAL <= to_date('$ENDDATE','DD/MM/YYYY')",NULL,FALSE);
		return $this->db->get("V_INCIDENT")->row()->JML;
	}

	private function n_minor1($ID_COMPANY,$STARTDATE,$ENDDATE){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("ID_INCIDENT_TYPE","1");
		$this->db->where("TANGGAL >= to_date('$STARTDATE','DD/MM/YYYY')",NULL,FALSE);
		$this->db->where("TANGGAL <= to_date('$ENDDATE','DD/MM/YYYY')",NULL,FALSE);
		return $this->db->get("V_INCIDENT")->row()->JML; #die($this->db->last_query());
	}

	private function n_minor2($ID_COMPANY,$STARTDATE,$ENDDATE){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("ID_INCIDENT_TYPE","2");
		$this->db->where("TANGGAL >= to_date('$STARTDATE','DD/MM/YYYY')",NULL,FALSE);
		$this->db->where("TANGGAL <= to_date('$ENDDATE','DD/MM/YYYY')",NULL,FALSE);
		return $this->db->get("V_INCIDENT")->row()->JML; #die($this->db->last_query());
	}

	private function n_mayor($ID_COMPANY,$STARTDATE,$ENDDATE){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("ID_INCIDENT_TYPE >=","3");
		$this->db->where("TANGGAL >= to_date('$STARTDATE','DD/MM/YYYY')",NULL,FALSE);
		$this->db->where("TANGGAL <= to_date('$ENDDATE','DD/MM/YYYY')",NULL,FALSE);
		return $this->db->get("V_INCIDENT")->row()->JML; #die($this->db->last_query());
	}

	private function n_eqr($ID_COMPANY,$STARTDATE,$ENDDATE){
		$this->db->select("count(ID_INCIDENT) as JML");
		$this->db->where("ID_COMPANY",$ID_COMPANY);
		$this->db->where("ID_INCIDENT_TYPE >=","4");
		$this->db->where("TANGGAL >= to_date('$STARTDATE','DD/MM/YYYY')",NULL,FALSE);
		$this->db->where("TANGGAL <= to_date('$ENDDATE','DD/MM/YYYY')",NULL,FALSE);
		return $this->db->get("V_INCIDENT")->row()->JML; #die($this->db->last_query());
	}

	public function get_notifikasi_company($data){
		$s = "
		select c.ID_COMPANY, b.ID_PLANT, a.ID_AREA, b.NM_PLANT, a.NM_AREA,
		(select count(z.ID_INCIDENT) FROM M_INCIDENT z where z.ID_AREA=a.ID_AREA AND z.ID_INCIDENT_TYPE=1 and z.TANGGAL >= to_date('".$data[STARTDATE]."','dd/mm/yyyy') and z.TANGGAL <= to_date('".$data[ENDDATE]."','dd/mm/yyyy') ) as MINOR1,
		(select count(z.ID_INCIDENT) FROM M_INCIDENT z where z.ID_AREA=a.ID_AREA AND z.ID_INCIDENT_TYPE=2 and z.TANGGAL >= to_date('".$data[STARTDATE]."','dd/mm/yyyy') and z.TANGGAL <= to_date('".$data[ENDDATE]."','dd/mm/yyyy') ) as MINOR2,
		(select count(z.ID_INCIDENT) FROM M_INCIDENT z where z.ID_AREA=a.ID_AREA AND z.ID_INCIDENT_TYPE>=3 and z.TANGGAL >= to_date('".$data[STARTDATE]."','dd/mm/yyyy') and z.TANGGAL <= to_date('".$data[ENDDATE]."','dd/mm/yyyy') ) as MAYOR,
		(select count(z.ID_INCIDENT) FROM M_INCIDENT z where z.ID_AREA=a.ID_AREA AND z.ID_INCIDENT_TYPE>=4 and z.TANGGAL >= to_date('".$data[STARTDATE]."','dd/mm/yyyy') and z.TANGGAL <= to_date('".$data[ENDDATE]."','dd/mm/yyyy') ) as EQR
		from m_area a, m_plant b, m_company c
		where
		c.ID_COMPANY='".$data[ID_COMPANY]."'
		and a.ID_PLANT=b.ID_PLANT and b.ID_COMPANY=c.ID_COMPANY
		order by ID_PLANT asc, ID_AREA asc";
		$q = $this->db->query($s);
		return $q->result();

	}

	public function avg_score_ncqr($data){
		$s = "select
			a.ID_COMPANY, a.NM_COMPANY,
			((select sum(b.SCORE) from V_INCIDENT b where a.ID_COMPANY=b.ID_COMPANY and b.TANGGAL >= to_date('".$data[STARTDATE]."','dd/mm/yyyy') and b.TANGGAL <= to_date('".$data[ENDDATE]."','dd/mm/yyyy') )
				/(select COUNT(b.ID_INCIDENT) from V_INCIDENT b where a.ID_COMPANY=b.ID_COMPANY and b.TANGGAL >= to_date('".$data[STARTDATE]."','dd/mm/yyyy') and b.TANGGAL <= to_date('".$data[ENDDATE]."','dd/mm/yyyy') )
			) AS AVG_SCORE
			from m_company a where a.KD_COMPANY != 2000";
		$q = $this->db->query($s);
		return $q->result();
	}

	public function list_notif($ID_INCIDENT){
		$this->db->select("b.FULLNAME, b.EMAIL, b.TEMBUSAN, c.NM_JABATAN, to_char(a.TANGGAL,'dd-mm-yyyy hh24:mi') as TANGGAL_NOTIFIKASI");
		$this->db->where("a.ID_INCIDENT",$ID_INCIDENT);
		$this->db->join("M_JABATAN c","a.ID_JABATAN=c.ID_JABATAN");
		$this->db->join("M_OPCO b","a.ID_OPCO=b.ID_OPCO and a.ID_JABATAN=b.ID_JABATAN AND b.DELETED=0 and b.ID_JABATAN=c.ID_JABATAN");
		$this->db->order_by("a.TANGGAL","asc");
		return $this->db->get("T_NOTIFIKASI a")->result();
	}


	public function get_query($solved=NULL){
		$this->db->select("a.*,b.NM_TEKNISI,c.JUDUL_SOLUTION");
		$this->db->from($this->table . ' a');
		$this->db->join("M_TEKNISI b","a.ID_TEKNISI=b.ID_TEKNISI","LEFT");
		$this->db->join("M_SOLUTION c","a.ID_SOLUTION=c.ID_SOLUTION","LEFT");
		$this->db->join('M_AREA d', 'a.ID_AREA = d.ID_AREA');
		$this->db->join('M_PLANT e', 'd.ID_PLANT = e.ID_PLANT');
		if ($this->USER->ID_COMPANY) $this->db->where('e.ID_COMPANY', $this->USER->ID_COMPANY);
		if($solved) {
			$this->db->where('c.JUDUL_SOLUTION IS NOT NULL', NULL, FALSE);
		}else{
			$this->db->where('c.JUDUL_SOLUTION IS NULL', NULL, FALSE);
		}
		#$this->db->where("a.ID_TEKNISI IS NOT NULL",NULL,FALSE);
		#$this->db->where("a.ID_SOLUTION IS NOT NULL",NULL,FALSE);
		$this->db->order_by("a.ID_INCIDENT","DESC");
		#echo $this->db->get_compiled_select();exit();
	}

	public function get_list($solved=NULL) {
		$this->get_query($solved);
		$i = 0;

		//Loop column search
		foreach ($this->column_search as $item) {
			if($this->post['search']['value']){
				if($i===0){ //first loop
					$this->db->group_start(); //open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, strtoupper($this->post['search']['value']));
				}else{
					$this->db->or_like($item, strtoupper($this->post['search']['value']));
				}

				if(count($this->column_search) - 1 == $i){ //last loop
                    $this->db->group_end(); //close bracket
				}
			}
			$i++;
		}

		if(isset($this->post['order'])){ //order datatable
			$this->db->order_by($this->column_order[$this->post['order']['0']['column']], $this->post['order']['0']['dir']);

		}elseif (isset($this->order)) {
			$this->db->order_by(key($this->order), $this->order[key($this->order)]);
		}
		if($this->post['length'] != -1){
			$this->db->limit($this->post['length'],$this->post['start']);
			#echo $this->db->get_compiled_select();exit();
			$query = $this->db->get();
		}else{
			$query = $this->db->get();
		}

		return $query->result();
	}

	/** Count query result after filtered **/
	public function count_filtered($solved=NULL){
		$this->get_query($solved);
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

	/** Count all result **/
	public function count_all($solved=NULL){
		$this->get_query($solved);
		$query = $this->db->get();
		return (int) $query->num_rows();
	}

}
