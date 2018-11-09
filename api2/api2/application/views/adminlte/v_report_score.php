<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Report Score
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form method="POST">
          <!-- /.box-header -->
          <div class="box-body">
            <table  id="dt_tables"
              class="table table-striped table-bordered table-hover dt-responsive nowrap"
              cellspacing="0"
              width="100%">
              <thead>
                <tr>
                  <td colspan="<?php echo (8+$this->COUNT_COMPANY);?>">
                    <div class="form-group col-sm-12 col-sm-4 picker_daily">
                      <label for="ID_COMPANY">OPTION</label>
                      <SELECT style="width:auto;" class="form-control select2" name="ASPEK" id='id_jenis_aspek'>
                        <option value="ALL">ALL</option>
                        <?php
                          foreach ($this->JENIS_ASPEK as $aspek) {
                            $slk = ($this->ASPEK == $aspek->ID_JENIS_ASPEK) ? "selected":"";
                            echo "<option $slk value='".$aspek->ID_JENIS_ASPEK."'>" . $aspek->JENIS_ASPEK . "</option>";
                          }
                        ?>
                      </SELECT>
                    </div>
                    <div class="form-group col-sm-12 col-sm-2 picker_daily" >
                      <label for="ID_COMPANY">MONTH</label>
                      <SELECT style="width:auto;" class="form-control select2" name="MONTH" id='bulan'>
                        <?php for($i=1;$i<=12;$i++): ?>
                          <option value="<?php echo $i; ?>" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')==$i):date("m")==$i) ? "selected":"";?>><?php echo strtoupper(date("F", mktime(0, 0, 0, $i, 10))); ?></option>
                        <?php endfor; ?>
                      </SELECT>
                    </div>
                    <div class="form-group col-sm-12 col-sm-2">
                      <label for="ID_COMPANY">YEAR</label>
                      <SELECT style="width:auto;" class="form-control select2" name="YEAR" id='tahun'>
                      <?php for($i=2016;$i<=date("Y");$i++): ?>
                        <option <?php echo (($this->input->post('YEAR')!=NULL)? ($this->input->post('YEAR')==$i):date("Y")==$i) ? "selected":"";?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                      <?php endfor; ?>
                      </SELECT>
                    </div>
                    <div class="form-group col-sm-12 col-sm-2">
                      <label for="ID_COMPANY">&nbsp;</label>
                      <button type="submit" id='btLoad' class="form-control btn btn-primary">Load</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th rowspan="2" valign="middle" width="2%">NO.</th>
                  <th rowspan="2" width="30%">KRITERIA</th>
                  <th rowspan="2" width="30%">BATASAN</th>
                  <?php
                    foreach ($this->LIST_COMPANY as $company) {
                      $color = company_color($company->KD_COMPANY);
                      echo "<th style='background-color:$color;' colspan='2'><center style='color:black;text-shadow:1px 1px 1px #cccccc'>".$company->NM_COMPANY . "</center></th>";
                    }
                  ?>
                </tr>
                <tr>
                  <?php
                    foreach ($this->LIST_COMPANY as $company) {
                      $color = company_color($company->KD_COMPANY,1);
                      echo "<th style='background-color:$color;'><center style='color:white;'>FIG.</center></th>";
                      echo "<th style='background-color:$color;'><center style='color:white;'>SKOR</center></th>";
                    }
                  ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($this->LIST_INPUT as $list) {
                  echo "<tr>";
                    echo "<td style='background-color:".company_color(1).";'>$no</td>";
                    echo "<td style='background-color:".company_color(1).";'>".$list->KRITERIA."</td>";
                    echo "<td style='background-color:lightgreen;'>".$list->BATASAN."</td>";
                    #echo "<td>";
                      #echo $list->BATASAN;
                      echo "<input name='ID_BATASAN[]' value='".$list->ID_BATASAN."' type='hidden'>";
                    #echo "</td>";
                    foreach ($this->LIST_COMPANY as $company) {
                      $color = company_color($company->KD_COMPANY,2);
                      $nilai = empty($this->NILAI['comp']) ? array(0):$this->NILAI['comp'][$company->ID_COMPANY];
                      $bts = $list->ID_BATASAN;
                      $fig = array_filter($nilai, function ($e) use ($bts) {
                        return $e->ID_BATASAN == $bts;
                      });
                      echo "<td style='background-color:$color;' align='center'>";
                        echo "<span class='opco_".$company->ID_COMPANY."' id='NILAI_".$list->ID_BATASAN.$company->ID_COMPANY."'>";
                          //Figure
                          //var_dump($fig);
                          foreach ($fig as $fNilai) {
                            if ($this->USER->ID_COMPANY==$company->ID_COMPANY || $this->USER->ID_COMPANY == NULL){
                              echo ($fNilai->NILAI_ASPEK=='') ? '':round($fNilai->NILAI_ASPEK,2);
                            }
                          }
                        echo "</span>";
                      echo "</td>";
                      echo "<td style='background-color:$color;' align='center'>";
                        echo "<span class='opcox_".$company->ID_COMPANY.$list->ID_JENIS_ASPEK."' id='NILAIX_".$list->ID_BATASAN.$company->ID_COMPANY."'>";
                          //Score
                          foreach ($fig as $fNilai) {
                            if ($this->USER->ID_COMPANY==$company->ID_COMPANY || $this->USER->ID_COMPANY == NULL){
                              $red = ($fNilai->NILAI_SKORING <= 2) ? "red":"blue";
                              echo "<font color='$red'>".$fNilai->NILAI_SKORING."</font>";
                            }
                          }
                        echo "</span>";
                      echo "</td>";
                    }
                  echo "</tr>";
                  $no++;
                } 
                ?>
                <tr>
                  <th colspan="3" valign="middle" width="2%">PEROLEHAN NILAI</th>
                  <?php
                  foreach ($this->LIST_COMPANY as $company) {
                    $sTot  = 0;
                    $nilai = empty($this->NILAI['comp']) ? array(0):$this->NILAI['comp'][$company->ID_COMPANY];
                    $ctr   = 5*count($nilai);
                
                    if ($this->USER->ID_COMPANY==$company->ID_COMPANY || $this->USER->ID_COMPANY == NULL){
                      if ($this->ASPEK!="ALL") {
                        foreach ($nilai as $nl) {
                          $sTot +=$nl->NILAI_SKORING;
                        }
                        $total = $sTot/$ctr*$nl->BOBOT;
                      }else{
                        $vSCORE = ARRAY();
                        foreach ($this->JENIS_ASPEK as $aspek) {
                          $vSCORE[$aspek->ID_JENIS_ASPEK][BOBOT] = $aspek->BOBOT;
                          $vSCORE[$aspek->ID_JENIS_ASPEK][SCORE] = 0;
                          $vSCORE[$aspek->ID_JENIS_ASPEK][ITEM] = 0;								
                          foreach ($nilai as $nl) {
                        		if ($aspek->ID_JENIS_ASPEK==$nl->ID_JENIS_ASPEK) {
                        			$vSCORE[$aspek->ID_JENIS_ASPEK][SCORE] 	+=	$nl->NILAI_SKORING;
                        			$vSCORE[$aspek->ID_JENIS_ASPEK][ITEM] 	+=	1;
                        		}
                          }
                        }
                        $total = 0;
                        foreach($vSCORE as $r){
                          @$total += ($r[SCORE] / (5*$r[ITEM]) * $r[BOBOT]);
                        }

                        $total = is_nan($total)?0:$total;
                        
                        $color = "#";
                        
                        if($total < 70 ) $color = "#FF6363";
                        if($total >= 70 && $total < 85) $color = "#2167FF"; 
                        if($total >= 85 && $total < 90) $color = "#8EFF80"; 
                        if($total >= 90) $color = "#FFD700"; 
                        
                      }
                    }
                    echo "<td colspan='2' align='center' bgcolor='".$color."'>";
                      echo "<span class='total_".$company->ID_COMPANY."'>";  
                      echo "<font color=black><b>".round($total,2)."</b></font>";
                      echo "</span>";
                    echo "</td>";
                  }
                  ?>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </form>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script>
  $(document).ready(function(){
    
  });
</script>
