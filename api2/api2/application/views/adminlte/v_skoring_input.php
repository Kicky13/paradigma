<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  INPUT SI RAMAH
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      
      <?php if($notice->error): ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
        <?php echo $notice->error; ?>
      </div>
      <?php endif; ?>
      
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Skoring</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo site_url("skoring/save") ?>" >
          <div class="box-body">

            <div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>JENIS ASPEK </label>
                <div style="font-weight: normal; margin-bottom: 10px;"><?php echo $this->LIST_BATASAN->JENIS_ASPEK;?></div>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>ASPEK </label>
                <div style="font-weight: normal; margin-bottom: 10px;"><?php echo $this->LIST_BATASAN->ASPEK;?></div>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>KRITERIA </label>
                <div style="font-weight: normal; margin-bottom: 10px;"><?php echo $this->LIST_BATASAN->KRITERIA;?></div>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-12 clearfix">
                <label>BATASAN </label>
                <div style="font-weight: normal; margin-bottom: 10px;"><?php echo $this->LIST_BATASAN->BATASAN;?></div>
              </div>
            </div>

            <div class="form-group row clearfix">
              <div class="col-sm-12 clearfix">
                <input type="hidden" name="ID_BATASAN" value="<?php echo $this->LIST_BATASAN->ID_BATASAN;?>">
                <?php foreach ($this->LIST_COMPANY as $company) {
                  echo "<div class='col-sm-3' style='text-align:center;'>";
                    echo "<span>$company->NM_COMPANY</span>";
                    echo "<div class='row'>";
                      echo "<div class='col-sm-12'>";
                        echo "<input type='number' step='any' name='NILAI_$company->ID_COMPANY' class='form-control' autofocus>";
                      echo "</div>";
                    echo "</div>";
                  echo "</div>";
                } ?>
              </div>
            </div>

          </div>

          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?php echo site_url("skoring");?>"> <button type="button" class="btn btn-danger">Cancel</button></a>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->

<script>
$(document).ready(function(){
  $("#ID_JENIS_ASPEK").change();
});

$("#ID_JENIS_ASPEK").change(function(){
  var id_jenis_aspek = $(this).val(), aspek = $('#ID_ASPEK'), bobot = $('#BOBOT');
  $.getJSON('<?php echo site_url("kriteria/ajax_get_aspek/");?>' + id_jenis_aspek, function (result) {
    var values = result;
    
    if (values != undefined && values.length > 0) {
      aspek.find('option').remove();
      $(values).each(function(index, element) {
        aspek.append($("<option></option>").attr("value", element.ID_ASPEK).text(element.ASPEK));
      });
      $("#ID_ASPEK").change();
    }else{
      aspek.find('option').remove();
      aspek.append($("<option></option>").attr("value", '00').text("NO ASPEK"));
    }
  });

  $.getJSON('<?php echo site_url("kriteria/ajax_get_aspek_bobot/");?>' + id_jenis_aspek, function (result) {
    var res = result;
    bobot.text(res.BOBOT+" %");
  });
});

$("#ID_ASPEK").change(function(){
  var id_aspek = $(this).val(), bobot = $('#BOBOT'), kriteria = $("#ID_KRITERIA");

  $.getJSON('<?php echo site_url("indikator/ajax_get_kriteria/");?>' + id_aspek, function (result) {
    var values = result;
    
    if (values != undefined && values.length > 0) {
      kriteria.find('option').remove();
      $(values).each(function(index, element) {
        kriteria.append($("<option></option>").attr("value", element.ID_KRITERIA).text(element.KRITERIA));
      });
      $("#ID_KRITERIA").change();
    }else{
      kriteria.find('option').remove();
      kriteria.append($("<option></option>").attr("value", '00').text("NO KRITERIA"));
    }
  });

});

$("#ID_KRITERIA").change(function(){
  var id_kriteria = $(this).val(), batasan = $('#ID_BATASAN');
  $.getJSON('<?php echo site_url("indikator/ajax_get_batasan/");?>' + id_kriteria, function (result) {
    var values = result;
    
    if (values != undefined && values.length > 0) {
      batasan.find('option').remove();
      $(values).each(function(index, element) {
        batasan.append($("<option></option>").attr("value", element.ID_BATASAN).text(element.BATASAN));
      });
      $("#ID_ASPEK").change();
    }else{
      batasan.find('option').remove();
      batasan.append($("<option></option>").attr("value", '00').text("NO BATASAN"));
    }
  });
});

</script>