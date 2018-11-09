<?php
header('Access-Control-Allow-Origin: *');

$month = (empty($_GET['bulan']) ? date('m') : $_GET['bulan']);
$year = (empty($_GET['tahun']) ? date('Y') : $_GET['tahun']);
$com = (empty($_GET['company']) ? '' : $_GET['company']);

$param = array('month' => $month, 'year' => $year,'last_month' => substr(('0'.($month-1)), -2), 'last_year' => $year-1, 'company' => $com);

$result = get_ms($param);



// echo json_encode($param);

//$result = oci_fetch_assoc($queryOracle);
$temp = array();
while ($row = oci_fetch_assoc($result)) {
	# code...
	if ($row['KODE_PERUSAHAAN']=='110') {
		# code...
		$company = '7000';
	} else if ($row['KODE_PERUSAHAAN']=='102') {
		# code...
		$company = '3000';
	} else if ($row['KODE_PERUSAHAAN']=='112') {
		# code...
		$company = '4000';
	}



    $qty_bln = $row['QTY'];
    $qty_bln_kmrn = $row['REAL_BULAN'];

    $qty_thn_kmrn = $row['REAL_TAHUN'];

    $qty_thn_kum = $row['REAL_TAHUNINI_KUM'];
    $qty_thn_kmrn_kum = $row['REAL_TAHUN_KUM'];
    
    if ($qty_bln_kmrn == '0') {
    	# code...
    	$growth_mom = '0';
    }else {
    	$growth_mom = round((($qty_bln - $qty_bln_kmrn) / $qty_bln_kmrn)*100,2);
    }

    if ($qty_thn_kmrn == '0') {
    	# code...
    	$growth_yoy = '0';
    }else {
    	$growth_yoy = round((($qty_bln - $qty_thn_kmrn) / $qty_thn_kmrn)*100,2);
    }

     if ($qty_thn_kmrn_kum == '0') {
    	# code...
    	$growth_kum_yoy = '0';
    }else {
    	$growth_kum_yoy = round((($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum)*100,2);
    }


	$temp[$company] = array(
			'NAMA' => $row['NAMA_PERUSAHAAN'],

			'VOLUME_BULAN' => $row['QTY'],
			'MS_BULAN' => round($row['QTY_REAL'],2),

			'LAST_VOLUME_BULAN' => $row['REAL_BULAN'],
			'LAST_MS_BULAN' => round($row['QTY_BULAN'],2),

			'MS_TAHUN_KUM' => round($row['QTY_TAHUNINI_KUM'],2),
			'TAHUN_VOLUME_KUM' => $row['REAL_TAHUNINI_KUM'],

			// 'LAST_VOLUME_TAHUN' => $row['REAL_TAHUN'],
			// 'LAST_MS_TAHUN' => round($row['QTY_TAHUN'],2),
			
			// 'LAST_MS_TAHUN_KUM' => '',
			// 'LAST_VOLUME_TAHUN_KUM' => $row['REAL_TAHUN_KUM'],

			'TARGET' => round($row['RKAP'])
			
		);

	// $temp[$company] = $row;
	$temp[$company]['GROWTH'] = array(
			'MOM' => $growth_mom,
			'YOY' => $growth_yoy,
			'KUM_YOY' => $growth_kum_yoy,
			// 'LAST_KUM_YOY' => ''
		);
}

echo json_encode($temp);

function get_ms($param){
		// $db=$this->load->database('default4',true);

		$user = "DEVSD";
		$pass = "gresik45";
		$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

		$conn = oci_connect($user, $pass, $_ora_sco);

		$company = array();
		$sqlCompany = '';
		if ($param['company']=='') {
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
										AND TAHUN = '{$param['year']}'
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
								AND TAHUN = '{$param['year']}'
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
		// echo $sql;
		$queryOracle = oci_parse($conn, $sql);
		oci_execute($queryOracle);


		return $queryOracle;



	}