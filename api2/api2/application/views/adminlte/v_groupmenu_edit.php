   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data Group Menu
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
              <h3 class="box-title">Update Data Group Menu</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="<?php echo site_url("groupmenu/update/".$this->data_groupmenu->ID_GROUPMENU) ?>" >
              <div class="box-body" style="background-color:#FFFAAE;">
                <div class="form-group">                  
                 <div class="col-sm-4 clearfix">
                  <label>GROUPMENU NAME</label>
                  <input type="text" class="form-control" name="NM_GROUPMENU" placeholder="Group Menu Name" value="<?php echo $this->data_groupmenu->NM_GROUPMENU ?>" REQUIRED>
                  </div>                
                </div>
                <div class="form-group">                  
        				 <div class="col-sm-2 clearfix">
        					<label>ORDER</label>
        					<input type="number" class="form-control" name="NO_ORDER" placeholder="Order" value="<?php echo $this->data_groupmenu->NO_ORDER ?>" REQUIRED>
        				  </div>                
        				</div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-warning">Update</button>
                <a type="submit" class="btn btn-danger" href="<?php echo site_url("groupmenu") ?>" >Cancel</a>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
