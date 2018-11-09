<?php
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=\"ncqr_report.xls\"");
header("Pragma: no-cache");
header("Expires: 0");

$data = json_decode($this->data);
?>
<h1>NCQR INCIDENT REPORT</h1>
<H3><?PHP echo $this->input->post("STARTDATE")." - ".$this->input->post("ENDDATE"); ?></H3>
<table class="table" border=1 id=tbldata>
<tr>
<th>No</th><TH>COMPANY</TH><TH>PLANT</TH><TH>AREA</TH><th>SUBJECT</th><th>CREATED BY</th><th>TYPE</th><th>DATE</th>
</tr>
<?php
foreach($data as $i => $item):
?>
<tr>
<td><?php echo ($i+1) ?></td>
<td><?PHP ECHO $item->NM_COMPANY ?></td>
<td><?PHP ECHO $item->NM_PLANT ?></td>
<td><?PHP ECHO $item->NM_AREA ?></td>
<td><?php echo $item->SUBJECT ?></td>
<td><?php echo ($item->FULLNAME)?$item->FULLNAME:"-" ?></td>
<td><?php echo $item->NM_INCIDENT_TYPE ?></td>
<td><?php echo $item->TANGGAL ?></td>
</tr>
<?php endforeach; ?>
</table>
