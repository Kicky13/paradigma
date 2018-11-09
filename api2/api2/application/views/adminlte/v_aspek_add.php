<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Master Data Aspek
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
          <h3 class="box-title">Add Data Aspek</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo site_url("aspek/create") ?>" >
          <div class="box-body" style="background-color:#c5d5ea;">
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>JENIS ASPEK </label><br>
                <select class="form-control" name="ID_JENIS_ASPEK">
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
                <label>ASPEK </label>
                <textarea class="form-control" name="ASPEK" placeholder="Aspek" required></textarea>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?php echo site_url("aspek");?>"> <button type="button" class="btn btn-danger">Cancel</button></a>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->