   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Level User
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
              <h3 class="box-title">Update Data Level User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="<?php echo site_url("user_level/update/".$this->data_user_level->ID_LEVEL_USER) ?>" >
              <div class="box-body" style="background-color:#e8e8e8;">                
                <div class="form-group">                  
				 <div class="col-sm-4 clearfix">
					<label>LEVEL USER NAME</label>
					<input type="text" class="form-control" name="NM_LEVEL_USER" placeholder="Level User Name" value="<?php echo $this->data_user_level->NM_LEVEL_USER ?>" >
				  </div>                
				</div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <a type="submit" class="btn btn-danger" href="<?php echo site_url("user_level") ?>" >Cancel</a>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
