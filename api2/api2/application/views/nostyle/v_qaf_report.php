<div class="col-sm-6 col-sm-12">
	<div class="box-body table-responsive no-padding">
		<table class="table" border=1 id=tbldata>
		<tr>
		<th ROWSPAN=2 style="vertical-align: middle"><?php echo $this->NM_AREA ?></th>
		<TH  COLSPAN="<?PHP echo count($this->list_component) ?>">CEMENT <?php echo $this->NM_PRODUCT ?></TH>
		</tr>					
		<tr>
			<?php foreach($this->list_component as $c): ?>
			<th><?php echo $c->KD_COMPONENT ?></th>
			<?php endforeach; ?>
		</tr>
		<tr id='trstd'>
			<th>STANDARD</th>
			<?php foreach($this->list_component as $c): ?>
			<th><?php 
				
				$min = ($c->V_MAX >= 999)?"MIN":"";
				$max = ($c->V_MIN == 0)?"MAX":"";
				$str = ($min == "" && $max == "")?"&nbsp;-&nbsp;":"";
				echo $min.$max."&nbsp;".((!$max)?$c->V_MIN:"").$str.((!$min)?$c->V_MAX:"") ?></th>
			<?php endforeach; ?>			
		</tr>
		<tr>
			<td><b>&#931; Data</b></td>
			<?php foreach($this->list_qaf as $c): ?>	
			<td><?php echo (int)$c->S_DATA ?></td>
			<?php endforeach; ?>
			<?php if(!count($this->list_qaf)): ?>
				<?php foreach($this->list_component as $c): ?>
				<td>0</td>
				<?php endforeach; ?>
			<?php endif; ?>
		</tr>
		<tr>
			<td><b>&#931; In</b></td>
			<?php foreach($this->list_qaf as $c): ?>				
			<td><?php echo (int)$c->S_IN ?></td>
			<?php endforeach; ?>
			<?php if(!count($this->list_qaf)): ?>
				<?php foreach($this->list_component as $c): ?>
				<td>0</td>
				<?php endforeach; ?>
			<?php endif; ?>
		</tr>
		<tr id='trqaf'>
			<td>% QAF</td>
			<?php foreach($this->list_qaf as $c): ?>	
			<td><?php echo (float)$c->PERSEN_QAF; $total += $c->PERSEN_QAF; ########## <<<<----- TOTAL QAF ?></td>
			<?php endforeach; ?>
			<?php if(!count($this->list_qaf)): ?>
				<?php foreach($this->list_component as $c): ?>
				<td>0</td>
				<?php endforeach; ?>
			<?php endif; ?>
		</tr>
		<tr id='trtotal'>
			<td>QAF TOTAL</td>
			<TD COLSPAN="<?PHP echo count($this->list_component) ?>"><?php echo @round((float)$total/(float)count($this->list_component),2) ?></TD>
		</tr>
		</table>
	</div>
</div>
              
              
