<?php
error_reporting(1);
defined('BASEPATH') OR exit('No direct script access allowed');

class M_msnasional extends CI_Model {

	public function get_ms($param){
		$db=$this->load->database('default5',true);

		$sqlCompany = '';
		if ($param['company']==''||$param['company']=='smi'||$param['company']=='SMI') {
			# code...
			$sqlCompany = " WHERE tbl3.kode_perusahaan IN ('110', '102', '112')";
		}else if ($param['company']=='7000') {
			# code...
			$sqlCompany = " WHERE tbl3.kode_perusahaan IN ('110')";
		}else if ($param['company']=='3000') { //padang
			# code...
			$sqlCompany = "WHERE tbl3.kode_perusahaan IN ('102')";
		}
		else if ($param['company']=='4000') {
			# code...
			$sqlCompany = "WHERE tbl3.kode_perusahaan IN ('112')";
		}


		$sql = "
					SELECT
						TBL3.KODE_PERUSAHAAN,
						TBL3.NAMA_PERUSAHAAN,
						TBL3.PRODUK,
						TBL3.INISIAL,
						TBL3.QTY,
						NVL (TBL3.REAL_BLN, 0) QTY_REAL,
						NVL (TBL4.QTY, 0) REAL_BULAN,
						NVL (TBL4.REAL_BLN_K, 0) QTY_BULAN,
						NVL (TBL5.QTY, 0) REAL_TAHUN,
						NVL (TBL5.REAL_THN_K, 0) QTY_TAHUN,
						NVL (TBL6.QTY, 0) REAL_TAHUNINI_KUM,
						NVL (TBL6.REAL_THN_K, 0) QTY_TAHUNINI_KUM,
						NVL (TBL7.QTY, 0) REAL_TAHUN_KUM,
						NVL (TBL8.RKAP, 0) RKAP
					FROM
						(
							SELECT
								*
							FROM
								(
									SELECT
										TBL1.KODE_PERUSAHAAN,
										TBL1.QTY QTY,
										TBL2.NAMA_PERUSAHAAN,
										TBL2.PRODUK,
										TBL2.INISIAL,
										(
											(
												TBL1.QTY / (
													SELECT
														SUM (QTY_REAL)
													FROM
														ZREPORT_MS_TRANS1
													WHERE
														BULAN = '{$param['month']}'
													AND TAHUN = '{$param['year']}'
												)
											) * 100
										) REAL_BLN
									FROM
										(
											SELECT
												KODE_PERUSAHAAN,
												SUM (QTY_REAL) QTY
											FROM
												ZREPORT_MS_TRANS1
											WHERE
												BULAN = '{$param['month']}'
											AND TAHUN = '{$param['year']}'
											GROUP BY
												KODE_PERUSAHAAN
											ORDER BY
												QTY DESC
										) TBL1
									JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
									ORDER BY
										TBL1.QTY DESC
								)
						) TBL3
					JOIN (
						SELECT
							TBL1.KODE_PERUSAHAAN,
							TBL1.QTY,
							(
								(
									TBL1.QTY / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
											BULAN = '{$param['last_month']}'
										AND TAHUN = '{$param['year2']}'
									)
								) * 100
							) REAL_BLN_K
						FROM
							(
								SELECT
									KODE_PERUSAHAAN,
									SUM (QTY_REAL) QTY
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									BULAN = '{$param['last_month']}'
								AND TAHUN = '{$param['year2']}'
								GROUP BY
									KODE_PERUSAHAAN
								ORDER BY
									QTY DESC
							) TBL1
						JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
						ORDER BY
							TBL1.QTY DESC
					) TBL4 ON TBL3.KODE_PERUSAHAAN = TBL4.KODE_PERUSAHAAN
					LEFT JOIN (
						SELECT
							TBL1.KODE_PERUSAHAAN,
							TBL1.QTY,
							(
								(
									TBL1.QTY / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
											BULAN = '{$param['month']}'
										AND TAHUN = '{$param['last_year']}'
									)
								) * 100
							) REAL_THN_K
						FROM
							(
								SELECT
									KODE_PERUSAHAAN,
									SUM (QTY_REAL) QTY
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									BULAN = '{$param['month']}'
								AND TAHUN = '{$param['last_year']}'
								GROUP BY
									KODE_PERUSAHAAN
								ORDER BY
									QTY DESC
							) TBL1
						LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
						ORDER BY
							TBL1.QTY DESC
					) TBL5 ON TBL3.KODE_PERUSAHAAN = TBL5.KODE_PERUSAHAAN
					LEFT JOIN (
						SELECT
							TBL1.KODE_PERUSAHAAN,
							TBL1.QTY,
							(
								(
									TBL1.QTY / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
											BULAN <= '{$param['month']}'
										AND TAHUN = '{$param['year']}'
									)
								) * 100
							) REAL_THN_K
						FROM
							(
								SELECT
									KODE_PERUSAHAAN,
									SUM (QTY_REAL) QTY
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									BULAN <= '{$param['month']}'
								AND TAHUN = '{$param['year']}'
								GROUP BY
									KODE_PERUSAHAAN
								ORDER BY
									QTY DESC
							) TBL1
						LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
						ORDER BY
							TBL1.QTY DESC
					) TBL6 ON TBL3.KODE_PERUSAHAAN = TBL6.KODE_PERUSAHAAN
					LEFT JOIN (
						SELECT
							TBL1.KODE_PERUSAHAAN,
							TBL1.QTY,
							(
								(
									TBL1.QTY / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
											BULAN <= '{$param['month']}'
										AND TAHUN = '{$param['last_year']}'
									)
								) * 100
							) REAL_THN_K
						FROM
							(
								SELECT
									KODE_PERUSAHAAN,
									SUM (QTY_REAL) QTY
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									BULAN <= '{$param['month']}'
								AND TAHUN = '{$param['last_year']}'
								GROUP BY
									KODE_PERUSAHAAN
								ORDER BY
									QTY DESC
							) TBL1
						LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
						ORDER BY
							TBL1.QTY DESC
					) TBL7 ON TBL3.KODE_PERUSAHAAN = TBL7.KODE_PERUSAHAAN
					LEFT JOIN (
						SELECT
							KODE_PERUSAHAAN,
							(SUM(QTY) / COUNT(PROPINSI)) RKAP
						FROM
							ZREPORT_MS_RKAPMS
						WHERE
							THN = '{$param['year']}'
						AND STATUS = '0'
						GROUP BY
							KODE_PERUSAHAAN
					) TBL8 ON TBL3.KODE_PERUSAHAAN = TBL8.KODE_PERUSAHAAN

					$sqlCompany 

					ORDER BY
						TBL3.QTY DESC";
		$result = $db->query($sql);


		return $result->result_array();
	}
	public function get_ms_smi($param){
		$db=$this->load->database('default5',true);

		
		$sqlCompany = " WHERE tbl3.kode_perusahaan IN ('110', '102', '112')";
		

		$sql = "
					SELECT
						SUM (TBL3.QTY) QTY,
						SUM (NVL(TBL3.REAL_BLN, 0)) QTY_REAL,
						SUM (NVL(TBL4.QTY, 0)) REAL_BULAN,
						SUM (NVL(TBL4.REAL_BLN_K, 0)) QTY_BULAN,
						SUM (NVL(TBL5.QTY, 0)) REAL_TAHUN,
						SUM (NVL(TBL5.REAL_THN_K, 0)) QTY_TAHUN,
						SUM (NVL(TBL6.QTY, 0)) REAL_TAHUNINI_KUM,
						SUM (NVL(TBL6.REAL_THN_K, 0)) QTY_TAHUNINI_KUM,
						SUM (NVL(TBL7.QTY, 0)) REAL_TAHUN_KUM,
						SUM (NVL(TBL8.RKAP, 0)) RKAP
					FROM
						(
							SELECT
								*
							FROM
								(
									SELECT
										TBL1.KODE_PERUSAHAAN,
										TBL1.QTY QTY,
										TBL2.NAMA_PERUSAHAAN,
										TBL2.PRODUK,
										TBL2.INISIAL,
										(
											(
												TBL1.QTY / (
													SELECT
														SUM (QTY_REAL)
													FROM
														ZREPORT_MS_TRANS1
													WHERE
														BULAN = '{$param['month']}'
													AND TAHUN = '{$param['year']}'
												)
											) * 100
										) REAL_BLN
									FROM
										(
											SELECT
												KODE_PERUSAHAAN,
												SUM (QTY_REAL) QTY
											FROM
												ZREPORT_MS_TRANS1
											WHERE
												BULAN = '{$param['month']}'
											AND TAHUN = '{$param['year']}'
											GROUP BY
												KODE_PERUSAHAAN
											ORDER BY
												QTY DESC
										) TBL1
									JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
									ORDER BY
										TBL1.QTY DESC
								)
						) TBL3
					JOIN (
						SELECT
							TBL1.KODE_PERUSAHAAN,
							TBL1.QTY,
							(
								(
									TBL1.QTY / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
											BULAN = '{$param['last_month']}'
										AND TAHUN = '{$param['year2']}'
									)
								) * 100
							) REAL_BLN_K
						FROM
							(
								SELECT
									KODE_PERUSAHAAN,
									SUM (QTY_REAL) QTY
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									BULAN = '{$param['last_month']}'
								AND TAHUN = '{$param['year2']}'
								GROUP BY
									KODE_PERUSAHAAN
								ORDER BY
									QTY DESC
							) TBL1
						JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
						ORDER BY
							TBL1.QTY DESC
					) TBL4 ON TBL3.KODE_PERUSAHAAN = TBL4.KODE_PERUSAHAAN
					LEFT JOIN (
						SELECT
							TBL1.KODE_PERUSAHAAN,
							TBL1.QTY,
							(
								(
									TBL1.QTY / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
											BULAN = '{$param['month']}'
										AND TAHUN = '{$param['last_year']}'
									)
								) * 100
							) REAL_THN_K
						FROM
							(
								SELECT
									KODE_PERUSAHAAN,
									SUM (QTY_REAL) QTY
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									BULAN = '{$param['month']}'
								AND TAHUN = '{$param['last_year']}'
								GROUP BY
									KODE_PERUSAHAAN
								ORDER BY
									QTY DESC
							) TBL1
						LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
						ORDER BY
							TBL1.QTY DESC
					) TBL5 ON TBL3.KODE_PERUSAHAAN = TBL5.KODE_PERUSAHAAN
					LEFT JOIN (
						SELECT
							TBL1.KODE_PERUSAHAAN,
							TBL1.QTY,
							(
								(
									TBL1.QTY / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
											BULAN <= '{$param['month']}'
										AND TAHUN = '{$param['year']}'
									)
								) * 100
							) REAL_THN_K
						FROM
							(
								SELECT
									KODE_PERUSAHAAN,
									SUM (QTY_REAL) QTY
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									BULAN <= '{$param['month']}'
								AND TAHUN = '{$param['year']}'
								GROUP BY
									KODE_PERUSAHAAN
								ORDER BY
									QTY DESC
							) TBL1
						LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
						ORDER BY
							TBL1.QTY DESC
					) TBL6 ON TBL3.KODE_PERUSAHAAN = TBL6.KODE_PERUSAHAAN
					LEFT JOIN (
						SELECT
							TBL1.KODE_PERUSAHAAN,
							TBL1.QTY,
							(
								(
									TBL1.QTY / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
											BULAN <= '{$param['month']}'
										AND TAHUN = '{$param['last_year']}'
									)
								) * 100
							) REAL_THN_K
						FROM
							(
								SELECT
									KODE_PERUSAHAAN,
									SUM (QTY_REAL) QTY
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									BULAN <= '{$param['month']}'
								AND TAHUN = '{$param['last_year']}'
								GROUP BY
									KODE_PERUSAHAAN
								ORDER BY
									QTY DESC
							) TBL1
						LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
						ORDER BY
							TBL1.QTY DESC
					) TBL7 ON TBL3.KODE_PERUSAHAAN = TBL7.KODE_PERUSAHAAN
					LEFT JOIN (
						SELECT
							KODE_PERUSAHAAN,
							(SUM(QTY) / COUNT(PROPINSI)) RKAP
						FROM
							ZREPORT_MS_RKAPMS
						WHERE
							THN = '{$param['year']}'
						AND STATUS = '0'
						GROUP BY
							KODE_PERUSAHAAN
					) TBL8 ON TBL3.KODE_PERUSAHAAN = TBL8.KODE_PERUSAHAAN

					$sqlCompany 

					ORDER BY
						TBL3.QTY DESC";
		$result = $db->query($sql);


		return $result->result_array();
	}
	public function get_msnasional()
	{
		$db=$this->load->database('default4',true);
		if (!empty($_GET['tahun'])) {
    	$tahun = $_GET['tahun'];
		} else {
		    $tahun = date('Y');
		}

		if (!empty($_GET['bulan'])) {
		    $bln = $_GET['bulan'];
		} else {
		    $bln = date('m');
		}
		$panjang = strlen($bln);
		if($panjang == 1){
		    $bulan = '0'.$bln;
		    $bulan_before = '0'.($bulan - 1);
		} else {
		    $bulan = $bln;
		    $bulan_before = $bulan - 1;
		}
		$tahun_before = $tahun - 1;

		$sql = $db->query("SELECT
			TBL3.KODE_PERUSAHAAN,
			TBL3.NAMA_PERUSAHAAN,
			TBL3.PRODUK,
			TBL3.INISIAL,
			TBL3.QTY QTY_BLN,
			NVL (TBL3.REAL_BLN, 0) MS_BLN,
			NVL (TBL4.QTY, 0) QTY_BLN_KMRN,
			NVL (TBL4.REAL_BLN_K, 0) MS_BLN_KUM,
			NVL (TBL5.QTY, 0) QTY_THN_KMRN,
			NVL (TBL5.REAL_THN_K, 0) MS_THN,
			NVL (TBL6.QTY, 0) QTY_THN_KUM,
			NVL (TBL6.REAL_THN_K, 0) MS_THN_KUM,
			NVL (TBL7.QTY, 0) QTY_THN_KMRN_KUM
		FROM
			(
				SELECT
					*
				FROM
					(
						SELECT
							TBL1.KODE_PERUSAHAAN,
							TBL1.QTY QTY,
							TBL2.NAMA_PERUSAHAAN,
							TBL2.PRODUK,
							TBL2.INISIAL,
							(
								(
									TBL1.QTY / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
											BULAN = '" . $bulan . "'
										AND TAHUN = '" . $tahun . "'
									)
								) * 100
							) REAL_BLN
						FROM
							(
								SELECT
									KODE_PERUSAHAAN,
									SUM (QTY_REAL) QTY
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									BULAN = '" . $bulan . "'
								AND TAHUN = '" . $tahun . "'
								GROUP BY
									KODE_PERUSAHAAN
								ORDER BY
									QTY DESC
							) TBL1
						JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
						ORDER BY
							TBL1.QTY DESC
					)
			) TBL3
		JOIN (
			SELECT
				TBL1.KODE_PERUSAHAAN,
				TBL1.QTY,
				(
					(
						TBL1.QTY / (
							SELECT
								SUM (QTY_REAL)
							FROM
								ZREPORT_MS_TRANS1
							WHERE
								BULAN = '" . $bulan_before . "'
							AND TAHUN = '" . $tahun . "'
						)
					) * 100
				) REAL_BLN_K
			FROM
				(
					SELECT
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) QTY
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '" . $bulan_before . "'
					AND TAHUN = '" . $tahun . "'
					GROUP BY
						KODE_PERUSAHAAN
					ORDER BY
						QTY DESC
				) TBL1
			JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
			ORDER BY
				TBL1.QTY DESC
		) TBL4 ON TBL3.KODE_PERUSAHAAN = TBL4.KODE_PERUSAHAAN
		LEFT JOIN (
			SELECT
				TBL1.KODE_PERUSAHAAN,
				TBL1.QTY,
				(
					(
						TBL1.QTY / (
							SELECT
								SUM (QTY_REAL)
							FROM
								ZREPORT_MS_TRANS1
							WHERE
								BULAN = '" . $bulan . "'
							AND TAHUN = '" . $tahun_before . "'
						)
					) * 100
				) REAL_THN_K
			FROM
				(
					SELECT
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) QTY
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '" . $bulan . "'
					AND TAHUN = '" . $tahun_before . "'
					GROUP BY
						KODE_PERUSAHAAN
					ORDER BY
						QTY DESC
				) TBL1
			LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
			ORDER BY
				TBL1.QTY DESC
		) TBL5 ON TBL3.KODE_PERUSAHAAN = TBL5.KODE_PERUSAHAAN
		LEFT JOIN (
			SELECT
				TBL1.KODE_PERUSAHAAN,
				TBL1.QTY,
				(
					(
						TBL1.QTY / (
							SELECT
								SUM (QTY_REAL)
							FROM
								ZREPORT_MS_TRANS1
							WHERE
								BULAN <= '" . $bulan . "'
							AND TAHUN = '" . $tahun . "'
						)
					) * 100
				) REAL_THN_K
			FROM
				(
					SELECT
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) QTY
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN <= '" . $bulan . "'
					AND TAHUN = '" . $tahun . "'
					GROUP BY
						KODE_PERUSAHAAN
					ORDER BY
						QTY DESC
				) TBL1
			LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
			ORDER BY
				TBL1.QTY DESC
		) TBL6 ON TBL3.KODE_PERUSAHAAN = TBL6.KODE_PERUSAHAAN
		LEFT JOIN (
			SELECT
				TBL1.KODE_PERUSAHAAN,
				TBL1.QTY,
				(
					(
						TBL1.QTY / (
							SELECT
								SUM (QTY_REAL)
							FROM
								ZREPORT_MS_TRANS1
							WHERE
								BULAN <= '" . $bulan . "'
							AND TAHUN = '" . $tahun_before . "'
						)
					) * 100
				) REAL_THN_K
			FROM
				(
					SELECT
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) QTY
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN <= '" . $bulan . "'
					AND TAHUN = '" . $tahun_before . "'
					GROUP BY
						KODE_PERUSAHAAN
					ORDER BY
						QTY DESC
				) TBL1
			LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
			ORDER BY
				TBL1.QTY DESC
		) TBL7 ON TBL3.KODE_PERUSAHAAN = TBL7.KODE_PERUSAHAAN
		ORDER BY
			TBL3.QTY DESC");

		foreach ($sql->result_array() as $rowID) {
		    
		    $kode_perusahaan = $rowID['KODE_PERUSAHAAN'];
		    $nama_perusahaan = $rowID['NAMA_PERUSAHAAN'];
		    $produk = $rowID['PRODUK'];
		    $inisial = $rowID['INISIAL'];
		    $qty_bln = $rowID['QTY_BLN'];
		    $ms_bln = $rowID['MS_BLN'];
		    $qty_bln_kmrn = $rowID['QTY_BLN_KMRN'];
		    $ms_bln_kum = $rowID['MS_BLN_KUM'];
		    $qty_thn_kmrn = $rowID['QTY_THN_KMRN'];
		    $ms_thn = $rowID['MS_THN'];
		    $qty_thn_kum = $rowID['QTY_THN_KUM'];
		    $ms_thn_kum = $rowID['MS_THN_KUM'];
		    $qty_thn_kmrn_kum = $rowID['QTY_THN_KMRN_KUM'];
		    
		    //rumus
		    $growth_mom = ($qty_bln - $qty_bln_kmrn) / $qty_bln_kmrn;
		    $growth_yoy = ($qty_bln - $qty_thn_kmrn) / $qty_thn_kmrn;
		    $growth_kum_yoy = ($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum;

		    $text[$kode_perusahaan] = array(
		        "kode_perusahaan" => $kode_perusahaan,
		        "nama_perusahaan" => $nama_perusahaan,
		        "produk" => $produk,
		        "inisial" => $inisial,
		        "qty_bln" => $qty_bln,
		        "ms_bln" => $ms_bln,
		        "qty_bln_kmrn" => $qty_bln_kmrn,
		        "ms_bln_kum" => $ms_bln_kum,
		        "qty_thn_kmrn" => $qty_thn_kmrn,
		        "ms_thn" => $ms_thn,
		        "qty_thn_kum" => $qty_thn_kum,
		        "ms_thn_kum" => $ms_thn_kum,
		        "qty_thn_kmrn_kum" => $qty_thn_kmrn_kum,
		        "growth_mom" => $growth_mom,
		        "growth_yoy" => $growth_yoy,
		        "growth_kum_yoy" => $growth_kum_yoy
		    );
		}
		echo '{"ms_nasional":'.json_encode($text).'}';
	}

	public function get_ms_com($param){
		$db=$this->load->database('default5',true);
		

		$sqlCompany = '';
		if ($param['company']=='') {
			# code...
			$sqlCompany = " WHERE tbl1.kode_perusahaan IN ('110', '102', '112')";
		}else if ($param['company']=='7000') {
			# code...
			$sqlCompany = " WHERE tbl1.kode_perusahaan IN ('110')";
		}else if ($param['company']=='3000') { //padang
			# code...
			$sqlCompany = "WHERE tbl1.kode_perusahaan IN ('102')";
		}
		else if ($param['company']=='4000') {
			# code...
			$sqlCompany = "WHERE tbl1.kode_perusahaan IN ('112')";
		}


		$sql = "
				
				SELECT
					TBL1.*,
					TBL2.NAMA_PERUSAHAAN,
					TBL8.NM_PROV,
					TBL8.NM_PROV_1 AS PROVINSI,
					NVL (TBL4.REAL_BULAN, 0) REAL_BULAN,
					NVL (TBL4.QTY_BULAN, 0) QTY_BULAN,
					NVL (TBL5.REAL_TAHUN, 0) REAL_TAHUN,
					NVL (TBL5.QTY_TAHUN, 0) QTY_TAHUN,
					NVL (TBL51.REAL_BULAN, 0) REAL_BLN_THN_KMRIN,
					NVL (TBL51.QTY_BULAN, 0) QTY_BLN_THN_KMRIN,
					NVL (TBL6.REAL_TAHUN_KUM, 0) REAL_TAHUN_KUM,
					NVL (TBL6.QTY_TAHUN_KUM, 0) QTY_TAHUN_KUM,
					NVL (TBL7.REAL_TAHUNINI_KUM, 0) REAL_TAHUNINI_KUM,
					NVL (TBL7.QTY_TAHUNINI_KUM, 0) QTY_TAHUNINI_KUM,
					NVL (TBL9.TARGET_RKAP, 0) TARGET_RKAP
				FROM
					(
						SELECT
							A .KODE_PERUSAHAAN,
							A .PROPINSI,
							SUM (A .QTY_REAL) QTY,
							(
								(
									SUM (A .QTY_REAL) / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
										BULAN = '{$param['month']}'
										AND TAHUN = '{$param['year']}'
										AND STATUS = '0'
									)
								) * 100
							) QTY_REAL
						FROM
							ZREPORT_MS_TRANS1 A
						WHERE
						A .BULAN = '{$param['month']}'
						AND A .TAHUN = '{$param['year']}'
						AND A .STATUS = '0'
						GROUP BY
							A .KODE_PERUSAHAAN,
							A .PROPINSI
					) TBL1
				LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
				LEFT JOIN (
					SELECT
						KODE_PERUSAHAAN,
						PROPINSI,
						SUM (QTY_REAL) REAL_BULAN,
						(
							SUM (QTY_REAL) / (
								SELECT
									SUM (QTY_REAL)
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									STATUS = '0'
								AND BULAN = '{$param['last_month']}'
								AND TAHUN = '{$param['year2']}'
							)
						) * 100 QTY_BULAN
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '{$param['last_month']}'
					AND TAHUN = '{$param['year2']}'
					GROUP BY
						PROPINSI,KODE_PERUSAHAAN
				) TBL4 ON TBL1.KODE_PERUSAHAAN = TBL4.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL4.PROPINSI
				LEFT JOIN (
					SELECT
						KODE_PERUSAHAAN,
						PROPINSI,
						SUM (QTY_REAL) REAL_TAHUN,
						(
							(
								SUM (QTY_REAL) / (
									SELECT
										SUM (QTY_REAL)
									FROM
										ZREPORT_MS_TRANS1
									WHERE
										STATUS = '0'
									AND BULAN = '{$param['month']}'
									AND TAHUN = '{$param['last_year']}'
								)
							) * 100
						) QTY_TAHUN
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '{$param['month']}'
					AND TAHUN = '{$param['last_year']}'
					GROUP BY
						PROPINSI ,KODE_PERUSAHAAN
				) TBL5 ON TBL1.KODE_PERUSAHAAN = TBL5.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL5.PROPINSI
				LEFT JOIN (
					SELECT
						KODE_PERUSAHAAN,
						PROPINSI,
						SUM (QTY_REAL) REAL_BULAN,
						(
							(
								SUM (QTY_REAL) / (
									SELECT
										SUM (QTY_REAL)
									FROM
										ZREPORT_MS_TRANS1
									WHERE
										STATUS = '0'
									AND BULAN = '{$param['last_month']}'
									AND TAHUN = '{$param['last_year']}'
								)
							) * 100
						) QTY_BULAN
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '{$param['last_month']}'
					AND TAHUN = '{$param['last_year']}'
					GROUP BY
						PROPINSI ,KODE_PERUSAHAAN
				) TBL51 ON TBL1.KODE_PERUSAHAAN = TBL51.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL51.PROPINSI
				LEFT JOIN (
					SELECT
						KODE_PERUSAHAAN,
						PROPINSI,
						SUM (QTY_REAL) REAL_TAHUN_KUM,
						(
							(
								SUM (QTY_REAL) / (
									SELECT
										SUM (QTY_REAL)
									FROM
										ZREPORT_MS_TRANS1
									WHERE
										STATUS = '0'
									AND BULAN <= '{$param['month']}'
									AND TAHUN = '{$param['last_year']}'
								)
							) * 100
						) QTY_TAHUN_KUM
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN <= '{$param['month']}'
					AND TAHUN = '{$param['last_year']}'
					GROUP BY
						PROPINSI,KODE_PERUSAHAAN
				) TBL6 ON TBL1.KODE_PERUSAHAAN = TBL6.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL6.PROPINSI
				LEFT JOIN (
					SELECT
						KODE_PERUSAHAAN,
						PROPINSI,
						SUM (QTY_REAL) REAL_TAHUNINI_KUM,
						(
							(
								SUM (QTY_REAL) / (
									SELECT
										SUM (QTY_REAL)
									FROM
										ZREPORT_MS_TRANS1
									WHERE
										STATUS = '0'
									AND BULAN <= '{$param['month']}'
									AND TAHUN = '{$param['year']}'
								)
							) * 100
						) QTY_TAHUNINI_KUM
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN <= '{$param['month']}'
					AND TAHUN = '{$param['year']}'
					GROUP BY
						PROPINSI,KODE_PERUSAHAAN
				) TBL7 ON TBL1.KODE_PERUSAHAAN = TBL7.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL7.PROPINSI
				LEFT JOIN ZREPORT_M_PROVINSI TBL8 ON TBL1.PROPINSI = TBL8.KD_PROV
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY) TARGET_RKAP
					FROM
						ZREPORT_MS_RKAPMS
					WHERE
						THN = '{$param['year']}'
					AND STATUS = '0'
					GROUP BY
						PROPINSI,
						KODE_PERUSAHAAN
				) TBL9 ON TBL1.PROPINSI = TBL9.PROPINSI
				AND TBL1.KODE_PERUSAHAAN = TBL9.KODE_PERUSAHAAN

				$sqlCompany
				
				-- ORDER BY
					-- TBL1.QTY_REAL DESC";
		// echo $sql;
					
		$result = $db->query($sql);


		return $result->result_array();

	}
	
	public function get_provinsi(){
		$db=$this->load->database('default5',true);

		$sql = "SELECT KD_PROV, NM_PROV, NM_PROV_1 FROM ZREPORT_M_PROVINSI";

		$result = $db->query($sql);


		return $result->result_array();


	}

	public function get_detail_prov2($provinsi, $bulan, $tahun){
		$db=$this->load->database('default5',true);


		$tahunkemarin = $tahun-1;
		$tahun2 = $tahun;
		$bulankemarin = substr(('0'.($bulan-1)), -2);

		if ($bulankemarin=='00') {
			$bulankemarin = '12';
			$tahun2 = $tahun-1;
		}



		$sqlProvinsi = "";
		if ($provinsi!='') {
			// $sqlProvinsi =  "AND PROPINSI = '$provinsi' ";
			// $sqlProvinsi2 = "a.PROPINSI = '$provinsi' AND";
			if ($provinsi == 'x') {
				$sqlProvinsi =  "AND PROPINSI IN ('0001', '1092') ";
				$sqlProvinsi2 = "a.PROPINSI IN ('0001', '1092') AND";
			}
			else
			if ($provinsi == '1') {
				$sqlProvinsi =  "AND PROPINSI IN ('1022', '1021', '1024', '1023', '1025', '1020') ";
				$sqlProvinsi2 = "a.PROPINSI IN ('1022', '1021', '1024', '1023', '1025', '1020') AND";
			} else if ($provinsi == '2') {
				$sqlProvinsi =  "AND PROPINSI IN ('1019', '1013', '1018', '1017', '1016', '1015', '1014', '1012', '1011', '1010') ";
				$sqlProvinsi2 = "a.PROPINSI IN ('1019', '1013', '1018', '1017', '1016', '1015', '1014', '1012', '1011', '1010') AND";

			} else if ($provinsi == '3') {
				$sqlProvinsi =  "AND PROPINSI IN ('1029', '1043', '1030', '1031', '1032') ";
				$sqlProvinsi2 = "a.PROPINSI IN ('1029', '1043', '1030', '1031', '1032') AND";

			} else if ($provinsi == '4') {
				$sqlProvinsi =  "AND PROPINSI IN ('1035', '1034', '1033', '1036', '1037', '1038') ";
				$sqlProvinsi2 = "a.PROPINSI IN ('1035', '1034', '1033', '1036', '1037', '1038') AND";

			} else if ($provinsi == '5') {
				      
				$sqlProvinsi =  "AND PROPINSI IN ('1026', '1027', '1028') ";
				$sqlProvinsi2 = "a.PROPINSI IN ('1026', '1027', '1028') AND";
			} else if ($provinsi == '6') {
				$sqlProvinsi =  "AND PROPINSI IN ('1039', '1041', '1040', '1042') ";
				$sqlProvinsi2 = "a.PROPINSI IN ('1039', '1041', '1040', '1042') AND";
			} 

		} else {
			$sqlProvinsi = " ";
			$sqlProvinsi2 = " ";
		}



		$sql = "SELECT
				  	TBL1.*, TBL2.NAMA_PERUSAHAAN,
				 	NVL (TBL4.REAL_BULAN, 0) REAL_BULAN,
				 	NVL (TBL4.QTY_BULAN, 0) QTY_BULAN,
				 	NVL (TBL5.REAL_TAHUN, 0) REAL_TAHUN,
				 	NVL (TBL5.QTY_TAHUN, 0) QTY_TAHUN,
				 	NVL (TBL6.REAL_TAHUN_KUM, 0) REAL_TAHUN_KUM,
				 	NVL (TBL6.QTY_TAHUN_KUM, 0) QTY_TAHUN_KUM,
				 	NVL (TBL7.REAL_TAHUNINI_KUM, 0) REAL_TAHUNINI_KUM,
				 	NVL (TBL7.QTY_TAHUNINI_KUM, 0) QTY_TAHUNINI_KUM,
				 	TBL8.NM_PROV,
				 	NVL (TBL9.TARGET_RKAP, 0) TARGET_RKAP
				FROM
					(
						SELECT
							A .KODE_PERUSAHAAN,
							A .PROPINSI,
							SUM (A .QTY_REAL) QTY,
							(
								(
									SUM (A .QTY_REAL) / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
											BULAN = '$bulan'
										$sqlProvinsi
										AND TAHUN = '$tahun'
										AND STATUS = '0'
									)
								) * 100
							) QTY_REAL
						FROM
							ZREPORT_MS_TRANS1 A
						WHERE
							$sqlProvinsi2 
							A .BULAN = '$bulan'
						AND A .TAHUN = '$tahun'
						AND A .STATUS = '0'
						GROUP BY
							A .KODE_PERUSAHAAN,
							A .PROPINSI
					) TBL1
				LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) REAL_BULAN,
						(
							SUM (QTY_REAL) / (
								SELECT
									SUM (QTY_REAL)
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									STATUS = '0'
								AND BULAN = '$bulankemarin'
								AND TAHUN = '$tahun' -- AND PROPINSI = '1'
								$sqlProvinsi
							)
						) * 100 QTY_BULAN
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '$bulankemarin'
					AND TAHUN = '$tahun2'
					$sqlProvinsi
					GROUP BY
						KODE_PERUSAHAAN, PROPINSI
				) TBL4 ON TBL1.KODE_PERUSAHAAN = TBL4.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL4.PROPINSI
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) REAL_TAHUN,
						(
							(
								SUM (QTY_REAL) / (
									SELECT
										SUM (QTY_REAL)
									FROM
										ZREPORT_MS_TRANS1
									WHERE
										STATUS = '0'
									AND BULAN = '$bulan'
									AND TAHUN = '$tahunkemarin' -- AND PROPINSI = '1'
									$sqlProvinsi
								)
							) * 100
						) QTY_TAHUN
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '$bulan'
					AND TAHUN = '$tahunkemarin'
					$sqlProvinsi
					GROUP BY
						KODE_PERUSAHAAN, PROPINSI
				) TBL5 ON TBL1.KODE_PERUSAHAAN = TBL5.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL5.PROPINSI 
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) REAL_TAHUN_KUM,
						(
							(
								SUM (QTY_REAL) / (
									SELECT
										SUM (QTY_REAL)
									FROM
										ZREPORT_MS_TRANS1
									WHERE
										STATUS = '0'
									AND BULAN <= '$bulan'
									AND TAHUN = '$tahunkemarin' -- AND PROPINSI = '1'
									$sqlProvinsi
								)
							) * 100
						) QTY_TAHUN_KUM
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN <= '$bulan'
					AND TAHUN = '$tahunkemarin'
					$sqlProvinsi
					GROUP BY
						KODE_PERUSAHAAN, PROPINSI
				) TBL6 ON TBL1.KODE_PERUSAHAAN = TBL6.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL6.PROPINSI
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) REAL_TAHUNINI_KUM,
						(
							(
								SUM (QTY_REAL) / (
									SELECT
										SUM (QTY_REAL)
									FROM
										ZREPORT_MS_TRANS1
									WHERE
										STATUS = '0'
									AND BULAN <= '$bulan'
									AND TAHUN = '$tahun' -- AND PROPINSI = '1'
									$sqlProvinsi
								)
							) * 100
						) QTY_TAHUNINI_KUM
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN <= '$bulan'
					AND TAHUN = '$tahun'
					$sqlProvinsi
					GROUP BY
						KODE_PERUSAHAAN,PROPINSI
				) TBL7 ON TBL1.KODE_PERUSAHAAN = TBL7.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL7.PROPINSI
				LEFT JOIN ZREPORT_M_PROVINSI TBL8 ON TBL1.PROPINSI = TBL8.KD_PROV
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY) TARGET_RKAP
					FROM
						ZREPORT_MS_RKAPMS
					WHERE
						THN = '$tahun'
					AND STATUS = '0'
					GROUP BY
						PROPINSI,
						KODE_PERUSAHAAN
				) TBL9 ON TBL1.PROPINSI = TBL9.PROPINSI
				AND TBL1.KODE_PERUSAHAAN = TBL9.KODE_PERUSAHAAN
				WHERE TBL1.KODE_PERUSAHAAN = 110
				-- GROUP BY TBL1.KODE_PERUSAHAAN
				 ORDER BY
					TBL1.QTY_REAL DESC";

        // echo $sql;
        $result = $db->query($sql);


		return $result->result_array();
	}

	public function getSummaryProv($sqlProvinsi, $bulan, $tahun){
		$db=$this->load->database('default5',true);

		$tahunkemarin = $tahun-1;
		$tahun2 = $tahun;
		$bulankemarin = substr(('0'.($bulan-1)), -2);

		if ($bulankemarin=='00') {
			$bulankemarin = '12';
			$tahun2 = $tahun-1;
		}

		$sql = "

			SELECT
				TBNOW.PROPINSI,
				TBNOW.SUM_PROVINSI 			SUM_CURRENT_MONTH,
				TBNOWLAST.SUM_PROVINSI 	SUM_LAST_MONTH,
				TBYEAR.SUM_PROVINSI 		SUM_YEAR_MONTH,
				TBLASTYEAR.SUM_PROVINSI SUM_LAST_YEAR_MONTH,
				TBKUM.SUM_PROVINSI 			SUM_KUM_YEAR_CURRENT,
				TBKUMLAST.SUM_PROVINSI 	SUM_KUM_YEAR_LAST
			FROM
				(
					SELECT
						PROPINSI,
						SUM (QTY_REAL) SUM_PROVINSI
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '$bulan'
					AND TAHUN = '$tahun'
					AND STATUS = '0'

					GROUP BY
						PROPINSI
				) TBNOW 
			LEFT JOIN (
				SELECT
					PROPINSI,
					SUM (QTY_REAL) SUM_PROVINSI
				FROM
					ZREPORT_MS_TRANS1
				WHERE
					BULAN = '$bulankemarin'
				AND TAHUN = '$tahun2'
				AND STATUS = '0'

				GROUP BY
					PROPINSI
			) TBNOWLAST ON TBNOW.PROPINSI = TBNOWLAST.PROPINSI
			LEFT JOIN (
				SELECT
					PROPINSI,
					SUM (QTY_REAL) SUM_PROVINSI
				FROM
					ZREPORT_MS_TRANS1
				WHERE
					BULAN = '$bulankemarin'
				AND TAHUN = '$tahunkemarin'
				AND STATUS = '0'

				GROUP BY
					PROPINSI
			) TBLASTYEAR ON TBNOW.PROPINSI = TBLASTYEAR.PROPINSI
			LEFT JOIN (
				SELECT
					PROPINSI,
					SUM (QTY_REAL) SUM_PROVINSI
				FROM
					ZREPORT_MS_TRANS1
				WHERE
					BULAN = '$bulan'
				AND TAHUN = '$tahunkemarin'
				AND STATUS = '0'

				GROUP BY
					PROPINSI
			) TBYEAR ON TBNOW.PROPINSI = TBYEAR.PROPINSI
			LEFT JOIN (
				SELECT
					PROPINSI,
					SUM (QTY_REAL) SUM_PROVINSI
				FROM
					ZREPORT_MS_TRANS1
				WHERE
					BULAN <= '$bulan'
				AND TAHUN = '$tahun'
				AND STATUS = '0'

				GROUP BY
					PROPINSI
			) TBKUM ON TBNOW.PROPINSI = TBKUM.PROPINSI
			LEFT JOIN (
				SELECT
					PROPINSI,
					SUM (QTY_REAL) SUM_PROVINSI
				FROM
					ZREPORT_MS_TRANS1
				WHERE
					BULAN <= '$bulan'
				AND TAHUN = '$tahunkemarin'
				AND STATUS = '0'

				GROUP BY
					PROPINSI
			) TBKUMLAST ON TBNOW.PROPINSI = TBKUMLAST.PROPINSI
			$sqlProvinsi
				
		";

		$result = $db->query($sql);


		return $result->result_array();

	}
	public function get_detail_prov($sqlProvinsi, $sqlProvinsi2, $bulan, $tahun){
		$db=$this->load->database('default5',true);


		$tahunkemarin = $tahun-1;
		$tahun2 = $tahun;
		$bulankemarin = substr(('0'.($bulan-1)), -2);

		if ($bulankemarin=='00') {
			$bulankemarin = '12';
			$tahun2 = $tahun-1;
		}

		$sql = "SELECT
				  	TBL1.*, TBL2.NAMA_PERUSAHAAN,
				 	NVL (TBL4.REAL_BULAN, 0) REAL_BULAN,
				 	NVL (TBL4.QTY_BULAN, 0) QTY_BULAN,
				 	NVL (TBL5.REAL_TAHUN, 0) REAL_TAHUN,
				 	NVL (TBL5.QTY_TAHUN, 0) QTY_TAHUN,

				 	NVL (TBL51.REAL_BULAN, 0) REAL_BLN_THN_KMRIN,
				 	NVL (TBL51.QTY_BULAN, 0) QTY_BLN_THN_KMRIN,

				 	NVL (TBL6.REAL_TAHUN_KUM, 0) REAL_TAHUN_KUM,
				 	NVL (TBL6.QTY_TAHUN_KUM, 0) QTY_TAHUN_KUM,
				 	NVL (TBL7.REAL_TAHUNINI_KUM, 0) REAL_TAHUNINI_KUM,
				 	NVL (TBL7.QTY_TAHUNINI_KUM, 0) QTY_TAHUNINI_KUM,
				 	TBL8.NM_PROV,
				 	NVL (TBL9.TARGET_RKAP, 0) TARGET_RKAP
				FROM
					(
						SELECT
							A .KODE_PERUSAHAAN,
							A .PROPINSI,
							SUM (A .QTY_REAL) QTY
							,
							(
								(
									SUM (A .QTY_REAL) / (
										SELECT
											SUM (QTY_REAL)
										FROM
											ZREPORT_MS_TRANS1
										WHERE
											BULAN = '$bulan'
										$sqlProvinsi
										AND TAHUN = '$tahun'
										AND STATUS = '0'
									)
								) * 100
							) QTY_REAL
						FROM
							ZREPORT_MS_TRANS1 A
						WHERE
							$sqlProvinsi2 
							A .BULAN = '$bulan'
						AND A .TAHUN = '$tahun'
						AND A .STATUS = '0'
						GROUP BY
							A .KODE_PERUSAHAAN,
							A .PROPINSI
					) TBL1
				LEFT JOIN ZREPORT_MS_PERUSAHAAN TBL2 ON TBL1.KODE_PERUSAHAAN = TBL2.KODE_PERUSAHAAN
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) REAL_BULAN
						,
						(
							SUM (QTY_REAL) / (
								SELECT
									SUM (QTY_REAL)
								FROM
									ZREPORT_MS_TRANS1
								WHERE
									STATUS = '0'
								AND BULAN = '$bulankemarin'
								AND TAHUN = '$tahun2' -- AND PROPINSI = '1'
								$sqlProvinsi
							)
						) * 100 QTY_BULAN
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '$bulankemarin'
					AND TAHUN = '$tahun2'
					$sqlProvinsi
					GROUP BY
						KODE_PERUSAHAAN, PROPINSI
				) TBL4 ON TBL1.KODE_PERUSAHAAN = TBL4.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL4.PROPINSI
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) REAL_TAHUN
						,
						(
							(
								SUM (QTY_REAL) / (
									SELECT
										SUM (QTY_REAL)
									FROM
										ZREPORT_MS_TRANS1
									WHERE
										STATUS = '0'
									AND BULAN = '$bulan'
									AND TAHUN = '$tahunkemarin' -- AND PROPINSI = '1'
									$sqlProvinsi
								)
							) * 100
						) QTY_TAHUN
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '$bulan'
					AND TAHUN = '$tahunkemarin'
					$sqlProvinsi
					GROUP BY
						KODE_PERUSAHAAN, PROPINSI
				) TBL5 ON TBL1.KODE_PERUSAHAAN = TBL5.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL5.PROPINSI 
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) REAL_BULAN
						,
						(
							(
								SUM (QTY_REAL) / (
									SELECT
										SUM (QTY_REAL)
									FROM
										ZREPORT_MS_TRANS1
									WHERE
										STATUS = '0'
									AND BULAN = '$bulankemarin'
									AND TAHUN = '$tahunkemarin' -- AND PROPINSI = '1'
									$sqlProvinsi
								)
							) * 100
						) QTY_BULAN
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '$bulankemarin'
					AND TAHUN = '$tahunkemarin'
					$sqlProvinsi
					GROUP BY
						KODE_PERUSAHAAN, PROPINSI
				) TBL51 ON TBL1.KODE_PERUSAHAAN = TBL51.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL51.PROPINSI 
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) REAL_TAHUN_KUM
						,
						(
							(
								SUM (QTY_REAL) / (
									SELECT
										SUM (QTY_REAL)
									FROM
										ZREPORT_MS_TRANS1
									WHERE
										STATUS = '0'
									AND BULAN <= '$bulan'
									AND TAHUN = '$tahunkemarin' -- AND PROPINSI = '1'
									$sqlProvinsi
								)
							) * 100
						) QTY_TAHUN_KUM
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN <= '$bulan'
					AND TAHUN = '$tahunkemarin'
					$sqlProvinsi
					GROUP BY
						KODE_PERUSAHAAN, PROPINSI
				) TBL6 ON TBL1.KODE_PERUSAHAAN = TBL6.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL6.PROPINSI
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY_REAL) REAL_TAHUNINI_KUM
						,
						(
							(
								SUM (QTY_REAL) / (
									SELECT
										SUM (QTY_REAL)
									FROM
										ZREPORT_MS_TRANS1
									WHERE
										STATUS = '0'
									AND BULAN <= '$bulan'
									AND TAHUN = '$tahun' -- AND PROPINSI = '1'
									$sqlProvinsi
								)
							) * 100
						) QTY_TAHUNINI_KUM
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN <= '$bulan'
					AND TAHUN = '$tahun'
					$sqlProvinsi
					GROUP BY
						KODE_PERUSAHAAN,PROPINSI
				) TBL7 ON TBL1.KODE_PERUSAHAAN = TBL7.KODE_PERUSAHAAN AND TBL1.PROPINSI = TBL7.PROPINSI
				LEFT JOIN ZREPORT_M_PROVINSI TBL8 ON TBL1.PROPINSI = TBL8.KD_PROV
				LEFT JOIN (
					SELECT
						PROPINSI,
						KODE_PERUSAHAAN,
						SUM (QTY) TARGET_RKAP
					FROM
						ZREPORT_MS_RKAPMS
					WHERE
						THN = '$tahun'
					AND STATUS = '0'
					GROUP BY
						PROPINSI,
						KODE_PERUSAHAAN
				) TBL9 ON TBL1.PROPINSI = TBL9.PROPINSI
				AND TBL1.KODE_PERUSAHAAN = TBL9.KODE_PERUSAHAAN
				--WHERE TBL1.KODE_PERUSAHAAN = 110
				-- GROUP BY TBL1.KODE_PERUSAHAAN
				 ORDER BY
					TBL1.QTY_REAL DESC";

        // echo $sql;
        $result = $db->query($sql);


		return $result->result_array();
	}

}

/* End of file m_msnasional.php */
/* Location: ./application/models/m_msnasional.php */