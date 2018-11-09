<div class="box-body table-responsive no-padding">
	<table class="table" border=1 id='tbldata'>
		<tr>
			<td rowspan="2">NO</td>
			<td rowspan="2">KRITERIA PENILAIAN</td>
			<td rowspan="2">BATASAN</td>
			<?php foreach ($this->LIST_COMPANY as $company) {
				echo "<td colspan='2'>".$company->NM_COMPANY."</td>";
			} ?>
		</tr>
		<tr>
			<?php foreach ($this->LIST_COMPANY as $company) {
				echo "<td>FIG.</td>";
				echo "<td>SKOR</td>";
			} ?>
		</tr>
		<?php
	      $no = 1;
	      foreach ($this->LIST_INPUT as $list) {
	      	$key = array_search($list->ID_BATASAN, array_column(json_decode(json_encode($this->LIST_REPORT),TRUE), 'ID_BATASAN'));
	            	var_dump($this->LIST_REPORT[$key]);
	        echo "<tr>";
	          echo "<td>$no</td>";
	          echo "<td>".$list->KRITERIA."</td>";
	          echo "<td>".$list->BATASAN."</td>";
	          foreach ($this->LIST_COMPANY as $company) {
	            echo "<td>";

	            echo "</td>";
	            echo "<td>";
	            echo "</td>";
	          }
	        echo "</tr>";
	        $no++;
	      } 
	    ?>
	</table>
</div>	