<div class="col-sm-4 col-sm-8">
	<div class="box-body table-responsive no-padding">
		<table class="table" border=1 id=tbldata WIDTH=100%>
			<tr><th colspan=3><b><?php echo $this->NM_COMPANY ?></b></th></tr>
			<tr><th>FINISH MILL</th><th>PRODUCTION </th><th>QAF</th></tr>
			<?php 
			$TOTAL_QAF = 0;
			$TOTAL_PRODUKSI = 0;
			$QAFxPROD = 0;
			$TOTAL_QxP = 0;
			$JML_LINE = 0;
			foreach($this->list_qaf as $r): 
				if($r->PERSEN_QAF && $r->PRODUKSI) {
					$TOTAL_PRODUKSI += $r->PRODUKSI;
					$QAFxPROD = ($r->PERSEN_QAF/100 * $r->PRODUKSI);
					$TOTAL_QxP += $QAFxPROD;
				}				 
			
			?>
			<TR><TD><?php echo $r->NM_AREA ?></TD><TD><?php echo ($r->PRODUKSI)?$r->PRODUKSI:0; ?></TD><TD><?php echo ($r->PERSEN_QAF)?$r->PERSEN_QAF:0; ?></TD></TR>
			<?PHP endforeach; 
			
			$total = @ROUND( ($TOTAL_QxP/$TOTAL_PRODUKSI*100),2);
			
			$total = (is_nan($total))?0:$total;
			?>
			<TR ID=trtotal><TD colspan=2>QAF TOTAL</TD><TD><?PHP echo $total  ?></TD></TR>
		</table>
	</div>
</div>
