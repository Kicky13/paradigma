   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Group Area
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
              <h3 class="box-title">Update Data Group Area</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="<?php echo site_url("grouparea/update/".$this->data_grouparea->ID_GROUPAREA) ?>" >
              <div class="box-body" style="background-color:#FFFAAE;">
                <div class="form-group">
                  <div class="col-sm-4 clearfix">
					<label>AREAGROUP CODE </label>
					<input type="text" class="form-control" name="KD_GROUPAREA" placeholder="Grouparea Code" value="<?php echo $this->data_grouparea->KD_GROUPAREA ?>"  REQUIRED >
				  </div>
                </div>
                
                <div class="form-group">                  
				 <div class="col-sm-4 clearfix">
					<label>AREAGROUP NAME</label>
					<input type="text" class="form-control" name="NM_GROUPAREA" placeholder="Grouparea Name" value="<?php echo $this->data_grouparea->NM_GROUPAREA ?>"  REQUIRED >
				  </div>                
				</div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <a type="submit" class="btn btn-danger" href="<?php echo site_url("grouparea") ?>" >Cancel</a>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
