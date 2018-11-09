<?php
header('Access-Control-Allow-Origin: *');
$user = "DEVSD";
$pass = "gresik45";
$_ora_sco = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.101)(PORT = 1521))) (CONNECT_DATA = (SID = devsgg)(SERVER = DEDICATED)))';

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


$conn = oci_connect($user, $pass, $_ora_sco);
$sql = "SELECT
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
	TBL3.QTY DESC";


$queryOracle = oci_parse($conn, $sql);
oci_execute($queryOracle);
$text = array();
while ($rowID = oci_fetch_array($queryOracle)) {
    
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
    //$growth_yoy = ($qty_bln - $qty_thn_kmrn) / $qty_thn_kmrn;
    //$growth_kum_yoy = ($qty_thn_kum - $qty_thn_kmrn_kum) / $qty_thn_kmrn_kum;

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
        //"growth_yoy" => $growth_yoy,
        //"growth_kum_yoy" => $growth_kum_yoy
    );
}
echo '{"ms_nasional":'.json_encode($text).'}';
?>