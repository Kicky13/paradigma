<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Master Data Indikator
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
          <h3 class="box-title">Add Data Indikator</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo site_url("indikator_hebat/update") ?>" >
          <div class="box-body" style="background-color:#FFFAAE;">
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>ASPEK</label><br>
                <select class="form-control" id="ID_ASPEK" name="ID_ASPEK">
                  <?php 
                    foreach ($this->ASPEK as $aspek) {
                      $sl = ($aspek->ID_ASPEK == $this->LIST->ID_ASPEK) ? "selected":"";
                      echo "<option $sl value='".$aspek->ID_ASPEK."'>".$aspek->ASPEK."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>KRITERIA </label><br>
                <select class="form-control" id="ID_KRITERIA" name="ID_KRITERIA"></select>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>BOBOT </label>
                <div id="BOBOT"></div>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>BATASAN </label><br>
                <select class="form-control" id="ID_BATASAN" name="ID_BATASAN"></select>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>INDIKATOR </label><br>
                <input type="hidden" name="ID_INDIKATOR" value="<?php echo $this->LIST->ID_INDIKATOR;?>">
                <textarea name="INDIKATOR" rows="5" class="form-control" id="INDIKATOR" required><?php echo $this->LIST->INDIKATOR;?></textarea>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>BOTTOM RASIO </label><br>
                <input step="any" type="number" class="form-control" id="RASIO_AWAL" name="RASIO_AWAL" value="<?php echo $this->LIST->RASIO_AWAL;?>">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>TOP RASIO </label><br>
                <input step="any" type="number" type="number" class="form-control" id="RASIO_AKHIR" name="RASIO_AKHIR" value="<?php echo $this->LIST->RASIO_AKHIR;?>" >
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>SKOR </label><br>
                <input required type="number" class="form-control" id="SKOR" name="SKOR" value="<?php echo $this->LIST->SKOR;?>">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>NOTE </label><br>
                <textarea name="CATATAN" rows="5" class="form-control" id="CATATAN"><?php echo $this->LIST->CATATAN;?></textarea>
              </div>
            </div>
            
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="<?php echo site_url("indikator_hebat");?>"> <button type="button" class="btn btn-danger">Cancel</button></a>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->

<script>
$(document).ready(function(){
  $("#ID_ASPEK").change();
});


$("#ID_ASPEK").change(function(){
  var id_aspek = $(this).val(), kriteria = $("#ID_KRITERIA");

  $.getJSON('<?php echo site_url("indikator_hebat/ajax_get_kriteria/");?>' + id_aspek, function (result) {
    var values = result;
    
    if (values != undefined && values.length > 0) {
      kriteria.find('option').remove();
      $(values).each(function(index, element) {
        kriteria.append($("<option></option>").attr("value", element.ID_KRITERIA).text(element.KRITERIA));
      });

    }else{
      kriteria.find('option').remove();
      kriteria.append($("<option></option>").attr("value", '00').text("NO KRITERIA"));
    }
    $("#ID_KRITERIA").change();
  });
});

$("#ID_KRITERIA").change(function(){
  var id_kriteria = $(this).val(), batasan = $('#ID_BATASAN'), bobot = $('#BOBOT');

  $.getJSON('<?php echo site_url("indikator_hebat/ajax_get_kriteria_by_id/");?>' + id_kriteria, function (result) {
    bobot.text(result.BOBOT);
  });

  $.getJSON('<?php echo site_url("indikator_hebat/ajax_get_batasan/");?>' + id_kriteria, function (result) {
    var values = result;
    if (values != undefined && values.length > 0) {
      batasan.find('option').remove();
      $(values).each(function(index, element) {
        batasan.append($("<option></option>").attr("value", element.ID_BATASAN).text(element.BATASAN));
      });

    }else{
      batasan.find('option').remove();
      batasan.append($("<option></option>").attr("value", '00').text("NO BATASAN"));
    }

  });
});


</script>