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
      
      <?php if($notice->error): ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
        <?php echo $notice->error; ?>
      </div>
      <?php endif; ?>
      
      <?php if($notice->success): ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Done!</h4>
        <?php echo $notice->success; ?>
      </div>
      <?php endif; ?>
      
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="dt_tables"
            class="table table-striped table-bordered table-hover dt-responsive nowrap"
            cellspacing="0"
            width="100%">
            <thead>
              <tr>
                <td colspan="<?php echo (8+$this->COUNT_COMPANY);?>">
                  <div class="form-group col-sm-12 col-sm-2 picker_daily" >
                    <label for="ID_COMPANY">OPTION</label>
                    <SELECT class="form-control select2" name="ASPEK" id='id_jenis_aspek'>
                      <option value="ALL">ALL</option>
                      <?php
                        foreach ($this->JENIS_ASPEK as $aspek) {
                          echo "<option value='".$aspek->ID_JENIS_ASPEK."'>" . $aspek->JENIS_ASPEK . "</option>";
                        }
                      ?>
                    </SELECT>
                  </div>
                  <div class="form-group col-sm-12 col-sm-2 picker_daily" >
                    <label for="ID_COMPANY">MONTH</label>
                    <SELECT class="form-control select2" name="MONTH" id='bulan'>
                      <option value="01" <?php echo ("01"==date("m")) ? "selected":"";?>>JANUARY</option>
                      <option value="02" <?php echo ("02"==date("m")) ? "selected":"";?>>FEBRUARY</option>
                      <option value="03" <?php echo ("03"==date("m")) ? "selected":"";?>>MARCH</option>
                      <option value="04" <?php echo ("04"==date("m")) ? "selected":"";?>>APRIL</option>
                      <option value="05" <?php echo ("05"==date("m")) ? "selected":"";?>>MAY</option>
                      <option value="06" <?php echo ("06"==date("m")) ? "selected":"";?>>JUNE</option>
                      <option value="07" <?php echo ("07"==date("m")) ? "selected":"";?>>JULY</option>
                      <option value="08" <?php echo ("08"==date("m")) ? "selected":"";?>>AUGUST</option>
                      <option value="09" <?php echo ("09"==date("m")) ? "selected":"";?>>SEPTEMBER</option>
                      <option value="10" <?php echo ("10"==date("m")) ? "selected":"";?>>NOVEMBER</option>
                      <option value="11" <?php echo ("11"==date("m")) ? "selected":"";?>>OCTOBER</option>
                      <option value="12" <?php echo ("12"==date("m")) ? "selected":"";?>>DECEMBER</option>
                    </SELECT>
                  </div>
                  <div class="form-group col-sm-12 col-sm-2">
                    <label for="ID_COMPANY">YEAR</label>
                    <SELECT class="form-control select2" name="YEAR" id='tahun'>
                    <?php for($i=2017;$i<=date("Y");$i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                    </SELECT>
                  </div>
                  <div class="form-group col-sm-12 col-sm-2">
                    <label for="ID_COMPANY">&nbsp;</label>
                    <button type="button" id='btLoad' class="form-control btn btn-primary">Load</button>
                  </div>
                </td>
              </tr>
              <tr>
                <th rowspan="2" valign="middle" width="2%">NO.</th>
                <th rowspan="2" width="30%">KRITERIA</th>
                <th rowspan="2" width="30%">BATASAN</th>
                <?php
                  foreach ($this->LIST_COMPANY as $company) {
                    echo "<th colspan='2'><center>".$company->NM_COMPANY."</center></th>";
                  }
                ?>
              </tr>
              <tr>
                <?php
                  foreach ($this->LIST_COMPANY as $company) {
                    echo "<th><center>FIG</center></th>";
                    echo "<th><center>SKOR</center></th>";
                  }
                ?>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($this->LIST_INPUT as $list) {
                echo "<tr>";
                  echo "<td>$no</td>";
                  echo "<td>".$list->KRITERIA."</td>";
                  echo "<td>";
                    echo $list->BATASAN;
                    echo "<input name='ID_BATASAN[]' value='".$list->ID_BATASAN."' type='hidden'>";
                  echo "</td>";
                  foreach ($this->LIST_COMPANY as $company) {
                    $id_c = ($this->USER->ID_COMPANY == $company->ID_COMPANY) ? "" : (!empty($this->USER->ID_COMPANY)) ? "disabled":"";
                    echo "<td align='right'>";
                      echo "<span class='opco_".$company->ID_COMPANY."' id='NILAI_".$list->ID_BATASAN.$company->ID_COMPANY."'></span>";
                    echo "</td>";
                    echo "<td align='right'>";
                      echo "<span class='opcox_".$company->ID_COMPANY.$list->ID_JENIS_ASPEK."' id='NILAIX_".$list->ID_BATASAN.$company->ID_COMPANY."'></span>";
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
                    echo "<td colspan='2' align='center'>";
                      echo "<span class='total_".$company->ID_COMPANY."'>-</span>";
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

<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script>
  $(document).ready(function(){
    
  });

  $("#btLoad").click(function(){
    var tgl = $("#bulan").val() + "-" + $("#tahun").val();
    var aspek = $("#id_jenis_aspek").val();
    get_nilai(aspek,tgl);
  });

  function get_nilai (aspek,tgl) {
    var j_aspek = {
      <?php foreach ($this->JENIS_ASPEK as $aspek) { ?>
        <?php echo "$aspek->ID_JENIS_ASPEK:" . $aspek->BOBOT;?>,
      <?php } ?>    
    };
    
    $.getJSON('<?php echo site_url("report_score/get_nilai/");?>' + aspek + '/' + tgl, function (result) {
      var values = result;
      if (values != undefined && values.length > 0) {
        $(values).each(function(idx, elm) {
          var input  = "NILAI_"+elm.ID_BATASAN+elm.ID_COMPANY;
          var inputx = "NILAIX_"+elm.ID_BATASAN+elm.ID_COMPANY;
          var nilai_aspek = elm.NILAI_ASPEK;
          var nilai_skor = elm.NILAI_SKORING;

          $("#"+input).text(parseFloat(nilai_aspek));
          $("#"+inputx).text(parseFloat(nilai_skor));
          $("#"+inputx).css("color", (nilai_skor <= 2) ? "red":"blue");
          $("#"+inputx).addClass(elm.ID_JENIS_ASPEK);
          
        });

        <?php foreach ($this->LIST_INPUT as $list) {?>
          <?php foreach ($this->LIST_COMPANY as $company) {?>
            var bobot_<?php echo $company->ID_COMPANY;?> = j_aspek[$('.opcox_<?php echo $company->ID_COMPANY.$list->ID_JENIS_ASPEK;?>').attr('class').split(' ')[1]];
            var sum_skor_<?php echo $company->ID_COMPANY;?>=0;
            var count_skor_<?php echo $company->ID_COMPANY;?> = $('.opcox_<?php echo $company->ID_COMPANY.$list->ID_JENIS_ASPEK;?>').length;
            var count_x5_<?php echo $company->ID_COMPANY;?> = 5*count_skor_<?php echo $company->ID_COMPANY;?>;
            //console.log(bobot_<?php echo $company->ID_COMPANY;?>)
            $('.opcox_<?php echo $company->ID_COMPANY.$list->ID_JENIS_ASPEK;?>').each(function(){
              sum_skor_<?php echo $company->ID_COMPANY;?> += parseFloat($(this).text());
            });
            var tot_<?php echo $company->ID_COMPANY;?> =  sum_skor_<?php echo $company->ID_COMPANY;?> / count_x5_<?php echo $company->ID_COMPANY;?> * bobot_<?php echo $company->ID_COMPANY;?>;
            $('.total_<?php echo $company->ID_COMPANY;?>').text(parseFloat(tot_<?php echo $company->ID_COMPANY;?>));
          <?php }?>
        <?php }?>

      }else{
        $.confirm({
          title: "WARNING!",
          text: "DATA NOT FOUND!<br/>PLEASE SELECT OTHER PERIODE",
          confirmButton: "OK",
          cancelButton: "Cancel",
          confirmButtonClass: "btn-danger"
        })
      } 
    });

  }
</script>