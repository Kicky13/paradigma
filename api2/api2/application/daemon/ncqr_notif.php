<?php
/*	1 MINOR 1 (0JAM)
 *  2 MINOR 2 (3JAM)
 *  3 MAYOR 1 (9JAM)
 *  4 MAYOR 2 (10JAM DST)
 * */
 
#define('APP_PATH','/home/arca/htdocs/QMOnline/');
#require_once(APP_PATH."application/config/database.php");

$db = oci_connect('mso','s3mengres1k','//10.15.5.122/pmdb');


$s = "select a.*, floor(24 * (SYSDATE - a.TANGGAL) ) as DD, 
(select count(t.ID_INCIDENT_TYPE) from T_NOTIFIKASI t where t.ID_INCIDENT_TYPE=a.ID_INCIDENT_TYPE) as SUDAH_NOTIFIKASI
from M_INCIDENT a where a.ID_SOLUTION is NULL order by a.ID_INCIDENT asc"; echo $s."\n";
$s = oci_parse($db,$s);
$x = oci_execute($s);
while($r = oci_fetch_object($s)){
	#print_r($r);
	$ID_JABATAN = NULL;
	if($r->DD <= 1){
		$ID_JABATAN = 1;
	}
	
	if($r->DD == 3){
		$ID_JABATAN = "1,2";
	}

	if($r->DD == 6){
		$ID_JABATAN = "1,2,3";
	}

	if($r->DD == 9){
		$ID_JABATAN = "1,2,3,4";
	}

	if($r->DD > 9){
		$ID_JABATAN = "1,2,3,4";
	}

	if($r->SUDAH_NOTIFIKASI && $r->ID_INCIDENT_TYPE < 4){
		exit;
	}
	
	#$ID_JABATAN="1,2,3,4";
	
	IF($ID_JABATAN){
		//PEJABAT
		$ps = "select * from M_OPCO where ID_AREA='".$r->ID_AREA."' and ID_JABATAN in (".$ID_JABATAN.")"; echo $ps."\n";
		$ps = oci_parse($db,$ps);
		$px = oci_execute($ps);
		while($pr = oci_fetch_object($ps)){
			var_dump($pr);
			//table abnormality
	
			
			$sdi = "SELECT a.*, b.*, c.*, c.ANALISA as VANALISA, TO_CHAR(c.JAM, 'DD-MM-YYYY HH24:MI') AS JAM_ANALISA, d.NM_AREA, e.NM_PLANT, f.NM_COMPANY, g.NM_INCIDENT_TYPE, h.KD_PRODUCT
					FROM M_INCIDENT a
					JOIN M_COMPONENT b ON a.ID_COMPONENT=b.ID_COMPONENT
					JOIN D_INCIDENT c ON a.ID_INCIDENT=c.ID_INCIDENT
					JOIN M_AREA d on a.ID_AREA=d.ID_AREA
					JOIN M_PLANT e on d.ID_PLANT=e.ID_PLANT
					JOIN M_COMPANY f on e.ID_COMPANY=f.ID_COMPANY
					LEFT JOIN M_INCIDENT_TYPE g on (a.ID_INCIDENT_TYPE+1)=g.ID_INCIDENT_TYPE
					LEFT JOIN M_PRODUCT h on a.ID_PRODUCT=h.ID_PRODUCT
					WHERE a.ID_INCIDENT = '".$r->ID_INCIDENT."' ";
					
			echo $sdi;		
					
			$pdi = oci_parse($db,$sdi);
			$xdi = oci_execute($pdi);
			
			$ddi = oci_fetch_object($pdi);
			
			$tab = "";
			$tab = "<table border=1>";
			$tab .= "<tr> 
                  <th>Component</th>
                  <th>Time</th>
                  <th>Analize</th>
                  <th>Standard</th>
                </tr>";
            
            $pdi = oci_parse($db,$sdi);
			$xdi = oci_execute($pdi);
			while($rdi = oci_fetch_object($pdi)){
				$tab .= "<tr>
					<td>".trim($rdi->KD_COMPONENT)."</td>
					<td>".$rdi->JAM_ANALISA."</td>
					<td>".$rdi->VANALISA."</td>
					<td>".$rdi->NILAI_STANDARD_MIN." - ".$rdi->NILAI_STANDARD_MAX."</td>
					</tr>";
			}
			$tab .= "</table>";
			
			$headers = "From: qm@semenindonesia.com" . "\r\n";			
			$to = $pr->EMAIL;
			$subject = "NCQR - ".trim($ddi->KD_COMPONENT).' OUT OF STANDARD ('.(($ddi->NM_INCIDENT_TYPE)?$ddi->NM_INCIDENT_TYPE:"EQR").')';

			$headers = "From: " . strip_tags("qm@semenindonesia.com") . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				
			$message = '
			<html>
			<style>
			table {
				border-collapse: collapse;
			}
			th, td {
				padding: 5px;
				text-align: center;
			}
			</style>
				<body>
					<div style="width: 60%;  padding: 20px; margin: 10px auto auto auto;  ">
					<H2>NON CONFIRMITY QUALITY REPORT</H2>
					<h3>'.trim($ddi->KD_COMPONENT).' OUT OF STANDARD ('.(($ddi->NM_INCIDENT_TYPE)?$ddi->NM_INCIDENT_TYPE:"EQR").') </H3>
					<p>
					
					</p>
					<p>
					<table border=0>
						<tr><td style="text-align:left">COMPANY &nbsp;</td><td>:</td><td style="text-align:left">'.$ddi->NM_COMPANY.'</td></tr>
						<tr><td style="text-align:left">PLANT &nbsp;</td><td>:</td><td style="text-align:left">'.$ddi->NM_PLANT.'</td></tr>
						<tr><td style="text-align:left">AREA &nbsp;</td><td>:</td><td style="text-align:left">'.$ddi->NM_AREA.'</td></tr>
						'.(($ddi->KD_PRODUCT)?'<tr><td style="text-align:left">PRODUCT &nbsp;</td><td>:</td><td style="text-align:left">'.trim($ddi->KD_PRODUCT).'</td></tr>':'').'
						<tr><td colspan=3>'.$tab.'</td></tr>
					
					</table>
					</p>
					<p>&nbsp;</p>
					<p><b><a href="http://10.15.2.130/incident/solve/'.$r->ID_INCIDENT.'" target="_blank">Solve This NCQR</a></b></p>
					<p>&nbsp;</p>
					<p><i>Please do not reply this email.</i></p>
					</div>
			</body>
			</html>';
			
			echo $message;
			
			 mail($to,$subject,$message,$headers);
			
			$en = "insert into T_NOTIFIKASI (ID_NOTIFIKASI, ID_OPCO, ID_INCIDENT, ID_JABATAN, TANGGAL, ID_INCIDENT_TYPE ) 
				   values(SEQ_ID_NOTIFIKASI.NEXTVAL, '".$pr->ID_OPCO."', '".$r->ID_INCIDENT."', '".$pr->ID_JABATAN."', SYSDATE, '".$r->ID_INCIDENT_TYPE."')"; echo $en."\n";
			$en = oci_parse($db, $en);
			$ex = oci_execute($en);
		}
		
		//update
		if($r->ID_INCIDENT_TYPE <= 3){
			$NEW_ID_INCIDENT = $r->ID_INCIDENT_TYPE+1;
			$us = "update M_INCIDENT set ID_INCIDENT_TYPE=".$NEW_ID_INCIDENT." WHERE ID_INCIDENT=".$r->ID_INCIDENT.""; echo $us."\n";
			$us = oci_parse($db,$us);
			$ux = oci_execute($us);
		}
	}
}
