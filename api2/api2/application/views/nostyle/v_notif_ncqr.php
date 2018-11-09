<div class="box-body table-responsive no-padding"><table class="table" border=1 id=tbldata style="width: 120%">
<tr>
<th>No.</th><th>Notification</th><th>Name</th><th>Email</th><th>Date</th>
</tr>
<?php 
$x = 1;
foreach($this->list_notif as $r): ?>
<tr>
	<td><?php echo $x++ ?></td>
	<td><?php echo $r->NM_JABATAN ?></td>
	<td><?php echo $r->FULLNAME ?></td>
	<td><?php echo $r->EMAIL ?></td>
	<td><?php echo $r->TANGGAL_NOTIFIKASI ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>
