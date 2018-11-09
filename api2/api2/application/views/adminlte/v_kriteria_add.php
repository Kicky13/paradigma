<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Master Data Kriteria
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
          <h3 class="box-title">Add Data Kriteria</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo site_url("kriteria/create") ?>" >
          <div class="box-body" style="background-color:#c5d5ea;">
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>JENIS ASPEK </label><br>
                <select class="form-control" id="ID_JENIS_ASPEK" name="ID_JENIS_ASPEK">
                  <?php 
                    foreach ($this->JENIS_ASPEK as $jenis_aspek) {
                      echo "<option value='".$jenis_aspek->ID_JENIS_ASPEK."'>".$jenis_aspek->JENIS_ASPEK."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>ASPEK </label><br>
                <select class="form-control" id="ID_ASPEK" name="ID_ASPEK"></select>
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
                <label>KRITERIA </label>
                <textarea required class="form-control" name="KRITERIA" placeholder="KRITERIA"></textarea>
              </div>
            </div>
            
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?php echo site_url("kriteria");?>"> <button type="button" class="btn btn-danger">Cancel</button></a>
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

</script>