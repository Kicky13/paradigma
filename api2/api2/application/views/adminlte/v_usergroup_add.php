   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data User Group
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
              <h3 class="box-title">Add Data User Group</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="<?php echo site_url("usergroup/create") ?>" >
              <div class="box-body" style="background-color:#c5d5ea;">
                <div class="form-group">
                  <div class="col-sm-4 clearfix">
					<label>USERGROUP CODE </label>
					<input type="text" class="form-control" name="KD_USERGROUP" placeholder="User Group Code" required>
				  </div>
                </div>
                
                <div class="form-group">                  
				 <div class="col-sm-4 clearfix">
					<label>USERGROUP NAME</label>
					<input type="text" class="form-control" name="NM_USERGROUP" placeholder="User Group Name" required>
				  </div>                
				</div>
				
				<div class="form-group">                  
				 <div class="col-sm-4 clearfix">
					<label>PERMISSION</label><BR />
					<input type="CHECKBOX" name="PERM_READ" value=1 > READ &nbsp; &nbsp; <input type="CHECKBOX" value=1 name="PERM_WRITE" > WRITE
				  </div>                
				</div>
				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a type="submit" class="btn btn-danger" href="<?php echo site_url("usergroup");?>" >Cancel</a>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
