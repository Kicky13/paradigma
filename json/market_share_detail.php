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
$company = 'default';
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

    $namaProv = $row['NM_PROV'];
	$temp[$namaProv] = array(
			// 'NAMA' => $row['NAMA_PERUSAHAAN'],
			'PROV' => $row['NM_PROV'],
			'INISIAL_PROV' => $row['PROVINSI'],
			'VOLUME_BULAN' => $row['QTY'],
			'MS_BULAN' => round($row['QTY_REAL'],2),


			'LAST_VOLUME_BULAN' => $row['REAL_BULAN'],
			'LAST_MS_BULAN' => round($row['QTY_BULAN'],2),

			'MS_TAHUN_KUM' => round($row['QTY_TAHUNINI_KUM'],2),
			'TAHUN_VOLUME_KUM' => $row['REAL_TAHUNINI_KUM'],

			'LAST_VOLUME_TAHUN' => $row['REAL_TAHUN'],
			'LAST_MS_TAHUN' => round($row['QTY_TAHUN'],2),
			
			// 'LAST_MS_TAHUN_KUM' => '',
			// 'LAST_VOLUME_TAHUN_KUM' => $row['REAL_TAHUN_KUM'],

			'TARGET' => round($row['TARGET_RKAP'])
			
		);

	// $temp[$company] = $row;
	$temp[$namaProv]['GROWTH'] = array(
			'MOM' => $growth_mom,
			'YOY' => $growth_yoy,
			'KUM_YOY' => $growth_kum_yoy,
			// 'LAST_KUM_YOY' => ''
		);
	$jsonArray[$company] = $temp;
}

echo json_encode($jsonArray);


//model
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
								AND TAHUN = '{$param['year']}'
							)
						) * 100 QTY_BULAN
					FROM
						ZREPORT_MS_TRANS1
					WHERE
						BULAN = '{$param['last_month']}'
					AND TAHUN = '{$param['year']}'
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
				
				--ORDER BY
				--	TBL1.QTY_REAL DESC";
		// echo $sql;
		$queryOracle = oci_parse($conn, $sql);
		oci_execute($queryOracle);


		return $queryOracle;



	}
