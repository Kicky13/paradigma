<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	
class M_kas extends CI_Model {
		public function __construct()
	{
		parent::__construct();
		$this->db=$this->load->database('default',true);
	}
	public function get_kas($bulan,$tahun)
	{
		$sql=$this->db->query("SELECT  COMPANY,FISC_YEAR,FIS_PERIOD,SUM(BALANCE) AS BALANCE,SUM(DEBITS_PER)AS DEBET,SUM(CREDIT_PER) AS CREDIT FROM ZCFI_SALDO WHERE COMPANY IN ('7000','6000','5000','4000','3000','2000') AND FISC_YEAR='$tahun' GROUP BY COMPANY,FISC_YEAR,FIS_PERIOD ORDER BY FIS_PERIOD");
		foreach ($sql->result_array() as $rowID) {
				$org=$rowID['COMPANY'];
				$tahun=$rowID['FISC_YEAR'];
				$periode=$rowID['FIS_PERIOD'];
				$debet=$rowID['DEBET'];
				$credit=$rowID['CREDIT'];
				$balance=$rowID['BALANCE'];
		$data['s'.$org][$periode]=array(
                                            'debet'=>$debet,
                                            'credit'=>$credit,
                                            'balance'=>$balance
                                              );
		}
		$tgl=date('Ymd');
		$sql1=$this->db->query("SELECT * FROM ZCFI_CF_AP_AR WHERE VERZN IN ('0','1','2','3','7') AND DATUM='".$tgl."'");
		foreach ($sql1->result_array() as $rowID) {
				$comp=$rowID['BUKRS'];
				$ap=$rowID['AP'];
				$ar=$rowID['AR'];
				$verzn=$rowID['VERZN'];
		$data['s'.$comp]['s'.$verzn]=array(
                                            'ap'=>$ap,
                                            'ar'=>$ar
                                              );
		}
		echo json_encode($data);
	}
	

}

/* End of file m_kas.php */
/* Location: ./application/models/m_kas.php */