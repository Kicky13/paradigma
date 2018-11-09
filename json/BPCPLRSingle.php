<title>Json</title>

<?php
header('Access-Control-Allow-Origin: *');
$user = "devsi";
$pass = "SelaluJaya6102";
$_ora_db_pm_dev = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.3.145)(PORT = 1521))) (CONNECT_DATA = (SERVICE_NAME = smig_dev.semenindonesia.com)(SERVER = DEDICATED)))';

$conn = oci_connect($user, $pass, $_ora_db_pm_dev);

if (!empty($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
} else {
    $bulan = date('m');
}

if (!empty($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
} else {
    $tahun = date('Y');
}

$bulan_before = $bulan - 1;
//======================================= CURRENT MONTH ==================================//
$q_pnjln = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) -- PENJUALAN
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_VLP'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) -- PENJUALAN
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_VLP'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PNJLN
FROM
	DUAL");
oci_execute($q_pnjln);
while ($rowID = oci_fetch_array($q_pnjln)) {
    $PNJLN = $rowID['PNJLN'];
}

$q_hpb = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) -- HASIL PENJUALAN BRUTO
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_HPB'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) -- HASIL PENJUALAN BRUTO
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_HPB'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_HPB
FROM
	DUAL");
oci_execute($q_hpb);
while ($rowID = oci_fetch_array($q_hpb)) {
    $PL_HPB = $rowID['PL_HPB'];
}

$q_oa = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) -- ONGKOS ANGKUT
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_OA'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) -- ONGKOS ANGKUT
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_OA'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_OA
FROM
	DUAL");

oci_execute($q_oa);
while ($rowID = oci_fetch_array($q_oa)) {
    $PL_OA = $rowID['PL_OA'];
}

$q_hpn = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) -- HASIL PENJUALAN
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_HPN'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) -- HASIL PENJUALAN
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_HPN'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_HPN
FROM
	DUAL");

oci_execute($q_hpn);
while ($rowID = oci_fetch_array($q_hpn)) {
    $PL_HPN = $rowID['PL_HPN'];
}

$q_bpp = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) -- BEBAN POKOK PENJUALAN
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_BPP'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) -- BEBAN POKOK PENJUALAN
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_BPP'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_BPP
FROM
	DUAL");

oci_execute($q_bpp);
while ($rowID = oci_fetch_array($q_bpp)) {
    $PL_BPP = $rowID['PL_BPP'];
}

$q_lk = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) -- BEBAN POKOK PENJUALAN
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_LK'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) -- BEBAN POKOK PENJUALAN
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_LK'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_LK
FROM
	DUAL");

oci_execute($q_lk);
while ($rowID = oci_fetch_array($q_lk)) {
    $PL_LK = $rowID['PL_LK'];
}

$q_bua = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_LK'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_LK'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_BUA
FROM
	DUAL");

oci_execute($q_bua);
while ($rowID = oci_fetch_array($q_bua)) {
    $PL_BUA = $rowID['PL_BUA'];
}

$q_bpe = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_BPE'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_BPE'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_BPE
FROM
	DUAL");

oci_execute($q_bpe);
while ($rowID = oci_fetch_array($q_bpe)) {
    $PL_BPE = $rowID['PL_BPE'];
}

$q_lu = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_LU'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_LU'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_LU
FROM
	DUAL");

oci_execute($q_lu);
while ($rowID = oci_fetch_array($q_lu)) {
    $PL_LU = $rowID['PL_LU'];
}

$q_e = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_E'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_E'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_E
FROM
	DUAL");

oci_execute($q_e);
while ($rowID = oci_fetch_array($q_e)) {
    $PL_E = $rowID['PL_E'];
}

$q_bp = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_BP'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_BP'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_BP
FROM
	DUAL");

oci_execute($q_bp);
while ($rowID = oci_fetch_array($q_bp)) {
    $PL_BP = $rowID['PL_BP'];
}

$q_lrsk = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_LRSK'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_LRSK'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_LRSK
FROM
	DUAL");

oci_execute($q_lrsk);
while ($rowID = oci_fetch_array($q_lrsk)) {
    $PL_LRSK = $rowID['PL_LRSK'];
}

$q_pll = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_PLL'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_PLL'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_PLL
FROM
	DUAL");

