<table border=1 class="trep">
<tr>
	<th></th>
	<?php foreach($this->list_grouparea as $r): ?>
	<th colspan=3 STYLE="text-align: center"><b><?php echo $r->NM_GROUPAREA ?></b></th>
	<?php endforeach; ?>	
</tr>

<TR>
	<TH>PLANT</TH>
	<?php foreach($this->list_grouparea as $r): ?>	
	<th style="text-align: center" >STATUS</th>
	<th style="text-align: center" >DATA</th>
	<th style="text-align: center" >ENTRI</th>	
	<?php endforeach; ?>	
</TR>

<?php foreach($this->list_data as $NM_PLANT => $r): ?>
<TR>
	<td><?php echo $NM_PLANT ?></td>
		<?php foreach($this->list_grouparea as $g): ?>
			<td STYLE="text-align: center;" class="<?php echo $r[$g->ID_GROUPAREA][STATUS] ?>"><?php echo $r[$g->ID_GROUPAREA][STATUS] ?></td>
			<td STYLE="text-align: center"><?php echo $r[$g->ID_GROUPAREA][TANGGAL_DATA] ?></td>
			<td STYLE="text-align: center"><?php echo $r[$g->ID_GROUPAREA][TANGGAL_ENTRI] ?></td>
		<?php endforeach; ?>
</TR>
<?php endforeach; ?>

</table>

<table border=0 class=tlegend>
<tr><td style="font-weight: bold; color: #0035B0; background: #0DD127; text-align: center; vertical-align: middle;">D</td><td>DONE</td></tr>
<tr><td style="font-weight: bold; color: #000; background: yellow; text-align: center; vertical-align: middle;">NC</td><td>NOT COMPLETED</td></tr>
<tr><td style="font-weight: bold; color: #fff; background: red; text-align: center; vertical-align: middle;">NY</td><td>NOT YET</td></tr>
</table>

<style>
.NY {
	background: red;
	color: #fff;
}

.D {
	background: #0DD127;
	color: #0035B0;
}

.NC {
	background: yellow;
}

.tlegend td {
	padding: 5px;
}

.tlegend {
	border-collapse: separate;
    border-spacing: 2px;
}
</style>

