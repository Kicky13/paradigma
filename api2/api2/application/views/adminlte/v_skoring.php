<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Kriteria Penilaian
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="dt_tables"
            class="table table-striped table-bordered table-hover dt-responsive nowrap"
            cellspacing="0"
            width="100%">
            <thead>
              <form id='myForm' role="form" method="POST" action="<?php echo site_url("skoring/save");?>">
              <tr>
                <td colspan="<?php echo (3+$this->COUNT_COMPANY);?>">
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
                <th valign="middle" width="2%">NO.</th>
                <th width="30%">KRITERIA</th>
                <th width="30%">BATASAN</th>
                <?php
                  foreach ($this->LIST_COMPANY as $company) {
                    echo "<th><center>".$company->NM_COMPANY."</center></th>";
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
                    echo "<td>";
                      if ($this->USER->ID_COMPANY==$company->ID_COMPANY || $this->USER->ID_COMPANY == NULL) {
                        echo "<input type='number' step='any' id='$company->ID_COMPANY' name='NILAI_".$list->ID_BATASAN.$company->ID_COMPANY."' class='form-control'>";
                      }else{
                        echo "<input disabled type='number' step='any' id='$company->ID_COMPANY' name='NILAIX_".$list->ID_BATASAN.$company->ID_COMPANY."' class='form-control'>";
                      }
                    echo "</td>";
                  }
                echo "</tr>";
                $no++;
              } 
              ?>
              
            </tbody>
          </table>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="<?php echo site_url("skoring");?>"> <button type="button" class="btn btn-danger">Cancel</button></a>
        </div>
        </form>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

<!-- msg confirm -->
<?php if($notice->error): ?>
  <a  id="a-notice-error"
    class="notice-error"
    style="display:none";
    href="#"
    data-title="Something Error"
    data-text="<?php echo $notice->error; ?>"
  ></a>

<?php endif; ?>

<?php if($notice->success): ?>
    <a  id="a-notice-success"
    class="notice-success"
    style="display:none";
    href="#"
    data-title="Done!"
    data-text="Do You want to go to <b>Report Score</b> page?"
  ></a>            
<?php endif; ?>
<!-- eof msg confirm -->

<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script>
  $(document).ready(function(){
    $(".notice-error").confirm({ 
      confirm: function(button) { /* Nothing */  },
      confirmButton: "OK",
      cancelButton: "Cancel",
      confirmButtonClass: "btn-danger"
    });
    
    $(".notice-success").confirm({ 
      confirm: function(button) { /* Nothing */ 
        window.location.href = '<?php echo site_url("report_score");?>';
      },
      confirmButton: "YES",
      cancelButton: "NO",
      confirmButtonClass: "btn-success"
    });
    
    <?php if($notice->error): ?>
    $("#a-notice-error").click();
    <?php endif; ?>
    
    <?php if($notice->success): ?>
    $("#a-notice-success").click();
    <?php endif; ?>      
  });

  $("#btLoad").click(function(){
    var tgl = $("#bulan").val() + "-" + $("#tahun").val();
    get_nilai(tgl);
  });

  function get_nilai (tgl) {
    $.getJSON('<?php echo site_url("skoring/get_nilai/");?>' + tgl, function (result) {
      var values = result;
      if (values != undefined && values.length > 0) {
        $(values).each(function(idx, elm) {
          var input = "NILAI_"+elm.ID_BATASAN+elm.ID_COMPANY;
          var nilai_aspek = elm.NILAI_ASPEK;
          $("input[name="+input+"]").val(nilai_aspek);
        });
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