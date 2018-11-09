<?php
header('Access-Control-Allow-Origin:*');
defined('BASEPATH') OR exit('No direct script access allowed');

class Real_sales_st extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->db=$this->load->database('tonasa',true);
	}

	public function index()
	{
		$data=[];
		$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
		$tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
		$hari = (empty($_GET['hari']) ? date('d') : $_GET['hari']);
		$tanggal = $tahun.'-'.$bulan.'-31';
		$tanggal1 = $tahun.'-'.$bulan.'-01';


		//bulan ini

		$sql=$this->db->query("
					SELECT
							VKORG,
							SUM(TON) AS REALISASI
						FROM
							T_ZCSD2155
						WHERE
							WADAT_IST = '$tanggal'
			");
		foreach ($sql->result_array() as $row) {
			$data['month']['days']=array(
						'OPCO'=>$row['VKORG'],
						'REAL'=>$row['REALISASI']
				);
		}


		//kemasan
		$kemasan = array('121-200%','121-301%','121-302%');
		foreach ($kemasan as $value) {
		$sql_kemasan = $this->db->query("
										SELECT
											VKORG,
											ARKTX,
											SUM(TON) AS REALISASI
										FROM
											T_ZCSD2155
										WHERE
											WADAT_IST = '$tanggal'
											AND MATNR LIKE '$value'
			");
			foreach ($sql_kemasan->result_array() as $row) {
				$data['month']['kemasan'][$row['ARKTX']]=array(
														'OPCO'=>$row['VKORG'],
														'REAL'=>$row['REALISASI']
														);
			}
		}

		//WILAYAH
		$sql_wilayah =$this->db->query("
							SELECT
								T_ZCSD2155.VKORG,
								ZREPORT_SCM_KABIRO_SALES.ID_REGION,
								SUM(T_ZCSD2155.TON) AS REALISASI
							FROM
								ZREPORT_SCM_KABIRO_SALES
							INNER JOIN T_ZCSD2155 ON T_ZCSD2155.VKORG = ZREPORT_SCM_KABIRO_SALES.ORG
							AND T_ZCSD2155.VKBUR = ZREPORT_SCM_KABIRO_SALES.ID_PROV
							WHERE T_ZCSD2155.WADAT_IST = '$tanggal'
							GROUP BY ZREPORT_SCM_KABIRO_SALES.ID_REGION
			");

		foreach ($sql_wilayah->result_array() as $row) {
				$data['month']['wilayah'][$row['ID_REGION']]=array('OPCO'=>$row['VKORG'],
												'REAL'=>$row['REALISASI']);
		}

		//INCOTERM
		$sql_incoterm = $this->db->query("
			SELECT
					VKORG,
					INCO1,
					SUM(TON) AS REALISASI
				FROM
					T_ZCSD2155
				WHERE
					WADAT_IST = '$tanggal'
				GROUP BY INCO1");
		foreach ($sql_incoterm->result_array() as $row) {
			$data['month']['incoterm'][$row['INCO1']]=array('OPCO'=>$row['VKORG'],
												'REAL'=>$row['REALISASI']);
		}



		//up bulan
		$sql=$this->db->query("
					SELECT
							VKORG,
							SUM(TON) AS REALISASI
						FROM
							T_ZCSD2155
						WHERE
							WADAT_IST BETWEEN '$tanggal1' AND '$tanggal'
			");
		foreach ($sql->result_array() as $row) {
			$data['up_month']['days']=array(
						'OPCO'=>$row['VKORG'],
						'REAL'=>$row['REALISASI']
				);
		}


		//kemasan
		$kemasan = array('121-200%','121-301%','121-302%');
		foreach ($kemasan as $value) {
		$sql_kemasan = $this->db->query("
										SELECT
											VKORG,
											ARKTX,
											SUM(TON) AS REALISASI
										FROM
											T_ZCSD2155
										WHERE
											WADAT_IST BETWEEN '$tanggal1' AND '$tanggal'
											AND MATNR LIKE '$value'
			");
			foreach ($sql_kemasan->result_array() as $row) {
				$data['up_month']['kemasan'][$row['ARKTX']]=array(
														'OPCO'=>$row['VKORG'],
														'REAL'=>$row['REALISASI']
														);
			}
		}

		//WILAYAH
		$sql_wilayah =$this->db->query("
							SELECT
								T_ZCSD2155.VKORG,
								ZREPORT_SCM_KABIRO_SALES.ID_REGION,
								SUM(T_ZCSD2155.TON) AS REALISASI
							FROM
								ZREPORT_SCM_KABIRO_SALES
							INNER JOIN T_ZCSD2155 ON T_ZCSD2155.VKORG = ZREPORT_SCM_KABIRO_SALES.ORG
							AND T_ZCSD2155.VKBUR = ZREPORT_SCM_KABIRO_SALES.ID_PROV
							WHERE T_ZCSD2155.WADAT_IST BETWEEN '$tanggal1' AND '$tanggal'
							GROUP BY ZREPORT_SCM_KABIRO_SALES.ID_REGION
			");

		foreach ($sql_wilayah->result_array() as $row) {
				$data['up_month']['wilayah'][$row['ID_REGION']]=array('OPCO'=>$row['VKORG'],
												'REAL'=>$row['REALISASI']);
		}

		//INCOTERM
		$sql_incoterm = $this->db->query("
			SELECT
					VKORG,
					INCO1,
					SUM(TON) AS REALISASI
				FROM
					T_ZCSD2155
				WHERE
					WADAT_IST BETWEEN '$tanggal1' AND '$tanggal'
				GROUP BY INCO1");
		foreach ($sql_incoterm->result_array() as $row) {
			$data['up_month']['incoterm'][$row['INCO1']]=array('OPCO'=>$row['VKORG'],
												'REAL'=>$row['REALISASI']);
		}

		//ALL
		$sql_all = $this->db->query("
										SELECT
											VKORG,
											ARKTX,
											INCO1,
											WADAT_IST,
											SUM(TON) AS REALISASI
										FROM
											T_ZCSD2155
										WHERE
											WADAT_IST BETWEEN '$tanggal1' AND '$tanggal'
		");
		foreach ($sql_all->result_array() as $row) {
			$data['up_month']['total']=array(
										'REAL'=>$row['REALISASI']
										);
		}

		echo json_encode($data);

	}

public function chart()
	{
		
		$data=[];
		$bulan = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
		$tahun = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
		$hari = (empty($_GET['hari']) ? date('d') : $_GET['hari']);
		$tanggal = $tahun.'-'.$bulan.'-'.$hari;
		$tanggal1 = $tahun.'-'.$bulan.'-01';
		
		$allData=[];
		
		//bulan ini

		$sql=$this->db->query("
					SELECT
							VKORG,
							SUM(TON) AS REALISASI
						FROM
							T_ZCSD2155
						WHERE
							WADAT_IST = '$tanggal'
			");
		foreach ($sql->result_array() as $row) {
			$data['daily']['days']=array(
						'OPCO'=>$row['VKORG'],
						'REAL'=>$row['REALISASI']
				);
		}

		//kemasan
		$kemasan = array('121-200%','121-301%','121-302%');
		foreach ($kemasan as $value) {
		$sql_kemasan = $this->db->query("
										SELECT
											VKORG,
											ARKTX,
											WADAT_IST,
											SUM(TON) AS REALISASI
										FROM
											T_ZCSD2155
										WHERE
											WADAT_IST BETWEEN '$tanggal1' AND '$tanggal'
											AND MATNR LIKE '$value'
										GROUP BY ARKTX, WADAT_IST
										ORDER BY WADAT_IST, ARKTX
			");
			foreach ($sql_kemasan->result_array() as $row) {
				$data['daily']['kemasan'][date('j',strtotime($row['WADAT_IST']))][$row['ARKTX']]=array(
														'REAL'=>$row['REALISASI']
														);
			}
		}
		
		//WILAYAH
		$sql_wilayah =$this->db->query("
							SELECT
								T_ZCSD2155.VKORG,
								T_ZCSD2155.WADAT_IST,
								ZREPORT_SCM_KABIRO_SALES.ID_REGION,
								SUM(T_ZCSD2155.TON) AS REALISASI
							FROM
								ZREPORT_SCM_KABIRO_SALES
							INNER JOIN T_ZCSD2155 ON T_ZCSD2155.VKORG = ZREPORT_SCM_KABIRO_SALES.ORG
							AND T_ZCSD2155.VKBUR = ZREPORT_SCM_KABIRO_SALES.ID_PROV
							WHERE T_ZCSD2155.WADAT_IST BETWEEN '$tanggal1' AND '$tanggal'
							GROUP BY ZREPORT_SCM_KABIRO_SALES.ID_REGION, T_ZCSD2155.WADAT_IST
							ORDER BY T_ZCSD2155.WADAT_IST, ZREPORT_SCM_KABIRO_SALES.ID_REGION
			");

		foreach ($sql_wilayah->result_array() as $row) {
				$data['daily']['wilayah'][date('j',strtotime($row['WADAT_IST']))][$row['ID_REGION']]=array(
					'REAL'=>$row['REALISASI']
				);
		}
		
		//INCOTERM
		$sql_incoterm = $this->db->query("
			SELECT
					VKORG,
					INCO1,
					WADAT_IST,
					SUM(TON) AS REALISASI
				FROM
					T_ZCSD2155
				WHERE
					WADAT_IST BETWEEN '$tanggal1' AND '$tanggal'
				GROUP BY INCO1, WADAT_IST
				ORDER BY WADAT_IST, INCO1
			");
		foreach ($sql_incoterm->result_array() as $row) {
			$data['daily']['incoterm'][date('j',strtotime($row['WADAT_IST']))][$row['INCO1']]=array(
				'REAL'=>$row['REALISASI']
			);
		}

		//ALL
		$sql_all = $this->db->query("
										SELECT
											VKORG,
											ARKTX,
											INCO1,
											WADAT_IST,
											SUM(TON) AS REALISASI
										FROM
											T_ZCSD2155
										WHERE
											WADAT_IST LIKE '$tahun-$bulan%'
										GROUP BY
											WADAT_IST
										ORDER BY
											WADAT_IST
		");
		foreach ($sql_all->result_array() as $row) {
			$data['daily']['all'][][date('j',strtotime($row['WADAT_IST']))]=array(
													'REAL'=>$row['REALISASI']
													);
		}
		echo json_encode($data);
	}

}

/* End of file real_sales_st.php */
/* Location: ./application/controllers/real_sales_st.php */