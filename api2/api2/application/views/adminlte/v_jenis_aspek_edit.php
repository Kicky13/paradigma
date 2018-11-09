<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Master Data Jenis Aspek
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
          <h3 class="box-title">Add Data Jenis Aspek</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo site_url("jenis_aspek/update");?>" >
          <div class="box-body" style="background-color:#FFFAAE;">
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>JENIS ASPEK </label>
                <input type="hidden" name="ID_JENIS_ASPEK" value="<?php echo $this->LIST->ID_JENIS_ASPEK;?>">
                <input type="text" class="form-control" name="JENIS_ASPEK" value="<?php echo $this->LIST->JENIS_ASPEK;?>" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>BOBOT </label>
                <input type="number" class="form-control" name="BOBOT" value="<?php echo $this->LIST->BOBOT;?>" required>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="<?php echo site_url("jenis_aspek");?>"> <button type="button" class="btn btn-danger">Cancel</button></a>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->
