<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Global Report
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body" style="overflow-x:auto">
          <form method="POST">
            <table class="table" style="border: 1px solid black;">
              <div class="form-group col-sm-1" style="margin-right:50px;">
                <label for="ID_COMPANY">MONTH</label>
                <SELECT style="width:auto;" class="form-control select2" name="MONTH" id='bulan'>
                  <?php for($i=1;$i<=12;$i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo (($this->MOON!=NULL)? ($this->MOON==$i):date("m")==$i) ? "selected":"";?>><?php echo strtoupper(date("F", mktime(0, 0, 0, $i, 10))); ?></option>
                  <?php endfor; ?>
                </SELECT>
              </div>
              <div class="form-group col-sm-1">
                <label for="ID_COMPANY">YEAR</label>
                <SELECT style="width:auto;" class="form-control select2" name="YEAR" id='tahun'>
                  <?php for($i=2016;$i<=date("Y");$i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo (($this->YEAR!=NULL)? ($this->YEAR==$i):date("Y")==$i) ? "selected":"";?>><?php echo $i; ?></option>
                  <?php endfor; ?>
                </SELECT>
              </div>
              <div class="form-group col-sm-2">
                <label for="ID_COMPANY">&nbsp;</label>
                <button type="submit" id='btLoad' class="form-control btn btn-primary">Load</button>
              </div>
            </table>
          </form>
          <table align="center" class="dt-responsive">
            <tbody>
              <tr>
                <?php
                  foreach ($this->LIST_COMPANY as $company) {
                    $opco    = short_opco($company->KD_COMPANY);
                    $nilai   = empty($this->NILAI['comp']) ? array(0):$this->NILAI['comp'][$company->ID_COMPANY];
                    $vSCORE  = ARRAY();
                    $catatan = "";
                    foreach ($this->JENIS_ASPEK as $aspek) {
                      $vSCORE[$aspek->ID_JENIS_ASPEK][BOBOT] = $aspek->BOBOT;
                      $vSCORE[$aspek->ID_JENIS_ASPEK][SCORE] = 0;
                      $vSCORE[$aspek->ID_JENIS_ASPEK][ITEM] = 0;                
                      foreach ($nilai as $nl) {
                        if ($nl->NILAI_SKORING <= 2) {
                          if (strpos($catatan, $nl->CATATAN)===FALSE) {
                            # code...
                            $catatan .= (!empty($nl->CATATAN)) ? "<li>" . $nl->CATATAN . "</li>" : "";
                          }
                        }

                        if ($aspek->ID_JENIS_ASPEK==$nl->ID_JENIS_ASPEK) {
                          $vSCORE[$aspek->ID_JENIS_ASPEK][SCORE]  +=  $nl->NILAI_SKORING;
                          $vSCORE[$aspek->ID_JENIS_ASPEK][ITEM]   +=  1;
                        }
                      }
                    }
                    $total = 0;
                    foreach($vSCORE as $r){
                      @$total += ($r[SCORE] / (5*$r[ITEM]) * $r[BOBOT]);
                    }

                    $total = is_nan($total)?0:number_format($total, 2, ",", ",");
                    $color = "#";
                        
                    if($total < 70 ) $color = "#FF0000";
                    if($total >= 70 && $total < 85) $color = "#0000FF"; 
                    if($total >= 85 && $total < 90) $color = "#00CC00"; 
                    if($total >= 90) $color = "#FFC000";

                    echo "<td>";
                      echo "<div id='tb_container'>";
                        echo "<div id='tb_label' style='background:$color'>";
                          echo "<span id='lb_text_opco'>";
                            echo "$opco";
                          echo "</span>";
                          echo "<span id='lb_text_nilai'>";
                            echo "$total%";
                          echo "</span>";
                        echo "</div>";
                        echo "<div id='tx_catatan'>";
                          echo "<span>";
                           echo " <h3>Action Plan</h3>";
                            echo "<ul>";
                              echo $catatan;
                            echo "</ul>";
                          echo "</span>";
                        echo "</div>";
                      echo "</div>";
                    echo "</td>";
                  }
                ?>
              </tr>
            </tbody>
          </table>
          
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

<style type="text/css">
  th, td {
    padding: 9px;
    text-align: left;
  }

  div #tb_container {
    width: 250px;
    height:auto;
    min-height:200px;
    height:auto !important;  
    height:200px;
    text-align: center;
  }

  div #tb_label {
    border-radius: 100px;
    border: 3px solid #FFB432;
    width: 100px;
    height: 100px; 
    text-align: center;
    z-index: 1;position:relative;
  }

  #lb_text_opco {
    font-size: 30px;
    color: white;
  }

  #lb_text_nilai {
    float: left;
    font-size: 25px;
    color: white;
    width: 100%;
    margin-top: -8px;
  }

  span h3 { 
    font-weight: bold; 
    text-align: center;
  }

  div #tx_catatan {
    background: #CCDDFF;
    box-shadow: 12px 0 8px -4px rgba(31, 73, 125, 0.5), -12px 0 8px -4px rgba(31, 73, 125, 0.5);
    border-radius: 25px;
    width: 250px; 
    height:500px;
    margin-top: -15px;
    padding: 5px 5px 5px 0px;
    text-align: left;
  }

</style>

<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script>
  $(document).ready(function(){
    
  });
</script>