oci_execute($q_pll);
while ($rowID = oci_fetch_array($q_pll)) {
    $PL_PLL = $rowID['PL_PLL'];
}

$q_lsp = oci_parse($conn, "SELECT
	(
		(
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_LSP'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.05'
		) - (
			SELECT
				SUM (AMOUNT) 
			FROM
				CONSOLIDATION
			WHERE
				AUDITTRAIL = 'PL_CONS'
			AND CATEGORY = 'ACT'
			AND COSTCENTER_COMPONENT = 'NO_CC'
			AND DOCUMENT_TYPE = 'NO_DOC'
			AND FLOW = 'CLOSING'
			AND GL_ACCOUNT = 'PL_LSP'
			AND COMPANY = '7000'
			AND INTERCO = 'I_NONE'
			AND CURRENCY = 'LC'
			AND SCOPE = 'NON_GROUP'
			AND FISCAL_YEAR_PERIOD = '2016.04'
		)
	) AS PL_LSP
FROM
	DUAL");

oci_execute($q_lsp);
while ($rowID = oci_fetch_array($q_lsp)) {
    $PL_LSP = $rowID['PL_LSP'];
}

//======================================= UPTO ==================================//
$query_pnjln = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PNJLN
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_VLP'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_pnjln);
while ($rowID = oci_fetch_array($query_pnjln)) {
    $UPTO_PNJLN = $rowID['PNJLN'];
}

$query_hpb = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_HPB
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_HPB'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_hpb);
while ($rowID = oci_fetch_array($query_hpb)) {
    $UPTO_HPB = $rowID['PL_HPB'];
}

$query_oa = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_OA
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_OA'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_oa);
while ($rowID = oci_fetch_array($query_oa)) {
    $UPTO_OA = $rowID['PL_OA'];
}

$query_hpn = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_HPN
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_HPN'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_hpn);
while ($rowID = oci_fetch_array($query_hpn)) {
    $UPTO_HPN = $rowID['PL_HPN'];
}

$query_bpp = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_BPP
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_BPP'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_bpp);
while ($rowID = oci_fetch_array($query_bpp)) {
    $UPTO_BPP = $rowID['PL_BPP'];
}

$query_lk = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_LK
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_LK'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_lk);
while ($rowID = oci_fetch_array($query_lk)) {
    $UPTO_LK = $rowID['PL_LK'];
}

$query_bua = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_BUA
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_BUA'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_bua);
while ($rowID = oci_fetch_array($query_bua)) {
    $UPTO_BUA = $rowID['PL_BUA'];
}

$query_bpe = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_BPE
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_BPE'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_bpe);
while ($rowID = oci_fetch_array($query_bpe)) {
    $UPTO_BPE = $rowID['PL_BPE'];
}

$query_lu = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_LU
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_LU'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_lu);
while ($rowID = oci_fetch_array($query_lu)) {
    $UPTO_LU = $rowID['PL_LU'];
}

$query_e = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_E
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_E'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_e);
while ($rowID = oci_fetch_array($query_e)) {
    $UPTO_E = $rowID['PL_E'];
}

$query_bp = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_BP
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_BP'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_bp);
while ($rowID = oci_fetch_array($query_bp)) {
    $UPTO_BP = $rowID['PL_BP'];
}

$query_lrsk = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_LRSK
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_LRSK'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_lrsk);
while ($rowID = oci_fetch_array($query_lrsk)) {
    $UPTO_LRSK = $rowID['PL_LRSK'];
}

$query_pll = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_PLL
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_PLL'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_pll);
while ($rowID = oci_fetch_array($query_pll)) {
    $UPTO_PLL = $rowID['PL_PLL'];
}

$query_lsp = oci_parse($conn, "SELECT
	SUM (AMOUNT) AS PL_LSP
FROM
	CONSOLIDATION
WHERE
	AUDITTRAIL = 'PL_CONS'
AND CATEGORY = 'ACT'
AND COSTCENTER_COMPONENT = 'NO_CC'
AND DOCUMENT_TYPE = 'NO_DOC'
AND FLOW = 'CLOSING'
AND GL_ACCOUNT = 'PL_LSP'
AND COMPANY = '7000'
AND INTERCO = 'I_NONE'
AND CURRENCY = 'LC'
AND SCOPE = 'NON_GROUP'
AND FISCAL_YEAR_PERIOD = '2016.05'");

oci_execute($query_lsp);
while ($rowID = oci_fetch_array($query_lsp)) {
    $UPTO_LSP = $rowID['PL_LSP'];
}
//======================================= CREATE JSON STRUCTURE ==================================//
$curr_rp1 = array(
    'hpb' => ($PL_HPB / $PNJLN) * 100,
    'oa' => ($PL_OA / $PNJLN) * 100,
    'hpn' => ($PL_HPN / $PNJLN) * 100,
    'bpp' => ($PL_BPP / $PNJLN) * 100,
    'lk' => ($PL_LK / $PNJLN) * 100,
    'bua' => ($PL_BUA / $PNJLN) * 100,
    'bpe' => ($PL_BPE / $PNJLN) * 100,
    'lu' => ($PL_LU / $PNJLN) * 100,
    'e' => ($PL_E / $PNJLN) * 100,
    'bp' => ($PL_BP / $PNJLN) * 100,
    'lrsk' => ($PL_LRSK / $PNJLN) * 100,
    'pll' => ($PL_PLL / $PNJLN) * 100,
    'lsp' => ($PL_LSP / $PNJLN) * 100
);

$upto_rp1 = array(
    'hpb' => ($UPTO_HPB / $UPTO_PNJLN) * 100,
    'oa' => ($UPTO_OA / $UPTO_PNJLN) * 100,
    'hpn' => ($UPTO_HPN / $UPTO_PNJLN) * 100,
    'bpp' => ($UPTO_BPP / $UPTO_PNJLN) * 100,
    'lk' => ($UPTO_LK / $UPTO_PNJLN) * 100,
    'bua' => ($UPTO_BUA / $UPTO_PNJLN) * 100,
    'bpe' => ($UPTO_BPE / $UPTO_PNJLN) * 100,
    'lu' => ($UPTO_LU / $UPTO_PNJLN) * 100,
    'e' => ($UPTO_E / $UPTO_PNJLN) * 100,
    'bp' => ($UPTO_BP / $UPTO_PNJLN) * 100,
    'lrsk' => ($UPTO_LRSK / $UPTO_PNJLN) * 100,
    'pll' => ($UPTO_PLL / $UPTO_PNJLN) * 100,
    'lsp' => ($UPTO_LSP / $UPTO_PNJLN) * 100
);

$curr = array(
    'penjualan' => $PNJLN,
    'hpb' => $PL_HPB,
    'oa' => $PL_OA,
    'hpn' => $PL_HPN,
    'bpp' => $PL_BPP,
    'lk' => $PL_LK,
    'mlk' => (($PL_LK / $PL_HPN) * 100),
    'bua' => $PL_BUA,
    'bpe' => $PL_BPE,
    'lu' => $PL_LU,
    'mlu' => (($PL_LU / $PL_HPN) * 100),
    'e' => $PL_E,
    'me' => (($PL_E / $PL_HPN) * 100),
    'bp' => $PL_BP,
    'lrsk' => $PL_LRSK,
    'pll' => $PL_PLL,
    'lsp' => $PL_LSP,
    'mlsp' => (($PL_LSP / $PL_HPN) * 100)
);

$upto = array(
    'penjualan' => $UPTO_PNJLN,
    'hpb' => $UPTO_HPB,
    'oa' => $UPTO_OA,
    'hpn' => $UPTO_HPN,
    'bpp' => $UPTO_BPP,
    'lk' => $UPTO_LK,
    'mlk' => (($UPTO_LK / $UPTO_HPN) * 100),
    'bua' => $UPTO_BUA,
    'bpe' => $UPTO_BPE,
    'lu' => $UPTO_LU,
    'mlu' => (($UPTO_LU / $UPTO_HPN) * 100),
    'e' => $UPTO_E,
    'me' => (($UPTO_E / $UPTO_HPN) * 100),
    'bp' => $UPTO_BP,
    'lrsk' => $UPTO_LRSK,
    'pll' => $UPTO_PLL,
    'lsp' => $UPTO_LSP,
    'mlsp' => (($UPTO_LSP / $UPTO_HPN) * 100)
);

$bpc_data = array(
    'current' => $curr,
    'current_rp1' => $curr_rp1,
    'upto' => $upto,
    'upto_rp1' => $upto_rp1
);
echo '{"7000":' . json_encode($bpc_data) . '}';
?>