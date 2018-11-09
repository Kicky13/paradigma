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
        <form role="form" method="POST" action="<?php echo site_url("kriteria_hebat/update") ?>" >
          <div class="box-body" style="background-color:#FFFAAE;">
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>ASPEK </label><br>
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
                <label>KRITERIA </label>
                <input type="hidden" name="ID_KRITERIA" value="<?php echo $this->LIST->ID_KRITERIA;?>">
                <textarea class="form-control" name="KRITERIA" placeholder="KRITERIA" required><?php echo $this->LIST->KRITERIA;?></textarea>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>BOBOT </label>
                <input required class="form-control" step="any" type="number" id="BOBOT" name="BOBOT" value="<?php echo $this->LIST->BOBOT;?>" />
              </div>
            </div>            
            
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="<?php echo site_url("kriteria_hebat");?>"> <button type="button" class="btn btn-danger">Cancel</button></a>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->

<script>
$(document).ready(function(){

});
</script>