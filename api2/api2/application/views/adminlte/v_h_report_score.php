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
                  <td colspan="<?php echo (12+$this->COUNT_COMPANY);?>">
                    <div class="form-group col-sm-12 col-sm-4 picker_daily">
                      <label for="ID_COMPANY">OPTION</label>
                      <SELECT style="width:auto;" class="form-control select2" name="ASPEK" id='id_jenis_aspek'>
                        <option value="ALL">ALL</option>
                        <?php
                          foreach ($this->JENIS_ASPEK as $aspek) {
                            $slk = ($this->ASPEK == $aspek->ID_ASPEK) ? "selected":"";
                            echo "<option $slk value='".$aspek->ID_ASPEK."'>" . $aspek->ASPEK . "</option>";
                          }
                        ?>
                      </SELECT>
                    </div>
                    <div class="form-group col-sm-12 col-sm-2 picker_daily" >
                      <label for="ID_COMPANY">MONTH</label>
                      <SELECT style="width:auto;" class="form-control select2" name="MONTH" id='bulan'>
                        <option value="01" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='01'):"01"==date("m")) ? "selected":"";?>>JANUARY</option>
                        <option value="02" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='02'):"02"==date("m")) ? "selected":"";?>>FEBRUARY</option>
                        <option value="03" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='03'):"03"==date("m")) ? "selected":"";?>>MARCH</option>
                        <option value="04" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='04'):"04"==date("m")) ? "selected":"";?>>APRIL</option>
                        <option value="05" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='05'):"05"==date("m")) ? "selected":"";?>>MAY</option>
                        <option value="06" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='06'):"06"==date("m")) ? "selected":"";?>>JUNE</option>
                        <option value="07" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='07'):"07"==date("m")) ? "selected":"";?>>JULY</option>
                        <option value="08" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='08'):"08"==date("m")) ? "selected":"";?>>AUGUST</option>
                        <option value="09" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='09'):"09"==date("m")) ? "selected":"";?>>SEPTEMBER</option>
                        <option value="10" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='10'):"10"==date("m")) ? "selected":"";?>>NOVEMBER</option>
                        <option value="11" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='11'):"11"==date("m")) ? "selected":"";?>>OCTOBER</option>
                        <option value="12" <?php echo (($this->input->post('MONTH')!=NULL)? ($this->input->post('MONTH')=='12'):"12"==date("m")) ? "selected":"";?>>DECEMBER</option>
                      </SELECT>
                    </div>
                    <div class="form-group col-sm-12 col-sm-2">
                      <label for="ID_COMPANY">YEAR</label>
                      <SELECT style="width:auto;" class="form-control select2" name="YEAR" id='tahun'>
                <?php for($i=2016;$i<=date("Y");$i++): ?>
                  <option value="<?php echo $i; ?>" <?php echo (date("Y")==$i) ? "selected":"";?>><?php echo $i; ?></option>
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
                  <!--th rowspan="2" valign="middle" width="2%">NO.</th-->
                  <th rowspan="2" width="30%"></th>
                  <?php
                    foreach ($this->LIST_COMPANY as $company) {
                      $color = company_color($company->KD_COMPANY);
                      echo "<th style='background-color:$color;' colspan='2'><center style='color:white;'>".$company->NM_COMPANY . "</center></th>";
                    }
                  ?>
                </tr>
                <tr>
                  <?php
                    foreach ($this->LIST_COMPANY as $company) {
                      $color = company_color($company->KD_COMPANY,1);
                      #echo "<th style='background-color:$color;'><center style='color:white;'>NILAI ASPEK</center></th>";
                      echo "<th style='background-color:$color;'><center style='color:white;'>POSISI</center></th>";
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
                    #echo "<td style='background-color:".company_color(1).";'>$no</td>";
                    echo "<td style='background-color:".company_color(1).";'>".$list->KRITERIA."</td>";
                    #echo "<td>";
                      #echo $list->BATASAN;
                      echo "<input name='ID_BATASAN[]' value='".$list->ID_KRITERIA."' type='hidden'>";
                    #echo "</td>";
                    foreach ($this->LIST_COMPANY as $company) {
                      $color  = company_color($company->KD_COMPANY,2);
                      $arr_k  = array_keys($this->NILAI['comp']);
                      $nilai  = (in_array($company->ID_COMPANY, $arr_k)) ? $this->NILAI['comp'][$company->ID_COMPANY]:array(0);
                      $bts    = $list->ID_KRITERIA;
                      $fig    = array_filter($nilai, function ($e) use ($bts) {
                                return $e->ID_KRITERIA == $bts;
                              });
                     
                      echo "<td style='background-color:$color;' align='center'>";
                        echo "<span class='opco_".$company->ID_COMPANY."' id='NILAI_".$list->ID_KRITERIA.$company->ID_COMPANY."'>";
                          //POSISI
                          foreach ($fig as $fNilai) {
                            echo round($fNilai->SCORE,2);
                          }
                        echo "</span>";
                      echo "</td>";
                      echo "<td style='background-color:$color;' align='center'>";
                        echo "<span class='opcox_".$company->ID_COMPANY.$list->ID_ASPEK."' id='NILAIX_".$list->ID_KRITERIA.$company->ID_COMPANY."'>";
                          //Score
                          foreach ($fig as $fNilai) {
                            echo round($fNilai->SCORE*$fNilai->BOBOT,2);
                          }
                        echo "</span>";
                      echo "</td>";
                    }
                  echo "</tr>";
                  $no++;
                } 
                ?>
                <tr>
                  <th style="background-color:#C2F1FF;" colspan="1" valign="middle" width="2%">SCORE</th>
                  <?php
                  foreach ($this->LIST_COMPANY as $company) {
                    #var_dump($this->ASPEK);
                    $total  = NULL;
                    $arr_k  = array_keys($this->NILAI['comp']);
                    $nilai  = (in_array($company->ID_COMPANY, $arr_k)) ? $this->NILAI['comp'][$company->ID_COMPANY]:array(0);
                    if ($nilai[0]!==0) {
                      foreach ($nilai as $nl) {
                        $skor = $nl->SCORE*$nl->BOBOT;
                        $total += round($skor,2);
                      }
                    }else{
                      $total = NULL;
                    }
                    $color = company_color($company->KD_COMPANY);
                    echo "<td style='background-color:$color;' colspan='2' align='center'>";
                      echo "<span class='total_".$company->ID_COMPANY."'>";
                        echo $total;
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
