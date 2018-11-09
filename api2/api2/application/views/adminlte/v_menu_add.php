   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Menu Configuration
        <small>Add, Edit, Remove Application's menu.</small>
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
              <h3 class="box-title">Create New Menu</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="<?php echo site_url("menu/create") ?>" >
              <div class="box-body" style="background-color:#c5d5ea;">
			   <div class="form-group">
				  <div class="col-sm-4 clearfix">
					<label>GROUP </label>
					<select class="form-control select2" name="ID_GROUPMENU" id="ID_GROUPMENU">
					  <?php  foreach($this->list_groupmenu as $groupmenu): ?>
					  <option <?php echo ($this->id_groupmenu == $groupmenu->ID_GROUPMENU) ? "selected":"" ;?> value="<?php echo $groupmenu->ID_GROUPMENU;?>" <?php echo ($this->ID_GROUPMENU == $groupmenu->ID_GROUPMENU)?"SELECTED":""; ?> ><?php echo $groupmenu->NM_GROUPMENU ?></option>
					  <?php endforeach; ?>
					</select>
				  </div>
				</div>
		
                <div class="form-group">
                  <div class="col-sm-4 clearfix">
					<label>Menu </label>
					<input type="text" class="form-control" required name="NM_MENU" placeholder="Menu Name">
				  </div>
                </div>
                
                <div class="form-group">                  
				 <div class="col-sm-4 clearfix">
					<label>URL </label>
					<input type="text" class="form-control" required name="URL_MENU" placeholder="Menu URL">
				  </div>                
				</div>
				<div class="form-group">                  
				 <div class="col-sm-2 clearfix">
					<label>ORDER </label>
					<input type="number" class="form-control" name="NO_ORDER" placeholder="ORDER" MIN="1">
				  </div>                
				</div>
				<div class="form-group"> 
                <div class="checkbox col-sm-4 clearfix">
                  <label>
                    <input type="checkbox" name="ACTIVE" value="1"> Activated
                  </label>
                </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a type="submit" class="btn btn-danger" href="<?php echo site_url("menu");?>" >Cancel</a>
              </div>
            </form>
          </div>

    </section>
    <!-- /.content -->
